@extends('layouts.compound')

@section('title', 'Contacto')

@section('header', 'FUNDAVICA')

@section('subtitle', 'Fundación vida y cámino para el autista en Guayana')

@section('options')
<li><a href="{{ url('posts/0') }}">Publicaciones</a></li>
<li><a href="{{ url('gallery') }}">Galeria</a></li>
<li class="is-active"><a href="{{ url('contact') }}">Contacto</a></li>
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
	<div class="container">
		<br>
		<div class="columns">
            <div class="column is-6">
                <a class="button is-fullwidth" style="background-color:#3b5998; color: #fff">
                    <span class="icon is-large">
                        <i class="fa fa-facebook-official" aria-hidden="true"></i>
                    </span>
                    <span>Facebook</span>
                </a>
            </div>
            <div class="column is-6">
                <a class="button is-fullwidth" style="background-color:#cd486b; color: #fff">
                    <span class="icon is-large">
                        <i class="fa fa-instagram" aria-hidden="true"></i>
                    </span>
                    <span>Instagram</span>                        
                </a>
            </div>
        </div>
        <div class="columns">
            <div class="column is-6">
                <a class="button is-fullwidth" style="background-color:#1dcaff; color: #fff">
                    <span class="icon is-large">
                        <i class="fa fa-twitter" aria-hidden="true"></i>
                    </span>
                    <span>Twitter</span>
                </a>
            </div>
            <div class="column is-6">
                <a class="button is-fullwidth" style="background-color:#25D366; color: #fff">
                    <span class="icon is-large">
                        <i class="fa fa-whatsapp" aria-hidden="true"></i>
                    </span>
                    <span>Whatsapp</span>
                </a>
            </div>
        </div>
		@include('partials.message')
		<div class="columns is-tablet">
			<div class="column is-12">
				<div class="card-plain">
					<div class="card-content">
						<h2 class="title is-2">Escríbenos</h2>
						<h5 class="subtitle is-5">En Fundavica tomamos en cuenta tus sugerencias y opiniones.</h5>
						<form action="{{ url('contact') }}" method="POST">
							{{ csrf_field() }}
							<div class="field">
								<textarea type="text" name="mensaje" class="textarea {{$errors->has('mensaje') ? 'is-danger':''}}" placeholder="Danos tu opinión" rows="10"></textarea>
								@if($errors->has('mensaje'))
									<p class="help is-danger">
										{{ $errors->first('mensaje') }}
									</p>
								@endif
							</div>
							<div class="columns">
								<div class="column is-9"></div>
								<div class="column is-3">
									<button class="button is-primary is-fullwidth" type="submit">Enviar</button>
								</div>
							</div>						
						</form>
					</div>
				</div>					
			</div>
		</div>
	</div>
</section>
@endsection