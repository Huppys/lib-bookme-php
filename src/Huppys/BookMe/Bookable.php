<?php declare(strict_types=1);

namespace Huppys\BookMe;


use DateTime;
use DateTimeImmutable;
use Error;
use Exception;
use InvalidArgumentException;
use When\When;

class Bookable implements Buildable {
    private int $_id;
    private string $_title;
    private array $_rooms = [Room::class];
    private Address $_address;
    private float $_taxAmount;
    /* @var $_tariffs Tariff[] */
    private array $_tariffs;

    function __construct(int $id, float $taxAmount, array $tariffs, string $title = "") {
        $this->_id = $id;
        $this->_title = $title;
        $this->_taxAmount = $taxAmount;
        $this->setTariffs($tariffs);
    }

    /**
     * @param Tariff[] $tariffs
     * @return bool
     */
    private static function hasValidTariffs(array $tariffs): bool {
        for ($i = 0; $i < count($tariffs) - 1; $i++) {

            $currentTariff = $tariffs[$i];
            $nextTariff = $tariffs[$i + 1];

            if ($currentTariff->get_end()->diff($nextTariff->get_start())->d != 1) {
                throw new InvalidArgumentException(
                    sprintf(
                        "The date interval between tariff %s and %s is more than one day.",
                        $currentTariff->get_title(), $nextTariff->get_title()
                    )
                );
            }
        }
        return true;
    }

    /**
     * @return int
     */
    public function get_id(): int {
        return $this->_id;
    }

    /**
     * @return array
     */
    function get_rooms(): array {
        return $this->_rooms;
    }

    /**
     * @return Address
     */
    public function get_address(): Address {
        return $this->_address;
    }

    /**
     * @param Address $address
     */
    public function set_address(Address $address): void {
        $this->_address = $address;
    }

    /**
     * @return string
     */
    public function get_title(): string {
        return $this->_title;
    }

    /**
     * @return float
     */
    public function get_taxAmount(): float {
        return $this->_taxAmount;
    }

    public function taxRate(): float {
        return 1 + ($this->_taxAmount / 100);
    }

    /**
     * @throws Exception
     */
    private function getTariffCostsForDate(DateTimeImmutable $startDate, DateTimeImmutable $endDate): float {

        $costs = 0.0;

        /* @var $tariff Tariff */
        foreach ($this->_tariffs as $tariff) {
            $occurrences = $this->getDateOccurrencesInTariff($startDate, $endDate, $tariff);
            if ($occurrences) {
                $costs += count($occurrences) * $tariff->get_price();
            }
        }

        if ($costs != 0.0) {
            return $costs;
        }

        $errorMessage = sprintf("No matching tariffs found for dates from %s to %s", $startDate->format('d.m.Y'), $endDate->format('d.m.Y'));

        throw new Error($errorMessage);
    }

    /**
     * @throws Exception
     */
    private function getDateOccurrencesInTariff(DateTimeImmutable $startDate, DateTimeImmutable $endDate, Tariff $tariff): array {
        $when = new When(DateTime::createFromImmutable($startDate)->format('Y-m-d'));
        $when->freq('daily')->until(DateTime::createFromImmutable($endDate));
        return $when->getOccurrencesBetween(DateTime::createFromImmutable($tariff->get_start()), DateTime::createFromImmutable($tariff->get_end()));
    }

    /**
     * @throws Exception
     */
    public function calculateCosts(DateTimeImmutable $startDate, DateTimeImmutable $endDate): float {
        return $this->getTariffCostsForDate($startDate, $endDate) * $this->taxRate();
    }

    public function get_tariffs(): array {
        return $this->_tariffs;
    }

    /**
     * @param array $tariffs
     */
    public function setTariffs(array $tariffs): void {
        if (self::hasValidTariffs($tariffs)) {
            $this->_tariffs = $tariffs;
        }
    }
}