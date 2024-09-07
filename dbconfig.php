<?php

	global $con; // Declara la variable $con como global para poder usarla en otros archivos

	$hostname = 'localhost'; 	// Nombre del host (generalmente 'localhost' para una base de datos en el mismo servidor)
	
	$user = 'root'; 			// Nombre de usuario para acceder a la base de datos (en este caso, 'root')
	
	$password = ''; 			// Contraseña para acceder a la base de datos (en este caso, está vacía)
	
	$dbname = 'sync_blog'; 		// Nombre de la base de datos a la que se conectará (en este caso, 'sync_blog')
			
	$con = new mysqli($hostname, $user, $password, $dbname); // Crea una nueva conexión a la base de datos MySQL usando los parámetros proporcionados

	// Verifica si hay un error al conectar con la base de datos
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error(); // Muestra el mensaje de error si la conexión falla
		die(); // Detiene la ejecución del script
	}
