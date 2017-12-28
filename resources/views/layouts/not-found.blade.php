<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Fundavica | 404</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/style-bm.css') }}">
	
</head>
<body>
	<section class="hero is-danger is-fullheight">
		<div class="hero-body">
			<div class="container has-text-centered">
				<h1 class="title">
					<a href="{{ url('/') }}">
						<img src="{{URL::asset('img/cut logo.png')}}">
					</a>
					<br><br>
					@yield('title')
				</h1>
			</div>
		</div>
	</section>
</body>
</html>