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
include '../function/string_to_ascii.php';
set_time_limit(0);
$connDB = new EnDeCode();
$read = "../connection/conn_DB.txt";
$connDB->para_read($read);
$connDB->Read_Text();
$connDB->conn_PDO();

function insert_date($take_date_conv) {
    $take_date = explode("-", $take_date_conv);
    $take_date_year = @$take_date[2] - 543;
    $take_date = "$take_date_year-" . @$take_date[1] . "-" . @$take_date[0] . "";
    return $take_date;
}
$conv=new convers_encode();
$method = isset($_POST['method']) ? $_POST['method'] : $_GET['method'];
if ($method == 'add_ADL') {
       
        $vn = $_POST['vn'];
        $hn = $_POST['hn'];
        $Q1 = isset($_POST['Q1'])?$_POST['Q1']:0;
        $Q2 = isset($_POST['Q2'])?$_POST['Q2']:0;
        $Q3 = isset($_POST['Q3'])?$_POST['Q3']:0;
        $Q4 = isset($_POST['Q4'])?$_POST['Q4']:0;
        $Q5 = isset($_POST['Q5'])?$_POST['Q5']:0;
        $Q6 = isset($_POST['Q6'])?$_POST['Q6']:0;
        $Q7 = isset($_POST['Q7'])?$_POST['Q7']:0;
        $Q8 = isset($_POST['Q8'])?$_POST['Q8']:0;
        $Q9 = isset($_POST['Q9'])?$_POST['Q9']:0;
        $Q10 = isset($_POST['Q10'])?$_POST['Q10']:0;
        $total = isset($_POST['total'])?$_POST['total']:0;
        $recdate = date('Y-m-d H:i:s');
        $recorder = $conv->utf8_to_tis620($_POST['recorder']);
        $user = $conv->utf8_to_tis620($_POST['user']);

        $data = array($hn,$vn,$Q1,$Q2,$Q3,$Q4,$Q5,$Q6,$Q7,$Q8,$Q9,$Q10,$total,$recdate,$recorder,$user);
        $table = "jvl_adl";
        $field = array('hn','vn','Q1','Q2','Q3','Q4','Q5','Q6','Q7','Q8','Q9','Q10','total','recdate','recorder','user');
        $MMSE = $connDB->insert($table, $data,$field);
        if($MMSE===false){
            $res = array("messege"=>'ไม่สามารถบันทึก ADL ได้!!!!');
        }else{
            $res = array("messege"=>'บันทึก ADL สำเร็จ!!!!');
            }
        print json_encode($res);
        $connDB->close_PDO();
    }