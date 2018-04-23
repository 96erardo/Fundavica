@extends('layouts.simple')

@section('title', $pub->titulo)

@section('body', 'class=background')

@section('content')
<section class="background-is-light">
	<br>
	<div class="container">
		@include('partials.message')
		<div class="columns">
			<div class="column is-8">
				<div class="card-plain">
					<div class="card-image post-title" style="background:linear-gradient(rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.5)), url({{$pub->imagen}}) center/cover no-repeat scroll">
						<div class="title-content">
							<h3 class="title is-3" style="color: #fff; margin: 0px;">{{$pub->titulo}}</h3>
							<div class="title-info">
								<p style="color: rgba(255, 255, 255, 0.6);">
									<small>Autor: {{$pub->user->nombre}} {{$pub->user->apellido}}</small>
								</p>
								<p style="color: rgba(255, 255, 255, 0.6);">
									<small>Fecha: {{$pub->fecha}}</small>
								</p>
							</div>
						</div>
					</div>
					<div class="card-content">
						<div class="content">
							{!! $pub->contenido !!}
						</div>
					</div>
				</div>
			</div>
			@if(Auth::check())
				@if(Auth::user()->isAdmin())
					<div class="column is-4">
						<div class="card-plain">
							<div class="card-content">
								<h2 class="subtitle is-2">Historial</h2>
								<table class="table is-striped is-fullwidth">
									<thead></thead>
									<tbody>
										@foreach($history as $op)
											<tr>
												<td style="color: #209CEE">{{ $op->user->usuario}}</td>
												<td style="color: #FF3860" class="has-text-centered">{{ $op->operation->nombre_visible }}</td>
												<td>{{ $op->created_at }}</td>
											</tr>
										@endforeach
										<tr>
											<td style="color: #209CEE"> {{ $pub->user->usuario }}</td>
											<td style="color: #FF3860" class="has-text-centered">CREADO</td>
											<td>{{ $pub->fecha }}</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				@endif
			@endif
		</div>
	</div>
