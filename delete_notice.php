<?php
	require_once('funs.php'); // Incluye el archivo de funciones que contiene funciones útiles
	session_start(); // Inicia la sesión para usar variables de sesión
	check_session(); // Verifica si la sesión del usuario es válida
	$session_name = $_SESSION['username']; // Obtiene el nombre de usuario desde la sesión
	$row = array(); // Crea un array vacío
	$row = get_member_data($session_name); // Obtiene los datos del miembro usando el nombre de usuario
	$id = $row['id']; // Obtiene el ID del miembro
	$name = $row['name']; // Obtiene el nombre del miembro
	$role = $row['role']; // Obtiene el rol del miembro
	$pic = $row['pic']; // Obtiene la foto del miembro
	$last_login = $row['last_login']; // Obtiene la última fecha de inicio de sesión
	$notice_id = $_GET['notice_id']; // Obtiene el ID del aviso desde la URL
	$last_login = date('jS M Y H:i', strtotime($last_login)); // Formatea la fecha de última sesión
	$total_members = get_all_status(); // Obtiene el número total de miembros
	$core_members = get_vip_status(); // Obtiene el estado de los miembros VIP
	$total_sessions = total_sessions(); // Obtiene el total de sesiones
	$completed_sessions = completed_sessions(); // Obtiene el número de sesiones completadas

	starter($id, $name, $role, $pic, $last_login, $total_members, $core_members, $total_sessions, $completed_sessions); // Llama a la función starter con la información del miembro

	if($role != 'President') // Verifica si el rol del usuario no es 'President'
	{
		echo '<div class="text-center alert bg-warning col-md-offset-4 col-md-4"><p><b>Acceso Prohibido</b></p></div>'; // Muestra un mensaje de acceso prohibido
		echo '<script>setTimeout(function () { window.location.href = "home.php";}, 1000);</script>'; // Redirige al usuario a la página de inicio después de 1 segundo
		exit(); // Detiene la ejecución del script
	}
	?>

	<div class="row">
		<ol class="breadcrumb">
			<li><a href="home.php"><i class="fa fa-home" aria-hidden="true"></i></a></li> <!-- Enlace a la página de inicio -->
			<li><a href="notice.php">Aviso</a></li> <!-- Enlace a la página de avisos -->
			<li class="active">Eliminar Aviso</li> <!-- Indica que estamos en la página para eliminar un aviso -->
		</ol>
	</div><!--/.row-->

	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Eliminar Aviso</h1> <!-- Título de la página -->
		</div>
	</div><!--/.row-->

	<div class="row">
		<div class="error">
			<?php delete_notice($notice_id, $role); ?> <!-- Llama a la función para eliminar el aviso con el ID especificado -->
		</div>
		<div class="col-lg-offset-2 col-lg-6">
			<div class="panel panel-danger"> <!-- Panel de advertencia con estilo de peligro -->
				<div class="panel-heading">
					Advertencia 
				</div>
				<div class="panel-body">
					<form class="" method="post" action="">
						<label for="ask">¿Realmente deseas eliminar este aviso?</label> <!-- Pregunta de confirmación -->
						<br>
						<div class="panel-footer">
							<div class="pull-right">
								<button class="btn btn-danger" name="yes" type="submit" id="login">Sí</button> <!-- Botón para confirmar la eliminación -->
								&nbsp;&nbsp;
								<a href="notice.php" class="btn btn-default" id="login">No, volver</a> <!-- Enlace para cancelar y regresar a la página de avisos -->
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div><!--/.row-->
<?php
	at_bottom(); // Llama a la función at_bottom al final del archivo
?>
