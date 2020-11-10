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
if ($method == 'add_cc') {
        //$i=0;
        $vn = $conv->utf8_to_tis620($_POST['vn']);
        $hn = $conv->utf8_to_tis620($_POST['hn']);
        $dep_send = $conv->utf8_to_tis620($_POST['dep_send']);
        $dep_res = $conv->utf8_to_tis620($_POST['dep_res']);
        $cons_id = $conv->utf8_to_tis620($_POST['cons_id']);
        $cause = $conv->utf8_to_tis620($_POST['cause']);
        $sender = $conv->utf8_to_tis620($_POST['user']);
        $send_date = date('Y-m-d');
        $send_time = date('H:i');
        $ward = isset($_POST['ward'])?$_POST['ward']:'';

        $sql = "SELECT tB_id FROM jvl_transferBox where hn ='".$hn ."' and send_date ='".$send_date."' and dep_res ='".$dep_res."'";
        $connDB->imp_sql($sql);
        $chk_send=$connDB->select_a();
        if(empty($chk_send)){

        $data = array($hn,$vn,$dep_send,$dep_res,$cons_id,$cause,$send_date,$sender);
        $field = array('hn','vn','dep_send','dep_res','cons_id','cause','send_date','sender');
        $table = "jvl_transferBox";
        $add_transferBox = $connDB->insert($table, $data, $field);
    if($add_transferBox===false){
        $res = array("messege"=>'ไม่สามารถส่งเคสได้!!!!');
    }else{
        $sql = "SELECT dm.department,dm.depcode,ou.name
        FROM jvl_transferBox tb
        inner join kskdepartment dm on dm.depcode = tb.dep_send
        inner join opduser ou on ou.loginname = tb.sender
        WHERE tb.tB_id = ".$add_transferBox;
        $connDB->imp_sql($sql);
        $selDep_send=$connDB->select_a();

        $sql = "SELECT department
        FROM kskdepartment
        WHERE depcode = '".$dep_res."'";
        $connDB->imp_sql($sql);
        $depres=$connDB->select_a();

        $sql = "SELECT cons_name
        FROM jvl_consult
        WHERE cons_id =".$cons_id;
        $connDB->imp_sql($sql);
        $cons=$connDB->select_a();
        //////////////////// Line Notify //////////////////////////////
//if(!empty($_SESSION['m_tokenkey'])){  
    include_once '../function/LineNotify.php';  
    include_once '../plugins/funcDateThai.php';
    $token = "ZC643LLAoKB1iyumnNF4jMN8rxcYDnRWj1Tviec2Zp1";
    $text =  "\nถึง : ".$conv->tis620_to_utf8($depres['department'])."\nHN : ".$hn." ".$ward
    ."\nเพื่อ : ".$conv->tis620_to_utf8($cons['cons_name'])."\nสาเหตุ : ".$conv->tis620_to_utf8($cause)."\nงานที่ส่ง : ".$conv->tis620_to_utf8($selDep_send['department'])."\nผู้ส่ง : ".$conv->tis620_to_utf8($selDep_send['name'])
    ."\nวันที่ ".DateThai1($send_date)." เวลา ".$send_time." น.";
     
    $resnoti = notify_message($text,$token);
    //}
    //print_r($res);
    
    /////////////////////
        $res = array("messege"=>'ส่งเคสสำเร็จ!!!!');
    }
}else{
    $res = array("messege"=>'มีการบันทึกการส่งปรึกษาเคส '.$_POST['hn'].' เรียบร้อยแล้วครับ หากไม่มีการแจ้งเตือนใน Line กรุณาโทรแจ้งงานที่ส่งและงามคอมพิวเตอร์ด้วยครับ!!!!');
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