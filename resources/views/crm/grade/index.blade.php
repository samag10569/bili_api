@extends('layouts.crm.master')

@section('map')
<section>
	<div class="container-fluid">
		<div class="row page-navigator">
			<div class="col-md-12">
				<ul>
					<li><img src="{!! asset('assets/site/images/location.png') !!}" alt=""></li>
					<li><a href="{{URL::action('Site\HomeController@getIndex')}}">صفحه اصلی</a></li><span>/</span>
					<li><a href="">بخش تعیین گرید علمی</a></li>
				</ul>
			</div>
		</div>
		<!-- /.page-navigator -->
	</div>
</section>
@stop

@section('content')
	<div class="col-md-8">
		@include('layouts.site.blocks.help')
		<div class="box hasForm" style="margin-top:20px;">
			<div class="head">
			<h4>  مقادیر سطح گرید علمی </h4>

			</div><!-- .head -->
			<div class="body">
				<div class="profile">
					{!! Form::model($grade_data,array('action' => array('Crm\GradeController@postEdit'),'class' => 'form','files' => 'true','id' => 'ejavan_form')) !!}
			  
						<span class="form-item">
							<div class="form-group form-inline">
								<label for="">   مدرک تحصیلی:</label>
								<a href="#" class="link link-hover upload start pull-left education_file" > آپلود مدارک  </a>
								<input type="file" name="education_file" id="education_file" style="display:none" />
							</div>
							<div class="form-group form-inline">
								 <div class="checkbox">
									<label>
										 {!!Form::radio('education', 1)!!}   دیپلم 
									</label>
								</div>
								<div class="checkbox">
									<label>
										{!!Form::radio('education', 2)!!}   فوق دیپلم 
									</label>
								</div>
								<div class="checkbox">
									<label>
										{!!Form::radio('education', 3)!!}   لیسانس
									</label>
								</div>
								<div class="checkbox">
									<label>
										{!!Form::radio('education', 4)!!}   فوق لیسانس
									</label>
								</div>
								<div class="checkbox">
									<label>
										{!!Form::radio('education', 5)!!}   دکتری
									</label>
								</div>
							</div>
							<hr>
						</span><!-- /.form-item -->
						
						<span class="form-item">
							<div class="form-group form-inline">
								<label for="">   جوایز ارزنده (علمی، ورزشی، هنری):</label>
								<a href="#" class="link link-hover upload start pull-left prizes_file"  > آپلود مدارک  </a>
								<input type="file" name="prizes_file" id="prizes_file" style="display:none" />
							</div>
							<div class="form-group form-inline">
								 <div class="checkbox">
									<label>
										{!!Form::radio('prizes', 1)!!}   داخلی 
									</label>
								</div>
								<div class="checkbox">
									<label>
										{!!Form::radio('prizes', 2)!!}   بین المللی 
									</label>
								</div>
								<div class="checkbox">
									<label>
										{!!Form::radio('prizes', 3)!!}   داخلی دارای مدال 
									</label>
								</div>
								<div class="checkbox">
									<label>
										{!!Form::radio('prizes', 4)!!}    بین المللی دارای مدال 
									</label>
								</div>
								<div class="checkbox">
									<label>
										{!!Form::radio('prizes', 5)!!}   داخلی و بین المللی دارای مدال 
									</label>
								</div>
							</div>
							<hr>
						</span><!-- /.form-item -->
						
						<span class="form-item">
							<div class="form-group form-inline">
								<label for="">   عضویت در انجمن ها و موسسات معتبر ملی
                            و بین المللی:</label>
								<a href="#"  class="link link-hover upload start pull-left membership_file"> آپلود مدارک  </a>
								<input type="file" name="membership_file" id="membership_file" style="display:none" />
							</div>
							<div class="form-group form-inline">
								 <div class="checkbox">
									<label>
										{!!Form::radio('membership', 1)!!}   داخلی 
									</label>
								</div>
								<div class="checkbox">
									<label>
										{!!Form::radio('membership', 2)!!}   بین المللی 
									</label>
								</div>
								<div class="checkbox">
									<label>
										{!!Form::radio('membership', 3)!!}   داخلی و بین المللی
									</label>
								</div>
								<div class="checkbox">
									<label>
										{!!Form::radio('membership', 4)!!}   بنیاد ملی نخبگان 
									</label>
								</div>
								<div class="checkbox">
									<label>
										{!!Form::radio('membership', 5)!!}   تمامی گزینه ها 
									</label>
								</div>
							</div>
							<hr>
						</span><!-- /.form-item -->
						
						<span class="form-item">
							<div class="form-group form-inline">
								<label for="">   تالیف مقالات، کنفراس ملی و بین
								المللی، علمی، پژوهشی ISI، ISC (تحویل مقاله موظفی در هر سال شامل یک امتیاز می شود.):</label>
								<a href="#"  class="link link-hover upload start pull-left project_required_file"  > آپلود مدارک  </a>
								<input type="file" name="project_required_file" id="project_required_file" style="display:none" />
							</div>
							<div class="form-group form-inline">
								 <div class="checkbox">
									<label>
										{!!Form::checkbox('project_required1', 1 )!!}  مقاله یا کنفراس داخلی دارد. (پروژه موظفی سال نخست تحویل داده شده)
									</label>
								</div>
								<div class="checkbox">
									<label>
										{!!Form::checkbox('project_required2', 2)!!}    مقاله یا کنفراس بین المللی دارد. (پروژه موظفی سال دوم تحویل داده شده)
									</label>
								</div>
								<div class="checkbox">
									<label>
										{!!Form::checkbox('project_required3', 3)!!}  مقاله یا کنفراس داخلی و یا خارجی به همراه مقاله ISC (پروژه موظفی سال سوم تحویل داده شده) 
									</label>
								</div>
								<div class="checkbox">
									<label>
										{!!Form::checkbox('project_required4', 4)!!}  مقاله یا کنفراس داخلی و یا خارجی به همراه مقاله ISI (پروژه موظفی سال چهارم تحویل داده شده)
									</label>
								</div>
								<div class="checkbox">
									<label>
										{!!Form::checkbox('project_required5', 5)!!}  تمامی گزینه ها (پروژه موظفی سال پنجم تحویل داده شده) 
									</label>
								</div>
							</div>
							<hr>
						</span><!-- /.form-item -->
						
						<span class="form-item">
							<div class="form-group form-inline">
								<label for="">   چاپ و تالیف و ترجمه کتاب (استفاده از
								خدمات چاپ کتاب مرکز معادل ترجمه کتاب می باشد.):</label>
								<a href="#"  class="link link-hover upload start pull-left writing_file"  > آپلود مدارک  </a>
								<input type="file" name="writing_file" id="writing_file" style="display:none" />
							</div>
							<div class="form-group form-inline">
								 <div class="checkbox">
									<label>
										{!!Form::radio('writing', 1)!!}   ترجمه کتاب 
									</label>
								</div>
								<div class="checkbox">
									<label>
										{!!Form::radio('writing', 2)!!}   تالیف کتاب 
									</label>
								</div>
								<div class="checkbox">
									<label>
										{!!Form::radio('writing', 3)!!}   ترجمه و تالیف کتاب 
									</label>
								</div>
								<div class="checkbox">
									<label>
										 {!!Form::radio('writing', 4)!!}   ترجمه وتالیف حداقل دو کتاب با هم 
									</label>
								</div>
								<div class="checkbox">
									<label>
										 {!!Form::radio('writing', 5)!!}   ترجمه و تالیف چند کتاب با هم 
									</label>
								</div>
							</div>
							<hr>
						</span><!-- /.form-item -->
						
						<span class="form-item">
							<div class="form-group form-inline">
								<label for="">   ثبت اختراع یا ایده (ملی و بین المللی):</label>
								<a href="#"  class="link link-hover upload start pull-left invention_file"  > آپلود مدارک  </a>
								<input type="file" name="invention_file" id="invention_file" style="display:none" />
							</div>
							<div class="form-group form-inline">
								 <div class="checkbox">
									<label>
										{!!Form::checkbox('invention1', 1 )!!}  دارای ایده خام اولیه
									</label>
								</div>
								<div class="checkbox">
									<label>
										{!!Form::checkbox('invention2', 2)!!}   دارای اختراع ثبت نشده 
									</label>
								</div>
								<div class="checkbox">
									<label>
										{!!Form::checkbox('invention3', 3)!!}  دارای اختراع ثبت شده
									</label>
								</div>
								<div class="checkbox">
									<label>
										{!!Form::checkbox('invention4', 4)!!}   دارای اختراع ثبت شده به همراه نمونه ساخته شده اولیه
									</label>
								</div>
								<div class="checkbox">
									<label>
										{!!Form::checkbox('invention5', 5)!!}  دارای اختراع ثبت شده جهانی
									</label>
								</div>
							</div>
							<hr>
						</span><!-- /.form-item -->
						
						<span class="form-item">
							<div class="form-group form-inline">
								<label for="">   فعالیت های اجرایی عمومی و تجاری:</label>
								<a href="#"  class="link link-hover upload start pull-left activity_file"  > آپلود مدارک  </a>
								<input type="file" name="activity_file" id="activity_file" style="display:none" />
							</div>
							<div class="form-group form-inline">
								 <div class="checkbox">
									<label>
										 {!!Form::radio('activity', 1)!!}    نیمه فعال (فعال در فعالیت های عمومی تجاری، فرهنگی، علمی و اجتماعی)
									</label>
								</div>
								<div class="checkbox">
									<label>
										 {!!Form::radio('activity', 2)!!}    فعال (فعال در فعالیت های تخصصی علمی، تجاری در سطح مدیر عامل شرکت، فرهنگی در سطوح حرفه ای
								فرهنگی، اجتماعی و سیاسی در سطوح بالا و حرفه ای)
									</label>
								</div>
							</div>
							<hr>
						</span><!-- /.form-item -->
						
						<span class="form-item">
							<div class="form-group form-inline">
								<label for="">   دوره های آموزشی (علمی، ورزشی، هنری)  (استفاده از خدمات دوره های آموزش آزاد مرکز یک امتیاز دارد):</label>
								<a href="#"  class="link link-hover upload start pull-left education_courses_file"  > آپلود مدارک  </a>
								<input type="file" name="education_courses_file" id="education_courses_file" style="display:none" />
							</div>
							<div class="form-group form-inline">
								 <div class="checkbox">
									<label>
										{!!Form::radio('education_courses', 1)!!}   گذراندن حداقل یک دوره داخلی 
									</label>
								</div>
								<div class="checkbox">
									<label>
										 {!!Form::radio('education_courses', 2)!!}   گذراندن بیش از یک دوره داخلی
									</label>
								</div>
								<div class="checkbox">
									<label>
										 {!!Form::radio('education_courses', 3)!!}   گذراندن حداقل یک دوره خارجی 
									</label>
								</div>
								<div class="checkbox">
									<label>
										 {!!Form::radio('education_courses', 4)!!}   گذراندن حداقل یک دوره داخلی و یک دورهه خارجی 
									</label>
								</div>
								<div class="checkbox">
									<label>
										{!!Form::radio('education_courses', 5)!!}   گذراندن دوره های متعدد داخلی و خارجی 
									</label>
								</div>
							</div>
							<hr>
						</span><!-- /.form-item -->
						
						<span class="form-item">
							<div class="form-group form-inline">
								<label for="">   طرح های پژوهشی:</label>
								<a href="#"  class="link link-hover upload start pull-left research_projects_file"  > آپلود مدارک  </a>
								<input type="file" name="research_projects_file" id="research_projects_file" style="display:none" />
							</div>
							<div class="form-group form-inline">
								 <div class="checkbox">
									<label>
										{!!Form::radio('research_projects', 1)!!}    دارای طرح خام اولیه
									</label>
								</div>
								<div class="checkbox">
									<label>
										{!!Form::radio('research_projects', 2)!!}    دارای طرح اجرا شده
									</label>
								</div>
							</div>
							<hr>
						</span><!-- /.form-item -->
						
						<span class="form-item">
							<div class="form-group form-inline">
								<label for="">   استفاده از خدمات بین المللی:</label>
								<a href="#"  class="link link-hover upload start pull-left use_of_services_file"  > آپلود مدارک  </a>
								<input type="file" name="use_of_services_file" id="use_of_services_file" style="display:none" />
							</div>
							<div class="form-group form-inline">
								 <div class="checkbox">
									<label>
										{!!Form::checkbox('use_of_services1', 1 )!!}  CV برد بین المللی
									</label>
								</div>
								<div class="checkbox">
									<label>
										{!!Form::checkbox('use_of_services2', 2)!!}    گرید یا کارت بین الملل
									</label>
								</div>
								<div class="checkbox">
									<label>
										{!!Form::checkbox('use_of_services3', 3)!!}  ثبت ایده بین الملل یا مشاوره حقوقی
									</label>
								</div>
								<div class="checkbox">
									<label>
										{!!Form::checkbox('use_of_services4', 4)!!}   ثبت اختراع ScienceRSS
									</label>
								</div>
								<div class="checkbox">
									<label>
										{!!Form::checkbox('use_of_services5', 5)!!}  ثبت اختراع US Patent
									</label>
								</div>
							</div>
							<hr>
						</span><!-- /.form-item -->
						
						<span class="form-item">
							<div class="form-group form-inline">
								<label for="">   خدمات کاربینی در صنعت:</label>
								<a href="#"  class="link link-hover upload start pull-left services_caribbean_file"  > آپلود مدارک  </a>
								<input type="file" name="services_caribbean_file" id="services_caribbean_file" style="display:none" />
							</div>
							<div class="form-group form-inline">
								 <div class="checkbox">
									<label>
										{!!Form::radio('services_caribbean', 1)!!}    استفاده از حداقل یک خدمت
									</label>
								</div>
								<div class="checkbox">
									<label>
										{!!Form::radio('services_caribbean', 2)!!}    استفاده از چند خدمت 
									</label>
								</div>
							</div>
							<hr>
						</span><!-- /.form-item -->
						
						<span class="form-item">
							<div class="form-group form-inline">
								<label for="">   دریافت مدرک معادل معتبر:</label>
							</div>
							<div class="form-group form-inline">
								 <div class="checkbox">
									<label>
										{!!Form::checkbox('equivalent_persian', 1 )!!}  
										ارسال درخواست مدرک معادل داخلی به زبان فارسی
									</label>
								</div>
							</div>
							<hr>
						</span><!-- /.form-item -->
						<?php /*
						<span class="form-item">
							<div class="form-group form-inline">
								<label for="">   هولوگرام:</label>
							</div>
							<div class="form-group form-inline">
								 <div class="checkbox">
									<label>
										{!!Form::checkbox('scientific_certification_persian', 1 )!!}  
								 ارسال درخواست گواهی تعیین گرید علمی رسمی با هولوگرام و به زبان فارسی
									</label>
								</div>
								<div class="checkbox">
									<label>
										{!!Form::checkbox('scientific_certification_english', 1)!!} 
								ارسال درخواست گواهی تعیین گرید علمی رسمی با هولوگرام و به زبان خارجی
									</label>
								</div>
							</div>
							<hr>
						</span><!-- /.form-item -->
						*/ ?>
					</div><!-- /.profile -->
	
				<button href="" class="link green link-hover pull-left"> ثبت نهایی </button>
				
			{!! Form::close() !!}
			</div><!-- .body -->
		</div><!-- .box -->



		<div class="box hasForm" style="margin-top:20px;">
			<div class="head">
					<h4>  استفاده از خدمات شبکه رشد علم جوان    </h4>

			</div><!-- .head -->
			<div class="body">
				<div class="profile">
				<form class="form">
					@if(count($allotment_date) == 0)
						<span class="form-item">
							<div class="form-group form-inline">
								<a href="{{URL::action('Crm\AllotmentController@getIndex')}}" class="link link-hover reject pull-left" style="width: 100%;">  
									کاربر گرامی
									</br>
									 شما هنوز سرویسی به خود اختصاص نداده اید. کلیک کنید
								</a>
							</div>
							</br>
						</span>
					@endif
					@foreach($allotment_date as $row)
						<span class="form-item">
							<div class="form-group form-inline">
								<p>{{@$row->allotment->title}} :</p>	
								@if($row->status == 2)
									<a class="link link-hover approve pull-left">  استفاده شده است  </a>		
								@else
									<a class="link link-hover reject pull-left">  در انتظار تایید مدیریت  </a>
								@endif
							</div>
							<div class="form-group form-inline">
								<p>مجموعه انتیازات شما از این خدمات : 0 امتیاز</p>
							</div>
							<hr>
						</span><!-- /.form-item -->
					@endforeach
					</form>
				</div><!-- /.profile -->
			</div><!-- .body -->
		</div><!-- .box -->
	</div>
	@include('layouts.crm.blocks.sidebar')

