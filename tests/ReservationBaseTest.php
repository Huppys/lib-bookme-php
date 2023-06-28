<?php

declare(strict_types=1);

namespace BookMe\Tests;

use BookMe\Entity\Bookable;
use BookMe\Entity\Reservation;
use BookMe\Service\ReservationService;
use BookMe\Tests\Builder\BuilderGenerator;
use DateTimeImmutable;
use Exception;
use PHPUnit\Framework\TestCase;

class ReservationBaseTest extends TestCase {

    protected Reservation $reservation;
    protected DateTimeImmutable $checkInDate;
    protected DateTimeImmutable $checkOutDate;
    protected Bookable $bookableEntity;
    protected ReservationService $reservationService;
    /**
     * @throws Exception
     */
    public function setUp(): void {

        $this->reservationService = new ReservationService();

        /**
         * @uses \BookMe\Tests\Builders\ReservationBuilder
         */
        $this->reservation = BuilderGenerator::a('Reservation');
    }

    /**
     * @test
     * @return void
     */
    public function shouldReturnInstanceOfReservation(): void {
        $this->assertInstanceOf(Reservation::class, $this->reservation);
    }

}