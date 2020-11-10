<?php
session_save_path("../session/");
header('Content-type: text/json; charset=utf-8');

function __autoload($class_name) {
    include '../class/' . $class_name . '.php';
}
include '../function/string_to_ascii.php';
set_time_limit(0);
$connDB = new EnDeCode();
$read = "../connection/conn_DB.txt";
$connDB->para_read($read);
$connDB->Read_Text();
$connDB->conn_PDO();
$rslt = array();
$series = array();
$sql = "SELECT month_id ,month_name
FROM opduser
WHERE !ISNULL(doctorcode)";
$conv=new convers_encode();
    $connDB->imp_sql($sql);
    $user = $connDB->select();
    for($i=0;$i<count($user);$i++){
        $series['id'] = $user[$i]['month_id'];
        $series['name'] = $user[$i]['month_name'];
        
    array_push($rslt, $series);    
    }
    print json_encode($rslt);
$connDB->close_PDO();
?>