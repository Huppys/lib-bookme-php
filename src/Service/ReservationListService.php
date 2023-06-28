<?php

namespace BookMe\Service;

use BookMe\Entity\Bookable;
use BookMe\Entity\Reservation;
use BookMe\Entity\TimeRange;
use DateTime;
use DateTimeImmutable;
use Ds\Map;
use Exception;
use When\When;

class ReservationListService {

    private static ?Map $reservationsByBookable = null;

    /**
     * @param Bookable $bookable
     * @param DateTimeImmutable $start
     * @param DateTimeImmutable $end
     * @return TimeRange[] | null
     * @throws Exception
     */
    public static function getReservedDates(Bookable $bookable, DateTimeImmutable $start, DateTimeImmutable $end): ?array {
        $key = $bookable->get_id();

        /** @var Reservation[] $values */
        $values = self::$reservationsByBookable->get($key);

        $values = array_map(fn($reservation) => new TimeRange($reservation->get_checkInDate(), $reservation->get_checkOutDate()), $values);

        return array_filter(
            $values,
            fn($value) => self::startAndEndAreInDateRange($value, $start, $end)
        );
    }

    public static function setReservedDates(Reservation $reservation): void {

        if (self::$reservationsByBookable == null) {
            self::$reservationsByBookable = new Map();
        }

        $key = $reservation->get_bookableEntity()->get_id();
        $currentBookingsForBookable = self::$reservationsByBookable->get($key, []);

        // push reservation to list of reservations for bookable
        $currentBookingsForBookable[] = $reservation;

        self::$reservationsByBookable->put($key, $currentBookingsForBookable);
    }

    /**
     * @param TimeRange $timeRange
     * @param DateTimeImmutable $start
     * @param DateTimeImmutable $end
     * @return bool
     * @throws Exception
     */
    private static function startAndEndAreInDateRange(TimeRange $timeRange, DateTimeImmutable $start, DateTimeImmutable $end): bool {

        // create occurrences lookup from the $start ...
        $when = new When(DateTime::createFromImmutable($start)->format('Y-m-d'));
        // ... until the $end of the time range
        $when->freq('daily')->until(DateTime::createFromImmutable($end));

        // find if at least on day between checkin date and the checkout date occurs in the occurrence lookup time range
        return count($when->getOccurrencesBetween($timeRange->getStart(), $timeRange->getEnd())) > 0;
    }
}