<?php

declare(strict_types=1);

namespace Recruitment\Entity;

use Recruitment\Entity\Exception\InvalidUnitPriceException;
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
