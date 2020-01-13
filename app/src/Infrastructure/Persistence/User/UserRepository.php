<?php


namespace App\Infrastructure\Persistence\User;


use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository as UserRepositoryInterface;
use Envms\FluentPDO\Query;

class UserRepository implements UserRepositoryInterface
{
    const TABLE = 'users';

    private Query $fluent;

    public function __construct(Query $fluent)
    {
        $this->fluent = $fluent;
    }

    /**
     * @inheritDoc
     * @return User[]
     * @throws \Envms\FluentPDO\Exception
     */
    public function findAll(): array
    {
        $users = $this->fluent
            ->from(self::TABLE)
            ->fetchAll();

        return array_map(fn($user) => new User($user['id'], $user['fname'], $user['lname']), $users);
    }

    /**
     * @inheritDoc
     * @throws \Envms\FluentPDO\Exception
     */
    public function finById(int $id): User
    {
        $user = $this->fluent
            ->from(self::TABLE, $id)
            ->fetch();

        if ($user) {
            return new User($user['id'], $user['fname'], $user['lname']);
        }
        throw new UserNotFoundException();
    }
}