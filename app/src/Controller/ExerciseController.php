<?php

namespace App\Controller;

use DateTime;
use App\Entity\Goal;
use App\Entity\Exercise;
use App\Entity\GoalUser;
use App\Entity\Training;
use App\Entity\Statistics;
use App\Entity\ExercisePlan;
use App\Service\NormalizeService;
use App\Entity\ExerciseClassifier;
use Symfony\Component\Mercure\Update;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/exercises")
 */
class ExerciseController extends AbstractController
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
     * @Route("", methods={"POST"})
     */
    public function postExercise(Request $request): JsonResponse
    {
        $trainingId = $request->get('training') ?? null;
        $userId = $this->getUser()->getId();
        $training = $this->em->getRepository(Training::class)->findOneBy(['id' => $trainingId]);

        if(is_null($training) || (!in_array($userId, $training->getProgram()->getTrainersId()) && $userId != $training->getProgram()->getOwnerId()))
            return new JsonResponse([
                'message' => "You can't add this training",
                'code' => 404
            ], 404);

        $program = $training->getProgram();
        $data = json_decode($request->getContent(), true);

        $planId = $data['plan'] ?? null;
        $exercisePlan = $this->em->getRepository(ExercisePlan::class)->findOneBy(['id' => $planId]);

        $goalInfo = $data['goal'] ?? null;

        if(!is_null($exercisePlan)) { 
            if(!is_null($planGoal = $exercisePlan->getGoal())) {
                $goalUser = new GoalUser($planGoal);
                $goalUser->setUserId($program->getOwnerId());
            }
        }
        else {
            $goalUser = null;
            $exercisePlan = new ExercisePlan();
            if(!is_null($eName = $data['name'] ?? null)) {
                if(is_null($exName = $this->em->getRepository(ExerciseClassifier::class)->findOneBy(['name' => $eName]))) {
                    $name = $eName;
                    $exName = new ExerciseClassifier();
                    $exName->setName($name);
    
                    $errors = $this->validator->validate($exName);
                    if (count($errors) > 0) {
                        return new JsonResponse(['message' => (string) $errors, 'code' => 400], 400);
                    }

                    $this->em->persist($exName);
                    $this->em->flush();
                }
                $exercisePlan->setName($exName);
            }
            $exercisePlan->setSetsNum($data['setsNum'] ?? null);

            if(!is_null($goalInfo) && !is_null($name = $goalInfo['name'] ?? null)) {
                if(is_null($goal = $this->em->getRepository(Goal::class)->findOneBy(['name' => $name]))) {
                    $goal = new Goal($name);
                    $errors = $this->validator->validate($goal);
                    if(count($errors) > 0) {
                        return new JsonResponse(['message' => (string) $errors, 'code' => 400], 400);
                    } 
                    $this->em->persist($goal);
                    $this->em->flush();
                }
                $goalUser = new GoalUser($goal);
                $goalUser->setUserId($program->getOwnerId());
                $exercisePlan->setGoal($goal);   
            }  
            $errors = $this->validator->validate($exercisePlan);
            if(count($errors) > 0) {
                return new JsonResponse(['message' => (string) $errors, 'code' => 400], 400);
            } 
            $this->em->persist($exercisePlan);
            $this->em->flush();
        }

        if(!is_null($goalUser)) {
            if(!is_null($goalInfo)) {
                $goalUser->setCriteria((array) $goalInfo['criteria'] ?? array());
                $goalUser->setCValues((array) $goalInfo['values'] ?? array());
                $goalUser->setUnits((array) $goalInfo['units'] ?? array());
            }

            $this->em->persist($goalUser);
            $this->em->flush();
        }

        $exercise = new Exercise($exercisePlan, $training);
        $exercise->setGoal($goalUser);
        $exercise->setRepetitionNum($data['repetitionNum'] ?? null);
        $exercise->setTimeLimit($data['timeLimit'] ?? null);
        $exercise->setWeight($data['weight'] ?? null);

        $errors = $this->validator->validate($exercise);
        if(count($errors) > 0) {
            return new JsonResponse(['message' => (string) $errors, 'code' => 400], 400);
        } 

        $this->em->persist($exercise);
        $this->em->flush();

        $update = new Update(
            '/api/trgp-control/trainings/' . $trainingId, 
            json_encode(['message' => 'New exercise has been added to training']),
        );
        $this->hub->publish($update);

        return $this->json([
            'message' => "Updated training",
            'data' => (new NormalizeService())->normalizeByGroup($training, ['groups' => ['main', 'additional_training']]),
            'code' => 200
        ]);
    }

    /**
     * @Route("/{id}", name="exercise", methods={"PATCH"})
     */
    public function patchExercise(Request $request, int $id): JsonResponse
    {
        $exercise = $this->em->getRepository(Exercise::class)->findOneBy(['id' => $id]) ?? null;
        if(is_null($exercise))
            return new JsonResponse([
                'message' => "Exercise not found",
                'code' => 404
            ], 404);
        $userId = $this->getUser()->getId();
        $training = $exercise->getTraining();
        if(is_null($training) || (!in_array($userId, $training->getProgram()->getTrainersId()) && $userId != $training->getProgram()->getOwnerId()))
            return new JsonResponse([
                'message' => "You can't update this exercise",
                'code' => 404
            ], 404);
        $data = json_decode($request->getContent(), true);
        $statistics = null;

        if(!is_null($goalInfo = $data['goal'] ?? null) && !is_null($goalUser = $exercise->getGoal())) {
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

                $exercise->setGoal($goalUser);
            }
        }

        if(!is_null($timeLimit = $data['timeLimit'] ?? null)) $exercise->setTimeLimit($timeLimit);
        if(!is_null($repetitionNum = $data['repetitionNum'] ?? null)) $exercise->setRepetitionNum($repetitionNum);
        if(!is_null($weight = $data['weight'] ?? null)) $exercise->setWeight($weight);

        $errors = $this->validator->validate($exercise);
        if(count($errors) > 0) {
            return new JsonResponse(['message' => (string) $errors, 'code' => 400], 400);
        } 

        if(!is_null($status = $data['status'] ?? null))
            switch($status) {
                case Exercise::PLANNED:
                    if(!$exercise->getStatus() == Exercise::FINISHED)
                        $exercise->setStatus(Exercise::PLANNED);
                    break;
                case Exercise::IN_PROGESS:
                    if($exercise->getStatus() == Exercise::PLANNED)
                        $exercise->setStatus(Exercise::IN_PROGESS);
                    break;
                case Exercise::FINISHED:
                    $exercise->setStatus(Exercise::FINISHED);
                    $statistics = new Statistics(
                        $exercise->getExercisePlan()->getName()->getName(),
                        new DateTime('now'), $exercise->getWeight(),
                        $exercise->getTimeLimit(), $exercise->getRepetitionNum(),
                        $training->getProgram()->getOwnerId()
                    );
                    $this->em->persist($statistics);
            }
        
        $this->em->flush();

        if(!is_null($statistics)) {
            $update = new Update(
                '/api/trgp-control/' . $statistics->getUserId() . '/statistics', 
                json_encode(['message' => 'Statistics list is updated']),
            );
            $this->hub->publish($update);
        }

        $update = new Update(
            '/api/trgp-control/trainings/' . $training->getId(), 
            json_encode(['message' => 'Training has been updated']),
        );
        $this->hub->publish($update);

        return $this->json([
            'message' => "Updated training",
            'data' => (new NormalizeService())->normalizeByGroup($training, ['groups' => ['main', 'additional_training']]),
            'code' => 200
        ]);
    }
    
    /**
     * @Route("/{id}", methods = {"DELETE"})
     */
    public function deleteExercise(int $id) {
        $exercise = $this->em->getRepository(Exercise::class)->findOneBy(['id' => $id]) ?? null;
        if(is_null($exercise))
            return new JsonResponse([
                'message' => "Exercise not found",
                'code' => 404
            ], 404);
        $userId = $this->getUser()->getId();
        $training = $exercise->getTraining();
        if(is_null($training) || (!in_array($userId, $training->getProgram()->getTrainersId()) && $userId != $training->getProgram()->getOwnerId()))
            return new JsonResponse([
                'message' => "You can't add this training",
                'code' => 404
            ], 404);

        $this->em->remove($exercise);
        $this->em->flush();

        $update = new Update(
            '/api/trgp-control/trainings/' . $training->getId(), 
            json_encode(['message' => 'One of exercises has been deleted from training']),
        );
        $this->hub->publish($update);

        return $this->json([
            'message' => "Updated training",
            'data' => (new NormalizeService())->normalizeByGroup($training, ['groups' => ['main', 'additional_training']]),
            'code' => 200
        ]);
    }
}
