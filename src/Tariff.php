<?php

namespace BookMe;

use DateTimeImmutable;

class Tariff implements Buildable {
    private DateTimeImmutable $_start;
    private DateTimeImmutable $_end;
    private float $_price;
    private string $_title;

    public function __construct($start, $end, float $_price, $title) {

        $this->_start = $start;
        $this->_end = $end;
        $this->_title = $title;
        $this->_price = $_price;
    }

    /**
     * @return DateTimeImmutable
     */
    public function get_start(): DateTimeImmutable {
        return $this->_start;
    }

    /**
     * @return DateTimeImmutable
     */
    public function get_end(): DateTimeImmutable {
        return $this->_end;
    }

    /**
     * @return string
     */
    public function get_title(): string {
        return $this->_title;
    }

    /**
     * @return float
     */
    public function get_price(): float {
        return $this->_price;
    }
}