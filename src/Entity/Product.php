<?php

declare(strict_types=1);

namespace Recruitment\Entity;

use Recruitment\Entity\Exception\InvalidUnitPriceException;

class Product
{
    /**
     * ID of product.
     *
     * @var int
     */
    private $id;

    /**
     * Product name.
     *
     * @var string
     */
    private $name;

    /**
     * Product unit price presented in 0,01 PLN.
     *
     * @var int
     */
    private $unitPrice;

    /**
     * Minimum quantity of product.
     *
     * @var int
     */
    private $minimumQuantity;

    /**
     * @param int    $id              ID of product
     * @param string $name            Product name
     * @param int    $unitPrice       Product unit price
     * @param int    $minimumQuantity Minimum quantity of product in order
     */
    public function __construct(
        ?int $id = null,
        ?string $name = null,
        ?int $unitPrice = null,
        int $minimumQuantity = 1
    ) {
        $this->setId($id)
            ->setName($name)
            ->setUnitPrice($unitPrice)
            ->setMinimumQuantity($minimumQuantity);
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @throws InvalidUnitPriceException When $unitPrice is less than 1
     */
    public function setUnitPrice(?int $unitPrice): self
    {
        if (\is_int($unitPrice) && 1 > $unitPrice) {
            $msg = "Cena produktu nie może być mniejsza niż 1 grosz.";
            throw new InvalidUnitPriceException($msg);
        }
        $this->unitPrice = $unitPrice;

        return $this;
    }

    public function getUnitPrice(): ?int
    {
        return $this->unitPrice;
    }

    /**
     * @throws \InvalidArgumentException When $minimumQuantity is less than 1
     */
    public function setMinimumQuantity(int $minimumQuantity): self
    {
        if (1 > $minimumQuantity) {
            $msg = "Minimalna ilość produktów w zamówieniu nie może być mniejsza niż 1.";
            throw new \InvalidArgumentException($msg);
        }
        $this->minimumQuantity = $minimumQuantity;

        return $this;
    }

    public function getMinimumQuantity(): int
    {
        return $this->minimumQuantity;
    }
}
