<?php

namespace BookMe\Tests\Builders;

use BookMe\Entity\Tariff;
use DateInterval;
use DateTimeImmutable;
use Exception;

class TariffBuilder extends BaseBuilder {

    use CheckInCheckOutDateProvider;

    /**
     * @throws Exception
     */
    public function __construct() {

        // Summer tariff starts one day before checkin
        $tariffSummerStart = clone ($this->get_checkInDate())->sub(new DateInterval('P2D'));
        // Summer tariff ends on checkin day, so checkin is in summer tariff
        $tariffSummerEnd = clone($this->get_checkInDate());

        // Winter tariff starts one after summer tariff end
        $tariffWinterStart = clone($tariffSummerEnd)->add(new DateInterval('P1D'));
        // Summer tariff ends one day after checkout
        $tariffWinterEnd = clone ($tariffWinterStart)->add(new DateInterval('P1D'));

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