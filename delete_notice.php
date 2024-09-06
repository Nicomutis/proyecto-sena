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
	$notice_id = $_GET['notice_id'];
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
			<li><a href="notice.php">Aviso</a></li> 
			<li class="active">Eliminar Aviso</li> 
		</ol>
	</div><!--/.row-->

	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Eliminar Aviso</h1> 
		</div>
	</div><!--/.row-->

	<div class="row">
		<div class="error">
			<?php delete_notice($notice_id,$role); ?>
		</div>
		<div class="col-lg-offset-2 col-lg-6">
			<div class="panel panel-danger">
				<div class="panel-heading">
					Advertencia 
				</div>
				<div class="panel-body">
					<form class="" method="post" action="">
						<label for="ask">¿Realmente deseas eliminar este aviso?</label> 
						<br>
						<div class="panel-footer">
							<div class="pull-right">
								<button class="btn btn-danger" name="yes" type="submit" id="login">Sí</button> 
								&nbsp;&nbsp;
								<a href="notice.php" class="btn btn-default" id="login">No, volver</a> 
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div><!--/.row-->
<?php
	at_bottom();
?>
