<?php

declare(strict_types=1);

use Huppys\BookMe\Address;
use PHPUnit\Framework\TestCase;
use Huppys\BookMe\Bookable;

final class BookableTest extends TestCase {
    private Bookable $_bookable;
    private string $_bookableTitle;

    public function setUp(): void {
        $this->_bookableTitle = "Ferienhaus Seepferdchen";
        $this->_bookable = new Bookable(1, $this->_bookableTitle);
    }

    public function testBookableExists(): void {
        $this->assertInstanceOf(Bookable::class, $this->_bookable);
    }

    public function testBookableHasRooms(): void {
        $this->assertIsArray($this->_bookable->get_rooms());
    }

    public function testBookableHasAddress(): void {
        $address = new Address("Berlin", "Lange Straße", "44", "10409");
        $this->_bookable->set_address($address);
        $this->assertInstanceOf(Address::class, $this->_bookable->get_address());
    }

    public function testBookableHasTitle(): void {
        $this->assertEquals($this->_bookableTitle, $this->_bookable->get_title());
    }
}
