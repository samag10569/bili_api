@extends ("layouts.admin.master")
@section('title','تایید گرید علمی')
@section('part','تایید گرید علمی')
@section('content')
	<div class="row">
		<div class="col-md-12">
		  <!-- general form elements -->
		  <div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">تایید گرید علمی  {{$user->name.' '.$user->family}}</h3>
			  <h3 class="box-title" style="float: left;">	
				<button class="btn btn-block bg-olive btn-lg">{{$user->user_code}}</button>
			  </h3>
			</div><!-- /.box-header -->
			<!-- form start -->
			@include('layouts.admin.blocks.message')
			{!! Form::model($grade_temp,array('action' => array('Admin\GradeTempController@postEdit',$user->id),'role' => 'form','files' => 'true','id' => 'ejavan_form')) !!}
			  
			  
			  <div class="box-body">
					<div class="form-group">
                        <label for="name" class="col-lg-12 well control-label">
                            ارزیاب گرامی توجه داشته باشید: 
							
							تعیین گرید فناوران از اهمیت بسزایی برخوردار است در تعیین گرید
                            نهایت دقت را داشته باشید و در زمان تایید گرید در استفاده از المان های چند انتخابی (مربع)
                            نهایت دقت را داشته باشید.
							
                        </label>
                    </div>
					
					<div class="form-group @if($grade_temp->education != -1) ejavan_grade @endif">
						@if($grade_file->education != null)
							<a target="_blank" href="{{asset('assets/uploads/grade/education/'.$grade_file->education)}}"> دانلود مدرک </a>
						@endif
						<div class="row">
							<label class="col-md-2 control-label">مدرک تحصیلی</label>
							<div class="col-md-2">
							   {!!Form::radio('education', 1)!!}   دیپلم 
							</div>
							<div class="col-md-2">
							   {!!Form::radio('education', 2)!!}   فوق دیپلم 
							</div>
							<div class="col-md-2">
							   {!!Form::radio('education', 3)!!}   لیسانس 
							</div>
							<div class="col-md-2">
							   {!!Form::radio('education', 4)!!}   فوق لیسانس 
							</div>
							<div class="col-md-2">
							   {!!Form::radio('education', 5)!!}   دکتری 
							</div>
						</div>
                    </div>
					
					<hr>
					
					<div class="form-group @if($grade_temp->prizes != -1) ejavan_grade @endif">
					
						@if($grade_file->prizes != null)
							<a target="_blank" href="{{asset('assets/uploads/grade/prizes/'.$grade_file->prizes)}}"> دانلود مدرک </a>
						@endif
						<div class="row">
							<label class="col-md-2 control-label">جوایز ارزنده (علمی، ورزشی، هنری)</label>
							<div class="col-md-2">
							   {!!Form::radio('prizes', 1)!!}   داخلی 
							</div>
							<div class="col-md-2">
							   {!!Form::radio('prizes', 2)!!}   بین المللی 
							</div>
							<div class="col-md-2">
							   {!!Form::radio('prizes', 3)!!}   داخلی دارای مدال 
							</div>
							<div class="col-md-2">
							   {!!Form::radio('prizes', 4)!!}    بین المللی دارای مدال 
							</div>
							<div class="col-md-2">
							   {!!Form::radio('prizes', 5)!!}   داخلی و بین المللی دارای مدال 
							</div>
						</div>
                    </div>
					
					<hr>
					
					<div class="form-group @if($grade_temp->membership != -1) ejavan_grade @endif">
						@if($grade_file->membership != null)
							<a target="_blank" href="{{asset('assets/uploads/grade/membership/'.$grade_file->membership)}}"> دانلود مدرک </a>
						@endif
						<div class="row">
							<label class="col-md-2 control-label">عضویت در انجمن ها و موسسات معتبر ملی
                            و بین المللی</label>
							<div class="col-md-2">
							   {!!Form::radio('membership', 1)!!}   داخلی 
							</div>
							<div class="col-md-2">
							   {!!Form::radio('membership', 2)!!}   بین المللی 
							</div>
							<div class="col-md-2">
							   {!!Form::radio('membership', 3)!!}   داخلی و بین المللی 
							</div>
							<div class="col-md-2">
							   {!!Form::radio('membership', 4)!!}   بنیاد ملی نخبگان 
							</div>
							<div class="col-md-2">
							   {!!Form::radio('membership', 5)!!}   تمامی گزینه ها 
							</div>
						</div>
                    </div>
					
					<hr>
					<div class="form-group 
					@if($grade_temp->project_required1 != -1 || $grade_temp->project_required2 != -1 || $grade_temp->project_required3 != -1 || $grade_temp->project_required4 != -1 || $grade_temp->project_required5 != -1) 
						ejavan_grade 
					@endif">
						@if($grade_file->project_required != null)
							<a target="_blank" href="{{asset('assets/uploads/grade/project_required/'.$grade_file->project_required)}}"> دانلود مدرک </a>
						@endif
						<div class="row">
							<label class="col-md-2 control-label">
								تالیف مقالات، کنفراس ملی و بین
								المللی، علمی، پژوهشی ISI، ISC (تحویل مقاله موظفی در هر سال شامل یک امتیاز می شود.)
							</label>
							<div class="col-md-2">
								@if($grade_temp->project_required1 != -1)
									{!!Form::checkbox('project_required1', 1 )!!}  مقاله یا کنفراس داخلی دارد. (پروژه موظفی سال نخست تحویل داده شده)
								@endif
							</div>
							<div class="col-md-2">
								@if($grade_temp->project_required2 != -1)
									{!!Form::checkbox('project_required2', 2)!!}    مقاله یا کنفراس بین المللی دارد. (پروژه موظفی سال دوم تحویل داده شده)
								@endif
							</div>
							<div class="col-md-2">
								@if($grade_temp->project_required3 != -1)
									{!!Form::checkbox('project_required3', 3)!!}  مقاله یا کنفراس داخلی و یا خارجی به همراه مقاله ISC (پروژه موظفی سال سوم تحویل داده شده)  
								@endif
							</div>
							<div class="col-md-2">
								@if($grade_temp->project_required4 != -1)
									{!!Form::checkbox('project_required4', 4)!!}  مقاله یا کنفراس داخلی و یا خارجی به همراه مقاله ISI (پروژه موظفی سال چهارم تحویل داده شده)
								@endif
							</div>
							<div class="col-md-2">
								@if($grade_temp->project_required5 != -1)
									{!!Form::checkbox('project_required5', 5)!!}  تمامی گزینه ها (پروژه موظفی سال پنجم تحویل داده شده) 
								@endif
							</div>
						</div>
					</div>
					
					<hr>
					
					<div class="form-group @if($grade_temp->writing != -1) ejavan_grade @endif">
						@if($grade_file->writing != null)
							<a target="_blank" href="{{asset('assets/uploads/grade/writing/'.$grade_file->writing)}}"> دانلود مدرک </a>
						@endif
						<div class="row">
							<label class="col-md-2 control-label">
								چاپ و تالیف و ترجمه کتاب (استفاده از
								خدمات چاپ کتاب مرکز معادل ترجمه کتاب می باشد.)
							</label>
							<div class="col-md-2">
							   {!!Form::radio('writing', 1)!!}   ترجمه کتاب 
							</div>
							<div class="col-md-2">
							   {!!Form::radio('writing', 2)!!}   تالیف کتاب 
							</div>
							<div class="col-md-2">
							   {!!Form::radio('writing', 3)!!}   ترجمه و تالیف کتاب 
							</div>
							<div class="col-md-2">
							   {!!Form::radio('writing', 4)!!}   ترجمه وتالیف حداقل دو کتاب با هم 
							</div>
							<div class="col-md-2">
							   {!!Form::radio('writing', 5)!!}   ترجمه و تالیف چند کتاب با هم 
							</div>
						</div>
                    </div>
					
					<hr>
					
					<div class="form-group
					@if($grade_temp->invention1 != -1 || $grade_temp->invention2 != -1 || $grade_temp->invention3 != -1 || $grade_temp->invention4 != -1 || $grade_temp->invention5 != -1) 
						ejavan_grade @endif">
						@if($grade_file->invention != null)
							<a target="_blank" href="{{asset('assets/uploads/grade/invention/'.$grade_file->invention)}}"> دانلود مدرک </a>
						@endif
						<div class="row">
							<label class="col-md-2 control-label">
								ثبت اختراع یا ایده (ملی و بین المللی)
							</label>
							<div class="col-md-2">
								@if($grade_temp->invention1 != -1)
								{!!Form::checkbox('invention1', 1 )!!}  دارای ایده خام اولیه
								@endif
							</div>
							<div class="col-md-2">
								@if($grade_temp->invention2 != -1)
								{!!Form::checkbox('invention2', 2)!!}   دارای اختراع ثبت نشده 
								@endif
							</div>
							<div class="col-md-2">
								@if($grade_temp->invention3 != -1)
								{!!Form::checkbox('invention3', 3)!!}  دارای اختراع ثبت شده
								@endif
							</div>
							<div class="col-md-2">
								@if($grade_temp->invention4 != -1)
								{!!Form::checkbox('invention4', 4)!!}   دارای اختراع ثبت شده به همراه نمونه ساخته شده اولیه
								@endif
							</div>
							<div class="col-md-2">
								@if($grade_temp->invention5 != -1)
								{!!Form::checkbox('invention5', 5)!!}  دارای اختراع ثبت شده جهانی
								@endif
							</div>
						</div>
					</div>
					
					<hr>
					
					<div class="form-group @if($grade_temp->activity != -1) ejavan_grade @endif">
						@if($grade_file->activity != null)
							<a target="_blank" href="{{asset('assets/uploads/grade/activity/'.$grade_file->activity)}}"> دانلود مدرک </a>
						@endif
						<div class="row">
							<label class="col-md-2 control-label">
								فعالیت های اجرایی عمومی و تجاری
							</label>
							<div class="col-md-5">
							   {!!Form::radio('activity', 1)!!}    نیمه فعال (فعال در فعالیت های عمومی تجاری، فرهنگی، علمی و اجتماعی)
							</div>
							<div class="col-md-5">
							   {!!Form::radio('activity', 2)!!}    فعال (فعال در فعالیت های تخصصی علمی، تجاری در سطح مدیر عامل شرکت، فرهنگی در سطوح حرفه ای
								فرهنگی، اجتماعی و سیاسی در سطوح بالا و حرفه ای)
							</div>
						</div>
                    </div>
					
					<hr>
					
					<div class="form-group @if($grade_temp->education_courses != -1) ejavan_grade @endif">
						@if($grade_file->education_courses != null)
							<a target="_blank" href="{{asset('assets/uploads/grade/education_courses/'.$grade_file->education_courses)}}"> دانلود مدرک </a>
						@endif
						<div class="row">
							<label class="col-md-2 control-label">
								دوره های آموزشی (علمی، ورزشی، هنری)  (استفاده از خدمات دوره های آموزش آزاد مرکز یک امتیاز دارد)
							</label>
							<div class="col-md-2">
							   {!!Form::radio('education_courses', 1)!!}   گذراندن حداقل یک دوره داخلی 
							</div>
							<div class="col-md-2">
							   {!!Form::radio('education_courses', 2)!!}   گذراندن بیش از یک دوره داخلی 
							</div>
							<div class="col-md-2">
							   {!!Form::radio('education_courses', 3)!!}   گذراندن حداقل یک دوره خارجی 
							</div>
							<div class="col-md-2">
							   {!!Form::radio('education_courses', 4)!!}   گذراندن حداقل یک دوره داخلی و یک دورهه خارجی 
							</div>
							<div class="col-md-2">
							   {!!Form::radio('education_courses', 5)!!}   گذراندن دوره های متعدد داخلی و خارجی 
							</div>
						</div>
                    </div>
					
					<hr>
					
					<div class="form-group @if($grade_temp->research_projects != -1) ejavan_grade @endif">
						@if($grade_file->research_projects != null)
							<a target="_blank" href="{{asset('assets/uploads/grade/research_projects/'.$grade_file->research_projects)}}"> دانلود مدرک </a>
						@endif
						<div class="row">
							<label class="col-md-2 control-label">
								طرح های پژوهشی
							</label>
							<div class="col-md-5">
							   {!!Form::radio('research_projects', 1)!!}    دارای طرح خام اولیه
							</div>
							<div class="col-md-5">
							   {!!Form::radio('research_projects', 2)!!}    دارای طرح اجرا شده
							</div>
						</div>
                    </div>
					
					<hr>
					
					<div class="form-group 
					@if($grade_temp->use_of_services1 != -1 || $grade_temp->use_of_services2 != -1 || $grade_temp->use_of_services3 != -1 || $grade_temp->use_of_services4 != -1 || $grade_temp->use_of_services5 != -1) 
						ejavan_grade @endif">
						@if($grade_file->use_of_services != null)
							<a target="_blank" href="{{asset('assets/uploads/grade/use_of_services/'.$grade_file->use_of_services)}}"> دانلود مدرک </a>
						@endif
						<div class="row">
							<label class="col-md-2 control-label">
								استفاده از خدمات بین المللی
							</label>
							<div class="col-md-2">
								@if($grade_temp->use_of_services1 != -1)
									{!!Form::checkbox('use_of_services1', 1 )!!}  CV برد بین المللی
								@endif
							</div>
							<div class="col-md-2">
								@if($grade_temp->use_of_services2 != -1)
									{!!Form::checkbox('use_of_services2', 2)!!}    گرید یا کارت بین الملل
								@endif
							</div>
							<div class="col-md-2">
								@if($grade_temp->use_of_services3 != -1)
									{!!Form::checkbox('use_of_services3', 3)!!}  ثبت ایده بین الملل یا مشاوره حقوقی
								@endif
							</div>
							<div class="col-md-2">
								@if($grade_temp->use_of_services4 != -1)
									{!!Form::checkbox('use_of_services4', 4)!!}   ثبت اختراع ScienceRSS
								@endif
							</div>
							<div class="col-md-2">
								@if($grade_temp->use_of_services5 != -1)
									{!!Form::checkbox('use_of_services5', 5)!!}  ثبت اختراع US Patent
								@endif
							</div>
						</div>
					</div>
					
					<hr>
					
					<div class="form-group @if($grade_temp->services_caribbean != -1) ejavan_grade @endif">
						@if($grade_file->services_caribbean != null)
							<a target="_blank" href="{{asset('assets/uploads/grade/services_caribbean/'.$grade_file->services_caribbean)}}"> دانلود مدرک </a>
						@endif
						<div class="row">
							<label class="col-md-2 control-label">
								خدمات کاربینی در صنعت
							</label>
							<div class="col-md-5">
							   {!!Form::radio('services_caribbean', 1)!!}    استفاده از حداقل یک خدمت
							</div>
							<div class="col-md-5">
							   {!!Form::radio('services_caribbean', 2)!!}    استفاده از چند خدمت 
							</div>
						</div>
                    </div>
					
					<hr>
					
					<div class="form-group @if($grade_temp->equivalent_persian != -1) ejavan_grade @endif">
						<div class="row">
							<div class="col-md-6">
								{!!Form::checkbox('equivalent_persian', 1 )!!}  
								 ارسال درخواست مدرک معادل داخلی به زبان فارسی
							</div>
							<div class="col-md-6">
							
							</div>
						</div>
					</div>
					<?php /*
					<hr>
					
					<div class="form-group @if($grade_temp->scientific_certification_persian != -1 || $grade_temp->scientific_certification_english != -1) ejavan_grade @endif">
						<div class="row">
							<div class="col-md-6">
								{!!Form::checkbox('scientific_certification_persian', 1 )!!}  
								 ارسال درخواست گواهی تعیین گرید علمی رسمی با هولوگرام و به زبان فارسی
							</div>
							<div class="col-md-6">
								{!!Form::checkbox('scientific_certification_english', 1)!!} 
								ارسال درخواست گواهی تعیین گرید علمی رسمی با هولوگرام و به زبان خارجی
							</div>
						</div>
					</div>
					
					*/ ?>
					<hr>
					
				  <div class="box-footer">
					<button type="submit" class="btn btn-primary">ذخیره</button>
				  </div>
				  
				  
			{!! Form::close() !!}
		  </div><!-- /.box -->
		</div>
	</div>
@stop

	