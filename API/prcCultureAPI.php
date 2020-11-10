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
if ($method == 'add_culture') {
        //$i=0;
        //$hcode = $conv->utf8_to_tis620('14644');
        $vdate = $_POST['vstdate'];
        $vn = $_POST['vn'];
        $hn = $_POST['hn'];
        // $sex = $conv->utf8_to_tis620($_POST['sex']);
        // $dob = $_POST['birthday'];
        // $pdx = $conv->utf8_to_tis620($_POST['pdx']);
        // $dx0 = $conv->utf8_to_tis620($_POST['dx0']);
        // $dx1 = $conv->utf8_to_tis620($_POST['dx1']);
        // $dx2 = $conv->utf8_to_tis620($_POST['dx2']);
        // $dx3 = $conv->utf8_to_tis620($_POST['dx3']);
        // $cgis_score = $_POST['cgi_score'];
        // $clinic = $conv->utf8_to_tis620($_POST['cgi_clinic']);
        $a1_1 = $_POST['A1-1'];
        $a1_2 = $_POST['A1-2'];
        $a1_3 = $_POST['A1-3'];
        $a1_4 = $_POST['A1-4'];
        $a1_5 = $_POST['A1-5'];
        $a1_6 = $_POST['A1-6'];
        $q1_7 = $conv->utf8_to_tis620($_POST['Q1-7']);
        $a1_7 = $_POST['A1-7'];
        $a1_8 = $_POST['A1-8'];
        $a2_1 = $_POST['A2-1'];
        $a2_2 = $_POST['A2-2'];
        $a2_3 = $_POST['A2-3'];
        $a2_4 = $_POST['A2-4'];
        $a2_5 = $_POST['A2-5'];
        $a2_6 = $_POST['A2-6'];
        $a2_7 = $_POST['A2-7'];
        $a2_8 = $_POST['A2-8'];
        $q2_9 = $conv->utf8_to_tis620($_POST['Q2-9']);
        $a2_9 = $_POST['A2-9'];
        $result = $_POST['result'];
        $user = $conv->utf8_to_tis620($_POST['user']);
        $dupdate = date('Y-m-d');

        // $sql = "SELECT id+1 as id FROM cgi ORDER BY id desc limit 1 ";
        // $connDB->imp_sql($sql);
        // $id=$connDB->select_a();

        $data = array($vdate,$hn,$vn,$a1_1,$a1_2,$a1_3,$a1_4,$a1_5,$a1_6,$q1_7,$a1_7,$a1_8
        ,$a2_1,$a2_2,$a2_3,$a2_4,$a2_5,$a2_6,$a2_7,$a2_8,$q2_9,$a2_9,$result,$user,$dupdate);
        //$field = array('id','hcode','vdate','vn','hn','sex','dob','pdx','dx0','dx1','dx2','dx3','cgis_score','clinic','user','dupdate');
        $table = "jvl_culture_form01";
        $culture = $connDB->insert($table, $data);
    if($culture===false){
        $res = array("messege"=>'ไม่สามารถประเมิน culture ได้!!!!');
    }else{
        $res = array("messege"=>'ประเมิน culture สำเร็จ!!!!');
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