<?php
require_once('dbconfig.php'); // Incluye la configuración de la base de datos
global $con; // Define la variable global de conexión a la base de datos

/*******************************
 * Función para iniciar sesión en el panel.
 *******************************/

function login()
{
	global $con; // Accede a la variable global de conexión
	if (isset($_POST['submit'])) // Verifica si se envió el formulario
	{
		$username = $_POST['username']; // Obtiene el nombre de usuario del formulario
		$username = stripslashes($username); // Elimina barras invertidas del nombre de usuario
		$password = $_POST['password']; // Obtiene la contraseña del formulario
		$password = stripslashes($password); // Elimina barras invertidas de la contraseña

		// Consulta para verificar si el nombre de usuario y la contraseña coinciden
		$query = "SELECT * from userinfo where username ='$username' AND password ='$password'";
		$result = mysqli_query($con,$query); // Ejecuta la consulta
		$rows = mysqli_affected_rows($con); // Obtiene el número de filas afectadas

		if($rows == 1) // Si se encontró un usuario con las credenciales proporcionadas
		{
			$_SESSION['username'] = $username; // Guarda el nombre de usuario en la sesión
			while($row = mysqli_fetch_assoc($result)) // Itera sobre el resultado de la consulta
			{
				$last_login = $row['currunt_login']; // Obtiene la última fecha de inicio de sesión

				// Actualiza la última fecha de inicio de sesión y establece la fecha actual como la nueva fecha de inicio
				$query = "UPDATE userinfo SET last_login='$last_login', currunt_login=NOW() WHERE username='$username'";
				mysqli_query($con,$query); // Ejecuta la actualización
			}

			// Muestra un mensaje de bienvenida y redirige al usuario a la página principal después de 1 segundo
			echo '<div class="text-center alert bg-success col-md-offset-4 col-md-4" role="alert"><span>Bienvenido de vuelta, <b>'.$_SESSION['username'].'</b>!</span></div>';
			echo '<script>setTimeout(function () { window.location.href = "home.php";}, 1000);</script>';
		}
		else
		{
			// Muestra un mensaje de error si las credenciales no son correctas
			echo '<div class="text-center alert bg-danger col-md-offset-4 col-md-4" role="alert"><span>Error <b>'.$username.'</b>, Intentalo de nuevo!</span></div>';
		}	
	}

	return false; // Devuelve false al finalizar
}

/*******************************
 * Verifica si el usuario está autorizado.
 *******************************/

function check_session()
{
	if( !isset($_SESSION["username"]) ) // Si no hay un nombre de usuario en la sesión
	{
    	header("location:index.php"); // Redirige al usuario a la página de inicio de sesión
    	exit(); // Detiene la ejecución del script
	}	
    return false; // Devuelve false al finalizar
}

/*******************************
 * Carga todos los datos del usuario de la sesión.
 *******************************/

function get_member_data($session_name)
{
	global $con; // Accede a la variable global de conexión
	// Consulta para obtener los datos del usuario basándose en el nombre de usuario
	$query = "SELECT * FROM userinfo WHERE username='$session_name'";
	$result = mysqli_query($con,$query); // Ejecuta la consulta
	$rows = mysqli_affected_rows($con); // Obtiene el número de filas afectadas
	
	if($rows == 1) // Si se encontró un usuario con el nombre proporcionado
	{
		$row = mysqli_fetch_assoc($result); // Obtiene los datos del usuario
	}
	else
		echo 'error while retriving data'; // Muestra un mensaje de error si no se encuentran datos
	return $row; // Devuelve los datos del usuario
}

/*******************************
 * Carga todos los datos necesarios para la configuración del usuario.
 *******************************/

function user_setting($user_id)
{
	global $con; // Accede a la variable global de conexión
	$user_id = $user_id; // Reutiliza el ID del usuario
	// Consulta para obtener los datos del usuario basado en su ID
	$query = "SELECT * FROM userinfo where id='$user_id'";
	$result = mysqli_query($con,$query); // Ejecuta la consulta
	$rows = mysqli_affected_rows($con); // Obtiene el número de filas afectadas
	
	if($rows == 1) // Si se encontró un usuario con el ID proporcionado
	{
		$row = mysqli_fetch_assoc($result); // Obtiene los datos del usuario
	}
	else
		echo 'error while retriving data'; // Muestra un mensaje de error si no se encuentran datos
	return $row; // Devuelve los datos del usuario
}

/*******************************
 * Actualiza el panel de configuración del usuario.
 *******************************/

function update_settings($id)
{
	global $con; // Accede a la variable global de conexión

	// Consulta para obtener los datos del usuario basado en su ID
	$query = "SELECT * FROM userinfo where id='$id'";
	$result = mysqli_query($con,$query); // Ejecuta la consulta
	$rows = mysqli_affected_rows($con); // Obtiene el número de filas afectadas
	
	if($rows == 1) // Si se encontró un usuario con el ID proporcionado
	{
		while($row = mysqli_fetch_assoc($result)) // Itera sobre el resultado de la consulta
		{
			$table_pwd = $row['password']; // Obtiene la contraseña almacenada en la base de datos
		}
	}
	else
	{
		echo 'error while retriving table_pwd'; // Muestra un mensaje de error si no se puede obtener la contraseña
	}
	
	if (isset($_POST['update_settings'])) // Verifica si se envió el formulario de actualización
	{
		$name = $_POST['name']; // Obtiene el nuevo nombre del formulario
		$name = stripslashes($name); // Elimina barras invertidas del nombre
		$old_pwd = $_POST['old_pwd']; // Obtiene la contraseña antigua del formulario
		$old_pwd = stripslashes($old_pwd); // Elimina barras invertidas de la contraseña antigua
		$new_pwd = $_POST['new_pwd']; // Obtiene la nueva contraseña del formulario
		$new_pwd = stripslashes($new_pwd); // Elimina barras invertidas de la nueva contraseña

		if(!empty($_POST['old_pwd']) && !empty($_POST['new_pwd'])) // Verifica si se proporcionaron las contraseñas
		{
			if($old_pwd == $table_pwd) // Verifica si la contraseña antigua es correcta
			{
				// Actualiza el nombre y la contraseña del usuario en la base de datos
				$query = "UPDATE userinfo SET name='$name', password='$new_pwd' WHERE id='$id'";
				mysqli_query($con,$query); // Ejecuta la actualización
				$rows = mysqli_affected_rows($con); // Obtiene el número de filas afectadas
				if($rows == 1) // Si la actualización fue exitosa
				{
					echo '<div class="text-center alert bg-success col-md-offset-4 col-md-4"><span>Datos actualizados!</span></div>'; // Muestra un mensaje de éxito
					echo '<script>setTimeout(function () { window.location.href = "home.php";}, 1000);</script>'; // Redirige a la página principal después de 1 segundo
				}
				else
				{
					echo '<div class="text-center alert bg-danger col-md-offset-4 col-md-4"><span>Problema al actualizar el nombre y la contraseña.</span></div>'; // Muestra un mensaje de error si no se pudo actualizar
				}
			}
			else
			{
				echo '<div class="text-center alert bg-danger col-md-offset-4 col-md-4"><span>Verifica tu contraseña anterior e inténtalo de nuevo.</span></div>'; // Muestra un mensaje de error si la contraseña antigua es incorrecta
			}
		}
		else
		{
			// Si solo se proporciona el nombre, actualiza solo el nombre del usuario
			$query = "UPDATE userinfo SET name='$name' WHERE id='$id'";
			mysqli_query($con,$query); // Ejecuta la actualización
			$rows = mysqli_affected_rows($con); // Obtiene el número de filas afectadas
			if($rows == 1) // Si la actualización fue exitosa
			{
				echo '<div class="text-center alert bg-success col-md-offset-4 col-md-4"><span>Datos actualizados</span></div>'; // Muestra un mensaje de éxito
				echo '<script>setTimeout(function () { window.location.href = "home.php";}, 1000);</script>'; // Redirige a la página principal después de 1 segundo
			}
			else
			{
				echo '<div class="text-center alert bg-danger col-md-offset-4 col-md-4"><span>Problema al actualizar los datos.</span></div>'; // Muestra un mensaje de error si no se pudo actualizar
			}
		}
	}

	return false; // Devuelve false al finalizar
}

