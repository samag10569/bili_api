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
								<label>نام خانوادگی:</label>
								{!! Form::text('family',null,array(
									'class'=>'form-control',
									'placeholder'=>'نام خانوادگی را وارد کنید . . .')) !!}
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<lable>تصویر :</lable>
								{!! Form::file('image',array(
									'class'=>'form-control')) !!}
							</div>
							<div class="col-md-2">
								@if(isset($data) and $data->image!='Not Image' and $data->image!='')
									<img src="{!!asset('assets/uploads/member/medium/'.$data->image)!!}"
											class="img-rounded"
											style="width: 100px; height: 60px;">
								@endif
							</div>
							<div class="col-md-4">
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label>نام پدر:</label>
								{!! Form::text('father_name',$info_data->father_name,array(
									'class'=>'form-control',
									'placeholder'=>'نام پدر را وارد کنید . . .')) !!}
							</div>
							<div class="col-md-6">
								<label>تاریخ تولد:</label>
								{!! Form::text('birth',jdate('d/m/Y',$info_data->birth,'','','en'),array(
									'class'=>'form-control',
									'id'=>'birth',
									'placeholder'=>'تاریخ تولد را وارد کنید . . .')) !!}
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label>کد ملی:</label>
								{!! Form::text('national_id',$info_data->national_id,array(
									'class'=>'form-control',
									'data-inputmask'=>"'mask': ['9999999999']",
									'data-mask'=>"",
									'placeholder'=>'کد ملی را وارد کنید . . .')) !!}
							</div>
							<div class="col-md-6">
								<label>شماره همراه:</label>
								{!! Form::text('mobile',null,array(
									'class'=>'form-control',
									'placeholder'=>'شماره همراه را وارد کنید . . .')) !!}
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label>ایمیل:</label>
								{!! Form::email('email',null,array(
								'class'=>'form-control',
								'disabled'=>'',
								'placeholder'=>'ایمیل را وارد کنید . . .')) !!}
							</div>
							@php
								$interview_type_id1 = null;
								$interview_type_id0 = null;
								if($info_data->interview_type_id == 1)
									$interview_type_id1 = true;
								else
									$interview_type_id0 = true;
							@endphp
							<div class="col-md-6 ejavan_col">
								<label>نوع مصاحبه:</label>
								&nbsp;&nbsp;&nbsp;
								{!!Form::radio('interview_type_id', 1, $interview_type_id1)!!}
								<label>حضوری</label>
								&nbsp;&nbsp;&nbsp;
								{!!Form::radio('interview_type_id',0, $interview_type_id0)!!}
								<label>غیر حضوری</label>
								
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label>تاریخ مصاحبه:</label>
								{!! Form::text('date_interview',jdate('d/m/Y',$data->date_interview,'','','en'),array(
									'class'=>'form-control',
									'id'=>'date_interview',
									'disabled'=>'',
									'placeholder'=>'تاریخ مصاحبه را وارد کنید . . .')) !!}
							</div>
							<div class="col-md-6">
								<label>ساعت مصاحبه:</label>
								{!! Form::text('time_interview',null,array(
									'class'=>'form-control',
									'data-inputmask'=>"'mask': ['99:99']",
									'data-mask'=>"",
									'disabled'=>'',
									'placeholder'=>'ساعت مصاحبه را وارد کنید . . .')) !!}
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							@php
								$rejection = false;
								$status_id_1 = false;
								$status_id_2 = false;
								$status_id_3 = false;
								$status_id_4 = false;
								$status_id_5 = false;
								$active = [];
								
								if($data->rejection) $rejection = true;
								elseif($data->status_id == 1) $status_id_1 = true;
								elseif($data->status_id == 2) $status_id_2 = true;
								elseif($data->status_id == 3) $status_id_2 = true;
								elseif($data->status_id == 4) $status_id_2 = true;
								elseif($data->status_id == 5) $status_id_2 = true;
							@endphp
							<div class="col-md-2 ejavan_col">
								<label>وضعیت عضو:</label>
							</div>
							<div class="col-md-5 ejavan_col">
								
								{!!Form::radio('member_status_id', 1,$status_id_1)!!}
								<label>در انتظار بررسی کارشناس جهت مصاحبه (برگشت پرونده به مرحله قبل)</label>
								</br>
								
								{!!Form::radio('member_status_id',2,$status_id_2)!!}
								<label>  اعضای تایید شده جهت مصاحبه (تعیین گرید)</label>
								</br>
								
								{{--{!!Form::radio('member_status_id',3,$status_id_3)!!}--}}
								{{--<label>  تایید جهت تخصیص خدمت</label>--}}
								{{--</br>--}}

								{{--{!!Form::radio('member_status_id',4,$status_id_4)!!}--}}
								{{--<label>  تایید اولیه</label>--}}
								{{--</br>--}}

								{{--{!!Form::radio('member_status_id',5,$status_id_5)!!}--}}
								{{--<label>  تایید نهایی</label>--}}
								{{--</br>--}}
								
								{!!Form::radio('member_status_id',-1,$rejection,array('id'=>'rejection'))!!}
								<label> عضویت رایگان</label>
								</br>
								
							</div>
							
							<div class="col-md-3">
							
								{!! Form::text('reason_rejection',null,array(
									'class'=>'form-control',
									'id'=>'reason_rejection',
									'placeholder'=>'دلیل رد شدن عضو را وارد کنید . . .')) !!}
							</br>
								<span class="ejavan_col">		
										<label>نوع عضویت:</label>
										@foreach($membershipType as $item)
										
											@php
												$membership_type_id = null;
												if($info_data->membership_type_id == $item->id)
													$membership_type_id = true;
												else
													$membership_type_id = false;
												
												if(Auth::user()->hasPermission('orders.membershipTypeEdit'))
													$disabled = [];
												else
													$disabled = ['disabled'=>''];
											@endphp
									
											</br>
											{!!Form::radio('membership_type_id', $item->id, $membership_type_id,$disabled)!!}
											<label @if($info_data->membership_type_id == $item->id) class="ejavan_select_radio" @endif>{{$item->title}}</label>
										@endforeach
								</span>
							</div>
							
							
							
							<div class="col-md-2">
								@if($info_data->membership_type_id == 3 || $info_data->membership_type_id == 4)
									@php
										$date_end = ($info_data->date_membership_type + ($info_data->membershipType->time*86400));
									@endphp
									<label>تاریخ پایان عضویت:</label>
									{!! Form::text('date_membership_type',jdate('d/m/Y',$date_end,'','','en'),array(
										'class'=>'form-control',
										'id'=>'date_membership_type',
										'disabled'=>'',
										'placeholder'=>'تاریخ پایان عضویت را وارد کنید . . .')) !!}
								@endif
							</div>
							
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label>مقطع تحصیلی:</label>
								{!! Form::select('branch_id',$branch_id,null,array('class'=>'form-control')) !!}
							</div>
							<div class="col-md-6">
								<label>شاخه تحصیلی:</label>
								{!! Form::select('category_id',$category_id,null,array('class'=>'form-control')) !!}
							</div>
						</div>
					</div>
					
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label>رشته تحصیلی:</label>
								{!! Form::text('branch',$info_data->branch,array(
								'class'=>'form-control',
								'placeholder'=>'رشته تحصیلی را وارد کنید . . .')) !!}
							</div>
							<div class="col-md-6">
								<label>امتیاز علمی فناور:</label>
								{!! Form::text('score',$info_data->score,array(
								'class'=>'form-control',
								'disabled'=>'',
								'placeholder'=>'امتیاز علمی فناور')) !!}
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label>استان:</label>
								{!! Form::select('state_id',$state_id,$info_data->state_id,array('class'=>'form-control')) !!}
							</div>
							<div class="col-md-6">
								<label>کدپستی:</label>
								{!! Form::text('postal_code',$info_data->postal_code,array(
									'class'=>'form-control',
									'data-inputmask'=>"'mask': ['9999999999']",
									'data-mask'=>"",
									'placeholder'=>'ساعت مصاحبه را وارد کنید . . .')) !!}
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-12">
								<label>آدرس محل سکونت:</label>
								{!! Form::text('city',$info_data->city,array(
								'class'=>'form-control',
								'placeholder'=>'آدرس را وارد کنید . . .')) !!}
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label>وضعیت شغلی:</label>
								{!! Form::text('employment_status',$info_data->employment_status,array(
								'class'=>'form-control',
								'placeholder'=>'وضعیت شغلی را وارد کنید . . .')) !!}
							</div>
							<div class="col-md-6">
								<label>مدیر ثبت نام کننده:</label>
								{!! Form::select('admin_id',$admin_id,null,array('class'=>'form-control')) !!}
							</div>
						</div>
					</div>
					
					@php
						$article = false;
						$invention = false;
						$ideas = false;
						$expertise = false;
						if($info_data->article) $article = true;
						if($info_data->invention) $invention = true;
						if($info_data->ideas) $ideas = true;
						if($info_data->expertise) $expertise = true;
					@endphp
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-2">
								<label>گزینه ها:</label>
							</div>
							<div class="col-md-2">
								{!!Form::checkbox('article', 1, $article )!!}
								&nbsp;
								<label>مقاله دارد</label>
							</div>
							<div class="col-md-2">
								{!!Form::checkbox('invention', 1,$invention)!!}
								&nbsp;
								<label>ثبت اختراع دارد </label>
							</div>
							<div class="col-md-2">
								{!!Form::checkbox('ideas', 1,$ideas)!!}
								&nbsp;
								<label>ایده دارد </label>
							</div>
							<div class="col-md-2">
								{!!Form::checkbox('expertise', 1,$expertise)!!}
								&nbsp;
								<label>تخصص دارد </label>
							</div>
							<div class="col-md-2">
							</div>
						</div>
					</div>
					
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-12">
								<label>عنوان مقاله:</label>
								{!! Form::text('article_title',$info_data->article_title,array(
								'class'=>'form-control',
								'placeholder'=>'عنوان مقاله را وارد کنید . . .')) !!}
							</div>
						</div>
					</div>
					
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-12">
								<label>عنوان اختراع:</label>
								{!! Form::text('invention_title',$info_data->invention_title,array(
								'class'=>'form-control',
								'placeholder'=>'عنوان اختراع را وارد کنید . . .')) !!}
							</div>
						</div>
					</div>
					
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-12">
								<label>عنوان ایده:</label>
								{!! Form::text('ideas_title',$info_data->ideas_title,array(
								'class'=>'form-control',
								'placeholder'=>'عنوان ایده را وارد کنید . . .')) !!}
							</div>
						</div>
					</div>
					
					<div class="form-group expertise">
						<label>عنوان تخصص ها (توانایی ها ) را وارد کنید:</label>
						<select name="skills[]" class="selectpicker form-control" multiple>
							@foreach($skills as $item)
								<option value="{{$item->id}}" @if(in_array($item->id, $skillId)) selected @endif>{{$item->title}}</option>
							@endforeach
						</select>
					</div>
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label>اعتبار طرح ایده:</label>
								{!! Form::select('credibility_id',$credibility_id,$info_data->credibility_id,array('class'=>'form-control')) !!}
							</div>
							<div class="col-md-6">
								<label>درجه علمی:</label>
								{!! Form::text('score_id',$info_data->score_id,array(
								'class'=>'form-control',
								'disabled'=>'',
								'placeholder'=>'درجه علمی')) !!}
							</div>
						</div>
					</div>
					
					@php
						$job_status1 = null;
						$job_status0 = null;
						if(@$info_data->job_status == 1)
							$job_status1 = true;
						else
							$job_status0 = true;
					@endphp
					
					<div class="form-group">
						<div class="row">
							<div class="col-lg-3 ejavan_col">
								{!!Form::radio('job_status', 1, $job_status1)!!}
								<label>شاغل هست</label>
							</div>
							<div class="col-lg-3 ejavan_col">
								{!!Form::radio('job_status', 0, $job_status0)!!}
								<label>شاغل نیست</label>
							</div>
							<div class="col-lg-6 job">
								<label>عنوان شغل:</label>
								{!! Form::text('employment_status',$info_data->employment_status,array(
								'class'=>'form-control',
								'id'=>'employment_status',
								'placeholder'=>'عنوان شغل را وارد کنید . . .')) !!}
							</div>
						</div>
					</div>
					
					<div class="form-group job">
						<div class="row">
							<div class="col-lg-6 job">
								<label>شرکت:</label>
								{!! Form::text('company',$info_data->company,array(
								'class'=>'form-control',
								'id'=>'company',
								'placeholder'=>'شرکت را وارد کنید . . .')) !!}
							</div>
							<div class="col-lg-6 job">
								<label>عنوان صنعت:</label>
								{!! Form::text('industry',$info_data->industry,array(
								'class'=>'form-control',
								'id'=>'industry',
								'placeholder'=>'عنوان صنعت را وارد کنید . . .')) !!}
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label>رمز:</label>
								{!! Form::password('password',array(
									'class'=>'form-control',
									'placeholder'=>'رمز را وارد کنید . . .')) !!}
							</div>
							<div class="col-md-6">
								<label>تکرار رمز:</label>
								{!! Form::password('repassword',array(
									'class'=>'form-control',
									'placeholder'=>'تکرار رمز را وارد کنید . . .')) !!}
							</div>
						</div>
					</div>
					
					@php
						$core_scientific1 = null;
						$core_scientific0 = null;
						if(@$data->core_scientific == 1)
							$core_scientific1 = true;
						else
							$core_scientific0 = true;
					@endphp
					
					<div class="form-group">
						<div class="row">
							<div class="col-lg-3 ejavan_col">
								{!!Form::radio('core_scientific', 1, $core_scientific1)!!}
								<label>عضو هسته علمی هست</label>
							</div>
							<div class="col-lg-3 ejavan_col">
								{!!Form::radio('core_scientific', 0, $core_scientific0)!!}
								<label>عضو هسته علمی نیست</label>
							</div>
							<div class="col-lg-6">
								<label>کارشناس:</label>
								<select name="groups[]" class="selectpicker form-control" multiple>
									@foreach($groups as $item)
										<option value="{{$item->id}}" @if(in_array($item->id, $groupsId)) selected @endif>{{$item->title}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-12">
								<label>رزومه:</label>
								{!! Form::textarea('cv',null,array(
								'class'=>'form-control ckeditor',
								'placeholder'=>'رزومه را وارد کنید . . .')) !!}
							</div>
						</div>
					</div>
					
				@include('layouts.admin.blocks.message-ajax')
				
					<div class="form-group">
						<div class="row">
							<div class="col-md-12">
								<label> توضیحات اضافی</label>
								{!! Form::textarea('content',null,array(
								'class'=>'form-control',
								'rows'=>'3',
								'placeholder'=>'توضیحات اضافی را وارد کنید . . .')) !!}
							</div>
						</div>
					</div>
					
				@foreach($content_data as $item)
					<div class="form-group">
						<div class="row">
							<div class="col-md-10" id="content{{$item->id}}">
								<label>
									{{@$item->admin->name.' '.@$item->admin->family}} 
									&nbsp;&nbsp;&nbsp;
									{{jdate('Y/m/d H:i',$item->created_at->timestamp)}} 
								</label>
								{!! Form::textarea('cv',$item->content,array(
								'class'=>'form-control',
								'rows'=>'3',
								'placeholder'=>'توضیحات اضافه را وارد کنید . . .')) !!}
							</div>
							<div class="col-md-2 ejavan_col">
								<a class="btn btn-danger btn-sm delete_content" id="delete_content{{$item->id}}"
								   style="cursor:pointer" onclick="deleteContent('{{URL::action('Admin\SearchMemberController@getDeleteContent',$item->id)}}',{{$item->id}})" ><i
											class="fa fa-trash"></i> حذف توضیحات</a>
								<center class="loading" id="loading{{$item->id}}">
								<img src="{{ asset('assets/admin/img/loading.gif')}}" width="30" height="30"/>
								در حال حذف اطلاعات لطفا شکیبا باشید.
								</center>
							</div>
						</div>
					</div>
				@endforeach
					
					
				  <div class="box-footer">
					<button type="submit" class="btn btn-primary">ذخیره</button>
				  </div>