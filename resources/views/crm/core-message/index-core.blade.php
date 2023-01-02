@extends('layouts.crm.master')

@section('content')


    <div class="col-md-8">
		@include('layouts.site.blocks.help')
        <div class="box" style="margin-top:50px;">
            <div class="head">
                <h4>درخواست های هسته تسهیل</h4>
            </div><!-- .head -->
            <div class="body">
                <div class="row profile-network">
                    <div class="col-md-12">
                        <div class="accordion-content" id="accordion-content">

                            <div id="content1" class="content">
                                <div class="title-area">
                                    <hr>
                                    <p class="link blue title">درخواست های کاربران</p>
                                </div>
                                @foreach($data as $row)
									@php
										$color = 'gray';
										if($row->status == 2)
											$color = 'red';
										elseif($row->status == 0)
											$color = 'gray';
										elseif($row->status == 1)
											$color = 'green';
									@endphp
                                    <div class="connect clearfix">
                                        <h4><a href="{{URL::action('Crm\CoreMessageController@getView',$row->id)}}">{{$row->title}}</a></h4>
                                        <p>{{$row->content}}</p>
                                        <p href=""  class="link {{$color}} link-hover">@if(isset($status[$row->status]))
                                                {{$status[$row->status]}}
                                            @endif</p>
                                        <p href=""  class="link blue link-hover">{{@$row->factualy->title}}</p>
										@if($row->status != 2)
											<a style="float: left;" href="{{URL::action('Crm\CoreMessageController@getClose',$row->id)}}"  class="link red link-hover">
											<i class="fa fa-remove"></i>	بستن درخواست
											</a>
										@endif
                                    </div><!-- /.connect -->
                                @endforeach

                            </div><!-- /#content2 -->
                        </div><!-- /#accordion-content -->
                    </div>
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
    @include('layouts.crm.blocks.sidebar')

@stop