/*******************************
 * Calcula el número total de miembros.
 *******************************/

 function get_all_status()
 {
	 global $con; // Accede a la variable global de conexión
	 $query = "SELECT * FROM userinfo"; // Consulta para seleccionar todos los miembros
	 $result = mysqli_query($con,$query); // Ejecuta la consulta
	 $rows = mysqli_affected_rows($con); // Obtiene el número de filas afectadas
	 return $rows; // Devuelve el número total de miembros
 }
 
 /*******************************
  * Calcula el número total de publicaciones en el blog.
  *******************************/
 
 function get_all_posts()
 {
	 global $con; // Accede a la variable global de conexión
	 $query = "SELECT * FROM blog_posts"; // Consulta para seleccionar todas las publicaciones del blog
	 $result = mysqli_query($con,$query); // Ejecuta la consulta
	 $rows = mysqli_affected_rows($con); // Obtiene el número de filas afectadas
	 return $rows; // Devuelve el número total de publicaciones en el blog
 }
 
 /*******************************
  * Calcula el número total de miembros CORE (VIP).
  *******************************/
 
 function get_vip_status()
 {
	 global $con; // Accede a la variable global de conexión
	 $query = "SELECT * FROM userinfo where role NOT LIKE 'Member'"; // Consulta para seleccionar miembros que no tengan el rol de 'Member'
	 $result = mysqli_query($con,$query); // Ejecuta la consulta
	 $rows = mysqli_affected_rows($con); // Obtiene el número de filas afectadas
	 return $rows; // Devuelve el número total de miembros CORE (VIP)
 }
 
 /*******************************
  * Calcula el número total de sesiones.
  *******************************/
 
 function total_sessions()
 {
	 global $con; // Accede a la variable global de conexión
	 $query = "SELECT * FROM sessions"; // Consulta para seleccionar todas las sesiones
	 $result = mysqli_query($con,$query); // Ejecuta la consulta
	 $rows = mysqli_affected_rows($con); // Obtiene el número de filas afectadas
	 return $rows; // Devuelve el número total de sesiones
 }
 
 /*******************************
  * Calcula el número total de sesiones completadas.
  *******************************/
 
 function completed_sessions()
 {
	 global $con; // Accede a la variable global de conexión
	 $query = "SELECT * FROM sessions"; // Consulta para seleccionar todas las sesiones
	 $result = mysqli_query($con,$query); // Ejecuta la consulta
	 $rows = mysqli_affected_rows($con); // Obtiene el número de filas afectadas
	 $completed_sessions = 0; // Inicializa el contador de sesiones completadas
	 if($rows == 0) // Si no hay sesiones
	 {
		 $completed_sessions = 0; // No hay sesiones completadas
	 }
	 else
	 {
		 while($row = mysqli_fetch_assoc($result)) // Itera sobre el resultado de la consulta
		 {
			 if(time() >= strtotime($row['session_date'])) // Verifica si la fecha actual es mayor o igual a la fecha de la sesión
			 {
				 $completed_sessions++; // Incrementa el contador de sesiones completadas
			 }
		 }
	 }
	 return $completed_sessions; // Devuelve el número total de sesiones completadas
 }
 
 /*******************************
  * Recupera todos los datos de los miembros en formato de tabla.
  *******************************/
 
 function all_member_table($role)
 {
	 global $con; // Accede a la variable global de conexión
	 $role = $role; // Reutiliza el rol proporcionado
	 $query = "SELECT * FROM userinfo"; // Consulta para seleccionar todos los miembros
	 $result = mysqli_query($con,$query); // Ejecuta la consulta
	 $rows = mysqli_affected_rows($con); // Obtiene el número de filas afectadas
	 ?>
	 <table class="table table-hover table-responsive"> <!-- Comienza la tabla HTML -->
			 <tr class="alert-info"> <!-- Encabezados de la tabla -->
				 <th><h4>Id</h4></th>
				 <th><h4>Nombre</h4></th>
				 <th><h4>Nombre de usuario</h4></th>
				 <th><h4>Void</h4></th>
				 <th><h4>Email</h4></th>
				 <th><h4>Rol</h4></th>
				 <th><h4>Editar</h4></th>
			 </tr>
	 <?php
	 while ($row = mysqli_fetch_assoc($result)) // Itera sobre el resultado de la consulta
	 {
		 if(empty($row['email'])) // Si el campo de correo electrónico está vacío
		 {
			 $row['email'] = '-'; // Asigna un guion como valor por defecto
		 }
 
		 if(empty($row['dob'])) // Si el campo de fecha de nacimiento está vacío
		 {
			 $row['dob'] = '-'; // Asigna un guion como valor por defecto
		 }
		 echo '<tr>
			 <td>'.$row['id'].'</td>
			 <td>'.$row['name'].'</td>
			 <td>'.$row['username'].'</td>
			 <td>'.$row['dob'].'</td>
			 <td>'.$row['email'].'</td>
			 <td>'.$row['role'].'</td>
			 <td>';
			 
			 if($role == "President") // Si el rol del usuario es 'President'
			 {
				 echo '<a href="edit_member.php?mem_id='.$row['id'].'">Editar</a> | <a href="delete_member.php?mem_id='.$row['id'].'">Remover</a>'; // Muestra enlaces para editar o eliminar el miembro
			 }
			 else
			 {
				 echo '-'; // Muestra un guion si el rol no es 'President'
			 }
		 
		 echo '</td></tr>';
	 }
	 echo '</table>'; // Cierra la tabla HTML
	 return false; // Devuelve false al finalizar
 }
 
