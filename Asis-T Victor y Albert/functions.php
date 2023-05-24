
<?php
function getEmployeesWithAttendanceCount($start, $end,$curso, $modulo)
{
    $query = "select alumnos.name, 
sum(case when status = 'presence' then 1 else 0 end) as presence_count,
sum(case when status = 'absence' then 1 else 0 end) as absence_count 
 from alumnos_asistencia
 INNER JOIN alumnos ON alumnos.id = alumnos_asistencia.employee_id
        WHERE date >= ? AND date <= ?  AND curso = ? AND modulo = ?
        GROUP BY employee_id;";
    $db = getDatabase();
    $statement = $db->prepare($query);
    $statement->execute([$start, $end,$curso, $modulo]);
    return $statement->fetchAll();
}

function saveAttendanceData($date, $alumnos)
{
    deleteAttendanceDataByDate($date);
    $db = getDatabase();
    $db->beginTransaction();
    $statement = $db->prepare("INSERT INTO alumnos_asistencia(employee_id, date, status) VALUES (?, ?, ?)");
    foreach ($alumnos as $alumnos) {
        $statement->execute([$alumnos->id, $date, $alumnos->status]);
    }
    $db->commit();
    return true;
}

function deleteAttendanceDataByDate($date)
{
    $db = getDatabase();
    $statement = $db->prepare("DELETE FROM alumnos_asistencia WHERE date = ?");
    return $statement->execute([$date]);
}
function getAttendanceDataByDate($date)
{
    $db = getDatabase();
    $statement = $db->prepare("SELECT employee_id, status FROM alumnos_asistencia WHERE date = ?");
    $statement->execute([$date]);
    return $statement->fetchAll();
}


function deleteEmployee($id)
{
    $db = getDatabase();
    $statement = $db->prepare("DELETE FROM alumnos WHERE id = ?");
    return $statement->execute([$id]);
}

function updateEmployee($name, $id, $curso, $turno)
{
    $db = getDatabase();
    $statement = $db->prepare("UPDATE alumnos SET name = ?, curso = ?, turno = ? WHERE id = ?");
    return $statement->execute([$name, $curso, $turno, $id]);
}

function getEmployeeById($id)
{
    $db = getDatabase();
    $statement = $db->prepare("SELECT id, name FROM alumnos WHERE id = ?");
    $statement->execute([$id]);
    return $statement->fetchObject();
}

function saveEmployee($name, $curso, $turno)
{
    $db = getDatabase();
    $statement = $db->prepare("INSERT INTO alumnos (name, curso, turno) VALUES (?, ?, ?)");
    return $statement->execute([$name, $curso, $turno]);
}

function getEmployees($curso=NULL,$turno=NULL)
{
    $db = getDatabase();
    if ($curso && $turno){
        $statement = $db->query("SELECT id, name, curso, turno FROM alumnos WHERE curso='".$curso."' AND turno='".$turno."'" );
    } else {
        $statement = $db->query("SELECT id, name, curso, turno FROM alumnos");
    }
    return $statement->fetchAll();
}

function getVarFromEnvironmentVariables($key)
{
    if (defined("_ENV_CACHE")) {
        $vars = _ENV_CACHE;
    } else {
        $file = "env.php";
        if (!file_exists($file)) {
            throw new Exception("The environment file ($file) does not exists. Please create it");
        }
        $vars = parse_ini_file($file);
        define("_ENV_CACHE", $vars);
    }
    if (isset($vars[$key])) {
        return $vars[$key];
    } else {
        throw new Exception("The specified key (" . $key . ") does not exist in the environment file");
    }
}

function getDatabase()
{
    $password = getVarFromEnvironmentVariables("MYSQL_PASSWORD");
    $user = getVarFromEnvironmentVariables("MYSQL_USER");
    $dbName = getVarFromEnvironmentVariables("MYSQL_DATABASE_NAME");
    $database = new PDO('mysql:host=localhost;dbname=' . $dbName, $user, $password);
    $database->query("set names utf8;");
    $database->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $database->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    return $database;
}
