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
$connDB = new EnDeCode();
$read = "../connection/conn_DB.txt";
$connDB->para_read($read);
$connDB->Read_Text();
$connDB->conn_PDO();

$id=$_POST['id'];

$sql = "SELECT *
FROM lot_item
WHERE li_id= :li_id";
$connDB->imp_sql($sql);
$execute=array(':li_id' => $id);
$detial_lot_item=$connDB->select_a($execute);

if($detial_lot_item['lot_pay']==0){
    $sql = "select receive,pay from material where mate_id= :mate_id";
    $connDB->imp_sql($sql);
    $execute=array(':mate_id' => $detial_lot_item['mate_id']);
    $receive=$connDB->select_a($execute);

    $total_receive = (int) $receive['receive']-$detial_lot_item['item_amount'];//คืนค่าการนำเข้า(receive)ให้ตาราง material

    $data2 = array($total_receive);
        $field = array("receive");
        $table2 = "material";
        $where="mate_id=:mate_id";
        $execute2=array(':mate_id' => $detial_lot_item['mate_id']);
        $edit_material=$connDB->update($table2, $data2, $where, $field, $execute2); 
    
        $sql = "SELECT lot_price,lot_amount FROM lot WHERE lot_id= :lot_id";
        $connDB->imp_sql($sql);
        $execute=array(':lot_id' => $detial_lot_item['lot_id']);
        $chk_lot=$connDB->select_a($execute);

        $lot_price = ($chk_lot['lot_price']-($detial_lot_item['item_price']*$detial_lot_item['item_amount']));
        $lot_amount = $chk_lot['lot_amount']-1;

        $data3 = array($lot_price,$lot_amount);
        $field3 = array("lot_price","lot_amount");
        $table3 = "lot";
        $where3="lot_id=:lot_id";
        $execute3=array(':lot_id' => $detial_lot_item['lot_id']);
        $edit_lot=$connDB->update($table3, $data3, $where3, $field3, $execute3);

        if($edit_lot){
            $table=$_POST['table'];
            $field=$_POST['field'];
            $where=$field."=:".$field;
            $execute=  array(':'.$field => $id);
            $del=$connDB->delete($table, $where , $execute);
            if($del===true){
                echo 'ลบสำเร็จครับ';
            }else{
                echo 'ไม่สามารถลบได้สำเร็จครับ';
            }
        }else{
            echo 'ไม่สามารถลบรายการได้ครับ';
        }
}else{
    echo 'ไม่สามารถลบได้ เนื่องจากมีการเบิกใช้งานไปแล้วครับ';
}
$connDB->close_PDO();
?>