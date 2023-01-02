<div class="box-body">
    <div class="form-group">
        <div class="row">

            <div class="col-md-6">
                <label>کاربر: </label>
                {!! Form::text('user_id',null,array(
                    'class'=>'form-control',
                    'id'=>'user_id')) !!}
                <span id="user-info-name"></span>
            </div>
            <div class="col-md-6">
                <label>نام سازمان:</label>
                {!! Form::text('company_name',null,array(
                    'class'=>'form-control')) !!}
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <label>شماره نامه:</label>
                {!! Form::text('letter_id',null,array(
                    'class'=>'form-control')) !!}
            </div>
            <div class="col-md-6">
                <label>نوع: </label>
                {!! Form::select('type_id',$type_id,null,array('class'=>'form-control')) !!}
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label>آدرس:</label>
                {!! Form::textarea('address',null,array(
                    'class'=>'form-control','rows'=>'2')) !!}
            </div>
        </div>
    </div>


    <div class="box-footer">
        <button type="submit" class="btn btn-primary">ذخیره</button>
    </div>
</div>

@section('js')
    <script>
        ;(function($){
            $.fn.extend({
                donetyping: function(callback,timeout){
                    timeout = timeout || 1e3; // 1 second default timeout
                    var timeoutReference,
                        doneTyping = function(el){
                            if (!timeoutReference) return;
                            timeoutReference = null;
                            callback.call(el);
                        };
                    return this.each(function(i,el){
                        var $el = $(el);
                        $el.is(':input') && $el.on('keyup keypress paste',function(e){
                            if (e.type=='keyup' && e.keyCode!=8) return;
                            if (timeoutReference) clearTimeout(timeoutReference);
                            timeoutReference = setTimeout(function(){
                                doneTyping(el);
                            }, timeout);
                        }).on('blur',function(){
                            doneTyping(el);
                        });
                    });
                }
            });
        })($);
        $( document ).ready(function() {
            $('#user_id').donetyping(function(){
                $.ajax({
                    method: "POST",
                    dataType: 'json',
                    url: '{!!URL::action('Admin\InterductionController@postUser')!!}',
                    data: { _token: '{!! csrf_token() !!}' ,code: $('#user_id').val() },
                    success: function(row) {
                        if(row.status=='success')
                            $('#user-info-name').html(row.data)
                        else
                            $('#user-info-name').html('کاربر یافت نشد.')
                    }
                });
                return false;
            });
        });
    </script>
@stop