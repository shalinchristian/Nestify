<?php
/**
 * Front router. Old URLs keep working: /User/Home.php, /Agent/AgentDashboard.php,
 * /User/images/..., /uploads/... . Lookup is case-insensitive because the
 * original code mixes header.php/Header.php, style.css/Style.css, etc.
 *
 * Dev:  php -S localhost:8000 -t public public/index.php
 * Apache: see public/.htaccess
 */
require_once dirname(__DIR__) . '/config/bootstrap.php';

$path = rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/');
$path = '/' . ltrim(str_replace('\\', '/', $path), '/');
if (strpos($path, '..') !== false) { http_response_code(400); exit('Bad request'); }

// Let the built-in server serve real files under public/ (uploads, assets).
if (PHP_SAPI === 'cli-server' && $path !== '/' && is_file(__DIR__ . $path)) {
    return false;
}

if ($path === '/' || $path === '/index.php') { header('Location: /User/Home.php'); exit; }

if (!preg_match('#^/(agent|user)/(.+)$#i', $path, $m)) { http_response_code(404); exit('Not found'); }
$role = strtolower($m[1]);
$file = $m[2];
define('NESTIFY_ROLE', $role);

/** case-insensitive file lookup inside $dir */
function nestify_find(string $dir, string $rel): ?string {
    $cur = $dir;
    foreach (explode('/', $rel) as $part) {
        if (!is_dir($cur)) return null;
        $hit = null;
        foreach (scandir($cur) as $e) { if (strcasecmp($e, $part) === 0) { $hit = $e; break; } }
        if ($hit === null) return null;
        $cur .= '/' . $hit;
    }
    return is_file($cur) ? $cur : null;
}

$aliases = ['forgot_password.php' => 'forget_password.php']; // dashboards link the misspelt name
$file = $aliases[strtolower($file)] ?? $file;

if (preg_match('/\.php$/i', $file)) {
    $Role = ucfirst($role);
    $target = nestify_find(APP_PATH . "/Controllers/$Role", $file)
        ?? nestify_find(VIEW_PATH . "/$role", $file)
        ?? nestify_find(VIEW_PATH . '/shared', $file)
        ?? nestify_find(APP_PATH . '/Controllers', $file);
    if ($target && strpos(basename($target), '.') !== false && !str_contains($target, '/partials/')) {
        // Buffer page output so header('Location: ...') still works after HTML was echoed
        // (several pages print the header/"Login First!" before their auth redirect).
        ob_start();
        chdir(dirname($target));
        require $target;
        return;
    }
    http_response_code(404); exit('Page not found');
}

// Static assets referenced relatively from pages (Style.css, AP.js, images/...)
$asset = nestify_find(__DIR__ . "/assets/$role", $file) ?? nestify_find(__DIR__ . '/assets/shared', $file);
if ($asset) {
    $types = ['css'=>'text/css','js'=>'application/javascript','png'=>'image/png','jpg'=>'image/jpeg','jpeg'=>'image/jpeg','gif'=>'image/gif','svg'=>'image/svg+xml','webp'=>'image/webp'];
    header('Content-Type: ' . ($types[strtolower(pathinfo($asset, PATHINFO_EXTENSION))] ?? 'application/octet-stream'));
    readfile($asset);
    return;
}
http_response_code(404); echo 'Not found';
