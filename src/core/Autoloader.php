<?php
// src/core/Autoloader.php

namespace Liberta_Mobile\Core;

class Autoloader {
    public function register() {
        spl_autoload_register(function ($class) {
            $prefix = 'Liberta_Mobile\\';
            $base_dir = __DIR__ . '/../';

            $len = strlen($prefix);
            if (strncmp($prefix, $class, $len) !== 0) return;

            $relative_class = substr($class, $len);
            $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

            if (file_exists($file)) {
                require $file;
            } else {
                throw new \Exception("Fichier non trouvé : $file");
            }
        });
    }
}