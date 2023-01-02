@foreach($help as $key=>$row)
	<div class="box">
		<div class="head">
			<h4>   {{$row->title}} </h4>

		</div>
		<!-- .head -->
		<div class="body">

			{!! $row->content !!}

		</div>
		<!-- .body -->
	</div>
	<!-- .box -->
		</br>
@endforeach