<?php
	require_once('funs.php'); // Incluye el archivo 'funs.php', que contiene funciones necesarias para este script.
	session_start(); // Inicia una nueva sesión o reanuda una sesión existente.
	check_session(); // Verifica si la sesión es válida.

	$session_name = $_SESSION['username']; // Obtiene el nombre de usuario de la sesión actual.
	$row = array(); // Inicializa un array vacío.
	$row = get_member_data($session_name); // Obtiene los datos del miembro basados en el nombre de usuario.
	$id = $row['id']; // Asigna el ID del miembro.
	$name = $row['name']; // Asigna el nombre del miembro.
	$role = $row['role']; // Asigna el rol del miembro.
	$pic = $row['pic']; // Asigna la imagen de perfil del miembro.
	$getcategory = $_GET['cat']; // Obtiene la categoría seleccionada de la URL.
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
			<li><a href="blog-home.php">Blog</a></li> <!-- Enlace a la página principal del blog. -->
			<li class="active"><?php echo $getcategory; ?></li> <!-- Muestra la categoría actual. -->
		</ol>
	</div><!--/.row-->

	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Publicaciones en <?php echo $getcategory; ?></h1> <!-- Título de la página mostrando la categoría actual. -->
		</div>
	</div><!--/.row-->

	<div class="row">
	<?php
	$query = "SELECT * FROM blog_posts WHERE catinfo='$getcategory' ORDER BY id DESC"; // Consulta SQL para obtener publicaciones en la categoría seleccionada, ordenadas por ID de manera descendente.
	$result = mysqli_query($con, $query); // Ejecuta la consulta en la base de datos.

	if(mysqli_num_rows($result) > 0) // Verifica si hay resultados en la consulta.
	{
		$select = 1; // Inicializa un contador para alternar el estilo de las publicaciones.
		while($row = mysqli_fetch_assoc($result)) // Recorre cada publicación obtenida en la consulta.
		{
			if($select % 2 == 1) // Alterna el estilo de la publicación entre 'panel-primary' y 'panel-info'.
			{
				$css = 'panel-primary'; // Asigna el estilo para la primera publicación.
			}
			else
			{
				$css = 'panel-info'; // Asigna el estilo para la siguiente publicación.
			}
		?>
		<div class="col-lg-5"> <!-- Crea un contenedor para la publicación. -->
			<div class="panel <?php echo $css; ?>"> <!-- Asigna el estilo a la publicación basado en el contador. -->
				<div class="panel-heading">
					<?php echo $row['postTitle']; ?> <!-- Muestra el título de la publicación. -->
				</div>
				<div class="panel-body">
					<i>Publicado el <?php echo date('jS M Y H:i:s', strtotime($row['post_date'])); ?></i> por <?php echo $row['auther']; ?> en 
					<a href="buscador.php?cat=<?php echo $row['catinfo']; ?>"><?php echo $row['catinfo']; ?></a> <!-- Muestra la fecha de publicación, el autor y la categoría con enlace a la búsqueda por categoría. -->
					<br><br>
					<p><?php echo $row['description']; ?></p> <!-- Muestra la descripción de la publicación. -->
				</div>
				<div class="panel-footer">
					<?php
					if($session_name == $row['auther'] || $role == 'President') // Verifica si el usuario actual es el autor de la publicación o tiene el rol de "President".
					{?>
						<a class="btn btn-warning" href="edit-post.php?id=<?php echo $row['id']; ?>&title=<?php echo $row['postTitle']; ?>">Editar</a> <!-- Enlace para editar la publicación, visible solo para el autor o el presidente. -->
						<a class="btn btn-danger" href="delete-post.php?id=<?php echo $row['id']; ?>&title=<?php echo $row['postTitle']; ?>">Eliminar</a> <!-- Enlace para eliminar la publicación, visible solo para el autor o el presidente. -->
					<?php }
					?>
					<a class="btn btn-primary" href="viewpost.php?id=<?php echo $row['id']; ?>&title=<?php echo $row['postTitle']; ?>">Leer Más</a> <!-- Enlace para leer la publicación completa. -->
				</div>
			</div>
		</div>
		<?php
			$select++; // Incrementa el contador para alternar el estilo en la siguiente publicación.
		} // Fin del bucle while de publicaciones.

	} // Fin de la verificación de resultados.
	else
	{
		echo '<div class="text-center alert bg-warning col-md-offset-4 col-md-4" role="alert"><span>No se encontraron publicaciones, inténtalo de nuevo</span></div>'; // Muestra un mensaje de alerta si no se encontraron publicaciones.
	}

	echo '</div>'; // Cierra el contenedor de la fila de publicaciones.
	at_bottom(); // Llama a la función 'at_bottom' para completar el contenido de la página (probablemente incluye el pie de página).
?>
