<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

</head>
<body style="font-family:  b nazanin;font-size: 15pt;">

<div dir='rtl' class='bodyx' style="border:8px double black;height:100%;margin:0px;">
     <center>
    <div style="width:505px;margin:0px;text-align:Center">
        
        «« {{$email_send->subject}} »»
    </div>
    </center>

    <div style=' padding-right:15px;line-height:2;font-size:12px'>
        فناور محترم جناب آقای/خانم {{$user->name.' '.$user->family}}
        <br>

		{!!$email_send->content!!}
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