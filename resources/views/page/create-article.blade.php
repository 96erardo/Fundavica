@extends('layouts.simple')

@section('title', 'Nuevo articulo')

@section('script')
<script src='https://cloud.tinymce.com/stable/tinymce.min.js'></script>
@endsection

@section('content')
<section class="background-is-light">
	<div class="container">
		<br><br>
		<div class="columns">
			<div class="column is-11 is-tablet-centered">		
				<div class="card-plain">
					<div class="card-image">
						<section class="hero is-warning">
							<div class="hero-body has-text-centered">
								<h2 class="title is-2">Nuevo Artículo <i class="fa fa-newspaper-o" aria-hidden="true"></i></h2>
							</div>
						</section>
					</div>
					<div class="card-content">
						<form id="form" method="POST" action="{{url('post/new')}}">
							{{ csrf_field() }}
							<div class="columns">
								<div class="column is-6">
									<div class="field">
										<label class="label">Título</label>
										<div class="control">
											<input class="input {{$errors->has('titulo') ? 'is-danger' : ''}}" type="text" name="titulo" id="titulo" required>
										</div>
										@if($errors->has('titulo'))
											<p class="help is-danger">
												{{ $errors->first('titulo') }}
											</p>
										@endif
									</div>		
								</div>
								<div class="column is-6">
									<div class="field">
										<label class="label">Imagen</label>
										<div class="control">
											<input class="input {{$errors->has('imagen') ? 'is-danger' : ''}}" type="text" name="imagen" required>
										</div>
										@if($errors->has('imagen'))
											<p class="help is-danger">
												{{ $errors->first('imagen') }}
											</p>
										@endif
									</div>		
								</div>
							</div>
							<div class="columns">
								<div class="column is-6">
									<div class="field">
										<label class="label">Categoría</label>
										<div class="control is-expanded">
											<div class="select is-fullwidth">
												<select name="categoria">
													@foreach($categories as $category)
														<option value="{{$category->id}}">{{$category->nombre}}</option>
													@endforeach
												</select>
											</div>
										</div>
									</div>		
								</div>
							</div>
							<div class="columns">
								<div class="column is-12">
									<div class="field">
										<textarea id="tinymce" name="contenido" class="textarea" required></textarea>
									</div>
								</div>
							</div>
							@if($errors->has('contenido'))
								<p class="help is-danger">
									{{ $errors->first('contenido') }}
								</p>
							@endif
							<div class="level">
								<div class="level-left">
								</div>
								<div class="level-right">
									<input type="submit" class="button is-success level-item" value="Aceptar">
									<a href="{{url('post/manage/0')}}" class="button is-danger level-item">Cancelar</a>
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
