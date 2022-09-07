<?php

namespace Huppys\BookMe;

enum ReservationStatus {
    /* User requested a reservation */
    case Created;

    /* A reservation was confirmed */
    case Confirmed;

    /* A reservation was rejected */
    case Rejected;

    /* A reservation is paid */
    case Paid;

    /* A reservation ended after the checkout */
    case Ended;

    /* A reservation is canceled by any party */
    case Canceled;

    /* A reservation is deleted */
    case Deleted;
}