<?php

namespace BookMe\Tests\Builders;

use BookMe\Reservation;
use BookMe\Tests\Builder\BuilderGenerator;
use Exception;

class ReservationBuilder extends BaseBuilder {

    use CheckInCheckOutDateProvider;

    /**
     * @throws Exception
     */
    public function __construct() {

        /**
         * @uses BookableBuilder
         */
        $bookable = BuilderGenerator::a('Bookable');

        /**
         * @uses GuestBuilder
         */
        $guest = BuilderGenerator::a('Guest');

        $reservation = new Reservation($this->get_checkInDate(), $this->get_checkOutDate(), $bookable, null, $guest);

        $this->setEntity($reservation);
    }

    /**
     * @throws Exception
     */
    public static function reservationWithExtra(): Reservation {
        /**
         * @uses BookableBuilder
         */
        $bookable = BuilderGenerator::a('Bookable');

        /**
         * @uses ExtraBuilder
         */
        $services = [BuilderGenerator::a('Extra')];


        /**
         * @uses GuestBuilder
         */
        $guest = BuilderGenerator::a('Guest');

        return new Reservation((new ReservationBuilder())->get_checkInDate(), (new ReservationBuilder())->get_checkOutDate(), $bookable, $services, $guest);
    }
}