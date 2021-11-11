<?php

namespace App\Controller;

use App\Entity\Goal;
use App\Service\NormalizeService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/goals", name="goal_cintroller")
 */
class GoalController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
    /**
     * @Route("", name="goals", methods={"GET"})
     */
    public function getGoals(): Response
    {
        $list = $this->em->getRepository(Goal::class)->findAll();

        return $this->json([
            'message' => "Programs not found",
            'data' => (new NormalizeService())->normalizeByGroup($list, ['groups' => ['main']]),
            'code' => 200
        ]);
    }
}
