<?php
declare(strict_types=1);

namespace Huppys\BookMe\tests;

use Exception;

final class ReservationCostsTest extends ReservationBaseTest {

    /**
     * @test
     * @throws Exception
     */
    public function shouldCalculateReservationCostsForTwoDays(): void {
        $this->assertEquals(($this->_priceSummerTariff + $this->_priceWinterTariff) * (1.0 + ($this->_bookableTaxAmount / 100)), $this->reservation->calculateCosts());
    }

}
