<?php
declare(strict_types=1);

namespace App\UseCase\Command\CreateCustomer\Infrastructure;

use App\Entity\Country;
use App\Entity\Customer;
use App\UseCase\Command\CreateCustomer\Command;
use App\UseCase\Command\CreateCustomer\Exception\NotFoundCountryException;
use App\UseCase\Command\CreateCustomer\RepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;

final readonly class Repository implements RepositoryInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    /**
     * @throws NotFoundCountryException
     */
    public function createCustomer(Command $command): Customer
    {
        $country = $this->entityManager->getRepository(Country::class)->findOneBy(['countryCode' => $command->countryCode]);

        if (!$country) {
            throw new NotFoundCountryException(sprintf('Country "%s" not found', $command->countryCode));
        }

        $customer = new Customer();

        $customer
            ->setName($command->name)
            ->setTaxIdentificationNumber($command->taxIdentificationNumber)
            ->setCountry($country)
            ->setUuid(Uuid::uuid4()->toString());

        $this->entityManager->persist($customer);
        $this->entityManager->flush();

        return $customer;
    }
}