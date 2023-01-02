<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterductionType extends Model
{
    protected $table = 'interduction_type';

    protected $fillable = [
        'title', 'listorder', 'status',
    ];

    protected function getDateFormat()
    {
        return 'U';
    }

}
