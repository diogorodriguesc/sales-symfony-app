<?php
declare(strict_types=1);

namespace App\UseCase\Query\GetCustomerByUuid;

use Ramsey\Uuid\UuidInterface;

final readonly class Query
{
    public function __construct(public UuidInterface $uuid)
    {
    }
}