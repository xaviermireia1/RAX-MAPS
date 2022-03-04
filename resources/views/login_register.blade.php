<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{!! asset('css/style.css') !!}">
    <link rel="stylesheet" href="{!! asset('css/mainstyle.css') !!}">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="js/login.js"></script>
    <title>Login/Register</title>
</head>
<body class="page-login">
    <div class="content-login">
        <div class="form">
            <ul class="tab-group">
                <li class="tab active"><a href="#signup" class="toggle-login">Registrarse</a></li>
                <li class="tab"><a href="#login" class="toggle-login">Log In</a></li>
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
    </div>
</body>
</html>