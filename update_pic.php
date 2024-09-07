<?php
	// Incluye el archivo de funciones 'funs.php'
	require_once('funs.php');
	
	// Inicia la sesión
	session_start();
	
	// Verifica si la sesión está activa
	check_session();
	
	// Obtiene el nombre de usuario almacenado en la sesión
	$session_name = $_SESSION['username'];
	
	// Inicializa un array vacío para los datos del usuario
	$row = array();
	
	// Obtiene los datos del miembro a partir del nombre de usuario
	$row = get_member_data($session_name);
	
	// Extrae información del usuario como ID, nombre, rol, imagen de perfil, etc.
	$id = $row['id'];
	$name = $row['name'];
	$role = $row['role'];
	$pic = $row['pic'];
	
	// Formatea la fecha del último inicio de sesión en un formato más legible
	$last_login = $row['last_login'];
	$last_login = date('jS M Y H:i', strtotime($last_login));
	
	// Obtiene el total de miembros y miembros VIP
	$total_members = get_all_status();
	$core_members = get_vip_status();
	
	// Obtiene el total de sesiones y las sesiones completadas
	$total_sessions = total_sessions();
	$completed_sessions = completed_sessions();
	
	// Llama a la función 'starter' para iniciar la página con los datos del usuario
	starter($id, $name, $role, $pic, $last_login, $total_members, $core_members, $total_sessions, $completed_sessions);
?>
			
		<!-- Sección para mostrar el camino de navegación (breadcrumbs) -->
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="home.php"><i class="fa fa-home" aria-hidden="true"></i></a></li>
				<li class="active">Cambiar foto de perfil</li> <!-- Página actual: Cambiar foto de perfil -->
			</ol>
		</div><!--/.row-->

		<!-- Sección de título de la página -->
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Cambiar foto de perfil</h1> 
			</div>
		</div><!--/.row-->

		<!-- Sección donde se muestra la imagen de perfil actual y el formulario para subir una nueva imagen -->
		<div class="row">
			<div class="error">
				<?php update_pic($id); ?> <!-- Llama a la función para actualizar la foto de perfil -->
			</div>
			
			<!-- Muestra la imagen de perfil actual del usuario -->
			<div class="col-lg-offset-2 col-lg-4">
				<img src="<?php echo $pic; ?>" height="200px" width="200px" class="img-responsive img-circle"><br>
				<h4><?php echo $name; ?></h4> <!-- Muestra el nombre del usuario -->
			</div>
			
			<!-- Panel para subir una nueva foto de perfil -->
			<div class="col-lg-4">
				<div class="panel panel-info">
					<div class="panel-heading">
						Subir nueva foto <!-- Título del panel -->
					</div>
					<div class="panel-body">
						<!-- Formulario para subir la imagen -->
						<form action="" role="form" method="POST" class="form-signin" enctype="multipart/form-data">
							<label for="file">Seleccionar imagen</label><br> 
		         			<input type="file" name="image"><br>
		         		</div>
					<div class="panel-footer">
		         			<!-- Botón para cambiar la foto y opción para cancelar -->
		         			<button class="btn btn-primary" name="add_event" type="submit">Cambiar</button>&nbsp;&nbsp; 
							<a type="button" class="btn btn-default" href="home.php" class="btn btn-default">Cancelar</a> 
					</div>
      				</form>
				</div>
			</div>
		</div><!--/.row-->

<?php
	// Llama a la función que muestra el pie de página
	at_bottom();

	// Función que se encarga de actualizar la foto de perfil del usuario
	function update_pic($id)
	{
		global $con; // Accede a la conexión global de la base de datos
		
		// Verifica si se ha subido una imagen
		if(isset($_FILES['image']))
		{
			$errors= array();
			$file_name = $_FILES['image']['name']; // Obtiene el nombre del archivo subido
			$file_size =$_FILES['image']['size']; // Obtiene el tamaño del archivo
			$file_tmp =$_FILES['image']['tmp_name']; // Ruta temporal del archivo
			$file_type=$_FILES['image']['type']; // Tipo de archivo
			
			// Verifica si el archivo supera el límite de 2 MB
			if($file_size > 2097152)
			{
				$errors[]='El tamaño del archivo debe ser exactamente de 2 MB'; 
			}
			
			// Si no hay errores, mueve la imagen al directorio y actualiza la base de datos
			if(empty($errors)==true)
			{
				// Mueve el archivo subido al directorio 'imgs'
				move_uploaded_file($file_tmp,"imgs/".$file_name);
				$addr = 'imgs/'.$file_name;
				
				// Actualiza la base de datos con la nueva ruta de la imagen
				$query = "UPDATE userinfo SET pic='$addr' WHERE id='$id'";
				$result = mysqli_query($con,$query);
				$rows = mysqli_affected_rows($con);
				
				// Verifica si la actualización fue exitosa
				if($rows == 1)
				{
					// Muestra un mensaje de éxito y redirige a la misma página
					echo '<div class="text-center alert bg-success"><span>¡Éxito! Foto de perfil actualizada</span></div>'; 
					echo '<script>setTimeout(function () { window.location.href = "update_pic.php";}, 1000);</script>';
				}
				else
				{
					// Muestra un mensaje de error si la actualización falla
					echo '<div class="text-center alert bg-danger"><span>Problema al actualizar la foto de perfil</span></div>';	
				}
			}
			else
			{
				// Muestra los errores si los hay
				print_r($errors);
			}
			
			return false;
		}
	}
?>
