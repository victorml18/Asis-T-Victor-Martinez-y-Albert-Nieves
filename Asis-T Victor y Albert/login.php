<?php
session_start();
include("configuracion_bd.php");

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = mysqli_real_escape_string($conexion, $_POST['usuario']);
    $contrasena = mysqli_real_escape_string($conexion, $_POST['contrasena']);

    $consulta = "SELECT * FROM usuarios WHERE usuario = '$usuario' and contrasena = '$contrasena' ";
    $resultado = mysqli_query($conexion, $consulta);
    $fila = mysqli_fetch_assoc($resultado);
    $count = mysqli_num_rows($resultado);

    if($count == 1) {
        $_SESSION['login_user'] = $fila['id'];
        header("location: asist_register.php");
    } else {
        echo "Usuario o contraseña incorrectos";
    }
}
?>
