<?php

namespace App\Http\Controllers\Crm;

use App\Models\FactualyList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CoreScientificController extends Controller
{
    public function getIndex(Request $request)
    {
        $groups = FactualyList::whereType(2)->whereVersion(1)->select(['title', 'id'])->get();

        return View('crm.core-scientific.index')
            ->with('groups', $groups);
    }

    public function getList($id)
    {
        $factualy = FactualyList::find($id);
        $data = $factualy->user;
        return view('crm.core-scientific.list')
            ->with('factualy', $factualy)
            ->with('data', $data);
    }

}
