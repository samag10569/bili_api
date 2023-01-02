<!----------------------------------- left SIDE -------------------------------->
<div class="col-md-4">
    <div id="left-sidebar">
        <div class="profile">
            <div class="bg"></div>
            <div class="wrap"><br><br><br><br>
                <a class="avatar">
                    @if(file_exists('assets/uploads/user/medium/' . Auth::user()->image))
                        <img src="{!!asset('assets/uploads/user/medium/'.Auth::user()->image)!!}"
                             alt="{{Auth::user()->name.' '.Auth::user()->family}}">
                    @else
                        <img src="{!! asset('assets/site/images/avatar.png') !!}"
                             alt="{{Auth::user()->name.' '.Auth::user()->family}}">
                    @endif
                </a><br>
                <span>{{Auth::user()->name.' '.Auth::user()->family}}</span><br>

                <span>{{@$userDetails->category->title.' - '.@$userDetails->branchInfo->title.' - '.@$userInfo->branch}}</span><br>
                <a href="{{URL::action('Crm\ProfileController@getEdit')}}" class="edit"><i
                            class="fa fa-pencil-square-o"></i> ویرایش پروفایل کاربری</a>
            </div><!-- /.wrap -->
        </div><!-- /.profile -->
        <hr>
        <div class="level">
            <h4>سطح علمی شما</h4>
			
			@php
				$level = 1;
				if(@$userInfo->score_id == 'D') $level = 1;
				elseif(@$userInfo->score_id == 'C') $level = 2;
				elseif(@$userInfo->score_id == 'B') $level = 3;
				elseif(@$userInfo->score_id == 'A') $level = 4;
				elseif(@$userInfo->score_id == 'A+') $level = 5;
			
			@endphp

            <div id="ballon-area">
                <div class="color level{{$level}}" data-level="{{$level}}"></div>
                <div class="ballon"></div>
                <ul class="bubbles level{{$level}}">
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                </ul>
            </div><!-- /#ballon -->

            <a href="{{URL::action('Crm\GradeController@getIndex')}}" class="link-hover">سطح من را افزایش بده</a>
        </div><!-- /.level -->
        <div class="services">
            <!-- red or green -->
            <h4 class="red link-hover">
                <a class="reset-btn" href="{{URL::action('Crm\AllotmentController@getIndex')}}"
                   style="color: white;">
                    @php
                        $allotmentCount = Classes\UserCheck::checkAllotmentAll(Auth::id());
                    @endphp
                    @if($allotmentCount)
                        شما
                        {{$allotmentCount}}
                        سرویس ثبت شده در سیستم دارید.
                    @else
                        شما هنوز سرویسی به خود تخصیص نداده اید
                    @endif
                </a></h4>

        </div><!-- /.serices -->
        <div class="inc-links">
            <a href="{{URL::action('Crm\NetworkController@getIndex')}}"><img
                        src="{!! asset('assets/site/images/add-links.png') !!}" alt="اتصالات"></a>
            <h4>افزایش اتصالات</h4>
            <p>شبکه دوستان علمی خود را افزایش دهید</p>
        </div><!-- /.inc-links -->
        <div class="projects">
            <a href="{{URL::action('Crm\ProjectController@getIndex')}}">
            <img src="{!! asset('assets/site/images/project.png') !!}" alt="پروژه موظفی"></a>
            <h4>پروژه موظفی</h4>
            <p>
               باعث افزایش رتبه شما خواهد شد
            </p><br/><br/><br/><br/>
        </div><!-- /.projects -->
        <hr>
        <div class="contact">
            <a href="{{URL::action('Crm\CoreMessageController@getIndex')}}" class=" link-hover core">ارتباط با هسته
                علمی</a>
            <a href="{{URL::action('Crm\SupportController@getIndex')}}" class=" link-hover support">ارتباط با
                پشتیبانی</a>
        </div>
        <hr>
        <div class="contact">
		@if(@$userInfo->membership_type_id == 3 || @$userInfo->membership_type_id == 4)
			@php
				$membershipType_time = $userInfo->membershipType->time;
				$old = $userInfo->date_membership_type;
				$today = time();
				$diff = ($today - $old) / 86400;
				$day = $membershipType_time - round($diff);
			@endphp
			<a class="link blue link-hover" style="background-color:#22a3d4">{{round($day)}} روز مانده تا پایان عضویت</a>
		@endif
            <a href="#" class="link-hover copy" id="demo" onclick="copyToClipboard('#profile-url')">کپی لینک پروفایل</a>
            <a href="{{URL::action('Crm\HomeController@getProfile', [Auth::id(), $name])}}" class="link-hover see">مشاهده
                پروفایل کاربری</a>
            <a href="{{URL::action('Crm\ShopController@getCart')}}" class="link-hover basket">مشاهده سبد خرید
                <span style="background: #7bcf7f;padding: 5px;border-radius: 10px;">{{Cart::count()}}</span>
            </a>
        </div>
    </div><!-- /#left-sidebar -->
</div>

<span id="profile-url"
      style="visibility: hidden;">{{URL::action('Crm\HomeController@getProfile', [Auth::id(), $name])}}</span>
<!----------------------------------- left SIDE -------------------------------->
