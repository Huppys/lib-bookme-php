<?php
declare(strict_types=1);

namespace Huppys\BookMe\tests\Builder;

interface Builder {
    public function setEntity(\Ds\Map $value);
}