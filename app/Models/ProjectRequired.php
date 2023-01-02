<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectRequired extends Model
{
    protected $table = 'project_required';

    protected $fillable = [
        'user_id', 'title', 'file', 'abstract', 'content', 'status_id', 'type',
        'change', 'print', 'status', 'source', 'description_extra', 'supervisor', 'factualy_id'
    ];

    protected function getDateFormat()
    {
        return 'U';
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function supervisorInfo()
    {
        return $this->belongsTo('App\User', 'supervisor', 'id');
    }

    public function projectRequiredStatus()
    {
        return $this->belongsTo('App\Models\ProjectRequiredStatus', 'status_id');
    }

    public function projectRequiredType()
    {
        return $this->belongsTo('App\Models\ProjectRequiredType', 'type');
    }

}
