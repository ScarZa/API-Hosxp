<?php
session_save_path("../session/");
session_start(); 
header('Content-type: text/json; charset=utf-8');

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
set_time_limit(0);
$rslt = array();
$series = array();
$data = isset($_POST['data1'])?$_POST['data1']:(isset($_GET['data1'])?$_GET['data1']:'');
$sql="SELECT smiv.recdate,a.an,smiv.comment,ou.name
,CASE
    WHEN smiv.confirm = '1' THEN 'ดูแลต่อเนื่อง'
    ELSE 'ติดตามในระบบ( HDC)' END as confirm
FROM an_stat a
inner join jvl_smiv smiv on a.vn = smiv.vn
inner join opduser ou on ou.loginname = smiv.recorder
WHERE a.hn = '".$data."' order by smiv.smiv_id desc"; 
$conn_DB->imp_sql($sql);
    $num_risk = $conn_DB->select();
    $conv=new convers_encode();
    for($i=0;$i<count($num_risk);$i++){
    $series['recdate'] = DateThai1($num_risk[$i]['recdate']);
    $series['an']= $num_risk[$i]['an'];
    $series['comment'] = $conv->tis620_to_utf8($num_risk[$i]['comment']);
    $series['name']= $conv->tis620_to_utf8($num_risk[$i]['name']);
    $series['confirm']= $num_risk[$i]['confirm'];
    array_push($rslt, $series);    
    }
print json_encode($rslt);
$conn_DB->close_PDO();