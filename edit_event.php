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
	$event_id = $_GET['event_id']; // Obtiene el ID del evento desde la URL
	$last_login = date('jS M Y H:i', strtotime($last_login)); // Formatea la fecha de última sesión
	$total_members = get_all_status(); // Obtiene el número total de miembros
	$core_members = get_vip_status(); // Obtiene el estado de los miembros VIP
	$total_sessions = total_sessions(); // Obtiene el total de sesiones
	$completed_sessions = completed_sessions(); // Obtiene el número de sesiones completadas

	starter($id, $name, $role, $pic, $last_login, $total_members, $core_members, $total_sessions, $completed_sessions); // Llama a la función starter con la información del miembro

	if($role != 'President') // Verifica si el rol del usuario no es 'President'
	{
		// Muestra un mensaje de advertencia y redirige a la página de inicio después de 1 segundo
		echo '<div class="text-center alert bg-warning col-md-offset-4 col-md-4"><p><b>Acceso Prohibido</b></p></div>'; 
		echo '<script>setTimeout(function () { window.location.href = "home.php";}, 1000);</script>';
		exit(); // Termina la ejecución del script
	}
	?>

	<div class="row">
		<ol class="breadcrumb">
			<li><a href="home.php"><i class="fa fa-home" aria-hidden="true"></i></a></li>
			<li><a href="cronograma.php">Calendario y sesiones</a></li> 
			<li class="active">Editar Sesión</li> 
		</ol>
	</div><!--/.row-->

	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Editar Sesión</h1> 
		</div>
	</div><!--/.row-->
	<?php
	$query = "SELECT * FROM sessions where session_id='$event_id'"; // Consulta para obtener los datos de la sesión usando el ID del evento
	$result = mysqli_query($con, $query); // Ejecuta la consulta
	$rows = mysqli_affected_rows($con); // Obtiene el número de filas afectadas por la consulta

	if($rows == 1) // Verifica si se obtuvo exactamente una fila
	{
		while($member_data = mysqli_fetch_assoc($result)) // Recorre los resultados de la consulta
		{
			$session_name = $member_data['session_name']; // Obtiene el nombre de la sesión
			$session_details = $member_data['session_details']; // Obtiene los detalles de la sesión
			$session_date = $member_data['session_date']; // Obtiene la fecha de la sesión
		}
	}
	else
	{
		echo 'error al recuperar la información'; // Muestra un mensaje de error si no se pudo recuperar la información
	}
	?>

	<div class="row">
		<div class="error">
			<?php edit_event($event_id, $role); ?> <!-- Llama a la función para editar la información del evento -->
		</div>
		<div class="col-lg-offset-2 col-lg-6">
			<form class="form-signin" method="post" action="">
				<label for="name">Título del Evento</label> 
				<input type="text" value="<?php echo $session_name; ?>" name="name" placeholder="máx 150 caracteres" id="name" class="form-control" require><br>
				<label for="name">Descripción del Evento</label> 
				<textarea type="text" name="description" placeholder="Descripción máx 250 caracteres" id="email" class="form-control" require><?php echo $session_details; ?></textarea><br>
				<label for="name">Fecha del Evento</label> 
				<input type="text" value="<?php echo $session_date; ?>" data-field="datetime" placeholder="fecha" name="date" class="form-control" require>
				<div id="dtBox"></div><br>
				<button class="btn btn-primary" name="edit_event" type="submit">Editar</button> 
				&nbsp;&nbsp;
				<a type="button" class="btn btn-default" href="manage_events.php" class="btn btn-default">Cancelar</a> 
			</form>
		</div><!--/.row-->
	<?php
	at_bottom(); // Llama a la función at_bottom al final del archivo
?>
