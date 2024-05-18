<?php
declare(strict_types=1);

namespace App\UseCase\Command\CreateCustomer\Infrastructure;

use App\Entity\Customer;
use App\UseCase\Command\CreateCustomer\Command;
use App\UseCase\Command\CreateCustomer\RepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;

final readonly class Repository implements RepositoryInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function createCustomer(Command $command): bool
    {
        $customer = new Customer();

        $customer
            ->setName($command->name)
            ->setTaxIdentificationNumber($command->taxIdentificationNumber)
            ->setCountryCode($command->countryCode)
            ->setUuid(Uuid::uuid4()->toString());

        $this->entityManager->persist($customer);
        $this->entityManager->flush();

        return true;
    }
}