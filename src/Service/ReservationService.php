<?php

namespace BookMe\Service;

use BookMe\Extra;
use BookMe\Reservation;
use BookMe\ReservationStatus;
use Exception;
use InvalidArgumentException;

class ReservationService {

    /**
     * @param Reservation $reservation
     * @throws Exception
     */
    public function markAsConfirmed(Reservation $reservation): void {
        if ($reservation->get_status() == ReservationStatus::Created) {
            $reservation->set_status(ReservationStatus::Confirmed);
        } else {
            throw new InvalidArgumentException($this->reservationStatusExceptionMessage(null));
        }
    }

    /**
     * @param Reservation $reservation
     * @throws Exception
     */
    public function markAsRejected(Reservation $reservation): void {
        if ($reservation->get_status() == ReservationStatus::Created) {
            $reservation->set_status(ReservationStatus::Rejected);
        } else {
            throw new InvalidArgumentException($this->reservationStatusExceptionMessage(null));
        }
    }

    /**
     * @param Reservation $reservation
     * @throws Exception
     */
    public function markAsEnded(Reservation $reservation): void {
        if ($reservation->get_status() == ReservationStatus::Paid) {
            $reservation->set_status(ReservationStatus::Ended);
        } else {
            throw new InvalidArgumentException($this->reservationStatusExceptionMessage(null));
        }
    }

    /**
     * @param Reservation $reservation
     * @throws Exception
     */
    public function markAsPaid(Reservation $reservation): void {
        if ($reservation->get_status() == ReservationStatus::Confirmed) {
            $reservation->set_status(ReservationStatus::Paid);
        } else {
            throw new InvalidArgumentException($this->reservationStatusExceptionMessage(null));
        }
    }

    /**
     * @param Reservation $reservation
     * @throws Exception
     */
    public function markAsCanceled(Reservation $reservation): void {
        if ($reservation->get_status() == ReservationStatus::Confirmed || $reservation->get_status() == ReservationStatus::Paid) {
            $reservation->set_status(ReservationStatus::Canceled);
        } else {
            throw new InvalidArgumentException($this->reservationStatusExceptionMessage(null));
        }
    }


    // TODO: Move to validation logic

    /**
     * @param string $id
     * @return string
     */
    private function reservationStatusExceptionMessage(string $id = "dummy"): string {
        return sprintf("Unexpected value for reservation status for reservation with id %s", $id);
    }


    /**
     * Calculate costs for the reservation
     * @param Reservation $reservation
     * @return float
     * @throws Exception
     */
    public function calculateCosts(Reservation $reservation): float {

        $costsInclTaxes = $reservation->get_bookableEntity()->calculateCosts($reservation->get_checkInDate(), $reservation->get_checkOutDate());

        if ($this->hasBookedExtras($reservation)) {
            $costsInclTaxes += $this->sumExtraCosts($reservation->get_extras());
        }

        return $costsInclTaxes;
    }

    /**
     * @param Extra[] $extras
     * @return array|null
     */
    private function sumExtraCosts(array $extras): ?float {
        return array_sum(array_map(fn($extra):float => $extra->get_costs(), $extras));
    }

    /**
     * @param Reservation $reservation
     * @return bool
     */
    private function hasBookedExtras(Reservation $reservation): bool {
        return $reservation->get_extras() != null;
    }
}