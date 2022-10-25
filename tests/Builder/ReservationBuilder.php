<?php

namespace Huppys\BookMe\tests\Builder;

use Huppys\BookMe\Reservation;

class ReservationBuilder extends BaseBuilder {

    protected string $_bookableTitle = 'Ferienhaus Seepferdchen';
    protected float $_bookableTaxAmount = 7.0;

    public function __construct() {
        parent::__construct();

        /**
         * @depends BookableBuilder
         */
        $this->reservation = new Reservation(1, $this->checkInDate, $this->checkOutDate, Builder::a('Bookable'));

        $this->setEntity($this->reservation);
    }
}