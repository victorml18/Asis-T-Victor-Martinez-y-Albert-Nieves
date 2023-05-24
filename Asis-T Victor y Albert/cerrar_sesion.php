<?php
session_start();
session_destroy(); // destruir todas las variables de sesión
header("location: login.html"); // redireccionar al usuario a la página de inicio de sesión
exit;
?>
