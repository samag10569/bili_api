<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

</head>

<body style="font-family:  b nazanin;font-size: 15pt;">

<div dir='rtl' class='bodyx' style="border:8px double black;eight:100%;margin:0px;">
    <div style="background:url('{{ asset('assets/admin/img/logo1.jpg')}}');width:151px;float:left;height:170px;margin:0px;">
    </div>
    <div style="width:505px;margin:0px;text-align:Center">
        <div style="background:url('{{ asset('assets/admin/img/logo2.jpg')}}'); height:120px;margin:0px;padding-right:10px;padding-top:3px;text-align:right">
<span style="font-size:x-small;font-family: b nazanin;"> 
شماره: &nbsp; {{$user->user_code}}
    <br>
تاریخ: &nbsp; {{jdate('Y/m/d','','','','en')}}
</span>
            <br>
            <span>net.علم.www</span>
</br></br></br>
            <div style="border-top:8px double #622423;width:100%;"></div>
        </div>
        «« دعوتنامه مصاحبه حضوری »»
    </div>
    <br>

    <div style=' padding-right:15px;line-height:2;font-size:12px'>
        فناور محترم جناب آقای/خانم {{$user->name.' '.$user->family}}
        <br>

        سلام علیکم
        <br>
        بدینوسیله از جنابعالی دعوت می شود با در دست داشتن رزومه کاری جهت تشکیل پرونده و استفاده از خدمات شبکه رشد علم
        جوان
        <br>
        به واحد ارزیابی واقع در آدرس ذیل مراجعه فرمایید .
        <br>
        آدرس:
        تهران - میدان ولیعصر - خیابان ولیعصر - بالاتر از خیابان زرتشت - کوچه پرستو پلاک 20 - طبقه 2 - واحد 3
        شماره تماس: 021-88800565
        <br>

        <b>تاریخ مراجعه {{jdate('Y/m/d',$user->date_interview,'','','en')}} - ساعت {{jdate('H:i',$user->date_interview,'','','en')}} &nbsp;&nbsp;

        </b> پرینت این معرفی نامه به همراه ارائه کارت ملی در روز مصاحبه الزامی است.
        <b>مدارک مورد نیاز: </b>اصل کارت ملی و شناسنامه به همراه کپی از هر کدام + رزومه ی کاری و آموزشی + مقالات ثبت شده
        خارجی و داخلی + ایده ها + گواهی
        <br>
        های اخذ شده از مراکز مختلف در صورت وجود ( اسکن ثبت اختراع ) + یک قطعه عکس با پس زمینه سفید + مستندات علمی شامل
        فیلم یا عکس از پروژه و تحقیقات

        <div style='text-align:Center'>

            <img style='width:570px' src="{{ asset('assets/admin/img/krooki.jpg')}}">

            <div style='border:2px solid black;width:563px;margin-right:40px'>

                راهنمایی:
                از طریق ایستگاه مترو جهاد (خروجی شرقی) تنها 200 متر با کوچه پرستو و دفتر مرکزی شبکه رشد علم جوان فاصله
                دارید.
            </div>
            <Br>
            <Br> <Br>
        </div>
    </div>
    <div style="border-top:8px double #622423;width:100%"></div>
    <div style='font-size:12px;text-align:Center'>
        <Br>
        آدرس:
        تهران - میدان ولیعصر - خیابان ولیعصر - بالاتر از خیابان زرتشت - کوچه پرستو پلاک 20 - طبقه 2 - واحد 3
        <br>
        شماره تماس: 021-88800565
    </div>
</div>
</body>
</html>