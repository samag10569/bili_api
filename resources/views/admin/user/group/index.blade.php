@extends ("layouts.admin.master")
@section('title','سطح دسترسی')
@section('part','سطح دسترسی')
@section('content')
	<div class="row">
		@include('layouts.admin.blocks.message')
		<div class="col-xs-12">
		  <div class="box">
			<div class="box-header">
			  <h3 class="box-title"></h3>
			  {!! Form::open(array('action' => array('Admin\UserController@postGroupDelete'),'style'=>'float: left')) !!}
			  <div class="box-tools">
				<a class="btn btn-success btn-xs" href="{{URL::action('Admin\UserController@getGroupAdd')}}" data-toggle="tooltip"
								   data-original-title="آیتم جدید">
					<i class="fa fa-plus"></i> جدید 
				</a>
				
				<button type="submit" onclick="return confirm('آیا از حذف اطلاعات مطمئن هستید.');"
				data-toggle="tooltip"
								   data-original-title="حذف موارد انتخابی"
					class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> حذف انتخاب شده ها
				</button>
				
				
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
					<th>کد</th>
					<th>عنوان</th>
					<th>عملیات</th>
				</tr>
				@foreach($data as $row)

					<tr>
						<td>
							<center>
								<input style="opacity: 1;position:static;" name="deleteId[]" class="delete-all"
									   type="checkbox"
									   value="{{$row['id']}}"/>

							</center>
						</td>
						<td>{{$row->id}}</td>
						<td>{{$row->name}}</td>
						<td>
								<a href="{{URL::action('Admin\UserController@getGroupEdit',[$row->id])}}" data-toggle="tooltip"
								   data-original-title="ویرایش اطلاعات" class="btn btn-warning  btn-xs"><i
											class="fa fa-edit"></i> ویرایش </a>
						</td>
					</tr>

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

@section('css')
    <link href="{{ asset('assets/admin/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
@stop


@section('js')

    <script src="{{ asset('assets/admin/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ asset('assets/admin/js/bootstrap-datepicker.fa.min.js')}}"></script>

    <script>

        $(".date").datepicker({
            changeMonth: true,
            changeYear: true,
            isRTL: true
        });

        $(document).ready(function () {
            $('#check-all').change(function () {
                $(".delete-all").prop('checked', $(this).prop('checked'));
            });
        });
    </script>

@stop