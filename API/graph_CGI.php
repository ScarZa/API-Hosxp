<?php 
header('Content-type: text/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Allow-Credentials: true");
function __autoload($class_name) {
    include '../class/'.$class_name.'.php';
}
set_time_limit(0);
$conn_DB= new EnDeCode();
$read="../connection/conn_DB.txt";
$conn_DB->para_read($read);
$conn_db=$conn_DB->Read_Text();
$conn_DB->conn_PDO();
include_once '../plugins/funcDateThai.php';
$rslt = array();
$series = array();
$dep= array();
$hn = $_GET['data'];

                        $sql = "SELECT vdate
                        FROM cgi
                        WHERE hn='$hn'
                        ORDER BY id asc";
                        $conn_DB->imp_sql($sql);
                        $data=$conn_DB->select();
                        
    for($i=0;$i<count($data);$i++){
    $date[$i] = DateThai1($data[$i]['vdate']);
       
    }  
    $series['date'] = $date;
    
    //array_push($rslt, $series); 
    print json_encode($series);
    $conn_DB->close_PDO();
                    ?>