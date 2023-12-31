<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitbfde9d0413945d3febac7f4e3be784f0
{
    public static $prefixLengthsPsr4 = array (
        'V' => 
        array (
            'Valitron\\' => 9,
        ),
        'L' => 
        array (
            'Laminas\\Stdlib\\' => 15,
            'Laminas\\Db\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Valitron\\' => 
        array (
            0 => __DIR__ . '/..' . '/vlucas/valitron/src/Valitron',
        ),
        'Laminas\\Stdlib\\' => 
        array (
            0 => __DIR__ . '/..' . '/laminas/laminas-stdlib/src',
        ),
        'Laminas\\Db\\' => 
        array (
            0 => __DIR__ . '/..' . '/laminas/laminas-db/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'U' => 
        array (
            'Upload' => 
            array (
                0 => __DIR__ . '/..' . '/scoumbourdis/upload/src',
            ),
        ),
        'P' => 
        array (
            'PHPExcel' => 
            array (
                0 => __DIR__ . '/..' . '/scoumbourdis/phpexcel/Classes',
            ),
        ),
        'G' => 
        array (
            'GroceryCrud' => 
            array (
                0 => __DIR__ . '/..' . '/grocery-crud/enterprise/src',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitbfde9d0413945d3febac7f4e3be784f0::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitbfde9d0413945d3febac7f4e3be784f0::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInitbfde9d0413945d3febac7f4e3be784f0::$prefixesPsr0;
            $loader->classMap = ComposerStaticInitbfde9d0413945d3febac7f4e3be784f0::$classMap;

        }, null, ClassLoader::class);
    }
}
