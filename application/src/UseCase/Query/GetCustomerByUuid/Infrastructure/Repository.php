<?php
declare(strict_types=1);

namespace App\UseCase\Query\GetCustomerByUuid\Infrastructure;

use App\UseCase\Query\GetCustomerByUuid\RepositoryInterface;
use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;

final readonly class Repository implements RepositoryInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function getCustomerByUuid(UuidInterface $uuid): ?Customer
    {
        return $this->entityManager->getRepository(Customer::class)->findOneBy(['uuid' => $uuid->toString()]);
    }
}