<?php
require dirname(__DIR__).'/vendor/autoload.php';
// Minimal .env reader (do not overwrite externally configured environment variables).
$envFile = dirname(__DIR__).'/.env';
if (is_file($envFile)) foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
    $line = trim($line);
    if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) continue;
    [$name,$value] = explode('=', $line, 2);
    $name = trim($name); $value = trim($value, " \t\n\r\0\x0B\"'");
    if (getenv($name) === false) putenv($name.'='.$value);
}
\App\Support\Config::load(dirname(__DIR__).'/config/app.php');
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection(\App\Support\Config::get('db'));
$capsule->setEventDispatcher(new \Illuminate\Events\Dispatcher(new \Illuminate\Container\Container));
$capsule->setAsGlobal(); $capsule->bootEloquent();
return $capsule;
