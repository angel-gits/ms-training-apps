<?php
namespace App\Service;

use App\Entity\User;
use App\Entity\Program;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class UserPermissionsCheckService {
    private function isTrainer(User $user): bool {
        return $user->isGranted("ROLE_SUPER_ADMIN");
    }

    public function isUserTrainer(User $user, int $trainerId): bool {
        $trainersId = $user->getTrainersId();
        if(is_array($trainersId) && in_array($trainerId, $trainersId))
            return true;
        return false;
    }

    public function isAuthor($entity, int $userId): bool {
        return $entity->getAuthorId() == $userId;
    }

    public function isOwner($program, int $userId) {
        return $program->getOwnerId() == $userId;
    }

    public function checkPermissionsOwnerAuthor($entity, int $userId): bool {
        if(!$this->isOwner($entity, $userId) && !$this->isAuthor($entity, $userId))
            return false;
        return true;
    }
}