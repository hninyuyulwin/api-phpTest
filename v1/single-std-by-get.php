<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

include_once "../config/database.php";
include_once "../classes/student.php";

$db = new Database();
$connection = $db->connect();

$student = new Student($connection);
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $student_id = isset($_GET['id']) ? intval($_GET['id']) : '';
  if (!empty($student_id)) {
    $student->id = $student_id;
    $std_data = $student->single_student();
    http_response_code(200);
    echo json_encode([
      'status' => 1,
      'data' => $std_data
    ]);
  }else{
    http_response_code(503);
    echo json_encode([
      'status' => 1,
      'message' => "Data not found"
    ]);
  }
}else{
  http_response_code(200);
  echo json_encode([
    'status' => 1,
    'data' => $std_data
  ]);
}

?>