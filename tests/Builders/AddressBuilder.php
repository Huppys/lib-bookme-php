<?php

namespace BookMe\Tests\Builders;

use BookMe\Address;

class AddressBuilder extends BaseBuilder {

    public function __construct() {

        $address = new Address(
            'TestCity',
            'TestStreet',
            '1a',
            '12345',
            'DE'
        );

        $this->setEntity($address);
    }
}