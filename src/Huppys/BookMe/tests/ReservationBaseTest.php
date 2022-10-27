<?php

declare(strict_types=1);

namespace Huppys\BookMe\tests;

use DateTimeImmutable;
use Exception;
use Huppys\BookMe\Bookable;
use Huppys\BookMe\Reservation;
use Huppys\BookMe\tests\Builder\Builder;
use Huppys\BookMe\tests\Builders\ReservationBuilder;
use PHPUnit\Framework\TestCase;

class ReservationBaseTest extends TestCase {

    protected Reservation $reservation;
    protected DateTimeImmutable $checkInDate;
    protected DateTimeImmutable $checkOutDate;
    protected Bookable $bookableEntity;


    /**
     * @throws Exception
     */
    public function setUp(): void {
        /**
         * @uses ReservationBuilder
         */
        $this->reservation = Builder::a('Reservation');
    }

    /**
     * @test
     * @return void
     */
    public function shouldReturnInstanceOfReservation(): void {
        $this->assertInstanceOf(Reservation::class, $this->reservation);
    }

}