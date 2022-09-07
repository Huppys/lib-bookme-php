<?php

declare(strict_types=1);

namespace Huppys\BookMe;

use DateTime;
use Error;
use Exception;

class Reservation {

    private DateTime $_checkInDate;
    private DateTime $_checkOutDate;
    private Bookable $_bookableEntity;
    private ReservationStatus $_status;

    function __construct(DateTime $checkInDate, DateTime $checkOutDate, Bookable $bookableEntity) {
        $this->_checkInDate = $checkInDate;
        $this->_checkOutDate = $checkOutDate;
        $this->_bookableEntity = $bookableEntity;
        $this->_status = ReservationStatus::Created;
    }

    /**
     * @throws Exception
     */
    public function markAsConfirmed(): ?Error {

        if ($this->_status == ReservationStatus::Created) {
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
     * @return DateTime
     */
    function get_checkInDate(): DateTime {
        return $this->_checkInDate;
    }

    /**
     * @return DateTime
     */
    function get_checkOutDate(): DateTime {
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
}