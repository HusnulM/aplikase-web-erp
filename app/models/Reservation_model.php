<?php

class Reservation_model{

    private $db;

    public function __construct(){
		  $this->db = new Database;
    }

    public function getReservation01(){

    }

    public function getWarehouseUtama(){
        $this->db->query("SELECT * FROM t_gudang WHERE gudang = 'WH00'");
		return $this->db->resultSet();
    }

    public function getReservation02($resnum){
        $this->db->query("SELECT *, resnum as 'refnum', resitem as 'refitem', fGetWarehouseName(fromwhs) as 'whsname1', fGetWarehouseName(towhs) as 'whsname2' FROM t_reserv02 WHERE resnum='$resnum' and movementstat is null");
        return $this->db->resultSet();
    }

    public function post($data, $rsnum){
        try {
            $matnr = $data['itm_material'];
            $maktx = $data['itm_matdesc'];
            $menge = $data['itm_qty'];
            $meins = $data['itm_unit'];
            $txz01 = $data['itm_remark'];
    
            $query1 = "INSERT INTO t_reserv01(resnum,resdate,note,requestor,fromwhs,towhs,createdon,createdby)
                        VALUES(:resnum,:resdate,:note,:requestor,:fromwhs,:towhs,:createdon,:createdby)";
    
            $this->db->query($query1);
            $this->db->bind('resnum',       $rsnum);
            $this->db->bind('resdate',      $data['resdate']);
            $this->db->bind('note',         $data['note']);
            $this->db->bind('requestor',    $data['requestor']);
            $this->db->bind('fromwhs',      $data['fromwhs']);
            $this->db->bind('towhs',        $data['towhs']);
            $this->db->bind('createdon',    date('Y-m-d'));
            $this->db->bind('createdby',    $_SESSION['usr']['user']);
            $this->db->execute();
            $rows = 0;
    
            $query2 = "INSERT INTO t_reserv02(resnum,resitem,material,matdesc,quantity,unit,fromwhs,towhs,remark,createdon,createdby)
            VALUES(:resnum,:resitem,:material,:matdesc,:quantity,:unit,:fromwhs,:towhs,:remark,:createdon,:createdby)";
            $this->db->query($query2);
            for($i = 0; $i < count($matnr); $i++){
                $rows = $rows + 1;
                $this->db->bind('resnum',   $rsnum);
                $this->db->bind('resitem',   $rows);
                $this->db->bind('material', $matnr[$i]);
                $this->db->bind('matdesc',  $maktx[$i]);
                
                $_menge = "";
                $_menge = str_replace(".", "",  $menge[$i]);
                $_menge = str_replace(",", ".", $_menge);
                $this->db->bind('quantity',     $_menge);
                $this->db->bind('unit',         $meins[$i]);
                $this->db->bind('fromwhs',      $data['fromwhs']);
                $this->db->bind('towhs',        $data['towhs']);
                $this->db->bind('remark',       $txz01[$i]);
                $this->db->bind('createdon',    date('Y-m-d'));
                $this->db->bind('createdby',    $_SESSION['usr']['user']);
                $this->db->execute();
            }
            return $this->db->rowCount();
        } catch (Exception $e) {
            $message = 'Caught exception: '.  $e->getMessage(). "\n";
            Flasher::setErrorMessage($message,'error');
            return 0;
        }
    }

    public function delete($rsnum){
        $query = "DELETE FROM t_reserv01 WHERE resnum=:resnum";
        $this->db->query($query);
      
        $this->db->bind('resnum',  $rsnum);
        $this->db->execute();
    }
}