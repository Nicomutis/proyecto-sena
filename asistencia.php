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
?>

	<div class="row">
		<ol class="breadcrumb"> <!-- Muestra una barra de navegación que indica la ubicación actual en el sitio web. -->
			<li><a href="home.php"><i class="fa fa-home" aria-hidden="true"></i></a></li> <!-- Enlace a la página principal. -->
			<li class="active">Asistencia</li> <!-- Muestra "Asistencia" como la página actual. -->
		</ol>
	</div><!--/.row-->

	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Sección de Asistencia</h1> <!-- Título de la página que indica la sección de asistencia. -->
		</div>
	</div><!--/.row-->

	<div class="row">
		<div class="panel">
			<div class="panel-body tabs">
				<div class="col-lg-3">
					<div class="panel-header">
						<h3 class="text-center">Seleccionar Sesión</h3> <!-- Título para seleccionar la sesión. -->
						<br>
						<ul class="nav nav-pills nav-stacked"> <!-- Crea una lista de navegación vertical para seleccionar la sesión. -->
						<?php
							global $con; // Declara la variable global de conexión a la base de datos.
							$query = "SELECT * FROM sessions"; // Consulta SQL para obtener todas las sesiones.
							$result = mysqli_query($con, $query); // Ejecuta la consulta.
							$rows = mysqli_affected_rows($con); // Obtiene el número de filas afectadas por la consulta.
							
							// Recorre cada fila del resultado de la consulta.
							while ($row = mysqli_fetch_assoc($result))
							{
								echo '<li><a href="#'.$row['session_id'].'" data-toggle="pill">'.date('jS M Y H:i', strtotime($row['session_date'])).'</a></li>';
							}
						?>
						</ul>
					</div>
				</div>
				<div class="panel-body">
					<div class="col-lg-9">
						<div class="tab-content"> <!-- Contenido de las pestañas para mostrar la información de la sesión. -->
							<div id="tab-start" class="tab-pane fade in active"> <!-- Contenido de la pestaña activa por defecto. -->
								<div class="col-lg-6">
									<div class="panel panel-teal">
										<div class="panel-heading">
											Asistencia por Sesión <!-- Título del panel para mostrar la asistencia por sesión. -->
										</div>
										<div class="panel-body">
											<p><i>Elige la fecha de la sesión desde el lado izquierdo para ver la asistencia de esa sesión específica.</i></p> 
										</div>
									</div>
								</div>
							</div>
							<?php
								global $con; // Declara la variable global de conexión a la base de datos.
								$query = "SELECT * FROM sessions"; // Consulta SQL para obtener todas las sesiones.
								$result = mysqli_query($con, $query); // Ejecuta la consulta.
								$rows = mysqli_affected_rows($con); // Obtiene el número de filas afectadas por la consulta.

								// Recorre cada fila del resultado de la consulta para crear las pestañas correspondientes.
								while ($row = mysqli_fetch_assoc($result))
								{
									echo '<div id="'.$row['session_id'].'" class="tab-pane fade">
											<h3 class="text-center">Asistencia para '.date('jS M Y H:i', strtotime($row['session_date'])).'</h3><br>'; 
										attendance($row['session_id'], $role); // Muestra la asistencia para la sesión actual.
									echo '</div>';
								}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div><!--/.row-->

<?php
	at_bottom(); // Llama a la función 'at_bottom' para completar el contenido de la página (probablemente incluye el pie de página).
?>
