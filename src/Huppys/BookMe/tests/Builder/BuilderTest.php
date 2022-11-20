<?php
declare(strict_types=1);

namespace Huppys\BookMe\tests\Builder;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Finder\Finder;

class BuilderTest extends TestCase {

    public function getAllNameSpaces($path) {
        $filenames = $this->getFilenames($path);
        $namespaces = [];
        foreach ($filenames as $filename) {
            $namespaces[] = $this->getFullNamespace($filename) . '\\' . $this->getClassName($filename);
        }
        return $namespaces;
    }

    private function getClassName($filename) {
        $directoriesAndFilename = explode('/', $filename);
        $filename = array_pop($directoriesAndFilename);
        $nameAndExtension = explode('.', $filename);
        $className = array_shift($nameAndExtension);
        return $className;
    }

    private function getFullNamespace($filename) {
        $lines = file($filename);
        $array = preg_grep('/^namespace /', $lines);
        $namespaceLine = array_shift($array);
        $match = [];
        preg_match('/^namespace (.*);$/', $namespaceLine, $match);
        $fullNamespace = array_pop($match);

        return $fullNamespace;
    }

    private function getFilenames($path) {
        $finderFiles = Finder::create()->files()->in($path)->name('*.php');
        $filenames = [];
        foreach ($finderFiles as $finderFile) {
            $filenames[] = $finderFile->getRealpath();
        }
        return $filenames;
    }

    private function getBuildableClasses(): array {
        $filenames = $this->getFilenames('../../');

        $buildableClasses = [];

        foreach ($filenames as $filename) {

            if ($this->getFullNamespace($filename) == 'Huppys\BookMe') {
                // TODO OWI: Create map with [className] => filepath
                include_once $filename;
            }
        }


        foreach (get_declared_classes() as $declared_class) {

            /** @var array $implementedInterfaces */
            $implementedInterfaces = class_implements($declared_class);

            if (array_key_exists('Huppys\BookMe\Buildable', $implementedInterfaces)) {
                $buildableClasses[] = $declared_class;
            }
        }

        return $buildableClasses;
    }

    private function getBuilderClasses(): array {
        $filenames = $this->getFilenames('../Builders');

        foreach ($filenames as $filename) {

            if ($this->getFullNamespace($filename) == 'Huppys\BookMe\tests\Builders') {
                include_once $filename;
            }
        }

        $builderClasses = [];

        foreach (get_declared_classes() as $declared_class) {

            if (array_key_exists('Huppys\BookMe\tests\Builders\BaseBuilder', class_parents($declared_class))) {
                $builderClasses[] = $declared_class;
            }
        }

        return $builderClasses;
    }

    /**
     * @test
     * @return void
     */
    public function shouldHaveBuilderForEveryClassImplementingBuildableInterface(): void {

        $this->assertEquals(count($this->getBuildableClasses()), count($this->getBuilderClasses()));

    }
}