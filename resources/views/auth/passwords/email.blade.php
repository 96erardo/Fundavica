@extends('layouts.simple')

@section('title', 'Olvidó su contraseña')

@section('content')
<section class="background-is-light">
	<div class="container">
		<br><br>
		<div class="columns is-centered">
			<div class="column is-8">
				<div class="card-plain">
					<div class="hero is-warning">
						<div class="hero-body text-is-centered">
							<h3 class="title is-3">
								¿Olvidó su contraseña? <i class="fa fa-unlock-alt" aria-hidden="true"></i>
							</h3>
						</div>
					</div>
					<div class="card-content">
						@include('partials.message')
						<form method="POST" action="{{ url('user/update/password') }}">
							{{ csrf_field() }}
							<div class="field">
								<label class="label">Dirección de correo electrónico</label>
								<div class="control">
									<input class="input {{$errors->has('correo') ? 'is-danger' : ''}}" type="email" name="correo" required placeholder="Correo electrónico">
								</div>
								@if($errors->has('correo'))
									<p class="help is-danger">
										{{ $errors->first('correo') }}
									</p>
								@endif
							</div>
							<br>
							<div class="level">
								<div class="level-left"></div>
								<div class="level-right">
									<button class="button is-success level-item" type="submit">
										<span>Restaurar contraseña</span>
										<span class="icon">
											<i class="fa fa-envelope-o" aria-hidden="true"></i>
										</span>
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<br><br>
</section>
@endsection