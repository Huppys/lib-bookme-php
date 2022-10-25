<?php
declare(strict_types=1);

namespace Huppys\BookMe\tests;

use Exception;
use Huppys\BookMe\Guest;
use Huppys\BookMe\tests\Builder\Builder;
use PHPUnit\Framework\TestCase;

class GuestTest extends TestCase {

    private Guest $_guest;

    /**
     * @throws Exception
     */
    public function setUp(): void {
        $this->_guest = Builder::a('Guest');
    }

    /**
     * @test
     * @return void
     */
    public function shouldReturnInstanceOfGuest(): void {
        $this->assertInstanceOf(Guest::class, $this->_guest);
    }
}
