<?php

declare(strict_types=1);

namespace Recruitment\Cart;

use Recruitment\Entity\{Order, Product};
use Recruitment\Utilities\Collection\ArrayCollection;
use function array_keys;
use function is_null;
use function count;

class Cart
{
    /**
     * Array of items.
     *
     * @var ArrayCollection
     */
    private $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    /**
     * Add Product to existing Item or create Item and add Product to him.
     *
     * @param Product $product
     * @param int     $quantity Quantity of products
     */
    public function addProduct(Product $product, int $quantity = 1): self
    {
        $key = $this->getItemKeyByProduct($product);
        if (!is_null($key)) {
            $item = $this->items->get($key);
            $item->setQuantity($item->getQuantity() + $quantity);
            $this->items->set($key, $item);
        } else {
            $this->items->add(new Item($product, $quantity));
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
        $key = $this->getItemKeyByProduct($product);
        if (!is_null($key)) {
            $item = $this->items->get($key)->setQuantity($quantity);
            $this->items->set($key, $item);
        } else {
            $this->items->add(new Item($product, $quantity));
        }

        return $this;
    }

    /**
     * Remove Product if exists in Item from $this->items.
     *
     * @param Product $product
     */
    public function removeProduct(Product $product)
    {
        $key = $this->getItemKeyByProduct($product);
        if (!is_null($key)) {
            $this->items->remove($key);
        }
    }

    /**
     * Get key of Item from $this->items depends on Product.
     * 
     * @param  Product $product Product which should belongs to Item
     * @return Item key if exists, null otherwise
     */
    public function getItemKeyByProduct(Product $product)
    {
        $itemsWithProduct = $this->items->filter(function (Item $item, Product $product) {
            return $product === $item->getProduct();
        }, $product);

        $keys = array_keys($itemsWithProduct);

        return 0 != count($keys) ? $keys[0] : null;
    }

    /**
     * Get array of items.
     *
     * @return array
     */
    public function getItems(): array
    {
        return $this->items->toArray();
    }

    /**
     * Get Item specified by position on array.
     *
     * @param  int  $position
     *
     * @return Item
     */
    public function getItem(int $position): Item
    {
        if ($this->items->count() <= $position || 0 > $position) {
            $msg = "Próbujesz pobrać element; który nie istnieje.";
            throw new \OutOfBoundsException($msg);
        }

        return $this->items->get($position);
    }

    /**
     * Total price of all items.
     *
     * @return int Price presented in 0,01 PLN
     */
    public function getTotalPrice(): int
    {
        $total = 0;
        $items = $this->items->toArray();
        foreach ($items as $item) {
            $total += $item->getTotalPrice();
        }

        return $total;
    }

    /**
     * Create Order and clear Cart from items.
     *
     * @param  int $id
     *
     * @return Order
     */
    public function checkout(int $id): Order
    {
        $order = new Order($id, $this->items->toArray());
        $this->items->clear();

        return $order;
    }
}
