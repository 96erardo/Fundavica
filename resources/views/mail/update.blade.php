<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Confirmación de Correo</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/app.css') }}">
</head>
<body>
<section class="background-is-soft">
    <div class="container">
        <div class="columns is-centered">
            <div class="column is-10">
                <div class="card-plain">
                    <div class="card-content">
                        <h3 class="title is-3">Confirmación de correo electrónico</h3>
                        <div class="content">
                            <h4 class="title is-4">Saludos {{$user->nombre}} {{$user->apellido}}</h4>
                            <p>
                                Para confirmar su cambio de correo electrónico en Fundavica, es necesario que
                                haga click <a href="{{ url('user/update/email/'.$email.'/'.$user->token) }}">aquí</a>
                            </p>
                            <br>
                            <p>
                                En caso de que usted no haya solicitado nada, por favor ignore este mensaje.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>