<?php
$capsule = require dirname(__DIR__).'/bootstrap/app.php';
use Illuminate\Database\Schema\Blueprint;
$s = $capsule->schema();
$s->hasTable('migrations') || $s->create('migrations', function(Blueprint $t) { $t->string('migration')->primary(); $t->timestamp('ran_at')->useCurrent(); });
$files = glob(dirname(__DIR__).'/database/migrations/*.php'); sort($files);
$rollback = in_array('--rollback', $argv, true);
if ($rollback) $files = array_reverse($files);
foreach ($files as $file) {
    $name = basename($file); $exists = $capsule->table('migrations')->where('migration',$name)->exists();
    if ($rollback && !$exists || !$rollback && $exists) continue;
    $migration = require $file;
    if ($rollback) { $migration->down(); $capsule->table('migrations')->where('migration',$name)->delete(); echo "Rolled back: $name\n"; }
    else { $migration->up(); $capsule->table('migrations')->insert(['migration'=>$name]); echo "Migrated: $name\n"; }
}
