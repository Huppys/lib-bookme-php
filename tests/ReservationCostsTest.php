<?php

declare(strict_types=1);

namespace Huppys\BookMe\tests;

use Exception;

final class ReservationCostsTest extends ReservationBaseTest {

    /**
     * @throws Exception
     */
    public function testReservationCostsForTwoDays(): void {
        $this->assertEquals(($this->_priceSummerTariff + $this->_priceWinterTariff) * (1.0 + ($this->_bookableTaxAmount / 100)), $this->reservation->calculateCosts());
    }

}
