<?php

namespace BookMe\Tests\Validator;

use BookMe\Entity\Bookable;
use BookMe\Entity\Reservation;
use BookMe\Service\ReservationService;
use BookMe\Tests\Builder\BuilderGenerator;
use BookMe\Validator\CheckInCheckOutValidator;
use BookMe\Validator\ReservationValidationError;
use DateInterval;
use Exception;
use PHPUnit\Framework\TestCase;

class CheckInCheckOutValidatorTest extends TestCase {

    protected Reservation $reservation;
    protected Bookable $bookableEntity;
    protected ReservationService $reservationService;

    /**
     * @throws Exception
     */
    public function setUp(): void {

        /**
         * @uses \BookMe\Tests\Builders\ReservationBuilder
         */
        $this->reservation = BuilderGenerator::a('Reservation');
    }

    /**
     * @return void
     * @test
     */
    public function shouldCreateValidReservation(): void {
        $reservationValidationError = CheckInCheckOutValidator::isValid(
            checkInDate:         $this->reservation->get_checkInDate(),
            checkOutDate:        $this->reservation->get_checkOutDate(),
            earliestCheckInDate: $this->reservation->get_checkInDate()->sub(new DateInterval('P1D')),
            latestCheckOutDate:  $this->reservation->get_checkOutDate()->add(new DateInterval('P14D'))
        );
        $this->assertEquals(ReservationValidationError::Valid, $reservationValidationError);
    }

    /**
     * @return void
     * @test
     */
    public function shouldFailWithCheckInDateAfterCheckOutDate(): void {
        $reservationValidationError = CheckInCheckOutValidator::isValid(
            checkInDate:         $this->reservation->get_checkOutDate(),
            checkOutDate:        $this->reservation->get_checkInDate(),
            earliestCheckInDate: $this->reservation->get_checkInDate()->sub(new DateInterval('P1D')),
            latestCheckOutDate:  $this->reservation->get_checkOutDate()->add(new DateInterval('P14D'))
        );

        $this->assertEquals(ReservationValidationError::CheckInIsAfterCheckoutDate, $reservationValidationError);
    }

    /**
     * @return void
     * @test
     */
    public function shouldFailWithCheckInDateEqualsEarliestCheckInDate(): void {
        $reservationValidationError = CheckInCheckOutValidator::isValid(
            checkInDate:         $this->reservation->get_checkInDate(),
            checkOutDate:        $this->reservation->get_checkOutDate(),
            earliestCheckInDate: $this->reservation->get_checkInDate(),
            latestCheckOutDate:  $this->reservation->get_checkOutDate()->add(new DateInterval('P14D'))
        );

        $this->assertEquals(ReservationValidationError::CheckInDateIsTooEarly, $reservationValidationError);
    }

    /**
     * @return void
     * @test
     */
    public function shouldFailWithCheckOutDateAfterLatestCheckOutDate(): void {
        $reservationValidationError = CheckInCheckOutValidator::isValid(
            checkInDate:         $this->reservation->get_checkInDate(),
            checkOutDate:        $this->reservation->get_checkOutDate()->add(new DateInterval('P2D')),
            earliestCheckInDate: $this->reservation->get_checkInDate()->sub(new DateInterval('P1D')),
            latestCheckOutDate:  $this->reservation->get_checkOutDate()->add(new DateInterval('P1D'))
        );

        $this->assertEquals(ReservationValidationError::CheckoutDateIsTooLate, $reservationValidationError);
    }
}
