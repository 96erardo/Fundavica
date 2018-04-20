@extends('layouts.compound')

@section('title', 'Artículos')

@section('header', 'FUNDAVICA')

@section('subtitle', 'Fundación vida y cámino para el autista en Guayana')

@section('options')
<li class="is-active"><a href="{{ url('posts/0') }}">Publicaciones</a></li>
<li><a href="{{ url('gallery') }}">Galeria</a></li>
<li><a href="{{ url('contact') }}">Contacto</a></li>
<li><a href="{{ url('donations') }}">Donaciones</a></li>
@endsection

@section('content')
<section class="background-is-soft">
	<div class="container">
		<br>
		<form action="{{ url('posts/index/search') }}" method="POST">
			{{ csrf_field() }}
			<div class="field has-addons">
				<div class="control is-expanded">
					<input id="busqueda" name="busqueda" type="text" class="input" placeholder="Busca la publicación que te interese" value="{{$search}}">
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
		<br>
		<div class="columns is-multiline">
			@foreach($posts as $post)
				<div class="column is-4">
					<div class="card-plain">
						<div class="card-image">
							<figure class="image is-2by1" style="background-image: url({{ $post->imagen }}); background-position: center !importante; background-size: cover;">
							</figure>
						</div>
						<div class="card-content">
							<p class="subtitle is-6"><a href="{{url('post/'. $post->id)}}">{{$post->titulo}}</a></p>
							<p style="color: #757575;"><small>Autor: {{$post->user->nombre}} {{$post->user->apellido}}</small></p>
							<p style="color: #757575;"><small>Fecha: {{$post->fecha}}</small></p>
						</div>
					</div>
				</div>
			@endforeach
		</div>
		<br>
	</div>
</section>
@endsection