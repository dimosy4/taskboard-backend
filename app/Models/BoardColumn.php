<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class BoardColumn extends Model {
    protected $table = 'board_columns';
    protected $primaryKey = 'column_id';
    const CREATED_AT = 'created_datetime';
    const UPDATED_AT = 'updated_datetime';
    protected $guarded = [];
    protected $hidden = ['password_hash'];
}
