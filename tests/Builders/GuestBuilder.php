<?php
declare(strict_types=1);

namespace BookMe\Tests\Builders;

use BookMe\Entity\Guest;

class GuestBuilder extends BaseBuilder {

    public function __construct() {

        $guest = new Guest(
            'TestFirstname',
            'TestLastname',
            'test@email.tld',
            '12345',
            'TestCity',
            'TestStreet',
            '1'
        );

        $this->setEntity($guest);
    }
}