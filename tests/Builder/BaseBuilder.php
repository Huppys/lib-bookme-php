<?php
declare(strict_types=1);

namespace Huppys\BookMe\tests\Builder;

use DateInterval;
use DateTimeImmutable;

abstract class BaseBuilder {
    protected mixed $_entity;

    protected DateTimeImmutable $checkInDate;
    protected DateTimeImmutable $checkOutDate;

    public function __construct() {
        $date_interval = 'P2D';
        $reservationDuration = new DateInterval($date_interval);
        $now = DateTimeImmutable::createFromFormat('Y-m-d|', date('Y-m-d'));
        $this->checkInDate = clone($now);
        $this->checkOutDate = clone ($now)->add($reservationDuration);
    }

    protected function setEntity(mixed $value): void {
        $this->_entity = $value;
    }

    public function getEntity(): object | array {
        return $this->_entity;
    }
}