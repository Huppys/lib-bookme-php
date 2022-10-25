<?php
declare(strict_types=1);

namespace Huppys\BookMe\tests;

use Exception;
use Huppys\BookMe\Address;
use Huppys\BookMe\Bookable;
use Huppys\BookMe\tests\Builder\BookableBuilder;
use Huppys\BookMe\tests\Builder\Builder;
use Huppys\BookMe\tests\Builder\TariffBuilder;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class BookableTest extends TestCase {

    /**
     * @throws Exception
     */
    public function setUp(): void {
        /**
         * @uses BookableBuilder
         */
        $this->bookable = Builder::a('Bookable');
    }

    /**
     * @test
     * @return void
     */
    public function shouldReturnInstanceOfBookable(): void {
        $this->assertInstanceOf(Bookable::class, $this->bookable);
    }

    /**
     * @test
     * @return void
     */
    public function shouldReturnRoomsAsAnArray(): void {
        $this->assertIsArray($this->bookable->get_rooms());
    }

    /**
     * @test
     * @return void
     */
    public function shouldReturnAddress(): void {
        $this->assertInstanceOf(Address::class, $this->bookable->get_address());
    }

    /**
     * @test
     * @return void
     */
    public function shouldReturnTitle(): void {
        $this->assertNotNull($this->bookable->get_title());
    }

    /**
     * @test
     * @return void
     */
    public function shouldReturnTariff(): void {
        $this->assertIsArray($this->bookable->get_tariffs());
    }

    /**
     * @test
     * @return void
     * @throws Exception
     */
    public function shouldThrowExceptionForInvalidTariffs(): void {
        $this->expectException(InvalidArgumentException::class);
        new Bookable(1, 1.0, TariffBuilder::getTariffsWithDateGap(), 'TestBookableTitle', Builder::a('Address'));
    }
}
