<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit8d070178755c320c69f93ee4800660ef
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Sts\\' => 4,
        ),
        'C' => 
        array (
            'Core\\' => 5,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Sts\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/Sts',
        ),
        'Core\\' => 
        array (
            0 => __DIR__ . '/../..' . '/core',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Core\\Config' => __DIR__ . '/../..' . '/core/Config.php',
        'Core\\ConfigController' => __DIR__ . '/../..' . '/core/ConfigController.php',
        'Core\\ConfigView' => __DIR__ . '/../..' . '/core/ConfigView.php',
        'Sts\\Controllers\\Api' => __DIR__ . '/../..' . '/app/Sts/Controllers/Api.php',
        'Sts\\Controllers\\Home' => __DIR__ . '/../..' . '/app/Sts/Controllers/Home.php',
        'Sts\\Controllers\\Login' => __DIR__ . '/../..' . '/app/Sts/Controllers/Login.php',
        'Sts\\Controllers\\Pokedex' => __DIR__ . '/../..' . '/app/Sts/Controllers/Pokedex.php',
        'Sts\\Models\\ApiToDb' => __DIR__ . '/../..' . '/app/Sts/Models/ApiToDb.php',
        'Sts\\Models\\GetApi' => __DIR__ . '/../..' . '/app/Sts/Models/GetApi.php',
        'Sts\\Models\\Helper\\StsConn' => __DIR__ . '/../..' . '/app/Sts/Models/Helper/StsConn.php',
        'Sts\\Models\\Helper\\StsCreate' => __DIR__ . '/../..' . '/app/Sts/Models/Helper/StsCreate.php',
        'Sts\\Models\\Helper\\StsRead' => __DIR__ . '/../..' . '/app/Sts/Models/Helper/StsRead.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit8d070178755c320c69f93ee4800660ef::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit8d070178755c320c69f93ee4800660ef::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit8d070178755c320c69f93ee4800660ef::$classMap;

        }, null, ClassLoader::class);
    }
}
