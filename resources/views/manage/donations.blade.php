@extends('layouts.compound')

@section('title', 'Administrar')

@section('header', 'Donaciones')

@section('subtitle', '¡Dale reconocimiento a quien se lo merece!')

@section('options')
<li><a href="{{ url('post/manage/0') }}">Publicaciones</a></li>
<li><a href="{{ url('user/manage/0') }}">Usuarios</a></li>
<li class="is-active"><a href="{{ url('donation/manage/0') }}">Donaciones</a></li>
<li ><a href="{{ url('account/manage') }}">Cuentas Bancarias</a></li>
@endsection

@section('content')
<section class="background-is-soft">
	<br>
	<div class="container">
		<div class="columns">
			<div class="column is-12">
				<form method="POST" action="{{ url('donations/manage/search') }}">
					{{ csrf_field() }}
					<div class="field has-addons">
						<div class="control is-expanded">
							<input id="search" name="busqueda" type="text" class="input" placeholder="Busca la donación que te interese">
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
									<th>Nombre</th>
									<th>Cédula</th>
									<th>Correo</th>
									<th>Medio</th>
									<th>Operación</th>
									<th>Monto</th>
									<th>Fecha</th>
									<th>Estado</th>
									<th>Acción</th>
								</tr>								
							</thead>
							<tbody>
								@foreach($donations as $donation)
								<tr>
									<td>{{ $donation->nombre }} {{ $donation->apellido }}</td>
									<td>{{ $donation->cedula }}</td>
									<td>{{ $donation->correo }}</td>
									<td>{{ $donation->medio }}</td>
									<td>{{ $donation->operacion }}</td>
									<td>{{ $donation->monto }} {{ $donation->moneda }}</td>
									<td>{{ $donation->fecha }}</td>
									@if($donation->estado == 0)
										<td>Pendiente</td>
									@else
										<td>Validada</td>
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
													@if($donation->estado == 0)
														<a href="{{ url('donations/validate/'.$donation->id) }}" class="dropdown-item">
															Validar
														</a>
													@else
														<a href="{{ url('donations/reject/'.$donation->id) }}" class="dropdown-item">
															Rechazar
														</a>
													@endif
													<a href="{{ url('donations/delete/'.$donation->id) }}" class="dropdown-item del">
														Eliminar
													</a>
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
				<a href="{{ url('donations/manage/'.($page-1)) }}" class="button is-primary is-outlined level-item" {{ $page > 0 ? '': 'disabled' }}>Anterior</a>
				<a href="{{ url('donations/manage/'.$page) }}" class="button is-primary is-outlined level-item" {{ ($page+1) == $pages ? 'disabled':'' }}>Siguiente</a>
			</div>
		</div>
	</div>
	<br><br>
</section>
@endsection
