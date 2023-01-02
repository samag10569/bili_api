@extends('layouts.crm.master')

@section('content')


    <div class="col-md-8">
		@include('layouts.site.blocks.help')
        <div class="box" style="margin-top:30px;">
            <div class="head">
                <h4>پروژه های موظفی </h4>

            </div>
            <!-- .head -->
            <div class="body">
                <!---------------------- ACCORDION -------------------->
                <div class="row profile-network">
                    <div class="col-md-12">
                        <div class="accordion-content" id="accordion-content">
                            <div id="content4" class="content">
                                @foreach($data as $row)
                                <div class="connect clearfix">
                                    <h4>{{$row->title}}</h4>
                                    <p>{{$row->abstract}}</p>
									@php
										$color = 'gray';
										if($row->status_id == 1)
											$color = 'red';
										elseif($row->status_id == 2)
											$color = 'gray';
										elseif($row->status_id > 2)
											$color = 'green';
									@endphp
                                    <a href="#" class="link {{$color}} link-hover">
                                        {{@$row->projectRequiredStatus->title}}
                                    </a>
                                    <a href="{{URL::action('Crm\ProjectController@getView',$row->id)}}" class="link blue link-hover">
                                        مشاهده
                                    </a>
                                </div><!-- /.connect -->
                                @endforeach
                            </div><!-- /#content4 -->
                        </div><!-- /#accordion-content -->
                    </div>
					<center>
						@if(count($data))
							{!! $data->appends(Request::except('page'))->render() !!}
						@endif
					</center>
                </div>
                <!---------------------- ACCORDION -------------------->

            </div>
            <!-- .body -->
        </div>
        <!-- .box -->



    </div>
    @include('layouts.crm.blocks.sidebar')

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

        function caller(x) {
            $.ajax({
                url: x,
                success: function (x) {
                    var data = JSON.parse(x);
                    $("#"+data.id).html(data.phone_call);
                }
            });
        }

        $(document).ready(function () {
            $('#check-all').change(function () {
                $(".delete-all").prop('checked', $(this).prop('checked'));
            });
        });
    </script>

@stop