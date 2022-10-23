<?php
declare(strict_types=1);

namespace Huppys\BookMe\tests;

use Huppys\BookMe\Guest;
use PHPUnit\Framework\TestCase;

class GuestTest extends TestCase {

    private string $_firstname;
    private string $_lastname;
    private string $_email;
    private string $_postalCode;
    private string $_city;
    private string $_street;
    private string $_houseNumber;

    private Guest $_guest;

    public function setUp(): void {

        $this->_firstname = "FirstNameTest";
        $this->_lastname = "LastNameTest";
        $this->_email = "testuser@example.com";
        $this->_postalCode = "12345";
        $this->_city = "Test City";
        $this->_street = "Test street";
        $this->_houseNumber = "123";

        $this->_guest = new Guest($this->_firstname, $this->_lastname, $this->_email, $this->_postalCode, $this->_city, $this->_street, $this->_houseNumber);
    }

    /**
     * @test
     * @return void
     */
    public function shouldReturnInstanceOfGuest(): void {
        $this->assertInstanceOf(Guest::class, $this->_guest);
    }
}
