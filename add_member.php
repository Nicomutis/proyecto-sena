<?php
	require_once('funs.php'); // Incluye el archivo 'funs.php', que contiene funciones necesarias para este script.
	session_start(); // Inicia una nueva sesión o reanuda una sesión existente.
	check_session(); // Verifica si la sesión es válida.

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
			<li><a href="gestion_miembros.php">Miembros</a></li> <!-- Enlace a la página de gestión de miembros. -->
			<li class="active">Agregar Nuevo Miembro</li> <!-- Muestra "Agregar Nuevo Miembro" como la página actual. -->
		</ol>
	</div><!--/.row-->

	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Agregar Nuevo Miembro</h1> <!-- Título de la página para agregar un nuevo miembro. -->
		</div>
	</div><!--/.row-->

	<div class="row">
		<div class="error">
			<?php add_member($role); ?> <!-- Llama a la función 'add_member' que maneja la lógica para agregar un nuevo miembro. -->
		</div>
		<div class="col-lg-offset-2 col-lg-6">
			<form class="form-signin" method="post" action=""> <!-- Formulario para agregar un nuevo miembro. -->
				<label for="name">Nombre</label> 
				<input type="text" name="name" placeholder="Nombre" id="name" class="form-control" require><br>
				<!-- Campo de entrada para el nombre del nuevo miembro. -->
				<label for="name">Correo Electrónico</label> 
				<input type="email" name="email" placeholder="Correo Electrónico" id="email" class="form-control" require><br>
				<!-- Campo de entrada para el correo electrónico del nuevo miembro. -->
				<label for="name">Nombre de Usuario</label> 
				<input type="text" name="username" placeholder="nombre de usuario" id="username" class="form-control"><br>
				<!-- Campo de entrada para el nombre de usuario del nuevo miembro. -->
				<label for="name">Contraseña</label> 
				<input type="password" name="password" placeholder="contraseña" id="password" class="form-control"><br><br>
				<!-- Campo de entrada para la contraseña del nuevo miembro. -->
				<?php if($role == 'President')
				{
					echo '<label for="name">Rol</label> 
					<select class="form-control" name="role">
						<option>SELECCIONAR</option> 
    					<option name="Member" value="Member">Miembro</option> 
						<option name="Media-Marketing" value="Media Marketing">Medios y Marketing</option> 
						<option name="Admin Logistics" value="Admin Logistics">Logística Administrativa</option> 
						<option name="Member Management" value="Member Management">Gestión de Miembros</option> 
						<option name="Technical" value="Technical">Técnico</option> 
						<option name="President" value="President">Presidente</option> 
					</select><br>';
				} ?>
				<!-- Si el rol del usuario es 'President', muestra un menú desplegable para seleccionar el rol del nuevo miembro. -->
				<button class="btn btn-primary" name="add_member" type="submit" id="login">Agregar</button> 
				<!-- Botón para enviar el formulario y agregar el nuevo miembro. -->
				&nbsp;&nbsp;
				<a href="gestion_miembros.php" class="btn btn-default" id="login">Cancelar</a> 
				<!-- Botón para cancelar y volver a la página de gestión de miembros. -->
			</form>
		</div>
	</div><!--/.row-->
	<script>
	$(document).ready(function()
	{
		 $("#dtBox").DateTimePicker();
	});
	</script>
	<!-- Código para inicializar el selector de fecha y hora cuando el documento esté listo. -->
	<link rel="stylesheet" type="text/css" href="css/DateTimePicker.min.css" />
	<!-- Incluye el archivo CSS para el selector de fecha y hora. -->
	<script type="text/javascript" src="js/DateTimePicker.min.js"></script>
	<!-- Incluye el archivo JavaScript para el selector de fecha y hora. -->
<?php
	at_bottom(); // Llama a la función 'at_bottom' para completar el contenido de la página (probablemente incluye el pie de página).
?>
