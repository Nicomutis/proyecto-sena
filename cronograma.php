<?php
	require_once('funs.php'); // Incluye el archivo 'funs.php', que probablemente contiene funciones utilizadas en este script.
	session_start(); // Inicia una nueva sesión o reanuda una sesión existente.
	check_session(); // Llama a la función 'check_session' para verificar el estado de la sesión.

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

	// Llama a la función 'starter' para inicializar o configurar el entorno con la información del miembro.
	starter($id, $name, $role, $pic, $last_login, $total_members, $core_members, $total_sessions, $completed_sessions);
?>
	<div class="row">
		<ol class="breadcrumb"> <!-- Muestra una barra de navegación que indica la ubicación actual en el sitio web. -->
			<li><a href="home.php"><i class="fa fa-home" aria-hidden="true"></i></a></li> <!-- Enlace a la página principal. -->
			<li class="active">Horario y Sesiones</li> <!-- Indica la sección actual. -->
		</ol>
	</div><!--/.row-->

	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Horario y Sesiones</h1> <!-- Título de la página. -->
		</div>
	</div><!--/.row-->

	<?php 
	if($role == "President") // Verifica si el rol del usuario es "President".
	{
		echo '<div class="row">
				<div class="col-lg-12">
					<a style="color: #fff;" href="add_event.php"><h1 class="ribbon"><i class="fa fa-calendar-plus-o" aria-hidden="true"></i> <b>Añadir Evento / Sesión</b></strong> 
					</h1></a>
				</div>
			</div>'; // Muestra un enlace para añadir eventos o sesiones, visible solo para el presidente.
	}
	?>

	<div class="row">
		<?php show_events($role); ?> <!-- Llama a la función 'show_events' para mostrar los eventos basados en el rol del usuario. -->
	</div><!--/.row-->
<?php
	at_bottom(); // Llama a la función 'at_bottom' para completar el contenido de la página (probablemente incluye el pie de página).
?>
