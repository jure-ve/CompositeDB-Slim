<?php
// src/Model/UsersTable.php
namespace App\Table;

use Composite\DB\AbstractTable;
use App\Entity\User;

class UsersTable extends \Composite\DB\AbstractTable
{
    protected function getConfig(): \Composite\DB\TableConfig
    {
        return \Composite\DB\TableConfig::fromEntitySchema(User::schema());
    }

    public function findByPk(int $id): ?User
    {
        return $this->_findByPk($id);
    }

    /**
     * @return User[]
     */
    public function findAllActive(): array
    {
        return $this->_findAll(['status' => \App\Enums\Status::ACTIVE]);
    }

    public function countAllActive(): int
    {
        return $this->_countAll(
            ['status' => \App\Enums\Status::ACTIVE],
        );
    }

    public function init(): void
    {
        $this->getConnection()->executeStatement("
            CREATE TABLE IF NOT EXISTS Users
            (
                `id`         INTEGER
                    CONSTRAINT Users_pk PRIMARY KEY AUTOINCREMENT,
                `email`      VARCHAR(255)                           NOT NULL,
                `name`       VARCHAR(255) DEFAULT NULL,
                `is_test`    INT          DEFAULT 0                 NOT NULL,
                `status`     ENUM         DEFAULT 'ACTIVE'          NOT NULL,
                `created_at` TIMESTAMP    DEFAULT CURRENT_TIMESTAMP NOT NULL,
                check (\"status\" IN ('ACTIVE', 'BLOCKED'))
            );
        ");
    }
}

