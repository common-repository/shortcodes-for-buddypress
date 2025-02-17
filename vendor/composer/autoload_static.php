<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit773bbb0c992842a2a3663dbab73b0ed7
{
    public static $prefixLengthsPsr4 = array (
        'H' => 
        array (
            'HardG\\BuddyPress120URLPolyfills\\' => 32,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'HardG\\BuddyPress120URLPolyfills\\' => 
        array (
            0 => __DIR__ . '/..' . '/hard-g/buddypress-12.0-url-polyfills/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit773bbb0c992842a2a3663dbab73b0ed7::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit773bbb0c992842a2a3663dbab73b0ed7::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit773bbb0c992842a2a3663dbab73b0ed7::$classMap;

        }, null, ClassLoader::class);
    }
}
