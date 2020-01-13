<?php


namespace App\Domain\User;


use DateTime;

class Weight implements \JsonSerializable
{
    /**
     * @var int|null
     */
    private ?int $id;
    /**
     * @var int
     */
    private int $userId;
    /**
     * @var DateTime
     */
    private DateTime $dt;
    /**
     * @var int
     */
    private int $value;

    public function __construct(?int $id, int $userId, DateTime $dt, int $value)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->dt = $dt;
        $this->value = $value;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'userId' => $this->userId,
            'datetime' => $this->dt->format('Y-m-d H:i:s'),
            'value' => $this->value
        ];
    }
}