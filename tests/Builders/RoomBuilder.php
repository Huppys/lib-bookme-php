<?php

namespace BookMe\Tests\Builders;

use BookMe\Room;

class RoomBuilder extends BaseBuilder {

    public function __construct() {

        $service = new Room(
            'Santa Fe',
        );

        $this->setEntity($service);
    }
}