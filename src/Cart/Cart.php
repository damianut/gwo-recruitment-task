<?php

declare(strict_types=1);

namespace Recruitment\Cart;

use Recruitment\Cart\Item;
use Recruitment\Entity\Order;
use Recruitment\Entity\Product;

class Cart
{
    /**
     * Collection of items.
     *
     * @var Array
     */
    private $items;

    public function __construct()
    {
        $this->items = [];
    }

    /**
     * Add Product to existing Item or create Item and add Product to him.
     *
     * @param Product $product
     * @param int     $quantity Quantity of products
     */
    public function addProduct(Product $product, int $quantity = 1): self
    {
        $itemsLen = count($this->items);
        for ($i = 0; $i < $itemsLen; $i++) {
            if ($product === $this->items[$i]->getProduct()) {
                $this->items[$i]->setQuantity($this->items[$i]->getQuantity() + $quantity);
                $i = $itemsLen + 1;
            }
        }
        if ($i === $itemsLen) {
            $this->items[] = new Item($product, $quantity);
        }

        return $this;
    }

    /**
     * Set quantity of given product.
     *
     * @param Product $product
     * @param int     $quantity Quantity of products
     */
    public function setQuantity(Product $product, int $quantity): self
    {
        $itemsLen = count($this->items);
        for ($i = 0; $i < $itemsLen; $i++) {
            if ($product === $this->items[$i]->getProduct()) {
                $this->items[$i]->setQuantity($quantity);
                $i = $itemsLen + 1;
            }
        }

        if ($i === $itemsLen) {
            $this->items[] = new Item($product, $quantity);
        }

        return $this;
    }

    /**
     * Remove Product if exists in Item from $items
     *
     * @param Product $product
     */
    public function removeProduct(Product $product)
    {
        $itemsLen = count($this->items);
        for ($i = 0; $i < $itemsLen; $i++) {
            if ($product === $this->items[$i]->getProduct()) {
                \array_splice($this->items, $i, 1);
                $i = $itemsLen;
            }
        }
    }

    /**
     * Get array of items
     *
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * Get Item specified by position on array
     *
     * @param  int  $position
     *
     * @return Item
     */
    public function getItem(int $position): Item
    {
        if (count($this->items) <= $position || 0 > $position) {
            $msg = "Próbujesz pobrać element; który nie istnieje.";
            throw new \OutOfBoundsException($msg);
        }

        return $this->items[$position];
    }

    /**
     * Get total price of all items
     *
     * @return int Price presented in 0,01 PLN
     */
    public function getTotalPrice(): int
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->getTotalPrice();
        }

        return $total;
    }

    /**
     * Get total gross price of all items
     *
     * @return int Gross price presented in 0,01 PLN
     */
    public function getTotalPriceGross(): int
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->getTotalPriceGross();
        }

        return $total;
    }

    /**
     * Create Order and clear Cart
     *
     * @param  int $id
     *
     * @return Order
     */
    public function checkout(int $id): Order
    {
        $order = new Order($id, $this->items);
        $this->items = [];

        return $order;
    }
}
