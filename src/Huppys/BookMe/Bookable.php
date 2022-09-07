<?php declare(strict_types=1);

namespace Huppys\BookMe;


class Bookable {
    private int $_id;
    private string $_title;
    private array $_rooms = [Room::class];
    private Address $_address;
    private float $_price;

    function __construct(int $id, float $price, string $title = "") {
        $this->_id = $id;
        $this->_title = $title;
        $this->_price = $price;
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
}