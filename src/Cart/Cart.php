<?php

declare(strict_types=1);

namespace Recruitment\Cart;

use Recruitment\Entity\Order;
use Recruitment\Entity\Product;

final class Cart
{
    /**
     * @var array
     */
    private $items = [];

    /**
     * @param Product $product
     * @param int $quantity
     * @return Cart
     * @throws Exception\QuantityTooLowException
     */
    public function addProduct(Product $product, int $quantity = 1): self
    {
        $found = false;
        /** @var $item Item */
        foreach ($this->items as &$item) {
            if ($item->getProduct() === $product) {
                $item->setQuantity($item->getQuantity() + $quantity);
                $found = true;
                break;
            }
        }
        if (false === $found) {
            $this->items[] = new Item($product, $quantity);
        }
        return $this;
    }

    /**
     * @param Product $product
     * @param int $quantity
     * @return Cart
     * @throws Exception\QuantityTooLowException
     */
    public function setQuantity(Product $product, int $quantity): self
    {
        $found = false;
        /** @var $item Item */
        foreach ($this->items as &$item) {
            if ($item->getProduct() === $product) {
                $item->setQuantity($quantity);
                $found = true;
                break;
            }
        }
        if (false === $found) {
            $this->addProduct($product, $quantity);
        }
        return $this;
    }

    /**
     * @param Product $product
     */
    public function removeProduct(Product $product): void
    {
        $filteredItems = array_filter($this->items, function($el) use ($product){
            /** @var $el Item */
            return $el->getProduct() !== $product;
        });
        $this->items = array_values($filteredItems);
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return (array) $this->items;
    }

    /**
     * @param int $index
     * @return Item
     */
    public function getItem(int $index): Item
    {
        if (!array_key_exists($index, $this->items)) {
            throw new \OutOfBoundsException('Index unvailable');
        }
        return $this->items[$index];
    }

    /**
     * @return int
     */
    public function getTotalPrice(): int
    {
        $totalPrice = 0;
        /** @var $item Item */
        foreach ($this->items as $item) {
            $totalPrice += $item->getTotalPrice();
        }

        return $totalPrice;
    }

    /**
     * @param int $orderId
     * @return Order
     */
    public function checkout(int $orderId): Order
    {
        $order = new Order();
        $order
            ->setId($orderId)
            ->setItems($this->items)
        ;
        $this->items = [];
        return $order;
    }
}
