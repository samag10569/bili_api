<div class="table-responsive">
                <table class="table">
                  <tbody>
				  <tr>
                    <th style="width:50%">مدرک تحصیلی</th>
                    <td>
					@php
						switch($grade_data->education){
							case 1: 
							echo 'دیپلم';
							break;
							
							case 2: 
							echo 'فوق دیپلم';
							break;
							
							case 3: 
							echo 'لیسانس';
							break;
							
							case 4: 
							echo ' فوق لیسانس';
							break;
							
							case 5: 
							echo 'دکتری';
							break;

							default: echo '-';
						}
					@endphp				
					</td>
                  </tr>
				  
				  
				  <tr>
                    <th style="width:50%">جوایز ارزنده (علمی، ورزشی، هنری)</th>
                    <td>
					@php
						switch($grade_data->membership){
							case 1: 
							echo 'داخلی';
							break;
							
							case 2: 
							echo 'بین المللی';
							break;
							
							case 3: 
							echo 'داخلی دارای مدال';
							break;
							
							case 4: 
							echo 'بین المللی دارای مدال';
							break;
							
							case 5: 
							echo 'داخلی و  بین المللی دارای مدال';
							break;

							default: echo '-';
						}
					@endphp				
					</td>
                  </tr>
				  
				  <tr>
                    <th style="width:50%">عضویت در انجمن ها و موسسات معتبر ملی و بین المللی</th>
                    <td>
					@php
						switch($grade_data->membership){
							case 1: 
							echo 'داخلی';
							break;
							
							case 2: 
							echo 'بین المللی';
							break;
							
							case 3: 
							echo 'داخلی و بین المللی';
							break;
							
							case 4: 
							echo 'بنیاد ملی نخبگان';
							break;
							
							case 5: 
							echo 'تمامی گزینه ها';
							break;

							default: echo '-';
						}
					@endphp				
					</td>
                  </tr>
				  
				  <tr>
                    <th style="width:50%">تالیف مقالات، کنفراس ملی و بین المللی، علمی، پژوهشی ISI، ISC (تحویل مقاله موظفی در هر سال شامل یک امتیاز می شود.)</th>
                    <td>
					
						@if($grade_data->project_required1) مقاله یا کنفراس داخلی دارد. (پروژه موظفی سال نخست تحویل داده شده) </br> @endif
						@if($grade_data->project_required2) مقاله یا کنفراس بین المللی دارد. (پروژه موظفی سال دوم تحویل داده شده) </br> @endif
						@if($grade_data->project_required3) مقاله یا کنفراس داخلی و یا خارجی به همراه مقاله ISC (پروژه موظفی سال سوم تحویل داده شده) </br> @endif
						@if($grade_data->project_required4) مقاله یا کنفراس داخلی و یا خارجی به همراه مقاله ISI (پروژه موظفی سال چهارم تحویل داده شده) </br> @endif
						@if($grade_data->project_required5) تمامی گزینه ها (پروژه موظفی سال پنجم تحویل داده شده) </br> @endif
							
					</td>
                  </tr>
				  
                    <th style="width:50%">چاپ و تالیف و ترجمه کتاب (استفاده از خدمات چاپ کتاب مرکز معادل ترجمه کتاب می باشد.)</th>
                    <td>
					@php
						switch($grade_data->writing){
							case 1: 
							echo ' ترجمه کتاب';
							break;
							
							case 2: 
							echo ' تالیف کتاب';
							break;
							
							case 3: 
							echo ' ترجمه و تالیف کتاب';
							break;
							
							case 4: 
							echo ' ترجمه وتالیف حداقل دو کتاب با هم';
							break;
							
							case 5: 
							echo 'ترجمه و تالیف چند کتاب با هم';
							break;

							default: echo '-';
						}
					@endphp				
					</td>
                  </tr>
				  
				  <tr>
                    <th style="width:50%">ثبت اختراع یا ایده (ملی و بین المللی)</th>
                    <td>
					
						@if($grade_data->invention1) دارای ایده خام اولیه </br> @endif
						@if($grade_data->invention2) دارای اختراع ثبت نشده </br> @endif
						@if($grade_data->invention3) دارای اختراع ثبت شده </br> @endif
						@if($grade_data->invention4) دارای اختراع ثبت شده به همراه نمونه ساخته شده اولیه </br> @endif
						@if($grade_data->invention5)  دارای اختراع ثبت شده جهانی </br> @endif
							
					</td>
                  </tr>
				  
                  <tr>
                    <th style="width:50%">فعالیت های اجرایی عمومی و تجاری</th>
                    <td>
					@php
						switch($grade_data->activity){
							case 1: 
							echo 'نیمه فعال (فعال در فعالیت های عمومی تجاری، فرهنگی، علمی و اجتماعی)';
							break;
							
							case 2: 
							echo ' فعال (فعال در فعالیت های تخصصی علمی، تجاری در سطح مدیر عامل شرکت، فرهنگی در سطوح حرفه ای فرهنگی، اجتماعی و سیاسی در سطوح بالا و حرفه ای)';
							break;

							default: echo '-';
						}
					@endphp				
					</td>
                  </tr>
				  
				  
                  <tr>
                    <th style="width:50%">دوره های آموزشی (علمی، ورزشی، هنری) (استفاده از خدمات دوره های آموزش آزاد مرکز یک امتیاز دارد)</th>
                    <td>
					@php
						switch($grade_data->education_courses){
							case 1: 
							echo '   گذراندن حداقل یک دوره داخلی ';
							break;
							
							case 2: 
							echo ' گذراندن بیش از یک دوره داخلی';
							break;
							
							case 3: 
							echo 'گذراندن حداقل یک دوره خارجی';
							break;
							
							case 4: 
							echo ' گذراندن حداقل یک دوره داخلی و یک دورهه خارجی';
							break;
							
							case 5: 
							echo 'گذراندن دوره های متعدد داخلی و خارجی';
							break;

							default: echo '-';
						}
					@endphp				
					</td>
                  </tr>
				  
				  
                  <tr>
                    <th style="width:50%">طرح های پژوهشی</th>
                    <td>
					@php
						switch($grade_data->research_projects){
							case 1: 
							echo 'دارای طرح خام اولیه';
							break;
							
							case 2: 
							echo 'دارای طرح اجرا شده';
							break;

							default: echo '-';
						}
					@endphp				
					</td>
                  </tr>
				  
                  <tr>
                    <th style="width:50%">استفاده از خدمات بین المللی</th>
                    <td>
						@if($grade_data->use_of_services1) CV برد بین المللی </br> @endif
						@if($grade_data->use_of_services2) گرید یا کارت بین الملل </br> @endif
						@if($grade_data->use_of_services3) ثبت ایده بین الملل یا مشاوره حقوقی </br> @endif
						@if($grade_data->use_of_services4) ثبت اختراع ScienceRSS </br> @endif
						@if($grade_data->use_of_services5)  ثبت اختراع US Patent </br> @endif
					</td>
                  </tr>
				  
                  <tr>
                    <th style="width:50%">خدمات کاربینی در صنعت</th>
                    <td>
					@php
						switch($grade_data->services_caribbean){
							case 1: 
							echo 'استفاده از حداقل یک خدمت';
							break;
							
							case 2: 
							echo 'استفاده از چند خدمت ';
							break;

							default: echo '-';
						}
					@endphp				
					</td>
                  </tr>
				  
                  <tr>
                    <th style="width:50%">امتیاز علمی فناور</th>
                    <td>
					{{$score}}
					</td>
                  </tr>
				  
                  <tr>
                    <th style="width:50%"> ارسال درخواست مدرک معادل داخلی به زبان فارسی</th>
                    <td>
						@if($grade_data->equivalent_persian)
							درخواست داده است. در انتظار واریز
						@else
							درخواست نداده است.
						@endif
					</td>
                  </tr>
				  
				  <?php /*
                  <tr>
                    <th style="width:50%">ارسال درخواست گواهی تعیین گرید علمی رسمی با هولوگرام و به زبان فارسی</th>
                    <td>
						@if($grade_data->scientific_certification_persian)
							درخواست داده است. در انتظار واریز
						@else
							درخواست نداده است.
						@endif
					</td>
                  </tr>
				  
                  <tr>
                    <th style="width:50%">ارسال درخواست گواهی تعیین گرید علمی رسمی با هولوگرام و به زبان خارجی</th>
                    <td>
						@if($grade_data->scientific_certification_english)
							درخواست داده است. در انتظار واریز
						@else
							درخواست نداده است.
						@endif
					</td>
                  </tr>
				  */ ?>
				  
                </tbody></table>
              </div>