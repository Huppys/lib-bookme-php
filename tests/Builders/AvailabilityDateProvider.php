<?php

namespace BookMe\Tests\Builders;

use DateInterval;
use DateTimeImmutable;

trait AvailabilityDateProvider {

    use CheckInCheckOutDateProvider;

    protected function get_AvailabilityStart(): DateTimeImmutable {
        return $this->get_checkInDate()->sub(new DateInterval('P30D'));
    }


    protected function get_AvailabilityEnd(): DateTimeImmutable {
        return $this->get_checkOutDate()->add(new DateInterval('P335D'));
    }

}