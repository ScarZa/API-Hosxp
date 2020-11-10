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
if ($method == 'add_NPIQ') {
       
        $vn = $_POST['vn'];
        $hn = $_POST['hn'];
        $informant = $_POST['informant'];
        $chk1 = isset($_POST['chk1'])?$_POST['chk1']:0;
        $b1 = isset($_POST['B1'])?$_POST['B1']:0;
        $c1 = isset($_POST['C1'])?$_POST['C1']:0;
        $chk2 = isset($_POST['chk2'])?$_POST['chk2']:0;
        $b2 = isset($_POST['B2'])?$_POST['B2']:0;
        $c2 = isset($_POST['C2'])?$_POST['C2']:0;
        $chk3 = isset($_POST['chk3'])?$_POST['chk3']:0;
        $b3 = isset($_POST['B3'])?$_POST['B3']:0;
        $c3 = isset($_POST['C3'])?$_POST['C3']:0;
        $chk4 = isset($_POST['chk4'])?$_POST['chk4']:0;
        $b4 = isset($_POST['B4'])?$_POST['B4']:0;
        $c4 = isset($_POST['C4'])?$_POST['C4']:0;
        $chk5 = isset($_POST['chk5'])?$_POST['chk5']:0;
        $b5 = isset($_POST['B5'])?$_POST['B5']:0;
        $c5 = isset($_POST['C5'])?$_POST['C5']:0;
        $chk6 = isset($_POST['chk6'])?$_POST['chk6']:0;
        $b6 = isset($_POST['B6'])?$_POST['B6']:0;
        $c6 = isset($_POST['C6'])?$_POST['C6']:0;
        $chk7 = isset($_POST['chk7'])?$_POST['chk7']:0;
        $b7 = isset($_POST['B7'])?$_POST['B7']:0;
        $c7 = isset($_POST['C7'])?$_POST['C7']:0;
        $chk8 = isset($_POST['chk8'])?$_POST['chk8']:0;
        $b8 = isset($_POST['B8'])?$_POST['B8']:0;
        $c8 = isset($_POST['C8'])?$_POST['C8']:0;
        $chk9 = isset($_POST['chk9'])?$_POST['chk9']:0;
        $b9 = isset($_POST['B9'])?$_POST['B9']:0;
        $c9 = isset($_POST['C9'])?$_POST['C9']:0;
        $chk10 = isset($_POST['chk10'])?$_POST['chk10']:0;
        $b10 = isset($_POST['B10'])?$_POST['B10']:0;
        $c10 = isset($_POST['C10'])?$_POST['C10']:0;
        $chk11 = isset($_POST['chk11'])?$_POST['chk11']:0;
        $b11 = isset($_POST['B11'])?$_POST['B11']:0;
        $c11 = isset($_POST['C11'])?$_POST['C11']:0;
        $chk12 = isset($_POST['chk12'])?$_POST['chk12']:0;
        $b12 = isset($_POST['B12'])?$_POST['B12']:0;
        $c12 = isset($_POST['C12'])?$_POST['C12']:0;
        $recdate = date('Y-m-d H:i:s');
        $recorder = $conv->utf8_to_tis620($_POST['recorder']);
        $user = $conv->utf8_to_tis620($_POST['user']);

        $data = array($hn,$vn,$informant,$chk1,$b1,$c1,$chk2,$b2,$c2,$chk3,$b3,$c3,$chk4,$b4,$c4,$chk5,$b5,$c5,$chk6,$b6,$c6
        ,$chk7,$b7,$c7,$chk8,$b8,$c8,$chk9,$b9,$c9,$chk10,$b10,$c10,$chk11,$b11,$c11,$chk12,$b12,$c12,$recdate,$recorder,$user);
        $table = "jvl_npiq";
        $field = array('hn','vn','informant','chk1','b1','c1','chk2','b2','c2','chk3','b3','c3','chk4','b4','c4','chk5','b5','c5','chk6','b6','c6'
        ,'chk7','b7','c7','chk8','b8','c8','chk9','b9','c9','chk10','b10','c10','chk11','b11','c11','chk12','b12','c12','recdate','recorder','user');
        $NPIQ = $connDB->insert($table, $data,$field);
        if($NPIQ===false){
            $res = array("messege"=>'ไม่สามารถบันทึก NPI-Q ได้!!!!');
        }else{
            $res = array("messege"=>'บันทึก NPI-Q สำเร็จ!!!!');
            }
        print json_encode($res);
        $connDB->close_PDO();
    }