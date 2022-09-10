<?php

declare(strict_types=1);

namespace Huppys\BookMe;

use DateTimeImmutable;
use Error;
use Exception;

class Reservation {

    private DateTimeImmutable $_checkInDate;
    private DateTimeImmutable $_checkOutDate;
    private Bookable $_bookableEntity;
    private ReservationStatus $_status;
    private float $_costsInclTaxes = 0;

    function __construct(DateTimeImmutable $checkInDate, DateTimeImmutable $checkOutDate, Bookable $bookableEntity) {
        // TODO: Validate checkInDate and checkOutDate
        $this->_checkInDate = $checkInDate;
        $this->_checkOutDate = $checkOutDate;
        $this->_bookableEntity = $bookableEntity;
        $this->_status = ReservationStatus::Created;
    }

    /**
     * @throws Exception
     */
    public function markAsConfirmed(): ?Error {

        if ($this->isRequestValid()) {
            $this->set_status(ReservationStatus::Confirmed);
        } else {
            return new Error("Unexpected value for reservation status");
        }

        return null;
    }

    /**
     * @throws Exception
     */
    public function markAsRejected(): ?Error {
        if ($this->_status == ReservationStatus::Created) {
            $this->set_status(ReservationStatus::Rejected);
        } else {
            return new Error("Unexpected value for reservation status");
        }

        return null;
    }

    /**
     * @throws Exception
     */
    public function markAsEnded(): ?Error {
        if ($this->_status == ReservationStatus::Paid) {
            $this->set_status(ReservationStatus::Ended);
        } else {
            return new Error("Unexpected value for reservation status");
        }

        return null;
    }

    /**
     * @throws Exception
     */
    public function markAsPaid(): ?Error {
        if ($this->_status == ReservationStatus::Confirmed) {
            $this->set_status(ReservationStatus::Paid);
        } else {
            return new Error("Unexpected value for reservation status");
        }

        return null;
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
     * Check if reservation request is valid
     * @return bool
     */
    public function isRequestValid(): bool {
        if ($this->get_status() != ReservationStatus::Created) {
            return false;
        }

        if (!$this->checkInDateIsBeforeCheckOutDate()) {
            return false;
        }

        return true;
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
    public function checkInDateIsBeforeCheckOutDate(): bool {
        return $this->get_checkInDate()->getTimestamp() < $this->get_checkOutDate()->getTimestamp();
    }
}