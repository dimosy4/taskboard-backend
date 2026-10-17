<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class User extends Model {
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    const CREATED_AT = 'created_datetime';
    const UPDATED_AT = 'updated_datetime';
    protected $guarded = [];
    protected $hidden = ['password_hash'];
}
