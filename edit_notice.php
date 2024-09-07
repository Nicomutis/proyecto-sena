<?php
	require_once('funs.php'); // Incluye el archivo de funciones
	session_start(); // Inicia la sesión
	check_session(); // Verifica si la sesión es válida
	$session_name = $_SESSION['username']; // Obtiene el nombre de usuario desde la sesión
	$row = array(); // Crea un array vacío
	$row = get_member_data($session_name); // Obtiene los datos del miembro basado en el nombre de usuario
	$id = $row['id']; // Obtiene el ID del miembro
	$name = $row['name']; // Obtiene el nombre del miembro
	$role = $row['role']; // Obtiene el rol del miembro
	$pic = $row['pic']; // Obtiene la imagen del miembro
	$last_login = $row['last_login']; // Obtiene la última fecha de inicio de sesión
	$notice_id = $_GET['notice_id']; // Obtiene el ID del aviso desde la URL
	$last_login = date('jS M Y H:i', strtotime($last_login)); // Formatea la fecha de última sesión
	$total_members = get_all_status(); // Obtiene el total de miembros
	$core_members = get_vip_status(); // Obtiene el estatus de miembros VIP
	$total_sessions = total_sessions(); // Obtiene el total de sesiones
	$completed_sessions = completed_sessions(); // Obtiene el número de sesiones completadas

	starter($id, $name, $role, $pic, $last_login, $total_members, $core_members, $total_sessions, $completed_sessions); // Llama a la función starter con los datos del miembro

	if($role != 'President') // Verifica si el rol del usuario no es 'President'
	{
		// Muestra un mensaje de advertencia si el acceso está prohibido y redirige a la página de inicio después de 1 segundo
		echo '<div class="text-center alert bg-warning col-md-offset-4 col-md-4"><p><b>Acceso Prohibido</b></p></div>'; 
		echo '<script>setTimeout(function () { window.location.href = "home.php";}, 1000);</script>';
		exit(); // Termina la ejecución del script
	}
	?>

	<div class="row">
		<ol class="breadcrumb">
			<li><a href="home.php"><i class="fa fa-home" aria-hidden="true"></i></a></li>
			<li><a href="notice.php">Avisos</a></li> 
			<li class="active">Editar Aviso</li> 
		</ol>
	</div><!--/.row-->

	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Editar Aviso</h1> 
		</div>
	</div><!--/.row-->

	<?php
	$query = "SELECT * FROM notice where notice_id='$notice_id'"; // Consulta para obtener los datos del aviso basado en el ID
	$result = mysqli_query($con, $query); // Ejecuta la consulta
	$rows = mysqli_affected_rows($con); // Obtiene el número de filas afectadas

	if($rows == 1) // Verifica si se obtuvo exactamente una fila
	{
		while($member_data = mysqli_fetch_assoc($result)) // Recorre los resultados
		{
			$session_name = $member_data['title']; // Obtiene el título del aviso
			$session_details = $member_data['description']; // Obtiene la descripción del aviso
			$session_date = $member_data['date']; // Obtiene la fecha del aviso
		}
	}
	else
	{
		echo 'error al recuperar la información'; // Muestra un mensaje de error si no se pudo recuperar la información
	}
	?>
	<div class="row">
		<div class="error">
			<?php edit_notice($notice_id, $role); ?> <!-- Llama a la función para editar el aviso -->
		</div>
		<div class="col-lg-offset-2 col-lg-6">
			<form class="form-signin" method="post" action="">
				<label for="name">Título del Aviso</label> 
				<input type="text" name="name" value="<?php echo $session_name; ?>" placeholder="máx 150 caracteres" id="name" class="form-control" require><br>
				<label for="name">Descripción del Aviso</label> 
				<textarea name="description" placeholder="Descripción máx 250 caracteres" id="email" class="form-control" require><?php echo $session_details; ?></textarea><br>
				<label for="name">Fecha del Aviso</label> 
				<input type="text" value="<?php echo $session_date; ?>" data-field="datetime" placeholder="fecha" name="date" class="form-control" require>
				<div id="dtBox"></div><br>
				<button class="btn btn-primary" name="edit_notice" type="submit">Editar Aviso</button> 
				&nbsp;&nbsp;
				<a type="button" class="btn btn-default" href="notice.php" class="btn btn-default">Cancelar</a> 
			</form>
		</div>
	</div><!--/.row-->

<?php
	at_bottom(); // Llama a la función at_bottom al final del archivo
?>
