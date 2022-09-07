<?php

declare(strict_types=1);

use Huppys\BookMe\Bookable;
use Huppys\BookMe\Reservation;
use Huppys\BookMe\ReservationStatus;
use PHPUnit\Framework\TestCase;

final class ReservationTest extends TestCase {
    private Reservation $reservation;
    private DateTime $checkInDate;
    private DateTime $checkOutDate;
    private Bookable $bookableEntity;

    public function setUp(): void {
        $this->checkInDate = new DateTime();
        $this->checkOutDate = new DateTime();
        $this->bookableEntity = new Bookable(1, 1.0, "Ferienhaus Seepferdchen");
        $this->reservation = new Reservation($this->checkInDate, $this->checkOutDate, $this->bookableEntity);
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

    /**
     * @throws Exception
     */
    public function testReservationHasConfirmedStatus(): void {
        $this->reservation->markAsConfirmed();
        $this->assertEquals(ReservationStatus::Confirmed, $this->reservation->get_status());
    }

    /**
     * @throws Exception
     */
    public function testReservationCannotBeConfirmedTwice(): void {
        $this->assertNull($this->reservation->markAsConfirmed());
        $this->assertInstanceOf(Error::class, $this->reservation->markAsConfirmed());
    }

    /**
     * @throws Exception
     */
    public function testReservationIsRejectedAfterRejection(): void {
        $this->reservation->markAsRejected();
        $this->assertEquals(ReservationStatus::Rejected, $this->reservation->get_status());
    }

    /**
     * @throws Exception
     */
    public function testReservationIsPaid(): void {
        $this->reservation->markAsConfirmed();
        $this->reservation->markAsPaid();
        $this->assertEquals(ReservationStatus::Paid, $this->reservation->get_status());
    }

    public function testRejectedReservationCannotBePaid(): void {
        $this->reservation->markAsRejected();
        $this->assertInstanceOf(Error::class, $this->reservation->markAsPaid());
    }

    public function testReservationHasEnded(): void {
        $this->reservation->markAsConfirmed();
        $this->reservation->markAsPaid();
        $this->reservation->markAsEnded();
        $this->assertEquals(ReservationStatus::Ended, $this->reservation->get_status());
    }
}
