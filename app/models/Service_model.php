<?php

class Service_model{

    private $db;

    public function __construct(){
		  $this->db = new Database;
    }

    public function getWhsAuth(){
        $user = $_SESSION['usr']['user'];
        $data = $this->db->query("SELECT * FROM t_user_object_auth WHERE username = '$user' and ob_auth = 'OB_WAREHOUSE' limit 1");
        return $this->db->single();
    }

    public function getServiceWhs(){

    }

    public function getNextPONumber($object){
		$this->db->query("CALL sp_NextNriv('$object')");
		return $this->db->single();
    }

    public function getOpenServiceByID($servicenum){
        $this->db->query("SELECT a.*, b.deskripsi as 'whsname' FROM t_service01 as a left join t_gudang as b on a.warehouse = b.gudang WHERE a.servicenum ='$servicenum'");
		return $this->db->single();
    }

    public function getOpenServiceItemByID($servicenum){
        $this->db->query("SELECT a.*, b.matdesc FROM t_service02 as a left join t_material as b on a.material = b.material WHERE a.servicenum ='$servicenum'");
		return $this->db->resultSet();
    }

    public function getOpenServiceData(){
        $user = $_SESSION['usr']['user'];
        $whsAuth = $this->getWhsAuth();
        if($whsAuth['ob_value'] === "*"){
            $this->db->query("SELECT * FROM t_service01 WHERE servicestatus is null");
        }else{
            $this->db->query("SELECT * FROM t_service01 where warehouse in(select ob_value from t_user_object_auth where username='$user' and ob_auth = 'OB_WAREHOUSE') AND servicestatus is null");
        }  
        
		return $this->db->resultSet();
    }

    public function getServiceData($strdate, $enddate){
        $this->db->query("SELECT * FROM t_service01 WHERE servicedate between '$strdate' and '$enddate'");
		return $this->db->resultSet();
    }

    public function getBatchStock(){
        $user = $_SESSION['usr']['user'];
        $whsAuth = $this->getWhsAuth();
        if($whsAuth['ob_value'] === "*"){
            $this->db->query("SELECT * FROM v_stockbatch WHERE quantity > 0");
        }else{
            $this->db->query("SELECT * FROM v_stockbatch where warehouse in(select ob_value from t_user_object_auth where username='$user' and ob_auth = 'OB_WAREHOUSE') AND quantity > 0");
        }          
		return $this->db->resultSet();
    }

    public function getResrvasi(){
        $user = $_SESSION['usr']['user'];
        $whsAuth = $this->getWhsAuth();

        $this->db->query("SELECT * FROM v_reservasi02");
        return $this->db->resultSet();
    }

    public function getStock($whs){
        $this->db->query("SELECT * FROM v_stock WHERE quantity > 0 AND warehouse='$whs'");
        return $this->db->resultSet();
    }

    public function save($data,$servicenum){
        try {
            $matnr = $data['itm_material'];
            // $lgort = $data['itm_whs'];
            $menge = $data['itm_qty'];
            $meins = $data['itm_unit'];

            $query1 = "INSERT INTO t_service01(servicenum,servicedate,note,mekanik,nopol,servicestatus,warehouse,createdon,createdby)
                            VALUES(:servicenum,:servicedate,:note,:mekanik,:nopol,:servicestatus,:warehouse,:createdon,:createdby)";
        
            $this->db->query($query1);
            $this->db->bind('servicenum',   $servicenum);
            $this->db->bind('servicedate',  $data['servicedate']);
            $this->db->bind('note',         $data['note']);
            $this->db->bind('mekanik',      $data['mekanik']);
            $this->db->bind('nopol',        $data['nopol']);
            $this->db->bind('servicestatus',null);
            $this->db->bind('warehouse',    $data['warehouse']);
            $this->db->bind('createdon',    date('Y-m-d'));
            $this->db->bind('createdby',    $_SESSION['usr']['user']);
            $this->db->execute();    

            $query2 = "INSERT INTO t_service02(servicenum,serviceitem,material,warehouse,quantity,unit,createdon,createdby)
                            VALUES(:servicenum,:serviceitem,:material,:warehouse,:quantity,:unit,:createdon,:createdby)";
            $this->db->query($query2);
            for($i = 0; $i < count($matnr); $i++){
                $rows = $rows + 1;
                $this->db->bind('servicenum',   $servicenum);
                $this->db->bind('serviceitem',  $rows);
                $this->db->bind('material',     $matnr[$i]);
                $this->db->bind('warehouse',    $data['warehouse']);
                
                $_menge = "";
                $_menge = str_replace(".", "",  $menge[$i]);
                $_menge = str_replace(",", ".", $_menge);
                $this->db->bind('quantity',     $_menge);
                $this->db->bind('unit',         $meins[$i]);

                $this->db->bind('createdon',    date('Y-m-d'));
                $this->db->bind('createdby',    $_SESSION['usr']['user']);
                $this->db->execute();
            }

            return $this->db->rowCount();    
    
        } catch (Exception $e) {
            $message = 'Caught exception: '.  $e->getMessage(). "\n";
            Flasher::setErrorMessage($message,'error');
            $return = array(
                "msgtype" => "0",
                "message" => $message,
                "data"    => $message
            );
            return $return;
        }
    }

