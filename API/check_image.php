<?php
header('Content-type: text/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Allow-Credentials: true");
function __autoload($class_name) {
    include '../class/' . $class_name . '.php';
}
include_once '../plugins/function_date.php';
include_once '../plugins/funcDateThai.php';
$conn_DB = new EnDeCode();
$read = "../connection/conn_DB.txt";
$conn_DB->para_read($read);
$conn_db = $conn_DB->Read_Text();
$conn_DB->conn_PDO();
$conv=new convers_encode();
set_time_limit(0);
$rslt = array();
$series = array();
$data = isset($_POST['data1'])?$_POST['data1']:(isset($_GET['data1'])?$_GET['data1']:'');

$sql="select image as cc from patient_image where hn='".$data."'"; 
$conn_DB->imp_sql($sql);
    $num_risk = $conn_DB->select_a();
 //print_r($num_risk['cc']); 
 $series['cc'] = isset($num_risk['cc'])?$conv->tis620_to_utf8($num_risk['cc']):'';
print json_encode($series);
$conn_DB->close_PDO();