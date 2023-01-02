@extends ("layouts.admin.master")
@section('title',' گرید علمی '.$user->id)
@section('part',' گرید علمی')
@section('content')
	<div class="row">
		<div class="col-md-12">
		 
			<div class="col-xs-12">
              <p class="lead">اطلاعات ثبت شده 
			  &nbsp; &nbsp;
			  <span style="float: left; background: rgba(60, 141, 188, 0.54) none repeat scroll 0% 0%; padding: 7px; border-radius: 10px;">
				  {{$user->name.' '.$user->family}}
				&nbsp; &nbsp;
				  {{$user->user_code}}
			  </span>
			  </p>
               @include('admin.current-day.form-print')
			  
				<a href="{{URL::action('Admin\CurrentDayMemberController@getEdit',[$user->id])}}" class="btn btn-warning print">بازگشت</a>
				<a href="#" onclick="window.print()" class="btn btn-success print">پرینت</a>
			
			  
				  
            </div>
		 
		</div>
	</div>
@stop

@section('css')
    <link href="{{ asset('assets/admin/css/print.css')}}" rel="stylesheet" media="print">
@stop