/*******************************
 * Agregar un nuevo miembro.
 *******************************/

 function add_member($role)
 {
	 global $con; // Accede a la variable global de conexión
	 $role = $role; // Asigna el rol proporcionado a la variable local
 
	 if (isset($_POST['add_member'])) // Verifica si se ha enviado el formulario para agregar un miembro
	 {
		 $name = $_POST['name']; // Obtiene el nombre del formulario
		 $name = stripslashes($name); // Elimina las barras invertidas del nombre
		 $email = $_POST['email']; // Obtiene el correo electrónico del formulario
		 $email = stripslashes($email); // Elimina las barras invertidas del correo electrónico
		 $username = $_POST['username']; // Obtiene el nombre de usuario del formulario
		 $username = stripslashes($username); // Elimina las barras invertidas del nombre de usuario
		 $password = $_POST['password']; // Obtiene la contraseña del formulario
		 $password = stripslashes($password); // Elimina las barras invertidas de la contraseña
		 $pic = 'imgs/user.png'; // Ruta por defecto para la imagen de perfil
 
		 if($role == 'President') // Si el rol es 'President'
		 {
			 $select_role = $_POST["role"]; // Obtiene el rol seleccionado del formulario
		 }
		 else
		 {
			 $select_role = "-"; // Asigna un valor por defecto si el rol no es 'President'
		 }
 
		 $query = "INSERT into userinfo (name, email, username, password, role, pic) VALUES ('$name', '$email', '$username', '$password', '$select_role', '$pic')"; // Consulta para insertar el nuevo miembro en la base de datos
		 $result = mysqli_query($con,$query); // Ejecuta la consulta
		 $rows = mysqli_affected_rows($con); // Obtiene el número de filas afectadas
		 if($rows == 1) // Si se ha agregado el miembro correctamente
		 {
			 echo '<div class="text-center alert alert-success col-md-offset-4 col-md-4"><p><b>¡Éxito! Miembro agregado.</b></p></div>'; // Mensaje de éxito
			 echo '<script>setTimeout(function () { window.location.href = "gestion_miembros.php";}, 1000);</script>'; // Redirige a la página de gestión de miembros después de 1 segundo
		 }
		 else
		 {
			 echo '<div class="text-center alert alert-danger col-md-offset-4 col-md-4"><p><b>Error al agregar al miembro. Inténtalo de nuevo.</b></p></div>'; // Mensaje de error
		 }
	 }
 
	 return false; // Devuelve false al finalizar
 }
 
 /*******************************
  * Editar la información del miembro.
  *******************************/
 
 function edit_member($role, $mem_id)
 {
	 global $con; // Accede a la variable global de conexión
	 $role = $role; // Asigna el rol proporcionado a la variable local
	 $mem_id = $mem_id; // Asigna el ID del miembro proporcionado a la variable local
 
	 if (isset($_POST['edit_member'])) // Verifica si se ha enviado el formulario para editar un miembro
	 {
		 $edit_name = $_POST['name']; // Obtiene el nuevo nombre del formulario
		 $edit_name = stripslashes($edit_name); // Elimina las barras invertidas del nuevo nombre
		 $edit_email = $_POST['email']; // Obtiene el nuevo correo electrónico del formulario
		 $edit_email = stripslashes($edit_email); // Elimina las barras invertidas del nuevo correo electrónico
		 $edit_username = $_POST['username']; // Obtiene el nuevo nombre de usuario del formulario
		 $edit_username = stripslashes($edit_username); // Elimina las barras invertidas del nuevo nombre de usuario
		 
		 if($role == 'President') // Si el rol es 'President'
		 {
			 $edit_select_role = $_POST['role']; // Obtiene el nuevo rol del formulario
		 }
		 else
		 {
			 $edit_select_role = ""; // Deja el rol vacío si no es 'President'
		 }
 
		 if(empty($edit_select_role)) // Si el rol está vacío
		 {
			 $query = "UPDATE userinfo SET name='$edit_name', email='$edit_email', username='$edit_username' WHERE id='$mem_id'"; // Consulta para actualizar solo el nombre, correo electrónico y nombre de usuario
		 }
		 else
		 {
			 $query = "UPDATE userinfo SET name='$edit_name', email='$edit_email', username='$edit_username', role='$edit_select_role' WHERE id='$mem_id'"; // Consulta para actualizar también el rol
		 }
		 
		 $result = mysqli_query($con,$query); // Ejecuta la consulta
		 $rows = mysqli_affected_rows($con); // Obtiene el número de filas afectadas
		 if($rows == 1) // Si la información se ha actualizado correctamente
		 {
			 echo '<div class="text-center alert alert-success col-md-offset-4 col-md-4"><p><b>¡Éxito! Información actualizada.</b></p></div>'; // Mensaje de éxito
			 echo '<script>setTimeout(function () { window.location.href = "gestion_miembros.php";}, 1000);</script>'; // Redirige a la página de gestión de miembros después de 1 segundo
		 }
		 else
		 {
			 echo '<div class="text-center alert alert-danger col-md-offset-4 col-md-4"><p><b>Error al actualizar la información. Inténtalo de nuevo.</b></p></div>'; // Mensaje de error
		 }
	 }
 
	 return false; // Devuelve false al finalizar
 }
 
 /*******************************
  * Eliminar el registro de un miembro.
  *******************************/
 
 function delete_member($mem_id, $role)
 {
	 global $con; // Accede a la variable global de conexión
	 $mem_id = $mem_id; // Asigna el ID del miembro proporcionado a la variable local
	 $role = $role; // Asigna el rol proporcionado a la variable local
 
	 if(isset($_POST['yes'])) // Verifica si se ha confirmado la eliminación del miembro
	 {
		 $query = "DELETE from userinfo where id='$mem_id'"; // Consulta para eliminar el miembro con el ID proporcionado
		 $result = mysqli_query($con,$query); // Ejecuta la consulta
		 $rows = mysqli_affected_rows($con); // Obtiene el número de filas afectadas
		 echo mysqli_error($con); // Muestra cualquier error de la consulta
		 if($rows == 1) // Si el miembro se ha eliminado correctamente
		 {
			 echo '<div class="text-center alert alert-success col-md-offset-4 col-md-4"><p><b>¡Éxito! Miembro eliminado.</b></p></div>'; // Mensaje de éxito
			 echo '<script>setTimeout(function () { window.location.href = "gestion_miembros.php";}, 1000);</script>'; // Redirige a la página de gestión de miembros después de 1 segundo
		 }
		 else
		 {
			 echo '<div class="text-center alert alert-danger col-md-offset-4 col-md-4"><p><b>Error al eliminar al miembro. Inténtalo de nuevo.</b></p></div>'; // Mensaje de error
		 }
	 }
	 
	 return false; // Devuelve false al finalizar
 } 

