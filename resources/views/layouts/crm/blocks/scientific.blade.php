<div class="box" style="margin-top:20px;">
	<div class="head">
		<h4>جدیدترین مطالب علمی ارسال شده در شبکه رشد علم جوان</h4>

	</div><!-- .head -->
	<div class="body">
		@foreach($scientific as $row)
		<div class="list">
			<div class="row">
				<div class="col-md-3">
					@if(file_exists('assets/uploads/scientific/medium/' . $row->image))
						<img src="{!! asset('assets/uploads/scientific/medium/'.$row->image) !!}" class="img-responsive" alt="{!! $row->title !!}" style="width: 183px;height: 126px;">
					@else
						<img src="{!! asset('assets/uploads/notFound.jpg') !!}"  alt="{!! $row->title !!}" style="width: 183px;height: 126px;">
					@endif
				</div>
				<div class="col-md-9">
					<h3> {!! $row->title !!}</h3>
					<p>
						{!! str_limit(strip_tags($row->content),150) !!}
					<a href="{{URL::action('Site\ScientificController@getDetails',[$row->id,Classes\Helper::seo($row->title)])}}"  class="link green link-hover pull-left">مطالعه بیشتر ...</a>
					</p>

				</div>
			</div>
		</div><!-- /.list -->
		@endforeach
	</div><!-- .body -->
</div><!-- .box -->