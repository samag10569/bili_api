
<html>
	<body>
		<div style="direction: rtl; text-align: right; background-color: beige; padding: 10px; border-radius: 10px;">
			<h3>لینک تاییدیه ایمیل – شبکه رشد علم جوان</h3>
			<p>
			کاربر گرامی 
			{{$user->name.' ',$user->family}}
			جهت بازیابی تایید ایمیل خود روی لینک زیر کلیک کنید.
			</p>
			<p>
				<a href="{!!URL::action('Crm\HomeController@getConfirmEmail',[$user->id,$user->email_confirm_code])!!}">
				تاییدیه ایمیل در شبکه رشد علم جوان
				</a>
			</p>
		</div>
	</body>
</html>
				