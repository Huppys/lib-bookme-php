<?php
declare(strict_types=1);

namespace Huppys\BookMe\tests\Builder;

use Exception;
use Huppys\BookMe\Buildable;

class Builder {

    /**
     * @throws Exception
     */
    public static function a(string $className): mixed {
        if (!self::entityClassIsBuildable($className)) {
            throw new Exception('Entity class does not exist.');
        }

        if (!self::builderClassExists($className)) {
            throw new Exception('No builder found for given entity class');
        }

        try {
            $builderName = $className . 'Builder';
            $entityClassPath = 'Huppys\\BookMe\\tests\\Builder\\' . $builderName;
            $instance = new $entityClassPath();
            return $instance->getEntity();
        } catch (Exception $e) {
            throw new Exception('Class ' . $entityClassPath . ' could no be instantiated.' . $e);
        }
    }

    /**
     * @param string $className
     * @return bool
     * @throws Exception
     */
    public static function entityClassIsBuildable(string $className): bool {
        $entityClassDirPath = './src/Huppys/BookMe/';
        $entityClassBasePath = $entityClassDirPath . $className . '.php';
        if (file_exists($entityClassBasePath)) {
            return self::entityClassImplementsBuildable($className);
        } else {
            echo new Exception('File ' . $entityClassBasePath . ' not found.');
            return false;
        }
    }

    /**
     * @param string $className
     * @return bool
     */
    public static function entityClassImplementsBuildable(string $className): bool {
        $classPath = 'Huppys\\BookMe\\' . $className;

        $implemented_interfaces = class_implements($classPath);

        if (!array_search(Buildable::class, $implemented_interfaces)) {
            echo new Exception('Class does not implement the ' . Buildable::class . '.');
            return false;
        }

        return true;
    }

    /**
     * @param string $className
     * @return bool
     * @throws Exception
     */
    public static function builderClassExists(string $className): bool {
        $testBuildersPath = './tests/Builder/';
        $builderBasePath = $className . 'Builder.php';
        $builderPath = $testBuildersPath . $builderBasePath;
        if (file_exists($builderPath)){
            return true;
        } else {
            echo new Exception('Builder does not exist under ' . $builderPath);
            return false;
        }
    }
}