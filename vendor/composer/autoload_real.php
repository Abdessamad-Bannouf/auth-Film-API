<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitb6263ccc8ed72cfa1e0e7d76ba6686ce
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInitb6263ccc8ed72cfa1e0e7d76ba6686ce', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitb6263ccc8ed72cfa1e0e7d76ba6686ce', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitb6263ccc8ed72cfa1e0e7d76ba6686ce::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