    public function update($data,$servicenum){
        try {
            $matnr = $data['itm_material'];
            $menge = $data['itm_qty'];
            $meins = $data['itm_unit'];

            $query1 = "UPDATE t_service01 SET servicedate=:servicedate,note=:note,mekanik=:mekanik,nopol=:nopol,servicestatus=:servicestatus,warehouse=:warehouse WHERE servicenum=:servicenum";
        
            $this->db->query($query1);
            $this->db->bind('servicenum',   $servicenum);
            $this->db->bind('servicedate',  $data['servicedate']);
            $this->db->bind('note',         $data['note']);
            $this->db->bind('mekanik',      $data['mekanik']);
            $this->db->bind('nopol',        $data['nopol']);
            $this->db->bind('servicestatus',null);
            $this->db->bind('warehouse',    $data['warehouse']);
            $this->db->execute();    

            $query2 = "INSERT INTO t_service02(servicenum,serviceitem,material,warehouse,quantity,unit,createdon,createdby)
                            VALUES(:servicenum,:serviceitem,:material,:warehouse,:quantity,:unit,:createdon,:createdby)
                        ON DUPLICATE KEY UPDATE material=:material,warehouse=:warehouse,quantity=:quantity,unit=:unit
                      ";
            $this->db->query($query2);
            for($i = 0; $i < count($matnr); $i++){
                $rows = $rows + 1;
                $this->db->bind('servicenum',   $servicenum);
                $this->db->bind('serviceitem',  $rows);
                $this->db->bind('material',     $matnr[$i]);
                $this->db->bind('warehouse',    $data['warehouse']);
                
                $_menge = "";
                $_menge = str_replace(".", "",  $menge[$i]);
                $_menge = str_replace(",", ".", $_menge);
                $this->db->bind('quantity',     $_menge);
                $this->db->bind('unit',         $meins[$i]);

                $this->db->bind('createdon',    date('Y-m-d'));
                $this->db->bind('createdby',    $_SESSION['usr']['user']);
                $this->db->execute();
            }

            return $this->db->rowCount();    
    
        } catch (Exception $e) {
            $message = 'Caught exception: '.  $e->getMessage(). "\n";
            Flasher::setErrorMessage($message,'error');
            $return = array(
                "msgtype" => "0",
                "message" => $message,
                "data"    => $message
            );
            return $return;
        }
    }

    public function closeservice($servicenum){
        $query1 = "UPDATE t_service01 SET servicestatus='X' WHERE servicenum='$servicenum'";
        $this->db->query($query1);
        $this->db->execute();    
    }

    public function delete($servicenum){
        $query1 = "DELETE FROM t_service01 WHERE servicenum='$servicenum'";
        $this->db->query($query1);
        $this->db->execute();    
    }

    public function getuomconversion($matnr, $meins){
        $this->db->query("SELECT * FROM t_material2 WHERE material = '$matnr' AND altuom = '$meins'");
        return $this->db->single();
    }

    public function checkStockwhs($material, $whs, $inputqty){
        $myArray = explode(',', $material);
        $myWhs   = explode(',', $whs);
        $array   = implode("','",$myArray);
        $inpwhs  = implode("','",$myWhs);

        $_menge = "";
        $_menge = str_replace(".", "",  $inputqty);
        $_menge = str_replace(",", ".", $_menge);
        
        $this->db->query("SELECT *, '$_menge' as 'inputqty' FROM t_stock WHERE material = '$material' AND warehouse = '$whs'");
        return $this->db->single();
    }

    public function checkinventorystock($data){
        $matnr = $data['itm_material'];
        $menge = $data['itm_qty'];
        $lgort = $data['warehouse'];;
        $meins = $data['itm_unit'];
        $ind   = "";
        $errmsg = array();
        for($i = 0; $i < count($matnr); $i++){

            $uomconv = $this->getuomconversion($matnr[$i], $meins[$i]);
            $stock   = $this->checkStockwhs($matnr[$i], $lgort, $menge[$i]);

            if($stock['quantity']*1 < ( $stock['inputqty']*$uomconv['convbase'])){
                array_push($errmsg,(object)[
                    "message" => "Stock Material ". $stock['material'] . " di Warehouse ". $stock['warehouse'] . " Tidak Mencukupi. Stock saat ini adalah ". str_replace(".00","",$stock['quantity'])
                ]);

                $ind = "X";
            }
        }     

        return $errmsg;
    }

