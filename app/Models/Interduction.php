<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interduction extends Model
{
    protected $table = 'interduction';

    protected $fillable = [
        'id', 'user_id', 'admin_id', 'letter_id', 'type_id', 'company_name', 'address', 'created_at'
    ];

    protected function getDateFormat()
    {
        return 'U';
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    public function admin()
    {
        return $this->belongsTo('App\User', 'admin_id');
    }
    public function type()
    {
        return $this->belongsTo('App\Models\InterductionType', 'type_id');
    }

}
