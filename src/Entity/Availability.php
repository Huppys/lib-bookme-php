<?php

namespace BookMe\Entity;

use BookMe\Buildable;
use BookMe\Service\AvailabilityService;
use BookMe\Service\ReservationListService;
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
     * @throws Exception
     */
    public function get_availabilityDates(): ?array {

        // get reserved dates for bookable after $start and before $end
        /** @var Reservation[] $reservationList */
        $bookedTimeRanges = ReservationListService::getReservedDates($this->_bookable, $this->_start, $this->_end);

        if ($bookedTimeRanges == null) {
            return null;
        }

        // find occurrences where reserved dates are not present after $start and before $end
        return AvailabilityService::filterAvailableDates($bookedTimeRanges, $this->_start, $this->_end);
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