<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectRequiredStatus extends Model
{
    protected $table = 'project_required_status';

    protected $fillable = [
        'id', 'title', 'listorder', 'status',
    ];

    protected function getDateFormat()
    {
        return 'U';
    }

}
