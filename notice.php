<?php
	// Incluye el archivo que contiene las funciones necesarias para esta página
	require_once('funs.php');
	
	// Inicia la sesión del usuario
	session_start();

	// Verifica que el usuario esté autenticado y tenga una sesión activa
	check_session();

	// Obtiene el nombre de usuario almacenado en la sesión actual
	$session_name = $_SESSION['username'];

	// Crea un array para almacenar los datos del miembro
	$row = array();

	// Obtiene los datos del miembro actual (como ID, nombre, rol, etc.) desde la base de datos
	$row = get_member_data($session_name);

	// Asigna los datos obtenidos a variables para utilizarlas más fácilmente
	$id = $row['id'];
	$name = $row['name'];
	$role = $row['role'];  // Rol del usuario (por ejemplo, presidente)
	$pic = $row['pic'];    // Imagen de perfil del usuario
	$last_login = $row['last_login'];

	// Formatea la fecha del último inicio de sesión a un formato más amigable
	$last_login = date('jS M Y H:i', strtotime($last_login));

	// Obtiene datos adicionales, como el número total de miembros, miembros VIP, total de sesiones, y sesiones completadas
	$total_members = get_all_status();
	$core_members = get_vip_status();
	$total_sessions = total_sessions();
	$completed_sessions = completed_sessions();

	// Llama a la función 'starter' que inicializa la página con los datos del usuario
	starter($id, $name, $role, $pic, $last_login, $total_members, $core_members, $total_sessions, $completed_sessions);
?>
	
	<!-- Sección de navegación (breadcrumbs) para mostrar el camino actual dentro de la aplicación -->
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="home.php"><i class="fa fa-home" aria-hidden="true"></i></a></li> <!-- Enlace a la página principal -->
			<li class="active">Aviso</li> <!-- Página actual: Avisos -->
		</ol>
	</div><!--/.row-->

	<!-- Título de la página: Tablón de Avisos -->
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Tablón de Avisos</h1>
		</div>
	</div><!--/.row-->
	
	<?php 
	// Si el rol del usuario es "President" (Presidente), muestra un botón para añadir nuevos avisos
	if($role == "President")
	{
		// Enlace a la página para añadir un nuevo aviso
		echo '<div class="row">
				<div class="col-lg-12">
					<a style="color: #fff;" href="add_notice.php"><h1 class="ribbon"><i class="fa fa-plus-circle" aria-hidden="true"></i> <b>Añadir Aviso</b></h1></a>
				</div>
			</div>';
	}
	?>
		
	<!-- Sección donde se mostrarán los avisos -->
	<div class="row">
		<?php 
		// Llama a la función 'show_notice' para mostrar los avisos disponibles en función del rol del usuario
		show_notice($role); 
		?>
	</div><!--/.row-->

<?php
	// Llama a la función que genera el pie de página de la aplicación
	at_bottom();
?>
