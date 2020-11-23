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
$sql = "SELECT vstdate,vn,an,SUBSTR(vsttime,1,5)vsttime FROM ovst WHERE hn = '".$data."' ORDER BY vstdate desc limit 5";
$conv=new convers_encode();
    $connDB->imp_sql($sql);
    $user = $connDB->select();
    for($i=0;$i<count($user);$i++){
        $series['vstdate'] = DateThai1($user[$i]['vstdate']);
        $series['vsttime'] = $user[$i]['vsttime'];
        $series['vn'] = $user[$i]['vn'];
        $series['an'] = $user[$i]['an'];
    array_push($rslt, $series);    
    }
    print json_encode($rslt);
$connDB->close_PDO();
?>