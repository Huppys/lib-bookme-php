<?php

namespace BookMe;

use DateInterval;
use DateTimeImmutable;
use Exception;

class Availability implements Buildable {

    private Bookable $_bookable;
    private DateTimeImmutable $_start;
    private DateTimeImmutable $_end;


    public function __construct(Bookable $bookable, DateTimeImmutable $start, DateTimeImmutable $end) {
        $this->_bookable = $bookable;
        $this->_start = $start;
        $this->_end = $end;
    }

    /**
     * @param Reservation[] $reservationList
     * @param DateTimeImmutable $start
     * @param DateTimeImmutable $end
     * @return array
     * @throws Exception
     */
    private function filterAvailableDates(?array $reservationList, DateTimeImmutable $start, DateTimeImmutable $end): array {

        // create empty array for possible unreserved dates
        $unreservedDates = [];

        // iterate reservations
        foreach ($reservationList as $reservation) {

            // if the checkin date after before the start date and checkout is before the end date ...
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

    /**
     * @throws Exception
     */
    public function get_availabilityDates(): ?array {

        // get reserved dates for bookable after $start and before $end
        /** @var Reservation[] $reservationList */
        $reservationList = ReservationList::getReservedDates($this->_bookable, $this->_start, $this->_end);

        if ($reservationList == null) {
            return null;
        }

        // find occurrences where reserved dates are not present after $start and before $end
        return $this->filterAvailableDates($reservationList, $this->_start, $this->_end);
    }

    /**
     * @return DateTimeImmutable
     */
    public function get_start(): DateTimeImmutable {
        return $this->_start;
    }

    /**
     * @return DateTimeImmutable
     */
    public function get_end(): DateTimeImmutable {
        return $this->_end;
    }

}