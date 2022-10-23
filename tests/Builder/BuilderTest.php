<?php
declare(strict_types=1);

namespace Huppys\BookMe\tests\Builder;

use PHPUnit\Framework\TestCase;

class BuilderTest extends TestCase {

    /**
     * @test
     * @return void
     */
    public function shouldHaveBuilderForEveryClassImplementingBuildableInterface(): void {
        $buildableClasses = [];
        $this->markTestIncomplete('Test is to be implemented');
    }
}