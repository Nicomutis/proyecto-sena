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
	$mem_id = $_GET['mem_id']; // Obtiene el ID del miembro a editar desde la URL
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
			<li><a href="gestion_miembros.php">Miembros</a></li> 
			<li class="active">Editar Miembro</li> 
		</ol>
	</div><!--/.row-->

	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Editar Miembro</h1> 
		</div>
	</div><!--/.row-->

	<?php
	$query = "SELECT * FROM userinfo where id='$mem_id'"; // Consulta para obtener los datos del miembro usando el ID
	$result = mysqli_query($con, $query); // Ejecuta la consulta
	$rows = mysqli_affected_rows($con); // Obtiene el número de filas afectadas por la consulta

	if($rows == 1) // Verifica si se obtuvo exactamente una fila
	{
		while($member_data = mysqli_fetch_assoc($result)) // Recorre los resultados de la consulta
		{
			$member_name = $member_data['name']; // Obtiene el nombre del miembro
			$member_email = $member_data['email']; // Obtiene el correo electrónico del miembro
			$member_username = $member_data['username']; // Obtiene el nombre de usuario del miembro
			$member_role = $member_data['role']; // Obtiene el rol del miembro
		}
	}
	else
	{
		echo 'error al recuperar la información del miembro'; // Muestra un mensaje de error si no se pudo recuperar la información
	}
	?>

	<div class="row">
		<div class="error">
			<?php edit_member($role, $mem_id); ?> <!-- Llama a la función para editar la información del miembro -->
		</div>
		<div class="col-lg-offset-2 col-lg-6">
			<form class="form-signin" method="post" action="">
				<label for="name">Nombre</label> 
				<input type="text" value="<?php echo $member_name; ?>" name="name" placeholder="Nombre" id="name" class="form-control" require><br>
				<label for="name">Correo Electrónico</label> 
				<input type="email" value="<?php echo $member_email; ?>" name="email" placeholder="Correo Electrónico" id="email" class="form-control" require><br>
				<label for="name">Nombre de Usuario</label> 
				<input type="text" value="<?php echo $member_username; ?>" name="username" placeholder="nombre de usuario" id="username" class="form-control"><br>
				<?php if($role == 'President') // Verifica si el rol del usuario es 'President'
				{
					// Muestra un campo de selección para cambiar el rol del miembro, solo si el usuario es el Presidente
					echo '<label for="name">Rol <small>(solo el Presidente puede agregar/editar roles)</small></label> 
					<select class="form-control" name="role">
						<option name="'.$member_role.'" value="'.$member_role.'">'.$member_role.'</option>
	    				<option name="Member" value="Member">Miembro</option> 
					   	<option name="Media-Marketing" value="Media Marketing">Marketing de Medios</option> 
					  	<option name="Admin Logistics" value="Admin Logistics">Logística Administrativa</option> 
					   	<option name="Member Management" value="Member Management">Gestión de Miembros</option> 
					   	<option name="Technical" value="Technical">Técnico</option> 
					   	<option name="President" value="President">Presidente</option> 
	  				</select><br>';
				} ?>
				<button class="btn btn-primary" name="edit_member" type="submit" id="login">Editar</button> 
				&nbsp;&nbsp;
				<a href="gestion_miembros.php" class="btn btn-default" id="login">Cancelar</a> 
			</form>
		</div>
	</div><!--/.row-->

<script>
		$(document).ready(function()
		{
		     $("#dtBox").DateTimePicker(); // Inicializa el selector de fecha y hora
		});
 	</script>
<link rel="stylesheet" type="text/css" href="css/DateTimePicker.min.css" /> <!-- Incluye la hoja de estilos para el selector de fecha y hora -->
<script type="text/javascript" src="js/DateTimePicker.min.js"></script> <!-- Incluye el archivo JavaScript para el selector de fecha y hora -->
<?php
	at_bottom(); // Llama a la función at_bottom al final del archivo
?>
