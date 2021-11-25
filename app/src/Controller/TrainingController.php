<?php

namespace App\Controller;

use DateTime;
use App\Entity\Goal;
use App\Entity\Program;
use App\Entity\GoalUser;
use App\Entity\Training;
use App\Entity\TrainingPlan;
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
 * @Route("/trainings")
 */
class TrainingController extends AbstractController
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
     * @Route("", methods={"GET"})
     */
    public function getTrainings(Request $request): JsonResponse {
        $programId = $request->get('program') ?? null;
        $program = $this->em->getRepository(Program::class)->findOneBy(['id' => $programId]);
        $userId = $this->getUser()->getId();
        if(is_null($program) || (!in_array($userId, $program->getTrainersId()) && $userId != $program->getOwnerId())) 
            return new JsonResponse([
                'message' => "Program not found",
                'code' => 404
            ], 404);

        $list = $this->em->getRepository(Training::class)->findBy(['program' => $program]);

        return $this->json([
            'message' => "Programs trainings",
            'data' => (new NormalizeService())->normalizeByGroup($list, ['groups' => ['main', 'additional_training']]),
            'code' => 200
        ]);
    }

    /**
     * @Route("/{id}", methods={"GET"})
     */
    public function getTraining(int $id): JsonResponse {
        $training = $this->em->getRepository(Training::class)->findOneBy(['id' => $id]);
        if(is_null($training)) return new JsonResponse([
                'message' => "Program not found",
                'code' => 404
            ], 404);

        $program = $training->getProgram();
        $userId = $this->getUser()->getId();
        if(is_null($program) || (!in_array($userId, $program->getTrainersId()) && $userId != $program->getOwnerId())) 
            return new JsonResponse([
                'message' => "Program not found",
                'code' => 404
            ], 404);

        return $this->json([
            'message' => "Requested training",
            'data' => (new NormalizeService())->normalizeByGroup($training, ['groups' => ['main', 'additional_training']]),
            'code' => 200
        ]);
    }

    /**
     * @Route("", methods={"POST"})
     */
    public function postTraining(Request $request): JsonResponse
    {
        $userId = $this->getUser()->getId();
        $id = $request->get('program');
        $program = $this->em->getRepository(Program::class)->findOneBy(['id' => $id]);
        if(is_null($program) || (!in_array($userId, $program->getTrainersId()) && $userId != $program->getOwnerId())) 
            return new JsonResponse([
                'message' => "You can't add this training",
                'code' => 404
            ], 404);
        $data = json_decode($request->getContent(), true);

        $planId = $data['plan'] ?? null;
        $trainingPlan = $this->em->getRepository(TrainingPlan::class)->findOneBy(['id' => $planId]);
        if(!is_null($trainingPlan)) { 
            $goalUser = new GoalUser($trainingPlan->getGoal());
            $goalUser->setUserId($program->getOwnerId());
        }
        else {
            $goalUser = null;
            $trainingPlan = new TrainingPlan();
            if(!is_null($name = $data['name'] ?? null)) $trainingPlan->setName($name);
        }

        $training = new Training($trainingPlan, $program);

        $goalInfo = $data['goal'] ?? null;
        if(is_null($goalUser)) {
            if(!is_null($goalInfo) && !is_null($name = $goalInfo['name'] ?? null)) {
                if(is_null($goal = $this->em->getRepository(Goal::class)->findOneBy(['name' => $name]))) {
                    $goal = new Goal($name ?? null);
                    $errors = $this->validator->validate($goal);
                    if(count($errors) > 0) {
                          return new JsonResponse(['message' => (string) $errors, 'code' => 400], 400);
                    } 
                    $this->em->persist($goal);
                }
                $goalUser = new GoalUser($goal);
                $goalUser->setUserId($program->getOwnerId());
                $trainingPlan->setGoal($goal);   
            }  
            $errors = $this->validator->validate($trainingPlan);
            if(count($errors) > 0) {
                return new JsonResponse(['message' => (string) $errors, 'code' => 400], 400);
            } 
            $this->em->persist($trainingPlan);
        }

        if(!is_null($goalUser) && !is_null($goalInfo)) {
            $goalUser->setCriteria((array) $goalInfo['criteria'] ?? array());
            $goalUser->setCValues((array) $goalInfo['values'] ?? array());
            $goalUser->setUnits((array) $goalInfo['units'] ?? array());
        }

        if(!is_null($goalUser)) {
            $this->em->persist($goalUser); 
        }

        $training->setGoal($goalUser);

        $training->setStartDateTime($startDateTime = $data['startDateTime'] ?? null);
        $training->setFinishDateTime($finishDateTime = $data['finishDateTime'] ?? null);

        $errors = $this->validator->validate($training);
        if(count($errors) > 0) {
            return new JsonResponse(['message' => (string) $errors, 'code' => 400], 400);
        } 
        $training->setStartDateTime(new DateTime($startDateTime));
        $training->setFinishDateTime(new DateTime($finishDateTime));

        $this->em->persist($training);
        $this->em->flush();


        $update = new Update(
            '/api/trgp-control/' . $program->getOwnerId() . '/trainings', 
            json_encode(['message' => 'Training has been added to my program ' . $id]),
        );
        $this->hub->publish($update);
        foreach($program->getTrainersId() as $trainerId) {
            $update = new Update(
                '/api/trgp-control/' . $trainerId . '/trainings', 
                json_encode(['message' => 'Training has been added to hosted program ' . $id]),
            );
            $this->hub->publish($update);
        }

        return $this->json([
            'message' => "Updated program",
            'data' => (new NormalizeService())->normalizeByGroup($program, ['groups' => ['main', 'additional_program']]),
            'code' => 200
        ]);
    }

    /**
     * @Route("/{id}", methods={"PATCH"})
     */
    public function updateTraining(int $id, Request $request): JsonResponse
    {
        $userId = $this->getUser()->getId();
        $training = $this->em->getRepository(Training::class)->findOneBy(['id' => $id]);
        $program = $training->GetProgram();

        if(is_null($training) || (!in_array($userId, $program->getTrainersId()) && $userId != $program->getOwnerId())) 
            return new JsonResponse([
            'message' => "Training not found",
            'code' => 404
        ], 404);

        $data = json_decode($request->getContent(), true);

        if(!is_null($goalInfo = $data['goal'] ?? null) && !is_null($goalUser = $training->getGoal())) {
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

                $training->setGoal($goalUser);
            }
        }

        $startDateTime = $data['startDateTime'] ?? null;
        $finishDateTime = $data['finishDateTime'] ?? null;
        if (!is_null($status = $data['status'] ?? null)) {
            switch ($status) {
                case Training::IN_PROGRESS:
                    $startDateTime = (new DateTime('now'))->format(\DateTime::ISO8601);
                    $training->setStatus(Training::IN_PROGRESS);
                    break;
                case Training::FINISHED:
                    $currentTime = new DateTime('now');
                    if ($currentTime->getTimestamp() - $program->getFinishDateTime()->getTimestamp() > 0) {
                        $program->setFinishDateTime($currentTime);
                    }
                    $finishDateTime = $currentTime->format(\DateTime::ISO8601);
                    $training->setStatus(Training::FINISHED);
                    break;
                case Training::PLANNED:
                    $training->setStatus(Training::PLANNED);
                    break;
            }
        }

        $training->setStartDateTime($startDateTime ?? $training->getStartDateTime()->format(\DateTime::ISO8601));
        $training->setFinishDateTime($finishDateTime ?? $training->getFinishDateTime()->format(\DateTime::ISO8601));

        $errors = $this->validator->validate($training);
        if(count($errors) > 0) {
            return new JsonResponse(['message' => (string) $errors, 'code' => 400], 400);
        } 

        $training->setStartDateTime(new DateTime($training->getStartDateTime()));
        $training->setFinishDateTime(new DateTime($training->getFinishDateTime()));
        if ($training->getStartDateTime()->getTimestamp() - $program->getStartDateTime()->getTimeStamp() < 0) 
                $program->setStartDateTime($training->getStartDateTime());
                
        $this->em->flush();

        $update = new Update(
            '/api/trgp-control/trainings/' . $id, 
            json_encode(['message' => 'Training has been updated']),
        );
        $this->hub->publish($update);

        return $this->json([
            'message' => "Updated training",
            'data' => (new NormalizeService())->normalizeByGroup($training, ['groups' => ['main', 'additional_training', 'additional']]),
            'code' => 200
        ]);
    }

    /**
     * @Route("/{id}", methods={"DELETE"})
     */
    public function deleteTraining(int $id): JsonResponse
    {
        $userId = $this->getUser()->getId();
        $training = $this->em->getRepository(Training::class)->findOneBy(['id' => $id]);

        if(is_null($training) || (!in_array($userId, $training->getProgram()->getTrainersId()) && $userId != $training->getProgram()->getOwnerId())) 
            return new JsonResponse([
            'message' => "Training not found",
            'code' => 404
        ], 404);

        $this->em->remove($training);
        $this->em->flush();

        $update = new Update(
            '/api/trgp-control/programs/' . $id, 
            json_encode(['message' => 'Training has been deleted']),
        );
        $this->hub->publish($update);

        return $this->json([
            'message' => "Updated program",
            'data' => (new NormalizeService())->normalizeByGroup($training->getProgram(), ['groups' => ['main', 'additional_program']]),
            'code' => 200
        ]);
    }
}
