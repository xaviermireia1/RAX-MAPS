<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{!! asset('css/style.css') !!}">
    <script src="js/login.js"></script>
    <title>Login/Register</title>
</head>
<body>
    <div class="form">
        <ul class="tab-group">
            <li class="tab active"><a href="#signup">Registrarse</a></li>
            <li class="tab"><a href="#login">Log In</a></li>
        </ul>
        <div class="tab-content">
            <div id="signup">
                <h1>Registrate Gratis</h1>
                <form action="/" method="post">
                    <div class="top-row">
                        <div class="field-wrap">
                            <label>Nombre<span class="req">*</span></label>
                            <input type="text" required autocomplete="off" />
                        </div>
                        <div class="field-wrap">
                            <label>Apellidos<span class="req">*</span></label>
                            <input type="text"required autocomplete="off"/>
                        </div>
                    </div>
                    <div class="field-wrap">
                        <label>Correo<span class="req">*</span></label>
                        <input type="email"required autocomplete="off"/>
                    </div>
                    <div class="field-wrap">
                        <label>Contraseña<span class="req">*</span></label>
                        <input type="password"required autocomplete="off"/>
                    </div>
                    <button type="submit" class="button button-block"/>Empezar</button>
                </form>
            </div>
            <div id="login">
                <h1>Bienvenido de nuevo!</h1>
                <form action="/" method="post">
                    <div class="field-wrap">
                        <label>Correo<span class="req">*</span></label>
                        <input type="email"required autocomplete="off"/>
                    </div>
                    <div class="field-wrap">
                        <label>Contraseña<span class="req">*</span></label>
                        <input type="password"required autocomplete="off"/>
                    </div>
                    <p class="forgot"><a href="#">¿Has olvidado tu contraseña?</a></p>
                    <button class="button button-block"/>Iniciar Sesion</button>
                </form>
            </div>
        </div><!-- tab-content -->
    </div> <!-- /form -->
</body>
</html>