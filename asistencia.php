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
?>
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="home.php"><i class="fa fa-home" aria-hidden="true"></i></a></li>
			<li class="active">Asistencia</li> 
		</ol>
	</div><!--/.row-->

	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Sección de Asistencia</h1> 
		</div>
	</div><!--/.row-->

	<div class="row">
		<div class="panel">
			<div class="panel-body tabs">
				<div class="col-lg-3">
					<div class="panel-header">
						<h3 class="text-center">Seleccionar Sesión</h3> 
						<br>
						<ul class="nav nav-pills nav-stacked">
						<?php
							global $con;
							$query = "SELECT * FROM sessions";
							$result = mysqli_query($con,$query);
							$rows = mysqli_affected_rows($con);
							
							while ($row = mysqli_fetch_assoc($result))
							{
								echo '<li><a href="#'.$row['session_id'].'" data-toggle="pill">'.date('jS M Y H:i', strtotime($row['session_date'])).'</a></li>';
							}
						?>
						</ul>
					</div>
				</div>
				<div class="panel-body">
					<div class="col-lg-9">
						<div class="tab-content">
							<div id="tab-start" class="tab-pane fade in active">
								<div class="col-lg-6">
									<div class="panel panel-teal">
										<div class="panel-heading">
											Asistencia por Sesión 
										</div>
										<div class="panel-body">
											<p><i>Elige la fecha de la sesión desde el lado izquierdo para ver la asistencia de esa sesión específica.</i></p> 
										</div>
									</div>
								</div>
							</div>
							<?php
								global $con;
								$query = "SELECT * FROM sessions";
								$result = mysqli_query($con,$query);
								$rows = mysqli_affected_rows($con);

								while ($row = mysqli_fetch_assoc($result))
								{
									echo '<div id="'.$row['session_id'].'" class="tab-pane fade">
											<h3 class="text-center">Asistencia para '.date('jS M Y H:i', strtotime($row['session_date'])).'</h3><br>'; 
										attendance($row['session_id'],$role);
									echo '</div>';
								}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div><!--/.row-->
<?php
	at_bottom();
?>
