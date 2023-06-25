<?php

namespace BookMe\Service;

use BookMe\Reservation;
use DateInterval;
use DateTimeImmutable;
use Exception;

class AvailabilityService {

    /**
     * @param Reservation[] $reservationList
     * @param DateTimeImmutable $start
     * @param DateTimeImmutable $end
     * @return array
     * @throws Exception
     */
    public static function filterAvailableDates(?array $reservationList, DateTimeImmutable $start, DateTimeImmutable $end): array {

        // create empty array for possible unreserved dates
        $unreservedDates = [];

        // iterate reservations
        foreach ($reservationList as $reservation) {

            // if the start date is before the checkin and checkout is before the end date ...
            if ($start->getTimestamp() < $reservation->get_checkInDate()->getTimestamp() && $end->getTimeStamp() >
                $reservation->get_checkOutDate()->getTimestamp()) {

                // ... add a new unreserved date that starts at $start and ends the day before checkin date
                $unreservedDates[] = array(
                    'start' => $start,
                    'end' => $reservation->get_checkInDate()->sub(new DateInterval('P1D'))
                );
            }

            // overwrite the start with the date of one day after the checkout date so we start the next iteration there
            $start = $reservation->get_checkOutDate()->add(new DateInterval('P1D'));
        }

        // if there is still time left in the requested time range ...
        if ($start->getTimestamp() <= $end->getTimestamp()) {
            // ... add this time range as well to the "unreserved dates"
            $unreservedDates[] = array('start' => $start, 'end' => $end);
        }

        return $unreservedDates;
    }
}