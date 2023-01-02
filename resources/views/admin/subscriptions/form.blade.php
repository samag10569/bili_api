<div class="box-body">



            <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <label> کاربر:</label>
                {!! Form::select('user_id',$user,null,array(
                    'class'=>'form-control chosen chosen-select')) !!}
            </div>
            <div class="col-md-6">
               <label>فروشگاه:</label>
                {!! Form::select('shop_id',$shop,null,array(
                    'class'=>'form-control chosen-select')) !!}
            </div>

        </div>

    </div>


    <div class="box-footer">
        <button type="submit" class="btn btn-primary">ذخیره</button>
    </div>

</div>

@section('css')
    <link href="{{ asset('css/chosen.min.css')}}" rel="stylesheet">
    @stop
@section('js')
    <script src="{{asset('js/chosen.jquery.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            $(".chosen-select").chosen();
        });
    </script>
    @stop