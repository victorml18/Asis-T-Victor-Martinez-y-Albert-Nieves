<?php
// Configuración de la conexión a la base de datos
$host = "localhost"; // Nombre del host
$usuario = "root"; // Nombre de usuario de la base de datos
$password = ""; // Contraseña de la base de datos
$base_de_datos = "schema"; // Nombre de la base de datos

// Conexión a la base de datos
$conexion = mysqli_connect($host, $usuario, $password, $base_de_datos);

// Verificación de la conexión
if (!$conexion) {
	die("Error de conexión a la base de datos: " . mysqli_connect_error());
}
?>
