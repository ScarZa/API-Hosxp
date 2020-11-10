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
include_once ('../plugins/funcDateThai.php');
set_time_limit(0);
$conn_DB= new EnDeCode();
$conv=new convers_encode();
$read="../connection/conn_DB.txt";
$conn_DB->para_read($read);
$conn_DB->Read_Text();
$conn_DB->conn_PDO();
$result = array();
$series = array();
$data = isset($_POST['data'])?$_POST['data']:(isset($_GET['data'])?$_GET['data']:'');
$data2 = isset($_POST['data2'])?$_POST['data2']:(isset($_GET['data2'])?$_GET['data2']:'');
if(!empty($data2)){
    $sql="select p.hn,p.pname,p.fname,p.lname,p.sex,p.informaddr,p.cid,p.birthday,concat(v.age_y,' ปี ',v.age_m,' เดือน ') age,m.name as mrname,a.an,a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5,w.name,pt.name ptname
    from patient p 
    LEFT OUTER JOIN an_stat a ON a.hn=p.hn
    left outer join marrystatus m on p.marrystatus=m.code 
    inner join ward w on w.ward = a.ward
    left outer join pttype pt on a.pttype=pt.pttype
    where a.an= :an";
    $conn_DB->imp_sql($sql);
    $execute=array(':an'=>$data2);
    $rslt=$conn_DB->select_a($execute);
    $ward = $conv->tis620_to_utf8( $rslt['name']);
    $series['ward'] = 'Admit ที่ : '.$ward;
}else {
    $sql="select p.hn,p.pname,p.fname,p.lname,p.sex,p.informaddr,p.cid,p.birthday,concat(v.age_y,' ปี ',v.age_m,' เดือน ') age,m.name as mrname,v.vn,v.pdx,v.dx0,v.dx1,v.dx2,v.dx3,v.dx4,v.dx5
    ,pt.name ptname,oc.bw,oc.height,oc.bmi,oc.pmh,oc.cc,oc.hpi,oc.temperature,oc.pulse,oc.rr,oc.bps,oc.bpd,cgi.cgis_score,ds.depression_score,ds.suicide_score
    from patient p 
    LEFT OUTER JOIN vn_stat v ON v.hn=p.hn
	left outer join opdscreen oc on oc.vn=v.vn
    left outer join marrystatus m on p.marrystatus=m.code 
    left outer join pttype pt on v.pttype=pt.pttype
	left outer join cgi on cgi.vn = v.vn
	left outer join depression_screen ds on ds.vn=v.vn
    where v.vn= :vn";
    $conn_DB->imp_sql($sql);
    $execute=array(':vn'=>$data);
    $rslt=$conn_DB->select_a($execute);
}

//print_r($rslt);

//for($i=0;$i<count($rslt);$i++){
    $pname=$conv->tis620_to_utf8( $rslt['pname']);
    $fname=$conv->tis620_to_utf8( $rslt['fname']);
    $lname=$conv->tis620_to_utf8( $rslt['lname']);
    $series['fullname'] = $pname.$fname.' '.$lname;
    $series['hn'] = $rslt['hn'];
    $series['sex'] = $rslt['sex'];
    $series['informaddr'] = $conv->tis620_to_utf8( $rslt['informaddr']);
    $series['cid'] = $rslt['cid'];
    $series['birthday'] = DateThai1($rslt['birthday']);
    $series['age'] = $rslt['age'];
    $series['mrname'] = $conv->tis620_to_utf8( $rslt['mrname']);
    $series['pdx'] = $rslt['pdx'];
    $series['dx0'] = $rslt['dx0'];
    $series['dx1'] = $rslt['dx1'];
    $series['dx2'] = $rslt['dx2'];
    $series['dx3'] = $rslt['dx3'];
    $series['dx4'] = $rslt['dx4'];
    $series['dx5'] = $rslt['dx5'];
    $series['ptname'] = $conv->tis620_to_utf8( $rslt['ptname']);
    $series['bw'] = round($rslt['bw'],2);
    $series['height'] = $rslt['height'];
    $series['bmi'] = round($rslt['bmi'],2);
    $series['pmh'] = $conv->tis620_to_utf8( $rslt['pmh']);
    $series['cc'] = $conv->tis620_to_utf8( $rslt['cc']);
    $series['hpi'] = $conv->tis620_to_utf8( $rslt['hpi']);
    $series['temp'] = round($rslt['temperature'],1);
    $series['pr'] = round($rslt['pulse']);
    $series['rr'] = round($rslt['rr']);
    $series['bps'] = round($rslt['bps']);
    $series['bpd'] = round($rslt['bpd']);
    $series['Q9'] = isset($rslt['depression_score'])?$rslt['depression_score']:'-';
    $series['Q8'] = isset($rslt['suicide_score'])?$rslt['suicide_score']:'-';
    $series['cgi'] = isset($rslt['cgis_score'])?$rslt['cgis_score']:'-';
array_push($result, $series);    
//}
//print_r($result);
print json_encode($result);
$conn_DB->close_PDO();
?>