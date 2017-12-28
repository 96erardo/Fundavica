@extends('layouts.compound')

@section('title', 'Administrar')

@section('header', 'Cuentas Bancarias')

@section('subtitle', 'Deja que la comunidad te ayude, dale tus datos.')

@section('options')
<li><a href="{{ url('post/manage/0') }}">Publicaciones</a></li>
<li><a href="{{ url('user/manage/0') }}">Usuarios</a></li>
<li><a href="{{ url('donation/manage/0') }}">Donaciones</a></li>
<li  class="is-active"><a href="{{ url('account/manage') }}">Cuentas Bancarias</a></li>
@endsection

@section('content')
<section class="background-is-soft">
	<br>
	<div class="container">
		@include('partials.message')
		<div class="columns">
			<div class="column is-12">
				<div class="card-plain">
					<div class="card-content">
						<h3 class="title is-3">Agrega una cuenta bancaria</h3>
						<form method="POST" action="{{ url('account/new') }}">
							{{ csrf_field() }}
							<div class="columns">
								<div class="column is-6">
									<div class="field">
										<label class="label">Medio</label>
										<div class="control">
											<input class="input" type="name" name="medio" placeholder="Ej: Banco de Venezuela" required>
										</div>
									</div>
								</div>
								<div class="column is-6">
									<div class="field">
										<label class="label">Nro de cuenta</label>
										<div class="control">
											<input class="input" type="name" name="nro" placeholder="Ej: 10-23-139105829710" required>
										</div>
									</div>
								</div>
							</div>
							<div class="level">
								<div class="level-left"></div>
								<div class="level-right">
								<input type="submit" class="button is-success" value="Registrar cuenta">
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="columns is-centered">
			<div class="column is-12">
				<div class="card-plain">
					<div class="card-content">
						<table class="table is-fullwidth">
							<thead>
								<tr>
									<th>Identificador</th>
									<th>Medio</th>
									<th>Nro cuenta</th>
									<th>Estado</th>
									<th>Acción</th>
								</tr>								
							</thead>
							<tbody>
								@foreach($accounts as $account)
								<tr>
									<td>{{ $account->id }} {{ $account->apellido }}</td>
									<td>{{ $account->banco }}</td>
									<td>{{ $account->nro_cuenta }}</td>
									@if($account->estado == 1)
										<td>Pública</td>
									@else
										<td>Oculta</td>
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
													@if($account->estado == 1)
														<a href="{{ url('account/hide/'.$account->id) }}" class="dropdown-item">
															Ocultar
														</a>
													@else
														<a href="{{ url('account/show/'.$account->id) }}" class="dropdown-item">
															Publicar
														</a>
													@endif
													<a class="dropdown-item del" href="{{ url('account/delete/'.$account->id) }}">
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
	<br>
</section>
@endsection