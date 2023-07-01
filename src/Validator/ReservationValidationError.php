<?php

namespace BookMe\Validator;

enum ReservationValidationError {

    case CheckInIsAfterCheckoutDate;
    case CheckInDateIsTooEarly;
    case CheckoutDateIsTooLate;
    case Valid;
}
