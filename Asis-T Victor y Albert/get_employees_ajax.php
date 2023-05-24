
<?php
include_once "functions.php";
$alumnos = getEmployees();
echo json_encode($alumnos);
