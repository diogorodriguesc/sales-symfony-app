<?php
declare(strict_types=1);

namespace App\Controller;

use App\UseCase\Command\CreateCustomer\Command;
use App\UseCase\Command\CreateCustomer\Exception\InvalidArgumentsException;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class CreateCustomerController extends AbstractController
{
    public function __construct(private readonly CommandBus $commandBus, private readonly SerializerInterface $serializer)
    {}

    public function __invoke__(Request $request, ValidatorInterface $validator): Response
    {
        try {
            $customer = $this->commandBus->handle(Command::buildFromRequest($request, $validator));

            $context = (new ObjectNormalizerContextBuilder())
                ->withGroups(['show_customer', 'show_country'])
                ->toArray();

            $json = $this->serializer->serialize($customer, 'json', $context);
        } catch (InvalidArgumentsException $e) {
            return new JsonResponse(['message' => $e->getMessage(), 'fields' => $e->getErrorFields()], 400);
        }

        return new Response($json, Response::HTTP_CREATED, ['Content-Type' => 'application/json']);
    }
}