<?php

declare(strict_types=1);

namespace Recruitment\Entity;

class Product
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int Product unit price
     */
    private $unitPrice;

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setUnitPrice(int $unitPrice): void
    {
        //Tutaj wyrzuć wyjątek
    }

    public function getUnitPrice(): int
    {
        return $this->unitPrice;
    }
}