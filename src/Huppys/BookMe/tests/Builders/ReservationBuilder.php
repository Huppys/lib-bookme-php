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

        /**
         * @uses ExtraBuilder
         */
        $services = [Builder::a('Extra')];

        $reservation = new Reservation(1, $this->get_checkInDate(), $this->get_checkOutDate(), $bookable, $services);

        $this->setEntity($reservation);
    }
}