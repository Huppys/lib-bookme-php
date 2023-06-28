<?php

namespace BookMe\Tests\Builders;

use BookMe\Entity\Bookable;
use BookMe\Tests\Builder\BuilderGenerator;
use Exception;

class BookableBuilder extends BaseBuilder {
    /**
     * @throws Exception
     */
    public function __construct() {

        /**
         * @uses TariffBuilder
         * @uses AddressBuilder
         */
        $bookable = new Bookable(1, 7.0, BuilderGenerator::a('Tariff'), 'Ferienhaus Seepferdchen', BuilderGenerator::a('Address'));

        $this->setEntity($bookable);
    }
}