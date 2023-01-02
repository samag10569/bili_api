<div class="box-body">
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <label>نام:</label>
                {!! Form::text('name',null,array(
                    'class'=>'form-control',
                    'placeholder'=>'نام را وارد کنید . . .')) !!}
            </div>
            <div class="col-md-6">
                <label>وضعیت:</label>
                {!! Form::select('published',$status,null,array(
                    'class'=>'form-control')) !!}
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <label>ایمیل:</label>
                {!! Form::email('email',null,array(
                    'class'=>'form-control')) !!}
            </div>
            <div class="col-md-6">
                <label>وب سایت:</label>
                {!! Form::url('url',null,array(
                    'class'=>'form-control')) !!}
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">

            <div class="col-md-12">
                <label>نظر:</label>
                {!! Form::textarea('comment',null,array(
                    'class'=>'form-control',
                    'rows'=>3)) !!}
            </div>
        </div>
    </div>

    <div class="box-footer">
        <button type="submit" class="btn btn-primary">ذخیره</button>
    </div>
    </div>