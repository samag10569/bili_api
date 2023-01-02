<?php

namespace App\Http\Controllers\Crm;

use App\Models\Allotment;
use App\Models\AllotmentCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class AllotmentController extends Controller
{

    public function getIndex($id = null)
    {
        $query = Allotment::query();
        if ($id != null)
            $query->whereCategoryId($id);
        $allotment = $query->whereStatus(1)
            ->latest()
            ->paginate(10);

        return view('crm.allotment.index')
            ->with('allotment', $allotment);
    }


    public function getDetails($id)
    {
        $allotment = Allotment::whereStatus(1)
            ->whereId($id)
            ->first();
        if (!$allotment) abort(404);

        return view('crm.allotment.details')
            ->with('allotment', $allotment);
    }

}
