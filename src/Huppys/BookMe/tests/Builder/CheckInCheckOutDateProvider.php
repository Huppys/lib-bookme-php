<?php

namespace Huppys\BookMe\tests\Builder;

use DateInterval;
use DateTimeImmutable;
use Exception;

trait CheckInCheckOutDateProvider {

    protected ?DateTimeImmutable $checkInDate = null;
    protected ?DateTimeImmutable $checkOutDate = null;

    private function initDates(): void {
        try {
            $now = DateTimeImmutable::createFromFormat('Y-m-d|', date('Y-m-d'));
            $reservationDuration = new DateInterval('P2D');
            $this->checkInDate = clone($now);
            $this->checkOutDate = clone ($now)->add($reservationDuration);
        } catch (Exception $e) {
            echo $e;
        }
    }

    protected function get_checkInDate(): DateTimeImmutable {
        if ($this->checkInDate == null) {
            $this->initDates();
        }

        return $this->checkInDate;
    }

    protected function get_checkOutDate(): DateTimeImmutable {
        if ($this->checkOutDate == null) {
            $this->initDates();
        }

        return $this->checkOutDate;
    }
}