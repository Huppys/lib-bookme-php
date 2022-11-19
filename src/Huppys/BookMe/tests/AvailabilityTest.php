<?php

namespace Huppys\BookMe\tests;

use DateInterval;
use DateTimeImmutable;
use Exception;
use Huppys\BookMe\Availability;
use Huppys\BookMe\Bookable;
use Huppys\BookMe\Reservation;
use Huppys\BookMe\ReservationList;
use Huppys\BookMe\tests\Builder\Builder;
use PHPUnit\Framework\TestCase;

class AvailabilityTest extends TestCase {


    private static Bookable $bookable;
    private static DateTimeImmutable $start;
    private static DateTimeImmutable $end;
    private static Availability $availability;
    private static Reservation $reservation;
//    private static int $availabilityStartTimestamp;

    /**
     * @throws Exception
     */
    public static function setUpBeforeClass(): void {

        /**
         * @uses BookableBuilder
         */
        self::$bookable = Builder::a('Bookable');


        $now = DateTimeImmutable::createFromFormat('Y-m-d|', date('Y-m-d'));

//        self::$availabilityStartTimestamp = $now->sub(new DateInterval('P30D'))->getTimestamp();

        self::$start = clone($now)->sub(new DateInterval('P180D'));
        self::$end = clone($now)->add(new DateInterval('P180D'));

        self::$availability = new Availability(self::$bookable, self::$start, self::$end);

        /**
         * @uses ReservationBuilder
         */
        self::$reservation = Builder::a('Reservation');

        ReservationList::setReservedDates(self::$reservation);
    }

    /**
     * @test
     * @return void
     */
    public function shouldReturnAvailabilityAsArray(): void {
        $this->assertInstanceOf(Availability::class, self::$availability);
    }

    /**
     * @test
     * @return void
     */
    public function shouldReturnAvailabilityDates(): void {

        $expected = [
            ['start' => self::$start, 'end' => self::$reservation->get_checkInDate()->sub(new DateInterval('P1D'))],
            ['start' => self::$reservation->get_checkOutDate()->add(new DateInterval('P1D')), 'end' => self::$end]
        ];

        $this->assertEquals($expected, self::$availability->get_availabilityDates());
    }

    /**
     * @test
     * @return void
     */
    public function shouldReturnEmptyArrayForOnlyUnavailableSlots(): void {

        $start = clone(self::$reservation->get_checkInDate());
        $end = clone(self::$reservation->get_checkOutDate());

        self::$availability = new Availability(self::$bookable, $start, $end);

        $this->assertEquals([], self::$availability->get_availabilityDates());
    }
}