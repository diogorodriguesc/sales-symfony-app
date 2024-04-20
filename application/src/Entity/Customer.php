<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
#[ORM\UniqueConstraint(
    name: 'tax_identification_number_country_code_idx',
    columns: ['tax_identification_number', 'country_code']
)]
class Customer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private string $name;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank]
    private string $taxIdentificationNumber;

    #[ORM\Column(length: 2)]
    #[Assert\NotBlank]
    private string $countryCode;

    public function id(): ?int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function taxIdentificationNumber(): string
    {
        return $this->taxIdentificationNumber;
    }

    public function countryCode(): string
    {
        return $this->countryCode;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setTaxIdentificationNumber(string $taxIdentificationNumber): self
    {
        $this->taxIdentificationNumber = $taxIdentificationNumber;

        return $this;
    }

    public function setCountryCode(string $countryCode): self
    {
        $this->countryCode = $countryCode;

        return $this;
    }
}
