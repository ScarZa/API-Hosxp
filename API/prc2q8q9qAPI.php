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
if ($method == 'add_depress') {
        //$i=0;
        //$hcode = $conv->utf8_to_tis620('14644');
       
        $vn = $_POST['vn'];
        $hn = $_POST['hn'];
        
        $pp_vn = $conv->utf8_to_tis620($vn);
        $recorder = $conv->utf8_to_tis620($_POST['recorder']);
        
        $q2_1 = $conv->utf8_to_tis620($_POST['2Q-1']);
        $q2_2 = $conv->utf8_to_tis620($_POST['2Q-2']);
        $q9score = isset($_POST['score9Q'])?$_POST['score9Q']:0;
        $res_9q = isset($_POST['res_9q'])?$_POST['res_9q']:9;
        $q8score = isset($_POST['score8Q'])?$_POST['score8Q']:0;
        $res_8q = isset($_POST['res_8q'])?$_POST['res_8q']:9;
        $pp_hn = $conv->utf8_to_tis620($hn);
        $Q9_1 = isset($_POST['9Q-1'])?$_POST['9Q-1']:0;
        $Q9_2 = isset($_POST['9Q-2'])?$_POST['9Q-2']:0;
        $Q9_3 = isset($_POST['9Q-3'])?$_POST['9Q-3']:0;
        $Q9_4 = isset($_POST['9Q-4'])?$_POST['9Q-4']:0;
        $Q9_5 = isset($_POST['9Q-5'])?$_POST['9Q-5']:0;
        $Q9_6 = isset($_POST['9Q-6'])?$_POST['9Q-6']:0;
        $Q9_7 = isset($_POST['9Q-7'])?$_POST['9Q-7']:0;
        $Q9_8 = isset($_POST['9Q-8'])?$_POST['9Q-8']:0;
        $Q9_9 = isset($_POST['9Q-9'])?$_POST['9Q-9']:0;
        $Q8_1 = isset($_POST['8Q-1'])?$_POST['8Q-1']:0;
        $Q8_2 = isset($_POST['8Q-2'])?$_POST['8Q-2']:0;
        $Q8_3 = isset($_POST['8Q-3'])?$_POST['8Q-3']:0;
        $Q8_31 = isset($_POST['8Q-31'])?$_POST['8Q-31']:0;
        $Q8_4 = isset($_POST['8Q-4'])?$_POST['8Q-4']:0;
        $Q8_5 = isset($_POST['8Q-5'])?$_POST['8Q-5']:0;
        $Q8_6 = isset($_POST['8Q-6'])?$_POST['8Q-6']:0;
        $Q8_7 = isset($_POST['8Q-7'])?$_POST['8Q-7']:0;
        $Q8_8 = isset($_POST['8Q-8'])?$_POST['8Q-8']:0;
        $pp_place = $_POST['place'];
        $pp_date = date('Y-m-d H:i:s');
        $hcode = $conv->utf8_to_tis620('14644');
        $sqluser = "SELECT doctorcode as id FROM opduser WHERE loginname='".$recorder."'";
        $connDB->imp_sql($sqluser);
        $recorder_id=$connDB->select_a();
        if($q2_1=='N' and $q2_2=='N'){
            $res_2q = 'N';
            
            $pp_code = $conv->utf8_to_tis620('151');
            $sql = "SELECT pp_special_id+1 as id FROM pp_special ORDER BY id desc limit 1 ";
            $connDB->imp_sql($sql);
            $id=$connDB->select_a();
            $data = array($id['id'],$pp_vn,$pp_code,$recorder_id['id'],$pp_place,$pp_date,$hcode,null,null,$pp_hn);
            $field = array('pp_special_id','vn','pp_special_type_id','doctor','pp_special_service_place_type_id'
                        ,'entry_datetime','dest_hospcode','hos_guid','pp_special_text','hn');
            $table = "pp_special";
            $pp_special= $connDB->insert($table, $data, $field);
        }else{
            $res_2q = 'Y';

            $pp_code = $conv->utf8_to_tis620('152');
            $sql = "SELECT pp_special_id+1 as id FROM pp_special ORDER BY id desc limit 1 ";
            $connDB->imp_sql($sql);
            $id=$connDB->select_a();
            $data = array($id['id'],$pp_vn,$pp_code,$recorder_id['id'],$pp_place,$pp_date,$hcode,null,null,$pp_hn);
            $field = array('pp_special_id','vn','pp_special_type_id','doctor','pp_special_service_place_type_id'
                        ,'entry_datetime','dest_hospcode','hos_guid','pp_special_text','hn');
            $table = "pp_special";
            $pp_special= $connDB->insert($table, $data, $field);

            switch ($res_9q){
                case 9:
                $pp_code = $conv->utf8_to_tis620('238');
                break;

                case 1:
                $pp_code = $conv->utf8_to_tis620('26');
                break;

                case 2:
                $pp_code = $conv->utf8_to_tis620('27');
                break;

                case 3:
                $pp_code = $conv->utf8_to_tis620('24');
                break;
            }
            $sql = "SELECT pp_special_id+1 as id FROM pp_special ORDER BY id desc limit 1 ";
                    $connDB->imp_sql($sql);
                    $id=$connDB->select_a();
                    $data = array($id['id'],$pp_vn,$pp_code,$recorder_id['id'],$pp_place,$pp_date,$hcode,null,null,$pp_hn);
                    $field = array('pp_special_id','vn','pp_special_type_id','doctor','pp_special_service_place_type_id'
                                ,'entry_datetime','dest_hospcode','hos_guid','pp_special_text','hn');
                    $table = "pp_special";
                    $pp_special= $connDB->insert($table, $data, $field);
            if($res_9q != 9){
                switch ($res_8q){
                    case 9:
                    $pp_code = $conv->utf8_to_tis620('31');
                    break;
    
                    case 1:
                    $pp_code = $conv->utf8_to_tis620('32');
                    break;
    
                    case 2:
                    $pp_code = $conv->utf8_to_tis620('33');
                    break;
    
                    case 3:
                    $pp_code = $conv->utf8_to_tis620('34');
                    break;
                }
                $sql = "SELECT pp_special_id+1 as id FROM pp_special ORDER BY id desc limit 1 ";
                    $connDB->imp_sql($sql);
                    $id=$connDB->select_a();
                    $data = array($id['id'],$pp_vn,$pp_code,$recorder_id['id'],$pp_place,$pp_date,$hcode,null,null,$pp_hn);
                    $field = array('pp_special_id','vn','pp_special_type_id','doctor','pp_special_service_place_type_id'
                                ,'entry_datetime','dest_hospcode','hos_guid','pp_special_text','hn');
                    $table = "pp_special";
                    $pp_special= $connDB->insert($table, $data, $field);
            }
        }
        
       
        $place = $_POST['place'];
        $patient_type = $_POST['patient-type'];
        $screen_type = $_POST['screen-type'];
        $patient_group = $_POST['patient-group'];
        $vdate = $_POST['vstdate'];
        $user = $conv->utf8_to_tis620($_POST['user']);
        $dupdate = date('Y-m-d');

        $sql = "SELECT depression_screen_id+1 as id FROM depression_screen ORDER BY id desc limit 1 ";
        $connDB->imp_sql($sql);
        $id=$connDB->select_a();

        $data = array($id['id'],$pp_vn,$recorder,$pp_date,$q2_1,$q2_2,$q9score,$res_9q,$q8score,$res_8q,$pp_hn,$pp_hn,$Q9_1,$Q9_2,$Q9_3,$Q9_4,$Q9_5,$Q9_6,$Q9_7,$Q9_8,$Q9_9
                    ,$Q8_1,$Q8_2,$Q8_3,$Q8_31,$Q8_4,$Q8_5,$Q8_6,$Q8_7,$Q8_8,$res_2q);
        $field = array('depression_screen_id','vn','staff','screen_datetime','feel_depression_2_week','feel_boring_2_week','depression_score','depression_screen_evaluate_id'
                    ,'suicide_score','suicide_screen_evaluate_id','patient_depression_id','hn','score_9q_1','score_9q_2','score_9q_3','score_9q_4','score_9q_5','score_9q_6','score_9q_7','score_9q_8','score_9q_9'
                    ,'score_8q_1','score_8q_2','score_8q_3','score_8q_4','score_8q_5','score_8q_6','score_8q_7','score_8q_8','score_8q_9','no_depression');
        $table = "depression_screen";
        $depression_screen = $connDB->insert($table, $data, $field);
        if($depression_screen===false){
            $res = array("messege"=>'ไม่สามารถประเมิน 2Q 8Q 9Q ได้!!!!');
        }else{
        $data2 = array($id['id'],$place,$patient_type,$screen_type,$patient_group,$vdate,$user,$dupdate);
        $table2 = "jvl_headData_2q8q9q";
        $field2 = array('depression_screen_id','service_place_type','patient_type','ts_id','pg_id','vdate','assuser','dupdate');
        $headData = $connDB->insert($table2, $data2,$field2);
        if($headData===false){
            $res = array("messege"=>'ไม่สามารถบันทึก Head data ได้!!!!');
        }else{
            $res = array("messege"=>'ประเมิน 2Q 8Q 9Q สำเร็จ!!!!');
            }
        }
        print json_encode($res);
        $connDB->close_PDO();
    }