<?php
declare(strict_types=1);

namespace App\Tests\Unit\Entity;

use App\Entity\Country;
use App\Entity\Customer;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    public function testCustomer(): void
    {
        $customer = new Customer();

        $customer
            ->setName('Diogo Correia')
            ->setUuid('b517f303-6e10-4b10-8c1c-268751510537')
            ->setTaxIdentificationNumber('123456789')
            ->setCountry(
                $this->createMock(Country::class)
            );

        self::assertEquals('Diogo Correia', $customer->name());
        self::assertEquals('123456789', $customer->taxIdentificationNumber());
        self::assertEquals('b517f303-6e10-4b10-8c1c-268751510537', $customer->uuid());
        self::assertInstanceOf(Country::class, $customer->country());
    }
}