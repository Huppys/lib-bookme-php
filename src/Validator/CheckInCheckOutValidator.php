<?php

namespace BookMe\Validator;

use DateTimeImmutable;

final class CheckInCheckOutValidator {

    public static function isValid(DateTimeImmutable $checkInDate, DateTimeImmutable $checkOutDate,
                                   DateTimeImmutable $earliestCheckInDate, DateTimeImmutable $latestCheckOutDate): ReservationValidationError {

        $checkInDate = $checkInDate->setTime(0, 0, 0);
        $checkOutDate = $checkOutDate->setTime(0, 0, 0);

        if ($checkInDate == $checkOutDate) {
            return ReservationValidationError::CheckInDayEqualsCheckOutDay;
        }

        // Check-in date must be before check-out date
        if (!self::checkInDateIsBeforeCheckOutDate($checkInDate, $checkOutDate)) {
            return ReservationValidationError::CheckInIsAfterCheckoutDate;
        }

        // Check-in date must not be today or earlier
        if (self::checkInDateIsEarlierThanEarliestCheckInDate($checkInDate, $earliestCheckInDate)) {
            return ReservationValidationError::CheckInDateIsTooEarly;
        }

        // Check-out date must not be later than maximum stay duration
        if (self::checkOutDateIsLaterThanLatestCheckOutDate($checkOutDate, $latestCheckOutDate)) {
            return ReservationValidationError::CheckoutDateIsTooLate;
        }

        return ReservationValidationError::Valid;
    }

    /**
     * @param DateTimeImmutable $checkInDate
     * @param DateTimeImmutable $checkOutDate
     * @return bool
     */
    private static function checkInDateIsBeforeCheckOutDate(DateTimeImmutable $checkInDate, DateTimeImmutable $checkOutDate): bool {
        return $checkInDate->getTimestamp() < $checkOutDate->getTimestamp();
    }

    private static function checkInDateIsEarlierThanEarliestCheckInDate(DateTimeImmutable $checkInDate, DateTimeImmutable $earliestCheckInDate): bool {
        return $checkInDate->getTimestamp() <= $earliestCheckInDate->getTimestamp();
    }

    private static function checkOutDateIsLaterThanLatestCheckOutDate(DateTimeImmutable $checkOutDate, DateTimeImmutable $latestCheckOutDate): bool {
        return $checkOutDate->getTimestamp() > $latestCheckOutDate->getTimestamp();
    }
}