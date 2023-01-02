<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectRequiredType extends Model
{
    protected $table = 'project_required_type';

    protected $fillable = [
        'title'
    ];

    protected function getDateFormat()
    {
        return 'U';
    }

}
