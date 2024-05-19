<?php
declare(strict_types=1);

namespace App\Tests\Unit\Entity;

use App\Entity\Country;
use PHPUnit\Framework\TestCase;

class CountryTest extends TestCase
{
    public function testCountry(): void
    {
        $country = new Country();

        $country
            ->setName('Portugal')
            ->setCountryCode('PT')
            ->setUuid('7775285a-db4b-4412-b13a-f2a307ef0144');

        self::assertEquals('Portugal', $country->name());
        self::assertEquals('PT', $country->countryCode());
        self::assertEquals('7775285a-db4b-4412-b13a-f2a307ef0144', $country->uuid());
    }
}