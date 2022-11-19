<?php
declare(strict_types=1);

namespace Huppys\BookMe\tests\Builders;

use Exception;
use Huppys\BookMe\Availability;
use Huppys\BookMe\tests\Builder\AvailabilityDateProvider;
use Huppys\BookMe\tests\Builder\Builder;

class AvailabilityBuilder extends BaseBuilder {

    use AvailabilityDateProvider;

    /**
     * @throws Exception
     */
    public function __construct() {

        $availability = new Availability(
            Builder::a('Bookable'),
            $this->get_AvailabilityStart(),
            $this->get_AvailabilityEnd()
        );

        $this->setEntity($availability);
    }
}