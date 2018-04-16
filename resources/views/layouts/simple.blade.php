<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Fundavica | @yield('title')</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/app.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/custom.css') }}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	@yield('script')
	<script src="{{ URL::asset('js/app.js') }}"></script>
</head>
<body>
	<nav class="navbar" role="navigation" aria-label="aria-label">
		<div class="container">
			<div class="navbar-brand">
				<a class="navbar-item" href="{{ url('/') }}">
					<img src="{{URL::asset('img/logo.png')}}" alt="Fundavica">
				</a>
				<div class="navbar-burger burger" data-target="navMenu">
					<span></span>
					<span></span>
					<span></span>
				</div>
			</div>		
			<div id="navMenu" class="navbar-menu">
				<div class="navbar-start">
					<a class="navbar-item" href="https://www.facebook.com/Fundavica-428010880045/" target="_blank">
                        <span class="icon" style="color: #3b5998;">
                            <i class="fa fa-facebook-official" aria-hidden="true"></i>
                        </span>
                    </a>
                    <a class="navbar-item" href="#" target="_blank">
                        <span class="icon" style="color: #cd486b;">
                            <i class="fa fa-instagram" aria-hidden="true"></i>
                        </span>
                    </a>
                    <a class="navbar-item" href="https://twitter.com/search?vertical=default&q=Fundavica&src=typd" target="_blank">
                        <span class="icon" style="color: #1dcaff;">
                            <i class="fa fa-twitter" aria-hidden="true"></i>
                        </span>
                    </a>
				</div>
				<div class="navbar-end">
					@if(Auth::check())
						<div class="navbar-item">
							<a class="button is-small is-primary is-outlined profile-button" href="{{ url('user/profile') }}">
								<span>{{Auth::user()->nombre}} {{Auth::user()->apellido}}</span>
								<span class="icon">
									<i class="fa fa-user-o" aria-hidden="true"></i>
								</span>
							</a>
						</div>
						@if(Auth::user()->tipo == 1)
							<div class="navbar-item">
								<a class="button is-small is-primary is-outlined" href="{{url('post/manage')}}">
									<span>Administrar</span>
									<span class="icon">
										<i class="fa fa-line-chart" aria-hidden="true"></i>
									</span>
								</a>
							</div>
						@elseif(Auth::user()->tipo == 2)
							<div class="navbar-item">
								<a class="button is-small is-primary is-outlined" href="{{url('post/manage/writer')}}">
									<span>Administrar</span>
									<span class="icon">
										<i class="fa fa-line-chart" aria-hidden="true"></i>
									</span>
								</a>
							</div>
						@endif
						<div class="navbar-item">
							<a class="button is-small is-danger is-outlined" href="{{ url('logout') }}">
								<span>Cerrar Sesión</span>
								<span class="icon">
									<i class="fa fa-times" aria-hidden="true"></i>
								</span>
							</a>
						</div>
					@else
						<div class="navbar-item">
							<a class="button is-small is-primary is-outlined" href="{{ url('login') }}">
								<span>Iniciar Sesión</span>
								<span class="icon">
									<i class="fa fa-key" aria-hidden="true"></i>
								</span>
							</a>
						</div>
						<div class="navbar-item">
							<a class="button is-small is-success is-outlined" href="{{ url('register') }}">
								<span>Registrate</span>
								<span class="icon">
									<i class="fa fa-address-book-o" aria-hidden="true"></i>
								</span>
							</a>
						</div>
					@endif
				</div>				
			</div>
		</div>		
	</nav>
	@yield('content')	
	@if(Auth::check())
		<div class="modal" id="profile-modal">
			<div class="modal-background profile-button"></div>
			<div class="model-content">
				<div class="modal-card">
					@if(Auth::user()->tipo == 1)
						<div class="hero is-success">
					@elseif(Auth::user()->tipo == 2)
						<div class="hero is-warning">
					@elseif(Auth::user()->tipo == 3)
						<div class="hero is-info">
					@endif
						<div class="hero-body">
							<div class="container">
								<h3 class="title is-3">{{Auth::user()->nombre}} {{Auth::user()->apellido}}</h3>
								<p class="subtitle">
									@if(Auth::user()->tipo == 1)
										Administrador <i class="fa fa-line-chart" aria-hidden="true"></i>
									@elseif(Auth::user()->tipo == 2)
										Redactor <i class="fa fa-newspaper-o" aria-hidden="true"></i>
									@elseif(Auth::user()->tipo == 3)
										Estandar <i class="fa fa-user-circle-o" aria-hidden="true"></i>
									@endif
								</p>
							</div>
						</div>                    
					</div>
					<section class="modal-card-body">
						<p class="title is-6"><strong>Nombre:</strong> <small>{{Auth::user()->nombre}} {{Auth::user()->apellido}}.</small></p>
						<p class="title is-6"><strong>Nombre de usuario:</strong> <small>{{Auth::user()->usuario}}.</small></p>
						<p class="title is-6"><strong>Correo electrónico:</strong> <small>{{Auth::user()->correo}}.</small></p>
					</section>
					<footer class="modal-card-foot">
						<div class="level">
							<div class="level-left"></div>
							<div class="level-right">
								<a class="button is-success level-item" href="{{ url('user/edit/' . Auth::user()->id) }}">
									<span>Editar mi información</span>
									<span class="icon">
										<i class="fa fa-pencil" aria-hidden="true"></i>
									</span>
								</a>
								<a class="button is-danger level-item" href="{{ url('user/delete/' . Auth::user()->id) }}">
									<span>Cerrar mi cuenta en Fundavica</span>
									<span class="icon">
										<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
									</span>
								</a>
							</div>
						</div>
					</footer>
				</div>
			</div>
			<button class="modal-close is-large profile-button" aria-label="close"></button>
		</div>
	@endif
	<div class="modal" id="delete-modal">
		<div class="modal-background delete-button"></div>
		<div class="model-content">
			<div class="modal-card">
				<div class="hero is-danger">
					<div class="hero-body has-text-centered">
						<h4 class="title is-4">¿ Seguro que desea eliminar esta información ?</h4>
						<p class="subtitle is-4">
							Una vez eliminado, no podrá recuperar esta información
						</p>
					</div>                    
				</div>
				<footer class="modal-card-foot">
					<div class="level">
						<div class="level-left"></div>
						<div class="level-right">
							<a class="button is-success level-item" id="delete-button" href="">
								<span>Eliminar</span>
								<span class="icon">
									<i class="fa fa-eraser" aria-hidden="true"></i>
								</span>
							</a>
							<a class="button is-danger level-item delete-button" href="{{ url('/') }}">
								<span>Cancelar</span>
								<span class="icon">
									<i class="fa fa-ban" aria-hidden="true"></i>
								</span>
							</a>
						</div>
					</div>
				</footer>
			</div>
		</div>
		<button class="modal-close is-large delete-button" aria-label="close"></button>
	</div>
</body>
</html>