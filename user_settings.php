<?php
	// Incluye el archivo 'funs.php' que contiene funciones necesarias
	require_once('funs.php');
	
	// Inicia la sesión
	session_start();
	
	// Verifica si la sesión está activa
	check_session();
	
	// Obtiene el nombre de usuario desde la sesión
	$session_name = $_SESSION['username'];
	
	// Inicializa un array vacío para los datos del miembro
	$row = array();
	
	// Obtiene los datos del miembro basados en el nombre de usuario de la sesión
	$row = get_member_data($session_name);
	
	// Extrae la información relevante del miembro (ID, nombre, rol, etc.)
	$id = $row['id'];
	$name = $row['name'];
	$role = $row['role'];
	$pic = $row['pic'];
	$user_id = $_GET['user_id']; // Obtiene el ID del usuario desde la URL
	
	// Convierte la fecha del último inicio de sesión a un formato más legible
	$last_login = $row['last_login'];
	$last_login = date('jS M Y H:i', strtotime($last_login));
	
	// Obtiene el total de miembros y miembros VIP
	$total_members = get_all_status();
	$core_members = get_vip_status();
	
	// Obtiene el número total de sesiones y sesiones completadas
	$total_sessions = total_sessions();
	$completed_sessions = completed_sessions();
	
	// Llama a la función 'starter' pasando los datos del miembro y otra información
	starter($id, $name, $role, $pic, $last_login, $total_members, $core_members, $total_sessions, $completed_sessions);
?>

<!-- Muestra la ruta de navegación (breadcrumbs) -->
<div class="row">
	<ol class="breadcrumb">
		<li><a href="home.php"><i class="fa fa-home" aria-hidden="true"></i></a></li>
		<li class="active">Configuración de Usuario</li> <!-- Indica que la página actual es la configuración de usuario -->
	</ol>
</div><!--/.row-->

<!-- Muestra el título de la página "Configuración de Usuario" -->
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Configuración de Usuario</h1> 
	</div>
</div><!--/.row-->

<!-- Muestra la sección de error si ocurre algún problema al actualizar los ajustes -->
<div class="row">
	<div class="error">
		<?php update_settings($id); ?> <!-- Llama a la función que actualiza la configuración del usuario -->
	</div>
	
	<!-- Formulario para editar los detalles del perfil -->
	<div class="col-lg-offset-2 col-lg-6">
		<div class="panel panel-primary">
			<div class="panel-heading">
				Detalles del Perfil <!-- Sección para los detalles del perfil -->
			</div>
			<div class="panel-body">
				<form class="form-signin" method="post" action="">
					<label for="name">Nombre</label> <!-- Campo para editar el nombre de usuario -->
					<input type="text" value="<?php echo $name; ?>" name="name" placeholder="Nombre de usuario" id="username" class="form-control" require> 
			</div>
		</div>

		<!-- Sección de seguridad para cambiar la contraseña -->
		<div class="panel panel-danger">
			<div class="panel-heading">
				Seguridad <!-- Título de la sección de seguridad -->
			</div>
			<div class="panel-body">
				<!-- Campo para ingresar la contraseña antigua -->
				<label for="name">Contraseña antigua</label> 
				<input type="password" name="old_pwd" placeholder="Contraseña antigua" id="password" class="form-control"> 
				
				<!-- Campo para ingresar la nueva contraseña -->
				<label for="name">Nueva contraseña</label> 
				<input type="password" name="new_pwd" placeholder="Nueva contraseña" id="password" class="form-control"><br/> 
			</div>

			<!-- Botones para guardar los cambios o cancelar -->
			<div class="panel-footer">
				<button class="btn btn-primary" name="update_settings" type="submit" id="login">Guardar</button>&nbsp;&nbsp; 
				<a href="home.php" class="btn btn-default" id="login">Cancelar</a> <!-- Botón para cancelar la acción -->
			</div>
		</form>
	</div>
</div><!--/.row-->

<?php
	// Llama a la función para mostrar el pie de página
	at_bottom();
?>
