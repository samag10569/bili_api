<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceNetwork extends Model
{
    protected $table = 'service_network';

    protected $fillable = [
        'id', 'title', 'content', 'image', 'link', 'listorder', 'status',
    ];

    protected function getDateFormat()
    {
        return 'U';
    }

}
