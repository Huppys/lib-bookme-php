<?php

namespace Huppys\BookMe;

use DateInterval;
use DateTimeImmutable;
use Exception;
use PHPUnit\Framework\TestCase;

class ReservationBaseTest extends TestCase {

    protected Reservation $reservation;
    protected DateTimeImmutable $checkInDate;
    protected DateTimeImmutable $checkOutDate;
    protected Bookable $bookableEntity;
    protected int $_reservationDurationInDays = 2;
    protected string $_bookableTitle = "Ferienhaus Seepferdchen";


    /**
     * @throws Exception
     */
    public function setUp(): void {
        $date_interval = 'P' . $this->_reservationDurationInDays . 'D';
        $_reservationDuration = new DateInterval($date_interval);

        $now = new DateTimeImmutable('now');
        $this->checkInDate = new DateTimeImmutable();
        $this->checkOutDate = $now->add($_reservationDuration);

        $_tariffSummer = new Tariff($this->checkInDate, $this->checkOutDate, 100.0, "Summer");
        $_tariffWinter = new Tariff($this->checkInDate, $this->checkOutDate, 50.0, "Winter");
        $_tariffs = array($_tariffSummer, $_tariffWinter);

        $this->bookableEntity = new Bookable(1, 1.0, 7.0, $_tariffs, $this->_bookableTitle);

        $this->reservation = new Reservation($this->checkInDate, $this->checkOutDate, $this->bookableEntity);
    }

}