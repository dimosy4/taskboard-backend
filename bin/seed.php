<?php
require dirname(__DIR__).'/bootstrap/app.php';
use App\Models\User; use App\Models\Board; use App\Models\BoardColumn; use App\Models\Card;
$user = User::firstOrCreate(['email'=>'demo@example.com'], ['name'=>'Demo User','password_hash'=>password_hash(bin2hex(random_bytes(16)),PASSWORD_DEFAULT)]);
$board = Board::firstOrCreate(['owner_user_id'=>$user->user_id,'title'=>'Demo board'], ['is_public'=>true]);
$column = BoardColumn::firstOrCreate(['board_id'=>$board->board_id,'title'=>'To do'],['ordinal_position'=>1,'color'=>'FFAA00']);
Card::firstOrCreate(['board_id'=>$board->board_id,'column_id'=>$column->column_id,'title'=>'First task'], ['sort_index'=>1,'content'=>'Created by Eloquent']);
echo "Demo records created\n";
