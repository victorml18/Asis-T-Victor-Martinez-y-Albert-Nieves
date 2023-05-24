<?php
$alumno = $_POST['alumno'];
$fecha = $_POST['date'];
$dFormat = date("Y-m-d", strtotime($fecha));
error_log($dFormat);
$status = $_POST['status'];
$modulo = $_POST['modulo'];
$hora = $_POST['hora'];

$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'schema';

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die('Error de conexión a la base de datos: ' . $conn->connect_error);
}

// Verificar si ya existe una falta de asistencia con los mismos valores
$stmt = $conn->prepare("SELECT employee_id FROM alumnos_asistencia WHERE employee_id = ? AND date = ? AND modulo = ? AND hora = ?");
$stmt->bind_param("isss", $alumno, $dFormat, $modulo, $hora);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Ya existe una falta de asistencia con los mismos valores, realizar un update
    $stmt = $conn->prepare("UPDATE alumnos_asistencia SET status = ? WHERE employee_id = ? AND date = ? AND modulo = ? AND hora = ?");
    $stmt->bind_param("sisss", $status, $alumno, $dFormat, $modulo, $hora);
    $result = $stmt->execute();

    if ($result) {
        echo 'Falta de asistencia actualizada en la base de datos.';
    } else {
        echo 'Error al actualizar la falta de asistencia en la base de datos.';
    }
} else {
    // No existe una falta de asistencia con los mismos valores
    $stmt = $conn->prepare("INSERT INTO alumnos_asistencia (employee_id, date, status, modulo, hora) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $alumno, $dFormat, $status, $modulo, $hora);
    $result = $stmt->execute();

    if ($result) {

        echo 'Falta de asistencia guardada en la base de datos.';
    } else {

        echo 'Error al guardar la falta de asistencia en la base de datos.';
    }
}

// Cerrar la conexión a la base de datos
$stmt->close();
$conn->close();
?>