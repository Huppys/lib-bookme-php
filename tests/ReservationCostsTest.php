<?php

declare(strict_types=1);

use Huppys\BookMe\ReservationBaseTest;

final class ReservationCostsTest extends ReservationBaseTest {

    private float $_costs = 100.0;
    private float $_bookableTaxAmount = 7.0;

    public function testReservationCostsForTwoDays(): void {
        $this->assertEquals(($this->_costs * $this->_reservationDurationInDays) * (1.0 + ($this->_bookableTaxAmount / 100)), $this->reservation->calculateCosts());
    }

}
