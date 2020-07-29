<?php

declare(strict_types=1);

namespace Recruitment\Entity;

use Recruitment\Cart\Cart;

class Order
{
    /**
     * ID of Order
     *
     * @var int
     */
    private $id;

    /**
     * Ordered Items retrieved from Cart.
     *
     * @var array
     */
    private $items;

    public function __construct(int $id, array $items)
    {
        $this->id = $id;
        $this->items = $items;
    }

    /**
     * Prepare data for view (view understood as in architectural pattern MVC)
     *
     * @return array
     */
    public function getDataForView(): array
    {
        $itemsView = [];
        $totalPrice = 0;
        $totalPriceGross = 0;
        foreach ($this->items as $item) {
            $itemTotalPrice = $item->getTotalPrice();
            $itemTotalPriceGross = $item->getTotalPriceGross();
            $itemsView[] = [
                'id' => $item->getProduct()->getId(),
                'quantity' => $item->getQuantity(),
                'tax' => $item->getProduct()->getTax(),
                'total_price' => $itemTotalPrice,
                'total_price_gross' => $itemTotalPriceGross,
            ];
            $totalPrice += $itemTotalPrice;
            $totalPriceGross += $itemTotalPriceGross;
        }

        return [
            'id' => $this->id,
            'items' => $itemsView,
            'total_price' => $totalPrice,
            'total_price_gross' => $totalPriceGross,
        ];
    }
}
