<!----------------------------------- left SIDE -------------------------------->
<div class="col-md-4">
    <div id="right-sidebar">
        <div class="box">
            <div class="head">
                <h4>دسته بندی خدمات</h4>

            </div>
            <!-- .head -->
            <div class="body">
                <div style="width:100%; padding: 8px 0;" id="right-dr-menu">
                    <div id="left" class="span3">
                        <ul id="menu-group-1" class="nav menu">
                            @foreach($category as $row)
                                <li class="item-{{$row->id}} deeper parent">
                                    <a class="" href="#">
                                        <span data-toggle="collapse" data-parent="#menu-group-1"
                                              href="#sub-item-{{$row->id}}" class="sign" aria-expanded="true"><i
                                                    class="glyphicon glyphicon-plus icon-minus"></i></span>
                                        <span class="lbl">{{$row->title}}</span>
                                    </a>
                                    @php
                                        $multi = new Classes\Multi();
                                        echo $multi->allotmentMultiMenuSide($row->id)
                                    @endphp
                                </li>
                            @endforeach

                        </ul>
                    </div>
                </div>
            </div>
            <!-- .body -->
        </div>
        <!-- .box -->
        <div class="box" style="margin-top:15px;">
            <div class="head">
                <h4>آمار خدمات </h4>

            </div>
            <!-- .head -->
            <div class="body">
                <ul>
                    <li>کل دسته ها :
                        {{ $count['all_category']}}
                        عدد
                    </li>
                    <li>کل محتوا :
                        {{ $count['all']}}
                        عدد
                    </li>
                    <li>محتوای امروز :
                        {{ $count['current_day']}}
                        عدد
                    </li>
                </ul>
            </div>
            <!-- .body -->
        </div>
        <!-- .box -->
        <div class="box" style="margin-top:15px;">
            <div class="head">
                <h4> آخرین خدمات </h4>

            </div>
            <!-- .head -->
            <div class="body">
                @foreach($allotment as $row)
                    <div class="sid-post">
                        @if(file_exists('assets/uploads/allotment/medium/' . $row->image) and $row->image != null and $row->image != '')
                            <img src="{!! asset('assets/uploads/allotment/medium/'.$row->image) !!}" class="pull-right"
                                 alt="{!! $row->title !!}" style="width: 93px;height: 93px;">
                        @else
                            <img src="{!! asset('assets/uploads/notFound.jpg') !!}" alt="{!! $row->title !!}"
                                 class="pull-right" style="width: 93px;height: 93px;">
                        @endif
                        <h4>{{$row->title}}</h4>
                        <p>{{$row->content}}</p>
                        <a href="{{URL::action('Crm\AllotmentController@getDetails', $row->id)}}"
                           class="link green link-hover small">ادامه ...</a>
                    </div>
                @endforeach
            </div>
            <!-- .body -->
        </div>
        <!-- .box -->

    </div>
    <!-- /#left-sidebar -->
</div>
<!----------------------------------- left SIDE -------------------------------->