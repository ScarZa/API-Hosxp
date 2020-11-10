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
include_once '../plugins/funcDateThai.php';
$conn_DB = new EnDeCode();
$read = "../connection/conn_DB.txt";
$conn_DB->para_read($read);
$conn_db = $conn_DB->Read_Text();
$conn_DB->conn_PDO();
set_time_limit(0);
$rslt = array();
$series = array();

$sql="SELECT clinic_code,clinic_name FROM cgi_clinic"; 
$conn_DB->imp_sql($sql);
    $num_risk = $conn_DB->select();
    $conv=new convers_encode();
    for($i=0;$i<count($num_risk);$i++){
        $clinic_name=$conv->tis620_to_utf8($num_risk[$i]['clinic_name']);
        $series['clinic_code'] = $num_risk[$i]['clinic_code'];
        $series['clinic_name'] = $clinic_name;
    array_push($rslt, $series);    
    }
//print_r($rslt);
print json_encode($rslt);
$conn_DB->close_PDO();