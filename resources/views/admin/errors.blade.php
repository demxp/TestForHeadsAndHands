@if($errors->any())
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="alert alert-danger">
					@foreach($errors->all() as $error)
						<li>{{$error}}</li>
					@endforeach
				</div>
			</div>
		</div>
	</div>
@endif