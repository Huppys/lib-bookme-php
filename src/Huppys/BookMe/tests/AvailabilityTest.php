<?php

namespace Huppys\BookMe\tests;

use DateInterval;
use DateTimeImmutable;
use Exception;
use Huppys\BookMe\Availability;
use Huppys\BookMe\Bookable;
use Huppys\BookMe\ReservationList;
use Huppys\BookMe\tests\Builder\Builder;
use PHPUnit\Framework\TestCase;

class AvailabilityTest extends TestCase {

    /**
     * @throws Exception
     */
    public function setUp(): void {
        $this->now = DateTimeImmutable::createFromFormat('Y-m-d|', date('Y-m-d'));

        /**
         * @uses ReservationBuilder
         */
        $this->reservation = Builder::a('Reservation');

        ReservationList::setReservedDates($this->reservation);
    }

    /**
     * @test
     * @return void
     * @throws Exception
     */
    public function shouldReturnAvailabilityAsArray(): void {

        /**
         * @uses AvailabilityBuilder
         */
        $availability = Builder::a('Availability');

        $this->assertInstanceOf(Availability::class, $availability);
    }

    /**
     * @test
     * @return void
     * @throws Exception
     */
    public function shouldReturnAvailabilityDates(): void {

        /**
         * @var Availability $availability
         * @uses AvailabilityBuilder
         */
        $availability = Builder::a('Availability');

        $expected = [
            ['start' => $availability->get_start(), 'end' => $this->reservation->get_checkInDate()->sub(new DateInterval('P1D'))],
            ['start' => $this->reservation->get_checkOutDate()->add(new DateInterval('P1D')), 'end' => $availability->get_end()]
        ];

        $this->assertEquals($expected, $availability->get_availabilityDates());
    }

    /**
     * @test
     * @return void
     * @throws Exception
     */
    public function shouldReturnEmptyArrayForOnlyUnavailableSlots(): void {

        $start = clone($this->reservation->get_checkInDate());
        $end = clone($this->reservation->get_checkOutDate());

        /**
         * @var Bookable $bookable
         * @uses BookableBuilder
         */
        $bookable = Builder::a('Bookable');

        // create availability request with $start matching checkin date and checkout date matching $end
        $availability = new Availability($bookable, $start, $end);

        $this->assertEquals([], $availability->get_availabilityDates());
    }
}