@extends('layouts.compound')

@section('title', 'Galería')

@section('header', 'FUNDAVICA')

@section('subtitle', 'Fundación vida y cámino para el autista en Guayana')

@section('options')
<li><a href="{{ url('posts/0') }}">Publicaciones</a></li>
<li class="is-active"><a href="{{ url('gallery') }}">Galeria</a></li>
<li><a href="{{ url('contact') }}">Contacto</a></li>
<li><a href="{{ url('donations') }}">Donaciones</a></li>
@endsection

@section('content')
<section class="background-is-white">
	<div class="container">
		<br>
		<div class="columns">
			<div class="column">
				<a class="button is-primary is-fullwidth" href="{{ url('post/1') }}">
					¿Quienes somos?
				</a>
			</div>
			<div class="column">
				<a class="button is-warning is-fullwidth" href="{{ url('post/4') }}">
					Objetivos
				</a>
			</div>
			<div class="column">
				<a class="button is-info is-fullwidth" href="{{ url('post/2') }}">
					Misión
				</a>
			</div>
			<div class="column">
				<a class="button is-danger is-fullwidth" href="{{ url('post/3') }}">
					Visión
				</a>
			</div>
		</div>
	</div>
	<br>
</section>
<section class="background-is-soft">
    <br>
    <div class="container">
        <div id="instafeed" class="columns is-multiline">

        </div>
    </div>
</section>
@endsection
