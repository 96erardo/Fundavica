@if(Auth::check())
	<div class="modal" id="profile-modal">
		<div class="modal-background profile-button"></div>
		<div class="model-content">
			<div class="modal-card">
				@if(Auth::user()->role_id == 4)
					<div class="hero is-success">
				@elseif(Auth::user()->role_id == 3)
					<div class="hero is-warning">
				@elseif(Auth::user()->role_id == 2 || Auth::user()->role_id == 1)
					<div class="hero is-info">
				@endif
					<div class="hero-body">
						<div class="container">
							<h3 class="title is-3">{{Auth::user()->nombre}} {{Auth::user()->apellido}}</h3>
							<p class="subtitle">
								@if(Auth::user()->role_id == 4)
									Administrador <i class="fa fa-line-chart" aria-hidden="true"></i>
								@elseif(Auth::user()->role_id == 4)
									Redactor <i class="fa fa-newspaper-o" aria-hidden="true"></i>
								@elseif(Auth::user()->role_id == 2)
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
							<a class="button is-success level-item" href="{{ url('user/edit') }}">
								<span>Editar mi información</span>
								<span class="icon">
									<i class="fa fa-pencil" aria-hidden="true"></i>
								</span>
							</a>
							<a class="button is-danger level-item del" href="{{ url('user/delete') }}">
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