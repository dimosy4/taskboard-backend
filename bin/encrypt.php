<?php
require dirname(__DIR__).'/bootstrap/app.php';
if (!isset($argv[1])) { fwrite(STDERR,"Usage: php bin/encrypt.php VALUE\n"); exit(1); }
echo \App\Support\Config::encrypt($argv[1]).PHP_EOL;
