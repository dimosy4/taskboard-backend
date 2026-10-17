<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Card extends Model {
    protected $table = 'cards';
    protected $primaryKey = 'card_id';
    const CREATED_AT = 'created_datetime';
    const UPDATED_AT = 'updated_datetime';
    protected $guarded = [];
    protected $hidden = ['password_hash'];
}
