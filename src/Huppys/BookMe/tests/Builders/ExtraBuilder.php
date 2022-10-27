<?php

namespace Huppys\BookMe\tests\Builders;

use Huppys\BookMe\Extra;

class ExtraBuilder extends BaseBuilder {
    public function __construct() {
        $service = new Extra(1, 'Clean-up', 150.0, 7.0, 'Clean-up after leave');

        $this->setEntity($service);
    }
}