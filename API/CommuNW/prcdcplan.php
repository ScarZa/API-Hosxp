<?php
header('Content-type: text/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Allow-Credentials: true");

function __autoload($class_name) {
    include '../../class/' . $class_name . '.php';
}
include '../../plugins/funcDateThai.php';
$conn_DB = new EnDeCode();
$conv=new convers_encode();
$read = "../../connection/conn_DB.txt";
$conn_DB->para_read($read);
$conn_DB->Read_Text();
$conn_DB->conn_PDO();
$rslt = array();
$series = array();

    $dcp_id = $_POST['dcp_id'];
    $hn = $_POST['hn'];
    $vn = $_POST['vn'];
    $an = $_POST['an'];
    $assent_tel = $_POST['assent_tel'];
    $assent_jvl = $_POST['assent_jvl'];
    $assent_cn = $_POST['assent_cn'];
    $assent_drug = $_POST['assent_drug'];
    $recorder = $_POST['recorder'];
    $regdate = date('Y-m-d H:i:s');

    $data = array($dcp_id,$hn,$vn,$an,$assent_tel,$assent_jvl,$assent_cn,$assent_drug,$recorder,$regdate);
    //$field = array("reg_status","confdate");
    $table = "jvl_dcplan";
    $dcplan = $conn_DB->insert($table, $data);
    if($dcplan != false){
      $res = array("messege"=>'บันทึก Discharge plan สำเร็จ!!!! 01');
  }else{
      $res = array("messege"=>'บันทึก Discharge plan ไม่สำเร็จ!!!!!!!! 02');
  }
    print json_encode($res);
$conn_DB->close_PDO();
?>