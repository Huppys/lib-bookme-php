<?php

declare(strict_types=1);

use Huppys\BookMe\Reservation;
use Huppys\BookMe\ReservationStatus;
use PHPUnit\Framework\TestCase;
use Huppys\BookMe\Bookable;

final class ReservationTest extends TestCase {
    private Reservation $reservation;
    private DateTime $checkInDate;
    private DateTime $checkOutDate;
    private Bookable $bookableEntity;

    public function setUp(): void {
        $this->checkInDate = new DateTime();
        $this->checkOutDate = new DateTime();
        $this->bookableEntity = new Bookable(1, "Ferienhaus Seepferdchen");
        $this->reservation = new Reservation($this->checkInDate, $this->checkOutDate, $this->bookableEntity);
    }

    public function testReservationExists(): void {
        $this->assertInstanceOf(Reservation::class, $this->reservation);
    }

    public function testReservationHasCheckInAndCheckOutDates(): void {
        $this->assertEquals($this->checkInDate, $this->reservation->get_checkInDate());
        $this->assertEquals($this->checkOutDate, $this->reservation->get_checkOutDate());
    }

    public function testReservationHasBookableEntity(): void {
        $this->assertEquals($this->bookableEntity, $this->reservation->get_bookableEntity());
    }

    public function testReservationHasStateCreated(): void {
        $this->assertEquals(ReservationStatus::Created, $this->reservation->get_status());
    }

    public function testReservationHasConfirmedStatus(): void {
        $this->reservation->confirmReservation();
        $this->assertEquals(ReservationStatus::Confirmed, $this->reservation->get_status());
    }

    public function testReservationCannotBeConfirmedTwice(): void {
        $this->assertNull($this->reservation->confirmReservation());
        $this->assertInstanceOf(Error::class, $this->reservation->confirmReservation());
    }
}
