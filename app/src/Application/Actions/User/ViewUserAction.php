<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Domain\User\UserNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;

class ViewUserAction extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $userId = (int)$this->resolveArg('id');

        try {
            $user = $this->userRepository->findUserOfId($userId);
        } catch (UserNotFoundException $e) {
            $this->logger->info("Trying to view a nonexistent user with id `{$userId}`");
            throw $e;
        }

        $this->logger->info("User of id `${userId}` was viewed.");

        return $this->respondWithData($user);
    }
}
