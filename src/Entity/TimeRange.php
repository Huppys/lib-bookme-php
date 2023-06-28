<?php

namespace BookMe\Entity;

use DateTimeImmutable;

class TimeRange {
    private DateTimeImmutable $start;
    private DateTimeImmutable $end;

    public function __construct(DateTimeImmutable $start, DateTimeImmutable $end) {
        $this->start = $start;
        $this->end = $end;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getStart(): DateTimeImmutable {
        return $this->start;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getEnd(): DateTimeImmutable {
        return $this->end;
    }
}