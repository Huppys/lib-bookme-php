<?php
declare(strict_types=1);

namespace Huppys\BookMe\tests\Builders;

abstract class BaseBuilder {
    protected mixed $_entity;

    protected function setEntity(mixed $value): void {
        $this->_entity = $value;
    }

    public function getEntity(): object | array {
        return $this->_entity;
    }
}