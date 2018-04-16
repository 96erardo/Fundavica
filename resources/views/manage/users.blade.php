@extends('layouts.compound')

@section('title', 'Administrar')

@section('header', 'Usuarios')

@section('subtitle', 'Observa y gestiona los niveles y estados de los usuarios')

@section('options')
<li><a href="{{ url('post/manage') }}">Publicaciones</a></li>
<li class="is-active"><a href="{{ url('user/manage') }}">Usuarios</a></li>
<li><a href="{{ url('donation/manage') }}">Donaciones</a></li>
<li ><a href="{{ url('account/manage') }}">Cuentas Bancarias</a></li>
@endsection

@section('content')
<section class="background-is-soft">
	<br><br>
	<div class="container">
		@include('partials.message')
		<div class="columns is-centered">
			<div class="column is-12">
				<div class="card-plain">
					<div class="card-content">
						<table class="tabla table is-fullwidth is-hoverable">
							<thead>
								<tr>
									<th>Nombre</th>
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
									<td>{{ $user->role->nombre_visible }}</td>
									<td>{{ $user->status->nombre_visible }}</td>
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
	</div>
	<br><br>
</section>
@endsection
