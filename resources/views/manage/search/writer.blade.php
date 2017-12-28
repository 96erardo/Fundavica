@extends('layouts.compound')

@section('title', 'Administrar')

@section('header', 'Publicaciones')

@section('subtitle', 'Crea, edita y administra las publicaciones a tu gusto')

@section('options')
<li class="is-active"><a href="{{ url('post/manage/writer/0') }}">Publicaciones</a></li>
@endsection

@section('content')
<section class="background-is-soft">
	<div class="container">
		<br>
		<div class="columns">
			<div class="column is-12">
				<form method="POST" action="{{ url('post/manage/search') }}">
					{{ csrf_field() }}
					<div class="field has-addons">
						<div class="control is-expanded">
							<input id="search" name="busqueda" type="text" class="input" value="{{ $search }}" placeholder="Busca la publicación que te interese">
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
	<div class="container">
		<br>
		<div class="columns">
			<div class="column is-12">
				<a href="{{ url('post/new') }}" class="button is-success">📰 Crear nuevo artículo</a>
			</div>
		</div>
		<div class="columns is-centered">
			<div class="column is-12">
				<div class="box">
					<table class="table is-fullwidth">
						<thead>
							<tr>
								<th>Título</th>
								<th>Redactor</th>
								<th>Usuario</th>
								<th>Fecha</th>
								<th>Estado</th>
								<th>Acción</th>
							</tr>								
						</thead>
						<tbody>
							@foreach($posts as $post)
							<tr>
								<td><a href="{{ url('post/'.$post->id) }}">{{ $post->titulo }}</a></td>
								<td>{{ $post->user->nombre }} {{ $post->user->apellido }}</td>
								<td>{{ $post->user->usuario }}</td>
								<td>{{ $post->fecha }}</td>
								@if($post->estado == 1)
									<td>Público</td>
								@else
									<td>Oculto</td>
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
												<a class="dropdown-item" href="{{ url('post/'.$post->id) }}" target="_blank">
													Ver
												</a>
												@if($post->user->usuario == Auth::user()->usuario)
													<a class="dropdown-item" href="{{ url('post/edit/'.$post->id) }}">
														Editar
													</a>
												@endif
												@if($post->estado == 1)
												<a class="dropdown-item" href="{{ url('post/hide/'.$post->id)}}">
													Ocultar
												</a>
												@else
												<a class="dropdown-item" href="{{ url('post/show/'.$post->id) }}">
													Publicar
												</a>
												@endif
												@if(Auth::user()->tipo == 1 && $post->id > 4)
												<a class="dropdown-item del" href="{{ url('post/delete/'.$post->id) }}">
													Eliminar
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
</section>
@endsection

