<?php
declare(strict_types=1);

namespace App\UseCase\Command\CreateCustomer;

final readonly class CommandHandler
{
    public function __construct(private RepositoryInterface $repository)
    {
    }

    public function handle(Command $command): void
    {
        $this->repository->createCustomer($command);
    }
}