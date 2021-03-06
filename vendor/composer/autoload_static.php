<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit5284d30559b2c016aa23ddab8259fc5c
{
    public static $prefixesPsr0 = array (
        'j' => 
        array (
            'jc21' => 
            array (
                0 => __DIR__ . '/..' . '/jc21/clitable/src',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInit5284d30559b2c016aa23ddab8259fc5c::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit5284d30559b2c016aa23ddab8259fc5c::$classMap;

        }, null, ClassLoader::class);
    }
}
