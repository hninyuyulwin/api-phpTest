<?php

header("Access-Control-Allow-Origin: *");
header("Content-type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once "../config/database.php";
include_once "../classes/student.php";

$db = new Database();
$connection = $db->connect();

$student = new Student($connection);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $data = json_decode(file_get_contents("php://input"));
  if (!empty($data->name) && !empty($data->email) && !empty($data->mobile)) {
    $student->name = $data->name;
    $student->email = $data->email;
    $student->mobile = $data->mobile;
    if($student->create_data()){
      http_response_code(200); // ok
      echo json_encode([
        'status' => 1,
        'message' => 'Student has been created'
      ]);
    }else{
      http_response_code(500); // internal server error
      echo json_encode([
        'status' => 0,
        'message' => 'Failed to create student'
      ]);
    }
  } 
  else{
    http_response_code(404); // internal server error
    echo json_encode([
      'status' => 0,
      'message' => 'Need to add all values'
    ]);
  }
} else {
  http_response_code(503); // Servoce Unavailable
  echo json_encode([
    'status' => 0,
    'message' => 'Access Denied'
  ]);
}

?>