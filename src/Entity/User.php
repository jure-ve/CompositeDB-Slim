<?php
// src/Model/User.php
namespace App\Entity;

use Composite\DB\Attributes\{Table, PrimaryKey};
use Composite\Entity\AbstractEntity;
use App\Enums\Status;

#[Table(connection: 'sqlite', name: 'Users')]
class User extends AbstractEntity
{
    #[PrimaryKey(autoIncrement: true)]
    public readonly int $id;

    public function __construct(
        public string $email,
        public ?string $name = null,
        public bool $is_test = false,
        public Status $status = Status::ACTIVE,
        public readonly \DateTimeImmutable $created_at = new \DateTimeImmutable(),
    ) {}
}
