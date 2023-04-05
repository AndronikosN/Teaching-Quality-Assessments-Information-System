<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc79686ceee963dcb8ef9a7c63f815125
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

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc79686ceee963dcb8ef9a7c63f815125::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc79686ceee963dcb8ef9a7c63f815125::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitc79686ceee963dcb8ef9a7c63f815125::$classMap;

        }, null, ClassLoader::class);
    }
}