@extends('layouts.compound')

@section('title', 'Administrar')

@section('header', 'Donaciones')

@section('subtitle', '¡Dale reconocimiento a quien se lo merece!')

@section('options')
<li><a href="{{ url('post/manage') }}">Publicaciones</a></li>
<li><a href="{{ url('user/manage') }}">Usuarios</a></li>
<li class="is-active"><a href="{{ url('donation/manage') }}">Donaciones</a></li>
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
	</div>
	<br><br>
</section>
@endsection
