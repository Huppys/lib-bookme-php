<?php

namespace Huppys\BookMe;

use DateInterval;
use DateTime;
use DateTimeImmutable;
use Exception;
use When\When;

class Availability implements Buildable {

    private Bookable $_bookable;
    private DateTimeImmutable $_start;
    private DateTimeImmutable $_end;
    private array $_availableDates;


    public function __construct(Bookable $bookable, DateTimeImmutable $start, DateTimeImmutable $end) {
        $this->_bookable = $bookable;
        $this->_start = $start;
        $this->_end = $end;
    }


    /**
     * @param Reservation[] $reservationList
     * @param DateTimeImmutable $start
     * @param DateTimeImmutable $end
     * @return array|null
     * @throws Exception
     */
    private function filterAvailableDates(?array $reservationList, DateTimeImmutable $start, DateTimeImmutable $end): ?array {

        $availableDates = [];

        foreach ($reservationList as $reservation) {

            $when = new When(DateTime::createFromImmutable($start)->format('Y-m-d'));
            $when->freq('daily')->until(DateTime::createFromImmutable($end))->generateOccurrences();

            if ($when->startDate->getTimestamp() < $reservation->get_checkInDate()->getTimestamp() && $when->until->getTimeStamp() >
            $reservation->get_checkOutDate()->getTimestamp()) {

                $availableDates[] = array(
                    'start' => $start,
                    'end' => $reservation->get_checkInDate()->sub(new DateInterval('P1D'))
                );
            }
            $start = $reservation->get_checkOutDate()->add(new DateInterval('P1D'));

            unset($when);
        }

        if ($start->getTimestamp() <= $end->getTimestamp()) {
            $availableDates[] = array('start' => $start, 'end' => $end);
        }

        return $availableDates;
    }

    public function get_availabilityDates(): ?array {

        // get reserved dates for bookable after $start and before $end
        /** @var Reservation[] $reservationList */
        $reservationList = ReservationList::getReservedDates($this->_bookable, $this->_start, $this->_end);

        if ($reservationList == null) {
            return null;
        }

        // find occurences where reserved dates are not present after $start and before $end
        return $this->filterAvailableDates($reservationList, $this->_start, $this->_end);
    }

}