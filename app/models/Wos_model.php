<?php

class Wos_model{

	private $db;

	public function __construct()
	{
		$this->db = new Database;
    }

    public function reffidvalidation($reffid){
        $this->db->query("SELECT COUNT(*) as 'rows' FROM t_wos01 WHERE reffid='$reffid' and wos_status = '1'");
        return $this->db->single();
    }

    public function getwosdata($reffid){
        $this->db->query("SELECT * FROM v_wos01 WHERE reffid='$reffid' and wos_status = '1'");
        return $this->db->single();
    }

    public function getwosbydate($strdate, $enddate){
        $this->db->query("SELECT * FROM v_wos01 WHERE createdon BETWEEN '$strdate' and '$enddate'");
        return $this->db->resultSet();
    }

    public function checkWosLastPosition($reffid){
        $wosdata  = $this->getwosdata($reffid);
        $lastarea = $this->getWOSLastProcess($wosdata['id']);
        return $lastarea;
    }

    public function getWOSLastProcess($wosid){
        $this->db->query("SELECT a.*, b.nomeja, b.deskripsi as 'namameja' FROM t_wosprocess as a left join t_meja as b on a.reffidmesin = b.reffid WHERE a.wosid='$wosid' and a.wos_status is null order by a.processid DESC");
        return $this->db->single();
    }

