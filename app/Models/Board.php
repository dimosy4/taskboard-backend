<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Board extends Model {
    protected $table = 'boards';
    protected $primaryKey = 'board_id';
    const CREATED_AT = 'created_datetime';
    const UPDATED_AT = 'updated_datetime';
    protected $guarded = [];
    protected $hidden = ['password_hash'];
}
