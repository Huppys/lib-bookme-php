<?php
declare(strict_types=1);

namespace BookMe\Tests;

use BookMe\Guest;
use BookMe\Tests\Builder\BuilderGenerator;
use Exception;
use PHPUnit\Framework\TestCase;

final class GuestTest extends TestCase {

    private Guest $_guest;

    /**
     * @throws Exception
     */
    public function setUp(): void {
        /**
         * @uses GuestBuilder
         */
        $this->_guest = BuilderGenerator::a('Guest');
    }

    /**
     * @test
     * @return void
     */
    public function shouldReturnInstanceOfGuest(): void {
        $this->assertInstanceOf(Guest::class, $this->_guest);
    }
}
