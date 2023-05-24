<?php
?>
<?php
if (!isset($_POST["name"]) | !isset($_POST["curso"]) | !isset($_POST["turno"])) {
    exit("error");
}
include_once "functions.php";
$name = $_POST["name"];
$curso = $_POST["curso"];
$turno = $_POST["turno"];
saveEmployee($name, $curso, $turno);
header("Location: alumnos.php");

?>

