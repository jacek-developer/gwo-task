<?php

declare(strict_types=1);

namespace Recruitment\Entity;

use Recruitment\Cart\Item;

class Order
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var array
     */
    private $items = [];

    /**
     * @param int $id
     * @return Order
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return (int) $this->id;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return (array) $this->items;
    }

    /**
     * @param array $items
     * @return Order
     */
    public function setItems(array $items): self
    {
        $this->items = $items;
        return $this;
    }

    /**
     * @return array
     */
    public function getDataForView(): array
    {
        $output                         = [];
        $output['id']                   = $this->getId();
        $output['items']                = [];
        $output['total_price']          = 0;
        $output['total_price_gross']    = 0.00;
        /** @var $item Item */
        foreach ($this->items as $item) {
            $output['items'][] = [
                'id'                    => $item->getProduct()->getId(),
                'quantity'              => $item->getQuantity(),
                'total_price'           => $item->getTotalPrice(),
                'total_price_gross'     => $item->getTotalGrossPrice(),
                'tax'                   => (string) $item->getProduct()->getTax() . '%'
            ];
            $output['total_price']          += $item->getTotalPrice();
            $output['total_price_gross']    += $item->getTotalGrossPrice();
        }
        return $output;
    }
}
