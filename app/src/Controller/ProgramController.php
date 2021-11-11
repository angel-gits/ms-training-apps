<?php

namespace App\Controller;

use DateTime;
use App\Entity\Goal;
use App\Entity\User;
use App\Entity\Program;
use App\Entity\Exercise;
use App\Entity\GoalUser;
use App\Entity\Training;
use App\Entity\ProgramPlan;
use App\Service\NormalizeService;
use Symfony\Component\Mercure\Update;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/programs")
 */
class ProgramController extends AbstractController
{
    private $em;
    private $validator;
    private $hub;

    public function __construct(EntityManagerInterface $em, ValidatorInterface $validator, HubInterface $hub)
    {
        $this->em = $em;
        $this->validator = $validator;
        $this->hub = $hub;
    }
    
    /**
     * @Route("", name="programs", methods={"GET"})
     */
    public function getAllPrograms(Request $request): JsonResponse
    {
        $userId = $this->getUser()->getId();

        $type = $request->get('type') ?? 'my';
        
        switch($type) {
            case 'my':
                $list = $this->em->getRepository(Program::class)->findBy(['ownerId' => $userId]);
                break;
            case 'hosted':
                $list = array();
                if($this->isGranted("ROLE_SUPER_ADMIN"))
                    foreach($this->em->getRepository(Program::class)->findAll() as $program)
                        if(in_array($userId, $program->getTrainersId()))
                            $list[] = $program;
                break;
            default: 
                return new JsonResponse([
                    'message' => "No such type of program found",
                    'code' => 404
                ], 404);
        }

        $list = array_unique($list, SORT_REGULAR);

        return $this->json([
            'message' => "List of all programs according to type",
            'data' => (new NormalizeService())->normalizeByGroup($list, ['groups' => ['main']]),
            'code' => 200
        ]);
    }

    /**
     * @Route("/program-{id}", name="program", methods={"GET"})
     */
    public function getProgram(int $id): JsonResponse
    {
        $userId = $this->getUser()->getId();
        $program = $this->em->getRepository(Program::class)->findOneBy(['id' => $id]) ?? null;
        if(is_null($program) || (!in_array($userId, $program->getTrainersId()) && $userId != $program->getOwnerId()))
            return new JsonResponse([
                'message' => "Such plan not found",
                'code' => 404
            ], 404);

        return $this->json([
            'message' => "Requested program",
            'data' => (new NormalizeService())->normalizeByGroup($program, ['groups' => ['main', 'additional_program']]),
            'code' => 200
        ]);
    }

    /**
     * @Route("/plans", name="program_plans", methods={"GET"})
     */
    public function getProgramPlans(Request $request): JsonResponse
    {
        $type = $request->get('type') ?? 'my';
        $userId = $this->getUser()->getId();
        $list = $this->em->getRepository(ProgramPlan::class)->findAll();

        switch($type) {
            case 'created': 
                foreach($list as $programPlan) {
                    if(is_bool($programPlan->getAuthorsId()) || !in_array($userId, $programPlan->getAuthorsId())) 
                        unset($list[array_search($programPlan, $list)]);
                }
                break;
            case 'my':
                foreach($list as $programPlan) {
                    $programs = $this->em->getRepository(Program::class)->findBy(['programPlan' => $programPlan, 'ownerId' => $userId]);
                    if(is_bool($programPlan->getOwnersId()) || !(in_array($userId, $programPlan->getOwnersId()) && empty($programs))) 
                        unset($list[array_search($programPlan, $list)]);
                }
                break;
            case 'my-all':
                foreach($list as $programPlan) {
                    if(is_bool($programPlan->getOwnersId()) || !in_array($userId, $programPlan->getOwnersId())) 
                        unset($list[array_search($programPlan, $list)]);
                }
                break;
            default:
                return new JsonResponse([
                    'message' => "No such type of program plans found",
                    'code' => 404
                ], 404);
            }

        return $this->json([
            'message' => "List of " . $type . " program plans",
            'data' => (new NormalizeService())->normalizeByGroup($list, ['groups' => ['main']]),
            'code' => 200
        ]);
    }

