<?php

declare(strict_types=1);

namespace Huppys\BookMe\tests;


use Error;
use Exception;
use Huppys\BookMe\ReservationStatus;

class ReservationTest extends ReservationBaseTest {


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

    public function testReservationRequestIsValid(): void {
        $this->assertTrue($this->reservation->isRequestValid());
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

    /**
     * @throws Exception
     */
    public function testRejectedReservationCannotBePaid(): void {
        $this->reservation->markAsRejected();
        $this->assertInstanceOf(Error::class, $this->reservation->markAsPaid());
    }

    /**
     * @throws Exception
     */
    public function testReservationHasEnded(): void {
        $this->reservation->markAsConfirmed();
        $this->reservation->markAsPaid();
        $this->reservation->markAsEnded();
        $this->assertEquals(ReservationStatus::Ended, $this->reservation->get_status());
    }
}
