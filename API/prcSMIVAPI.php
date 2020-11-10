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
if ($method == 'add_SMIV') {
       
        $vn = $_POST['vn'];
        $hn = $_POST['hn'];
        $recdate = insert_date($_POST['assdate']);
        $chk_1 = isset($_POST['chk1'])?$_POST['chk1']:0;
        $smiv1_1 = isset($_POST['smiv1_1'])?$_POST['smiv1_1']:'';
        $smiv1_2 = isset($_POST['smiv1_2'])?$_POST['smiv1_2']:'';
        $smiv1_3 = isset($_POST['smiv1_3'])?$_POST['smiv1_3']:'';
        $smiv1_4 = isset($_POST['smiv1_4'])?$_POST['smiv1_4']:'';
        $smiv1_5 = isset($_POST['smiv1_5'])?$_POST['smiv1_5']:'';
        $smiv1_6 = isset($_POST['smiv1_6'])?$_POST['smiv1_6']:'';
        $smiv1_7 = isset($_POST['smiv1_7'])?$_POST['smiv1_7']:'';
        $smiv1_8 = isset($_POST['smiv1_8'])?$_POST['smiv1_8']:'';
        $smiv1_9 = isset($_POST['smiv1_9'])?$_POST['smiv1_9']:'';
        $smiv1_10 = isset($_POST['smiv1_10'])?$_POST['smiv1_10']:'';
        $smiv1_11 = isset($_POST['smiv1_11'])?$_POST['smiv1_11']:'';
        $smiv1_12 = isset($_POST['smiv1_12'])?$_POST['smiv1_12']:'';
        $t1_12 = isset($_POST['T1_12'])?$conv->utf8_to_tis620($_POST['T1_12']):'';
        $chk_2 = isset($_POST['chk2'])?$_POST['chk2']:0;
        $smiv2_1 = isset($_POST['smiv2_1'])?$_POST['smiv2_1']:'';
        $smiv2_2 = isset($_POST['smiv2_2'])?$_POST['smiv2_2']:'';
        $smiv2_3 = isset($_POST['smiv2_3'])?$_POST['smiv2_3']:'';
        $smiv2_4 = isset($_POST['smiv2_4'])?$_POST['smiv2_4']:'';
        $smiv2_5 = isset($_POST['smiv2_5'])?$_POST['smiv2_5']:'';
        $smiv2_6 = isset($_POST['smiv2_6'])?$_POST['smiv2_6']:'';
        $smiv2_7 = isset($_POST['smiv2_7'])?$_POST['smiv2_7']:'';
        $smiv2_8 = isset($_POST['smiv2_8'])?$_POST['smiv2_8']:'';
        $smiv2_9 = isset($_POST['smiv2_9'])?$_POST['smiv2_9']:'';
        $smiv2_10 = isset($_POST['smiv2_10'])?$_POST['smiv2_10']:'';
        $smiv2_11 = isset($_POST['smiv2_11'])?$_POST['smiv2_11']:'';
        $smiv2_12 = isset($_POST['smiv2_12'])?$_POST['smiv2_12']:'';
        $t2_12 = isset($_POST['T2_12'])?$conv->utf8_to_tis620($_POST['T2_12']):'';
        $chk_3 = isset($_POST['chk3'])?$_POST['chk3']:0;
        $smiv3_1 = isset($_POST['smiv3_1'])?$_POST['smiv3_1']:'';
        $smiv3_2 = isset($_POST['smiv3_2'])?$_POST['smiv3_2']:'';
        $smiv3_3 = isset($_POST['smiv3_3'])?$_POST['smiv3_3']:'';
        $t3_3 = isset($_POST['T3_3'])?$conv->utf8_to_tis620($_POST['T3_3']):'';
        $chk_4 = isset($_POST['chk4'])?$_POST['chk4']:0;
        $smiv4_1 = isset($_POST['smiv4_1'])?$_POST['smiv4_1']:'';
        $smiv4_2 = isset($_POST['smiv4_2'])?$_POST['smiv4_2']:'';
        $smiv4_3 = isset($_POST['smiv4_3'])?$_POST['smiv4_3']:'';
        $smiv4_4 = isset($_POST['smiv4_4'])?$_POST['smiv4_4']:'';
        $chk_5 = isset($_POST['chk5'])?$_POST['chk5']:0;
        $smiv5_1 = isset($_POST['smiv5_1'])?$_POST['smiv5_1']:'';
        $smiv5_2 = isset($_POST['smiv5_2'])?$_POST['smiv5_2']:'';
        $smiv5_3 = isset($_POST['smiv5_3'])?$_POST['smiv5_3']:'';
        $smiv5_4 = isset($_POST['smiv5_4'])?$_POST['smiv5_4']:'';
        $smiv_class = isset($_POST['smiv_class'])?$_POST['smiv_class']:'';
        $comment = isset($_POST['comment'])?$conv->utf8_to_tis620($_POST['comment']):'';
        $regdate = date('Y-m-d H:i:s');
        $recorder = $conv->utf8_to_tis620($_POST['recorder']);
        $user = $conv->utf8_to_tis620($_POST['user']);

        $data = array($hn,$vn,$chk_1,$smiv1_1,$smiv1_2,$smiv1_3,$smiv1_4,$smiv1_5,$smiv1_6,$smiv1_7,$smiv1_8,$smiv1_9,$smiv1_10,$smiv1_11,$smiv1_12,$t1_12
                    ,$chk_2,$smiv2_1,$smiv2_2,$smiv2_3,$smiv2_4,$smiv2_5,$smiv2_6,$smiv2_7,$smiv2_8,$smiv2_9,$smiv2_10,$smiv2_11,$smiv2_12,$t2_12
                    ,$chk_3,$smiv3_1,$smiv3_2,$smiv3_3,$t3_3
                    ,$chk_4,$smiv4_1,$smiv4_2,$smiv4_3,$smiv4_4
                    ,$chk_5,$smiv5_1,$smiv5_2,$smiv5_3,$smiv5_4
                    ,$smiv_class,$comment,$recdate,$recorder,$regdate,$user);
        $table = "jvl_smiv";
        $field = array('hn','vn','chk_1','smiv1_1','smiv1_2','smiv1_3','smiv1_4','smiv1_5','smiv1_6','smiv1_7','smiv1_8','smiv1_9','smiv1_10','smiv1_11','smiv1_12','t1_12'
                    ,'chk_2','smiv2_1','smiv2_2','smiv2_3','smiv2_4','smiv2_5','smiv2_6','smiv2_7','smiv2_8','smiv2_9','smiv2_10','smiv2_11','smiv2_12','t2_12'
                    ,'chk_3','smiv3_1','smiv3_2','smiv3_3','t3_3'
                    ,'chk_4','smiv4_1','smiv4_2','smiv4_3','smiv4_4'
                    ,'chk_5','smiv5_1','smiv5_2','smiv5_3','smiv5_4'
                    ,'smiv_class','comment','recdate','recorder','regdate','user');
        $SMIV = $connDB->insert($table, $data,$field);
        if($SMIV===false){
            $res = array("messege"=>'ไม่สามารถบันทึก SMIV-V ได้!!!!');
        }else{
            $res = array("messege"=>'บันทึก SMIV-V สำเร็จ!!!!');
            }
        print json_encode($res);
        $connDB->close_PDO();
    }