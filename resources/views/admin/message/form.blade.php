<div class="box-body">
    <div class="form-group">
        <div class="row">
            <div class="container">
            <div class="col-md-10">


                    <div class="panel panel-default">
                        <div class="panel-body">
                            {!! $data->user->name  !!} &nbsp;{!! $data->user->family  !!} :
<br>
                            {{jdate('Y/m/d',$data->created_at->timestamp)}}
                            <br><br>
                            {!! $data->content !!}

                        </div>
                    </div>
                </div>

            <div class="col-md-2">
                    <span class="fa fa-user"></span>
                </div>
            </div>
        </div>
    </div>

@foreach($msg_reply as $row)
@if($row->user_id ==null)

            <div class="form-group">
                <div class="row">
                    <div class="container">
                        <div class="col-md-2">
                            <span class="fa fa-user"></span>
                        </div>
                        <div class="col-md-10">


                            <div class="panel panel-default">
                                <div class="panel-body">

                                    پاسخ ادمین :
                                    <br>
                                    {{jdate('Y/m/d',$row->created_at->timestamp)}}
                                    <br><br>
                                    {!! $row->content !!}

                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
@else
            <div class="form-group">
                <div class="row">
                    <div class="container">
                        <div class="col-md-10">


                            <div class="panel panel-default">
                                <div class="panel-body">

                                    {!! $row->User->name  !!} &nbsp;{!! $row->User->family  !!} :
                                    <br>
                                    {{jdate('Y/m/d',$row->created_at->timestamp)}}
                                    <br><br>
                                    {!! $row->content !!}

                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <span class="fa fa-user"></span>
                        </div>
                    </div>
                </div>
            </div>

    @endif
    @endforeach





@if($data->status !=2)

    <div class="form-group">
        <div class="row">

            <div class="col-md-12">
                <label>پاسخ:</label>
                {!! Form::textarea('reply',null,array(
                    'class'=>'form-control',)) !!}
            </div>
        </div>
    </div>

    <div class="col-md-4 ejavan_col">
        <button type="submit" class="btn btn-primary">پاسخ</button>
    </div>
    @endif
</div>
