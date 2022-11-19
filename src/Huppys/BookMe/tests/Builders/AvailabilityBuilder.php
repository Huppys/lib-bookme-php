<?php
declare(strict_types=1);

namespace Huppys\BookMe\tests\Builders;

use Exception;
use Huppys\BookMe\Availability;
use Huppys\BookMe\tests\Builder\AvailabilityDateProvider;
use Huppys\BookMe\tests\Builder\Builder;

class AvailabilityBuilder extends BaseBuilder {

    /**
     * @throws Exception
     */
    public function __construct() {

        $availabilityDateProvider = new AvailabilityDateProvider();

        $availability = new Availability(
            Builder::a('Bookable'),
            $availabilityDateProvider->get_AvailabilityStart(),
            $availabilityDateProvider->get_AvailabilityEnd()
        );

        $this->setEntity($availability);
    }
}