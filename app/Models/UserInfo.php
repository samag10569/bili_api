<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    protected $table = 'user_info';
    protected $dates = ['deleted_at'];
    protected $softDelete = true;

    protected $fillable = [
        'user_id', 'article', 'invention', 'ideas', 'expertise', 'article_title', 'invention_title',
        'ideas_title', 'expertise_title', 'interview_type_id', 'agent_send', 'membership_type_id', 'city', 'state_id',
        'membership_type_id', 'credibility_id', 'degree_id', 'branch', 'postal_code', 'father_name', 'national_id',
        'birth', 'employment_status', 'number_ledger', 'grade_score', 'industry', 'company', 'job_status', 'grade',
        'date_membership_type', 'status_membership_type', 'allotment_score', 'allotment', 'score', 'score_id'
    ];

    protected function getDateFormat()
    {
        return 'U';
    }

    public function state()
    {
        return $this->belongsTo('App\Models\State', 'state_id');
    }

    public function credibility()
    {
        return $this->belongsTo('App\Models\Credibility', 'credibility_id');
    }

    public function membershipType()
    {
        return $this->belongsTo('App\Models\MembershipType', 'membership_type_id');
    }

}
