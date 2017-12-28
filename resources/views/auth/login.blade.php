@extends('layouts.simple')

@section('title', 'Iniciar sesión')

@section('content')
<section class="background-is-light">
	<div class="container">
		<br><br>
		<div class="columns is-centered">
			<div class="column is-6">
				<div class="card-plain">
					<div class="card-image">
						<div class="hero is-info">
							<div class="hero-body has-text-centered">
								<h2 class="title is-2">
									Inicia Sesión <i class="fa fa-user-circle-o" aria-hidden="true"></i>
								</h2>
							</div>
						</div>
					</div>
					<div class="card-content">
						@include('partials.message')
						<form method="POST" action="{{ url('login') }}">
							{{ csrf_field() }}
							<div class="field">
								<label class="label">Nombre de usuario</label>
								<div class="control">
									<input class="input {{$errors->has('usuario') ? 'is-danger':''}}" type="text" name="usuario">
								</div>
								@if($errors->has('usuario'))
									<p class="help is-danger">
										{{$errors->first('usuario')}}
									</p>
								@endif
							</div>
							<div class="field">
								<label class="label">Contraseña</label>
								<div class="control">
									<input class="input {{$errors->has('clave') ? 'is-danger':''}}" type="password" name="password">
								</div>
								@if($errors->has('clave'))
									<p class="help is-danger">
										{{$errors->first('clave')}}
									</p>
								@endif				
							</div>
							<div class="field">
								<label class="checkbox">
									<input type="checkbox" name="remember"/>
									Recuerdame
								</label>
							</div>
							<div class="field">
								<div class="level">
									<div class="level-left">
										<a href="{{ url('password/reset') }}">¿Olvidó su contraseña?</a>
									</div>
									<div class="level-right">
										<button class="button is-primary is-outlined level-item" type="submit">
											<span>Ingresar</span>
                                            <span class="icon">
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                            </span>
										</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<br><br>
	</div>
</section>
@endsection