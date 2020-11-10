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
if ($method == 'add_social') {
        //$i=0;
        //$hcode = $conv->utf8_to_tis620('14644');
        $vdate = $_POST['vstdate'];
        $vn = $_POST['vn'];
        $hn = $_POST['hn'];
        $contributor = $conv->utf8_to_tis620($_POST['contributor']);
        $relevance = $conv->utf8_to_tis620($_POST['relevance']);
        $symptom = $conv->utf8_to_tis620($_POST['symptom']);
        // $psych_history = $_POST['psych_history'];
        // $psych_comm = isset($_POST['psych_comm'])?$conv->utf8_to_tis620($_POST['psych_comm']):'';
        $hurt_salf = $_POST['hurt_salf'];
        $hurt_comm = isset($_POST['hurt_comm'])?$conv->utf8_to_tis620($_POST['hurt_comm']):'';
        $spawn = $_POST['spawn'];
        $spawn_comm = isset($_POST['spawn_comm'])?$conv->utf8_to_tis620($_POST['spawn_comm']):'';
        $evolu = $_POST['evolu'];
        $evolu_comm = isset($_POST['evolu_comm'])?$conv->utf8_to_tis620($_POST['evolu_comm']):'';
        $twitch = $_POST['twitch'];
        $twitch_comm = isset($_POST['twitch_comm'])?$conv->utf8_to_tis620($_POST['twitch_comm']):'';
        $educate = $_POST['educate'];
        // $fall = $_POST['fall'];
        $edu_comm = isset($_POST['edu_comm'])?$conv->utf8_to_tis620($_POST['edu_comm']):'';
        $career = $conv->utf8_to_tis620($_POST['career']);
        $marry = $conv->utf8_to_tis620($_POST['marry']);
        $addictive = $_POST['addictive'];
        $addict_comm = isset($_POST['addictive_comm'])?$conv->utf8_to_tis620($_POST['addictive_comm']):'';
        // $accident = $conv->utf8_to_tis620($_POST['accident']);
        // $sick = $conv->utf8_to_tis620($_POST['sick']);
        // $habit = $conv->utf8_to_tis620($_POST['habit']);
        $family = $conv->utf8_to_tis620($_POST['family']);
        $spending = $_POST['spending'];
        $spend_comm = isset($_POST['spend_comm'])?$conv->utf8_to_tis620($_POST['spend_comm']):'';
        // $congenital = $_POST['congenital'];
        // $conge_comm = isset($_POST['conge_comm'])?$conv->utf8_to_tis620($_POST['conge_comm']):'';
        $Sdiag_1 = isset($_POST['Sdiag_1'])?$_POST['Sdiag_1']:'';
        $Sdiag_2 = isset($_POST['Sdiag_2'])?$_POST['Sdiag_2']:'';
        $Sdiag_3 = isset($_POST['Sdiag_3'])?$_POST['Sdiag_3']:'';
        $Sdiag_4 = isset($_POST['Sdiag_4'])?$_POST['Sdiag_4']:'';
        $Sdiag_5 = isset($_POST['Sdiag_5'])?$_POST['Sdiag_5']:'';
        $help = $_POST['help'];
        $help_comm = isset($_POST['help_comm'])?$conv->utf8_to_tis620($_POST['help_comm']):'';
        $source = $_POST['source'];
        $source_comm = isset($_POST['source_comm'])?$conv->utf8_to_tis620($_POST['source_comm']):'';
        $user = $conv->utf8_to_tis620($_POST['user']);
        $dupdate = date('Y-m-d');

        // $sql = "SELECT id+1 as id FROM cgi ORDER BY id desc limit 1 ";
        // $connDB->imp_sql($sql);
        // $id=$connDB->select_a();

        $data = array($vdate,$hn,$vn,$contributor,$relevance,$symptom,$hurt_salf,$hurt_comm,$spawn,$spawn_comm,$evolu,$evolu_comm
        ,$twitch,$twitch_comm,$educate,$edu_comm,$career,$marry,$addictive,$addict_comm,$family,$spending,$spend_comm
        ,$Sdiag_1,$Sdiag_2,$Sdiag_3,$Sdiag_4,$Sdiag_5,$help,$help_comm,$source,$source_comm,$user,$dupdate);
        //$field = array('id','hcode','vdate','vn','hn','sex','dob','pdx','dx0','dx1','dx2','dx3','cgis_score','clinic','user','dupdate');
        $table = "jvl_social01";
        $social = $connDB->insert($table, $data);
        $res = array("messege"=>$social);
    if($social===false){
        $res = array("messege"=>'ไม่สามารถประเมิน Social ได้!!!!');
    }else{
        $res = array("messege"=>'ประเมิน Social สำเร็จ!!!!',"id"=>$social);
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