<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipType extends Model
{
    protected $table = 'membership_type';

    protected $fillable = [
        'title', 'listorder', 'status', 'time', 'price', 'content', 'image'
    ];

    protected function getDateFormat()
    {
        return 'U';
    }

}
