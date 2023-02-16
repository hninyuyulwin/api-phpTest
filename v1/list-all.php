<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

include_once "../config/database.php";
include_once "../classes/student.php";

$db = new Database;
$connection = $db->connect();

$student = new Student($connection);
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  $data = $student->get_all_data();
  if ($data->num_rows > 0) {
    $students["records"] = array(); 
    while($row = $data->fetch_assoc()){
      array_push($students["records"], array(
        "id" => $row['id'],
        "name" => $row['name'],
        "email" => $row['email'],
        "mobile" => $row['mobile'],
        "status" => $row['status'],
        "created_at" => date('d M Y H:i A',strtotime($row['created_at'])),
      ));
    }
    http_response_code(200);
    echo json_encode(array(
      'status' => 1,
      'data' => $students["records"]
    ));
  } else {
    http_response_code(404);
    echo json_encode([
      'status' => 0,
      'data' => "No data available"
    ]);
  }
  
} else {
  http_response_code(503);
  echo json_encode([
    'status' => 0,
    'message' => 'Service Unavailable'
  ]);
}


 