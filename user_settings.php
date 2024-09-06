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
	$user_id = $_GET['user_id'];
	$last_login = $row['last_login'];
	$last_login = date('jS M Y H:i', strtotime($last_login));
	$total_members = get_all_status();
	$core_members = get_vip_status();
	$total_sessions = total_sessions();
	$completed_sessions = completed_sessions();
	
	starter($id,$name,$role,$pic,$last_login,$total_members,$core_members,$total_sessions,$completed_sessions);
?>
			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="home.php"><i class="fa fa-home" aria-hidden="true"></i></a></li>
				<li class="active">Configuración de Usuario</li> 
			</ol>
		</div><!--/.row-->

		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Configuración de Usuario</h1> 
			</div>
		</div><!--/.row-->
		
		<div class="row">
			<div class="error">
				<?php update_settings($id); ?>
			</div>
			<div class="col-lg-offset-2 col-lg-6">
				<div class="panel panel-primary">
					<div class="panel-heading">
						Detalles del Perfil 
					</div>
				<div class="panel-body">
				<form class="form-signin" method="post" action="">
					<label for="name">Nombre</label> 
					<input type="text" value="<?php echo $name; ?>" name="name" placeholder="Nombre de usuario" id="username" class="form-control" require> 
				</div>
				<div class="panel panel-danger">
					<div class="panel-heading">
						Seguridad 
					</div>
					<div class="panel-body">
					<label for="name">Contraseña antigua</label> 
					<input type="password" name="old_pwd" placeholder="Contraseña antigua" id="password" class="form-control"> 
					<label for="name">Nueva contraseña</label> 
					<input type="password" name="new_pwd" placeholder="Nueva contraseña" id="password" class="form-control"><br/> 
					</div>
					<div class="panel-footer">
					<button class="btn btn-primary" name="update_settings" type="submit" id="login">Guardar</button>&nbsp;&nbsp; 
					<a href="home.php" class="btn btn-default" id="login">Cancelar</a> 
					</div>
				</form>
			</div>
		</div><!--/.row-->
<?php
	at_bottom();
?>
