<?php

namespace BookMe\Tests\Validator;

use BookMe\Entity\Bookable;
use BookMe\Entity\Reservation;
use BookMe\Service\ReservationService;
use BookMe\Tests\Builder\BuilderGenerator;
use BookMe\Validator\CheckInCheckOutValidator;
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
        $isValid = CheckInCheckOutValidator::isValid(
            checkInDate:         $this->reservation->get_checkInDate(),
            checkOutDate:        $this->reservation->get_checkOutDate(),
            earliestCheckInDate: $this->reservation->get_checkInDate()->sub(new DateInterval('P1D')),
            latestCheckOutDate:  null
        );
        $this->assertTrue($isValid);
    }

    /**
     * @return void
     * @test
     */
    public function shouldFailWithCheckInDateAfterCheckOutDate(): void {
        $isValid = CheckInCheckOutValidator::isValid(
            checkInDate:         $this->reservation->get_checkOutDate(),
            checkOutDate:        $this->reservation->get_checkInDate(),
            earliestCheckInDate: $this->reservation->get_checkInDate()->sub(new DateInterval('P1D')),
            latestCheckOutDate:  null
        );

        $this->assertFalse($isValid);
    }

    /**
     * @return void
     * @test
     */
    public function shouldFailWithCheckInDateEqualsEarliestCheckInDate(): void {
        $isValid = CheckInCheckOutValidator::isValid(
            checkInDate:         $this->reservation->get_checkInDate(),
            checkOutDate:        $this->reservation->get_checkOutDate(),
            earliestCheckInDate: $this->reservation->get_checkInDate(),
            latestCheckOutDate:  null
        );

        $this->assertFalse($isValid);
    }

    /**
     * @return void
     * @test
     */
    public function shouldFailWithCheckOutDateAfterLatestCheckOutDate(): void {
        $isValid = CheckInCheckOutValidator::isValid(
            checkInDate:         $this->reservation->get_checkInDate(),
            checkOutDate:        $this->reservation->get_checkOutDate()->add(new DateInterval('P2D')),
            earliestCheckInDate: $this->reservation->get_checkInDate()->sub(new DateInterval('P1D')),
            latestCheckOutDate:  $this->reservation->get_checkOutDate()->add(new DateInterval('P1D'))
        );

        $this->assertFalse($isValid);
    }
}
