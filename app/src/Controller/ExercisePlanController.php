<?php

namespace App\Controller;

use App\Entity\Goal;
use App\Entity\Exercise;
use App\Entity\ExercisePlan;
use App\Entity\TrainingPlan;
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
 * @Route("/exercise-plans")
 */
class ExercisePlanController extends AbstractController
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
    public function addExerciseToTrainingPlan(Request $request): JsonResponse
    {
        $trainingPlan = $this->em->getRepository(TrainingPlan::class)->findOneBy(['id' => $request->get('trainingPlan')]);
        $userId = $this->getUser()->getId();
        if(is_null($trainingPlan) || !in_array($userId, $trainingPlan->getProgramPlan()->getAuthorsId())) 
            return new JsonResponse(['message' => "Such training plan not found", 'code' => 404], 404);
        
        $data = json_decode($request->getContent(), true);

        $setsNum = $data['setsNumber'] ?? null;
        $exercisePlan = new ExercisePlan();
        $exercisePlan->setSetsNum($setsNum);

        if(!is_null($data['name'] ?? null)) {
            if(is_null($exName = $this->em->getRepository(ExerciseClassifier::class)->findOneBy(['name' => $data['name']]))) {
                $name = $data['name'] ?? null;
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
        if (!is_null($goalInfo = $data['goal'] ?? null)) {
            if (is_null($goal = $this->em->getRepository(Goal::class)->findOneBy(['name' => $goalInfo['name'] ?? null]))) {
                $goal = new Goal($goalInfo['name'] ?? null);
                $errors = $this->validator->validate($goal);
                if (count($errors) > 0) {
                    return new JsonResponse(['message' => (string) $errors, 'code' => 400], 400);
                }
                $this->em->persist($goal);
                $this->em->flush();
            }
            $exercisePlan->setGoal($goal);
        }
        $exercisePlan->setTrainingPlan($trainingPlan);

        $errors = $this->validator->validate($exercisePlan);
        if (count($errors) > 0) {
            return new JsonResponse(['message' => (string) $errors, 'code' => 400], 400);
        }
        $this->em->persist($exercisePlan);
        $this->em->flush();

        $update = new Update(
            '/api/trgp-control/training-plans/' . $trainingPlan->getId(), 
            json_encode(['message' => 'New exercise plan has been added to training plan']),
        );
        $this->hub->publish($update);

        return $this->json([
            'message' => "Changed training plan",
            'data' => (new NormalizeService())->normalizeByGroup($trainingPlan, ['groups' => ['main', 'additional_tp', 'main_g']]),
            'code' => 200
        ]);
    }

    /**
     * @Route("/{id}", methods={"PATCH"})
     */
    public function patchExercisePlan(Request $request, int $id): JsonResponse
    {
        $exercisePlan = $this->em->getRepository(ExercisePlan::class)->findOneBy(['id' => $id]);
        $trainingPlan = $exercisePlan->getTrainingPlan() ?? null;
        $plan = is_null($trainingPlan) ? null : $trainingPlan->getProgramPlan();
        $userId = $this->getUser()->getId();
        if(!is_null($exercisePlan)) {
            if(is_null($plan)) {
                $wrong = 0;
                $list = array();
                foreach($exercises = $this->em->getRepository(Exercise::class)->findBy(['exercisePlan' => $exercisePlan]) as $exercise) {
                    $training = $exercise->getTraining();
                    if(!in_array($userId, $training->getProgram()->getTrainersId()) && $userId != $training->getProgram()->getOwnerId())
                        $wrong++;
                        $list[] = $training;
                }
                if(sizeof($exercises) == $wrong) return new JsonResponse(['message' => "You're not allowed to edit plan", 'code' => 403], 403);
            }
            elseif (!in_array($userId, $plan->getAuthorsId())) 
                return new JsonResponse(['message' => "You're not allowed to edit plan", 'code' => 403], 403);
        }
        else return new JsonResponse(['message' => "Such exercise plan not found", 'code' => 404], 404);
        
        $data = json_decode($request->getContent(), true);

        if(!is_null($setsNum = $data['setsNumber'] ?? null)) $exercisePlan->setSetsNum($setsNum);
        if(!is_null($data['name'] ?? null)) {
            if(is_null($name = $this->em->getRepository(ExerciseClassifier::class)->findOneBy(['name' => $data['name']]))) {
                $name = new ExerciseClassifier($data['name'] ?? null);
                $errors = $this->validator->validate($name);
                    if (count($errors) > 0) {
                        return new JsonResponse(['message' => (string) $errors, 'code' => 400], 400);
                    }
                    $this->em->persist($name);
                    $this->em->flush();
            }
            $exercisePlan->setName($name);
        }
        if (!is_null($goalInfo = $data['goal'] ?? null)) {
            if (is_null($goal = $this->em->getRepository(Goal::class)->findOneBy(['name' => $goalInfo['name'] ?? null]))) {
                $goal = new Goal($goalInfo['name'] ?? null);
                $errors = $this->validator->validate($goal);
                if (count($errors) > 0) {
                    return new JsonResponse(['message' => (string) $errors, 'code' => 400], 400);
                }
                $this->em->persist($goal);
                $this->em->flush();
            }
            $exercisePlan->setGoal($goal);
        }

        $errors = $this->validator->validate($exercisePlan);
        if (count($errors) > 0) {
            return new JsonResponse(['message' => (string) $errors, 'code' => 400], 400);
        }

        $this->em->flush();

        $update = new Update(
            '/api/trgp-control/training-plans/' . $training->getId(), 
            json_encode(['message' => 'Training plan has been updated']),
        );
        $this->hub->publish($update);

        return $this->json([
            'message' => "Changed exercise plan",
            'data' => (new NormalizeService())->normalizeByGroup($exercisePlan, ['groups' => ['main',  'main_g']]),
            'code' => 200
        ]);
    }

    /**
     * @Route("/{id}", methods={"DELETE"})
     */
    public function deleteExercisePlan(int $id) {
        $exercisePlan = $this->em->getRepository(ExercisePlan::class)->findOneBy(['id' => $id]);
        $trainingPlan = is_null($exercisePlan) ? null : $exercisePlan->getTrainingPlan();
        $userId = $this->getUser()->getId();
        if(is_null($trainingPlan) || !in_array($userId, $trainingPlan->getProgramPlan()->getAuthorsId())) 
            return new JsonResponse(['message' => "Such exercise in training plan not found", 'code' => 404], 404);

        $trainingPlan->removePlannedExercise($exercisePlan);

        $this->em->flush();

        $update = new Update(
            '/api/trgp-control/training-plans/' . $trainingPlan->getId(), 
            json_encode(['message' => 'One of exercise plans has been deleted from training plan']),
        );
        $this->hub->publish($update);

        return $this->json([
            'message' => "Changed training plan",
            'data' => (new NormalizeService())->normalizeByGroup($trainingPlan, ['groups' => ['main', 'additional_tp', "main_g"]]),
            'code' => 200
        ]);
    }
}
