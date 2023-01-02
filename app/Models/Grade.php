<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $table = 'grade';

    protected $fillable = [
        'id', 'user_id', 'admin_id', 'education', 'prizes', 'membership', 'project_required1',
        'project_required2', 'project_required3', 'project_required4', 'project_required5', 'writing', 'invention1', 'invention2',
        'invention3', 'invention4', 'invention5', 'activity', 'education_courses', 'research_projects', 'use_of_services1',
        'use_of_services2', 'use_of_services3', 'use_of_services4', 'use_of_services5', 'services_caribbean',
        'scientific_certification_persian', 'scientific_certification_english', 'equivalent_persian',
    ];

    protected function getDateFormat()
    {
        return 'U';
    }

}