    /**
     * @Route("", methods={"POST"})
     */
    public function postProgram(Request $request) : JsonResponse {
        $userId = $this->getUser()->getId();
        $data = json_decode($request->getContent(), true);

        $program = new Program();

        $ownerId = $data['owner'] ?? null;
        $trainersId = $data['trainers'] ?? array();
        if(is_null($ownerId)) {
            $program->setOwnerId($userId);
            $ownerId = $userId;
        }
        else {
            $user = $this->em->getRepository(User::class)->findOneBy(['id' => $ownerId]);
            if(in_array($userId, $user->getTrainersId())) {
                $program->setOwnerId($ownerId);
                $trainersId[] = $userId;
            }
            else return new JsonResponse(['message' => "Owner must be provided by one of the trainers", 'code' => 400], 400);
        }
        $program->setTrainersId($trainersId);

        if(is_null($programPlan = $this->em->getRepository(ProgramPlan::class)->findOneBy(['id' => $data['plan'] ?? null])))
            return new JsonResponse([
                'message' => "Such plan not found",
                'code' => 404
            ], 404);

        if(!in_array($ownerId, $programPlan->getOwnersId()) && !in_array($ownerId, $programPlan->getAuthorsId()))
            return new JsonResponse(['message' => "You don't have permission", 'code' => 403], 403);

        $program->setProgramPlan($programPlan);

        $goalUser = new GoalUser($programPlan->getGoal());
        $goalUser->setUserId($ownerId);
        if(!is_null($goalInfo = $data['goal'] ?? null)) {
                
            $goalUser->setCriteria((array) $goalInfo['criteria'] ?? array());
            $goalUser->setCValues((array) $goalInfo['values'] ?? array());
            $goalUser->setUnits((array) $goalInfo['units'] ?? array());
        }
        $this->em->persist($goalUser);
        $this->em->flush();

        $program->setGoal($goalUser);

        $program->setStartDateTime($startDate = $data['startDateTime'] ?? null);
        $program->setFinishDateTime($finishDate = $data['finishDateTime'] ?? null);

        $errors = $this->validator->validate($program);
        if(count($errors) > 0) {
            return new JsonResponse(['message' => (string) $errors, 'code' => 400], 400);
        } 
        $program->setStartDateTime(new DateTime($startDate));
        $program->setFinishDateTime(new DateTime($finishDate));
        
        $this->em->persist($program);
        $this->em->flush();

        foreach($programPlan->getPlannedTrainings() as $trainingPlan) {
            $training = new Training($trainingPlan, $program);
            if(!is_null($goal = $trainingPlan->getGoal())) $training->setGoal($newGoal = new GoalUser($goal));
            $newGoal->setUserId($program->getOwnerId());
            $this->em->persist($newGoal);
            $this->em->flush();
            $this->em->persist($training);
            $this->em->flush();
            foreach($trainingPlan->getPlannedExercises() as $plannedExercise) {
                $exercise = new Exercise($plannedExercise, $training);
                if(!is_null($goal = $plannedExercise->getGoal())) $exercise->setGoal($newGoal = new GoalUser($goal));
                $newGoal->setUserId($program->getOwnerId());
                $this->em->persist($newGoal);
                $this->em->flush();
                $this->em->persist($exercise);
                $this->em->flush();
            }
        }

        $update = new Update(
            '/api/trgp-control/' . $program->getOwnerId() . '/programs', 
            json_encode(['message' => 'New program has been added to my list']),
        );
        $this->hub->publish($update);
        foreach($program->getTrainersId() as $trainerId) {
            $update = new Update(
                '/api/trgp-control/' . $trainerId . '/programs', 
                json_encode(['message' => 'New hosted program has been added']),
            );
            $this->hub->publish($update);
        }

        return $this->json([
            'message' => "Created program",
            'data' => (new NormalizeService())->normalizeByGroup($program, ['groups' => ['main', 'additional_program']]),
            'code' => 200
        ]);
    }

