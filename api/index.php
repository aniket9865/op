<?php

// Create writable directories in /tmp
$tmpDirs = [
    '/tmp/views',
    '/tmp/cache',
    '/tmp/sessions'
];

foreach ($tmpDirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// Forward request to Laravel
require __DIR__ . '/../public/index.php';
