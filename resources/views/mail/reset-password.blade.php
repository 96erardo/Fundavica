<!DOCTYPE html>
<html>
<head>
    <title>Restaurar Contraseña</title>
</head>
<body>
    <h1>Saludos {{$user->nombre}} {{$user->apellido}}</h1>
    <p>
        Puede llevar a cabo el cambio de contraseña que solicitó haciendo click <a href='{{url("user/update/password/{$token}")}}'>aquí</a>    
    </p>
</body>
</html>