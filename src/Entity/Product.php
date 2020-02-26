<?php

declare(strict_types=1);

namespace Recruitment\Entity;

use Recruitment\Entity\Exception\InvalidUnitPriceException;
use Recruitment\Entity\Exception\InvalidTaxRateException;
use InvalidArgumentException;

class Product
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $unitPrice;

    /**
     * @var int
     */
    private $minimumQuantity = 1;

    /**
     * @var int
     */
    private $tax;

    /**
     * @param int $id
     * @return Product
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
     * @param int $tax
     * @return Product
     * @throws InvalidTaxRateException
     */
    public function setTax(int $tax): self
    {
        if (!in_array($tax, [0, 5, 8, 23], true)) {
            throw new InvalidTaxRateException('Invalid unit price');
        }
        $this->tax = $tax;
        return $this;
    }

    /**
     * @return int
     */
    public function getTax(): int
    {
        return (int) $this->tax;
    }

    /**
     * @param int $price
     * @return Product
     * @throws InvalidUnitPriceException
     */
    public function setUnitPrice(int $price): self
    {
        if ($price < 1) {
            throw new InvalidUnitPriceException('Invalid unit price');
        }
        $this->unitPrice = $price;
        return $this;
    }

    /**
     * @return int
     */
    public function getUnitPrice(): int
    {
        return (int) $this->unitPrice;
    }

    /**
     * @return float
     */
    public function getUnitGrossPrice(): float
    {
        $taxRate = $this->getTax();
        if ($taxRate === 0) {
            return round($this->getUnitPrice(), 2);
        }
        $tax = round($this->getUnitPrice() * ($taxRate / 100), 2);
        return round($this->getUnitPrice() + $tax,2);
    }

    /**
     * @param int $minimumQuantity
     * @return Product
     */
    public function setMinimumQuantity(int $minimumQuantity): self
    {
        if ($minimumQuantity < 1) {
            throw new InvalidArgumentException('Invalid minimum quantity');
        }
        $this->minimumQuantity = $minimumQuantity;
        return $this;
    }

    /**
     * @return int
     */
    public function getMinimumQuantity(): int
    {
        return (int) $this->minimumQuantity;
    }
}
