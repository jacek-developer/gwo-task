<?php

declare(strict_types=1);

namespace Recruitment\Cart;

use Recruitment\Cart\Exception\QuantityTooLowException;
use Recruitment\Entity\Product;
use InvalidArgumentException;

final class Item
{
    /**
     * @var Product
     */
    private $product;

    /**
     * @var int
     */
    private $quantity;

    /**
     * @var int
     */
    private static $priceDecimalPrecision = 2;

    /**
     * Item constructor.
     * @param Product $product
     * @param int $quantity
     */
    public function __construct(Product $product, int $quantity)
    {
        $this->product = $product;

        if ($quantity < $this->product->getMinimumQuantity()) {
            throw new InvalidArgumentException('Minimum quantity not valid');
        }

        $this->quantity = $quantity;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product {
        return $this->product;
    }

    /**
     * @return int
     */
    public function getQuantity(): int {
        return (int) $this->quantity;
    }

    /**
     * @return int
     */
    public function getTotalPrice(): int {
        return (int) round($this->quantity * $this->product->getUnitPrice(), 0);
    }

    /**
     * @return float
     */
    public function getTotalGrossPrice(): float
    {
        return round($this->quantity * $this->product->getUnitGrossPrice(), 2);
    }

    /**
     * @param int $quantity
     * @throws QuantityTooLowException
     */
    public function setQuantity(int $quantity): void {
        if ($quantity < $this->product->getMinimumQuantity()) {
            throw new QuantityTooLowException('Minimum quantity not valid');
        }
        $this->quantity = $quantity;
    }
}
