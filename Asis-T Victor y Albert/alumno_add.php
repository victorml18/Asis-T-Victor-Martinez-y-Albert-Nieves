<?php
 ?>
<?php
include_once "header.php";
include_once "nav.php";
?>
<div class="row">
    <div class="col-12">
        <h1 class="text-center">Añadir Alumno</h1>
    </div>
    <div class="col-12">
        <form action="alumno_save.php" method="POST">
            <div class="form-group">
                <label for="name">Nombre Completo</label>
                <input name="name" placeholder="Nombre" type="text" id="name" class="form-control" required>
                <label for="curso">Curso</label>
                <td>
                    <select name="curso" v-model="curso" class="form-control">
                        <option value="ASIX">ASIX</option>
                        <option value="DAW">DAW</option>
                    </select>
                </td>
                <label for="turno">Turno</label>
                <td>
                    <select name="turno" v-model="turno" class="form-control">
                        <option value="Mañana">Mañana</option>
                        <option value="Tarde">Tarde</option>
                    </select>
                </td>
            </div>
            <div class="form-group">
                <button class="btn btn-success">
                    Guardar <i class="fa fa-check"></i>
                </button>
            </div>
        </form>
    </div>
</div>
<?php
include_once "footer.php";
