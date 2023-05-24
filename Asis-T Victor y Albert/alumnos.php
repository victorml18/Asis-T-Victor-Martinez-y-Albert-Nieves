
<?php
include_once "header.php";
include_once "nav.php";
include_once "functions.php";
$alumnos = getEmployees();
?>
<div class="row">
    <div class="col-12">
        </br>
        <h1 class="text-center">Todos los Alumnos</h1>
        </br>
    </div>
    <div class="col-12">
        <a href="alumno_add.php" class="btn btn-info mb-2">Nuevo Alumno <i class="fa fa-plus"></i></a>
    </div>
    <div class="col-12">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Curso</th>
                        <th>Turno</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($alumnos as $alumnos) { ?>
                        <tr>
                            <td>
                                <?php echo $alumnos->id ?>
                            </td>
                            <td>
                                <?php echo $alumnos->name ?>
                            </td>
                            <td>
                                <?php echo $alumnos->curso ?>
                            </td>
                            <td>
                                <?php echo $alumnos->turno ?>
                            </td>
                            <td>
                                <a class="btn btn-warning" href="alumno_edit.php?id=<?php echo $alumnos->id ?>">
                                Editar <i class="fa fa-edit"></i>
                            </a>
                            </td>
                            <td>
                                <a class="btn btn-danger" href="alumno_delete.php?id=<?php echo $alumnos->id ?>">
                                Eliminar <i class="fa fa-trash"></i>
                            </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

