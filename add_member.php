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
	
	starter($id,$name,$role,$pic,$last_login,$total_members,$core_members,$total_sessions,$completed_sessions);

	if($role != 'President')
	{
		echo '<div class="text-center alert bg-warning col-md-offset-4 col-md-4"><p><b>Acceso Prohibido</b></p></div>'; 
		echo '<script>setTimeout(function () { window.location.href = "home.php";}, 1000);</script>';
		exit();
	}
?>
			
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="home.php"><i class="fa fa-home" aria-hidden="true"></i></a></li>
			<li><a href="manage_members.php">Miembros</a></li> 
			<li class="active">Agregar Nuevo Miembro</li> 
		</ol>
	</div><!--/.row-->

	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Agregar Nuevo Miembro</h1> 
		</div>
	</div><!--/.row-->

	<div class="row">
		<div class="error">
			<?php add_member($role); ?>
		</div>
		<div class="col-lg-offset-2 col-lg-6">
			<form class="form-signin" method="post" action="">
				<label for="name">Nombre</label> 
				<input type="text" name="name" placeholder="Nombre" id="name" class="form-control" require><br>
				<label for="name">Correo Electrónico</label> 
				<input type="email" name="email" placeholder="Correo Electrónico" id="email" class="form-control" require><br>
				<label for="name">Nombre de Usuario</label> 
				<input type="text" name="username" placeholder="nombre de usuario" id="username" class="form-control"><br>
				<label for="name">Contraseña</label> 
				<input type="password" name="password" placeholder="contraseña" id="password" class="form-control"><br><br>
				<?php if($role == 'President')
				{
					echo '<label for="name">Rol</label> 
					<select class="form-control" name="role">
						<option>SELECCIONAR</option> 
    					<option name="Member" value="Member">Miembro</option> 
						<option name="Media-Marketing" value="Media Marketing">Medios y Marketing</option> 
						<option name="Admin Logistics" value="Admin Logistics">Logística Administrativa</option> 
						<option name="Member Management" value="Member Management">Gestión de Miembros</option> 
						<option name="Technical" value="Technical">Técnico</option> 
						<option name="President" value="President">Presidente</option> 
					</select><br>';
				} ?>
				<button class="btn btn-primary" name="add_member" type="submit" id="login">Agregar</button> 
				&nbsp;&nbsp;
				<a href="manage_members.php" class="btn btn-default" id="login">Cancelar</a> 
			</form>
		</div>
	</div><!--/.row-->
	<script>
	$(document).ready(function()
	{
		 $("#dtBox").DateTimePicker();
	});
	</script>
<link rel="stylesheet" type="text/css" href="css/DateTimePicker.min.css" />
<script type="text/javascript" src="js/DateTimePicker.min.js"></script>
<?php
	at_bottom();
?>
