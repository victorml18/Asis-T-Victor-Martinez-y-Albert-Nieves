<?php
include_once "header.php";
include_once "nav.php";
include_once "functions.php";
$start = date("Y-m-d");
$end = date("Y-m-d");


if (isset($_GET["start"])) {
    $start = $_GET["start"];
}
if (isset($_GET["end"])) {
    $end = $_GET["end"];
}
if (isset($_GET["curso"])) {
    $curso = $_GET["curso"];

}
if (isset($_GET["modulo"])) {
    $modulo = $_GET["modulo"];
    $alumnos = getEmployeesWithAttendanceCount($start, $end, $curso, $modulo);
}

?>
<div class="row">
    <div class="col-12">
        </br>
        <h1 class="text-center">Faltas de Asistencia</h1>
        </br>
    </div>
    <div class="col-12">

        <form action="asist_report.php" method='GET' class="form-inline mb-2">
            <label for="curso">Curso:&nbsp;</label>
            <select id="curso" name="curso" class="form-control mr-2">
                <option value="ASIX">ASIX</option>
                <option value="DAW">DAW</option>
            </select>
            <label for="modulo">Módulo:&nbsp;</label>
            <select id="modulo" name="modulo" class="form-control mr-2">
                <option value="M1">M1</option>
                <option value="M2">M2</option>
                <option value="M3">M3</option>
                <option value="M4">M4</option>
                <option value="M5">M5</option>
            </select>
            <label for="start">Inicio:&nbsp;</label>
            <input required id="start" type="date" name="start" value="<?php echo $start ?>" class="form-control mr-2">
            <label for="end">Final:&nbsp;</label>
            <input required id="end" type="date" name="end" value="<?php echo $end ?>" class="form-control">
            <button class="btn btn-success ml-2">Filtrar</button>
        </form>
    </div>
    <div class="col-12">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Alumnos</th>
                        <th>Asistencia</th>
                        <th>Ausencias</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        if (isset($alumnos)) {

                    foreach ($alumnos as $alumno) {
                        $total_asistencias = $alumno->presence_count + $alumno->absence_count;
                        $presence_percentage = ($total_asistencias > 0) ? ($alumno->presence_count / $total_asistencias * 100) : 0;
                        $absence_percentage = ($total_asistencias > 0) ? ($alumno->absence_count / $total_asistencias * 100) : 0;
                        ?>
                        <tr>
                            <td>
                                <?php echo $alumno->name ?>
                            </td>
                            <td>
                                <?php echo round($presence_percentage, 2) ?>%
                                <?php echo ('(') ?>
                                <?php echo ($alumno->presence_count) ?>
                                <?php echo (')') ?>
                            </td>
                            <td>
                                <?php echo round($absence_percentage, 2) ?>%
                                <?php echo ('(') ?>
                                <?php echo ($alumno->absence_count) ?>
                                <?php echo (')') ?>
                            </td>
                        </tr>
                    <?php } 
                    }?>

                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
include_once "footer.php";