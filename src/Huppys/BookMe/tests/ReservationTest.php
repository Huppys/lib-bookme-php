<?php
declare(strict_types=1);

namespace Huppys\BookMe\tests;

use Exception;
use Huppys\BookMe\ReservationStatus;
use InvalidArgumentException;

final class ReservationTest extends ReservationBaseTest {

    /**
     * @test
     * @return void
     */
    public function shouldCreateReservationAsCreated(): void {
        $this->assertEquals(ReservationStatus::Created, $this->reservation->get_status());
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
        $this->expectException(InvalidArgumentException::class);
        $this->reservation->markAsConfirmed();
        $this->reservation->markAsConfirmed();
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
        $this->expectException(InvalidArgumentException::class);
        $this->reservation->markAsRejected();
        $this->reservation->markAsRejected();
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

    /**
     * @throws Exception
     */
    public function shouldCancelReservation(): void {
        $this->reservation->markAsConfirmed();
        $this->reservation->markAsCanceled();
        $this->assertEquals(ReservationStatus::Canceled, $this->reservation->get_status());

    }
}
