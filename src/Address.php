<?php

declare(strict_types=1);

namespace BookMe;

class Address implements Buildable {
    private string $_city;
    private string $_street;
    private string $_number;
    private string $_postalCode;

    function __construct(string $_city, string $_street, string $_number, string $_postalCode) {
        $this->_city = $_city;
        $this->_street = $_street;
        $this->_number = $_number;
        $this->_postalCode = $_postalCode;
    }

    /**
     * @return string
     */
    public function get_city(): string {
        return $this->_city;
    }

    /**
     * @return string
     */
    public function get_street(): string {
        return $this->_street;
    }

    /**
     * @return string
     */
    public function get_number(): string {
        return $this->_number;
    }

    /**
     * @return string
     */
    public function get_postalCode(): string {
        return $this->_postalCode;
    }
}