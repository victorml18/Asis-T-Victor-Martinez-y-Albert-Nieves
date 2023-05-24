<?php
include_once "header.php";
include_once "nav.php";
?>
<div class="row" id="app">
    <div class="col-12">
        </br>
        <h1 class="text-center">Pasar Lista</h1>
        </br>
    </div>
    <div class="col-12">
        <div class="form-inline mb-2">
            <label for="date">Fecha: &nbsp;</label>
            <input @change="refreshEmployeesList" v-model="date" name="date" id="date" type="date" class="form-control">
            <form method="POST" action="">
                <label for="curso" style="display: inline-block;">&nbsp;Curso:&nbsp;</label>
                <select name="curso" id="curso" class="form-control mr-2">
                    <option value="ASIX">ASIX</option>
                    <option value="DAW">DAW</option>
                </select>
                <label for="turno" style="display: inline-block;" >Turno:&nbsp;</label>
                <select name="turno" id="turno" class="form-control mr-2">
                    <option value="Mañana">Mañana</option>
                    <option value="Tarde">Tarde</option>
                </select>
                <input type="submit" class="btn btn-success ml-2" name="filtrar" value="Filtrar">
            </form>
            </br>
            <ul></ul>
            </select>
                <label for="modulo">Modulo:</label>
                <select name="modulo" id="modulo" class="form-control mr-2">
                    <option value="m1">M1</option>
                    <option value="m2">M2</option>
                    <option value="m3">M3</option>
                    <option value="m4">M4</option>
                    <option value="m5">M5</option>
                </select>
                <ul></ul>
                </select>
                <label for="hora">Hora:</label>
                <select name="hora" id="hora" class="form-control mr-2">
                <option value="8:00">8:00</option>
                <option value="9:00">9:00</option>
                <option value="10:00">10:00</option>
                <option value="11:30">11:30</option>
                <option value="12:30">12:30</option>
                <option value="13:30">13:30</option>
                <option value="14:30">14:30</option>
                <option value="15:00">15:00</option>
                <option value="16:00">16:00</option>
                <option value="17:00">17:00</option>
                <option value="18:20">18:20</option>
                <option value="19:20">19:20</option>
                <option value="20:20">20:20</option>
		    </select>
         
        </div>

    </div>
    <div class="col-12">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            Alumnos
                        </th>
                        <th>
                            Estado
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_POST["filtrar"])) {
                        $curso = $_POST["curso"];
                        $turno = $_POST["turno"];

                        // Establecer la conexión con la base de datos
                        $conexion = mysqli_connect("localhost", "root", "", "schema");

                        // Realizar la consulta
                        $query = "SELECT name, id, curso, turno FROM alumnos WHERE curso = '$curso' AND turno = '$turno'";
                        $result = mysqli_query($conexion, $query);

                        // Mostrar los resultados
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr>
                                <td><?php echo($row["name"])?></td>
                                <td>
                                    <select onchange="insertFalta('<?php echo($row['id'])?>',document.getElementById('date').value,document.getElementById('modulo').value,document.getElementById('hora').value, this.value)" class="form-control">
                                        <option disabled selected value="">-Seleccione-</option>
                                        <option value="presence">Asiste</option>
                                        <option value="absence">Falta</option>
                                    </select>
                                </td>
                            </tr>
                            <?php
                        }

                        // Cerrar la conexión con la base de datos
                        mysqli_close($conexion);
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="js/vue.min.js"></script>
<script src="js/vue-toasted.min.js"></script>
<script>
    Vue.use(Toasted);
    const UNSET_STATUS = "unset";
    new Vue({
        el: "#app",
        data: () => ({
            employees: [],
            date: "",
        }),
        async mounted() {
            this.date = this.getTodaysDate();
            await this.refreshEmployeesList();
        },
        methods: {
            getTodaysDate() {
                const date = new Date();
                const month = date.getMonth() + 1;
                const day = date.getDate();
                return `${date.getFullYear()}-${(month < 10 ? '0' : '').concat(month)}-${(day < 10 ? '0' : '').concat(day)}`;
            },
            async save() {
                // We only need id and status, nothing more
                let employeesMapped = this.employees.map(employee => {
                    return {
                        id: employee.id,
                        status: employee.status,
                    }
                });
                // And we need only where status is set
                employeesMapped = employeesMapped.filter(employee => employee.status != UNSET_STATUS);
                const payload = {
                    date: this.date,
                    employees: employeesMapped,
                };
                const response = await fetch("./save_attendance_data.php", {
                    method: "POST",
                    body: JSON.stringify(payload),
                });
                this.$toasted.show("Saved", {
                    position: "top-left",
                    duration: 1000,
                });
            },
            async refreshEmployeesList() {
                // Get all employees
                let response = await fetch("./get_employees_ajax.php");
                let employees = await response.json();
                // Set default status: unset
                let employeeDictionary = {};
                employees = employees.map((employee, index) => {
                    employeeDictionary[employee.id] = index;
                    return {
                        id: employee.id,
                        name: employee.name,
                        status: UNSET_STATUS,
                    }
                });
                // Get attendance data, if any
                response = await fetch(`./get_attendance_data_ajax.php?date=${this.date}`);
                let attendanceData = await response.json();
                // Refresh attendance data in each student, if any
                attendanceData.forEach(attendanceDetail => {
                    let employeeId = attendanceDetail.employee_id;
                    if (employeeId in employeeDictionary) {
                        let index = employeeDictionary[employeeId];
                        employees[index].status = attendanceDetail.status;
                    }
                });
                // Let Vue do its magic ;)
                this.employees = employees;
            }
        },
    });
</script>
<?php
include_once "footer.php";