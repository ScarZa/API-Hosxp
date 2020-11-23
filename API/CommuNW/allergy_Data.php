<?php
header('Content-type: text/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Allow-Credentials: true");

function __autoload($class_name) {
    include '../../class/' . $class_name . '.php';
}
include '../../function/string_to_ascii.php';
include_once ('../../plugins/funcDateThai.php');
set_time_limit(0);
$connDB = new EnDeCode();
$read = "../../connection/conn_DB.txt";
$connDB->para_read($read);
$connDB->Read_Text();
$connDB->conn_PDO();
$rslt = array();
$series = array();
$data = isset($_POST['data'])?$_POST['data']:(isset($_GET['data'])?$_GET['data']:'');
$sql = "SELECT concat(oa.agent,' : ',oa.symptom)drugallergy FROM opd_allergy oa
inner join allergy_result ar on ar.allergy_result_id = oa.allergy_result_id
inner join allergy_relation are on are.allergy_relation_id = oa.allergy_relation_id
WHERE oa.hn='".$data."'";
$conv=new convers_encode();
    $connDB->imp_sql($sql);
    $user = $connDB->select();
    for($i=0;$i<count($user);$i++){
        $series['drugallergy'] = $conv->tis620_to_utf8($user[$i]['drugallergy']);
    array_push($rslt, $series);    
    }
    print json_encode($rslt);
$connDB->close_PDO();
?>