@extends('layouts.simple')

@section('title', 'Reestablecer Contraseña')

@section('content')
<section class="background-is-light">
	<div class="container">
		<br><br>
		<div class="columns is-centered">
			<div class="column is-8">
				<div class="card-plain">
					<div class="hero is-info">
						<div class="hero-body text-is-centered">
							<h3 class="title is-3">
								Reestablecer Contraseña <i class="fa fa-unlock-alt" aria-hidden="true"></i>
							</h3>
						</div>
					</div>
					<div class="card-content">
						@include('partials.message')
						<form method="POST" action="{{ url('user/password/reset') }}">
							{{ csrf_field() }}
                            <input type="text" name="token" value="{{$token}}" hidden>
							<div class="field">
								<label class="label">Contraseña</label>
								<div class="control">
									<input class="input {{$errors->has('clave') ? 'is-danger' : ''}}" type="password" name="clave" required placeholder="Contraseña">
								</div>
								@if($errors->has('clave'))
									<p class="help is-danger">
										{{ $errors->first('clave') }}
									</p>
								@endif
							</div>
                            <div class="field">
								<label class="label">Repita la contraseña</label>
								<div class="control">
									<input class="input {{$errors->has('clave_confirmation') ? 'is-danger' : ''}}" type="password" name="clave_confirmation" required placeholder="Repita la contraseña">
								</div>
								@if($errors->has('clave_confirmation'))
									<p class="help is-danger">
										{{ $errors->first('clave_confirmation') }}
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