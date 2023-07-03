<?php

namespace App\Entity;

use App\Repository\CurrenciesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CurrenciesRepository::class)]
class Currencies
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $currencyName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $code = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mid = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCurrencyName(): ?string
    {
        return $this->currencyName;
    }

    public function setCurrencyName(?string $currencyName): static
    {
        $this->currencyName = $currencyName;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getMid(): ?string
    {
        return $this->mid;
    }

    public function setMid(?string $mid): static
    {
        $this->mid = $mid;

        return $this;
    }
}
