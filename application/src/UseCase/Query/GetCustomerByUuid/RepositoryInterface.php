<?php
declare(strict_types=1);

namespace App\UseCase\Query\GetCustomerByUuid;

use App\Entity\Customer;
use Ramsey\Uuid\UuidInterface;

interface RepositoryInterface
{
    public function getCustomerByUuid(UuidInterface $uuid): ?Customer;
}