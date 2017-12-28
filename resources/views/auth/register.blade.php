@extends('layouts.simple')

@section('title', 'Registro')

@section('content')
<section class="background-is-light">
	<div class="container">
		<br><br>
		<div class="columns is-centered">
			<div class="column is-8">
				<div class="card-plain">
					<div class="card-image">
						<div class="hero is-success">
							<div class="hero-body has-text-centered">
								<h2 class="title is-2">
									Registrar <i class="fa fa-address-card" aria-hidden="true"></i>
								</h2>
							</div>
						</div>
					</div>
					<div class="card-content">
						<form method="POST" action="{{'/register'}}">
							{{ csrf_field() }}
							<div class="field is-horizontal">
								<div class="field-label is-small">
									<label class="label">Nombre</label>
								</div>										
							 	<div class="field-body">
									<div class="field">
										<p class="control is-expanded has-icons-left">
											<input class="input {{$errors->has('nombre') ? 'is-danger':''}}" type="name" name="nombre" required placeholder="Nombre">
											<span class="icon is-small is-left">
                                                <i class="fa fa-user" aria-hidden="true"></i>
                                            </span>
										</p>
										@if($errors->has('nombre'))
											<p class="help is-danger">
												{{ $errors->first('nombre') }}
											</p>
										@endif
									</div>											
								</div>
							</div>
							<div class="field is-horizontal">
								<div class="field-label is-small">
									<label class="label">Apellido</label>
								</div>
								<div class="field-body">
									<div class="field">
										<p class="control is-expanded has-icons-left">
											<input class="input {{$errors->has('apellido') ? 'is-danger':''}}" type="name" name="apellido" required placeholder="Apellido">
											<span class="icon is-small is-left">
                                                <i class="fa fa-user" aria-hidden="true"></i>
                                            </span>
										</p>
										@if($errors->has('apellido'))
											<p class="help is-danger">
												{{ $errors->first('apellido') }}
											</p>
										@endif
									</div>
								</div>
							</div>
							<div class="field is-horizontal">
								<div class="field-label is-small">
									<label class="label">Nombre de usuario</label>
								</div>										
							 	<div class="field-body">
									<div class="field">
										<p class="control is-expanded has-icons-left">
											<input class="input {{$errors->has('usuario') ? 'is-danger':''}}" type="name" name="usuario" required placeholder="Nombre de Usuario">
											<span class="icon is-small is-left">
                                                <i class="fa fa-user-o" aria-hidden="true"></i>
                                            </span>
										</p>
										@if($errors->has('usuario'))
											<p class="help is-danger">
												{{ $errors->first('usuario') }}
											</p>
										@endif
									</div>											
								</div>
							</div>
							<div class="field is-horizontal">
								<div class="field-label is-small">
									<label class="label">Correo</label>
								</div>										
							 	<div class="field-body">
									<div class="field">
										<p class="control is-expanded has-icons-left">
											<input class="input {{$errors->has('correo') ? 'is-danger':''}}" type="email" name="correo" required placeholder="Correo electrónico">
											<span class="icon is-small is-left">
                                                <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                            </span>
										</p>
										@if($errors->has('correo'))
											<p class="help is-danger">
												{{ $errors->first('correo') }}
											</p>
										@endif
									</div>											
								</div>
							</div>
							<div class="field is-horizontal">
								<div class="field-label is-small">
									<label class="label">Contraseña</label>
								</div>
								<div class="field-body">
									<div class="field">
										<p class="control is-expanded has-icons-left">
											<input class="input {{$errors->has('clave') ? 'is-danger':''}}" type="password" name="clave" required placeholder="Contraseña">
											<span class="icon is-small is-left">
                                                <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                                            </span>
										</p>
										@if($errors->has('clave'))
											<p class="help is-danger">
												{{ $errors->first('clave') }}
											</p>
										@endif
									</div>
								</div>
							</div>
							<div class="field is-horizontal">
								<div class="field-label is-small">
									<label class="label">Repetir contraseña</label>
								</div>
								<div class="field-body">
									<div class="field">
										<p class="control is-expanded has-icons-left">
											<input class="input {{$errors->has('clave_confirmation') ? 'is-danger':''}}" type="password" name="clave_confirmation" required placeholder="Repita la contraseña">
											<span class="icon is-small is-left">
                                                <i class="fa fa-unlock" aria-hidden="true"></i>
                                            </span>
										</p>
										@if($errors->has('clave_confirmation'))
											<p class="help is-danger">
												{{ $errors->first('clave_confirmation') }}
											</p>
										@endif
									</div>
								</div>
							</div>
							<br>						
							<div class="level">
								<div class="level-left"></div>
								<div class="level-right">
									<button class="button is-primary is-outlined level-item" type="submit">
										<span>Aceptar</span>
                                        <span class="icon">
                                            <i class="fa fa-check" aria-hidden="true"></i>
                                    	</span>
									</button>
									<a href="{{url('/')}}" class="button is-danger is-outlined level-item">
										<span>Cancelar</span>
                                        <span class="icon">
                                            <i class="fa fa-ban" aria-hidden="true"></i>
                                        </span> 
									</a>
								</div>
							</div>												
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection