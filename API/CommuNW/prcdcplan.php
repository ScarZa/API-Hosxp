<?php
header('Content-type: text/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Allow-Credentials: true");

function __autoload($class_name) {
    include '../../class/' . $class_name . '.php';
}
include '../../plugins/funcDateThai.php';
$conn_DB = new EnDeCode();
$conv=new convers_encode();
$read = "../../connection/conn_DB.txt";
$conn_DB->para_read($read);
$conn_DB->Read_Text();
$conn_DB->conn_PDO();
$result = array();
$series = array();

    $dcp_id = $_POST['dcp_id'];
    $hn = $_POST['hn'];
    $vn = $_POST['vn'];
    $an = $_POST['an'];
    $assent_tel = $_POST['assent_tel'];
    $assent_jvl = $_POST['assent_jvl'];
    $assent_cn = $_POST['assent_cn'];
    $assent_drug = $_POST['assent_drug'];
    $recorder = $_POST['recorder'];
    $regdate = date('Y-m-d H:i:s');

    $data = array($dcp_id,$hn,$vn,$an,$assent_tel,$assent_jvl,$assent_cn,$assent_drug,$recorder,$regdate);
    //$field = array("reg_status","confdate");
    $table = "jvl_dcplan";
    $dcplan = $conn_DB->insert($table, $data);
    if($dcplan != false){
        
        $sql0 = "SELECT a.hn from an_stat a WHERE a.an = :an";
        $conn_DB->imp_sql($sql0);
        $execute=array(':an' => $an);
        $rslt0=$conn_DB->select_a($execute);
            $sql="select (SELECT count(a.an) from an_stat a WHERE a.hn = '".$rslt0['hn']."')admit
            ,(SELECT count(smi.hn) from jvl_smiv smi WHERE smi.hn = '".$rslt0['hn']."' and smi.confirm = 3)smiv
            ,(SELECT oap.nextdate from oapp oap WHERE oap.vn=:vn)nextdate
            ,v1.vn,v1.hn,v1.pttype_expire,re.expire_date,v1.age_y,v1.age_m,o1.vstdate,SUBSTR(o1.vsttime,1,5)vsttime,hos.Dhospital
                ,ifr.typep,ifr.typep_1,ifr.typep_3,ifr.lawpsych_chk,ifr.bw,ifr.height,ifr.bmi,ifr.pmh,ifr.cc,ifr.hpi,s.temperature,s.pulse,s.rr,s.bps,s.bpd
                ,p.pname,p.fname,p.lname
                ,CASE
                    WHEN p.sex = 1 THEN 'ชาย'
                ELSE 'หญิง' END as sex
                #,CASE
                #    WHEN a.lastvisit = '999' THEN 'ไม่เคย admit'
                #ELSE a.lastvisit END as lastvisit
                ,a.admdate
                ,ipt.dchdate,SUBSTR(ipt.dchtime,1,5)dchtime
                ,ifr.biographer,ifr.relative,ifr.tel0 hometel,ifr.patient_add informaddr,ifr.tel1 informtel,ifr.relative1,ifr.tel2,ifr.relative2,p.cid,p.birthday,p.bloodgrp,p.drugallergy,ill.cc_persist_disease disease
                ,n.name nation_name,r.name religion_name,e.name edu_name,occ.name occ_name
                ,p.addrpart,p.moopart,t3.name tambon,t2.name ampher,t1.name changwat
                ,SUBSTR(v1.pdx,1,3)mpdx,SUBSTR(v1.pdx,4,1)spdx
                ,concat(v1.pdx,' ',ic1.name)as dxname1,concat(v1.dx0,' ',ic2.name) as dxname2,concat(v1.dx1,' ',ic3.name) as dxname3
                ,concat(v1.dx2,' ',ic4.name) as dxname4 ,c.name clinic,h.name as refername,ovs.name as ovstistname,d.name as docName,pt1.name ptname1,pt2.name ptname2,cgi.cgis_score,ds.depression_score,ds.suicide_score
                ,(SELECT concat(di.name,' ',di.strength) FROM opitemrece op inner join patient p on op.hn = p.hn inner join ovst o1 on p.hn = o1.hn inner join vn_stat vt on vt.vn = o1.vn inner join drugitems di on di.icode = op.icode WHERE op.icode = '1480070' and ((o1.vn = :vn 
            and op.income in(03,19))) GROUP BY op.vstdate ORDER BY op.vstdate desc limit 1)Clozapine100
            ,(SELECT op.vstdate FROM opitemrece op inner join patient p on op.hn = p.hn inner join ovst o1 on p.hn = o1.hn inner join vn_stat vt on vt.vn = o1.vn inner join drugitems di on di.icode = op.icode WHERE op.icode = '1480070' and ((o1.vn = :vn 
            and op.income in(03,19))) GROUP BY op.vstdate ORDER BY op.vstdate desc limit 1)Clozapine100Date
            ,(SELECT concat(di.name,' ',di.strength) FROM opitemrece op inner join patient p on op.hn = p.hn inner join ovst o1 on p.hn = o1.hn inner join vn_stat vt on vt.vn = o1.vn inner join drugitems di on di.icode = op.icode WHERE op.icode = '1480069' and ((o1.vn = :vn 
            and op.income in(03,19))) GROUP BY op.vstdate ORDER BY op.vstdate desc limit 1)Clozapine25
            ,(SELECT op.vstdate FROM opitemrece op inner join patient p on op.hn = p.hn inner join ovst o1 on p.hn = o1.hn inner join vn_stat vt on vt.vn = o1.vn inner join drugitems di on di.icode = op.icode WHERE op.icode = '1480069' and ((o1.vn = :vn 
            and op.income in(03,19))) GROUP BY op.vstdate ORDER BY op.vstdate desc limit 1)Clozapine25Date
            ,(SELECT concat(di.name,' ',di.strength) FROM opitemrece op inner join patient p on op.hn = p.hn inner join ovst o1 on p.hn = o1.hn inner join vn_stat vt on vt.vn = o1.vn inner join drugitems di on di.icode = op.icode WHERE op.icode = '1000059' and ((o1.vn = :vn 
            and op.income in(03,19))) GROUP BY op.vstdate ORDER BY op.vstdate desc limit 1)Carbamazepine200
            ,(SELECT op.vstdate FROM opitemrece op inner join patient p on op.hn = p.hn inner join ovst o1 on p.hn = o1.hn inner join vn_stat vt on vt.vn = o1.vn inner join drugitems di on di.icode = op.icode WHERE op.icode = '1000059' and ((o1.vn = :vn 
            and op.income in(03,19))) GROUP BY op.vstdate ORDER BY op.vstdate desc limit 1)Carbamazepine200Date
            ,(SELECT concat(di.name,' ',di.strength) FROM opitemrece op inner join patient p on op.hn = p.hn inner join ovst o1 on p.hn = o1.hn inner join vn_stat vt on vt.vn = o1.vn inner join drugitems di on di.icode = op.icode WHERE op.icode = '1480107' and ((o1.vn = :vn 
            and op.income in(03,19))) GROUP BY op.vstdate ORDER BY op.vstdate desc limit 1)LithiumCarbonate300
            ,(SELECT op.vstdate FROM opitemrece op inner join patient p on op.hn = p.hn inner join ovst o1 on p.hn = o1.hn inner join vn_stat vt on vt.vn = o1.vn inner join drugitems di on di.icode = op.icode WHERE op.icode = '1480107' and ((o1.vn = :vn 
            and op.income in(03,19))) GROUP BY op.vstdate ORDER BY op.vstdate desc limit 1)LithiumCarbonate300Date
            ,(SELECT concat(di.name,' ',di.strength) FROM opitemrece op inner join patient p on op.hn = p.hn inner join ovst o1 on p.hn = o1.hn inner join vn_stat vt on vt.vn = o1.vn inner join drugitems di on di.icode = op.icode WHERE op.icode = '1460332' and ((o1.vn = :vn 
            and op.income in(03,19))) GROUP BY op.vstdate ORDER BY op.vstdate desc limit 1)SodiumValproate200
            ,(SELECT op.vstdate FROM opitemrece op inner join patient p on op.hn = p.hn inner join ovst o1 on p.hn = o1.hn inner join vn_stat vt on vt.vn = o1.vn inner join drugitems di on di.icode = op.icode WHERE op.icode = '1460332' and ((o1.vn = :vn 
            and op.income in(03,19))) GROUP BY op.vstdate ORDER BY op.vstdate desc limit 1)SodiumValproate200Date
            ,(SELECT concat(di.name,' ',di.strength) FROM opitemrece op inner join patient p on op.hn = p.hn inner join ovst o1 on p.hn = o1.hn inner join vn_stat vt on vt.vn = o1.vn inner join drugitems di on di.icode = op.icode WHERE op.icode = '1570044' and ((op.vn = :vn 
            and op.income in(03,19))) GROUP BY op.vstdate ORDER BY op.vstdate desc limit 1)SodiumValproate200CHRONO
            ,(SELECT op.vstdate FROM opitemrece op inner join patient p on op.hn = p.hn inner join ovst o1 on p.hn = o1.hn inner join vn_stat vt on vt.vn = o1.vn inner join drugitems di on di.icode = op.icode WHERE op.icode = '1570044' and ((o1.vn = :vn 
            and op.income in(03,19))) GROUP BY op.vstdate ORDER BY op.vstdate desc limit 1)SodiumValproate200CHRONODate
            ,(SELECT concat(di.name,' ',di.strength) FROM opitemrece op inner join patient p on op.hn = p.hn inner join ovst o1 on p.hn = o1.hn inner join vn_stat vt on vt.vn = o1.vn inner join drugitems di on di.icode = op.icode WHERE op.icode = '1540021' and ((o1.vn = :vn 
            and op.income in(03,19))) GROUP BY op.vstdate ORDER BY op.vstdate desc limit 1)SodiumValproate500
            ,(SELECT op.vstdate FROM opitemrece op inner join patient p on op.hn = p.hn inner join ovst o1 on p.hn = o1.hn inner join vn_stat vt on vt.vn = o1.vn inner join drugitems di on di.icode = op.icode WHERE op.icode = '1540021' and ((o1.vn = :vn 
            and op.income in(03,19))) GROUP BY op.vstdate ORDER BY op.vstdate desc limit 1)SodiumValproate500Date
                from vn_stat v1 
                left outer join an_stat a on a.vn=v1.vn
                left outer join ipt on ipt.an = a.an
                left outer join ovst o1 on o1.vn=v1.vn
                left outer join ovstist ovs on ovs.ovstist = o1.ovstist
                left outer join opdscreen s on s.vn = v1.vn
                inner join jvl_ipd_first_rec ifr on ifr.vn = v1.vn
                #left outer join oapp oap on oap.vn=v1.vn
                left outer join referin re on re.vn=v1.vn
                left outer join hospcode h on h.hospcode = re.hospcode
                left outer join patient p on p.hn=v1.hn
                left outer join nationality n on n.nationality = p.nationality
                left outer join religion r on r.religion = p.religion
                left outer join education e on e.education = p.educate
                left outer join occupation occ on occ.occupation = p.occupation
                left outer join icd101 ic1 on ic1.code=v1.pdx
                left outer join icd101 ic2 on ic2.code=v1.dx0
                left outer join icd101 ic3 on ic3.code=v1.dx1
                left outer join icd101 ic4 on ic4.code=v1.dx2
                left outer join clinicmember cl on cl.hn = v1.hn
                left outer join clinic c on c.clinic = cl.clinic
                left outer join doctor d on d.code = v1.dx_doctor
                left outer join pttype pt1 on p.pttype=pt1.pttype
                left outer join pttype pt2 on o1.pttype=pt2.pttype
                left outer join cgi on cgi.vn = v1.vn
                left outer join depression_screen ds on ds.vn=v1.vn
                left outer join dbhospital hos on hos.idhospital = v1.hospmain
                left outer join thaiaddress t1 on t1.chwpart=p.chwpart and
                     t1.amppart='00' and t1.tmbpart='00'
                left outer join thaiaddress t2 on t2.chwpart=p.chwpart and
                     t2.amppart=p.amppart and t2.tmbpart='00'
                left outer join thaiaddress t3 on t3.chwpart=p.chwpart and
                     t3.amppart=p.amppart and t3.tmbpart=p.tmbpart
                left outer JOIN thaiaddress t4 ON t4.chwpart=p.chwpart
                left outer join opd_ill_history ill on ill.hn = p.hn
                where v1.vn= :vn GROUP BY v1.vn";
            $conn_DB->imp_sql($sql);
            $execute=array(':vn'=>$vn);
            $rslt=$conn_DB->select_a($execute);
        
            $series['admit'] = $rslt['admit'];
            $series['smiv'] = $rslt['smiv'];
            $series['lastvisit'] = $rslt['lastvisit'];
            $series['admdate'] = $rslt['admdate'];
            $series['nextdate'] = isset($rslt['nextdate'])?DateThai1($rslt['nextdate']):'';
            $series['pttype_expire'] = isset($rslt['pttype_expire'])?DateThai1($rslt['pttype_expire']):'';
            $series['expire_date'] = isset($rslt['expire_date'])?DateThai1($rslt['expire_date']):'';
            $series['vstdate'] = DateThai2($rslt['vstdate']);
            $series['vsttime'] = $rslt['vsttime'];
            $series['dchdate'] = isset($rslt['dchdate'])?DateThai2($rslt['dchdate']):'';
            $series['dchtime'] = isset($rslt['dchtime'])?$rslt['dchtime']:'';
            $series['Dhospital'] = $conv->tis620_to_utf8( $rslt['Dhospital']);
            $pname=$conv->tis620_to_utf8( $rslt['pname']);
            $fname=$conv->tis620_to_utf8( $rslt['fname']);
            $lname=$conv->tis620_to_utf8( $rslt['lname']);
            $series['fullname'] = $pname.$fname.' '.$lname;
            $series['hn'] = $rslt['hn'];
            $series['vn'] = $rslt['vn'];
            $series['sex'] = $rslt['sex'];
            $series['biographer'] = $conv->tis620_to_utf8($rslt['biographer']);
            $series['relative'] = $conv->tis620_to_utf8($rslt['relative']);
            $series['address'] = $rslt['addrpart'].' ม.'.$rslt['moopart'].' ต.'. $conv->tis620_to_utf8( $rslt['tambon']).' อ.'. $conv->tis620_to_utf8( $rslt['ampher']).' จ.'. $conv->tis620_to_utf8( $rslt['changwat']);
            $series['hometel'] = $conv->tis620_to_utf8($rslt['hometel']);
            $series['informaddr'] = $conv->tis620_to_utf8( $rslt['informaddr']);
            $series['informtel'] = $conv->tis620_to_utf8($rslt['informtel']);
            $series['relative1'] = $conv->tis620_to_utf8($rslt['relative1']);
            $series['tel2'] = $conv->tis620_to_utf8($rslt['tel2']);
            $series['relative2'] = $conv->tis620_to_utf8($rslt['relative2']);
            $series['cid'] = $rslt['cid'];
            $series['birthday'] = DateThai1($rslt['birthday']);
            $series['bloodgrp'] = $conv->tis620_to_utf8(trim($rslt['bloodgrp']));
            $series['drugallergy'] = $conv->tis620_to_utf8( $rslt['drugallergy']);
            $series['disease'] = $conv->tis620_to_utf8( $rslt['disease']);
            $series['age'] = $conv->tis620_to_utf8($rslt['age_y']).' ปี '.$conv->tis620_to_utf8($rslt['age_m']).' เดือน';
            $series['nation_name'] = $conv->tis620_to_utf8( $rslt['nation_name']);
            $series['religion_name'] = $conv->tis620_to_utf8( $rslt['religion_name']);
            $series['edu_name'] = $conv->tis620_to_utf8( $rslt['edu_name']);
            $series['occ_name'] = $conv->tis620_to_utf8( $rslt['occ_name']);
            $series['mpdx'] = $conv->tis620_to_utf8( $rslt['mpdx']);
            $series['spdx'] = $conv->tis620_to_utf8( $rslt['spdx']);
            $series['dxname1'] = $conv->tis620_to_utf8( $rslt['dxname1']);
            $series['dxname2'] = $conv->tis620_to_utf8( $rslt['dxname2']);
            $series['dxname3'] = $conv->tis620_to_utf8( $rslt['dxname3']);
            $series['dxname4'] = $conv->tis620_to_utf8( $rslt['dxname4']);
            $series['ptname1'] = $conv->tis620_to_utf8( $rslt['ptname1']);
            $series['ptname2'] = $conv->tis620_to_utf8( $rslt['ptname2']);
            $series['refername'] = $conv->tis620_to_utf8( $rslt['refername']);
            $series['clinic'] = $conv->tis620_to_utf8( $rslt['clinic']);
            $series['ovstistname'] = $conv->tis620_to_utf8( $rslt['ovstistname']);
            $series['docName'] = $conv->tis620_to_utf8( $rslt['docName']);
            $series['typep'] = $rslt['typep'];
            $series['typep_1'] = $rslt['typep_1'];
            $series['typep_3'] = $rslt['typep_3'];
            $series['lawpsych_chk'] = $rslt['lawpsych_chk'];
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
            $series['Clozapine100'] = $rslt['Clozapine100'];
            $series['Clozapine100Date'] = isset($rslt['Clozapine100Date'])?DateThai1($rslt['Clozapine100Date']):'';
            $series['Clozapine25'] = $rslt['Clozapine25'];
            $series['Clozapine25Date'] = isset($rslt['Clozapine25Date'])?DateThai1($rslt['Clozapine25Date']):'';
            $series['Carbamazepine200'] = $rslt['Carbamazepine200'];
            $series['Carbamazepine200Date'] = isset($rslt['Carbamazepine200Date'])?DateThai1($rslt['Carbamazepine200Date']):'';
            $series['LithiumCarbonate300'] = $rslt['LithiumCarbonate300'];
            $series['LithiumCarbonate300Date'] = isset($rslt['LithiumCarbonate300Date'])?DateThai1($rslt['LithiumCarbonate300Date']):'';
            $series['SodiumValproate200'] = $rslt['SodiumValproate200'];
            $series['SodiumValproate200Date'] = isset($rslt['SodiumValproate200Date'])?DateThai1($rslt['SodiumValproate200Date']):'';
            $series['SodiumValproate200CHRONO'] = $rslt['SodiumValproate200CHRONO'];
            $series['SodiumValproate200CHRONODate'] = isset($rslt['SodiumValproate200CHRONODate'])?DateThai1($rslt['SodiumValproate200CHRONODate']):'';
            $series['SodiumValproate500'] = $rslt['SodiumValproate500'];
            $series['SodiumValproate500Date'] = isset($rslt['SodiumValproate500Date'])?DateThai1($rslt['SodiumValproate500Date']):'';
        //array_push($result, $series); 

      $res = array("messege"=>'บันทึก Discharge plan สำเร็จ!!!!',"detailPT"=>$series);
  }else{
      $res = array("messege"=>'บันทึก Discharge plan ไม่สำเร็จ!!!!!!!!');
  }
    print json_encode($res);
$conn_DB->close_PDO();
?>