<?php

declare(strict_types=1);

namespace Huppys\BookMe;

use DateTimeImmutable;
use Exception;
use InvalidArgumentException;

class Reservation implements Buildable {

    private int $_id;
    private DateTimeImmutable $_checkInDate;
    private DateTimeImmutable $_checkOutDate;
    private Bookable $_bookableEntity;
    private ReservationStatus $_status;
    private float $_costsInclTaxes = 0;
    private ?array $_extras;

    function __construct(int $id, DateTimeImmutable $checkInDate, DateTimeImmutable $checkOutDate, Bookable $bookableEntity, ?array $extras) {

        if (!$this->checkInDateIsBeforeCheckOutDate($checkInDate, $checkOutDate)) {
            throw new InvalidArgumentException("Check-in date is not after Check-out date");
        }

        $this->_id = $id;
        $this->_checkInDate = $checkInDate;
        $this->_checkOutDate = $checkOutDate;
        $this->_bookableEntity = $bookableEntity;
        $this->_status = ReservationStatus::Created;
        $this->_extras = $extras;
    }

    /**
     * @throws Exception
     */
    public function markAsConfirmed(): void {
        if ($this->get_status() == ReservationStatus::Created) {
            $this->set_status(ReservationStatus::Confirmed);
        } else {
            throw new InvalidArgumentException($this->reservationStatusExceptionMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function markAsRejected(): void {
        if ($this->_status == ReservationStatus::Created) {
            $this->set_status(ReservationStatus::Rejected);
        } else {
            throw new InvalidArgumentException($this->reservationStatusExceptionMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function markAsEnded(): void {
        if ($this->_status == ReservationStatus::Paid) {
            $this->set_status(ReservationStatus::Ended);
        } else {
            throw new InvalidArgumentException($this->reservationStatusExceptionMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function markAsPaid(): void {
        if ($this->_status == ReservationStatus::Confirmed) {
            $this->set_status(ReservationStatus::Paid);
        } else {
            throw new InvalidArgumentException($this->reservationStatusExceptionMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function markAsCanceled(): void {
        if ($this->_status == ReservationStatus::Confirmed || $this->_status == ReservationStatus::Paid) {
            $this->set_status(ReservationStatus::Canceled);
        } else {
            throw new InvalidArgumentException($this->reservationStatusExceptionMessage());
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

        if ($this->hasBookedExtras()) {
            $this->_costsInclTaxes += $this->sumExtraCosts($this->get_extras());
        }

        return $this->_costsInclTaxes;
    }

    /**
     * @param Extra[] $extras
     * @return array|null
     */
    function sumExtraCosts(array $extras): ?float {
        return array_sum(array_map(fn($extra):float => $extra->get_costs(), $extras));
    }

    /**
     * @return bool
     */
    public function checkInDateIsBeforeCheckOutDate(DateTimeImmutable $checkInDate, DateTimeImmutable $checkOutDate): bool {
        return $checkInDate->getTimestamp() < $checkOutDate->getTimestamp();
    }

    /**
     * @return int
     */
    public function get_id(): int {
        return $this->_id;
    }

    /**
     * @param int $id
     */
    public function set_id(int $id): void {
        $this->_id = $id;
    }

    /**
     * @return string
     */
    public function reservationStatusExceptionMessage(): string {
        return sprintf("Unexpected value for reservation status for reservation with id %s", $this->get_id());
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
     * @return bool
     */
    private function hasBookedExtras(): bool {
        return $this->get_extras() != null;
    }
}