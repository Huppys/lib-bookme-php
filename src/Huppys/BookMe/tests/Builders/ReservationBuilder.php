<?php

namespace Huppys\BookMe\tests\Builders;

use Exception;
use Huppys\BookMe\Reservation;
use Huppys\BookMe\tests\Builder\Builder;
use Huppys\BookMe\tests\Builder\CheckInCheckOutDateProvider;

class ReservationBuilder extends BaseBuilder {

    use CheckInCheckOutDateProvider;

    /**
     * @throws Exception
     */
    public function __construct() {

        /**
         * @uses BookableBuilder
         */
        $bookable = Builder::a('Bookable');

        $reservation = new Reservation(1, $this->get_checkInDate(), $this->get_checkOutDate(), $bookable, null);

        $this->setEntity($reservation);
    }

    public static function reservationWithExtra(): Reservation {
        /**
         * @uses BookableBuilder
         */
        $bookable = Builder::a('Bookable');

        /**
         * @uses ExtraBuilder
         */
        $services = [Builder::a('Extra')];

        return new Reservation(1, (new ReservationBuilder())->get_checkInDate(), (new ReservationBuilder())->get_checkOutDate(), $bookable, $services);
    }
}