/*******************************
 * Función para olvidar la contraseña.
 *******************************/

 function forgot()
 {
	 global $con; // Accede a la variable global de conexión
	 $otp = mt_rand(111111, 999999); // Genera un código de verificación aleatorio de 6 dígitos
	 if(isset($_POST['send_code'])) // Verifica si se ha enviado el formulario para solicitar un código de recuperación
	 {
		 $email = $_POST['email']; // Obtiene el correo electrónico del formulario
		 $query = "SELECT * from userinfo where email='$email'"; // Consulta para verificar si el correo electrónico existe en la base de datos
		 $result = mysqli_query($con,$query); // Ejecuta la consulta
		 $rows = mysqli_affected_rows($con); // Obtiene el número de filas afectadas
		 if($rows == 1) // Si el correo electrónico está registrado
		 {
			 $query = "UPDATE userinfo SET otp='$otp' where email='$email'"; // Actualiza la base de datos con el nuevo código de verificación
			 $result = mysqli_query($con,$query); // Ejecuta la consulta de actualización
			 $rows = mysqli_affected_rows($con); // Obtiene el número de filas afectadas
			 if($rows == 1) // Si el código de verificación se ha actualizado correctamente
			 {
				 // Librería de correo de Pear
				 require_once "Mail.php"; // Incluye la librería de correo
				 $from = '<aguilaniko01@gmail.com>'; // Dirección de correo del remitente
				 $subject = 'Club - Código de Restablecimiento de Contraseña'; // Asunto del correo
				 $body = "Código: ".$otp; // Cuerpo del correo con el código de verificación
				 $headers = array(
					 'From' => $from,
					 'To' => $email,
					 'Subject' => $subject
				 );
				 $smtp = Mail::factory('smtp', array(
						 'host' => 'ssl://smtp.gmail.com', // Servidor SMTP
						 'port' => '465', // Puerto SMTP
						 'auth' => true, // Autenticación requerida
						 'username' => 'aguilaniko01@gmail.com', // Nombre de usuario SMTP
						 'password' => 'password' // Contraseña SMTP
					 ));
				 $mail = $smtp->send($to, $headers, $body); // Envía el correo
				 if (PEAR::isError($mail)) 
				 {
					 echo('<div class="text-center alert alert-danger col-md-offset-4 col-md-4"><p>' . $mail->getMessage() . '</p></div>'); // Mensaje de error si falla el envío del correo
				 } 
				 else 
				 {
					 echo('<div class="text-center alert alert-success col-md-offset-4 col-md-4"><p><b>Código de restablecimiento de contraseña enviado a '.$email.'. Revisa tu bandeja de entrada.</b></p></div>'); // Mensaje de éxito si el correo se envía correctamente
				 }
			 }
			 else
			 {
				 echo '<div class="text-center alert alert-danger col-md-offset-4 col-md-4"><p><b>Error al generar el código de verificación.</b></p></div>'; // Mensaje de error si no se puede actualizar el código
			 }
		 
		 }
		 else
		 {
			 echo '<div class="text-center alert alert-danger col-md-offset-4 col-md-4"><p><b>¡Correo electrónico inválido! Inténtalo de nuevo.</b></p></div>'; // Mensaje de error si el correo electrónico no está registrado
		 }
	 
	 }
	 
	 return false; // Devuelve false al finalizar
 }
 
 /*******************************
  * Mostrar todas las sesiones y eventos.
  *******************************/
 
 function show_events($role)
 {
	 global $con; // Accede a la variable global de conexión
	 $query = "SELECT * FROM sessions ORDER by session_date ASC"; // Consulta para obtener todas las sesiones ordenadas por fecha
	 $result = mysqli_query($con,$query); // Ejecuta la consulta
	 $rows = mysqli_affected_rows($con); // Obtiene el número de filas afectadas
 
	 if($rows == 0) // Si no hay eventos programados
	 {
		 echo '<div class="text-center alert alert-info col-md-offset-4 col-md-4"><p><b>¡Aún no hay eventos programados!</b></p></div>'; // Mensaje indicando que no hay eventos
	 }
	 
	 while($row = mysqli_fetch_assoc($result)) // Recorre cada fila del resultado
	 {
		 if(time() >= strtotime($row['session_date'])) // Si la fecha de la sesión ya ha pasado
		 {
			 $choose_css = "panel-red"; // Clase CSS para eventos pasados
		 }
		 else
		 {
			 $choose_css = "panel-teal"; // Clase CSS para eventos futuros
		 }
		 ?>
			 
		 <div class="col-md-4">
			 <div class="panel <?php echo $choose_css; ?>">
				 <div class="panel-heading dark-overlay"><?php echo $row['session_name']; ?></div>
					 <div class="panel-body">
						 <p>
						 <b>Fecha:</b> <small><?php echo date('jS M Y H:i', strtotime($row['session_date'])); ?></small><br>
						 <?php echo $row['session_details']; ?>
						 </p>
					 </div>
					 <?php
						 if($role == 'President') // Si el rol es 'President'
						 {
							 echo '<div class="panel-footer"><a class="btn btn-primary btn-sm" href="edit_event.php?event_id='.$row['session_id'].'">Editar</a> <a class="btn btn-danger btn-sm pull-right" href="delete_event.php?event_id='.$row['session_id'].'">Eliminar</a></div>'; // Opciones para editar y eliminar eventos
						 }
					 ?>
			 </div>
		 </div>
	 <?php
	 }
 
	 return false; // Devuelve false al finalizar
 }
 
 /*******************************
  * Eventos en formato de tabla.
  *******************************/
 
 function all_events_table($role)
 {
	 $role = $role; // Asigna el rol proporcionado a la variable local
 
	 if($role == "President" || $role == "Technical") // Si el rol es 'President' o 'Technical'
	 {
		 global $con; // Accede a la variable global de conexión
		 $query = "SELECT * FROM sessions"; // Consulta para obtener todas las sesiones
		 $result = mysqli_query($con,$query); // Ejecuta la consulta
		 $rows = mysqli_affected_rows($con); // Obtiene el número de filas afectadas
		 if($rows == 0) // Si no hay eventos programados
		 {
			 echo '<div class="col-md-offset-3 col-md-5 alert alert-warning text-center"><b>No hay eventos programados. ¡Programa un evento primero!</b></div>'; // Mensaje indicando que no hay eventos
			 exit(); // Sale de la función si no hay eventos
		 }
		 ?>
		 <table class="table manage-member-panel table-hover table-responsive">
				 <tr class="alert-info">
					 <th><h4>Id</h4></th>
					 <th><h4>Evento</h4></th>
					 <th><h4>Descripción</h4></th>
					 <th><h4>Fecha</h4></th>
					 <th><h4>Acciones</h4></th>
				 </tr>
		 <?php
		 while ($row = mysqli_fetch_assoc($result)) // Recorre cada fila del resultado
			 {
				 echo '<tr>
					 <td>'.$row['session_id'].'</td>
					 <td>'.$row['session_name'].'</td>
					 <td>'.$row['session_details'].'</td>
					 <td>'.$row['session_date'].'</td>
					 <td><a href="edit_event.php?event_id='.$row['session_id'].'">Editar</a>'; // Enlace para editar el evento
					 echo ' | <a href="delete_event.php?event_id='.$row['session_id'].'">Eliminar</a></td></tr>'; // Enlace para eliminar el evento
			 }
		 echo '</table>'; // Cierra la tabla
		 }
	 return false; // Devuelve false al finalizar
 }
 
 /*******************************
  * Agregar un nuevo evento.
  *******************************/
 
 function add_event()
 {
	 global $con; // Accede a la variable global de conexión
	 if (isset($_POST['add_event'])) // Verifica si se ha enviado el formulario para agregar un evento
	 {
		 $name = $_POST['name']; // Obtiene el nombre del evento del formulario
		 $name = stripslashes($name); // Elimina las barras invertidas del nombre
		 $description = $_POST['description']; // Obtiene la descripción del evento del formulario
		 $description = stripslashes($description); // Elimina las barras invertidas de la descripción
		 $date = $_POST['date']; // Obtiene la fecha del evento del formulario
 
		 $query = "INSERT into sessions (session_name, session_details, session_date) VALUES ('$name', '$description', '$date')"; // Consulta para insertar el nuevo evento en la base de datos
		 $result = mysqli_query($con,$query); // Ejecuta la consulta
		 $rows = mysqli_affected_rows($con); // Obtiene el número de filas afectadas
		 if($rows == 1) // Si el evento se ha agregado correctamente
		 {
			 echo '<div class="text-center alert alert-success col-md-offset-4 col-md-4"><p><b>¡Hecho! Evento agregado.</b></p></div>'; // Mensaje de éxito
			 echo '<script>setTimeout(function () { window.location.href = "cronograma.php";}, 1000);</script>'; // Redirige a la página de cronograma después de 1 segundo
		 }
		 else
		 {
			 echo '<div class="text-center alert alert-danger col-md-offset-4 col-md-4"><p><b>Error al agregar el evento. Inténtalo de nuevo.</b></p></div>'; // Mensaje de error si no se puede agregar el evento
		 }
	 }
 
	 return false; // Devuelve false al finalizar
 }
 
 /*******************************
  * Eliminar evento.
  *******************************/
 
 function delete_event($event_id, $role)
 {
	 global $con; // Accede a la variable global de conexión
	 $event_id = $event_id; // Asigna el ID del evento a la variable local
	 $role = $role; // Asigna el rol proporcionado a la variable local
 
	 if(isset($_POST['yes'])) // Verifica si se ha confirmado la eliminación del evento
	 {
		 $query = "DELETE from sessions where session_id='$event_id'"; // Consulta para eliminar el evento de la base de datos
		 $result = mysqli_query($con,$query); // Ejecuta la consulta
		 $rows = mysqli_affected_rows($con); // Obtiene el número de filas afectadas
		 echo mysqli_error($con); // Muestra el error de MySQL si ocurre alguno
		 if($rows == 1) // Si el evento se ha eliminado correctamente
		 {
			 echo '<div class="text-center alert alert-success col-md-offset-4 col-md-4"><p><b> Hecho! Evento eliminado </b></p></div>'; // Mensaje de éxito
			 echo '<script>setTimeout(function () { window.location.href = "cronograma.php";}, 1000);</script>'; // Redirige a la página de cronograma después de 1 segundo
		 }
		 else
		 {
			 echo '<div class="text-center alert alert-danger col-md-offset-4 col-md-4"><p><b> Error al eliminar la sesión. Inténtalo de nuevo. </b></p></div>'; // Mensaje de error si no se puede eliminar el evento
		 }
	 }
	 
	 return false; // Devuelve false al finalizar
 } 

