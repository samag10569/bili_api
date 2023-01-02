<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialType extends Model
{
    protected $table = 'financial_type';

    protected $fillable = [

    ];

    protected function getDateFormat()
    {
        return 'U';
    }

}
