<?php
declare(strict_types=1);

namespace Huppys\BookMe\tests;


use Error;
use Exception;
use Huppys\BookMe\ReservationStatus;

class ReservationTest extends ReservationBaseTest {

    /**
     * @test
     * @return void
     */
    public function shouldSetCheckInDate(): void {
        $this->assertEquals($this->checkInDate, $this->reservation->get_checkInDate());
    }

    /**
     * @test
     * @return void
     */
    public function shouldSetCheckOutDate(): void {
        $this->assertEquals($this->checkOutDate, $this->reservation->get_checkOutDate());
    }

    /**
     * @test
     * @return void
     */
    public function shouldSetBookableEntity(): void {
        $this->assertEquals($this->bookableEntity, $this->reservation->get_bookableEntity());
    }

    /**
     * @test
     * @return void
     */
    public function shouldCreateReservationAsCreated(): void {
        $this->assertEquals(ReservationStatus::Created, $this->reservation->get_status());
    }

    /**
     * @test
     * @return void
     */
    public function shouldCheckReservationLifecycle(): void {
        $this->assertTrue($this->reservation->isRequestValid());
    }

    /**
     * @test
     * @throws Exception
     */
    public function shouldFlagReservationAsConfirmed(): void {
        $this->reservation->markAsConfirmed();
        $this->assertEquals(ReservationStatus::Confirmed, $this->reservation->get_status());
    }

    /**
     * @test
     * @throws Exception
     */
    public function shouldCatchDoubleConfirmation(): void {
        $this->assertNull($this->reservation->markAsConfirmed());
        $this->assertInstanceOf(Error::class, $this->reservation->markAsConfirmed());
    }

    /**
     * @test
     * @throws Exception
     */
    public function shouldFlagAsRejected(): void {
        $this->reservation->markAsRejected();
        $this->assertEquals(ReservationStatus::Rejected, $this->reservation->get_status());
    }

    /**
     * @test
     * @throws Exception
     */
    public function shouldFlagAsPaid(): void {
        $this->reservation->markAsConfirmed();
        $this->reservation->markAsPaid();
        $this->assertEquals(ReservationStatus::Paid, $this->reservation->get_status());
    }

    /**
     * @test
     * @throws Exception
     */
    public function shouldPreventToFlagRejectedAsPaid(): void {
        $this->reservation->markAsRejected();
        $this->assertInstanceOf(Error::class, $this->reservation->markAsPaid());
    }

    /**
     * @test
     * @throws Exception
     */
    public function shouldEndReservation(): void {
        $this->reservation->markAsConfirmed();
        $this->reservation->markAsPaid();
        $this->reservation->markAsEnded();
        $this->assertEquals(ReservationStatus::Ended, $this->reservation->get_status());
    }
}
