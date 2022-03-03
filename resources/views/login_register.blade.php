<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login/Register</title>
</head>
<body>
    <div>
        <form action="{{url('login/user')}}">
            <label for="">Nickname/Email</label>
            <input type="text" name="nick_email" id="nick_email">
            <label for="">Contraseña</label>
            <input type="password" name="password" id="password">
        </form>
    </div>
    <div>
        <form action="{{url('register/user')}}">
            <label for="">Email</label>
            <input type="email" name="email" id="">
            <label for="">Nickname</label>
            <input type="text" name="nick" id="nick">
            <label for="">Contraseña</label>
            <input type="password" name="password" id="password">
            <label for="">Repetir contraseña</label>
            <input type="password" name="password2" id="password2">
            <input type="submit" value="Registrarme">
        </form>
    </div>
</body>
</html>