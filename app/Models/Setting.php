<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'setting';
    public $timestamps = false;
    protected $fillable = [
        'title', 'keyword', 'description', 'logo_water_mark',
        'favicon', 'sender', 'logo_header', 'logo_footer', 'port',
        'username', 'host'
    ];

}
