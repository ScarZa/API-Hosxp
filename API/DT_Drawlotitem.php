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
//$data1 = isset($_POST['data1'])?$_POST['data1']:$_GET['data1'];
$data = isset($_POST['data1'])?$_POST['data1']:(isset($_GET['data1'])?$_GET['data1']:'');
if(empty($data)){
    $code='';
} else {
    $code="where b.bill_id=".$data;
}
$sql = "SELECT bi.bi_id,m.mate_name,l.doc_no,bi.draw_amount
FROM bill_item bi
INNER JOIN bill b on b.bill_id=bi.bill_id
INNER JOIN material m on m.mate_id=bi.mate_id
INNER JOIN lot_item li on li.li_id=bi.li_id
INNER JOIN lot l on l.lot_id=li.lot_id ".$code;

$conn_DB->imp_sql($sql);
$num_risk = $conn_DB->select();
for($i=0;$i<count($num_risk);$i++){
    $series['ID'] = $num_risk[$i]['bi_id'];
    $series['name'] = $num_risk[$i]['mate_name'];
    $series['doc_no'] = $num_risk[$i]['doc_no'];
    $series['draw_amount'] = $num_risk[$i]['draw_amount'];
array_push($rslt, $series);    
}
    print json_encode($rslt);
$conn_DB->close_PDO();
?>