@endsection

@section('css')

	<style>
		img.avatar {
			cursor: pointer;
		}
	</style>
@stop



@section('js')
	<script src="{{ asset('assets/site/js/upload.js')}}"></script>
	
    <script>

		$('.education_file').click(function(){ $('#education_file').trigger('click'); });
		chngText("education_file");
		$('.prizes_file').click(function(){ $('#prizes_file').trigger('click'); });
		chngText("prizes_file");
		$('.membership_file').click(function(){ $('#membership_file').trigger('click'); });
		chngText("membership_file");
		$('.project_required_file').click(function(){ $('#project_required_file').trigger('click'); });
		chngText("project_required_file");
		$('.writing_file').click(function(){ $('#writing_file').trigger('click'); });
		chngText("writing_file");
		$('.invention_file').click(function(){ $('#invention_file').trigger('click'); });
		chngText("invention_file");
		$('.activity_file').click(function(){ $('#activity_file').trigger('click'); });
		chngText("activity_file");
		$('.education_courses_file').click(function(){ $('#education_courses_file').trigger('click'); });
		chngText("education_courses_file");
		$('.research_projects_file').click(function(){ $('#research_projects_file').trigger('click'); });
		chngText("research_projects_file");
		$('.use_of_services_file').click(function(){ $('#use_of_services_file').trigger('click'); });
		chngText("use_of_services_file");
		$('.services_caribbean').click(function(){ $('#services_caribbean').trigger('click'); });
		chngText("services_caribbean");
	
	</script>		
@endsection