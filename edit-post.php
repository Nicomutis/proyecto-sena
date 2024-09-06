<?php
	require_once('funs.php');
	$post_id = $_GET['id'];
	session_start();
	check_session();
	$session_name = $_SESSION['username'];
	$row = array();
	$row = get_member_data($session_name);
	$id = $row['id'];
	$name = $row['name'];
	$role = $row['role'];
	$pic = $row['pic'];
	$last_login = $row['last_login'];
	$last_login = date('jS M Y H:i', strtotime($last_login));
	$total_members = get_all_status();
	$core_members = get_vip_status();
	$total_sessions = total_sessions();
	$completed_sessions = completed_sessions();
	
	starter($id,$name,$role,$pic,$last_login,$total_members,$core_members,$total_sessions,$completed_sessions);
?>
<?php	

	$query = "SELECT * FROM blog_posts WHERE id = '$post_id'";
	$result = mysqli_query($con,$query);

	if (mysqli_num_rows($result) > 0)
	{
		while($row = mysqli_fetch_assoc($result))
		{
            $postTitle = $row['postTitle'];
            $description = $row['description'];
            $content = $row['content'];
            $catinfo = $row['catinfo'];                    
		}
	}
	else
	{
		echo '<div class="text-center alert bg-danger col-md-offset-4 col-md-4" role="alert"><span>Error, la recuperación de la información de la publicación falló, inténtalo de nuevo</span></div>'; 
		die();
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
			<?php edit_post($post_id); ?>
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
    				<option name="Uncategorised" value="Uncategorised">Sin Categoría</option> 
				   	<option name="Technology" value="Technology">Tecnología</option> 
				  	<option name="Lifestyle" value="Lifestyle">Estilo de Vida</option> 
				   	<option name="News" value="News">Noticias</option> 
				   	<option name="Education" value="Education">Educación</option> 
				   	<option name="Nature" value="Nature">Naturaleza</option> 
				   	<option name="Health" value="Health">Salud</option> 
				   	<option name="Programming" value="Programming">Programación</option> 
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
	at_bottom();
?>
