<?php

namespace Huppys\BookMe\tests\Builder;

use Huppys\BookMe\Service;

class ServiceBuilder extends BaseBuilder {
    public function __construct() {
        parent::__construct();

        $service = new Service(1, 'Clean-up', 150.0, 7.0, 'Clean-up after leave');

        $this->setEntity($service);
    }
}