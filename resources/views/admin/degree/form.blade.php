<div class="box-body">



    <div class="form-group">
        <div class="row">

            <div class="col-md-12">
                <label> نام:</label>
                {!! Form::text('title',null,array(
                    'class'=>'form-control',
                    'placeholder'=>' نام را وارد کنید . . .')) !!}
            </div>
        </div>
    </div>




    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <label>حداقل :</label>
                {!! Form::number('min',null,array(
                    'class'=>'form-control',
                    'placeholder'=>'حداقل را وارد کنید . . .')) !!}
            </div>
            <div class="col-md-6">
                <label>حداکثر :</label>
                {!! Form::number('max',null,array(
                    'class'=>'form-control',
                    'placeholder'=>'حداکثر را وارد کنید . . .')) !!}
            </div>

        </div>
    </div>



    <div class="box-footer">
        <button type="submit" class="btn btn-primary">ذخیره</button>
    </div>

</div>