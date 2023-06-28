<?php

namespace BookMe\Tests\Builders;

use BookMe\Entity\Extra;

class ExtraBuilder extends BaseBuilder {

    public function __construct() {

        $service = new Extra(
            'Clean-up',
            25.0,
            7.0,
            'Clean-up after leave'
        );

        $this->setEntity($service);
    }
}