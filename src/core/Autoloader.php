<?php
// src/Core/Autoloader.php

namespace Liberta_Mobile\Core;

class Autoloader {
    public function register() {
        spl_autoload_register(function ($class) {
            $prefix = 'Liberta_Mobile\\';
            $base_dir = __DIR__ . '/../';

            $len = strlen($prefix);
            if (strncmp($prefix, $class, $len) !== 0) return;

            $relative_class = substr($class, $len);
            // Conserver la casse pour éviter les problèmes sur les systèmes sensibles à la casse
            $relative_path = str_replace('\\', '/', $relative_class);
            $file = $base_dir . $relative_path . '.php';
            
            // Essayer avec le chemin exact d'abord
            if (file_exists($file)) {
                require $file;
                return;
            }
            
            // Si le fichier n'existe pas, essayons de trouver le fichier indépendamment de la casse
            // Cela est utile sur les systèmes de fichiers sensibles à la casse comme Linux
            $directory = dirname($base_dir . $relative_path);
            $filename = basename($relative_path) . '.php';
            
            if (is_dir($directory)) {
                $files = scandir($directory);
                foreach ($files as $f) {
                    if (strtolower($f) === strtolower($filename)) {
                        require $directory . '/' . $f;
                        return;
                    }
                }
            }
        });
    }
}