/*******************************
 * Editar la información del evento.
 *******************************/

 function edit_event($event_id, $role)
 {
	 global $con; // Accede a la variable global de conexión
	 $role = $role; // Asigna el rol proporcionado a la variable local
	 $event_id = $event_id; // Asigna el ID del evento a la variable local
 
	 if (isset($_POST['edit_event'])) // Verifica si se ha enviado el formulario para editar el evento
	 {
		 $name = $_POST['name']; // Obtiene el nombre del evento del formulario
		 $name = stripslashes($name); // Elimina las barras invertidas del nombre
		 $description = $_POST['description']; // Obtiene la descripción del evento del formulario
		 $description = stripslashes($description); // Elimina las barras invertidas de la descripción
		 $date = $_POST['date']; // Obtiene la fecha del evento del formulario
		 
		 // Consulta para actualizar la información del evento en la base de datos
		 $query = "UPDATE sessions SET session_name='$name', session_details='$description', session_date='$date' WHERE session_id='$event_id'";
		 $result = mysqli_query($con, $query); // Ejecuta la consulta
		 $rows = mysqli_affected_rows($con); // Obtiene el número de filas afectadas
		 if ($rows == 1) // Si la información se actualizó correctamente
		 {
			 echo '<div class="text-center alert alert-success col-md-offset-4 col-md-4"><p><b> ¡Hecho! Información actualizada </b></p></div>'; // Mensaje de éxito
			 echo '<script>setTimeout(function () { window.location.href = "cronograma.php";}, 1000);</script>'; // Redirige a la página de cronograma después de 1 segundo
		 }
		 else
		 {
			 echo '<div class="text-center alert alert-danger col-md-offset-4 col-md-4"><p><b> Hubo un error al actualizar la información, intenta de nuevo </b></p></div>'; // Mensaje de error si no se pudo actualizar la información
		 }
	 }
 
	 return false; // Devuelve false al finalizar
 }
 
 /*******************************
  * Mostrar asistencia de miembros presentes y ausentes.
  *******************************/
 
 function attendance($session_id, $role)
 {
	 global $con; // Accede a la variable global de conexión
	 $session_id = $session_id; // Asigna el ID de la sesión a la variable local
 
	 // Consulta para obtener la asistencia de una sesión específica
	 $query = "SELECT * from attendance where session_id='$session_id'";
	 $result = mysqli_query($con, $query); // Ejecuta la consulta
	 $rows = mysqli_affected_rows($con); // Obtiene el número de filas afectadas
 
	 $key = str_rot13($session_id); // Codifica el ID de la sesión para su uso en los enlaces
 
	 if ($rows == 1) // Si hay datos de asistencia para la sesión
	 {
		 $query = "SELECT * from attendance where session_id='$session_id'"; // Consulta repetida para obtener los datos de asistencia
		 $result = mysqli_query($con, $query); // Ejecuta la consulta
		 $rows = mysqli_affected_rows($con); // Obtiene el número de filas afectadas
 
		 ?>
		 <div class="row">
			 <div class="col-md-5">
				 <table class="table table-responsive">
					 <tr class="success"><th>ID</th><th> Miembros presentes </th></tr>
		 <?php
 
		 // Código para mostrar miembros presentes
		 while ($row = mysqli_fetch_assoc($result))
		 {
			 $string_ids = unserialize($row['id_array']); // Deserializa el array de IDs de los miembros presentes
			 foreach ($string_ids as $key => $value)
			 {
				 $query = "SELECT * FROM userinfo where id='$value'"; // Consulta para obtener la información del miembro presente
				 $result = mysqli_query($con, $query); // Ejecuta la consulta
				 $rows = mysqli_affected_rows($con); // Obtiene el número de filas afectadas
				 if ($rows == 0) // Si no hay miembros presentes
				 {
					 echo '<tr class="success"><td> ¡Nadie está presente, Qué mal! </td>';
				 }
				 while ($row = mysqli_fetch_assoc($result))
				 {
					 echo '<tr class="success"><td>'.$row['id'].'</td><td>'.$row['name'].'</td></tr>'; // Muestra la información del miembro presente
				 }
			 }			
			 ?>
				 </table>
				 </div>
				 <div class="col-md-5">
					 <table class="table table-responsive">
						 <tr class="danger"><th>ID</th><th> Miembros ausentes </th></tr>
					 
						 <?php
						 // Código para mostrar miembros ausentes
 
						 $query = "SELECT id FROM userinfo"; // Consulta para obtener todos los IDs de los miembros
						 $result = mysqli_query($con, $query); // Ejecuta la consulta
						 $rows = mysqli_affected_rows($con); // Obtiene el número de filas afectadas
						 $all_id_array = array(); // Array para almacenar todos los IDs de los miembros
						 while ($row = mysqli_fetch_assoc($result))
						 {
							 array_push($all_id_array, $row['id']); // Agrega cada ID al array
						 }
 
						 $absent_array = array('0' => ''); // Array para almacenar los IDs de los miembros ausentes
						 $absent_array = array_diff($all_id_array, $string_ids); // Calcula la diferencia entre todos los IDs y los presentes
						 foreach ($absent_array as $key => $value)
						 {
							   $query = "SELECT * FROM userinfo where id='$value'"; // Consulta para obtener la información del miembro ausente
							 $result = mysqli_query($con, $query); // Ejecuta la consulta
							 $rows = mysqli_affected_rows($con); // Obtiene el número de filas afectadas
 
							 if ($rows == 0) // Si no hay miembros ausentes
							 {
								 echo '<tr class="danger"><td> ¡Todos están presentes, bien hecho, chicos! </td>';
							 }
 
							 while ($row = mysqli_fetch_assoc($result))
							 {
								 echo '<tr class="danger"><td>'.$row['id'].'</td><td>'.$row['name'].'</td></tr>'; // Muestra la información del miembro ausente
							 }
						 }
						 ?>
					 </table>
				 </div>
			 </div>
		 <?php
		 }
	 }
	 else
	 {
		 if ($role == "President" || $role == "Technical") // Si el rol es 'President' o 'Technical'
		 {
			 echo '<br><div class="text-center"><a href="gestion_asistencia.php?key='.$key.'" class="btn btn-primary">Rellena la asistencia para esta sesión.</a></div>'; // Enlace para rellenar la asistencia
		 }
		 else
		 {
			 echo '<div class="text-center alert alert-info col-md-offset-4 col-md-4"><p><b>La asistencia no se ha actualizado para esta sesión. ¡Por favor, contacta a tu responsable técnico o al presidente para resolver el problema!</b></p></div>'; // Mensaje si la asistencia no está actualizada
		 }
		 
	 }
 
	 return false; // Devuelve false al finalizar
 }
 
 /*******************************
  * Registrar la asistencia en la base de datos.
  *******************************/
 
 function do_attendance($key)
 {
	 global $con; // Accede a la variable global de conexión
 
	 if (isset($_POST['submit_attendance'])) // Verifica si se ha enviado el formulario para registrar la asistencia
	 {
		 // Consulta para verificar si la asistencia ya está registrada para la sesión
		 $query = "SELECT session_id FROM attendance WHERE session_id='$key'";
		 $result = mysqli_query($con, $query); // Ejecuta la consulta
		 $rows = mysqli_affected_rows($con); // Obtiene el número de filas afectadas
		 if ($rows == 1) // Si la asistencia ya está registrada
		 {
			 echo '<div class="text-center alert alert-warning col-md-offset-4 col-md-4"><p><b>¡La asistencia ya está registrada!</b></p></div>'; // Mensaje de advertencia
			 echo '<script>setTimeout(function () { window.location.href = "asistencia.php";}, 1000);</script>'; // Redirige a la página de asistencia después de 1 segundo
			 exit(); // Sale de la función
		 }
		 
		 $string_ids = serialize($_POST['checkbx']); // Serializa el array de IDs de miembros presentes
 
		 // Consulta para insertar la asistencia en la base de datos
		 $query = "INSERT into attendance (session_id, id_array) VALUES ('$key', '$string_ids')";
		 $result = mysqli_query($con, $query); // Ejecuta la consulta
		 echo mysqli_error($con); // Muestra el error de MySQL si ocurre alguno
		 $rows = mysqli_affected_rows($con); // Obtiene el número de filas afectadas
 
		 if ($rows == 1) // Si la asistencia se ha registrado correctamente
		 {
			 echo '<div class="text-center alert alert-success col-md-offset-4 col-md-4"><p><b> ¡Éxito! ¡Asistencia actualizada! </b></p></div>'; // Mensaje de éxito
			 echo '<script>setTimeout(function () { window.location.href = "asistencia.php";}, 1000);</script>'; // Redirige a la página de asistencia después de 1 segundo
		 }
		 else
		 {
			 echo '<div class="text-center alert alert-danger col-md-offset-4 col-md-4"><p><b>Error al actualizar la asistencia. Inténtalo de nuevo.</b></p></div>'; // Mensaje de error si no se pudo registrar la asistencia
		 }
	 }
 
	 return false; // Devuelve false al finalizar
 }
 
 /*******************************
  * Mostrar el tablón de anuncios.
  *******************************/
 
 function show_notice($role)
 {
	 global $con; // Accede a la variable global de conexión
	 $query = "SELECT * FROM notice ORDER by date DESC"; // Consulta para obtener los anuncios ordenados por fecha descendente
	 $result = mysqli_query($con, $query); // Ejecuta la consulta
	 $rows = mysqli_affected_rows($con); // Obtiene el número de filas afectadas
 
	 if ($rows == 0) // Si no hay anuncios
	 {
		 echo '<div class="text-center alert alert-info col-md-offset-4 col-md-4"><p><b> No hay noticias aún!</b></p></div>'; // Mensaje si no hay anuncios
		 exit(); // Sale de la función
	 }
	 
	 $select = 1; // Variable para alternar el estilo de los paneles
	 while ($row = mysqli_fetch_assoc($result))
	 {
		 if ($select % 2 == 1) // Alterna el estilo de los paneles
		 {
			 $css = 'panel-teal';
		 }
		 else
		 {
			 $css = 'panel-orange';
		 }
		 ?>
 
		 <div class="col-md-4">
			 <div class="panel <?php echo $css; ?>">
				 <div class="panel-heading dark-overlay"><?php echo $row['title']; ?></div> <!-- Muestra el título del anuncio -->
				 <div class="panel-body">
					 <p>
					 <b>Date:</b> <small><?php echo date('jS M Y H:i', strtotime($row['date'])); ?></small><br> <!-- Muestra la fecha del anuncio -->
					 <?php echo $row['description']; ?> <!-- Muestra la descripción del anuncio -->
					 </p>
				 </div>
				 <?php
					 if ($role == 'President') // Si el rol es 'President'
					 {
						 echo '<div class="panel-footer"><a class="btn btn-primary btn-sm" href="edit_notice.php?notice_id='.$row['notice_id'].'">Editar</a> <a class="btn btn-danger btn-sm pull-right" href="delete_notice.php?notice_id='.$row['notice_id'].'">Eliminar</a></div>'; // Botones para editar o eliminar el anuncio
					 }
				 ?>
			 </div>
		 </div>
		 <?php
		 $select++; // Incrementa el contador para alternar el estilo
	 }
 
	 return false; // Devuelve false al finalizar
 } 

