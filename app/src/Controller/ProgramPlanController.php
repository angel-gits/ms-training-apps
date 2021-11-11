<?php

namespace App\Controller;

use App\Entity\Goal;
use App\Entity\GoalUser;
use App\Entity\ProgramPlan;
use App\Service\NormalizeService;
use Symfony\Component\Mercure\Update;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/program-plans")
 */
class ProgramPlanController extends AbstractController
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
     * @Route("/{id}", methods={"GET"})
     */
    public function getCreatedProgramPlan(int $id): JsonResponse
    {
        $userId = $this->getUser()->getId();
        $programPlan = $this->em->getRepository(ProgramPlan::class)->findOneBy(['id' => $id]);
        if(is_null($programPlan) || (!in_array($userId, $programPlan->getAuthorsId()) && !in_array($userId, $programPlan->getOwnersId()))) 
            return new JsonResponse(['message' => "Such program plan not found", 'code' => 404], 404);
        elseif(!in_array($userId, $programPlan->getAuthorsId()))
            return $this->json([
                'message' => "Chosen program plan",
                'data' => (new NormalizeService())->normalizeByGroup($programPlan, ['groups' => ['main', 'additional', 'additional_author', 'main_pp']]),
                'code' => 200
            ]);
        else 
            return $this->json([
                'message' => "Chosen program plan",
                'data' => (new NormalizeService())->normalizeByGroup($programPlan, ['groups' => ['main', 'additional', 'main_t', 'main_pp']]),
                'code' => 200
            ]);
    }

    /**
     * @Route("", methods={"POST"})
     */
    public function postNewPlan(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $name = $data['name'] ?? null;
        $duration = $data['duration'] ?? null;
        $goalInfo = $data['goal'] ?? null;
        $authorsId = $data['authors'] ?? null;
        $ownersId = $data['owners'] ?? null;

        $userId = $this->getUser()->getId();

        $programPlan = new ProgramPlan($duration, $name);
        
        if(!is_null($ownersId) && !$this->getUser()->isGranted("ROLE_SUPER_ADMIN"))
            return new JsonResponse(['message' => "You're not allowed to perform such action", 'code' => 403], 403);
        elseif(!is_null($ownersId)) $programPlan->setOwnersId((array)$ownersId);
        else $programPlan->setOwnersId(array($userId));

        if(!is_null($goalInfo)) {
            if(is_null($goal = $this->em->getRepository(Goal::class)->findOneBy(['name' => $goalInfo['name'] ?? null]))) {
                $goal = new Goal($goalInfo['name'] ?? null);
                $errors = $this->validator->validate($goal);
                if(count($errors) > 0) {
                    return new JsonResponse(['message' => (string) $errors, 'code' => 400], 400);
                } 
                $this->em->persist($goal);
                $this->em->flush();
            }

            $programPlan->setGoal($goal);
        }

        if(is_null($authorsId)) $authorsdId = array($userId);
        else (array) $authorsId[] = $userId;
        $programPlan->setAuthorsId((array)$authorsdId);

        $errors = $this->validator->validate($programPlan);
        if(count($errors) > 0) {
            return new JsonResponse(['message' => (string) $errors, 'code' => 400], 400);
        } 
        
        $this->em->persist($programPlan);
        $this->em->flush();

        foreach($programPlan->getAuthorsId() as $authorId) {
            $update = new Update(
                '/api/trgp-control/' . $authorId . '/program-plans', 
                json_encode(['message' => 'New program plan has been added to created ones']),
            );
            $this->hub->publish($update);
        }
        foreach($programPlan->getOwnersId() as $ownerId) {
            $update = new Update(
                '/api/trgp-control/' . $ownerId . '/program-plans', 
                json_encode(['message' => 'New program plan has been added to my ones']),
            );
            $this->hub->publish($update);
        }


        return $this->json([
            'message' => "Added program plan",
            'data' => (new NormalizeService())->normalizeByGroup($programPlan, ['groups' => ['main', 'main_pp']]),
            'code' => 200
        ]);
    }

    /**
     * @Route("/{id}", methods={"DELETE"})
     */
    public function removePlan(int $id)
    {
        $userId = $this->getUser()->getId();
        $programPlan = $this->em->getRepository(ProgramPlan::class)->findOneBy(['id' => $id]);
        if(is_null($programPlan) || !in_array($userId, $programPlan->getAuthorsId())) return new JsonResponse(['message' => "Such program plan not found", 'code' => 404], 404);

        $this->em->remove($programPlan);
        $this->em->flush();

        $list = $this->em->getRepository(ProgramPlan::class)->findAll();
        if($this->getUser()->isGranted("ROLE_SUPER_ADMIN")) {
            foreach($list as $programPlan) {
                if(is_bool($programPlan->getAuthorsId()) || !in_array($this->getUser()->getId(), $programPlan->getAuthorsId())) 
                    if (($key = array_search($programPlan, $list)) !== false) {
                        unset($list[$key]);
                    }
            }
        }

        $update = new Update(
            '/api/trgp-control/program-plans/' . $id, 
            json_encode(['message' => 'Program plan has been deleted']),
        );
        $this->hub->publish($update);

        return $this->json([
            'message' => "List of created program plans",
            'data' => (new NormalizeService())->normalizeByGroup($list, ['groups' => ['main', 'main_pp']]),
            'code' => 200
        ]);
    }

    /**
     * @Route("/{id}", methods={"PATCH"})
     */
    public function editPlan(Request $request, int $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $name = $data['name'] ?? null;
        $duration = $data['duration'] ?? null;
        $goalInfo = $data['goal'] ?? null;
        $authorsId = $data['authors'] ?? null;
        $ownersId = $data['owners'] ?? null;
        $type = $data['type'] ?? null;

        $userId = $this->getUser()->getId();

        $programPlan = $this->em->getRepository(ProgramPlan::class)->findOneBy(['id' => $id]);
        if(is_null($programPlan) || !in_array($userId, $programPlan->getAuthorsId())) 
            return new JsonResponse(['message' => "Such program plan not found", 'code' => 404], 404);

        if(!is_null($name)) $programPlan->setName($name);
        if(!is_null($duration)) $programPlan->setDuration($duration);

        if(!is_null($ownersId) && !is_null($type) && $type == 'add') {
            $programPlan->setOwnersId(array_unique(array_merge($programPlan->getOwnersId(), (array) $ownersId), SORT_REGULAR));
        }
        if(!is_null($authorsId) && !is_null($type) && $type == 'add') {
            $programPlan->setAuthorsId(array_unique(array_merge($programPlan->getAuthorsId(), (array) $authorsId), SORT_REGULAR));
        }

        if(!is_null($ownersId) && !is_null($type) && $type == 'delete' && $ownersId != $programPlan->getOwnersId()) {
            $programPlan->setOwnersId(array_diff($programPlan->getOwnersId(), (array) $ownersId));
            
        }
        if(!is_null($authorsId) && !is_null($type) && $type == 'delete' && $authorsId != $programPlan->getAuthorsId()) {
            $programPlan->setAuthorsId(array_diff($programPlan->getAuthorsId(), (array) $authorsId));
            if(empty($programPlan->getAuthorsId())) 
                return new JsonResponse([
                    'message' => "There can't be no author. None changes've been applied",
                    'code' => 409
                ], 409);
        }

        if(!is_null($goalInfo)) {
            if(is_null($goal = $this->em->getRepository(Goal::class)->findOneBy(['name' => $goalInfo['name'] ?? null]))) {
                $goal = new Goal($goalInfo['name'] ?? null);
                $errors = $this->validator->validate($goal);
                if(count($errors) > 0) {
                    return new JsonResponse(['message' => (string) $errors, 'code' => 400], 400);
                } 
                $this->em->persist($goal);
                $this->em->flush();

                foreach($this->em->getRepository(GoalUser::class)->findBy(['goal' => $programPlan->getGoal()]) as $goalUser)
                    $goalUser->setGoal($goal);
            }
            $programPlan->setGoal($goal);
        }

        $errors = $this->validator->validate($programPlan);
        if(count($errors) > 0) {
            return new JsonResponse(['message' => (string) $errors, 'code' => 400], 400);
        } 
        
        $this->em->flush();

        if(in_array($userId, $programPlan->getAuthorsId()) || in_array($userId, $programPlan->getOwnersId())) {
            $update = new Update(
                '/api/trgp-control/program-plans/' . $id, 
                json_encode(['message' => 'Program plan has been updated']),
            );
            $this->hub->publish($update);

            return $this->json([
                'message' => "Changed program plan",
                'data' => (new NormalizeService())->normalizeByGroup($programPlan, ['groups' => ['main', 'additional', 'additional_author', 'main_pp']]),
                'code' => 200
            ]);
        }
        else return new JsonResponse(['message' => "Such program plan not found", 'code' => 404], 404);
    }
}
