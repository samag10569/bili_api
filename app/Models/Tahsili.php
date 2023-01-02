<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tahsili extends Model
{
    protected $table = 'tahsili';

    protected $guarded=['id'];

    protected function getDateFormat()
    {
        return 'U';
    }




}
