<?php

namespace BookMe\Validator;

use DateInterval;
use DateTime;
use DateTimeImmutable;

final class CheckInCheckOutValidator {

    public static function isValid(DateTimeImmutable $checkInDate, DateTimeImmutable $checkOutDate,
                                   DateTimeImmutable $earliestCheckInDate, ?DateTimeImmutable $latestCheckOutDate): bool {

        // TODO: Implement reservation settings containing maximum stay duration
        if ($latestCheckOutDate == null) {
            $latestCheckOutDate = DateTimeImmutable::createFromMutable(new DateTime())->add(new DateInterval('P14D'));
        }

        // Check-in date must be before check-out date
        if (!self::checkInDateIsBeforeCheckOutDate($checkInDate, $checkOutDate)) {
            return false;
        }

        // Check-in date must not be today or earlier
        if (self::checkInDateIsEarlierThanEarliestCheckInDate($checkInDate, $earliestCheckInDate)) {
            return false;
        }

        // Check-out date must not be later than maximum stay duration
        if (self::checkOutDateIsLaterThanLatestCheckOutDate($checkOutDate, $latestCheckOutDate)) {
            return false;
        }

        return true;
    }

    /**
     * @param DateTimeImmutable $checkInDate
     * @param DateTimeImmutable $checkOutDate
     * @return bool
     */
    private static function checkInDateIsBeforeCheckOutDate(DateTimeImmutable $checkInDate, DateTimeImmutable $checkOutDate): bool {
        return $checkInDate->getTimestamp() < $checkOutDate->getTimestamp();

    }

    private static function checkInDateIsEarlierThanEarliestCheckInDate(DateTimeImmutable $checkInDate, DateTimeImmutable $earliestCheckInDate) {
        return $checkInDate->getTimestamp() <= $earliestCheckInDate->getTimestamp();
    }

    private static function checkOutDateIsLaterThanLatestCheckOutDate(DateTimeImmutable $checkOutDate, DateTimeImmutable $latestCheckOutDate) {
        return $checkOutDate->getTimestamp() > $latestCheckOutDate->getTimestamp();
    }
}