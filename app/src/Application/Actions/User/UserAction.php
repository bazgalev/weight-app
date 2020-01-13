<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Application\Actions\Action;
use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository;
use Psr\Log\LoggerInterface;

abstract class UserAction extends Action
{
    /**
     * @var UserRepository
     */
    protected UserRepository $userRepository;

    /**
     * @param LoggerInterface $logger
     * @param UserRepository $userRepository
     */
    public function __construct(LoggerInterface $logger, UserRepository $userRepository)
    {
        parent::__construct($logger);
        $this->userRepository = $userRepository;
    }

    /**
     * @param int $userId
     * @return User
     * @throws UserNotFoundException
     */
    protected function getUserById(int $userId): User
    {
        try {
            $user = $this->userRepository->finById($userId);
        } catch (UserNotFoundException $e) {
            $this->logger->info("Trying to view a nonexistent user with id `{$userId}`");
            throw $e;
        }

        return $user;
    }

    /**
     * @return int
     * @throws \Slim\Exception\HttpBadRequestException
     */
    protected function resolveUserId(): int
    {
        return (int)$this->resolveArg('id');
    }
}
