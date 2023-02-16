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
  $param = json_decode(file_get_contents("php://input"));
  if (!empty($param->id)) {
    $student->id = $param->id;
    $std_data = $student->single_student();
    if (!empty($std_data)) {
      http_response_code(200);
      echo json_encode([
        'status' => 1,
        'data' => $std_data
      ]);
    }else{
      http_response_code(404);
      echo json_encode([
        'status' => 0,
        'message' => 'Student not found'
      ]);
    }
  } 
  
}else{
  http_response_code(503);
  echo json_encode([
    'status' => 0,
    'message' => 'Access Denied'
  ]);
}