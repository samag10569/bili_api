<?php
return [
    'admin' => 'ejavan_mod',
    'permisions' => [

        'pending-member' => array(
            'title' => 'مدیریت افراد در انتظار تایید',
            'access' => array(
                'index' => 'افراد در انتظار تایید',
                'add' => 'عضو جدید',
                'edit' => 'ویرایش عضو',
                'email' => 'ارسال ایمیل',
                'deleteContent' => 'حذف توضیحات',
                'caller' => 'شمارنده تماس',
                'delete' => 'حذف موقت',
            )
        ),
        'current-day-member' => array(
            'title' => 'مدیریت اعضا روز جاری',
            'access' => array(
                'index' => 'اعضا روز جاری',
                'edit' => 'ویرایش عضو',
                'deleteContent' => 'حذف توضیحات',
                'delete' => 'حذف موقت',
                'grade' => 'تعیین گرید',
            )
        ),
        'waiting-interview' => array(
            'title' => 'مدیریت اعضا در انتظار مصاحبه',
            'access' => array(
                'index' => 'اعضا در انتظار مصاحبه',
                'add' => 'عضو جدید',
                'edit' => 'ویرایش عضو',
                'deleteContent' => 'حذف توضیحات',
                'caller' => 'شمارنده تماس',
                'delete' => 'حذف موقت',
                'grade' => 'تعیین گرید',
            )
        ),
        'rejected' => array(
            'title' => 'مدیریت اعضای رایگان',
            'access' => array(
                'index' => 'اعضا رایگان',
                'edit' => 'ویرایش عضو',
                'membershipType' => 'ویرایش عضویت',
                'deleteContent' => 'حذف توضیحات',
                'delete' => 'حذف موقت',
            )
        ),
        'grade-temp' => array(
            'title' => ' پرونده های در انتظار تایید گرید',
            'access' => array(
                'index' => 'مشاهده',
                'edit' => 'ویرایش',
            )
        ),
//        'assigned-serve' => array(
//            'title' => 'مدیریت اعضا در انتظار تخصیص خدمت',
//            'access' => array(
//                'index' => 'اعضا در انتظار تخصیص خدمت',
//                'edit' => 'ویرایش عضو',
//                'deleteContent' => 'حذف توضیحات',
//                'delete' => 'حذف موقت',
//                'allotment' => 'تخصیص خدمت',
//                'deleteOption' => 'حذف موارد بیشتر',
//                'supervisorAjax' => 'استاد راهنما',
//            )
//        ),
//        'initial-approval' => array(
//            'title' => 'مدیریت اعضا تایید اولیه',
//            'access' => array(
//                'index' => 'اعضا تایید اولیه',
//                'edit' => 'ویرایش عضو',
//                'deleteContent' => 'حذف توضیحات',
//                'delete' => 'حذف موقت',
//            )
//        ),
        'project-required' => array(
            'title' => 'مدیریت پروژه موظفی',
            'access' => array(
                'index' => 'لیست پروژه ها',
                'edit' => 'مشاهده و تایید',
                'editProject' => 'ویرایش',
                'pdf' => 'فایل pdf',
            )
        ),
//        'core-facility' => array(
//            'title' => 'مدیریت هسته تسهیل',
//            'access' => array(
//                'index' => 'هسته تسهیل',
//                'edit' => 'ویرایش',
//                'deleteContent' => 'حذف توضیحات',
//                'delete' => 'حذف موقت',
//                'allotment' => 'تخصیص خدمت',
//                'deleteOption' => 'حذف موارد بیشتر',
//                'deleteMessage' => 'حذف عناوین پیگیری شده',
//                'editMessage' => 'ویرایش عناوین پیگیری شده',
//                'addMessage' => 'اضافه عناوین پیگیری شده',
//                'coreScientific' => 'تعیین هسته علمی',
//            )
//        ),
        'user' => array(
            'title' => 'مدیریت کاربران',
            'access' => array(
                'index' => 'مشاهده',
                'add' => 'اضافه',
                'edit' => 'ویرایش',
                'delete' => 'حذف',
                'group' => 'مشاهده دسترسی',
                'groupAdd' => 'اضافه دسترسی',
                'groupEdit' => 'ویرایش دسترسی',
                'groupDelete' => 'حذف دسترسی',
            )
        ),
        'core-scientific' => array(
            'title' => 'اعضا هسته تسهیل',
            'access' => array(
                'index' => 'مشاهده',
                'add' => 'اضافه',
                'edit' => 'ویرایش',
                'delete' => 'حذف'
            )
        ),
        'network' => array(
            'title' => 'اتصالات کاربران',
            'access' => array(
                'index' => 'مشاهده',
                'friend' => 'اتصالات',
                'removeFriendRequest' => 'حذف اتصال',
            )
        ),
        'temp-users' => array(
            'title' => 'اعضا در انتظار تایید شماره همراه و ایمیل',
            'access' => array(
                'index' => 'مشاهده',
                'sendConfirmEmail' => 'ارسال ایمیل',
                'sendConfirmPhone' => 'ارسال پیام',
                'email' => 'تایید ایمیل',
                'mobile' => 'تایید موبایل',
            )
        ),
        'profile-comment' => array(
            'title' => 'نظرات پروفایل کاربران',
            'access' => array(
                'index' => 'مشاهده',
            )
        ),
        'private-message' => array(
            'title' => 'پیام ها خصوصی کاربران',
            'access' => array(
                'index' => 'مشاهده',
            )
        ),
        'search-member' => array(
            'title' => 'جستجو پیشرفته',
            'access' => array(
                'index' => 'مشاهده',
                'resualt' => 'نتیجه',
                'edit' => 'ویرایش',
                'signIn' => 'ورود به پنل کاربر',
                'changePassword' => 'تغییر رمز کاربر',
                'deleteContent' => 'حذف توضیحات',
            )
        ),
        'excel-member' => array(
            'title' => 'خروجی اکسل',
            'access' => array(
                'index' => 'مشاهده',
                'resualt' => 'اکسل',
            )
        ),
        'email-send' => array(
            'title' => 'ارسال ایمیل',
            'access' => array(
                'index' => 'مشاهده',
                'add' => 'اضافه',
                'delete' => 'حذف',
            )
        ),
        'contacts-list' => array(
            'title' => 'ارسال ایمیل به اعضای معرفی شده',
            'access' => array(
                'index' => 'مشاهده',
                'setting' => 'تنظیمات',
                'email' => 'ایمیل های ارسالی',
                'emailTest' => 'ارسال ایمیل تست',
                'add' => 'اضافه',
                'edit' => 'ویرایش',
                'delete' => 'حذف',
                'deleteError' => 'حذف ایمیل',
            )
        ),
        'email-excel' => array(
            'title' => 'ارسال ایمیل دعوت نامه از اکسل',
            'access' => array(
                'index' => 'مشاهده',
                'email' => 'ایمیل های ارسالی',
                'sample' => 'دانلود اکسل نمونه',
                'import' => 'ایمپورت اکسل',
                'setting' => 'تنظیمات',
                'add' => 'اضافه',
                'edit' => 'ویرایش',
                'delete' => 'حذف',
                'deleteError' => 'حذف ایمیل',
            )
        ),
        'ignore-email' => array(
            'title' => 'لیست ایمیل های عدم ارسال',
            'access' => array(
                'index' => 'مشاهده',
                'delete' => 'حذف',
            )
        ),
        'allotment-category' => array(
            'title' => 'دسته بندی خدمات',
            'access' => array(
                'index' => 'مشاهده',
                'add' => 'اضافه',
                'edit' => 'ویرایش',
                'delete' => 'حذف',
                'sort' => 'ترتیب',
            )
        ),
        'allotment' => array(
            'title' => 'خدمات',
            'access' => array(
                'index' => 'مشاهده',
                'add' => 'اضافه',
                'edit' => 'ویرایش',
                'delete' => 'حذف',
                'sort' => 'ترتیب',
            )
        ),
        'services' => array(
            'title' => 'خدمات',
            'access' => array(
                'index' => 'مشاهده',
                'add' => 'اضافه',
                'edit' => 'ویرایش',
                'delete' => 'حذف',
            )
        ),
        'delete' => array(
            'title' => 'مدیریت حذف',
            'access' => array(
                'index' => 'مشاهده',
                'user' => 'حذف کاربر',
                'viewUser' => 'مشاهده کاربر',
                'cancelUser' => 'لغو کاربر',
                'help' => 'حذف راهنمایی',
                'viewHelp' => 'مشاهده راهنمایی',
                'cancelHelp' => 'لغو راهنمایی',
                'scientificCategory' => 'حذف دسته بندی مطالب علمی',
                'viewScientificCategory' => 'مشاهده دسته بندی مطالب علمی',
                'cancelScientificCategory' => 'لغو دسته بندی مطالب علمی',
                'scientific' => 'حذف مطالب علمی',
                'viewScientific' => 'مشاهده مطالب علمی',
                'cancelScientific' => 'لغو مطالب علمی',
                'news' => 'حذف اخبار',
                'viewNews' => 'مشاهده اخبار',
                'cancelNews' => 'لغو اخبار',
            )
        ),
        'page' => array(
            'title' => 'صفحات ایستا',
            'access' => array(
                'index' => 'مشاهده',
                'add' => 'اضافه',
                'edit' => 'ویرایش',
                'delete' => 'حذف',
            )
        ),
        'banner' => array(
            'title' => 'بنر',
            'access' => array(
                'index' => 'مشاهده',
                'add' => 'اضافه',
                'edit' => 'ویرایش',
                'delete' => 'حذف',
                'sort' => 'ترتیب',
            )
        ),
        'service-network' => array(
            'title' => 'بال خدماتی',
            'access' => array(
                'index' => 'مشاهده',
                'add' => 'اضافه',
                'edit' => 'ویرایش',
                'delete' => 'حذف',
                'sort' => 'ترتیب',
            )
        ),
        'logo' => array(
            'title' => ' لوگوها',
            'access' => array(
                'index' => 'مشاهده',
                'add' => 'اضافه',
                'edit' => 'ویرایش',
                'delete' => 'حذف',
                'sort' => 'ترتیب',
            )
        ),
        'news' => array(
            'title' => 'اخبار',
            'access' => array(
                'index' => 'مشاهده',
                'add' => 'اضافه',
                'edit' => 'ویرایش',
                'delete' => 'حذف',
            )
        ),

        'message' => array(
            'title' => 'درخواست های پشتیبانی اعضا',
            'access' => array(
                'index' => 'مشاهده',
                'close' => 'بستن',
                'view' => 'پاسخ',
                'delete' => 'حذف',
            )
        ),

        'message-core' => array(
            'title' => 'درخواست های ارسال شده به هسته علمی',
            'access' => array(
                'index' => 'مشاهده',
                'close' => 'بستن',
                'view' => 'پاسخ',
                'delete' => 'حذف',
            )
        ),

        'setting' => array(
            'title' => 'تنظیمات',
            'access' => array(
                'index' => 'مشاهده',
                'edit' => 'ویرایش',
            )

        ),
        'email' => array(
            'title' => 'تنظیمات ایمیل',
            'access' => array(
                'index' => 'مشاهده',
                'edit' => 'ویرایش',
            )
        ),

        'delete' => array(
            'title' => 'مدیریت حذف',
            'access' => array(
                'index' => 'مشاهده',
                'edit' => 'ویرایش',
                'delete' => 'حذف',
            )
        ),
        'tab' => array(
            'title' => 'تب های هدر',
            'access' => array(
                'index' => 'مشاهده',
                'add' => 'اضافه',
                'edit' => 'ویرایش',
                'delete' => 'حذف',
            )
        ),
        'under-menu' => array(
            'title' => 'زیرمنو های هدر',
            'access' => array(
                'index' => 'مشاهده',
                'add' => 'اضافه',
                'edit' => 'ویرایش',
                'delete' => 'حذف',
            )
        ),
        'footer-tab' => array(
            'title' => 'تب های فوتر',
            'access' => array(
                'index' => 'مشاهده',
                'add' => 'اضافه',
                'edit' => 'ویرایش',
                'delete' => 'حذف',
            )
        ),
        'footer-under-menu' => array(
            'title' => 'زیرمنو های فوتر',
            'access' => array(
                'index' => 'مشاهده',
                'add' => 'اضافه',
                'edit' => 'ویرایش',
                'delete' => 'حذف',
            )
        ),
        'help' => array(
            'title' => 'راهنما',
            'access' => array(
                'index' => 'مشاهده',
                'add' => 'اضافه',
                'edit' => 'ویرایش',
                'delete' => 'حذف',
            )
        ),
        'capacity' => array(
            'title' => 'ظرفیت ثبت نام',
            'access' => array(
                'index' => 'مشاهده',
                'add' => 'اضافه',
                'edit' => 'ویرایش',
                'delete' => 'حذف',
            )
        ),
        'category' => array(
            'title' => 'شاخه تحصیلی',
            'access' => array(
                'index' => 'مشاهده',
                'add' => 'اضافه',
                'edit' => 'ویرایش',
                'delete' => 'حذف',
                'sort' => 'ترتیب',
            )
        ),

        'branch' => array(
            'title' => 'مقطع تحصیلی',
            'access' => array(
                'index' => 'مشاهده',
                'add' => 'اضافه',
                'edit' => 'ویرایش',
                'delete' => 'حذف',
                'sort' => 'ترتیب',
            )
        ),

        'credibility' => array(
            'title' => 'اعتبار طرح و ایده',
            'access' => array(
                'index' => 'مشاهده',
                'add' => 'اضافه',
                'edit' => 'ویرایش',
                'delete' => 'حذف',
                'sort' => 'ترتیب',
            )
        ),
        'state' => array(
            'title' => 'مدیریت استان ها',
            'access' => array(
                'index' => 'مشاهده',
                'add' => 'اضافه',
                'edit' => 'ویرایش',
                'delete' => 'حذف',
                'sort' => 'ترتیب',
            )
        ),

        'degree' => array(
            'title' => 'درجه علمی ',
            'access' => array(
                'index' => 'مشاهده',
                'add' => 'اضافه',
                'edit' => 'ویرایش',
                'delete' => 'حذف',
            )
        ),

        'uploader' => array(
            'title' => 'آپلودر',
            'access' => array(
                'index' => 'مشاهده',
                'add' => 'اضافه',
                'delete' => 'حذف',
            )
        ),
        'scientific-category' => array(
            'title' => 'دسته بندی مطالب علمی',
            'access' => array(
                'index' => 'مشاهده',
                'add' => 'اضافه',
                'edit' => 'ویرایش',
                'delete' => 'حذف',
                'sort' => 'ترتیب',
            )
        ),
        'scientific' => array(
            'title' => 'مطالب علمی مدیران',
            'access' => array(
                'index' => 'مشاهده',
                'add' => 'اضافه',
                'edit' => 'ویرایش',
                'delete' => 'حذف',
            )
        ),
        'scientific-users' => array(
            'title' => 'مطالب علمی کاربران',
            'access' => array(
                'index' => 'مشاهده',
                'edit' => 'ویرایش',
            )
        ),
        'report-pro' => array(
            'title' => 'آمارگیر پیشرفته',
            'access' => array(
                'index' => 'مشاهده',
            )
        ),
        'membership-type' => array(
            'title' => 'نوع عضویت',
            'access' => array(
                'index' => 'مشاهده',
                'edit' => 'ویرایش',
            )
        ),
        'interduction' => array(
            'title' => 'معرفی نامه',
            'access' => array(
                'index' => 'مشاهده',
                'add' => 'اضافه',
                'edit' => 'ویرایش',
                'delete' => 'حذف',
            )
        ),
        'orders' => array(
            'title' => 'فاکتورها',
            'access' => array(
                'index' => 'خدمات پرداخت شده',
                'factor' => 'مشاهده فاکتور',
                'transactions' => 'تراکنش ها',
                'membershipType' => 'فاکتورهای اعضای طلایی و الماسی',
                'membershipTypeUser' => 'اعضای طلایی و الماسی',
                'edit' => 'ویرایش اعضای طلایی و الماسی',
                'membershipTypeEdit' => 'ویرایش نوع عضویت',
                'allotments' => 'خدمات ارائه شده',
                'allotmentUser' => 'کاربران خدمات',
                'equivalentPersia' => 'کاربران درخواست دهنده مدرک معادل',
            )
        ),
        'logs' => array(
            'title' => 'لاگ ها',
            'access' => array(
                'index' => 'مشاهده',
                //'delete' => 'حذف',
            )
        ),
    ],

    'out' => 'out',
    'permisionsOut' => [


    ],
    'crm' => 'crm',
    'permisionsCrm' => [


    ],
];