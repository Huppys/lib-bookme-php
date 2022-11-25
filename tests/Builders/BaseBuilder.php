<?php
declare(strict_types=1);

namespace BookMe\Tests\Builders;

abstract class BaseBuilder {

    protected mixed $_entity;

    protected function setEntity(mixed $value): void {
        $this->_entity = $value;
    }

    /**
     * @see BaseBuilder
     * @noinspection PhpUnused
     */
    public function getEntity(): object | array {
        return $this->_entity;
    }
}