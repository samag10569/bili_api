<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

</head>
<body style="font-family:  b nazanin;font-size: 15pt;">

<div dir='rtl' class='bodyx' style="border:8px double black;height:100%;margin:0px;">
     <center>
    <div style="width:505px;margin:0px;text-align:Center">
        
        «« دعوتنامه »»
    </div>
    </center>

    <div style=' padding-right:15px;line-height:2;font-size:16px'>
	
         آقای/خانم {{$reagent->name}}
        <br>

		از جنابعالی دعوت می شود که در اولین هایپر فناوری ایرانی ( شبکه رشد علم جوان ) عضو شده و از تمامی مزایای رایگان این شبکه بهره مند شوید.
        <br>
		@if($test)
			<a href="{{URL::action('Site\RegisterController@getStep1',[$reagent->id,config('options.email')])}}">
				برای ثبت نام کلیک کنید
			</a>
		@else
			<a href="{{URL::action('Site\RegisterController@getStep1',[$reagent->id,$reagent->email])}}">
				برای ثبت نام کلیک کنید
			</a>
		@endif
        <br>
			<b>با آرزوی موفقیت روز افزون برای شما</b>
        <br>
			<b>اولین هایپرفناوری ایرانی</b>
        <br>
			<b>شبکه رشد علم جوان</b>
		<br>
		<a href="http://www.hyperfanavari.com/">www.hyperfanavari.com</a>
		<br>
		در صورتی که تمایل به دریافت ایمیل ندارید، اینجا کلیک کنید.
		<a href="{{URL::action('Site\HomeController@getUnSubscribe',[$reagent->email,'excel',$reagent->id])}}">unsubscribe link</a>
			
       
    </div>
</div>
</body>
</html>