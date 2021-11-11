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
;

/**
 * @Route("/bids")
 */
class BidController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
    /**
     * @Route("/incoming", name="incoming_bids", methods={"GET"})
     */
    public function getIncomingBids(): JsonResponse
    {
        $userId = $this->getUser()->getId();
        $list = $this->em->getRepository(Bid::class)->findBy(['recieverId' => $userId]);
        return $this->json([
            'message' => "List of incoming bids",
            'data' => (new NormalizeService())->normalizeByGroup($list, ['groups' => ['main', 'additional_in']]),
            'code' => 200
        ]);
    }

    /**
     * @Route("/outgoing", name="outgoing_bids",methods={"GET"})
     */
    public function getOutgoingBids(): JsonResponse
    {
        $userId = $this->getUser()->getId();
        $list = $this->em->getRepository(Bid::class)->findBy(['senderId' => $userId]);
        return $this->json([
            'message' => "List of outgoing bids",
            'data' => (new NormalizeService())->normalizeByGroup($list, ['groups' => ['main', 'additional_out']]),
            'code' => 200
        ]);
    }

    /**
     * @Route("/", name="bids", methods={"GET"})
     */
    public function getBids(): JsonResponse
    {
        $userId = $this->getUser()->getId();
        $list1 = $this->em->getRepository(Bid::class)->findBy(['recieverId' => $userId]);
        $list2 = $this->em->getRepository(Bid::class)->findBy(['senderId' => $userId]);
        $list = array_merge($list1, $list2);
        return $this->json([
            'message' => "List of both incoming and outgoing bids",
            'data' => (new NormalizeService())->normalizeByGroup($list, ['groups' => ['main', 'additional_in', 'additional_out']]),
            'code' => 200
        ]);
    }

    /**
     * @Route("/{id}", methods={"GET"})
     */
    public function getBid(int $id): JsonResponse
    {
        $userId = $this->getUser()->getId();
        $bid = 
            $this->em->getRepository(Bid::class)->findOneBy(['id' => $id, 'senderId' => $userId]) 
            ?? $this->em->getRepository(Bid::class)->findOneBy(['id' => $id, 'recieverId' => $userId]);
        if(is_null($bid)) return new JsonResponse(['message' => "Bid isn't found", 'code' => 404], 404);

        return $this->json([
            'message' => 'Info about requested bid was successfully found',
            'data' => (new NormalizeService())->normalizeByGroup($bid, ['groups' => 'additional']),
            'code' => 200
        ]);
    }

    /**
     * @Route("/{id}", methods={"PATCH"})
     */
    public function changeBidStatus(Request $request, int $id): JsonResponse 
    {
        $user = $this->em->getRepository(User::class)->findOneBy(['id' => $this->getUser()->getId()]);
        $userId = $user->getId();
        $bid = $this->em->getRepository(Bid::class)->findOneBy(['id' => $id, 'recieverId' => $userId]);
        if(is_null($bid)) return new JsonResponse(['message' => "Bid isn't found", 'code' => 404], 404);

        $data = json_decode($request->getContent(), true);
        $status = $data['status'] ?? '';

        if($status === 'accept') {
            $sender = $this->em->getRepository(User::class)->findOneBy(['id' => $bid->getSenderId()]);
            switch($bid->getType()) {
                case Bid::TO_TRAINER: 
                    $user->addUserId($bid->getSenderId());
                    $sender->addTrainerId($userId);
                    break;
                case Bid::TO_USER: 
                    $user->addTrainerId($bid->getSenderId());
                    $sender->addUserId($userId);
                    break;
            }
        }

        $this->em->remove($bid);
        $this->em->flush();

        $list = $this->em->getRepository(Bid::class)->findBy(['recieverId' => $userId]);
        return $this->json([
            'message' => "Bid resolved. Current incoming bids list",
            'data' => (new NormalizeService())->normalizeByGroup($list, ['groups' => ['main', 'additional_in']]),
            'code' => 200
        ]);
    }

    /**
     * @Route("/{id}", methods={"DELETE"})
     */
    public function deleteBid(int $id): JsonResponse 
    {
        $userId = $this->getUser()->getId();
        $bid = $this->em->getRepository(Bid::class)->findOneBy(['id' => $id, 'senderId' => $userId]);
        if(is_null($bid)) return new JsonResponse(['message' => "Bid isn't found", 'code' => 404], 404);
        
        $this->em->remove($bid);
        $this->em->flush();

        $list = $this->em->getRepository(Bid::class)->findBy(['senderId' => $userId]);
        return $this->json([
            'message' => "List of outgoing bids",
            'data' => (new NormalizeService())->normalizeByGroup($list, ['groups' => ['main', 'additional_out']]),
            'code' => 200
        ]);
    }
}
