<?php
session_save_path("../session/");
//session_start(); 
header('Content-type: text/json; charset=utf-8');
// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Headers: access");
// header("Access-Control-Allow-Methods: GET,POST");
// header("Access-Control-Allow-Credentials: true");
// header('Content-Type: application/json;charset=utf-8');
function __autoload($class_name) {
    include '../class/' . $class_name . '.php';
}
$conn_DB = new EnDeCode();
$read = "../connection/conn_DB.txt";
$conn_DB->para_read($read);
$conn_DB->Read_Text();
$conn_DB->conn_PDO();

$id=$_POST['id'];

$sql = "SELECT COUNT(bi_id)count
FROM bill_item
WHERE bill_id= :bill_id";
$conn_DB->imp_sql($sql);
$execute=array(':bill_id' => $id);
$count_bill_item=$conn_DB->select_a($execute);
if($count_bill_item['count']==0){
$table=$_POST['table'];
$field=$_POST['field'];
$where=$field."=:".$field;
$execute=  array(':'.$field => $id);
$del=$conn_DB->delete($table, $where , $execute);
if($del===true){
    echo 'ลบสำเร็จครับ';
}else{
    echo 'ไม่สามารถลบได้สำเร็จครับ';
}
}else{
    echo 'ไม่สามารถลบได้ เนื่องมีรายการในใบเบิกครับ';
}

$conn_DB->close_PDO();
?>