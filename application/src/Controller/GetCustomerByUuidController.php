<?php
declare(strict_types=1);

namespace App\Controller;

use App\UseCase\Query\GetCustomerByUuid\Query;
use League\Tactician\CommandBus;
use Ramsey\Uuid\Rfc4122\UuidV4;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;
use Symfony\Component\Serializer\SerializerInterface;

final class GetCustomerByUuidController extends AbstractController
{
    public function __construct(private readonly CommandBus $commandBus)
    {}

    public function getCustomerByUuid(SerializerInterface $serializer, string $uuid): Response
    {
        $customer = $this->commandBus->handle(new Query(UuidV4::fromString($uuid)));

        if (!$customer) {
            throw new NotFoundHttpException();
        }

        $context = (new ObjectNormalizerContextBuilder())
            ->withGroups('show_customer')
            ->toArray();

        $json = $serializer->serialize($customer, 'json', $context);

        return new Response($json, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }
}