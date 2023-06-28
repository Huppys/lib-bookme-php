<?php
declare(strict_types=1);

namespace BookMe\Entity;

use BookMe\Buildable;

class Guest implements Buildable {
    private string $_firstname;
    private string $_lastname;
    private string $_email;
    private string $_postalCode;
    private string $_city;
    private string $_street;
    private string $_houseNumber;

    /**
     * @param string $_firstname
     * @param string $_lastname
     * @param string $_email
     * @param string $_postalCode
     * @param string $_city
     * @param string $_street
     * @param string $_houseNumber
     */
    public function __construct(string $_firstname, string $_lastname, string $_email, string $_postalCode, string $_city, string $_street, string $_houseNumber) {
        $this->_firstname = $_firstname;
        $this->_lastname = $_lastname;
        $this->_email = $_email;
        $this->_postalCode = $_postalCode;
        $this->_city = $_city;
        $this->_street = $_street;
        $this->_houseNumber = $_houseNumber;
    }

    /**
     * @return string
     */
    public function getFirstname(): string {
        return $this->_firstname;
    }

    /**
     * @return string
     */
    public function getLastname(): string {
        return $this->_lastname;
    }

    /**
     * @return string
     */
    public function getEmail(): string {
        return $this->_email;
    }

    /**
     * @return string
     */
    public function getPostalCode(): string {
        return $this->_postalCode;
    }

    /**
     * @return string
     */
    public function getCity(): string {
        return $this->_city;
    }

    /**
     * @return string
     */
    public function getStreet(): string {
        return $this->_street;
    }

    /**
     * @return string
     */
    public function getHouseNumber(): string {
        return $this->_houseNumber;
    }


}