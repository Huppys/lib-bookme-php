<?php

namespace Huppys\BookMe\tests\Builder;

use DateInterval;
use DateTimeImmutable;

class AvailabilityDateProvider {

    use CheckInCheckOutDateProvider;

    public function get_AvailabilityStart(): DateTimeImmutable {
        return $this->get_checkInDate()->sub(new DateInterval('P30D'));
    }


    public function get_AvailabilityEnd(): DateTimeImmutable {
        return $this->get_checkOutDate()->add(new DateInterval('P335D'));
    }

}