<?php
declare(strict_types=1);

namespace BookMe\Tests;

use Exception;
use BookMe\ReservationStatus;
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
        $this->reservationService->markAsConfirmed($this->reservation);
        $this->assertEquals(ReservationStatus::Confirmed, $this->reservation->get_status());
    }

    /**
     * @test
     * @throws Exception
     */
    public function shouldCatchDoubleConfirmation(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->reservationService->markAsConfirmed($this->reservation);
        $this->reservationService->markAsConfirmed($this->reservation);
    }

    /**
     * @test
     * @throws Exception
     */
    public function shouldFlagAsRejected(): void {
        $this->reservationService->markAsRejected($this->reservation);
        $this->assertEquals(ReservationStatus::Rejected, $this->reservation->get_status());
    }

    /**
     * @test
     * @throws Exception
     */
    public function shouldFlagAsPaid(): void {
        $this->reservationService->markAsConfirmed($this->reservation);
        $this->reservationService->markAsPaid($this->reservation);
        $this->assertEquals(ReservationStatus::Paid, $this->reservation->get_status());
    }

    /**
     * @test
     * @throws Exception
     */
    public function shouldPreventToFlagRejectedAsPaid(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->reservationService->markAsRejected($this->reservation);
        $this->reservationService->markAsRejected($this->reservation);
    }

    /**
     * @test
     * @throws Exception
     */
    public function shouldEndReservation(): void {
        $this->reservationService->markAsConfirmed($this->reservation);
        $this->reservationService->markAsPaid($this->reservation);
        $this->reservationService->markAsEnded($this->reservation);
        $this->assertEquals(ReservationStatus::Ended, $this->reservation->get_status());
    }

    /**
     * @throws Exception
     */
    public function shouldCancelReservation(): void {
        $this->reservationService->markAsConfirmed($this->reservation);
        $this->reservationService->markAsCanceled($this->reservation);
        $this->assertEquals(ReservationStatus::Canceled, $this->reservation->get_status());
    }
}
