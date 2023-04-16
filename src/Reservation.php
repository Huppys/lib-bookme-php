<?php

declare(strict_types=1);

namespace BookMe;

use DateTimeImmutable;
use InvalidArgumentException;

class Reservation implements Buildable {

    private DateTimeImmutable $_checkInDate;
    private DateTimeImmutable $_checkOutDate;
    private Bookable $_bookableEntity;
    private ReservationStatus $_status;
    private ?array $_extras;
    private Guest $guest;

    function __construct(DateTimeImmutable $checkInDate, DateTimeImmutable $checkOutDate, Bookable $bookableEntity, ?array $extras, Guest $guest) {

        // TODO: Move validation to validation logic
        if (!$this->checkInDateIsBeforeCheckOutDate($checkInDate, $checkOutDate)) {
            throw new InvalidArgumentException("Check-in date is not after Check-out date");
        }

        $this->_checkInDate = $checkInDate;
        $this->_checkOutDate = $checkOutDate;
        $this->_bookableEntity = $bookableEntity;
        $this->_status = ReservationStatus::Created;
        $this->_extras = $extras;
        $this->guest = $guest;
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
     * @return null|array
     */
    public function get_extras(): ?array {
        return $this->_extras;
    }

    /**
     * @param ?array $extras
     */
    public function set_extras(?array $extras): void {
        $this->_extras = $extras;
    }

    /**
     * @param DateTimeImmutable $checkInDate
     * @param DateTimeImmutable $checkOutDate
     * @return bool
     */
    public function checkInDateIsBeforeCheckOutDate(DateTimeImmutable $checkInDate, DateTimeImmutable $checkOutDate): bool {
        return $checkInDate->getTimestamp() < $checkOutDate->getTimestamp();
    }

    /**
     * @return Guest
     */
    public function get_guest(): Guest {
        return $this->guest;
    }
}