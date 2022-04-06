<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitac8aecd2906716016008a861e905e67c
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitac8aecd2906716016008a861e905e67c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitac8aecd2906716016008a861e905e67c::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}