<?php

namespace Huppys\BookMe\tests\Builder;

use Exception;
use Huppys\BookMe\Reservation;

class ReservationBuilder extends BaseBuilder {

    protected string $_bookableTitle = 'Ferienhaus Seepferdchen';
    protected float $_bookableTaxAmount = 7.0;

    /**
     * @throws Exception
     */
    public function __construct() {
        parent::__construct();

        /**
         * @uses BookableBuilder
         */
        $bookable = Builder::a('Bookable');

        /**
         * @uses ServiceBuilder
         */
        $services = [Builder::a('Service')];

        $reservation = new Reservation(1, $this->checkInDate, $this->checkOutDate, $bookable, $services);

        $this->setEntity($reservation);
    }
}