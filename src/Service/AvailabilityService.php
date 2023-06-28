<?php

namespace BookMe\Service;

use BookMe\Entity\TimeRange;
use DateInterval;
use DateTimeImmutable;
use Exception;

class AvailabilityService {

    /**
     * @param TimeRange[] $bookedTimeRanges - Array of time ranges, e.g. from a booked entity
     * @param int $start - Start date as timestamp
     * @param int $end - End date as timestamp
     * @return array
     * @throws Exception
     */
    public static function filterAvailableDates(?array $bookedTimeRanges, DateTimeImmutable $start, DateTimeImmutable $end): array {

        // create empty array for possible unreserved dates
        $unreservedDates = [];

        // iterate reservations
        foreach ($bookedTimeRanges as $bookedTimeRange) {

            // if the start date is before the checkin and checkout is before the end date ...
            if ($start->getTimestamp() < $bookedTimeRange->getStart()->getTimestamp() && $end->getTimeStamp() >
                $bookedTimeRange->getEnd()->getTimestamp()) {

                // ... add a new unreserved date that starts at $start and ends the day before checkin date
                $unreservedDates[] = array(
                    'start' => $start,
                    'end' => $bookedTimeRange->getStart()->sub(new DateInterval('P1D'))
                );
            }

            // overwrite the start with the date of one day after the checkout date so we start the next iteration there
            $start = $bookedTimeRange->getEnd()->add(new DateInterval('P1D'));
        }

        // if there is still time left in the requested time range ...
        if ($start->getTimestamp() <= $end->getTimestamp()) {
            // ... add this time range as well to the "unreserved dates"
            $unreservedDates[] = array('start' => $start, 'end' => $end);
        }

        return $unreservedDates;
    }
}