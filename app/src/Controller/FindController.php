<?php

namespace App\Controller;

use App\Entity\Goal;
use App\Entity\Program;
use App\Entity\GoalUser;
use App\Entity\Training;
use App\Entity\ProgramPlan;
use App\Entity\ExercisePlan;
use App\Entity\TrainingPlan;
use Psr\Log\LoggerInterface;
use App\Service\NormalizeService;
use App\Entity\ExerciseClassifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/find")
 */
class FindController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/program-plans", methods={"GET"})
     */
    public function findPlans(Request $request): JsonResponse {
        $data = json_decode($request->getContent(), true);
        $value = $data['value'] ?? null;
        
        if(!is_null($value)) {
            $list1 = array();
            if(!empty($goals = $this->em->getRepository(Goal::class)->findLikeByName($value))) {
                foreach($goals as $goal) {
                    if(!empty($programs = $this->em->getRepository(ProgramPlan::class)->findBy(['goal' => $goal]))) {
                        $list1 = array_merge($list1, $programs);
                    }
                }
            }
            $list2 = $this->em->getRepository(ProgramPlan::class)->findLikeMathcesByValue($value);
            $list = array_unique(array_merge($list1, $list2), SORT_REGULAR);
            $userId = $this->getUser()->getId();
            foreach($list as $plan) {
                if(!in_array($userId, $plan->getAuthorsId()) && !in_array($userId, $plan->getOwnersId()))
                    if (($key = array_search($plan, $list)) !== false) {
                        unset($list[$key]);
                    }
            }
            return $this->json([
                'message' => "Found program",
                'data' => (new NormalizeService())->normalizeByGroup($list, ['groups' => ['main']]),
                'code' => 200
            ]);
        }
        else return $this->json([
            'message' => "Programs not found",
            'data' => (new NormalizeService())->normalizeByGroup(array(), ['groups' => ['main']]),
            'code' => 200
        ]);
    }

    /**
     * @Route("/training-plans", methods={"GET"})
     */
    public function findTrainingPlans(Request $request): JsonResponse {
        $data = json_decode($request->getContent(), true);
        $value = $data['value'] ?? null;

        $programPlan = $this->em->getRepository(ProgramPlan::class)->findOneBy(['id' => $request->get('plan') ?? null]);
        $userId = $this->getUser()->getId();
        if(is_null($programPlan) || (!in_array($userId, $programPlan->getAuthorsId()) && !in_array($userId, $programPlan->getOwnersId()))) 
            return new JsonResponse([
                'message' => "Can't find trainings for particular program plan", 
                'code' => 404
            ], 404);

        if(!is_null($value)) {
            $list1 = array();
            if(!empty($goals = $this->em->getRepository(Goal::class)->findLikeByName($value))) {
                foreach($goals as $goal) {
                    if(!empty($trainingPlans = $this->em->getRepository(TrainingPlan::class)->findBy(['goal' => $goal]))) {
                        $list1 = array_merge($list1, $trainingPlans);
                    }
                }
            }
            
            $list2 = $this->em->getRepository(TrainingPlan::class)->findLikeByValue($value);

            $list = array_unique(array_merge($list1, $list2), SORT_REGULAR);
            foreach($list as $trainingPlan) {
                if($trainingPlan->getProgramPlan() != $programPlan)
                    if (($key = array_search($trainingPlan, $list)) !== false) {
                        unset($list[$key]);
                    }
            }

            return $this->json([
                'message' => "Found training plans",
                'data' => (new NormalizeService())->normalizeByGroup($list, ['groups' => ['main']]),
                'code' => 200
            ]);
        }
        else return $this->json([
            'message' => "Training plans not found",
            'data' => (new NormalizeService())->normalizeByGroup(array(), ['groups' => ['main']]),
            'code' => 200
        ]);
    }

    /**
     * @Route("/exercise-names", methods={"GET"})
     */
    public function getExerciseNames(Request $request): JsonResponse {
        $data = json_decode($request->getContent(), true);
        $value = $data['value'] ?? null;

        if(!is_null($value)) {
            $list = $this->em->getRepository(ExerciseClassifier::class)->findLikeByName($value);

            return $this->json([
                'message' => "Found exercise names",
                'data' => (new NormalizeService())->normalizeByGroup($list, ['groups' => ['main']]),
                'code' => 200
            ]);
        }
        else return $this->json([
            'message' => "Exercise names not found",
            'data' => (new NormalizeService())->normalizeByGroup(array(), ['groups' => ['main']]),
            'code' => 200
        ]);
    }

    /**
     * @Route("/goals", methods={"GET"})
     */
    public function getGoals(Request $request): JsonResponse {
        $data = json_decode($request->getContent(), true);
        $value = $data['value'] ?? null;

        if(!is_null($value)) {
            $list = $this->em->getRepository(Goal::class)->findLikeByName($value);

            return $this->json([
                'message' => "Found goals",
                'data' => (new NormalizeService())->normalizeByGroup($list, ['groups' => ['main']]),
                'code' => 200
            ]);
        }
        else return $this->json([
            'message' => "Goals not found",
            'data' => (new NormalizeService())->normalizeByGroup(array(), ['groups' => ['main']]),
            'code' => 200
        ]);
    }

    /**
     * @Route("/programs", methods={"GET"})
     */
    public function getPrograms(Request $request): JsonResponse {
        $data = json_decode($request->getContent(), true);
        $value = $data['value'] ?? null;
        $type = $request->get('type') ?? 'my';

        if(!is_null($value)) {
            $list1 = $this->em->getRepository(Program::class)->findLikeMathcesByValue($value);

            $list2 = array();
            foreach($this->em->getRepository(ProgramPlan::class)->findLikeNameMathcesByValue($value) as $programPlan) {
                $list2 = array_merge($list2, $this->em->getRepository(Program::class)->findBy(['programPlan' => $programPlan]));
            }

            $list3 = array();
            if(!empty($goals = $this->em->getRepository(Goal::class)->findLikeByName($value))) {
                foreach($goals as $goal)
                    foreach($this->em->getRepository(GoalUser::class)->findBy(['goal' => $goal]) as $goalUser)
                        $list3 = array_merge($list3, $this->em->getRepository(Program::class)->findBy(['goal' => $goalUser]));
            }

            $list = array_unique(array_merge($list1, $list2, $list3), SORT_REGULAR);
            $userId = $this->getUser()->getId();
            foreach($list as $program) {
                switch($type) {
                    case 'my':
                        if($userId != $program->getOwnerId())
                            if (($key = array_search($program, $list)) !== false) {
                                unset($list[$key]);
                            }
                        break;
                    case 'hosted':
                        if(!in_array($userId, $program->getTrainersId()))
                            if (($key = array_search($program, $list)) !== false) {
                                unset($list[$key]);
                            }
                        break;
                    default: return new JsonResponse([
                        'message' => "No such type of program found",
                        'code' => 404
                    ], 404);
                }
            }
            return $this->json([
                'message' => "Found programs",
                'data' => (new NormalizeService())->normalizeByGroup($list, ['groups' => ['main']]),
                'code' => 200
            ]);
        }
        else return $this->json([
            'message' => "Programs not found",
            'data' => (new NormalizeService())->normalizeByGroup(array(), ['groups' => ['main']]),
            'code' => 200
        ]);
    }

    /**
     * @Route("/trainings", methods={"GET"})
     */
    public function getTrainings(Request $request): JsonResponse {
        $programId = $request->get('program');
        $type = $request->get('type') ?? null;
        $userId = $this->getUser()->getId();
        $program = $this->em->getRepository(Program::class)->findOneBy(['id' => $programId]);
        if(is_null($program) || (!in_array($userId, $program->getTrainersId()) && $userId != $program->getOwnerId())) 
            return new JsonResponse([
            'message' => "You can't update this program",
            'code' => 404
        ], 404);
        $trainings = $program->getTrainings();

        $data = json_decode($request->getContent(), true);
        $value = $data['value'] ?? null;

        if(!is_null($value)) {
            if($type == 'byExercise') {
                $list = array();
                $names = $this->em->getRepository(ExerciseClassifier::class)->findLikeByName($value);
                foreach($names as $name) 
                    foreach($this->em->getRepository(ExercisePlan::class)->findBy(['name' => $name]) as $exercisePlan)
                        foreach($trainings as $training)
                            foreach($training->getExercises() as $exercise) 
                                if($exercise->getExercisePlan() == $exercisePlan) {
                                    $list[] = $training;
                                    break;
                                }
            }
            else {
                $list1 = $this->em->getRepository(Training::class)->findLikeMathcesByValue($value);
                foreach($list1 as $training)
                    if(!$trainings->contains($training))
                        if (($key = array_search($training, $list1)) !== false) {
                            unset($list1[$key]);
                        }

                $list2 = array();
                foreach($this->em->getRepository(TrainingPlan::class)->findLikeNameByValue($value) as $trainingPlan) {
                    foreach($trainings as $training)
                        if($training->getTrainingPlan() == $trainingPlan)
                            $list2[] = $training;
                }

                $list3 = array();
                if(!empty($goals = $this->em->getRepository(Goal::class)->findLikeByName($value))) {
                    foreach($goals as $goal)
                        foreach($this->em->getRepository(GoalUser::class)->findBy(['goal' => $goal]) as $goalUser)
                            foreach($trainings as $training)
                                if($training->getGoal() == $goalUser)
                                    $list3[] = $training;
                }

                $list = array_unique(array_merge($list1, $list2, $list3), SORT_REGULAR);
            }
            return $this->json([
                'message' => "Found trainings",
                'data' => (new NormalizeService())->normalizeByGroup($list, ['groups' => ['main', 'additional_training']]),
                'code' => 200
            ]);
        }
        else return $this->json([
            'message' => "Trainings not found",
            'data' => (new NormalizeService())->normalizeByGroup(array(), ['groups' => ['main']]),
            'code' => 200
        ]);
    }
}
