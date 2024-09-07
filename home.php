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
	$all_posts = get_all_posts(); // Obtiene el número total de publicaciones
	
	starter($id,$name,$role,$pic,$last_login,$total_members,$core_members,$total_sessions,$completed_sessions); // Inicializa la página con los datos del miembro
?>
			
	<div class="row">
		<ol class="breadcrumb"> <!-- Muestra la ruta de navegación -->
			<li><a href="#"><i class="fa fa-home" aria-hidden="true"></i></a></li> <!-- Enlace a la página de inicio -->
			<li class="active">Dashboard</li> <!-- Indica que la página actual es el Dashboard -->
		</ol>
	</div><!--/.row-->

	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Dashboard</h1> <!-- Título principal de la página -->
		</div>
	</div><!--/.row-->

	<div class="row">
		<div class="col-xs-12 col-md-6 col-lg-3"> <!-- Panel para mostrar el número total de miembros -->
			<div class="panel panel-blue panel-widget">
				<div class="row no-padding">
					<div class="col-sm-3 col-lg-5 widget-left">
						<i class="fa fa-user fa-4x" aria-hidden="true"></i> <!-- Icono de usuario -->
					</div>
					<div class="col-sm-9 col-lg-7 widget-right">
						<div class="large"><?php echo $total_members; ?></div> <!-- Muestra el número total de miembros -->
						<div class="text-muted">Miembros</div> <!-- Etiqueta para el total de miembros -->
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-md-6 col-lg-3"> <!-- Panel para mostrar el número de miembros clave -->
			<div class="panel panel-orange panel-widget">
				<div class="row no-padding">
					<div class="col-sm-3 col-lg-5 widget-left">
						<i class="fa fa-user-secret fa-4x" aria-hidden="true"></i> <!-- Icono de miembro clave -->
					</div>
					<div class="col-sm-9 col-lg-7 widget-right">
						<div class="large"><?php echo $core_members; ?></div> <!-- Muestra el número de miembros clave -->
						<div class="text-muted">Miembros Clave</div> <!-- Etiqueta para los miembros clave -->
					</div>
				</div>
			</div>
		</div>

		<a href="cronograma.php"> <!-- Enlace a la página de cronograma -->
		<div class="col-xs-12 col-md-6 col-lg-3"> <!-- Panel para mostrar el número total de sesiones -->
			<div class="panel panel-teal panel-widget">
				<div class="row no-padding">
					<div class="col-sm-3 col-lg-5 widget-left">
						<i class="fa fa-calendar fa-4x" aria-hidden="true"></i> <!-- Icono de calendario -->
					</div>
					<div class="col-sm-9 col-lg-7 widget-right">
						<div class="large"><?php echo $total_sessions; ?></div> <!-- Muestra el número total de sesiones -->
						<div class="text-muted">Sesiones</div> <!-- Etiqueta para el total de sesiones -->
					</div>
				</div>
			</div>
		</div>
		</a>
		
		<a href="blog-home.php"> <!-- Enlace a la página del blog -->
		<div class="col-xs-12 col-md-6 col-lg-3"> <!-- Panel para mostrar el número total de publicaciones -->
			<div class="panel panel-red panel-widget">
				<div class="row no-padding">
					<div class="col-sm-3 col-lg-5 widget-left">
						<i class="fa fa-pencil fa-4x" aria-hidden="true"></i> <!-- Icono de lápiz para publicaciones -->
					</div>
					<div class="col-sm-9 col-lg-7 widget-right">
						<div class="large"><?php echo $all_posts; ?></div> <!-- Muestra el número total de publicaciones -->
						<div class="text-muted">Publicaciones</div> <!-- Etiqueta para el total de publicaciones -->
					</div>
				</div>
			</div>
		</div>
		</a>
	</div><!--/.row-->

	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Publicaciones Recientes del Blog</h1> <!-- Título para la sección de publicaciones recientes -->
		</div>
	</div><!--/.row-->

	<div class="row">
		<div class="col-lg-12">
			<?php show_home_posts(); ?> <!-- Muestra las publicaciones recientes del blog -->
		</div>
	</div><!--/.row-->

	<script>
		$(document).ready(function()
		{
			// Maneja el clic en los enlaces de menú
			$('.menu').on("click",".menu",function(e){ 
  			e.preventDefault(); // Cancela el comportamiento por defecto del clic
  			var page = $(this).attr('href'); // Obtiene la URL del enlace
  			$('.menu').load(page); // Carga el contenido de la URL en el elemento con clase 'menu'
			});
		});
	</script>
<?php
	at_bottom(); // Función que se ejecuta al final de la página
?>
