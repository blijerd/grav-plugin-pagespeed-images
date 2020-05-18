<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite863a36850238c27fe275e4df5c3a50c
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'WebPConvert\\' => 12,
        ),
        'P' => 
        array (
            'PHPHtmlParser\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'WebPConvert\\' => 
        array (
            0 => __DIR__ . '/..' . '/rosell-dk/webp-convert/src',
        ),
        'PHPHtmlParser\\' => 
        array (
            0 => __DIR__ . '/..' . '/paquettg/php-html-parser/src/PHPHtmlParser',
        ),
    );

    public static $prefixesPsr0 = array (
        's' => 
        array (
            'stringEncode' => 
            array (
                0 => __DIR__ . '/..' . '/paquettg/string-encode/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite863a36850238c27fe275e4df5c3a50c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite863a36850238c27fe275e4df5c3a50c::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInite863a36850238c27fe275e4df5c3a50c::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
