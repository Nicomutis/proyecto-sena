<?php
	require_once('funs.php'); // Incluye las funciones definidas en 'funs.php'
	session_start(); // Inicia la sesión del usuario
	check_session(); // Verifica la validez de la sesión actual
	$session_name = $_SESSION['username']; // Obtiene el nombre de usuario de la sesión
	$row = array(); // Crea un array vacío
	$row = get_member_data($session_name); // Obtiene los datos del miembro usando el nombre de usuario
	$id = $row['id']; // Obtiene el ID del miembro
	$name = $row['name']; // Obtiene el nombre del miembro
	$role = $row['role']; // Obtiene el rol del miembro
	$pic = $row['pic']; // Obtiene la foto del perfil del miembro
	$last_login = $row['last_login']; // Obtiene la última fecha de inicio de sesión del miembro
	$last_login = date('jS M Y H:i', strtotime($last_login)); // Formatea la fecha de la última sesión
	$total_members = get_all_status(); // Obtiene el total de miembros
	$core_members = get_vip_status(); // Obtiene el número de miembros clave
	$total_sessions = total_sessions(); // Obtiene el total de sesiones
	$completed_sessions = completed_sessions(); // Obtiene el número de sesiones completadas
	
	starter($id,$name,$role,$pic,$last_login,$total_members,$core_members,$total_sessions,$completed_sessions); // Inicializa la página con los datos del miembro

	// Verifica si el rol del usuario no es 'President'
	if($role != 'President')
	{
		echo '<div class="text-center alert bg-warning col-md-offset-4 col-md-4"><p><b>Acceso prohibido</b></p></div>'; // Muestra un mensaje de acceso prohibido
		echo '<script>setTimeout(function () { window.location.href = "home.php";}, 1000);</script>'; // Redirige al usuario a la página de inicio después de 1 segundo
		exit(); // Detiene la ejecución del script
	}
?>
	<div class="row">
		<ol class="breadcrumb"> <!-- Muestra la ruta de navegación -->
			<li><a href="home.php"><i class="fa fa-home" aria-hidden="true"></i></a></li> <!-- Enlace a la página de inicio -->
			<li class="active">Miembros</li> <!-- Indica que la página actual es la sección de miembros -->
		</ol>
	</div><!--/.row-->

	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Sección de Miembros</h1> <!-- Título principal de la página -->
		</div>
	</div><!--/.row-->

	<?php 
	if($role == "President") // Verifica si el rol del usuario es 'President'
	{
		echo '<div class="row">
				<div class="col-lg-12">
					<a style="color: #fff;" href="add_member.php"><h1 class="ribbon"><i class="fa fa-user-plus" aria-hidden="true"></i> <b>Añadir Miembro</b></strong> 
					</h1></a>
				</div>
			</div>'; // Muestra un enlace para añadir un nuevo miembro si el usuario es 'President'
	}
	?>

	<div class="row">
		<div class="col-lg-11">
			<?php all_member_table($role); ?> <!-- Muestra la tabla con todos los miembros según el rol del usuario -->
		</div>	
	</div><!--/.row-->
<?php
	at_bottom(); // Función que se ejecuta al final de la página
?>
