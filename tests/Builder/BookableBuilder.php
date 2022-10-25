<?php

namespace Huppys\BookMe\tests\Builder;

use Huppys\BookMe\Bookable;

class BookableBuilder extends BaseBuilder {
    public function __construct() {

        parent::__construct();

        /**
         * @depends TariffBuilder
         */
        $bookable = new Bookable(1, 7.0, Builder::a('Tariff'), 'Ferienhaus Seepferdchen');

        $this->setEntity($bookable);

    }
}