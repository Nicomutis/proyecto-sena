<?php
	require_once('funs.php'); // Incluye el archivo de funciones que se utilizarán
	$post_id = $_GET['id']; // Obtiene el ID de la publicación desde la URL
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
	$last_login = date('jS M Y H:i', strtotime($last_login)); // Formatea la fecha de última sesión
	$total_members = get_all_status(); // Obtiene el total de miembros
	$core_members = get_vip_status(); // Obtiene el estatus de miembros VIP
	$total_sessions = total_sessions(); // Obtiene el total de sesiones
	$completed_sessions = completed_sessions(); // Obtiene el número de sesiones completadas
	
	starter($id, $name, $role, $pic, $last_login, $total_members, $core_members, $total_sessions, $completed_sessions); // Llama a la función starter con los datos del miembro
?>
<?php	

	$query = "SELECT * FROM blog_posts WHERE id = '$post_id'"; // Consulta para obtener los datos de la publicación basada en el ID
	$result = mysqli_query($con, $query); // Ejecuta la consulta

	if (mysqli_num_rows($result) > 0) // Verifica si la consulta devolvió resultados
	{
		while($row = mysqli_fetch_assoc($result)) // Recorre los resultados
		{
            $postTitle = $row['postTitle']; // Obtiene el título de la publicación
            $description = $row['description']; // Obtiene la descripción de la publicación
            $content = $row['content']; // Obtiene el contenido de la publicación
            $catinfo = $row['catinfo']; // Obtiene la categoría de la publicación                    
		}
	}
	else
	{
		// Muestra un mensaje de error si no se pudo recuperar la información de la publicación
		echo '<div class="text-center alert bg-danger col-md-offset-4 col-md-4" role="alert"><span>Error, la recuperación de la información de la publicación falló, inténtalo de nuevo</span></div>'; 
		die(); // Termina la ejecución del script
	}
?>
	
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="home.php"><i class="fa fa-home" aria-hidden="true"></i></a></li>
			<li><a href="blog-home.php">Blog</a></li>
			<li class="active">Editar Publicación</li> 
		</ol>
	</div><!--/.row-->

	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Editar Publicación</h1> 
		</div>
	</div><!--/.row-->

	<div class="row">
		<div class="error">
			<?php edit_post($post_id); ?> <!-- Llama a la función para editar la publicación -->
		</div>
		<div class="col-lg-12">
			<form class="form-signin" method="post" action="">
			<div class="col-lg-4">
				<label for="postTitle">Título de la Publicación</label> 
				<input type="text" value="<?php echo $postTitle; ?>" name="postTitle" placeholder="Título de la Publicación" class="form-control" required autofocus>
				<br>
				<label for="description">Descripción de la Publicación</label> 
				<textarea name="description" rows="7" cols="60" maxlength="250" placeholder="Descripción de la Publicación" id="description" class="form-control space" required><?php echo $description; ?></textarea>
				<br>
				<label for="content">Seleccionar Categoría de la Publicación</label><br> 
				<select class="form-control" name="cats">
					<option name="<?php echo $catinfo; ?>" value="<?php echo $catinfo; ?>"><?php echo $catinfo; ?></option>
    				<option name="Sin Categoría" value="Sin Categoría">Sin Categoría</option> 
				   	<option name="Tecnología" value="Tecnología">Tecnología</option> 
				  	<option name="Estilo de Vida" value="Estilo de Vida">Estilo de Vida</option> 
				   	<option name="Noticias" value="Noticias">Noticias</option> 
				   	<option name="Educación" value="Educación">Educación</option> 
				   	<option name="Naturaleza" value="Naturaleza">Naturaleza</option> 
				   	<option name="Salud" value="Salud">Salud</option> 
				   	<option name="Programación" value="Programación">Programación</option> 
  				</select>
			</div>
			<div class="col-lg-8">
					<label for="content">Contenido de la Publicación</label> 
					<textarea name="content" placeholder="Contenido de la Publicación" id="content" class="form-control space" required><?php echo $content; ?></textarea>
					<div class="text-center">
				<button class="btn btn-lg btn-primary" name="update" type="submit" id="update">Actualizar Publicación</button> 
			</div>
			</div>
					
			</form>
	</div>
</div><!--/.row-->
<?php
	at_bottom(); // Llama a la función at_bottom al final del archivo
?>
