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
include '../plugins/funcDateThai.php';
$conn_DB = new EnDeCode();
$read = "../connection/conn_DB.txt";
$conn_DB->para_read($read);
$conn_db = $conn_DB->Read_Text();
$conn_DB->conn_PDO();
$rslt = array();
$series = array();
$conv=new convers_encode();
//$data1 = isset($_POST['data1'])?$_POST['data1']:$_GET['data1'];
$data = isset($_POST['data1'])?$_POST['data1']:(isset($_GET['data1'])?$_GET['data1']:'');
$new_data =  (int) $data;
$sql = "SELECT ds.screen_datetime,ds.depression_score,q9.rs9q_name
FROM depression_screen ds
inner join jvl_9q_results q9 on q9.rs9q_id = ds.depression_screen_evaluate_id
WHERE ds.patient_depression_id like '%".$new_data."' ORDER BY ds.depression_screen_id desc";

$conn_DB->imp_sql($sql);
$num_risk = $conn_DB->select();

for($i=0;$i<count($num_risk);$i++){
    $series['date'] = DateThai1($num_risk[$i]['screen_datetime']);
    $series['depression_score'] = $num_risk[$i]['depression_score'];
    $series['rs9q_name'] = $conv->tis620_to_utf8($num_risk[$i]['rs9q_name']);
array_push($rslt, $series);    
}
//print_r($rslt);
    print json_encode($rslt);
$conn_DB->close_PDO();
?>