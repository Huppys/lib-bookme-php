<?php

namespace Huppys\BookMe\tests\Builder;

use Exception;
use Huppys\BookMe\Bookable;

class BookableBuilder extends BaseBuilder {
    /**
     * @throws Exception
     */
    public function __construct() {

        parent::__construct();

        /**
         * @uses TariffBuilder
         */
        $bookable = new Bookable(1, 7.0, Builder::a('Tariff'), 'Ferienhaus Seepferdchen', Builder::a('Address'));

        $this->setEntity($bookable);
    }
}