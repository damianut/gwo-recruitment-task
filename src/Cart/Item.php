<?php

declare(strict_types=1);

namespace Recruitment\Cart;

use Recruitment\Cart\Exception\QuantityTooLowException;
use Recruitment\Entity\Product;

class Item
{
    /**
     * Product assigned to given Item in Cart.
     *
     * @var Product
     */
    private $product;

    /**
     * Quantity of product.
     *
     * @var int
     */
    private $quantity;

    /**
     * @param Product $product
     * @param int     $quantity
     */
    public function __construct(Product $product, int $quantity)
    {
        $this->setProduct($product);
        $this->setQuantity($quantity);
    }

    /**
     * Set Product in Item
     *
     * @param Product $product
     *
     * @return self
     */
    public function setProduct(Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get Product of Item.
     *
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @throws QuantityTooLowException When $quantity is less than $this->product->minimumQuantity
     */
    public function setQuantity(?int $quantity): self
    {
        if (\is_int($quantity) && $this->product->getMinimumQuantity() > $quantity) {
            $msg = "Należy zamówić minimalnie ".$this->product->getMinimumQuantity()." sztuk produktu.";
            throw new QuantityTooLowException($msg);
        }
        $this->quantity = $quantity;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * Price of product multiplied by quantity.
     *
     * @return int Price presented in 0,01 PLN
     */
    public function getTotalPrice(): int
    {
        return $this->quantity * $this->product->getUnitPrice();
    }
}
