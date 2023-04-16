<?php

namespace BookMe\Tests;

use BookMe\Service\ReservationService;
use Exception;
use BookMe\Extra;
use BookMe\Tests\Builders\ReservationBuilder;

class ReservationWithExtraCostsTest extends ReservationBaseTest {

    public function setUp(): void {

        parent::setUp();

        /**
         * @uses ReservationBuilder
         */
        $this->reservation = ReservationBuilder::reservationWithExtra();
    }

    /**
     * @test
     * @throws Exception
     */
    public function shouldCalculateReservationCostsForTwoDays(): void {
        $this->assertEquals(
              (
                  $this->reservation->get_bookableEntity()->get_tariffs()[0]->get_price() +
                  $this->reservation->get_bookableEntity()->get_tariffs()[1]->get_price()
              ) * (1.0 + ($this->reservation->get_bookableEntity()->get_taxAmount() / 100)) +
              $this->mapExtrasToCosts($this->reservation->get_extras())
            , $this->reservationService->calculateCosts($this->reservation)
        );
    }

    /**
     * @param Extra[] $extras
     * @return array|null
     */
    function mapExtrasToCosts(array $extras): ?float {
        return array_sum(array_map(fn($extra): float => $extra->get_costs(), $extras));
    }
}