<?php

	global $con;

	$hostname = 'localhost'; 	// Host name
	
	$user = 'root'; 			// Username DB
	
	$password = ''; 			// Contraseña
	
	$dbname = 'db'; 			// Nombre base de datos
			
	$con = new mysqli($hostname,$user,$password,$dbname);
	if (mysqli_connect_errno())
		{
	  		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	  		die();
	  	}