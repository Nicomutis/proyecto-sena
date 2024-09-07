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
	$key = $_GET['key']; // Obtiene el valor del parámetro 'key' de la URL
	
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
				<li><a href="asistencia.php">Asistencia</a></li> <!-- Enlace a la página de asistencia -->
				<li class="active">Gestionar Asistencia</li> <!-- Indica que la página actual es la sección de gestión de asistencia -->
			</ol>
		</div><!--/.row-->

		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Registrar Asistencia para la Sesión</h1> <!-- Título principal de la página -->
			</div>
		</div><!--/.row-->

		<div class="row">
			<div class="error"> <!-- Muestra errores relacionados con la asistencia -->
				<?php do_attendance($key); ?> <!-- Llama a la función para registrar la asistencia con el parámetro 'key' -->
			</div>
			<div class="col-lg-offset-2 col-lg-6">
				<div class="panel panel-primary"> <!-- Panel para registrar la asistencia -->
					<div class="panel-heading">
						Marcar Todos los Miembros Presentes <!-- Título del panel -->
					</div>
					<div class="panel-body">
						<form class="form-signin" method="post" action=""> <!-- Formulario para registrar asistencia -->
							<?php
								global $con; // Accede a la variable global de conexión a la base de datos
								$key = $key; // Reutiliza el parámetro 'key'
								$query = "SELECT * FROM userinfo"; // Consulta para obtener todos los usuarios
								$result = mysqli_query($con,$query); // Ejecuta la consulta
								$rows = mysqli_affected_rows($con); // Obtiene el número de filas afectadas
								while ($row = mysqli_fetch_assoc($result)) // Itera sobre los resultados de la consulta
								{
									// Muestra una casilla de verificación para cada miembro
									echo '<div class="checkbox">
									<label><input type="checkbox" name="checkbx[]" value="'.$row['id'].'">'.$row['name'].'</label>
									</div>';
								}
							?>
						</div>
						<div class="panel-footer">
							<button class="btn btn-primary pull-left" name="submit_attendance" type="submit" id="login">Guardar Asistencia</button> <!-- Botón para guardar la asistencia -->
							&nbsp;&nbsp; 
							<a href="notice.php" class="btn btn-default" id="login">Cancelar</a> <!-- Enlace para cancelar y volver -->
						</div>
						</div>
						</form>
					</div>
				</div>
			</div>
		</div><!--/.row-->
<?php
	at_bottom(); // Función que se ejecuta al final de la página
?>
