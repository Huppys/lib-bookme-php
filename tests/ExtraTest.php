<?php

namespace BookMe\Tests;

use BookMe\Entity\Extra;
use BookMe\Tests\Builder\BuilderGenerator;
use Exception;
use PHPUnit\Framework\TestCase;

class ExtraTest extends TestCase {

    protected Extra $_service;

    /**
     * @return void
     * @throws Exception
     */
    public function setUp(): void {
        $this->_service = BuilderGenerator::a('Extra');
    }

    /**
     * @test
     * @return void
     */
    public function shouldBeInstanceOfService() : void {
        $this->assertInstanceOf(Extra::class, $this->_service);
    }
}