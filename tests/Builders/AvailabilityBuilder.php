<?php
declare(strict_types=1);

namespace BookMe\Tests\Builders;

use BookMe\Availability;
use BookMe\Tests\Builder\BuilderGenerator;
use Exception;

class AvailabilityBuilder extends BaseBuilder {

    use AvailabilityDateProvider;

    /**
     * @throws Exception
     */
    public function __construct() {

        $availability = new Availability(
            BuilderGenerator::a('Bookable'),
            $this->get_AvailabilityStart(),
            $this->get_AvailabilityEnd()
        );

        $this->setEntity($availability);
    }
}