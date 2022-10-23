<?php

declare(strict_types=1);

namespace Huppys\BookMe\tests;

use DateInterval;
use DateTimeImmutable;
use Exception;
use Huppys\BookMe\Bookable;
use Huppys\BookMe\Reservation;
use Huppys\BookMe\Tariff;
use PHPUnit\Framework\TestCase;

class ReservationBaseTest extends TestCase {

    protected Reservation $reservation;
    protected DateTimeImmutable $checkInDate;
    protected DateTimeImmutable $checkOutDate;
    protected Bookable $bookableEntity;
    protected int $_reservationDurationInDays = 2;
    protected string $_bookableTitle = 'Ferienhaus Seepferdchen';
    protected float $_priceSummerTariff = 100.0;
    protected float $_priceWinterTariff = 50.0;
    protected float $_bookableTaxAmount = 7.0;


    /**
     * @throws Exception
     */
    public function setUp(): void {
        $date_interval = 'P' . $this->_reservationDurationInDays . 'D';
        $_reservationDuration = new DateInterval($date_interval);

        $now = DateTimeImmutable::createFromFormat('Y-m-d|', date('Y-m-d'));
        $this->checkInDate = clone($now);
        $this->checkOutDate = clone($now)->add($_reservationDuration);

        // Summer tariff starts one day before checkin
        $_tariffSummerStart = clone($this->checkInDate)->sub(new DateInterval('P1D'));
        // Summer tariff ends on checkin day, so checkin is in summer tariff
        $_tariffSummerEnd = clone($this->checkInDate);

        // Winter tariff starts one after summer tariff end
        $_tariffWinterStart = clone($_tariffSummerEnd)->add(new DateInterval('P1D'));
        // Summer tariff ends one day after checkout
        $_tariffWinterEnd = clone($this->checkOutDate)->add(new DateInterval('P1D'));

        $_tariffSummer = new Tariff($_tariffSummerStart, $_tariffSummerEnd, $this->_priceSummerTariff, 'Summer');
        $_tariffWinter = new Tariff($_tariffWinterStart, $_tariffWinterEnd, $this->_priceWinterTariff, 'Winter');
        $_tariffs = array($_tariffSummer, $_tariffWinter);

        $this->bookableEntity = new Bookable(1, 7.0, $_tariffs, $this->_bookableTitle);

        $this->reservation = new Reservation($this->checkInDate, $this->checkOutDate, $this->bookableEntity);
    }

    /**
     * @test
     * @return void
     */
    public function shouldReturnInstanceOfReservation(): void {
        $this->assertInstanceOf(Reservation::class, $this->reservation);
    }

}