<div class="box-body">

    <div class="form-group">
        <div class="row">
            <div class="col-md-4">
                <label>تاریخ حضور:</label>
                {!! Form::text('date',jdate('d/m/Y',$data->date,'','','en'),array(
                    'class'=>'form-control',
                    'id'=>'date_set',
                    'placeholder'=>'تاریخ حضور را وارد کنید . . .')) !!}
            </div>
            <div class="col-md-4">
                <label>تعداد :</label>
                {!! Form::number('capacity',null,array(
                    'class'=>'form-control',
                    'placeholder'=>'تعداد را وارد کنید . . .')) !!}
            </div>
            <div class="col-md-4">
               <label>وضعیت:</label>
				{!! Form::select('status',$status,null,array(
					'class'=>'form-control')) !!}
            </div>
        </div>
    </div>
	
    <div class="box-footer">
        <button type="submit" class="btn btn-primary">ذخیره</button>
    </div>

</div>