/*******************************
 * Add Notice.
 *******************************/

 function add_notice()
 {
	 global $con; // Usar la variable global de conexión a la base de datos.
	 if (isset($_POST['add_notice'])) // Verificar si se ha enviado el formulario para agregar una noticia.
	 {
		 $name = $_POST['name']; // Obtener el nombre de la noticia del formulario.
		 $name = stripslashes($name); // Eliminar barras invertidas de los datos.
		 $description = $_POST['description']; // Obtener la descripción de la noticia del formulario.
		 $description = stripslashes($description); // Eliminar barras invertidas de los datos.
		 $date = $_POST['date']; // Obtener la fecha de la noticia del formulario.
 
		 $query = "INSERT into notice (title,  description, date) VALUES ('$name',  '$description', '$date')"; // Consulta para insertar la noticia en la base de datos.
		 $result = mysqli_query($con,$query); // Ejecutar la consulta.
		 $rows = mysqli_affected_rows($con); // Obtener el número de filas afectadas.
		 if($rows == 1) // Verificar si se insertó una fila.
		 {
			 // Mostrar mensaje de éxito y redirigir a la página de noticias después de 1 segundo.
			 echo '<div class="text-center alert alert-success bg-success col-md-offset-4 col-md-4" role="alert" style="color: #fff;"></b> Hecho! Noticia agregada </b></div>';
			 echo '<script>setTimeout(function () { window.location.href = "notice.php";}, 1000);</script>';
		 }
		 else
		 {
			 // Mostrar mensaje de error si no se insertó la noticia.
			 echo '<div class="text-center alert alert-success bg-success col-md-offset-4 col-md-4" role="alert" style="color: #fff;"><b> Error al publicar la noticia </b></div>';
		 }
	 }
 
	 return false;
 }
 
 /*******************************
  * delete notice.
  *******************************/
 
 function delete_notice($notice_id,$role)
 {
	 global $con; // Usar la variable global de conexión a la base de datos.
	 $notice_id = $notice_id; // ID de la noticia a eliminar.
	 $role = $role; // Rol del usuario (no se usa en esta función).
 
	 if(isset($_POST['yes'])) // Verificar si se ha confirmado la eliminación.
	 {
		 $query = "DELETE from notice where notice_id='$notice_id'"; // Consulta para eliminar la noticia.
		 $result = mysqli_query($con,$query); // Ejecutar la consulta.
		 $rows = mysqli_affected_rows($con); // Obtener el número de filas afectadas.
		 echo mysqli_error($con); // Mostrar cualquier error de la base de datos.
		 if($rows == 1) // Verificar si se eliminó una fila.
		 {
			 // Mostrar mensaje de éxito y redirigir a la página de noticias después de 1 segundo.
			 echo '<div class="text-center alert alert-success col-md-offset-4 col-md-4"><p><b> Hecho! Noticia eliminada </b></p></div>';
			 echo '<script>setTimeout(function () { window.location.href = "notice.php";}, 1000);</script>';
		 }
		 else
		 {
			 // Mostrar mensaje de error si no se eliminó la noticia.
			 echo '<div class="text-center alert alert-danger col-md-offset-4 col-md-4"><p><b> Hubo un error, Intentalo de nuevo </b></p></div>';
		 }
	 }
	 
	 return false;
 }
 
 /*******************************
  * Editar la información de la noticia.
  *******************************/
 
 function edit_notice($notice_id,$role)
 {
	 global $con; // Usar la variable global de conexión a la base de datos.
	 $role = $role; // Rol del usuario (no se usa en esta función).
 
	 if (isset($_POST['edit_notice'])) // Verificar si se ha enviado el formulario para editar una noticia.
	 {
		 $name = $_POST['name']; // Obtener el nuevo nombre de la noticia del formulario.
		 $name = stripslashes($name); // Eliminar barras invertidas de los datos.
		 $description = $_POST['description']; // Obtener la nueva descripción de la noticia del formulario.
		 $description = stripslashes($description); // Eliminar barras invertidas de los datos.
		 $date = $_POST['date']; // Obtener la nueva fecha de la noticia del formulario.
		 
		 $query = "UPDATE notice SET title='$name', description='$description', date='$date' WHERE notice_id='$notice_id'"; // Consulta para actualizar la noticia en la base de datos.
		 $result = mysqli_query($con,$query); // Ejecutar la consulta.
		 $rows = mysqli_affected_rows($con); // Obtener el número de filas afectadas.
		 if($rows == 1) // Verificar si se actualizó una fila.
		 {
			 // Mostrar mensaje de éxito y redirigir a la página de noticias después de 1 segundo.
			 echo '<div class="text-center alert alert-success bg-success col-md-offset-4 col-md-4" role="alert" style="color: #fff;"></b> Hecho! Noticia editada </b></div>';
			 echo '<script>setTimeout(function () { window.location.href = "notice.php";}, 1000);</script>';
		 }
		 else
		 {
			 // Mostrar mensaje de error si no se actualizó la noticia.
			 echo '<div class="text-center alert alert-danger bg-danger col-md-offset-4 col-md-4" role="alert" style="color: #fff;"></b> Error al editar la noticia </b></div>';
		 }
	 }
 
	 return false;
 }
 
 /*******************************
  * Inicio para cada página.
  *******************************/
 
 function starter($id,$name,$role,$pic,$last_login,$total_members,$core_members,$total_sessions,$completed_sessions)
 {
	 ?>
 <!DOCTYPE html>
 <html>
 <head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <title>Club Manager - Dashboard</title>
 <link rel='shortcut icon' href='favicon.ico' type='image/x-icon'/ >
 <link href="css/pace-theme-corner-indicator.css" rel="stylesheet"> <!-- Estilo para la carga de la página. -->
 <script src="js/pace.min.js"></script> <!-- Script para la carga de la página. -->
 <script>pace.start();</script>
 <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
 <link href="css/styles.css" rel="stylesheet"> <!-- Estilo personalizado para la página. -->
 <script src="https://use.fontawesome.com/c250a4b18e.js"></script> <!-- Iconos Font Awesome. -->
 <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet"> <!-- Fuente Open Sans. -->
 </head>
 <body>
	 <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		 <div class="container-fluid">
			 <div class="navbar-header">
				 <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
					 <span class="sr-only">Toggle navigation</span>
					 <span class="icon-bar"></span>
					 <span class="icon-bar"></span>
					 <span class="icon-bar"></span>
				 </button>
				 <b><a class="navbar-brand" href="home.php"><span>Sync</span>Circle</a></b>
				 <ul class="user-menu">
					 <li class="dropdown pull-right">
						 <a class="dropdown-toggle" data-toggle="dropdown"><img src="<?php echo $pic; ?>" class="img-responsive img-circle img-thumbnail" height="35px" width="35px"> <b id="mobhide"><?php echo $name; ?></b> <div class="btn btn-xs btn-info" id="mobhide"><?php echo $role; ?></div><span class="caret"></span></a>
 
						 <ul class="dropdown-menu" role="menu">
							 <li><a href="update_pic.php"><i class="fa fa-user" aria-hidden="true"></i> Cambiar la imagen de tu perfil </a></li>
							 <li><a href="user_settings.php?user_id=<?php echo $id; ?>"><i class="fa fa-cog" aria-hidden="true"></i> Configuración </a></li>
							 <li><a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Cerrar sesión </a></li>
						 </ul>
					 </li>
				 </ul>
			 </div>			
		 </div><!-- /.container-fluid -->
	 </nav><br>
		 <div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		 <form role="search" action="search.php" method="post">
			 <div class="form-group">
				 <input type="text" name="term" class="form-control" placeholder="Buscar" required>
			 </div>
		 </form>
		 <ul class="nav menu">
				 <li><a href="home.php"><i class="fa fa-home" aria-hidden="true"></i> Inicio </a></li>
				 <li><a href="notice.php"><i class="fa fa-bullhorn" aria-hidden="true"></i> Noticias </a></li>
				 <li><a href="members.php"><i class="fa fa-users" aria-hidden="true"></i> Miembros </a></li>
				 <li><a href="sessions.php"><i class="fa fa-calendar" aria-hidden="true"></i> Sesiones </a></li>
				 <li><a href="profile.php?user_id=<?php echo $id; ?>"><i class="fa fa-user" aria-hidden="true"></i> Perfil </a></li>
			 </ul>
		 </div><!--/.sidebar-->
		 <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		 <?php
 }
 