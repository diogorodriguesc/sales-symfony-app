<?php
declare(strict_types=1);

namespace App\UseCase\Command\CreateCustomer;

use App\UseCase\Command\CreateCustomer\Exception\InvalidArgumentsException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final readonly class Command
{
    #[Assert\NotBlank]
    public string $name;

    #[Assert\NotBlank]
    public string $taxIdentificationNumber;

    #[Assert\NotBlank]
    public string $countryCode;

    private function __construct(string $name, string $taxIdentificationNumber, string $countryCode)
    {
        $this->name = $name;
        $this->taxIdentificationNumber = $taxIdentificationNumber;
        $this->countryCode = $countryCode;
    }

    /**
     * @throws InvalidArgumentsException
     */
    public static function buildFromRequest(Request $request, ValidatorInterface $validator): self
    {
        $params = $request->getPayload()->all();

        $self = new self(
            $params['name'] ?? '',
            $params['taxIdentificationNumber'] ?? '',
            $params['countryCode'] ?? ''
        );

        if (($errors = $validator->validate($self)) && count($errors) > 0) {
            $errorFields = [];
            foreach ($errors as $error) {
                $errorFields[] = [
                    'field' => $error->getPropertyPath(),
                    'message' => $error->getMessage(),
                ];
            }

            throw new InvalidArgumentsException($errorFields);
        }

        return $self;
    }
}