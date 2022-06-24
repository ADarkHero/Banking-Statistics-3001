<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit61d53a12430de145b58569dc0bba1bd8
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Psr\\Log\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
    );

    public static $prefixesPsr0 = array (
        'T' => 
        array (
            'Tests\\Fhp' => 
            array (
                0 => __DIR__ . '/..' . '/nemiah/php-fints/lib',
            ),
        ),
        'F' => 
        array (
            'Fhp' => 
            array (
                0 => __DIR__ . '/..' . '/nemiah/php-fints/lib',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit61d53a12430de145b58569dc0bba1bd8::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit61d53a12430de145b58569dc0bba1bd8::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit61d53a12430de145b58569dc0bba1bd8::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
