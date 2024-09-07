<?php

	// Incluye el archivo de funciones 'funs.php' donde están definidas varias funciones reutilizables
	require_once('funs.php');

	// Inicia una sesión para el usuario
	session_start();

	// Verifica si la sesión está activa
	check_session();

	// Obtiene el nombre de usuario de la sesión actual
	$session_name = $_SESSION['username'];

	// Crea un array vacío para almacenar los datos del usuario
	$row = array();

	// Obtiene los datos del miembro actual según su nombre de usuario
	$row = get_member_data($session_name);

	// Extrae el ID, nombre, rol e imagen de perfil del usuario
	$id = $row['id'];
	$name = $row['name'];
	$role = $row['role'];
	$pic = $row['pic'];

	// Formatea la fecha del último inicio de sesión a un formato más legible
	$last_login = $row['last_login'];
	$last_login = date('jS M Y H:i', strtotime($last_login));

	// Obtiene el número total de miembros y el número de miembros VIP
	$total_members = get_all_status();
	$core_members = get_vip_status();

	// Obtiene el total de sesiones y las sesiones completadas
	$total_sessions = total_sessions();
	$completed_sessions = completed_sessions();

	// Llama a la función 'starter' para inicializar la página con los datos del usuario
	starter($id, $name, $role, $pic, $last_login, $total_members, $core_members, $total_sessions, $completed_sessions);

	// Obtiene el término de búsqueda enviado por el formulario POST
	$key = $_POST['term'];

	// Realiza una consulta en la base de datos buscando en las columnas 'postTitle', 'description' y 'content'
	// todos los registros que coincidan parcial o totalmente con el término de búsqueda
	$query = "SELECT * FROM blog_posts WHERE postTitle LIKE '%".$key."%' OR description LIKE '%".$key."%' OR content LIKE '%".$key."%'";

	// Ejecuta la consulta
	$result = mysqli_query($con, $query);

?>
	<!-- Sección para mostrar el camino de navegación (breadcrumbs) -->
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="home.php"><i class="fa fa-home" aria-hidden="true"></i></a></li>
			<li class="active">Búsqueda</li> <!-- Página actual: Búsqueda -->
		</ol>
	</div><!--/.row-->

	<!-- Título de la página con el término de búsqueda subrayado -->
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Resultados de búsqueda para <u><?php echo $key; ?></u></h1>
		</div>
	</div><!--/.row-->
		
	<!-- Sección donde se muestran los resultados de la búsqueda -->
	<div class="row">
		<?php

		// Si no se encontraron resultados en la búsqueda, muestra un mensaje de advertencia
		if (mysqli_num_rows($result) == 0)
		{
			echo  '<br><div class="text-center alert bg-warning col-lg-offset-2 col-lg-5"><span><b>Lo sentimos, no se encontraron resultados</b></span></div>'; 
		}

		// Si se encuentran resultados, los muestra en paneles de color alterno (teal y naranja)
		if (mysqli_num_rows($result) > 0)
		{
			$select = 1;
			// Itera a través de los resultados de la búsqueda
			while ($row = mysqli_fetch_assoc($result))
			{
				// Alterna el color del panel entre 'teal' y 'naranja'
				if ($select % 2 == 1)
				{
					$css = 'panel-teal';
				}
				else
				{
					$css = 'panel-orange';
				}
				?>

				<!-- Muestra cada resultado en un panel con los detalles del post -->
				<div class="col-lg-4">
					<div class="panel <?php echo $css; ?>">
						<div class="panel-body">
							<!-- Enlace al post utilizando su ID y título -->
							<a href="viewpost.php?id=<?php echo $row['id']; ?>&title=<?php echo $row['postTitle']; ?>" style="color: #fff;">
								<h3 style="color: #fff;"><?php echo $row['postTitle']; ?></h3>
								<!-- Detalles del autor, fecha de publicación y categoría -->
								<p>Publicado por <b><?php echo $row['auther']; ?></b> el <b><?php echo date('jS M Y H:i:s', strtotime($row['post_date'])); ?></b> en 
								<b><a style="color: #fff;" href="buscador.php?cat=<?php echo $row['catinfo']; ?>"><?php echo $row['catinfo']; ?></a></b></p>
							    
							    <!-- Descripción del post -->
							    <p><a style="color: #fff;" href="buscador.php?cat=<?php echo $row['catinfo']; ?>"><?php echo $row['description']; ?></a></p>
							</a>
						</div>               
					</div>
				</div>
			    <?php
			    $select++; // Incrementa el contador para alternar el color del panel
			}
		}

?>
	</div><!--/.row-->

<?php
	// Llama a la función que muestra el pie de página
	at_bottom();
?>
