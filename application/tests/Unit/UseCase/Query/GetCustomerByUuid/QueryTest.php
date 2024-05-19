<?php
declare(strict_types=1);

namespace App\Tests\Unit\UseCase\Query\GetCustomerByUuid;

use App\UseCase\Query\GetCustomerByUuid\Query;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class QueryTest extends TestCase
{
    public function testQuery(): void
    {
        $query = new Query($expectedUuid = Uuid::fromString('a74884ca-1f60-4d4e-86e6-01a60c6dc5e4'));

        self::assertEquals($expectedUuid, $query->uuid);
    }
}