<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradeFile extends Model
{
    protected $table = 'grade_file';

    protected $fillable = [
        'id', 'user_id', 'education', 'prizes', 'membership', 'project_required', 'writing', 'invention',
        'activity', 'education_courses', 'research_projects', 'use_of_services', 'services_caribbean',
    ];

    protected function getDateFormat()
    {
        return 'U';
    }

}
