<?php

namespace BookMe;

use DateTime;
use DateTimeImmutable;
use Ds\Map;
use Exception;
use When\When;

class ReservationList {

    private static ?Map $reservationsByBookable = null;

    /**
     * @param Bookable $bookable
     * @param DateTimeImmutable $start
     * @param DateTimeImmutable $end
     * @return Reservation[] | null
     * @throws Exception
     */
    public static function getReservedDates(Bookable $bookable, DateTimeImmutable $start, DateTimeImmutable $end): ?array {
        $key = $bookable->get_id();

        /** @var Reservation[] $values */
        $values = self::$reservationsByBookable->get($key);

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
     * @param Reservation $reservation
     * @param DateTimeImmutable $start
     * @param DateTimeImmutable $end
     * @return bool
     * @throws Exception
     */
    private static function startAndEndAreInDateRange(Reservation $reservation, DateTimeImmutable $start, DateTimeImmutable $end): bool {

        // create occurrences lookup from the $start ...
        $when = new When(DateTime::createFromImmutable($start)->format('Y-m-d'));
        // ... until the $end of the time range
        $when->freq('daily')->until(DateTime::createFromImmutable($end));

        // find if at least on day between checkin date and the checkout date occurs in the occurrence lookup time range
        return count($when->getOccurrencesBetween($reservation->get_checkInDate(), $reservation->get_checkOutDate())) > 0;
    }
}