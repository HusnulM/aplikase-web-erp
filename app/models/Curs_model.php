<?php

class Curs_model{

    private $db;

    public function __construct()
    {
		$this->db = new Database;
    }

    public function cursList(){
        $this->db->query("SELECT * FROM t_kurs");
        return $this->db->resultSet(); 
    }

    public function bomHeader($bomid){
        $this->db->query("SELECT * FROM t_bom01 WHERE bomid='$bomid'");
        return $this->db->single(); 
    }

    public function bomDetail($bomid){
        $this->db->query("SELECT a.*, b.matdesc FROM t_bom02 as a left join t_material as b on a.component = b.material WHERE a.bomid='$bomid'");
        return $this->db->resultSet(); 
    }

    public function bomcalculation($bomid,$qty){
        $this->db->query("SELECT a.bomid,a.partnumber,a.component,a.quantity,ROUND(a.quantity*'$qty',2) as 'Total', a.unit, b.matdesc FROM t_bom02 as a left join t_material as b on a.component = b.material WHERE a.bomid='$bomid'");
        return $this->db->resultSet(); 
    }

    public function delete($bomid){
        $this->db->query('DELETE FROM t_bom01 WHERE bomid=:bomid');
        $this->db->bind('bomid',$bomid);
        $this->db->execute();  
        return $this->db->rowCount();
    }

    public function update($data){
        $this->delete($data['bomid']);
        // $this->save($data, $data['bomid']);
        $bomid = $data['bomid'];
        $matnr = $data['itm_material'];
        $menge = $data['itm_qty'];
        $meins = $data['itm_unit'];
        $createdon = date('Y-m-d h:m:s');
        $d2 = new Datetime("now");

        if($bomid == null){
            $bomid = $d2->format('U');
        }

        $query1 = "INSERT INTO t_bom01(bomid,partnumber,partname,customer,createdon,createdby)
                   VALUES(:bomid,:partnumber,:partname,:customer,:createdon,:createdby)
                   ON DUPLICATE KEY UPDATE partnumber=:partnumber,partname=:partname,customer=:customer";

        $this->db->query($query1);
        $this->db->bind('bomid',      $bomid);
        $this->db->bind('partnumber', $data['partnumb']);
        $this->db->bind('partname',   $data['partname']);
        $this->db->bind('customer',   $data['customer']); 
		$this->db->bind('createdon',  $createdon);
        $this->db->bind('createdby',  $_SESSION['usr']['user']);
        $this->db->execute();

        $query2 = "INSERT INTO t_bom02(bomid,partnumber,component,quantity,unit,createdon,createdby)
        VALUES(:bomid,:partnumber,:component,:quantity,:unit,:createdon,:createdby)
        ON DUPLICATE KEY UPDATE partnumber=:partnumber,component=:component,quantity=:quantity,unit=:unit";
        $this->db->query($query2);
        for($i = 0; $i < count($matnr); $i++){
            $_menge = "";
            $_menge = str_replace(".", "",  $menge[$i]);
            $_menge = str_replace(",", ".", $_menge);
            $this->db->bind('bomid',        $bomid);
            $this->db->bind('partnumber',   $data['partnumb']);
            $this->db->bind('component',    $matnr[$i]);            
            $this->db->bind('quantity',     $_menge);
            $this->db->bind('unit',         $meins[$i]);
            $this->db->bind('createdon',    $createdon);
            $this->db->bind('createdby',    $_SESSION['usr']['user']);
            $this->db->execute();
        }

        return $this->db->rowCount();
    }

    public function save($data, $bomid = null){
        $matnr = $data['itm_material'];
        $menge = $data['itm_qty'];
        $meins = $data['itm_unit'];
        $createdon = date('Y-m-d h:m:s');
        $d2 = new Datetime("now");

        if($bomid == null){
            $bomid = $d2->format('U');
        }

        $query1 = "INSERT INTO t_bom01(bomid,partnumber,partname,customer,createdon,createdby)
                   VALUES(:bomid,:partnumber,:partname,:customer,:createdon,:createdby)
                   ON DUPLICATE KEY UPDATE partnumber=:partnumber,partname=:partname,customer=:customer";

        $this->db->query($query1);
        $this->db->bind('bomid',      $bomid);
        $this->db->bind('partnumber', $data['partnumb']);
        $this->db->bind('partname',   $data['partname']);
        $this->db->bind('customer',   $data['customer']); 
		$this->db->bind('createdon',  $createdon);
        $this->db->bind('createdby',  $_SESSION['usr']['user']);
        $this->db->execute();

        $query2 = "INSERT INTO t_bom02(bomid,partnumber,component,quantity,unit,createdon,createdby)
        VALUES(:bomid,:partnumber,:component,:quantity,:unit,:createdon,:createdby)
        ON DUPLICATE KEY UPDATE partnumber=:partnumber,component=:component,quantity=:quantity,unit=:unit";
        $this->db->query($query2);
        for($i = 0; $i < count($matnr); $i++){
            $_menge = "";
            $_menge = str_replace(".", "",  $menge[$i]);
            $_menge = str_replace(",", ".", $_menge);
            $this->db->bind('bomid',        $bomid);
            $this->db->bind('partnumber',   $data['partnumb']);
            $this->db->bind('component',    $matnr[$i]);            
            $this->db->bind('quantity',     $_menge);
            $this->db->bind('unit',         $meins[$i]);
            $this->db->bind('createdon',    $createdon);
            $this->db->bind('createdby',    $_SESSION['usr']['user']);
            $this->db->execute();
        }
        return $this->db->rowCount();
    }
}