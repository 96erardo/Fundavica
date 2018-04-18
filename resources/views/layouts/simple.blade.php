<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Fundavica | @yield('title')</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/app.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/custom.css') }}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="{{ URL::asset('js/plugins/jquery/jquery-3.3.1.min.js') }}"></script>
	<script src="{{ URL::asset('js/plugins/datatables/jquery.dataTables.js') }}"></script>
	<script src="{{ URL::asset('js/plugins/datatables-bulma/js/dataTables.bulma.min.js') }}"></script>
	<script src="{{ URL::asset('js/app.js') }}"></script>
	@yield('top_script')
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
	@includeWhen(Auth::check(), 'partials.modal-profile')
	@includeWhen(Auth::check(), 'partials.modal-delete')
	@yield('script')
</body>
</html>