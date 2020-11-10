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
if ($method == 'add_Carba') {

        $vn = $_POST['vn'];
        $hn = $_POST['hn'];
        $WBC = isset($_POST['WBC'])?$conv->utf8_to_tis620($_POST['WBC']):'';
        $WBC_val = isset($_POST['WBC_val'])?$_POST['WBC_val']:'';
        $last_WBC = $conv->utf8_to_tis620($_POST['last_CBC']);
        $last_WBC_val = isset($_POST['last_CBC_val'])?$_POST['last_CBC_val']:'';
        $symplomo01 = $conv->utf8_to_tis620($_POST['symplomo01']);
        $symplomo02 = $conv->utf8_to_tis620($_POST['symplomo02']);
        $symplomo03 = $conv->utf8_to_tis620($_POST['symplomo03']);
        $symplomo04 = $conv->utf8_to_tis620($_POST['symplomo04']);
        $symplomo05 = $conv->utf8_to_tis620($_POST['symplomo05']);
        $symplomo06 = $conv->utf8_to_tis620($_POST['symplomo06']);
        $symplomo07 = $conv->utf8_to_tis620($_POST['symplomo07']);
        $symplomo08 = $conv->utf8_to_tis620($_POST['symplomo08']);
        $recorder = $conv->utf8_to_tis620($_POST['user']);
        $regdate = date('Y-m-d H:i:s');

        $data = array($hn,$vn,$last_WBC,$last_WBC_val,$WBC,$WBC_val,$symplomo01,$symplomo02,$symplomo03,$symplomo04,$symplomo05,$symplomo06,$symplomo07,$symplomo08,$regdate,$recorder);
        //$field = array('id','hcode','vdate','vn','hn','sex','dob','pdx','dx0','dx1','dx2','dx3','cgis_score','clinic','user','dupdate');
        $table = "jvl_carbamazepine";
        $carbamazepine = $connDB->insert($table, $data);
        $res = array("messege"=>$carbamazepine);
    if($carbamazepine===false){
        $res = array("messege"=>'ไม่สามารถบันทึกประเมินยา carbamazepine ได้!!!!');
    }else{
        $res = array("messege"=>'บันทึกประเมินยา carbamazepine สำเร็จ!!!!',"id"=>$carbamazepine);
    }
        print json_encode($res);
        $connDB->close_PDO();
}elseif ($method == 'add_social02') {
    //$i=0;
    //$hcode = $conv->utf8_to_tis620('14644');
    $vdate = $_POST['vstdate'];
    $vn = $_POST['vn'];
    $hn = $_POST['hn'];
    $contributor = $conv->utf8_to_tis620($_POST['contributor']);
    $relevance = $conv->utf8_to_tis620($_POST['relevance']);
    $symptom = $conv->utf8_to_tis620($_POST['symptom']);
    $aliment = $conv->utf8_to_tis620($_POST['aliment']);
    $relationship = $conv->utf8_to_tis620($_POST['relationship']);
    $issue_ali = $_POST['issue_ali'];
    $ali_comm = isset($_POST['ali_comm'])?$conv->utf8_to_tis620($_POST['ali_comm']):'';
    $issue_edu = $_POST['issue_edu'];
    $edu_comm = isset($_POST['edu_comm'])?$conv->utf8_to_tis620($_POST['edu_comm']):'';
    $issue_other = $_POST['issue_other'];
    $other_comm = isset($_POST['other_comm'])?$conv->utf8_to_tis620($_POST['other_comm']):'';
    $assessment01 = $_POST['assessment01'];
    $assessment02 = $_POST['assessment02'];
    $ass02_comm = isset($_POST['ass02_comm'])?$conv->utf8_to_tis620($_POST['ass02_comm']):'';
    $assessment03 = $_POST['assessment03'];
    $assessment04 = $_POST['assessment04'];
    $assessment05 = $_POST['assessment05'];
    $assessment06 = $_POST['assessment06'];
    $assessment07 = $_POST['assessment07'];
    $ass07_comm = isset($_POST['ass07_comm'])?$conv->utf8_to_tis620($_POST['ass07_comm']):'';
    $assessment08 = $_POST['assessment08'];
    $assessment09 = $_POST['assessment09'];
    $assessment10 = $_POST['assessment10'];
    $assessment11 = $_POST['assessment11'];
    $assessment12 = $_POST['assessment12'];
    $ass12_comm = isset($_POST['ass12_comm'])?$conv->utf8_to_tis620($_POST['ass12_comm']):'';
    $plan01 = $_POST['plan01'];
    $plan02 = $_POST['plan02'];
    $plan03 = $_POST['plan03'];
    $plan04 = $_POST['plan04'];
    $plan05 = $_POST['plan05'];
    $p05_comm = isset($_POST['p05_comm'])?$conv->utf8_to_tis620($_POST['p05_comm']):'';
    
    $user = $conv->utf8_to_tis620($_POST['user']);
    $dupdate = date('Y-m-d');

    // $sql = "SELECT id+1 as id FROM cgi ORDER BY id desc limit 1 ";
    // $connDB->imp_sql($sql);
    // $id=$connDB->select_a();

    $data = array($vdate,$hn,$vn,$contributor,$relevance,$symptom,$relationship,$aliment,$issue_ali,$ali_comm,$issue_edu,$edu_comm
    ,$issue_other,$other_comm,$assessment01,$assessment02,$ass02_comm,$assessment03,$assessment04,$assessment05,$assessment06,$assessment07,$ass07_comm
    ,$assessment08,$assessment09,$assessment10,$assessment11,$assessment12,$ass12_comm,$plan01,$plan02,$plan03,$plan04,$plan05,$p05_comm,$user,$dupdate);
    //$field = array('id','hcode','vdate','vn','hn','sex','dob','pdx','dx0','dx1','dx2','dx3','cgis_score','clinic','user','dupdate');
    $table = "jvl_social02";
    $social = $connDB->insert($table, $data);
    $res = array("messege"=>$social);
if($social===false){
    $res = array("messege"=>'ไม่สามารถประเมิน Social ได้!!!!');
}else{
    $res = array("messege"=>'ประเมิน Social สำเร็จ!!!!',"id"=>$social);
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