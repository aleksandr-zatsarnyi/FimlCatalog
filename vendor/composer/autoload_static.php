<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit8eee028cef2c83ec21220a8b4fd9e6d9
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\Server\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\Server\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/server',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit8eee028cef2c83ec21220a8b4fd9e6d9::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit8eee028cef2c83ec21220a8b4fd9e6d9::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit8eee028cef2c83ec21220a8b4fd9e6d9::$classMap;

        }, null, ClassLoader::class);
    }
}