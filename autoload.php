<?php

spl_autoload_register(function ($class) {
    
    // Danh sách namespace cần load
    $namespaces = [
        'App\\'     => __DIR__ . '/App/',
        'Shared\\'  => __DIR__ . '/Shared/',
        'Route\\'  => __DIR__ . '/'
    ];
    foreach ($namespaces as $prefix => $baseDir) {
        if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
            continue;
        }
       
        $relativeClass = substr($class, strlen($prefix)); 
        $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
        if (file_exists($file)) {
        
            require_once $file;
            return;
        }
    }
    $errorCode = 500;
    $errorMessage = "Không tìm thấy class '$class'";
    require __DIR__ . '/App/Views/Error/Error.php';
    exit;
});

