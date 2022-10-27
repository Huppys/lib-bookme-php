<?php

namespace Huppys\BookMe\tests;

use Huppys\BookMe\Extra;
use Huppys\BookMe\tests\Builder\Builder;
use PHPUnit\Framework\TestCase;

class ExtraTest extends TestCase {

    protected Extra $_service;

    public function setUp(): void {
        $this->_service = Builder::a('Extra');
    }

    /**
     * @test
     * @return void
     */
    public function shouldBeInstanceOfService() : void {
        $this->assertInstanceOf(Extra::class, $this->_service);
    }
}