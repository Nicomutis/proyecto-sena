<?php
	// Incluye las funciones necesarias desde 'funs.php'
	require_once('funs.php');
	
	// Inicia la sesión del usuario
	session_start();

	// Verifica si el usuario tiene una sesión activa
	check_session();

	// Obtiene el nombre de usuario de la sesión actual
	$session_name = $_SESSION['username'];

	// Crea un array para almacenar los datos del miembro
	$row = array();

	// Recupera los datos del miembro actual basándose en el nombre de usuario
	$row = get_member_data($session_name);

	// Asigna los datos del miembro a variables individuales
	$id = $row['id'];
	$name = $row['name'];
	$role = $row['role'];  // Rol del miembro (puede influir en los permisos)
	$pic = $row['pic'];    // Foto del miembro
	$last_login = $row['last_login'];

	// Formatea la fecha de último inicio de sesión
	$last_login = date('jS M Y H:i', strtotime($last_login));

	// Obtiene información adicional sobre los miembros y sesiones
	$total_members = get_all_status();
	$core_members = get_vip_status();
	$total_sessions = total_sessions();
	$completed_sessions = completed_sessions();

	// Inicializa la página con los datos del miembro
	starter($id, $name, $role, $pic, $last_login, $total_members, $core_members, $total_sessions, $completed_sessions);
?>
	
	<!-- Navegación de breadcrumbs para que el usuario sepa dónde está -->
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="home.php"><i class="fa fa-home" aria-hidden="true"></i></a></li> <!-- Enlace a la página de inicio -->
			<li><a href="blog-home.php">Blog</a></li> <!-- Enlace a la página principal del blog -->
			<li class="active">Nuevo Post</li> <!-- Página actual: Nuevo Post -->
		</ol>
	</div><!--/.row-->

	<!-- Título de la página: Nuevo Post en el Blog -->
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Nuevo Post en el Blog</h1>
		</div>
	</div><!--/.row-->
	
	<!-- Muestra los posibles errores al crear un nuevo post -->
	<div class="row">
		<div class="error">
			<?php new_post(); ?> <!-- Función que gestiona la creación del nuevo post -->
		</div>

		<!-- Formulario para la creación de un nuevo post -->
		<div class="col-lg-12">
			<form class="form-signin" method="post" action="">
			
			<!-- Columna para el título, descripción y categoría del post -->
			<div class="col-lg-4">
				<label for="postTitle">Título del Post</label> 
				<input type="text" name="postTitle" placeholder="Título del Post" class="form-control" required autofocus> <!-- Campo para el título del post -->
				<br>

				<label for="description">Descripción del Post</label> 
				<textarea name="description" rows="7" cols="60" maxlength="250" placeholder="Descripción del Post" id="description" class="form-control space" required></textarea> <!-- Campo para la descripción del post -->
				<br>

				<label for="content">Seleccionar Categoría del Post</label><br> 
				<select class="form-control" name="cats"> <!-- Desplegable para seleccionar la categoría del post -->
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

			<!-- Columna para el contenido del post -->
			<div class="col-lg-8">
				<label for="content">Contenido del Post</label> 
				<textarea name="content" placeholder="Contenido del Post" id="content" class="form-control space" required></textarea> <!-- Campo para escribir el contenido del post -->
				
				<!-- Botón para publicar el post -->
				<div class="text-center">
					<button class="btn btn-lg btn-primary" name="publish" type="submit" id="publish">Publicar Post</button>
				</div>
			</div>			
			</form>
		</div>
	</div><!--/.row-->

	<!-- Script para inicializar el editor de texto Summernote en el campo de contenido -->
	<script>
	$(document).ready(function() {
		// Inicializa el editor Summernote con una altura de 450 píxeles
		$('#content').summernote({
			height: 450,
			// Función para cargar imágenes dentro del editor
			onImageUpload:function(files, editor, welEditable) {
				sendFile(files[0], editor, welEditable);
			}
		});

		// Función que gestiona la subida de archivos al servidor
		function sendFile(file, editor, welEditable) {
			data = new FormData();
			data.append("file", file);

			// Petición AJAX para subir la imagen y luego insertarla en el editor
			$.ajax({
				data: data,
				type: "POST",
				url: 'summer-upload.php',
				cache: false,
				contentType: false,
				processData: false,
				success: function(url) {
					$('#content').summernote('editor.insertImage', url); // Inserta la imagen en el editor
				}
			});
		} 
	});
	</script>

	<!-- Incluye el CSS y JS de Summernote desde un CDN -->
	<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" rel="stylesheet">
	<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js"></script>

<?php
	// Función que añade el pie de página
	at_bottom();
?>
