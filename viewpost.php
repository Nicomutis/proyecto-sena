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
	
	// Obtiene los datos del miembro basado en el nombre de usuario de la sesión
	$row = get_member_data($session_name);
	
	// Extrae la información relevante del miembro (ID, nombre, rol, etc.)
	$id = $row['id'];
	$name = $row['name'];
	$role = $row['role'];
	$pic = $row['pic'];
	$post_id = $_GET['id']; // Obtiene el ID de la publicación desde la URL
	
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

<?php
	// Realiza una consulta a la base de datos para obtener la publicación con el ID proporcionado
	$query = "SELECT * FROM blog_posts WHERE id = '$post_id'";
	$result = mysqli_query($con, $query); // Ejecuta la consulta

	// Verifica si se encontraron resultados
	if (mysqli_num_rows($result) > 0)
	{
		// Recorre los resultados de la consulta
		while($row = mysqli_fetch_assoc($result))
		{
			// Asigna los valores de la publicación a variables
            $postTitle = $row['postTitle']; // Título de la publicación
            $postDate = date('jS M Y H:i:s', strtotime($row['post_date'])); // Fecha de la publicación
            $auther = $row['auther']; // Autor de la publicación
            $description = $row['description']; // Descripción de la publicación
            $content = $row['content']; // Contenido de la publicación
            $catinfo = $row['catinfo']; // Categoría de la publicación
		}
	}
	else
	{
		// Si no se encuentra la publicación, muestra un mensaje de error
		echo '<div class="alert alert-warning text-center"><h3>¡Error al recuperar la publicación!</h3></div>'; 
	}
?>

<!-- Muestra la ruta de navegación (breadcrumbs) -->
<div class="row">
	<ol class="breadcrumb">
		<li><a href="home.php"><i class="fa fa-home" aria-hidden="true"></i></a></li>
		<li><a href="blog-home.php">Blog</a></li>
		<li class="active"><?php echo $postTitle; ?></li> <!-- Muestra el título de la publicación actual -->
	</ol>
</div><!--/.row-->

<!-- Muestra el título de la publicación y los detalles -->
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"><?php echo $postTitle; ?></h1> <!-- Título de la publicación -->
		<p>Publicado por <b><?php echo $auther; ?></b> el <b><?php echo $postDate; ?></b> en 
		<a href="buscador.php?cat=<?php echo $catinfo; ?>"><?php echo $catinfo; ?></a></p> <!-- Muestra el autor, fecha y categoría -->
	</div>
</div><!--/.row-->

<!-- Muestra la descripción y el contenido de la publicación -->
<div class="row">
	<div class="col-lg-12">
		<h3><i><?php echo $description; ?></i></h3><br> <!-- Muestra la descripción de la publicación -->
		<p><h3><?php echo $content; ?></h3></p> <!-- Muestra el contenido de la publicación -->
	</div>
</div>

<?php
	// Llama a la función para mostrar el pie de página
	at_bottom();
?>

