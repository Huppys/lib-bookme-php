<?php

namespace BookMe\Tests\Builders;

use BookMe\Extra;

class ExtraBuilder extends BaseBuilder {

    public function __construct() {

        $service = new Extra(
            1,
            'Clean-up',
            25.0,
            7.0,
            'Clean-up after leave'
        );

        $this->setEntity($service);
    }
}