<aside class="main-sidebar" class="print">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-right image">
                <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{Auth::user()->name.' '.Auth::user()->family}}</p>
            </div>
        </div>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">

            <li class="header">پیشخوان</li>
            <li>
                <a href="{{URL::action('Out\HomeController@getIndex')}}"><i
                            class="fa fa-dashboard"></i> صفحه نخست پنل</a>
            </li>

            <li class="treeview"
                    {{\Classes\Helper::menuActive([
                    'message','message-core'
                    ],'admin')}}>
                <a href="#">
                    <i class="fa fa-ticket"></i>
                    <span>مدیریت فعالیت های کاربران</span>
                    <i class="fa fa-angle-left pull-left"></i>
                </a>
                <ul class="treeview-menu">
                    @if(Auth::user()->hasPermission('message'))
                        <li>
                            <a href="{{URL::action('Out\MessageController@getIndex')}}"><i class="fa fa-circle-o"></i>
                                درخواست های پشتیبانی
                            </a>
                        </li>
                    @endif

                    @if(Auth::user()->hasPermission('message-core'))
                        <li>
                            <a href="{{URL::action('Out\MessageCoreController@getIndex')}}"><i
                                        class="fa fa-circle-o"></i>
                                درخواست های هسته علمی
                            </a>
                        </li>
                    @endif

                </ul>
            </li>



            @foreach($allotment_category_m as $row)
                @php
                    $array = explode(':',$row->title);
                    if($array > 1) $title = $array[0];
                    else $title = $row->title;
                    $count = 1;
                @endphp
                <li class="header">{{$title}}</li>
                @foreach($row->allotment as $value)

                    @if(Auth::user()->hasPermission('allotment'.$value->id))
                        <li class="treeview
                            {{\Classes\Helper::menuActive([
                            'allotment'.$value->id.'/accepted',
                            'allotment'.$value->id.'/total-waiting',
                            'allotment'.$value->id.'/total-rejected',
                            'allotment'.$value->id.'/waiting-wings',
                            'allotment'.$value->id.'/rejected-wings',
                            'allotment'.$value->id.'/edit',
                            ],'out')}}">
                            <a href="#">
                                <i class="badge bg-light-blue ejavan_badge" data-toggle="tooltip" data-placement="top"
                                   title="{{$value->title}}">{{$count}}</i>
                                <span data-toggle="tooltip" data-placement="top"
                                      title="{{$value->title}}">{{str_limit($value->title,25,'')}}</span>
                                <i class="fa fa-angle-left pull-left" data-toggle="tooltip" data-placement="top"
                                   title="{{$value->title}}"></i>
                            </a>
                            <ul class="treeview-menu">
                                @if(Auth::user()->hasPermission('allotment'.$value->id.'.accepted'))
                                    <li>
                                        <a href="{{URL::route('accepted.'.$value->id)}}"><i
                                                    class="fa fa-circle-o"></i>
                                            اعضای تایید شده
                                        </a>
                                    </li>
                                @endif
                                @if(Auth::user()->hasPermission('allotment'.$value->id.'.totalWaiting'))
                                    <li>
                                        <a href="{{URL::route('total.waiting.'.$value->id)}}"><i
                                                    class="fa fa-circle-o"></i>
                                            اعضای در انتظار کل
                                        </a>
                                    </li>
                                @endif
                                @if(Auth::user()->hasPermission('allotment'.$value->id.'.totalRejected'))
                                    <li>
                                        <a href="{{URL::route('total.rejected.'.$value->id)}}"><i
                                                    class="fa fa-circle-o"></i>
                                            اعضای رد شده کل
                                        </a>
                                    </li>
                                @endif
                                @if(Auth::user()->hasPermission('allotment'.$value->id.'.waitingWings'))
                                    <li>
                                        <a href="{{URL::route('waiting.wings.'.$value->id)}}"><i
                                                    class="fa fa-circle-o"></i>
                                            اعضای در انتظار بال خدماتی
                                        </a>
                                    </li>
                                @endif
                                @if(Auth::user()->hasPermission('allotment'.$value->id.'.rejectedWings'))
                                    <li>
                                        <a href="{{URL::route('rejected.wings.'.$value->id)}}"><i
                                                    class="fa fa-circle-o"></i>
                                            اعضای رد شده بال خدماتی
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @php
                        $count++;
                    @endphp
                @endforeach
            @endforeach
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>