</section>
<section class="background-is-soft">
	<div class="container">
		<br>
		<div class="columns">
			<div class="column is-8">
				<div class="card-plain">
					<div class="card-image">
						<div class="hero is-info">
							<div class="hero-body">
								<div class="has-text-centered">
									<h3 class="title">
										Comentarios
									</h3>
								</div>
							</div>
						</div>
						@if(count($pub->comments) == 0)
							<section class="background-is-light">
								<div class="has-text-centered">
									<br><br>
									<h3 class="subtitle is-3">
										Nadie ha comentado aún, se el primero.
									</h3>
									<br><br>
								</div>
							</section>
						@endif
					</div>
					@if(Auth::check())
						<div class="card-content">
							<form method="POST" action="{{ url('comment/new/'.$pub->id) }}">
								{{ csrf_field() }}
								<textarea id="contenido" name="contenido" class="textarea" placeholder="Danos tu opinión."></textarea>
								<br>
								<div class="level">
									<div class="level-left"></div>
									<div class="level-right">
										<button type="submit" class="button is-primary">
											<span class="icon">
												<i class="fa fa-commenting-o" aria-hidden="true"></i>
											</span>
											<span>Comentar</span>
										</button>
									</div>
								</div>
							</form>
							<hr>
						</div>
					@endif
					@if(count($pub->comments) > 0)
						<div class="card-content">
							@foreach($pub->comments as $commentary)
								@if($commentary->isPublic())
									<div class="commentary"> 
										<article class="media is-principal" data-identifier="{{ $commentary->id }}">
											<div class="media-content">
												<p>
													<strong>{{$commentary->user->nombre}} {{$commentary->user->apellido}}</strong> <small>{{$commentary->user->usuario}}</small> <span>{{$commentary->fecha}}</span>
													<br>
													<span class="comment-content">
														{{$commentary->contenido}}
													</span>
												</p>
												<div class="level is-mobile">
													<div class="level-left">
														@if(Auth::check())
															@if(Auth::user()->isAdmin())
																<a class="level-item" href="{{ url('comment/hide/'.$pub->id.'/'.$commentary->id) }}">
																	<i class="fa fa-eye" aria-hidden="true"></i>
																</a>
																<a class="level-item del" href="{{url('comment/delete/'.$pub->id.'/'.$commentary->id)}}">
																	<i class="fa fa-eraser" aria-hidden="true"></i>
																</a>
															@endif
															@if(Auth::user()->id == $commentary->usuario_id)
																<a class="level-item edt" href="{{ url('comment/edit/'.$pub->id.'/'.$commentary->id) }}">
																	<i class="fa fa-pencil" aria-hidden="true"></i>
																</a>
																<a class="level-item del" href="{{url('comment/delete/'.$pub->id.'/'.$commentary->id)}}">
																	<i class="fa fa-eraser" aria-hidden="true"></i>
																</a>
															@endif												
														@endif
													</div>
													@if(Auth::check())
														<div class="level-right">
															<a class="level-item response" href="{{ url('comment/new/'.$pub->id.'/'.$commentary->id) }}">
																Responder
															</a>
														</div>
													@endif
												</div>
											</div>
										</article>
										@foreach($commentary->responses as $response)
											<div class="columns">
												<div class="column is-11 is-offset-1">
													<article class="media is-response" data-identifier="{{ $response->id }}">
														<div class="media-content">
															<div class="content">
																<p>
																	<strong>{{$response->user->nombre}} {{$response->user->apellido}}</strong> <small>{{$response->user->usuario}}</small> <span>{{$response->fecha}}</span>
																	<br>
																	<span class="comment-content">{{ $response->contenido }}<span>
																</p>
																<div class="level is-mobile">
																	<div class="level-left">
																		@if(Auth::check())
																			@if(Auth::user()->isAdmin())
																				<a class="level-item" href="{{ url('comment/hide/'.$pub->id.'/'.$response->id) }}">
																					<i class="fa fa-eye" aria-hidden="true"></i>
																				</a>
																				<a class="level-item del" href="{{url('comment/delete/'.$pub->id.'/'.$response->id)}}">
																					<i class="fa fa-eraser" aria-hidden="true"></i>
																				</a>
																			@endif
																			@if(Auth::user()->id == $response->usuario_id)
																				<a class="level-item edt" href="{{ url('comment/edit/'.$pub->id.'/'.$response->id) }}">
																					<i class="fa fa-pencil" aria-hidden="true"></i>
																				</a>
																				<a class="level-item del" href="{{url('comment/delete/'.$pub->id.'/'.$response->id)}}">
																					<i class="fa fa-eraser" aria-hidden="true"></i>
																				</a>
																			@endif												
																		@endif
																	</div>
																</div>
															</div>
														</div>
													</article>
												</div>
											</div>
										@endforeach
									</div>
								@elseif(Auth::check())
									@if(Auth::user()->isAdmin())
										<article class="media">
											<div class="media-content">
												<div class="content">
													<p>
														<strong>{{$commentary->user->nombre}} {{$commentary->user->apellido}}</strong> <small>{{$commentary->user->usuario}} {{$commentary->fecha}}</small>
														<br>
														{{$commentary->contenido}}
													</p>
													@if(Auth::check())
														<div class="level is-mobile">
															<div class="level-left">
																@if(Auth::user()->isAdmin())
																<a class="level-item" href="{{ url('comment/show/'.$pub->id.'/'.$commentary->id) }}">
																	<i class="fa fa-eye" aria-hidden="true"></i>
																</a>
																<a class="level-item del" href="{{url('comment/delete/'.$pub->id.'/'.$commentary->id)}}">
																	<i class="fa fa-eraser" aria-hidden="true"></i>
																</a>
																@endif
																@if(Auth::user()->id == $commentary->usuario_id)
																	<a class="level-item edt">
																		<i class="fa fa-pencil" aria-hidden="true"></i>
																	</a>
																	<a class="level-item del" href="{{url('comment/delete/'.$pub->id.'/'.$commentary->id)}}">
																		<i class="fa fa-eraser" aria-hidden="true"></i>
																	</a>
																@endif												
															</div>
														</div>
													@endif
												</div>
											</div>
											@if(Auth::check())
												@if(Auth::user()->isAdmin() && $commentary->estado == 0)
													<div class="media-right">
														<span class="tag is-warning">
															<i class="fa fa-exclamation" aria-hidden="true"></i>
															Comentario Oculto
														</span>
													</div>
												@endif
											@endif
										</article>
										@if(Auth::check())
											@if(Auth::user()->id == $commentary->usuario_id)
												<div class="comment" style="display:none;">
													<form method="POST" action="{{ url('comment/edit/'.$pub->id.'/'.$commentary->id) }}">
														{{ csrf_field() }}
														<textarea class="textarea" name="comentario">{{ $commentary->contenido }}</textarea>
														<br>
														<div class="level">
															<div class="level-left"></div>
															<div class="level-right">
																<button class="button is-primary level-item">
																	<span>Editar Comentario</span>
																	<span class="icon">
																		<i class="fa fa-commenting-o" aria-hidden="true"></i>
																	</span>
																</button>
																<button class="button is-danger level-item cnl">
																	<span>Cancelar</span>
																	<span class="icon">
																		<i class="fa fa-ban" aria-hidden="true"></i>
																	</span>
																</button>
															</div>
														</div>
													</form>
													<hr>
												</div>
											@endif
										@endif
									@endif
								@endif
								<br>
							@endforeach
						</div>
					@endif
				</div>
			</div>
		</div>
	</div>
	<br><br>
</section>
@endsection

@section('script')
<script src="{{ asset('js/components/post/read.js') }}"></script>
@endsection
