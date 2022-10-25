<?php

namespace Huppys\BookMe\tests\Builder;

use DateInterval;
use DateTimeImmutable;
use Exception;
use Huppys\BookMe\Tariff;

class TariffBuilder extends BaseBuilder {
    /**
     * @throws Exception
     */
    public function __construct() {
        parent::__construct();

        $date_interval = 'P2D';
        $reservationDuration = new DateInterval($date_interval);

        $now = DateTimeImmutable::createFromFormat('Y-m-d|', date('Y-m-d'));
        $this->checkInDate = clone($now);
        $this->checkOutDate = clone ($now)->add($reservationDuration);

        // Summer tariff starts one day before checkin
        $tariffSummerStart = clone ($this->checkInDate)->sub(new DateInterval('P1D'));
        // Summer tariff ends on checkin day, so checkin is in summer tariff
        $tariffSummerEnd = clone($this->checkInDate);

        // Winter tariff starts one after summer tariff end
        $tariffWinterStart = clone ($tariffSummerEnd)->add(new DateInterval('P1D'));
        // Summer tariff ends one day after checkout
        $tariffWinterEnd = clone ($this->checkOutDate)->add(new DateInterval('P1D'));

        $tariffSummer = new Tariff($tariffSummerStart, $tariffSummerEnd, 100.0, 'Summer');
        $tariffWinter = new Tariff($tariffWinterStart, $tariffWinterEnd, 50.0, 'Winter');

        $tariffs = array($tariffSummer, $tariffWinter);

        $this->setEntity($tariffs);
    }

    /**
     * @throws Exception
     */
    public static function getTariffsWithDateGap(): array {
        $now = DateTimeImmutable::createFromFormat('Y-m-d|', date('Y-m-d'));

        $tariffSummerStart = clone($now);
        $tariffSummerEnd = clone ($now)->add(new DateInterval('P1D'));

        $tariffWinterStart = clone ($now)->add(new DateInterval('P3D'));
        $tariffWinterEnd = clone ($now)->add(new DateInterval('P4D'));

        $tariffSummer = new Tariff($tariffSummerStart, $tariffSummerEnd, 100.0, 'Summer');
        $tariffWinter = new Tariff($tariffWinterStart, $tariffWinterEnd, 50.0, 'Winter');

        return array($tariffSummer, $tariffWinter);
    }
}