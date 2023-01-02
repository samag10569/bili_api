<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	</head>
	<body style="font-family:  b nazanin;font-size: 15pt;">
		<div dir='rtl' class='bodyx' style="border:8px double black;margin:10px;padding: 30px;">
		
			<h3>
				{{$data->title}}
			</h3>
			<p>
				{{$data->abstract}}
			</p>
			<div>
				{!!$data->content!!}
			</div>
			<p>
				{{$data->source}}
			</p>
		</div>
	</body>
</html>