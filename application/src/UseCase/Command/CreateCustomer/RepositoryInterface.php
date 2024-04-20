<?php
declare(strict_types=1);

namespace App\UseCase\Command\CreateCustomer;

interface RepositoryInterface
{
    public function createCustomer(Command $command): bool;
}