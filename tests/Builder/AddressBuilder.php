<?php

namespace Huppys\BookMe\tests\Builder;

use Huppys\BookMe\Address;

class AddressBuilder extends BaseBuilder {
    public function __construct() {
        parent::__construct();
        $address = new Address('TestCity', 'TestStreet', '1a', '12345');

        $this->setEntity($address);
    }
}