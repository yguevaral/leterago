<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2694246e9e860a501fc70e3d087b4b96
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2694246e9e860a501fc70e3d087b4b96::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2694246e9e860a501fc70e3d087b4b96::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit2694246e9e860a501fc70e3d087b4b96::$classMap;

        }, null, ClassLoader::class);
    }
}
