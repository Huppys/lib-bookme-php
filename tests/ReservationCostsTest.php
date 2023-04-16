<?php
declare(strict_types=1);

namespace BookMe\Tests;

use Exception;

final class ReservationCostsTest extends ReservationBaseTest {

    /**
     * @test
     * @throws Exception
     */
    public function shouldCalculateReservationCostsForTwoDays(): void {
        $this->assertEquals(
            (
                $this->reservation->get_bookableEntity()->get_tariffs()[0]->get_price() +
                $this->reservation->get_bookableEntity()->get_tariffs()[1]->get_price()
            ) * (1.0 + ($this->reservation->get_bookableEntity()->get_taxAmount() / 100)), $this->reservationService->calculateCosts($this->reservation)
        );
    }

}
