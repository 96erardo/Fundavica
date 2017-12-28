@extends('layouts.compound')

@section('title', 'Administrar')

@section('header', 'Usuarios')

@section('subtitle', 'Observa y gestiona los niveles y estados de los usuarios')

@section('options')
<li><a href="{{ url('post/manage/0') }}">Publicaciones</a></li>
<li class="is-active"><a href="{{ url('user/manage/0') }}">Usuarios</a></li>
<li><a href="{{ url('donation/manage/0') }}">Donaciones</a></li>
<li ><a href="{{ url('account/manage') }}">Cuentas Bancarias</a></li>
@endsection

@section('content')
<section class="background-is-soft">
	<br>
	<div class="container">
		<div class="columns">
			<div class="column is-12">
				<form method="POST" action="{{ url('users/manage/search') }}">
					{{ csrf_field() }}
					<div class="field has-addons">
						<div class="control is-expanded">
							<input id="search" name="busqueda" type="text" class="input" placeholder="Busca el usuario que te interese">
						</div>
						<div class="control">
							<button type="submit" class="button is-info">
								<span>Buscar</span>
								<span class="icon">
									<i class="fa fa-search" aria-hidden="true"></i>
								</span>
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<br>
</section>
<section class="background-is-white">
	<br>
	<div class="container">
		@include('partials.message')
		<div class="columns is-centered">
			<div class="column is-12">
				<div class="card-plain">
					<div class="card-content">
						<table class="table is-fullwidth">
							<thead>
								<tr>
									<th>Nombre y apellido</th>
									<th>Usuario</th>
									<th>Correo</th>
									<th>Tipo</th>
									<th>Estado</th>
									<th>Acción</th>
								</tr>								
							</thead>
							<tbody>
								@foreach($users as $user)
								<tr>
									<td>{{ $user->nombre }} {{ $user->apellido }}</td>
									<td>{{ $user->usuario }}</td>
									<td>{{ $user->correo }}</td>
									<td>{{ $user->getType() }}</td>
									@if($user->estado == 1)
										<td>Activo</td>
									@else
										<td>Bloqueado</td>
									@endif
									<td>
										<div class="dropdown">
											<div class="dropdown-trigger">
												<button class="button is-success" aria-haspopup="true" aria-controls="dropdown-menu2">
													<span>Acción</span>
													<span class="icon is-small">
														⬇
													</span>
												</button>
											</div>
											<div class="dropdown-menu" id="dropdown-menu2" role="menu">
												<div class="dropdown-content">
													@if($user->tipo == 1)
														<a class="dropdown-item" href="{{ url('user/writer/'.$user->id) }}">
															Hacer usuario redactor
														</a>
														<a class="dropdown-item" href="{{ url('user/normal/'.$user->id) }}">
															Hacer usuario normal
														</a>
													@elseif($user->tipo == 2)
														<a href="{{ url('user/admin/'.$user->id) }}" class="dropdown-item">
															Hacer usuario administrador
														</a>
														<a class="dropdown-item" href="{{ url('user/normal/'.$user->id) }}">
															Hacer usuario normal
														</a>
													@elseif($user->tipo == 3)
														<a href="{{ url('user/admin/'.$user->id) }}" class="dropdown-item">
															Hacer usuario administrador
														</a>
														<a class="dropdown-item" href="{{ url('user/writer/'.$user->id) }}">
															Hacer usuario redactor
														</a>
													@endif
												</div>
											</div>
										</div>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="level">
			<div class="level-left"></div>
			<div class="level-right">
				<a href="{{ url('user/manage/'.($page-1)) }}" class="button is-primary is-outlined level-item" {{ $page > 0 ? '': 'disabled' }}>Anterior</a>
				<a href="{{ url('user/manage/'.$page) }}" class="button is-primary is-outlined level-item" {{ ($page+1) == $pages ? 'disabled':'' }}>Siguiente</a>
			</div>
		</div>
	</div>
	<br><br>
</section>
@endsection
