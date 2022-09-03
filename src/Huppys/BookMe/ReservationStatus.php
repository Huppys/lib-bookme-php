<?php

namespace Huppys\BookMe;

enum ReservationStatus {
    case Created;
    case Confirmed;
    case Rejected;
    case Paid;
    case Canceled;
    case Deleted;
}