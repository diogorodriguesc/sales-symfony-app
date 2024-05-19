<?php
declare(strict_types=1);

namespace App\Controller;

use App\UseCase\Query\GetCustomerByUuid\Query;
use League\Tactician\CommandBus;
use Ramsey\Uuid\Rfc4122\UuidV4;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\SerializerInterface;

final class GetCustomerByUuidController extends AbstractController
{
    public function __construct(
        private readonly CommandBus $commandBus,
        private readonly SerializerInterface $serializer
    )
    {}

    public function __invoke__(string $uuid): Response
    {
        $customer = $this->commandBus->handle(new Query(UuidV4::fromString($uuid)));

        if (!$customer) {
            throw new NotFoundHttpException('Customer not found');
        }

        $json = $this->serializer->serialize($customer, 'json', ['groups' => ['show_customer', 'show_country']]);

        return new Response($json, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }
}