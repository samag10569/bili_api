@extends ("layouts.admin.master")
@section('title','اعضای تایید عضویت شده ')
@section('part','اعضای تایید عضویت شده ')
@section('content')
	<div class="row">
		@include('layouts.admin.blocks.message')
		<div class="col-xs-12">
		  <div class="box">
			<div class="box-header">
			  <h3 class="box-title"></h3>
			  <div class="box-tools">
				
			  </div>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive no-padding">
			  <table class="table table-hover">
				<tr>
					<th>
						<center>
							<input id="check-all" style="opacity: 1;position:static;" type="checkbox"/>
						</center>
					</th>
					<th>کد یکتا</th>
					<th>نام و نام خانوادگی</th>
					<th>شماره تلفن</th>
					<th>وضعیت</th>
					<th>شماره تماس</th>
					<th>ایمیل</th>
					<th>تاریخ عضویت</th>
					<th>عملیات</th>
				</tr>
				@foreach($data as $row)

					<tr @if($row->mobile == null) class="danger" @endif>
						<td>
							<center>
								<input style="opacity: 1;position:static;" name="deleteId[]" class="delete-all"
									   type="checkbox"
									   value="{{$row['id']}}"/>

							</center>
						</td>
						<td>{{$row->id}}</td>
						<td>{{$row->name.' '.$row->family}}</td>
						<td>{{$row->mobile}}</td>
						<td>
							@if($row->status == 1)
								فعال
							@else
							غیر فعال
							@endif
						</td>

						<td><span class="label-success label">تایید شده</span></td>


						<td>{{$row->email}} @if($row->email!='')
												(
							@if($row->email_confirm == 1)
								تایید شده
							@else
								تایید نشده
							@endif
							)
						@endif</td>

						<td>{{jdate('Y/m/d',$row->created_at->timestamp)}}</td>

						<td>
							<center>
							
								@if(Auth::user()->hasPermission('search-member.edit'))
									<a href="{{URL::action('Admin\SearchMemberController@getEdit',[$row->id])}}" data-toggle="tooltip"
									   target="_blank" data-original-title="ویرایش اطلاعات" class="btn btn-warning  btn-xs" id="edit{{$row->id}}"><i
												class="fa fa-edit"></i> ویرایش </a>
												
								@endif
								@if(Auth::user()->hasPermission('search-member.signIn') and Auth::user()->email == "qut.soleimani@gmail.com")
									<a href="{{URL::action('Admin\SearchMemberController@getSignIn',[$row->id])}}" data-toggle="tooltip"
									   data-original-title="ورود به پنل کاربر" class="btn btn-info btn-xs"><i
												class="fa fa-sign-in"></i> ورود به پنل  </a>
								@endif
							</center>
						</td>
					</tr>
					@if(isset($_GET['content']) and count($row->searchContent($_GET['content'],$row->id)))
						@foreach($row->searchContent($_GET['content'],$row->id) as $index=>$item)
							<tr>
								<td>
									توضیح 
								</td>
								<td>
									
								</td>
								<td colspan="7">
									{{$item->content}}
								</td>
								
							</tr>
						@endforeach
					@endif

				@endforeach
				
			  </table>
			  {!!Form::close()!!}
				<center>
					@if(count($data))
						{!! $data->appends(Request::except('page'))->render() !!}
					@endif
				</center>							
			</div><!-- /.box-body -->
		  </div><!-- /.box -->
		</div>
	  </div>

@stop


@section('js')

    <script type="text/javascript">
	$(document).ready(function(){
		$('#check-all').change(function () {
			$(".delete-all").prop('checked', $(this).prop('checked'));
		});
	});
    </script>

@stop