<?php

declare(strict_types=1);

namespace Huppys\BookMe;

use DateTimeImmutable;
use Exception;
use InvalidArgumentException;

class Reservation implements Buildable {

    private DateTimeImmutable $_checkInDate;
    private DateTimeImmutable $_checkOutDate;
    private Bookable $_bookableEntity;
    private ReservationStatus $_status;
    private float $_costsInclTaxes = 0;

    function __construct(DateTimeImmutable $checkInDate, DateTimeImmutable $checkOutDate, Bookable $bookableEntity) {

        if (!$this->checkInDateIsBeforeCheckOutDate($checkInDate, $checkOutDate)) {
            throw new InvalidArgumentException("Check-in date is not after Check-out date");
        }

        $this->_checkInDate = $checkInDate;
        $this->_checkOutDate = $checkOutDate;
        $this->_bookableEntity = $bookableEntity;
        $this->_status = ReservationStatus::Created;
    }

    /**
     * @throws Exception
     */
    public function markAsConfirmed(): void {
        if ($this->get_status() == ReservationStatus::Created) {
            $this->set_status(ReservationStatus::Confirmed);
        } else {
            throw new InvalidArgumentException("Unexpected value for reservation status");
        }
    }

    /**
     * @throws Exception
     */
    public function markAsRejected(): void {
        if ($this->_status == ReservationStatus::Created) {
            $this->set_status(ReservationStatus::Rejected);
        } else {
            throw new InvalidArgumentException("Unexpected value for reservation status");
        }
    }

    /**
     * @throws Exception
     */
    public function markAsEnded(): void {
        if ($this->_status == ReservationStatus::Paid) {
            $this->set_status(ReservationStatus::Ended);
        } else {
            throw new InvalidArgumentException("Unexpected value for reservation status");
        }
    }

    /**
     * @throws Exception
     */
    public function markAsPaid(): void {
        if ($this->_status == ReservationStatus::Confirmed) {
            $this->set_status(ReservationStatus::Paid);
        } else {
            throw new InvalidArgumentException("Unexpected value for reservation status");
        }
    }

    /**
     * @return DateTimeImmutable
     */
    function get_checkInDate(): DateTimeImmutable {
        return $this->_checkInDate;
    }

    /**
     * @return DateTimeImmutable
     */
    function get_checkOutDate(): DateTimeImmutable {
        return $this->_checkOutDate;
    }

    /**
     * @return Bookable
     */
    function get_bookableEntity(): Bookable {
        return $this->_bookableEntity;
    }

    /**
     * @return ReservationStatus
     */
    public function get_status(): ReservationStatus {
        return $this->_status;
    }

    /**
     * @param ReservationStatus $status
     */
    public function set_status(ReservationStatus $status): void {
        $this->_status = $status;
    }

    /**
     * Calculate costs for the reservation
     * @return float
     * @throws Exception
     */
    public function calculateCosts(): float {
        if ($this->_costsInclTaxes == 0) {
            $this->_costsInclTaxes = $this->_bookableEntity->calculateCosts($this->_checkInDate, $this->_checkOutDate);
        }

        return $this->_costsInclTaxes;
    }

    /**
     * @return bool
     */
    public function checkInDateIsBeforeCheckOutDate(DateTimeImmutable $checkInDate, DateTimeImmutable $checkOutDate): bool {
        return $checkInDate->getTimestamp() < $checkOutDate->getTimestamp();
    }
}