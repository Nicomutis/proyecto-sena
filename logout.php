<?php
// Incluye las funciones necesarias desde 'funs.php'
require_once('funs.php');

// Inicia la sesión del usuario
session_start();

// Elimina el nombre de usuario de la sesión
unset($_SESSION['username']);

// Destruye toda la sesión actual
session_destroy();

// Verifica si la sesión aún tiene el nombre de usuario (esto debería ser falso si la sesión se destruyó correctamente)
if(isset($_SESSION['username']))
    echo 'error in logout'; // Muestra un mensaje de error si la sesión no se ha destruido correctamente
else
{
    // Redirige al usuario a la página de inicio ('index.php') si la sesión se destruyó correctamente
    header("location:index.php");
    exit(); // Asegura que el script se detenga después de redirigir
}
?>
