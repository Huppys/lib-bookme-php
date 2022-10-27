<?php

namespace Huppys\BookMe\tests\Builders;

use Exception;
use Huppys\BookMe\Bookable;
use Huppys\BookMe\tests\Builder\Builder;

class BookableBuilder extends BaseBuilder {
    /**
     * @throws Exception
     */
    public function __construct() {

        /**
         * @uses TariffBuilder
         */
        $bookable = new Bookable(1, 7.0, Builder::a('Tariff'), 'Ferienhaus Seepferdchen', Builder::a('Address'));

        $this->setEntity($bookable);
    }
}