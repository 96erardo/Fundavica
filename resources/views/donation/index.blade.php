@extends('layouts.compound')

@section('title', 'Donaciones')

@section('header', 'FUNDAVICA')

@section('subtitle', 'Fundación vida y cámino para el autista en Guayana')

@section('options')
<li><a href="{{ url('/posts/0') }}">Publicaciones</a></li>
<li><a href="{{ url('/gallery') }}">Galeria</a></li>
<li><a href="{{ url('/contact') }}">Contacto</a></li>
<li class="is-active"><a href="{{ url('/donations') }}">Donaciones</a></li>
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
		@include('partials.message')
			<div class="columns">
				<div class="column is-12-tablet is-hidden-mobile">
					<div class="card-plain">
						<div class="card-content">
							<p class="title is-2">!Muchas Gracias!</p>
							<h5 class="subtitle is-5">
								Queremos dar las gracias toda estas personas que nos han ayudado economicamente a mantener y mejorar el servicio que prestamos en esta fundación a la comunidad.
							</h5>
							<table class="tabla table is-fullwidth is-hoverable is-striped">
								<thead>
									<tr>
										<th><abbr>Nombre</abbr></th>
										<th><abbr>Cédula</abbr></th>
										<th><abbr>Fecha</abbr></th>
									</tr>									
								</thead>
								<tbody>
									@foreach($donations as $donation)
										<tr>
											<td>{{$donation->nombre}} {{$donation->apellido}}</td>
											<td>{{$donation->cedula}}</td>
											<td>{{$donation->fecha}}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>						
				</div>
			</div>
			<div class="columns">
				<div class="column is-7">
					<div class="card-plain">
						<div class="card-content">
							<p class="title is-3">Apóyanos.</p>
							<article class="message is-success">
								<div class="message-header">
									<p>Información</p>
								</div>
								<div class="message-body">
									Si ya hiciste una donación, puedes registrarla aquí y luego de que la verifiquemos, te agradeceremos publicamente tu ayuda aquí, en nuestra página web 🔺.
								</div>
							</article>
							<form method="POST" action="{{ url('donations') }}">					
								{{ csrf_field() }}	
								<div class="columns">
									<div class="column is-6">
										<div class="field">
											<label class="label">Nombre</label>
											<div class="control">
												<input class="input" type="name" name="nombre" required>
											</div>
										</div>
									</div>
									<div class="column is-6">
										<div class="field">
											<label class="label">Apellido</label>
											<div class="control">
												<input class="input" type="apellido" name="apellido" required>
											</div>
										</div>
									</div>
								</div>
								<div class="columns">
									<div class="column is-6">
										<div class="field">
											<label class="label">Cédula</label>
											<div class="control">
												<input class="input" type="number" name="cedula" required>
											</div>
										</div>
									</div>
									<div class="column is-6">
										<div class="field">
											<label class="label">Correo electrónico</label>
											<div class="control">
												<input class="input" type="email" name="correo" required>
											</div>
										</div>
									</div>
								</div>
								<div class="columns">
									<div class="column is-6">
										<div class="field">
											<label class="label">Medio</label>
											<div class="control is-expanded">
												<div class="select is-fullwidth">
													<select name="medio">
														<option>Banco de Venezuela</option>
														<option>Banco Banesco</option>
														<option>Banco Provincial</option>
														<option>Paypal</option>
													</select>
												</div>												
											</div>
										</div>
									</div>
									<div class="column is-6">
										<div class="field">
											<label class="label">Operación</label>
											<div class="control is-expanded">
												<div class="select is-fullwidth">
													<select name="operacion">
														<option>Deposito</option>
														<option>Transferencia</option>
													</select>
												</div>												
											</div>
										</div>
									</div>
								</div>
								<div class="columns">
									<div class="column is-6">
										<label class="label">Monto</label>
										<div class="field has-addons">						
											<p class="control">
												<input class="input" type="number" name="monto" required>
											</p>
											<p class="control">
												<span class="select">
													<select name="moneda">
														<option>Bsf</option>
														<option>$</option>
													</select>
												</span>												
											</p>											
										</div>
									</div>
									<div class="column is-6">
										<div class="field">
											<label class="label">Código de operación</label>
											<div class="control">
												<input class="input" type="text" name="codigo" placeholder="Si no tiene, deje el campo vacío">
											</div>
										</div>
									</div>
								</div>
								<div class="columns">
									<div class="column is-6">
										<label class="label">Fecha</label>
										<div class="field">								
											<div class="control">
												<input class="input" type="date" name="fecha" required>
											</div>											
										</div>
									</div>
								</div>
								<div class="level">
									<div class="level-left"></div>
									<div class="level-right">
										<input class="item button is-success" type="submit" value="Registrar donación">
									</div>
								</div>
							</form>
						</div>
					</div>					
				</div>
				<div class="column is-5">
					<div class="card-plain">
						<div class="card-content">
							<div class="columns">
								<div class="column is-12 has-text-centered">
									<p class="subtitle is-5">
										Puedes transferirnos a nuestro paypal
									</p>
									<div class="level">
										<div class="level-item"></div>
										<div class="level-item"></div>
										<div class="level-item has-text-centered">
											<a target="_blank" href="https://www.paypal.me/fundavica">
												<img class="image is-128x128 has" src="http://www.underconsideration.com/brandnew/archives/paypal_2014_logo_detail.png">
												<br>
											</a>
										</div>
										<div class="level-item"></div>
										<div class="level-item"></div>
									</div>
								</div>
							</div>
							<div class="columns">
								<div class="column is-12">
									<article class="message is-success">
										<div class="message-header">
											<p>Bancos</p>
										</div>
										<div class="message-body">
											<ul>
												@foreach($accounts as $account)
													<li>{{$account->banco}}: {{$account->nro_cuenta}}</li>
												@endforeach
											</ul>
										</div>
									</article>
								</div>									
							</div>
						</div>
					</div>
				</div>
			</div>
	</div>
</section>
@endsection

@section('script')
<script type="text/javascript" src="{{ URL::asset('js/donations.js') }}"></script>
@endsection