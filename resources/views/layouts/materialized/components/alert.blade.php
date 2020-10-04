@if (session('alert'))
	<?php $color = (session('alert.type') == "danger") ? "red" : "green" ;  ?>
	<div id="card-alert" class="card {{ $color }}  lighten-5">
		<div class="card-content {{ $color }}-text"><p>{!! session('alert.message') !!}</p></div>
		<button type="button" class="close {{ $color }}-text" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
	</div>
@endif

@if ($errors->any())
	<div id="card-alert" class="card red lighten-5">
		<div class="card-content red-text">
			 @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach			
		</div>
		<button type="button" class="close red-text" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
	</div>
@endif

