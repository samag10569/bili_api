<header>
    <div class="container-fluid">
        <div class="row menu-area ">
            <div class="col-md-5 col-md-12">
                <ul id="menu" class="closed">
                    <li class="mother">
                        <a href="" class="main" onclick="return false">
                            <div id="nav-icon">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                            منوی اصلی سامانه</a>

                        <ul class="list">
                            <li class="list-item"><a href="{!! URL::action('Site\HomeController@getIndex') !!}">صفحه اصلی</a></li>
                            @foreach($tab as $row)
                                <li class="list-item"><a href="">{!! $row->title !!}</a>
                                    @if($row->underMenu)
                                        <ul class="sub">
                                            @foreach($row->underMenu as $item)
                                                <li><a href="{{$item->link}}">{!! $item->title !!}</a></li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach


                        </ul>
                    </li>
                </ul>
                <!-- /#menu -->

            </div>
            <div class="col-md-2">
                <img src="{!! asset('assets/site/images/logo-top.png') !!}" alt="" id="logo-top"
                     class="animated flipInX">
            </div>
            <div class="col-md-5 col-md-12">
                @if(Auth::check())
                    <div id="welcome-area" class="closed pull-left">
                        <ul>
                            <li>
                                @if (file_exists('assets/uploads/user/medium/'.Auth::user()->image) and Auth::user()->image != '' and Auth::user()->image != null)
								    <img class="profile-head" src="{{ asset('assets/uploads/user/medium/'.Auth::user()->image) }}">
								@else
								    <img class="profile-head" src="{{ asset('assets/site/images/user.png') }}">
								@endif
								<a class="msg" onclick="return false">{{Auth::user()->name}} {{Auth::user()->family}}، خوش آمدید
                                    
                                </a>
                                <!-- /.msg -->
                                <ul class="links">
                                    <li><a href="{{URL::action('Crm\HomeController@getIndex')}}">پنل کاربری</a></li>
                                    <li><a href="{{URL::action('Crm\HomeController@getProfile', [Auth::id(), $name])}}">پروفایل کاربر</a></li>
									<li><a href="{{URL::action('Crm\ProfileController@getEdit')}}">ویرایش پروفایل</a></li>
									<li><a href="{{URL::action('Crm\GradeController@getIndex')}}">افزایش سطح</a></li>
									<li><a href="{{URL::action('Crm\AllotmentController@getIndex')}}">خدمات</a></li>
									<li><a href="{{URL::action('Crm\NetworkController@getIndex')}}">اتصالات</a></li>
									<li><a href="{{URL::action('Crm\HomeController@getChart')}}">شبکه اتصالات</a></li>
									<li><a href="{{URL::action('Crm\ProjectController@getIndex')}}">پروژه موظفی</a></li>
									<li><a href="{{URL::action('Crm\CoreMessageController@getIndex')}}">ارتباط با هسته تسهیل</a></li>
									<li><a href="{{URL::action('Crm\SupportController@getIndex')}}">ارتباط با پشتیبانی</a></li>
									<li><a href="{{URL::action('Crm\PrivateMessagesController@getInbox')}}">پیام خصوصی</a></li>
									<li><a href="{{URL::action('Crm\MemberShipTypeController@getIndex')}}">عضویت ویژه</a></li>
									<li><a href="{{URL::action('Crm\ShopController@getCart')}}">مشاهده سبد خرید</a></li>
                                    @if(Session::has('returnId'))
                                        <li><a href="{{URL::action('Crm\HomeController@getBackAdmin')}}">بازگشت به
                                                مدیریت</a></li>
                                    @endif
                                    <li>
                                        <a href="{{ url('/logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">خروج</a>
                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                              style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                                <!-- /.links -->
                            </li>
                        </ul>

                    </div>
                    <!-- /#welcome-area -->
					
				@else
					<div id="welcome-area" class="closed pull-left">
                        <ul>
                            <li>
								<img class="profile-head" src="{{ asset('assets/site/images/user.png') }}">
								<a class="msg" data-toggle="modal" data-target="#myModal" href=""> ورود / عضویت
                                    
                                </a>
                            </li>
                        </ul>

                    </div>
                @endif
            </div>
        </div>
    </div>
</header>