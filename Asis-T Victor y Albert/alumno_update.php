
<?php
if (!isset($_POST["name"]) || !isset($_POST["id"]) || !isset($_POST["curso"]) || !isset($_POST["turno"])) {
    exit("Falta información: Rellena todos los campos");
}
include_once "functions.php";
$name = $_POST["name"];
$id = $_POST["id"];
$curso = $_POST["curso"];
$turno = $_POST["turno"];
updateEmployee($name, $id, $curso, $turno);
header("Location: alumnos.php");

