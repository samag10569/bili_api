<ul class="nav nav-tabs " style="padding-right:0px">
    <li class="active">
        <a data-toggle="tab" href="#tab_default_1">

            تنظیمات ایمیل

        </a>
    </li>


</ul>
<div class="tab-content">
    <div id="tab_default_1" class="tab-pane active">

        <div class="box-body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4">
                        <label>نام کاربری:</label>
                        {!! Form::text('username',null,array(
                            'class'=>'form-control',
                            'placeholder'=>'نام کاربری را وارد کنید . . .')) !!}
                    </div>
                    <div class="col-md-4">
                        <label>پورت:</label>
                        {!! Form::text('port',null,array(
                            'class'=>'form-control',
                            'placeholder'=>'پورت را وارد کنید . . .')) !!}
                    </div>
                    <div class="col-md-4">
                        <label>فرستنده:</label>
                        {!! Form::text('sender',null,array(
                            'class'=>'form-control',
                            'placeholder'=>'فرستنده را وارد کنید . . .')) !!}
                    </div>

                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label> رمز:</label>
                        {!! Form::text('password',null,array(
                            'class'=>'form-control',
                            'placeholder'=>' رمز را وارد کنید . . .')) !!}
                    </div>
                    <div class="col-md-6">
                        <label>هاست:</label>
                        {!! Form::text('host',null,array(
                            'class'=>'form-control',
                            'placeholder'=>'هاست را وارد کنید . . .')) !!}
                    </div>

                </div>
            </div>


        </div>
    </div>


</div>


<div class="box-footer">
    <button type="submit" class="btn btn-primary">ذخیره</button>
</div>
