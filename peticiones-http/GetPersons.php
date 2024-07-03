<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methos: GET");

include_once "../database.php";
include_once "../Personas.php";

$db = new DataBase();
$instant = $db->getConnection();

$personInstant = new Personas($instant);

$cmd = $personInstant->getListPersons();

$count = $cmd->rowCount();

if ($count > 0) {
  $personaArray = array();

  while ($row = $cmd->fetch(PDO::FETCH_ASSOC)) {
    extract($row);

    $elementos = array(
      "id" => $id,
      "nombres" => $nombres,
      "apellidos" => $apellidos,
      "telefono" => $telefono,
      "direccion" => $direccion,
      "foto" => $foto
    );

    http_response_code(200);
    array_push($personaArray, $elementos);
  }

  echo json_encode($personaArray);
} else {
  http_response_code(404);

  echo json_encode(array("message" => "No hay datos."));
}
