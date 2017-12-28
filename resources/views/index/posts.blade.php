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
<section class="background-is-white">
	<div class="container">
		<br>
		@include('partials.message')
		<div class="columns">
			<div class="column">
				<a class="button is-primary is-fullwidth" href=" {{ url('post/1') }}">
					¿Quienes somos?
				</a>
			</div>
			<div class="column">
				<a class="button is-warning is-fullwidth" href=" {{ url('post/4') }}">
					Objetivos
				</a>
			</div>
			<div class="column">
				<a class="button is-info is-fullwidth" href=" {{ url('post/2') }}">
					Misión
				</a>
			</div>
			<div class="column">
				<a class="button is-danger is-fullwidth" href=" {{ url('post/3') }}">
					Visión
				</a>
			</div>
		</div>
		<br>
	</div>
</section>
<section class="background-is-soft">
	<div class="container">
		<br>
		<form method="POST" action="{{ action('FundavicaController@search') }}">
			{{ csrf_field() }}
			<div class="field has-addons">
                <div class="control is-expanded">
                  	<input id="busqueda" name="busqueda" type="text" class="input" placeholder="Busca la publicación que te interese">
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
		<div class="level">
            <div class="level-left"></div>
            <div class="level-right">
				<a href="{{ url('posts/'.($page-1)) }}" class="button is-primary is-outlined level-item" {{ $page > 0 ? '': 'disabled' }}>Anterior</a>
				<a href="{{ url('posts/'.$page) }}" class="button is-primary is-outlined level-item" {{ ($page+1) == $pages ? 'disabled':'' }}>Siguiente</a>
            </div>
        </div>
	</div>
	<br>
</section>
@endsection