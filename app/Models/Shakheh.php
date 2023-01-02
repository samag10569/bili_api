<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shakheh extends Model
{
    protected $table = 'shakheh';

    protected $guarded=['id'];

    protected function getDateFormat()
    {
        return 'U';
    }






}
