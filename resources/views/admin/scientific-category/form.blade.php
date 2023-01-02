<div class="box-body">



            <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <label> عنوان:</label>
                {!! Form::text('title',null,array(
                    'class'=>'form-control',
                    'id'=>'date',
                    'placeholder'=>' عنوان را وارد کنید . . .')) !!}
            </div>
            <div class="col-md-6">
               <label>وضعیت:</label>
                {!! Form::select('status',$status,null,array(
                    'class'=>'form-control')) !!}
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <label> والد:</label>
                {!! Form::select('parent_id',$category,null,array(
                    'class'=>'form-control')) !!}
            </div>
        </div>
    </div>


    <div class="box-footer">
        <button type="submit" class="btn btn-primary">ذخیره</button>
    </div>

</div>