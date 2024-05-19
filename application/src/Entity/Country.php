<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class Country
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank]
    #[Groups(['show_country'])]
    private string $name;

    #[ORM\Column(length: 36, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Uuid]
    #[Groups(['show_country'])]
    private string $uuid;

    #[ORM\Column(length: 2, unique: true)]
    #[Assert\NotBlank]
    #[Groups(['show_country'])]
    private string $countryCode;

    public function id(): ?int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function uuid(): string
    {
        return $this->uuid;
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

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function setCountryCode(string $countryCode): self
    {
        $this->countryCode = $countryCode;

        return $this;
    }
}