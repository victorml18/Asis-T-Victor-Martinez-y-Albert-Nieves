function insertFalta(alumno, fecha, modulo, hora, status) {
 fetch('insert_falta.php', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/x-www-form-urlencoded'
  },
  body: 'modulo=' + modulo + '&hora=' + hora + "&alumno=" + alumno + "&date=" + fecha + "&status=" + status
})
.then(function(response) {
  // Manejar la respuesta del servidor
  if (response.ok) {
    // La solicitud se completó con éxito
    console.log('Falta de asistencia guardada en la base de datos.');
  } else {
    // Ocurrió un error al procesar la solicitud
    console.error('Error al guardar la falta de asistencia en la base de datos.');
  }
})
.catch(function(error) {
  // Ocurrió un error en la comunicación con el servidor
  console.error('Error de comunicación con el servidor:', error);
});

}
 