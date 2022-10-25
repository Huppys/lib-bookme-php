<?php

namespace Huppys\BookMe\tests;

use Huppys\BookMe\Service;
use Huppys\BookMe\tests\Builder\Builder;
use PHPUnit\Framework\TestCase;

class ServiceTest extends TestCase {

    protected Service $_service;

    public function setUp(): void {
        $this->_service = Builder::a('Service');
    }

    /**
     * @test
     * @return void
     */
    public function shouldBeInstanceOfService() : void {
        $this->assertInstanceOf(Service::class, $this->_service);
    }
}