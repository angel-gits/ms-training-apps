<?php

namespace App\Controller;

use App\Entity\Exercise;
use App\Entity\Statistics;
use App\Service\NormalizeService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/statistics")
 */
class StatisticsController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/exercise-{id}", methods={"GET"})
     */
    public function getForExercise(int $id): JsonResponse
    {
        $exercise = $this->em->getRepository(Exercise::class)->findOneBy(['id' => $id]) ?? null;
        if(is_null($exercise)) return new JsonResponse([
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
        $name = $exercise->getExercisePlan()->getName()->getName();

        $list = $this->em->getRepository(Statistics::class)->findBy(['exersiceName' => $name], ['date' => 'ASC']);

        return $this->json([
            'message' => "Statistics for requested exercise",
            'data' => (new NormalizeService())->normalizeByGroup($list, ['groups' => ['main']]),
            'code' => 200
        ]);
    }
}