    public function save($data){
        $query1 = "INSERT INTO t_wos01(reffid,bomid,partnumber,quantity,wpnumber,circuitno,stardate,enddate,wos_status,createdon,createdby)
        VALUES(:reffid,:bomid,:partnumber,:quantity,:wpnumber,:circuitno,:stardate,:enddate,:wos_status,:createdon,:createdby)";

        $this->db->query($query1);
        $this->db->bind('reffid',      $data['reffid']);
        $this->db->bind('bomid',       $data['bomid']);
        $this->db->bind('partnumber',  $data['partnumber']);
        $this->db->bind('quantity',    $data['quantity']);
        $this->db->bind('wpnumber',    $data['wpnumber']);
        $this->db->bind('circuitno',   $data['circuitno']);
        $this->db->bind('stardate',    $data['strdate']);
        $this->db->bind('enddate',     $data['enddate']);
        $this->db->bind('wos_status',  '1');
        $this->db->bind('createdon',   date('Y-m-d'));
        $this->db->bind('createdby',   $_SESSION['usr']['user']);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function savewos($data){

        $reffid = $data['_reffid'];
        $wosqty = $data['_wosqty'];
        $lotng  = $data['_lotng'];

        $query1 = "INSERT INTO t_wos01(reffid,bomid,partnumber,quantity,wpnumber,circuitno,stardate,enddate,wos_status,lotng,createdon,createdby)
        VALUES(:reffid,:bomid,:partnumber,:quantity,:wpnumber,:circuitno,:stardate,:enddate,:wos_status,:lotng,:createdon,:createdby)";

        $this->db->query($query1);
        for($i = 0; $i < sizeof($reffid); $i++){
            $this->db->bind('reffid',      $reffid[$i]);
            $this->db->bind('bomid',       $data['bomid']);
            $this->db->bind('partnumber',  $data['partnumber']);
            $this->db->bind('quantity',    $wosqty[$i]);
            $this->db->bind('wpnumber',    $data['wpnumber']);
            $this->db->bind('circuitno',   $data['circuitno']);
            $this->db->bind('stardate',    $data['strdate']);
            $this->db->bind('enddate',     $data['enddate']);
            $this->db->bind('wos_status',  '1');
            $this->db->bind('lotng',       $lotng[$i]);
            $this->db->bind('createdon',   date('Y-m-d'));
            $this->db->bind('createdby',   $_SESSION['usr']['user']);
    
            $this->db->execute();
        }
        return $this->db->rowCount();
    }

    public function getLastWIPStock($area,$bomid){
        $this->db->query("SELECT * FROM t_wip_stock WHERE area='$area' and bomid = '$bomid'");
        return $this->db->single();
    }

    public function closewos($reffid, $data){

        $wosdata  = $this->getwosdata($reffid);
        $lastarea = $this->getWOSLastProcess($wosdata['id']);

        $query = "UPDATE t_wos01 set wos_status='2' WHERE reffid='$reffid' and wos_status = '1'";
        $this->db->query($query);
        $this->db->execute();

        if($data['jmlng'] > 0){
            // Update WIP
            $wipqty = $data['jmlcheck'] - $data['jmlng'];
            $querywip1 = "UPDATE t_wip SET quantity=:quantity 
            WHERE wosid=:wosid AND bomid=:bomid AND from_area=:from_area and wiptype=:wiptype";
            $this->db->query($querywip1);
            $this->db->bind('wosid',        $wosdata['id']);
            $this->db->bind('bomid',        $wosdata['bomid']);
            $this->db->bind('from_area',    $lastarea['area']);
            $this->db->bind('wiptype',      'IN');
            $this->db->bind('quantity',     $wipqty);
            $this->db->execute();

            $lastwipstock = $this->getLastWIPStock($lastarea['area'], $wosdata['bomid']);

            $querywip2 = "UPDATE t_wip_stock SET quantity=:quantity 
            WHERE area=:area AND bomid=:bomid";
            $this->db->query($querywip2);
            $this->db->bind('area',         $lastarea['area']);
            $this->db->bind('bomid',        $wosdata['bomid']);
            $this->db->bind('quantity',     $lastwipstock['quantity']-$data['jmlng']);
            $this->db->execute();
            
            if($data['nomeja'] === "other"){
                $data['nomeja'] = $data['mesinother'];
            }
            
            $query1 = "INSERT INTO t_inspection(lotng,isnpecdate,inspector,customer,operator,assyno,cctno,idsection,process,jumlahcheck,nomeja,jenisdefect,jumlahng,createdon,createdby)
            VALUES(:lotng,:isnpecdate,:inspector,:customer,:operator,:assyno,:cctno,:idsection,:process,:jumlahcheck,:nomeja,:jenisdefect,:jumlahng,:createdon,:createdby)";
    
            $this->db->query($query1);
            $this->db->bind('lotng',        $data['lotng']);
            $this->db->bind('isnpecdate',   $data['idate']);
            $this->db->bind('inspector',    $data['inspector']);
            $this->db->bind('customer',     $data['cusotmer']);
            $this->db->bind('operator',     $data['operator']);
            $this->db->bind('assyno',       $data['assyno']);
            $this->db->bind('cctno',        $data['cctno']);
            $this->db->bind('idsection',    $data['section']);
            $this->db->bind('process',      $data['process']);
            $this->db->bind('jumlahcheck',  $data['jmlcheck']);
            $this->db->bind('nomeja',       $data['nomeja']);
            $this->db->bind('jenisdefect',  $data['jdefect']);
            $this->db->bind('jumlahng',     $data['jmlng']);
            $this->db->bind('createdon',    date('Y-m-d h:m:s'));
            $this->db->bind('createdby',    $_SESSION['usr']['user']);
            $this->db->execute();
        }
        
        return $this->db->rowCount();
    }

    public function saveWIP($wiptype,$area1,$area2,$bomid,$part,$customer,$quantity,$wosid){
        try {
            $d2 = new Datetime("now");
            $transid = $d2->format('U');
    
            $query1 = "INSERT INTO t_wip(wipid,wiptype,from_area,dest_area,bomid,partnumber,customer,quantity,periode,wosid,createdon,createdby)
            VALUES(:wipid,:wiptype,:from_area,:dest_area,:bomid,:partnumber,:customer,:quantity,:periode,:wosid,:createdon,:createdby)";
    
            $this->db->query($query1);
            $this->db->bind('wipid',        $transid);
            $this->db->bind('wiptype',      $wiptype);
            $this->db->bind('from_area',    $area1);
            $this->db->bind('dest_area',    $area2);
            $this->db->bind('bomid',        $bomid);
            $this->db->bind('partnumber',   $part);
            $this->db->bind('customer',     $customer);
            $this->db->bind('quantity',     $quantity);
            $this->db->bind('periode',      date('Y-m-d'));
            $this->db->bind('wosid',        $wosid);
            $this->db->bind('createdon',    date('Y-m-d h:m:s'));
            $this->db->bind('createdby',    $_SESSION['usr']['user']);
            $this->db->execute();
    
            if($wiptype === "OUT"){
    
                $areadesc = $this->getareadesc($area2);
                if (strpos($areadesc['deskripsi'], 'DELIVERY') !== false) {
                    
                }else{
                    $query2 = "INSERT INTO t_wip(wipid,wiptype,from_area,dest_area,bomid,partnumber,customer,quantity,periode,wosid,createdon,createdby)
                    VALUES(:wipid,:wiptype,:from_area,:dest_area,:bomid,:partnumber,:customer,:quantity,:periode,:wosid,:createdon,:createdby)";
        
                    $this->db->query($query2);
                    $this->db->bind('wipid',        $transid);
                    $this->db->bind('wiptype',      'IN');
                    $this->db->bind('from_area',    $area2);
                    $this->db->bind('dest_area',    0);
                    $this->db->bind('bomid',        $bomid);
                    $this->db->bind('partnumber',   $part);
                    $this->db->bind('customer',     $customer);
                    $this->db->bind('quantity',     $quantity);
                    $this->db->bind('periode',      date('Y-m-d'));
                    $this->db->bind('wosid',        $wosid);
                    $this->db->bind('createdon',    date('Y-m-d h:m:s'));
                    $this->db->bind('createdby',    $_SESSION['usr']['user']);
                    $this->db->execute();
                }
            }
            
            return $this->db->rowCount();
        } catch (Exception $e) {
            $this->db->rollBack();
            $message = 'Caught exception: '.  $e->getMessage(). "\n";
            $return = array(
                "msgtype" => "0",
                "message" => $message
            );
            return $return;
        }
    }
}