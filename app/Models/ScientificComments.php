<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScientificComments extends Model
{
    protected $table = 'scientific_comments';

    protected $fillable = [
        'id','parent_id','comment','name','email','url','published','scientific_id','ip','user_id'
    ];

    protected function getDateFormat()
    {
        return 'U';
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    public function scientific()
    {
        return $this->belongsTo('App\Models\Scientific', 'scientific_id');
    }
    public function publishedby()
    {
        return $this->belongsTo('App\User', 'published_by');
    }
    public function children()
    {
        return $this->hasMany('App\Models\ScientificComments', 'parent_id');
    }

    public function countChildren($node = null)
    {
        $query = $this->children();
        if (!empty($node)) {
            $query = $query->where('node', $node);
        }
        $count = 0;
        foreach ($query->get() as $child) {
            $count += $child->countChildren() + 1;
        }
        return $count;
    }

}
