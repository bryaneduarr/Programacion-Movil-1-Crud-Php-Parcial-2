<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");

// Incluimos los archivos que utilizaremos
// para las funciones.
include_once "../database.php";
include_once "../Personas.php";

// Creamos una nueva instancia de la base de 
// datos.
$db = new DataBase();

// Obtenemos la conexion.
$instant = $db->getConnection();
$personInstant = new Personas($instant);

// Obtenemos una conexion con la base de datos
// y su contenido.
$data = json_decode(file_get_contents("php://input"));


// Verificamos que el campo no este vacio
// a la hora de crear la persona.
if (!empty($data->id)) {
  // Asignamos el valor a la propiedade
  // de la instancia personas.
  $personInstant->id = $data->id;

  // Manejar si la persona se elimino correctamente.
  if ($personInstant->deletePerson()) {
    // El codigo 200 significa que hubo exito
    // ejecutando la operacion.
    http_response_code(200);

    // Mensaje de exito al elminar la persona.
    echo json_encode(array("message" => "Persona eliminada."));
  } else {
    // El error 503 significa que el servicio no esta
    // disponible.
    http_response_code(503);

    // Mensaje si hubo un error de conexion etc..
    echo json_encode(array("message" => "No se pudo eliminar la persona."));
  }
} else {
  // El codigo 400 significa que hubo un error. 
  http_response_code(400);

  // Mensaje si el campo esta vacio.
  echo json_encode(array("message" => "Datos incompletos."));
}