    /**
     * @Route("/{id}", methods={"PATCH"})
     */
    public function updateProgram(int $id, Request $request) : JsonResponse {
        $userId = $this->getUser()->getId();
        $data = json_decode($request->getContent(), true);

        $program = $this->em->getRepository(Program::class)->findOneBy(['id' => $id]);
        if(is_null($program) || (!in_array($userId, $program->getTrainersId()) && $userId != $program->getOwnerId())) 
            return new JsonResponse([
            'message' => "You can't update this program",
            'code' => 404
        ], 404);

        if(!is_null($goalInfo = $data['goal'] ?? null)) {
            $goalUser = $program->getGoal();   
            if(!is_null($criteria = $goalInfo['criteria'] ?? null) && 
                    !is_null($cValues = $goalInfo['values'] ?? null) && 
                    !is_null($units = $goalInfo['units'] ?? null)) {
                if(!is_null($type = $goalInfo['type'] ?? null) && $type == 'delete') {
                    $goalUser->setCriteria(array_diff($goalUser->getCriteria(), (array) $criteria));
                    $goalUser->setCValues(array_diff($goalUser->getCValues(), (array) $cValues));
                    $goalUser->setUnits(array_diff($goalUser->getUnits(), (array) $units));
                }
                else {
                    $goalUser->setCriteria(array_merge($goalUser->getCriteria(), (array) $criteria), SORT_REGULAR);
                    $goalUser->setCValues(array_merge($goalUser->getCValues(), (array) $cValues), SORT_REGULAR);
                    $goalUser->setUnits(array_merge($goalUser->getUnits(), (array) $units), SORT_REGULAR);
                }
            }
            $this->em->flush();
            $program->setGoal($goalUser);
        }

        if(!is_null($trainers = $data['trainers'] ?? null)) {
            if(!is_null($type = $trainers['type'] ?? null) && $type == 'delete')
                $program->setTrainersId(array_diff($program->getTrainersId(), (array) $trainers['id']));
            else $program->setTrainersId(array_unique(array_merge($program->getTrainersId(), (array) $trainers['id']), SORT_REGULAR));
        }

        $startDateTime = $data['startDateTime'] ?? null;
        $program->setStartDateTime($startDateTime ?? $program->getStartDateTime()->format(\DateTime::ISO8601));
        $finishDateTime = $data['finishDateTime'] ?? null;
        $program->setFinishDateTime($finishDateTime ?? $program->getFinishDateTime()->format(\DateTime::ISO8601));

        $errors = $this->validator->validate($program);
        if(count($errors) > 0) {
            return new JsonResponse(['message' => (string) $errors, 'code' => 400], 400);
        } 
        $program->setStartDateTime(new DateTime($startDateTime ?? $program->getStartDateTime()));
        $program->setFinishDateTime(new DateTime($finishDateTime ?? $program->getFinishDateTime()));

        $this->em->flush();

        $update = new Update(
            '/api/trgp-control/programs/' . $id, 
            json_encode(['message' => 'Program has been updated']),
        );
        $this->hub->publish($update);

        return $this->json([
            'message' => "Updated program",
            'data' => (new NormalizeService())->normalizeByGroup($program, ['groups' => ['main', 'additional_program']]),
            'code' => 200
        ]);
    }

    /**
     * @Route("/{id}", methods={"DELETE"})
     */
    public function deleteProgram(int $id) : JsonResponse {
        $userId = $this->getUser()->getId();
        $program = $this->em->getRepository(Program::class)->findOneBy(['id' => $id]);
        if(is_null($program) || (!in_array($userId, $program->getTrainersId()) && $userId != $program->getOwnerId())) 
            return new JsonResponse([
                'message' => "You can't delete this program",
                'code' => 404
            ], 404);

        $this->em->remove($program);
        $this->em->flush();
        
        $list = array();
        foreach($this->em->getRepository(Program::class)->findAll() as $program)
            if($userId == $program->getOwnerId() || in_array($userId, $program->getTrainersId())) $list[] = $program;

        $update = new Update(
            '/api/trgp-control/programs/' . $id, 
            json_encode(['message' => 'Program has been deleted']),
        );
        $this->hub->publish($update);

        return $this->json([
            'message' => "List of all my and managed programs",
            'data' => (new NormalizeService())->normalizeByGroup($list, ['groups' => ['main']]),
            'code' => 200
        ]);
    }
}
