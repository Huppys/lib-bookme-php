<?php declare(strict_types=1);

namespace Huppys\BookMe;


class Bookable {
    private int $_id;
    private string $_title;
    private array $_rooms = [Room::class];
    private Address $_address;
    private float $_price;
    private float $_taxAmount;
    private array $_tariffs;

    function __construct(int $id, float $price, float $taxAmount, array $tariffs, string $title = "") {
        $this->_id = $id;
        $this->_title = $title;
        $this->_price = $price;
        $this->_taxAmount = $taxAmount;
        $this->_tariffs = $tariffs;
    }

    /**
     * @return int
     */
    function get_id(): int {
        return $this->_id;
    }

    /**
     * @return array
     */
    function get_rooms(): array {
        return $this->_rooms;
    }

    /**
     * @return Address
     */
    public function get_address(): Address {
        return $this->_address;
    }

    /**
     * @param Address $address
     */
    public function set_address(Address $address): void {
        $this->_address = $address;
    }

    /**
     * @return string
     */
    public function get_title(): string {
        return $this->_title;
    }

    /**
     * @return float
     */
    public function get_price(): float {
        return $this->_price;
    }

    /**
     * @return float
     */
    public function get_taxAmount(): float {
        return $this->_taxAmount;
    }

    /**
     * Returns price incl. taxes
     * @return float
     */
    public function get_priceInclTaxes(): float {
        return (1 + ($this->_taxAmount / 100.0)) * $this->_price;
    }

    public function calculateCosts($startDate, $endDate): float {
        $dateDiff = $startDate->diff($endDate)->format('%a');
        return (int)$dateDiff * ($this->get_priceInclTaxes());
    }

    public function get_tariffs(): array {
        return $this->_tariffs;
    }
}