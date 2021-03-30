<?php

class Wosprocess_model{
    // SPLK@2021PDW
	private $db;

	public function __construct()
	{
		$this->db = new Database;
    }

    public function getWOSLastProcess($wosid){
        $this->db->query("SELECT * FROM t_wosprocess WHERE wosid='$wosid' and wos_status is null order by processid DESC");
        return $this->db->single();
    }

    public function getWOSLastProcessByReffid($reffid,$reffidmesin,$idprocess){
        // $this->db->query("SELECT count(*) as 'rows' FROM v_wosprocess01 WHERE reffid='$reffid' and reffidmesin= '$reffidmesin' and wos_status is null");
        // return $this->db->single();
        $this->db->query("SELECT count(*) as 'rows' FROM v_wosprocess01 
        WHERE reffid='$reffid' and reffidmesin= '$reffidmesin' and process_mesin = '$idprocess' and
        wos_status is null");
        return $this->db->single();
    }

    public function getWOSData($wosid){
        $this->db->query("SELECT a.*, b.customer FROM t_wos01 as a INNER JOIN t_bom01 as b on a.bomid = b.bomid WHERE a.id='$wosid'");
        return $this->db->single();
    }

    public function getareadesc($area){
        $this->db->query("SELECT * FROM t_meja WHERE nomeja='$area'");
        return $this->db->single();
    }

    public function save($wosdata){
        try {
            $data      = $wosdata['items'][0];
            $idprocess = $wosdata['items'][1];
            $wosdata   = $this->getWOSData($data['wosid']);
            $lastarea  = $this->getWOSLastProcess($data['wosid']);
    
            $query1 = "INSERT INTO t_wosprocess(wosid,area,reffidmesin,process_mesin,createdon,createdby)
            VALUES(:wosid,:area,:reffidmesin,:process_mesin,:createdon,:createdby)";
    
            $this->db->query($query1);
            $this->db->bind('wosid',       $data['wosid']);
            $this->db->bind('area',        $data['area']);
            $this->db->bind('reffidmesin', $data['reffidmesin']);
            $this->db->bind('process_mesin', $idprocess['process']);
            $this->db->bind('createdon',   date('Y-m-d'));
            $this->db->bind('createdby',   $_SESSION['usr']['user']);
    
            $this->db->execute();
    
            if($lastarea){
                $this->saveWIP('OUT',$lastarea['area'],$data['area'],$idprocess['process'],$wosdata['bomid'],$wosdata['partnumber'],$wosdata['customer'],$wosdata['quantity'],$data['wosid']);
            }else{
                $this->saveWIP('IN',$data['area'],0,$idprocess['process'],$wosdata['bomid'],$wosdata['partnumber'],$wosdata['customer'],$wosdata['quantity'],$data['wosid']);
            }        
            return $this->db->rowCount();
        } catch (Exception $e) {
            // $this->db->rollBack();
            $message = 'Caught exception: '.  $e->getMessage(). "\n";
            $return = array(
                "msgtype" => "0",
                "message" => $message
            );
            return $return;
        }
    }

    public function saveWIP($wiptype,$area1,$area2,$process,$bomid,$part,$customer,$quantity,$wosid){
        // try {
            $d2 = new Datetime("now");
            $transid = $d2->format('U');
    
            $query1 = "INSERT INTO t_wip(wipid,wiptype,from_area,dest_area,process_mesin,bomid,partnumber,customer,quantity,periode,wosid,createdon,createdby)
            VALUES(:wipid,:wiptype,:from_area,:dest_area,:process_mesin,:bomid,:partnumber,:customer,:quantity,:periode,:wosid,:createdon,:createdby)";
    
            $this->db->query($query1);
            $this->db->bind('wipid',        $transid);
            $this->db->bind('wiptype',      $wiptype);
            $this->db->bind('from_area',    $area1);
            $this->db->bind('dest_area',    $area2);
            if($wiptype === "OUT"){
                $this->db->bind('process_mesin',0);
            }else{
                $this->db->bind('process_mesin',$process);
            }
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
                    $query2 = "INSERT INTO t_wip(wipid,wiptype,from_area,dest_area,process_mesin,bomid,partnumber,customer,quantity,periode,wosid,createdon,createdby)
                    VALUES(:wipid,:wiptype,:from_area,:dest_area,:process_mesin,:bomid,:partnumber,:customer,:quantity,:periode,:wosid,:createdon,:createdby)";
        
                    $this->db->query($query2);
                    $this->db->bind('wipid',        $transid);
                    $this->db->bind('wiptype',      'IN');
                    $this->db->bind('from_area',    $area2);
                    $this->db->bind('dest_area',    0);
                    $this->db->bind('process_mesin',$process);
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
        // } catch (Exception $e) {
        //     // $this->db->rollBack();
        //     $message = 'Caught exception: '.  $e->getMessage(). "\n";
        //     $return = array(
        //         "msgtype" => "0",
        //         "message" => $message
        //     );
        //     return $return;
        // }
    }
}