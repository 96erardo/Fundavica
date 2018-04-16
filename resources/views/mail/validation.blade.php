<!DOCTYPE html>
<html>
<head>
    <title>Confirmación de Email</title>
</head>
<body>
    <h1>Gracias por unirse a Fundavica, ¡Bienvenido!</h1>
    <p>
        Necesitamos que confirmes tu email para habilitar tu cuenta, haz click 
        <a href='{{url("register/confirm/{$user->verifyme_token}")}}'>aquí</a>    
    </p>
</body>
</html>