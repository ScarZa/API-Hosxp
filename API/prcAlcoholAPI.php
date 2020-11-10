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
if ($method == 'add_alcohol') {
        //$i=0;
        //$hcode = $conv->utf8_to_tis620('14644');
        $vdate = $_POST['vstdate'];
        $vn = $_POST['vn'];
        $pp_vn = $conv->utf8_to_tis620($vn);
        $hn = $_POST['hn'];
        $pp_hn = $conv->utf8_to_tis620($hn);
        $recorder = $conv->utf8_to_tis620($_POST['recorder']);
        $place = $conv->utf8_to_tis620($_POST['place']);
        // $sex = $conv->utf8_to_tis620($_POST['sex']);
        // $dob = $_POST['birthday'];
        // $pdx = $conv->utf8_to_tis620($_POST['pdx']);
        // $dx0 = $conv->utf8_to_tis620($_POST['dx0']);
        // $dx1 = $conv->utf8_to_tis620($_POST['dx1']);
        // $dx2 = $conv->utf8_to_tis620($_POST['dx2']);
        // $dx3 = $conv->utf8_to_tis620($_POST['dx3']);
        // $cgis_score = $_POST['cgi_score'];
        // $clinic = $conv->utf8_to_tis620($_POST['cgi_clinic']);
        $Q1 = isset($_POST['Q1'])?$_POST['Q1']:0;
        $Q2 = isset($_POST['Q2'])?$_POST['Q2']:0;
        $Q3 = isset($_POST['Q3'])?$_POST['Q3']:0;
        $Q4 = isset($_POST['Q4'])?$_POST['Q4']:0;
        $Q5 = isset($_POST['Q5'])?$_POST['Q5']:0;
        $Q6 = isset($_POST['Q6'])?$_POST['Q6']:0;
        $Q7 = isset($_POST['Q7'])?$_POST['Q7']:0;
        $user = $conv->utf8_to_tis620($_POST['user']);
        $dupdate = date('Y-m-d');
        $pp_date = date('Y-m-d H:i:s');
        $hcode = $conv->utf8_to_tis620('14644');
        $result = $Q2+$Q3+$Q4+$Q5+$Q6+$Q7;
        $data = array($vdate,$hn,$vn,$Q1,$Q2,$Q3,$Q4,$Q5,$Q6,$Q7,$result,$user,$dupdate);
        $table = "jvl_alcohol01";
        $alcohol = $connDB->insert($table, $data);
        if($alcohol===false){
            $res = array("messege"=>'ไม่สามารถประเมิน Alcohol ได้!!!!');
        }else{
            if($Q1 != 2){
            if($Q1 == 0){
                $pp_code = $conv->utf8_to_tis620('270');
            }elseif($Q1 == 1){
                $pp_code = $conv->utf8_to_tis620('271');
            }
            $sql = "SELECT pp_special_id+1 as id FROM pp_special ORDER BY id desc limit 1 ";
            $connDB->imp_sql($sql);
            $id=$connDB->select_a();
    
            $data = array($id['id'],$pp_vn,$pp_code,$recorder,$place,$pp_date,$hcode,null,null,$pp_hn);
            $field = array('pp_special_id','vn','pp_special_type_id','doctor','pp_special_service_place_type_id'
                        ,'entry_datetime','dest_hospcode','hos_guid','pp_special_text','hn');
            $table = "pp_special";
            $pp_special= $connDB->insert($table, $data, $field);
            }elseif($Q1 == 2){
                if($result<=10){
                    $pp_code[0] = $conv->utf8_to_tis620('272');
                    $pp_code[1] = $conv->utf8_to_tis620('276');
                }elseif($result>=11 and $result<=26){
                    $pp_code[0] = $conv->utf8_to_tis620('273');
                    $pp_code[1] = $conv->utf8_to_tis620('277');
                }elseif($result>=27){
                    $pp_code[0]= $conv->utf8_to_tis620('274');
                    $pp_code[1] = $conv->utf8_to_tis620('277');
                }
                for($i=0;$i<=1;$i++){
                    $sql = "SELECT pp_special_id+1 as id FROM pp_special ORDER BY id desc limit 1 ";
                    $connDB->imp_sql($sql);
                    $id=$connDB->select_a();
                    $data = array($id['id'],$pp_vn,$pp_code[$i],$recorder,$place,$pp_date,$hcode,null,null,$pp_hn);
                    $field = array('pp_special_id','vn','pp_special_type_id','doctor','pp_special_service_place_type_id','entry_datetime','dest_hospcode','hos_guid','pp_special_text','hn');
                    $table = "pp_special";
                    $pp_special= $connDB->insert($table, $data, $field);
                }
            }
            if($pp_special===false){
                $res = array("messege"=>'ไม่สามารถประเมิน Alcohol ได้!!!!');
            }else{
            $res = array("messege"=>'ประเมิน Alcohol สำเร็จ!!!!');
            }
        }
            
        print json_encode($res);
        $connDB->close_PDO();
}elseif ($method == 'edit_lotitem') {
    $lot_price=0;
    $li_id = $_POST['li_id'];
    $lot_id = $_POST['lot_id'];
    $db_id = $_POST['db_id'];
    $item_price = $_POST['item_price'];
    $item_amount = $_POST['item_amount'];
    $sell_price = $_POST['sell_price'];
    $expire_date = insert_date($_POST['expire_date']);

    $sql = "select receive,sell from drug_brand where db_id= :db_id";
    $connDB->imp_sql($sql);
    $execute=array(':db_id' => $db_id);
    $receive=$connDB->select_a($execute);
    // $total_receive = (int) $item_amount + (int) $receive['receive'];
    // $total_now = $total_receive - (int) $receive['sell'];

    $sql = "select item_price,item_amount from lot_item where li_id= :li_id";
    $connDB->imp_sql($sql);
    $execute=array(':li_id' => $li_id);
    $amount=$connDB->select_a($execute);
    $total_receive = (int) $item_amount + ((int) $receive['receive']-$amount['item_amount']);
    $total_now = $total_receive - (int) $receive['sell'];

    $data = array($db_id,$item_price,$item_amount,$sell_price,$expire_date,$total_now);
    $field = array("db_id","item_price","item_amount","sell_price","expire_date","total_now");
    $table = "lot_item";
    $where="li_id=:li_id";
    $execute=array(':li_id' => $li_id);
    $edit_lot_item = $connDB->update($table, $data, $where, $field, $execute);

    if($edit_lot_item){
        $data2 = array($total_receive);
        $field = array("receive");
        $table2 = "drug_brand";
        $where="db_id=:db_id";
        $execute2=array(':db_id' => $db_id);
        $edit_drug_brand=$connDB->update($table2, $data2, $where, $field, $execute2); 

        $lot_price += $item_price*$item_amount;
    }
    else if(!$add_lot_item){
        $res = array("messege"=>'เพิ่มรายการไม่สำเร็จ!!!! '.$edit_lot_item->errorInfo());
        print json_encode($res);
    }
    $sql = "SELECT lot_price,lot_amount FROM lot WHERE lot_id= :lot_id";
    $connDB->imp_sql($sql);
    $execute=array(':lot_id' => $lot_id);
    $chk_lot=$connDB->select_a($execute);

    $lot_price = ($chk_lot['lot_price']-($amount['item_price']*$amount['item_amount'])+$lot_price);
    $lot_amount = $chk_lot['lot_amount'];

    $data3 = array($lot_price,$lot_amount);
    $field3 = array("lot_price","lot_amount");
    $table3 = "lot";
    $where3="lot_id=:lot_id";
    $execute3=array(':lot_id' => $lot_id);
    $edit_lot=$connDB->update($table3, $data3, $where3, $field3, $execute3); 

    $res = array("messege"=>'เพิ่มรายการสำเร็จ!!!!');
    print json_encode($res);
    $connDB->close_PDO();
}