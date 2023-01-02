<aside class="main-sidebar" class="print">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-right image">
                <img src="{!!asset('assets/uploads/user/medium/'.Auth::user()->image)!!}" class="img-circle"
                     alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{Auth::user()->name.' '.Auth::user()->family}}</p>
                <i style="color: green" class="fa fa-circle" aria-hidden="true"></i>

                آنلاین
            </div>
        </div>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">ناوبری اصلی</li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-home"></i>
                    <span>پیشخوان</span>
                    <i class="fa fa-angle-left pull-left"></i>
                </a>
                <ul class="treeview-menu menu-open">
                    <li>
                        <a href="{{ route('admin.home.page') }}">
                            <i class="fa fa-circle-o"></i>
                            صفحه نخست پنل</a>
                    </li>
                    <li>
                        <a href="{{URL::action('Admin\SearchMemberController@getIndex')}}">
                            <i class="fa fa-circle-o"></i>
                            جستجو پیشرفته اعضا</a>
                    </li>
                    <li>
                        <a href="{{URL::action('Admin\ReportProController@getIndex')}}">
                            <i class="fa fa-circle-o"></i>
                            آمارگیر پیشرفته</a>
                    </li>
                    <li>
                        <a href="{{URL::action('Admin\UploaderController@getIndex')}}">
                            <i class="fa fa-circle-o"></i>
                            آپلودر داخلی سامانه</a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-group"></i>
                    <span>مدیریت اعضا ثبت نام شده</span>
                    <i class="fa fa-angle-left pull-left"></i>
                </a>
                <ul class="treeview-menu menu-open">
                    <li>
                        <a href="{{URL::action('Admin\TempUsersController@getIndex')}}">
                            <i class="fa fa-circle-o"></i>
                            اعضا در انتظار تایید عضویت</a>
                    </li>
                    <li>
                        <a href="{{URL::action('Admin\TempUsersController@getIndex2')}}">
                            <i class="fa fa-circle-o"></i>
                            اعضا تایید عضویت شده</a>
                    </li>
                    <li>
                        <a href="{{URL::action('Admin\MsgController@getIndex')}}">
                            <i class="fa fa-circle-o"></i>
                            مشاهده پیام های داخلی سیستم</a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-laptop"></i>
                    <span>مدیریت فروشگاه ها</span>
                    <i class="fa fa-angle-left pull-left"></i>
                </a>
                <ul class="treeview-menu menu-open">
                    <li>
                        <a href="{{ route('admin.shops.list') }}">
                            <i class="fa fa-circle-o"></i>
                            مدیریت فروشگاه های عضو</a>
                    </li>


                    <li>
                        <a href="{{URL::action('Admin\AllotmentCategoryController@getIndex')}}">
                            <i class="fa fa-circle-o"></i>
                            دسته بندی ها</a>
                    </li>

                    <li>
                        <a href="{{ route('admin.products.list') }}">
                            <i class="fa fa-circle-o"></i>
                            مدیریت محصولات ارسالی</a>
                    </li>

                    <li>
                        <a href="{{URL::action('Admin\ShopController@getSubscriptionIndex')}}">
                            <i class="fa fa-circle-o"></i>
                            مدیریت اعضای باشگاه مشتریان </a>
                    </li>
                    <li>
                        <a href="{{URL::action('Admin\ShopController@getCustomerMsgIndex')}}">
                            <i class="fa fa-circle-o"></i>
                            مدیریت پیام های تبادل شده </a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-money"></i>
                    <span>مالی</span>
                    <i class="fa fa-angle-left pull-left"></i>
                </a>
                <ul class="treeview-menu menu-open">
                    <li>
                        <a href="{{URL::action('Admin\UserController@getIndexCredit')}}">
                            <i class="fa fa-circle-o"></i>
                            بخش مالی اعضا دارای حساب شارژ شده</a>
                    </li>
                    <li>
                        <a href="{{URL::action('Admin\TransactionController@getIndex')}}">
                            <i class="fa fa-circle-o"></i>
                           لاگ کامل پرداخت های کاربران</a>
                    </li>
                    <li>
                        <a href="{{URL::action('Admin\VoucherController@getIndex')}}">
                            <i class="fa fa-circle-o"></i>
                            تعریف کد تخفیف</a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-laptop"></i>
                    <span>سفارش های تبلیغاتی</span>
                    <i class="fa fa-angle-left pull-left"></i>
                </a>
                <ul class="treeview-menu menu-open">
                    <li>
                        <a href="{{ route('admin.ads_texts.list') }}">
                            <i class="fa fa-circle-o"></i>
                            سفارش های تبلیغات متنی</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.ads_images.list') }}">
                            <i class="fa fa-circle-o"></i>
                            سفارش های تبلیغات تصویری</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.ads_videos.list') }}">
                            <i class="fa fa-circle-o"></i>
                            سفارش های تبلیغات ویدئویی</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.ads_apps.list') }}">
                            <i class="fa fa-circle-o"></i>
                            سفارش های تبلیغات نرم افزاری</a>
                    </li>
                    <li>
                        <a href="{{URL::action('Admin\AdsOrderController@getIndex')}}">
                            <i class="fa fa-circle-o"></i>
                            سفارش های ساخت تبلیغات</a>
                    </li>
                    <li>
                        <a href="{{URL::action('Admin\AdsOrderCategoryController@getIndex')}}" >
                            <i class="fa fa-circle-o"></i>
                           مدیریت دسته بندی ساخت تبلیغات</a>
                    </li>
                    <li>
                        <a href="{{URL::action('Admin\UserController@getIndexCredit')}}">
                            <i class="fa fa-circle-o"></i>
                            مدیریت پرداخت های پول تو جیبی</a>
                    </li>
                    <li>
                        <a href="{{URL::action('Admin\AllAdsController@getIndex')}}">
                            <i class="fa fa-circle-o"></i>
                            گزارش های انجام تعهدات تبلیغاتی</a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-envelope"></i>
                    <span>سیستم ایمیل و پیامک</span>
                    <i class="fa fa-angle-left pull-left"></i>
                </a>
                <ul class="treeview-menu menu-open">
                    <li>
                        <a href="{{URL::action('Admin\EmailSendController@getIndex')}}">
                            <i class="fa fa-circle-o"></i>
                            ارسال ایمیل به اعضا</a>
                    </li>
                    <li>
                        <a href="{{URL::action('Admin\EmailController@getEdit')}}">
                            <i class="fa fa-circle-o"></i>
                            تنظیمات سیستم ارسال ایمیل</a>
                    </li>
                    <li>
                        <a href="{{URL::action('Admin\SmsSendController@getIndex')}}">
                            <i class="fa fa-circle-o"></i>
                            ارسال پیامک به اعضا</a>
                    </li>

                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-laptop"></i>
                    <span>مدیریت بیلبوردهای تبلیغاتی</span>
                    <i class="fa fa-angle-left pull-left"></i>
                </a>
                <ul class="treeview-menu menu-open">
                    <li>
                        <a href="{{ route('admin.billboards.list') }}">
                            <i class="fa fa-circle-o"></i>
                            مدیریت بیلبوردها</a>
                    </li>

                    <li>
                        <a href="#">
                            <i class="fa fa-circle-o"></i>
                            سفارشات ثبتی کاربران برای بیلبوردها</a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-laptop"></i>
                    <span>پشتیبانی و راهنمایی سیستم</span>
                    <i class="fa fa-angle-left pull-left"></i>
                </a>
                <ul class="treeview-menu menu-open">
                    <li>
                        <a href="#">
                            <i class="fa fa-circle-o"></i>
                            پشتیبانی تیکت های ثبت شده کاربران</a>
                    </li>
                    <li>
                        <a href="{{URL::action('Admin\PageController@getEdit',20)}}">
                            <i class="fa fa-circle-o"></i>
                            مدیریت راهنمایی سیستم</a>
                    </li>
                    <li>
                        <a href="{{URL::action('Admin\PageController@getEdit',21)}}">
                            <i class="fa fa-circle-o"></i>
                            ویرایش صفحه قوانین سیستم</a>
                    </li>
                    <li>
                        <a href="{{URL::action('Admin\PageController@getEdit',22)}}">
                            <i class="fa fa-circle-o"></i>
                            ویرایش صفحه معرفی سامانه تبلیغاتچی</a>
                    </li>

                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-laptop"></i>
                    <span>مدیریت سیستم</span>
                    <i class="fa fa-angle-left pull-left"></i>
                </a>
                <ul class="treeview-menu menu-open">
                    <li>
                        <a href="{{URL::action('Admin\SettingController@getEdit',array(1))}}">
                            <i class="fa fa-circle-o"></i>
                            مدیریت تنظیمات سیستم</a>
                    </li>
                    <li>
                        <a href="{{URL::action('Admin\UserController@getIndex')}}">
                            <i class="fa fa-circle-o"></i>
                            لیست مدیران سیستم</a>
                    </li>
                    <li>
                        <a href="{{URL::action('Admin\ExcelMemberController@getIndex')}}">
                            <i class="fa fa-circle-o"></i>
                            خروجی اکسل از سیستم</a>
                    </li>
                    <li>
                        <a href="{{URL::action('Admin\StateController@getIndex')}}">
                            <i class="fa fa-circle-o"></i>
                            مدیریت سیستم شهر و استان</a>
                    </li>
                    <li>
                        <a href="{{URL::action('Admin\BranchController@getIndex')}}"><i
                                    class="fa fa-circle-o"></i>
                            مدیریت مقطع تحصیلی
                        </a>
                    </li>
                    <li>
                        <a href="{{URL::action('Admin\CategoryController@getIndex')}}"><i
                                    class="fa fa-circle-o"></i>
                            مدیریت شاخه تحصیلی
                        </a>
                    </li>
                </ul>
            </li>









        </ul>
    </section>
    <!-- /.sidebar -->
</aside>