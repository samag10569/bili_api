<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FactualyUser extends Model
{
    protected $table = 'factualy_list_user';

    protected $fillable = [
        'id', 'user_id', 'factualy_list_id'
    ];

}
