<?php
namespace Classes;

use App\Models\ScientificCategory;
use App\Models\AllotmentCategory;
use Illuminate\Support\Facades\URL;

class Multi
{

    public function multiMenuSiide($id)
    {
        $m = '';
        $category = ScientificCategory::with('childs', 'scientific')->find($id);
        if (count(@$category->childs) > 0 and $category->status == 1) {
            $m .= '<ul class="children nav-child unstyled small collapse in" id="sub-item-' . $id . '" aria-expanded="true">';
            $x = true;
            foreach (@$category->childs as $e) {
                if (count(@$e->childs) > 0) {
                    $data = $e;
                    $m .= '<li class="item-' . $e->id . ' deeper parent active"><a href="' . URL::action('Site\ScientificController@getIndex', $e->id) . '"> 
                     <span data-toggle="collapse" data-parent="#menu-group-1" href="#sub-item-' . $e->id . ' " class="sign" aria-expanded="true"><i class="glyphicon glyphicon-plus icon-minus"></i></span>
                     ' . $data->title . '</a>';
                    $m .= $this->multiMenuSiide($e->id);
                    $m .= '</li>';


                } else {
                    if ($e->status == 1) {
                        $data = $e;
                        $m .= '<li class="item-' . $e->id . ' deeper parent active"><a href="' . URL::action('Site\ScientificController@getIndex', $e->id) . '">
                     <span data-toggle="collapse" data-parent="#menu-group-1" href="#sub-item-' . $e->id . ' " class="sign" aria-expanded="true"><i class="glyphicon glyphicon-plus icon-minus"></i></span>
                     ' . $data->title . '</a></li>';
                    }

                }
                $x = false;
            }

            $m .= '</ul>';

        }
        return $m;
    }

    public function parentAll($id, $array = [], $orginal = true, $depth = 1)
    {
        $category = ScientificCategory::with('parent')->find($id);
        if ($orginal) {
            $array[] = (int)$id;
        }
        if($category)
        if (count($category->parent) > 0) {
            $depth++;
            $array[] = $category->parent->id;
            $array = $array + $this->parentAll($category->parent->id, $array, false, $depth);
        }
        return $array;
    }

    public function allotmentMultiMenuSide($id)
    {
        $m = '';
        $category = AllotmentCategory::with('childs', 'allotment')->find($id);
        if (count(@$category->childs) > 0 and $category->status == 1) {
            $m .= '<ul class="children nav-child unstyled small collapse in" id="sub-item-' . $id . '" aria-expanded="true">';
            $x = true;
            foreach (@$category->childs as $e) {
                if (count(@$e->childs) > 0) {
                    $data = $e;
                    $m .= '<li class="item-' . $e->id . ' deeper parent active"><a href="' . URL::action('Crm\AllotmentController@getIndex', $e->id) . '"> 
                     <span data-toggle="collapse" data-parent="#menu-group-1" href="#sub-item-' . $e->id . ' " class="sign" aria-expanded="true"><i class="glyphicon glyphicon-plus icon-minus"></i></span>
                     ' . $data->title . '</a>';
                    $m .= $this->allotmentMultiMenuSide($e->id);
                    $m .= '</li>';


                } else {
                    if ($e->status == 1) {
                        $data = $e;
                        $m .= '<li class="item-' . $e->id . ' deeper parent active"><a href="' . URL::action('Crm\AllotmentController@getIndex', $e->id) . '">
                     <span data-toggle="collapse" data-parent="#menu-group-1" href="#sub-item-' . $e->id . ' " class="sign" aria-expanded="true"><i class="glyphicon glyphicon-plus icon-minus"></i></span>
                     ' . $data->title . '</a></li>';
                    }

                }
                $x = false;
            }

            $m .= '</ul>';

        }
        return $m;
    }

    public function allotmentParentAll($id, $array = [], $orginal = true, $depth = 1)
    {
        $category = AllotmentCategory::with('parent')->find($id);
        if ($orginal) {
            $array[] = (int)$id;
        }
        if($category)
            if (count($category->parent) > 0) {
                $depth++;
                $array[] = $category->parent->id;
                $array = $array + $this->allotmentParentAll($category->parent->id, $array, false, $depth);
            }
        return $array;
    }


}