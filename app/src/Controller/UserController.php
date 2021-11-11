<?php

namespace App\Controller;

use App\Entity\Bid;
use App\Entity\User;
use App\Service\NormalizeService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

        /**
     * @Route("/users", name="users", methods={"GET"})
     */
    public function getUsers(Request $request): JsonResponse
    {
        $currUser  = $this->em->getRepository(User::class)->findOneBy(['id' => $this->getUser()->getId()]);;
        $users = $this->em->getRepository(User::class)->findAll();
        $list = array();
        foreach($users as $user) {
            if(is_array($currUser->getTrainersId()) && in_array($user->getId(), $currUser->getTrainersId())) {
                $status = "my trainer";
            }
            elseif(is_array($currUser->getUsersId()) && in_array($user->getId(), $currUser->getUsersId())) {
                $status = "my user";
            }
            else $status = "";
            $arr = [$user, $status];

            $list[] = $arr;
        }
        return $this->json([
            'message' => "List of existing users",
            'data' => (new NormalizeService())->normalizeByGroup($list, ['groups' => ['main', 'additional']]),
            'code' => 200
        ]);
    }
    
    /**
     * @Route("/users", methods={"POST"})
     */
    public function postBid(Request $request): JsonResponse 
    {
        $data = json_decode($request->getContent(), true);
        $sender = $this->getUser();
        $senderId  = $sender->getId();
        $recieverId = $data['to'] ?? null;
        $type = $data['type'] ?? 0;

        if(!is_null($recieverId) && $senderId !== $recieverId) {
            $reciever = $this->em->getRepository(User::class)->findOneBy(['id' => $recieverId]);
            if(is_null($reciever)) return new JsonResponse(['message' => "User you're sending bid to isn't found", 'code' => 404], 404);

            if(!is_null($this->em->getRepository(Bid::class)->findOneBy(['senderId' => $senderId, 'recieverId' => $recieverId, 'type' => $type]))
                || !is_null($this->em->getRepository(Bid::class)->findOneBy(['senderId' => $recieverId, 'recieverId' => $senderId, 'type' => 1-(int)$type])))
                return new JsonResponse(['message' => "Such bid has already been sent", 'code' => 409], 409);
            elseif(($reciever->isGranted('ROLE_SUPER_ADMIN') && $type == 0 && 
                            (is_bool($reciever->getUsersId()) || is_array($reciever->getUsersId()) && !in_array($senderId, $reciever->getUsersId()))) || 
                    ($this->isGranted('ROLE_SUPER_ADMIN') && $type == 1 && 
                            (is_bool($reciever->getTrainersId()) || is_array($reciever->getTrainersId()) && !in_array($senderId, $reciever->getTrainersId())))) {
                $bid = new Bid($senderId, $recieverId, $type);
                $this->em->persist($bid);
                $this->em->flush(); 

                return $this->json([
                    'message' => 'New bid was creted and sent to trainer',
                    'data' => (new NormalizeService())->normalizeByGroup($bid, ['groups' => 'additional']),
                    'code' => 200
                ]);
            }
            else return new JsonResponse(['message' => "Bid can not be created", 
                                            'code' => 400], 400);
        }
        else return new JsonResponse(['message' => "Check reciever. Something went wrong", 'code' => 400], 400);
    }

    /**
     * @Route("/my-users", name="trainer-users", methods={"GET"})
     */
    public function getUserUsers(): JsonResponse
    {
        $user = $this->em->getRepository(User::class)->findOneBy(['id' => $this->getUser()->getId()]);
        return $this->json([
            'message' => "List of my users",
            'data' => (new NormalizeService())->normalizeByGroup($user->getUsersId(), ['groups' => ['main', 'additional']]),
            'code' => 200
        ]);
    }

    /**
     * @Route("/my-users/{id}", methods={"DELETE"})
     */
    public function deleteUser(int $id): JsonResponse
    {
        $trainer = $this->em->getRepository(User::class)->findOneBy(['id' => $this->getUser()->getId()]);
        $delUser = $this->em->getRepository(User::class)->findOneBy(['id' => $id]);
        if(is_null($delUser)) return new JsonResponse(['message' => "User isn't found", 'code' => 404], 404);

        $usersId = $trainer->getUsersId();
        $trainersId = $delUser->getTrainersId();
        if(is_array($usersId) && in_array($id, $usersId)) {
            foreach($usersId as $userId) {
                if($userId == $id) {
                    $trainer->removeUserId($userId);
                    break;
                }
            }
            foreach($trainersId as $usTrainerId) {
                if($usTrainerId == $this->getUser()->getId()) {
                    $delUser->removeTrainerId($usTrainerId);
                    break;
                }
            }
        }

        $this->em->flush();

        return $this->json([
            'message' => "Changed list of my users",
            'data' => (new NormalizeService())->normalizeByGroup($trainer->getUsersId(), ['groups' => ['main', 'additional']]),
            'code' => 200
        ]);
    }

    /**
     * @Route("/my-trainers", name="user-trainers", methods={"GET"})
     */
    public function getUserTrainers(): JsonResponse
    {
        $user = $this->em->getRepository(User::class)->findOneBy(['id' => $this->getUser()->getId()]);;
        return $this->json([
            'message' => "List of my trainers",
            'data' => (new NormalizeService())->normalizeByGroup($user->getTrainersId(), ['groups' => ['main', 'additional']]),
            'code' => 200
        ]);
    }

    /**
     * @Route("/my-trainers/{id}", methods={"DELETE"})
     */
    public function deleteTrainer(int $id): JsonResponse
    {
        $user = $this->em->getRepository(User::class)->findOneBy(['id' => $this->getUser()->getId()]);
        $delTrainer = $this->em->getRepository(User::class)->findOneBy(['id' => $id]);
        if(is_null($delTrainer)) return new JsonResponse(['message' => "User isn't found", 'code' => 404], 404);

        $trainersId = $user->getTrainersId();
        $usersId = $delTrainer->getUsersId();

        if(is_array($trainersId) && in_array($id, $trainersId)) {
            foreach($trainersId as $trainerId) {
                if($trainerId == $id) {
                    $user->removeTrainerId($trainerId);
                    break;
                }
            }
            foreach($usersId as $trUserId) {
                if($trUserId == $user->getId()) {
                    $delTrainer->removeUserId($trUserId);
                    break;
                }
            }
        }

        $this->em->flush();

        return $this->json([
            'message' => "Changed list of my trainers",
            'data' => (new NormalizeService())->normalizeByGroup($user->getTrainersId(), ['groups' => ['main', 'additional']]),
            'code' => 200
        ]);
    }
}
