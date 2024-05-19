<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\UniqueConstraint(
    name: 'tax_identification_number_country_code_idx',
    columns: ['tax_identification_number', 'country_id']
)]
class Customer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['show_customer'])]
    private string $name;

    #[ORM\Column(length: 36)]
    #[Assert\NotBlank]
    #[Assert\Uuid]
    #[Groups(['show_customer'])]
    private string $uuid;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank]
    #[Groups(['show_customer'])]
    private string $taxIdentificationNumber;

    #[ManyToOne(targetEntity: Country::class, inversedBy: 'customer')]
    #[Groups(['show_customer'])]
    private Country $country;

    public function id(): ?int
    {
        return $this->id;
    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function taxIdentificationNumber(): string
    {
        return $this->taxIdentificationNumber;
    }

    public function country(): Country
    {
        return $this->country;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
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

    public function setCountry(Country $country): self
    {
        $this->country = $country;

        return $this;
    }
}
