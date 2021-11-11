<?php

namespace App\Controller;

use App\Entity\Goal;
use App\Entity\Training;
use App\Entity\ProgramPlan;
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
 * @Route("/training-plans")
 */
class TrainingPlanController extends AbstractController
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
     * @Route("/{id}", name="training", methods={"GET"})
     */
    public function getTraining(int $id): JsonResponse
    {
        $trainingPlan = $this->em->getRepository(TrainingPlan::class)->findOneBy(['id' => $id]);
        $userId = $this->getUser()->getId();
        $plan = is_null($trainingPlan) ? null : $trainingPlan->getProgramPlan();
        if(is_null($plan) || (!in_array($userId, $plan->getAuthorsId()) && !in_array($userId, $plan->getOwnersId()))) 
            return new JsonResponse(['message' => "Such training plan not found", 'code' => 404], 404);
        
        return $this->json([
            'message' => "Training program",
            'data' => (new NormalizeService())->normalizeByGroup($trainingPlan, ['groups' => ['main', 'additional_tp', 'main_t', 'main_g']]),
            'code' => 200
        ]);
    }

    /**
     * @Route("", methods={"POST"})
     */
    public function addTrainingPlan(Request $request)
    {
        $id = $request->get('plan') ?? null;
        $plan = $this->em->getRepository(ProgramPlan::class)->findOneBy(['id' => $id]);
        if (is_null($plan)) return new JsonResponse(['message' => "Such program plan doesn't exist", 'code' => 404], 404);

        $userId = $this->getUser()->getId();
        if (!in_array($userId, $plan->getAuthorsId()))
            return new JsonResponse(['message' => "You don't have rights to edit this plan", 'code' => 403], 403);

        $data = json_decode($request->getContent(), true);
        $trainingPlan = new TrainingPlan();
        $trainingPlan->setName($data['name'] ?? null);
        $trainingPlan->setProgramPlan($plan);
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
            $trainingPlan->setGoal($goal);
        }

        $errors = $this->validator->validate($trainingPlan);
        if (count($errors) > 0) {
            return new JsonResponse(['message' => (string) $errors, 'code' => 400], 400);
        }

        $this->em->persist($trainingPlan);
        $plan->addPlannedTraining($trainingPlan);

        $this->em->flush();

        foreach($plan->getAuthorsId() as $authorId) {
            $update = new Update(
                '/api/trgp-control/' . $authorId . '/training-plans', 
                json_encode(['message' => 'New training plan has been added to created program plan ' . $id]),
            );
            $this->hub->publish($update);
        }
        foreach($plan->getOwnersId() as $ownerId) {
            $update = new Update(
                '/api/trgp-control/' . $ownerId . '/training-plans', 
                json_encode(['message' => 'New training plan has been added to my program plan ' . $id]),
            );
            $this->hub->publish($update);
        }

        return $this->json([
            'message' => "Created training",
            'data' => (new NormalizeService())->normalizeByGroup($trainingPlan, ['groups' => ['main', 'additional_tp', 'main_t', 'main_g']]),
            'code' => 200
        ]);
    }

    /**
     * @Route("/{id}", methods={"PATCH"})
     */
    public function patchTraining(Request $request, int $id) {
        $trainingPlan = $this->em->getRepository(TrainingPlan::class)->findOneBy(['id' => $id]);
        $userId = $this->getUser()->getId();
        $plan = $trainingPlan->getProgramPlan() ?? null;
        if(!is_null($trainingPlan)) {
            if(is_null($plan)) {
                $wrong = 0;
                foreach($trainings = $this->em->getRepository(Training::class)->findBy(['trainingPlan' => $trainingPlan]) as $training) {
                    if(!in_array($userId, $training->getProgram()->getTrainers()) && $userId != $training->getProgram()->getOwnerId())
                        $wrong++;
                }
                if(sizeof($trainings) == $wrong) return new JsonResponse(['message' => "You're not allowed to edit plan", 'code' => 403], 403);
            }
            else if(!in_array($userId, $plan->getAuthorsId())) 
                return new JsonResponse(['message' => "You're not allowed to edit plan", 'code' => 403], 403);
        }
        else return new JsonResponse(['message' => "Such training plan not found", 'code' => 404], 404);
        
        $data = json_decode($request->getContent(), true);
        if(!is_null($data['name'] ?? null)) $trainingPlan->setName($data['name']);
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
            $trainingPlan->setGoal($goal);
        }
    
        $errors = $this->validator->validate($trainingPlan);
        if (count($errors) > 0) {
            return new JsonResponse(['message' => (string) $errors, 'code' => 400], 400);
        }
    
        $this->em->persist($trainingPlan);
        $this->em->flush();

        $update = new Update(
            '/api/trgp-control/training-plans/' . $id, 
            json_encode(['message' => 'Training plan has been updated']),
        );
        $this->hub->publish($update);
    
        return $this->json([
            'message' => "Changed training",
            'data' => (new NormalizeService())->normalizeByGroup($trainingPlan, ['groups' => ['main', 'additional_tp', 'main_t']]),
            'code' => 200
        ]);
    }

    /**
     * @Route("/{id}", methods={"DELETE"})
     */
    public function deleteTraining(int $id) {
        $trainingPlan = $this->em->getRepository(TrainingPlan::class)->findOneBy(['id' => $id]);
        $userId = $this->getUser()->getId();
        $plan = $trainingPlan->getProgramPlan() ?? null;
        if(is_null($trainingPlan) || is_null($plan) || (!in_array($userId, $plan->getAuthorsId())))
            return new JsonResponse(['message' => "Such training plan not found", 'code' => 404], 404);

        $plan->removePlannedTraining($trainingPlan);
        $this->em->remove($trainingPlan);

        $this->em->flush();

        $update = new Update(
            '/api/trgp-control/training-plans/' . $id, 
            json_encode(['message' => 'Training plan has been deleted']),
        );
        $this->hub->publish($update);

        return $this->json([
            'message' => "Changed program plan",
            'data' => (new NormalizeService())->normalizeByGroup($plan, ['groups' => ['main', 'additional', 'main_t', 'main_g']]),
            'code' => 200
        ]);
    }
}
