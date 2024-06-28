<?php
spl_autoload_register(function ($class) {
    // Define the base directory for the namespace prefix
    $baseDir = __DIR__ . '/src/';

    // Replace the namespace prefix with the base directory, replace namespace separators with directory separators in the class name, append with .php
    $file = $baseDir . str_replace('\\', '/', $class) . '.php';
    
    
    // If the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});
