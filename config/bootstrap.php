<?php
/*
 * sets up paths, loads .env and composer autoload.
 * public/index.php includes this once before any page runs
 */
define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');
define('VIEW_PATH', APP_PATH . '/Views');
define('CONFIG_PATH', ROOT_PATH . '/config');
define('UPLOAD_PATH', ROOT_PATH . '/public/uploads');

// simple .env reader (KEY=VALUE lines, # for comments). real env vars take priority
$envFile = ROOT_PATH . '/.env';
if (is_readable($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#' || strpos($line, '=') === false) continue;
        [$k, $v] = array_map('trim', explode('=', $line, 2));
        $v = trim($v, "\"'");
        if (getenv($k) === false) { putenv("$k=$v"); $_ENV[$k] = $v; }
    }
}

function env(string $key, $default = null) {
    $v = getenv($key);
    return ($v === false || $v === '') ? $default : $v;
}

if (is_readable(ROOT_PATH . '/vendor/autoload.php')) {
    require_once ROOT_PATH . '/vendor/autoload.php';
}
require_once APP_PATH . '/Models/Database.php';
require_once CONFIG_PATH . '/mail.php';
