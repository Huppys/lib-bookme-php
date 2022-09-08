<?php

declare(strict_types=1);

use Huppys\BookMe\Address;
use Huppys\BookMe\Bookable;
use Huppys\BookMe\ReservationBaseTest;

final class BookableTest extends ReservationBaseTest {

    public function testBookableExists(): void {
        $this->assertInstanceOf(Bookable::class, $this->bookableEntity);
    }

    public function testBookableHasRooms(): void {
        $this->assertIsArray($this->bookableEntity->get_rooms());
    }

    public function testBookableHasAddress(): void {
        $address = new Address("Berlin", "Lange Straße", "44", "10409");
        $this->bookableEntity->set_address($address);
        $this->assertInstanceOf(Address::class, $this->bookableEntity->get_address());
    }

    public function testBookableHasTitle(): void {
        $this->assertEquals($this->_bookableTitle, $this->bookableEntity->get_title());
    }

    public function testBookableHasPrice(): void {
        $this->assertNotNull($this->bookableEntity->get_price());
    }

    public function testBookableHasTariff(): void {
        $this->assertIsArray($this->bookableEntity->get_tariffs());
    }
}
