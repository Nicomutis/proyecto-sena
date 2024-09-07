<?php
	require_once('funs.php'); // Incluye el archivo 'funs.php', que contiene funciones necesarias para este script.
	session_start(); // Inicia una nueva sesión o reanuda una sesión existente.
	check_session(); // Verifica si la sesión del usuario es válida.

	$session_name = $_SESSION['username']; // Obtiene el nombre de usuario de la sesión actual.
	$row = array(); // Inicializa un array vacío.
	$row = get_member_data($session_name); // Obtiene los datos del miembro basado en el nombre de usuario.
	$id = $row['id']; // Asigna el ID del miembro.
	$name = $row['name']; // Asigna el nombre del miembro.
	$role = $row['role']; // Asigna el rol del miembro.
	$pic = $row['pic']; // Asigna la imagen de perfil del miembro.
	$last_login = $row['last_login']; // Asigna la fecha y hora del último inicio de sesión del miembro.
	$last_login = date('jS M Y H:i', strtotime($last_login)); // Formatea la fecha del último inicio de sesión a un formato legible.
	$total_members = get_all_status(); // Obtiene el estado de todos los miembros.
	$core_members = get_vip_status(); // Obtiene el estado de los miembros VIP.
	$total_sessions = total_sessions(); // Obtiene el total de sesiones.
	$completed_sessions = completed_sessions(); // Obtiene el número de sesiones completadas.

	// Inicializa la configuración de la página con la información del miembro.
	starter($id, $name, $role, $pic, $last_login, $total_members, $core_members, $total_sessions, $completed_sessions);

	// Verifica si el rol del usuario no es 'President'.
	if($role != 'President')
	{
		echo '<div class="text-center alert bg-warning col-md-offset-4 col-md-4"><p><b>Acceso Prohibido</b></p></div>'; 
		// Muestra un mensaje de alerta indicando "Acceso Prohibido".
		echo '<script>setTimeout(function () { window.location.href = "home.php";}, 1000);</script>';
		// Redirige al usuario a la página principal después de 1 segundo.
		exit(); // Termina la ejecución del script.
	}
?>
			
	<div class="row">
		<ol class="breadcrumb"> <!-- Muestra una barra de navegación que indica la ubicación actual en el sitio web. -->
			<li><a href="home.php"><i class="fa fa-home" aria-hidden="true"></i></a></li> <!-- Enlace a la página principal. -->
			<li><a href="cronograma.php">Horario y Sesiones</a></li> <!-- Enlace a la página de horario y sesiones. -->
			<li class="active">Agregar Nuevas Sesiones</li> <!-- Muestra "Agregar Nuevas Sesiones" como la página actual. -->
		</ol>
	</div><!--/.row-->

	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Agregar Nueva Sesión</h1> <!-- Título de la página para agregar una nueva sesión. -->
		</div>
	</div><!--/.row-->

	<div class="row">
		<div class="error">
			<?php add_event(); ?> <!-- Llama a la función 'add_event' que maneja la lógica para agregar un nuevo evento. -->
		</div>
		<div class="col-lg-offset-2 col-lg-6">
			<form class="form-signin" method="post" action=""> <!-- Formulario para agregar una nueva sesión. -->
				<label for="name">Título del Evento</label> 
				<input type="text" name="name" placeholder="máx. 150 caracteres" id="name" class="form-control" require><br>
				<!-- Campo de entrada para el título del evento. -->
				<label for="name">Descripción del Evento</label> 
				<textarea type="text" name="description" placeholder="Descripción máx. 250 caracteres" id="email" class="form-control" require></textarea><br>
				<!-- Campo de texto para la descripción del evento. -->
				<label for="name">Fecha del Evento</label> 
				<input type="text" data-field="datetime" placeholder="fecha" name="date" class="form-control" require>
				<div id="dtBox"></div><br>
				<!-- Campo para seleccionar la fecha y hora del evento. -->
				<button class="btn btn-primary" name="add_event" type="submit">Agregar</button> 
				<!-- Botón para enviar el formulario y agregar la nueva sesión. -->
				&nbsp;&nbsp;
				<a type="button" class="btn btn-default" href="cronograma.php" class="btn btn-default">Cancelar</a> 
				<!-- Botón para cancelar y volver a la página de horario y sesiones. -->
			</form>
		</div>
	</div><!--/.row-->
<?php
	at_bottom(); // Llama a la función 'at_bottom' para completar el contenido de la página (probablemente incluye el pie de página).
?>
