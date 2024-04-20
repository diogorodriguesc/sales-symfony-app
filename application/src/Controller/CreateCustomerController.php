<?php
declare(strict_types=1);

namespace App\Controller;

use App\UseCase\Command\CreateCustomer\Command;
use App\UseCase\Command\CreateCustomer\Exception\InvalidArgumentsException;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class CreateCustomerController extends AbstractController
{
    public function __construct(private readonly CommandBus $commandBus)
    {}

    public function createCustomer(Request $request, ValidatorInterface $validator): JsonResponse
    {
        try {
            $this->commandBus->handle(Command::buildFromRequest($request, $validator));
        } catch (InvalidArgumentsException $e) {
            return new JsonResponse(['message' => $e->getMessage(), 'fields' => $e->getErrorFields()], 400);
        }

        return new JsonResponse();
    }
}