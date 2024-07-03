<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
// Aqui le decimos que utilizaremos el metodo POST.
header("Access-Control-Allow-Methods: POST");

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

// Verificamos que ningun campo este vacio
// a la hora de crear la persona.
if (
  !empty($data->nombres) &&
  !empty($data->apellidos) &&
  !empty($data->direccion) &&
  !empty($data->telefono) &&
  !empty($data->foto)
) {
  // Asignamos los valores a las propiedades
  // de cada uno de la instancia personas.
  $personInstant->nombres = $data->nombres;
  $personInstant->apellidos = $data->apellidos;
  $personInstant->direccion = $data->direccion;
  $personInstant->telefono = $data->telefono;
  $personInstant->foto = $data->foto;

  // Manejar si la persona se creo correctamente.
  if ($personInstant->createPerson()) {
    // El codigo 201 significa que fue creado con
    // exito.
    http_response_code(201);

    // Mensaje de exito al crear.
    echo json_encode(array("message" => "Persona creada."));
  } else {
    // El error 503 significa que el servicio no esta
    // disponible.
    http_response_code(503);

    // Mensaje si hubo un error de conexion etc..
    echo json_encode(array("message" => "No se pudo crear la persona."));
  }
} else {
  // El codigo 400 significa que hubo un error. 
  http_response_code(400);

  // Mensaje si alguno de los campos esta vacio.
  echo json_encode(array("message" => "Llene todos los campos de personas."));
}
