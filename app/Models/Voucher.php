<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $table = 'vouchers';

    
     protected $guarded = [
        'id'
    ];   

    protected function getDateFormat()
    {
        return 'U';
    }


}
