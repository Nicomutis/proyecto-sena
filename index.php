<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"> <!-- Define el conjunto de caracteres utilizado en la página -->
<meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Asegura que la página sea responsiva en dispositivos móviles -->
<title>SyncCircle</title> <!-- Título de la página que se muestra en la pestaña del navegador -->
<link rel='shortcut icon' href='favicon.ico' type='image/x-icon'/ > <!-- Icono que aparece en la pestaña del navegador -->
<link href="css/pace-theme-corner-indicator.css" rel="stylesheet"> <!-- Estilo para la animación de carga de la página -->
<script src="js/pace.min.js"></script> <!-- Script para la animación de carga de la página -->
<script>pace.start();</script> <!-- Inicia la animación de carga cuando la página comienza a cargarse -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> <!-- Estilo de Bootstrap para el diseño y los componentes -->
<link href="css/styles.css" rel="stylesheet"> <!-- Estilo personalizado para la página -->
</head>

<?php
	session_start(); // Inicia la sesión del usuario
	require_once('funs.php'); // Incluye funciones necesarias desde 'funs.php'
	
	// Verifica si el usuario ya ha iniciado sesión y, si es así, redirige a la página de inicio 'home.php'
	if( isset($_SESSION["username"]) )
	{
    	header("location:home.php");
    	exit(); // Detiene la ejecución del script después de la redirección
	}
?>

<body style="overflow: hidden;background-color: #eee;"> <!-- Establece el estilo del fondo de la página y oculta el desbordamiento -->

	<div class="row"> <!-- Contenedor para el contenido de la página -->
		<h1 class="text-center" style="padding-top:25px;color: #000;font-weight: bold;font-size: 3.0em;">SyncCircle <small>(Proyecto Sena)</small></h1><br> <!-- Título de la página con estilo personalizado -->
		<div class="error"><?php login(); ?></div> <!-- Muestra mensajes de error relacionados con el inicio de sesión -->
		<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4"> <!-- Contenedor para centrar el formulario de inicio de sesión -->
			<div class="login-panel panel panel-default"> <!-- Panel que contiene el formulario de inicio de sesión -->
				<div class="panel-heading">Iniciar sesión</div> <!-- Encabezado del panel -->
				<div class="panel-body"> <!-- Cuerpo del panel -->
					<form class="" method="post" action=""> <!-- Formulario de inicio de sesión -->
						<fieldset> <!-- Agrupa los controles del formulario -->
							<div class="form-group"> <!-- Contenedor para el campo de entrada del nombre de usuario -->
								<input class="form-control input-lg" placeholder="Usuario" name="username" type="text" autofocus="" required> <!-- Campo para ingresar el nombre de usuario -->
							</div>
							<div class="form-group"> <!-- Contenedor para el campo de entrada de la contraseña -->
								<input class="form-control input-lg" placeholder="Contraseña" name="password" type="password" required> <!-- Campo para ingresar la contraseña -->
							</div>
							<div class="checkbox"> <!-- Contenedor para la opción de recordar al usuario -->
								<label>
									<input name="remember" type="checkbox" value="Remember Me">Recordarme 
								</label>
							</div>
							<button class="btn btn-primary btn-lg" name="submit" type="submit" id="login">Iniciar sesión</button> <!-- Botón para enviar el formulario -->
						</fieldset>
					</form>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->	
	<div class="text-center" style="margin-top: 75px; color: #000;"><b>Hecho con <i style="color: red;">&#10084;</i> Por <a href="https://github.com/Nicomutis/proyecto-sena" target="blank">Nicolas Mutis</a> 2024</b></div> <!-- Mensaje de agradecimiento con un enlace al perfil de GitHub -->
</body>
</html>
