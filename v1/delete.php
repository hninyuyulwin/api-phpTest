<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

include_once "../config/database.php";
include_once "../classes/student.php";

$db = new Database();
$connection = $db->connect();

$student = new Student($connection);
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $student_id = isset($_GET['id']) ? $_GET['id'] : '';
  if (!empty($student_id)) {
    $student->id = $student_id;
    if ($student->delete()) {
      http_response_code(200);
      echo json_encode([
        'status' => 1,
        'message' => 'User Data Deleted Success'
      ]);
    } else {
      http_response_code(404);
      echo json_encode([
        'status' => 0,
        'message' => 'Fail to delete'
      ]);
    }
  }else{
    http_response_code(503);
    echo json_encode([
      'status' => 0,
      'message' => 'Empty ID'
    ]);
  }
  
}else{
  http_response_code(503);
  echo json_encode([
    'status' => 0,
    'message' => 'Access Denied'
  ]);
}
