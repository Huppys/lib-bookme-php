<?php

namespace BookMe;

enum ReservationStatus: string {
    /* User requested a reservation */
    case Created = 'Created';

    /* A reservation was confirmed */
    case Confirmed = 'Confirmed';

    /* A reservation was rejected */
    case Rejected = 'Rejected';

    /* A reservation is paid */
    case Paid = 'Paid';

    /* A reservation ended after the checkout */
    case Ended = 'Ended';

    /* A reservation is canceled by any party */
    case Canceled = 'Canceled';

    /* A reservation is deleted */
    case Deleted = 'Deleted';
}