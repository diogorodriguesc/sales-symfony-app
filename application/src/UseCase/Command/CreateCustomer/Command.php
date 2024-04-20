<?php
declare(strict_types=1);

namespace App\UseCase\Command\CreateCustomer;

use App\Entity\Customer;
use App\UseCase\Command\CreateCustomer\Exception\InvalidArgumentsException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final readonly class Command
{
    public function __construct(public string $name, public string $taxIdentificationNumber, public string $countryCode)
    {
    }

    /**
     * @throws InvalidArgumentsException
     */
    public static function buildFromRequest(Request $request, ValidatorInterface $validator): self
    {
        $params = $request->getPayload()->all();

        $customer = new Customer();
        $customer->setName($params['name'] ?? '');
        $customer->setTaxIdentificationNumber($params['taxIdentificationNumber'] ?? '');
        $customer->setCountryCode(strtoupper($params['countryCode'] ?? ''));

        if (($errors = $validator->validate($customer)) && count($errors) > 0) {
            $errorFields = [];
            foreach ($errors as $error) {
                $errorFields[] = [
                    'field' => $error->getPropertyPath(),
                    'message' => $error->getMessage(),
                ];
            }

            throw new InvalidArgumentsException($errorFields);
        }

        return new self($customer->name(), $customer->taxIdentificationNumber(), $customer->countryCode());
    }
}