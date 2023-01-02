<html>
	<body>
		<div style="direction: rtl; text-align: right; background-color: beige; padding: 10px; border-radius: 10px;">
			<h3>بازیابی رمز عبور</h3>
			<p>
			کاربر گرامی 
			{{$user->name.' ',$user->family}}
			جهت بازیابی رمز عبور روی لینک زیر کلیک کنید.
			</p>
			<p>
				<a href="{{URL::action('Auth\ForgotPasswordController@getResetPassword',$token)}}">
				بازیابی رمز عبور شبکه رشد علم جوان
				</a>
			</p>
		</div>
	</body>
</html>
				