<?php
	require_once('funs.php');
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
	
	starter($id, $name, $role, $pic, $last_login, $total_members, $core_members, $total_sessions, $completed_sessions);
?>
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="home.php"><i class="fa fa-home" aria-hidden="true"></i></a></li>
			<li><a href="blog-home.php">Blog</a></li>
			<li class="active">Nuevo Post</li> 
		</ol>
	</div><!--/.row-->

	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Nuevo Post en el Blog</h1> 
		</div>
	</div><!--/.row-->
	
	<div class="row">
		<div class="error">
			<?php new_post(); ?>
		</div>
		<div class="col-lg-12">
			<form class="form-signin" method="post" action="">
			<div class="col-lg-4">
				<label for="postTitle">Título del Post</label> 
				<input type="text" name="postTitle" placeholder="Título del Post" class="form-control" required autofocus> 
				<br>
				<label for="description">Descripción del Post</label> 
				<textarea name="description" rows="7" cols="60" maxlength="250" placeholder="Descripción del Post" id="description" class="form-control space" required></textarea> 
				<br>
				<label for="content">Seleccionar Categoría del Post</label><br> 
				<select class="form-control" name="cats">
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
					<label for="content">Contenido del Post</label> 
					<textarea name="content" placeholder="Contenido del Post" id="content" class="form-control space" required></textarea> 
					<div class="text-center">
					<button class="btn btn-lg btn-primary" name="publish" type="submit" id="publish">Publicar Post</button> 
					</div>
			</div>			
			</form>
	</div>
</div><!--/.row-->

<script>
$(document).ready(function() {
          $('#content').summernote({
                height: 450,   
                onImageUpload:function(files, editor, welEditable) {
                  sendFile(files[0], editor, welEditable);
              }

          });
          function sendFile(file, editor, welEditable) {
              data = new FormData();
              data.append("file", file);
              $.ajax({
                  data: data,
                  type: "POST",
                  url: 'summer-upload.php',
                  cache: false,
                  contentType: false,
                  processData: false,
                  success: function(url) {
                     $('#content').summernote('editor.insertImage', url);
                  }
              });
          } 
      });
</script>
<!-- include summernote css/js-->
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js"></script>
<?php
	at_bottom();
?>
