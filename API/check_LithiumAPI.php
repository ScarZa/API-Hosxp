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
include_once ('../plugins/funcDateThai.php');
set_time_limit(0);
$conn_DB= new EnDeCode();
$read="../connection/conn_DB.txt";
$conn_DB->para_read($read);
$conn_DB->Read_Text();
$conn_DB->conn_PDO();
$result = array();
$series = array();
$data = isset($_POST['data'])?$_POST['data']:(isset($_GET['data'])?$_GET['data']:'');
$data2 = isset($_POST['data2'])?$_POST['data2']:(isset($_GET['data2'])?$_GET['data2']:'');
if(!empty($data2)){
    $sql="select p.hn,p.pname,p.fname,p.lname,p.informaddr,p.cid,p.birthday,m.name as mrname,a.an,a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5
    from patient p 
    LEFT OUTER JOIN an_stat a ON a.hn=p.hn
    left outer join marrystatus m on p.marrystatus=m.code 
    where a.an= :an";
    $conn_DB->imp_sql($sql);
    $execute=array(':an'=>$data2);
    $rslt=$conn_DB->select_a($execute);
}else {
    $sql="SELECT regdate FROM jvl_lithium WHERE hn =:hn ORDER BY lithium_id desc limit 1";
    $conn_DB->imp_sql($sql);
    $execute=array(':hn'=>$data);
    $rslt=$conn_DB->select_a($execute);
}

//print_r($rslt);
$conv=new convers_encode();
//for($i=0;$i<count($rslt);$i++){
    $series['regdate'] = isset($rslt['regdate'])?DateThai1($rslt['regdate']):'ไม่เคยประเมิน';
//array_push($result, $series);    
//}
//print_r($result);
print json_encode($series);
$conn_DB->close_PDO();
?>