    public function postconfirmservice($data, $mblnr){

        try {
            $ind    = "";
            $matnr  = $data['itm_material'];
            $maktx  = $data['itm_matdesc'];
            $menge  = $data['itm_qty'];
            $meins  = $data['itm_unit'];
            $srvitm = $data['itm_no'];
            $year   = date('Y');
            $whs    = $data['warehouse'];
            $user   = $_SESSION['usr']['user'];
            $servicenum = $data['servicenum'];

            $query1 = "INSERT INTO t_inv_h(grnum,year,movement,movementdate,note,refnum,createdon,createdby)
                       VALUES(:grnum,:year,:movement,:movementdate,:note,:refnum,:createdon,:createdby)";
        
                $this->db->query($query1);
                $this->db->bind('grnum',        $mblnr);
                $this->db->bind('year',         date('Y'));
                $this->db->bind('movement',     '261');
                $this->db->bind('movementdate', $data['confdate']);
                $this->db->bind('note',         $data['note']);
                $this->db->bind('refnum',       $data['servicenum']);
                $this->db->bind('createdon',    date('Y-m-d'));
                $this->db->bind('createdby',    $_SESSION['usr']['user']);
                $this->db->execute();
                $rows = 0;
        
                // $query2 = "INSERT INTO t_inv_i(grnum,year,gritem,movement,batchnumber,material,matdesc,quantity,unit,ponum,poitem,resnum,resitem,remark,warehouse,warehouseto,shkzg,createdon,createdby)
                // VALUES(:grnum,:year,:gritem,:movement,:batchnumber,:material,:matdesc,:quantity,:unit,:ponum,:poitem,:resnum,:resitem,:remark,:warehouse,:warehouseto,:shkzg,:createdon,:createdby)";
                // $this->db->query($query2);
                for($i = 0; $i < count($matnr); $i++){    
                    $_matnr = $matnr[$i];
                    $_menge = "";
                    $_menge = str_replace(".", "",  $menge[$i]);
                    $_menge = str_replace(",", ".", $_menge);
                    $_maktx = $maktx[$i];
                    $_meins = $meins[$i];
                    $_srvitm = $srvitm[$i];

                    $this->db->query("CALL getBatchByFIFO(
                        '$_matnr',
                        '$whs',
                        '$_menge',
                        '$mblnr',
                        '$year',
                        '261', 
                        '$_maktx',
                        '$_meins',
                        '$whs',
                        '',
                        '+',
                        '$servicenum',
                        '$_srvitm',
                        '$user'
                    )");
                    $this->db->execute();                
                    // $rows = $rows + 1;
                    // $this->db->bind('grnum',       $mblnr);
                    // $this->db->bind('year',        date('Y'));
                    // $this->db->bind('gritem',      $rows);
                    // $this->db->bind('movement',    '261');                    
                    // $this->db->bind('batchnumber', $batch[$i]);
                    // $this->db->bind('material',    $matnr[$i]);
                    // $this->db->bind('matdesc',     $maktx[$i]);                    
                    // $_menge = "";
                    // $_menge = str_replace(".", "",  $menge[$i]);
                    // $_menge = str_replace(",", ".", $_menge);
                    // $this->db->bind('quantity',     $_menge);
                    // $this->db->bind('unit',         $meins[$i]);                    
                    // $this->db->bind('ponum',        null);
                    // $this->db->bind('poitem',       null);
                    // $this->db->bind('resnum',       null);
                    // $this->db->bind('resitem',      null);
                    // $this->db->bind('shkzg',        '-');
                    // $this->db->bind('remark',       $txz01[$i]);
                    // $this->db->bind('warehouse',    $lgort[$i]);
                    // $this->db->bind('warehouseto',  null);
                    // $this->db->bind('createdon',    date('Y-m-d'));
                    // $this->db->bind('createdby',    $_SESSION['usr']['user']);
                    // $this->db->execute();
                }
    
                
                // return $this->db->rowCount();
                $this->closeservice($data['servicenum']);

                $return = array(
                    "msgtype" => "1",
                    "message" => "Post Success",
                    "data"    => null
                );

                return 1;         
    
        } catch (Exception $e) {
            $message = 'Caught exception: '.  $e->getMessage(). "\n";
            Flasher::setErrorMessage($message,'error');
            $return = array(
                "msgtype" => "0",
                "message" => $message,
                "data"    => $message
            );
            return $return;
        }
      
    }
}