<?php
class Student{
  public $name;
  public $email;
  public $mobile;
  public $id;

  private $conn;
  private $table_name;

  public function __construct($db){
    $this->conn = $db;
    $this->table_name = "tbl_students";
  }

  public function create_data(){
    $query = "INSERT INTO ". $this->table_name ." SET name=?,email=?,mobile=?";
    $obj = $this->conn->prepare($query);

    $this->name = htmlspecialchars(strip_tags($this->name));
    $this->email = htmlspecialchars(strip_tags($this->email));
    $this->mobile = htmlspecialchars(strip_tags($this->mobile));

    $obj->bind_param("sss",$this->name,$this->email,$this->mobile);
    if ($obj->execute()) {
      return true;
    }
    return false;
  }

  public function get_all_data()
  {
    $sql_query = "SELECT * FROM ". $this->table_name;
    $obj = $this->conn->prepare($sql_query);
    $obj->execute();
    return $obj->get_result();
  }

  public function single_student(){
    $query = "SELECT * from ". $this->table_name ." WHERE id =?";
    $obj = $this->conn->prepare($query);
    $obj->bind_param("i",$this->id);
    $obj->execute();
    $data = $obj->get_result();
    return $data->fetch_assoc();
  }

  public function update()
  {
    $update_query = "UPDATE ". $this->table_name ." SET name =?,email=?,mobile=? WHERE id = ?";
    $query_object = $this->conn->prepare($update_query);

    $this->name = htmlspecialchars(strip_tags($this->name));
    $this->email = htmlspecialchars(strip_tags($this->email));
    $this->mobile = htmlspecialchars(strip_tags($this->mobile));
    $this->id = htmlspecialchars(strip_tags($this->id));

    $query_object->bind_param("sssi",$this->name,$this->email,$this->mobile,$this->id);
    if($query_object->execute()){
      return true;
    }else{
      return false;
    }
  }

  public function delete()
  {
    $delete_query = "DELETE FROM ". $this->table_name. " WHERE id = ?";
    $query_object = $this->conn->prepare($delete_query);
    $this->id = htmlspecialchars(strip_tags($this->id));
    $query_object->bind_param('i',$this->id);
    if ($query_object->execute()) {
      return true;
    }
    return false;
  }
}
?>