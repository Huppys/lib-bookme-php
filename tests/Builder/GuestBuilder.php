<?php
declare(strict_types=1);

namespace Huppys\BookMe\tests\Builder;

class GuestBuilder extends BaseBuilder implements Builder {

    public function __construct() {
        return $this;
    }

    public function setEntity(\Ds\Map $value) {
        $this->_entity = $value;
    }
}