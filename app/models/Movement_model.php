<?php

class Movement_model{

    private $db;

    public function __construct(){
		  $this->db = new Database;
    }

    public function getWhsAuth(){
        $user = $_SESSION['usr']['user'];
        $data = $this->db->query("SELECT * FROM t_user_object_auth WHERE username = '$user' and ob_auth = 'OB_WAREHOUSE' limit 1");
        return $this->db->single();
    }

    public function getInvMovementByAuth(){
        $user = $_SESSION['usr']['user'];
        $this->db->query("CALL sp_GetInvMovementCatByObjAuth('$user')");
		return $this->db->resultSet();
    }

    public function getPotoGR(){
        $user = $_SESSION['usr']['user'];
        $whsAuth = $this->getWhsAuth();
        if($whsAuth['ob_value'] === "*"){
            $this->db->query("SELECT * FROM v_po002");
        }else{
            $this->db->query("SELECT * FROM v_po002 where warehouse in(select ob_value from t_user_object_auth where username='$user' and ob_auth = 'OB_WAREHOUSE')");
        }  
		return $this->db->resultSet();
    }

    public function getResrvasitoTF(){
        $this->db->query("SELECT * FROM v_reservasi02");
		return $this->db->resultSet();
    }

    public function readlockdata($object,$docnum){
        $this->db->query("SELECT * FROM t_lockdata WHERE object='$object' AND docnum = '$docnum'");
		return $this->db->single();
    }

    public function getPOitemtoGR($ponum){
        $this->db->query("SELECT *, ponum as 'refnum', poitem as 'refitem', '' as 'fromwhs', '-' as 'towhs' FROM t_po02 WHERE ponum = '$ponum' AND grstatus IS NULL AND final_approve = 'X'");
        return $this->db->resultSet();
    }

    public function checkwhsauth($whsnum){
        $return = 0;
        $user = $_SESSION['usr']['user'];
        $this->db->query("SELECT * FROM t_user_object_auth WHERE username = '$user' and ob_auth = 'OB_WAREHOUSE' and ob_value='$whsnum'");

        if(count($this->db->resultSet()) > 0){
            $return = 1;
            return $return;
        }else{
            $this->db->query("SELECT * FROM t_user_object_auth WHERE username = '$user' and ob_auth = 'OB_WAREHOUSE' and ob_value='*'");

            $return = count($this->db->resultSet());
            return $return;
        }
    }

    public function checkStock($material, $whs, $inputqty){
        $myArray = explode(',', $material);
        $myWhs   = explode(',', $whs);
        $array   = implode("','",$myArray);
        $inpwhs  = implode("','",$myWhs);
        $this->db->query("SELECT *, '$inputqty' as 'inputqty' FROM t_stock WHERE material in('$array') AND warehouse in('$inpwhs')");
        return $this->db->resultSet();
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

    public function getuomconversion($matnr, $meins){
        $this->db->query("SELECT * FROM t_material2 WHERE material = '$matnr' AND altuom = '$meins'");
        return $this->db->single();
    }

    public function checkinventorystock($data){
        $matnr = $data['itm_material'];
        $menge = $data['itm_qty'];
        $lgort = $data['itm_whs'];
        $meins = $data['itm_unit'];
        $ind   = "";
        $errmsg = array();
        for($i = 0; $i < count($matnr); $i++){

            $uomconv = $this->getuomconversion($matnr[$i], $meins[$i]);
            $stock   = $this->checkStockwhs($matnr[$i], $lgort[$i], $menge[$i]);

            if($stock['quantity']*1 < ( $stock['inputqty']*$uomconv['convbase'])){
                array_push($errmsg,(object)[
                    "message" => "Stock Material <b>". $stock['material'] . "</b> di Warehouse <b>". $stock['warehouse'] . "</b> Tidak Mencukupi. Stock saat ini adalah ". str_replace(".00","",$stock['quantity'])
                ]);

                $ind = "X";
            }
        }     

        return $errmsg;
    }

    public function generateBatch(){
		$this->db->query("CALL sp_NextNriv('BATCH')");
		return $this->db->single();
	} 

    public function post($data, $mblnr){

        try {
            $ind = "";
            $matnr = $data['itm_material'];
            $maktx = $data['itm_matdesc'];
            $menge = $data['itm_qty'];
            $meins = $data['itm_unit'];
            $txz01 = $data['itm_remark'];
            $lgort = $data['itm_whs'];
            $lgort2  = $data['itm_whs2'];
            $refnum  = $data['itm_refnum'];
            $refitem  = $data['itm_refitem'];
            // $batchnum = $data['itm_batch'];

            $user  = $_SESSION['usr']['user'];
            $year  = date('Y');

            $query1 = "INSERT INTO t_inv_h(grnum,year,movement,movementdate,note,createdon,createdby)
                            VALUES(:grnum,:year,:movement,:movementdate,:note,:createdon,:createdby)";
        
            $this->db->query($query1);
            $this->db->bind('grnum',        $mblnr);
            $this->db->bind('year',         date('Y'));
            $this->db->bind('movement',     $data['immvt']);
            $this->db->bind('movementdate', $data['mvdate']);
            $this->db->bind('note',         $data['note']);
            $this->db->bind('createdon',    date('Y-m-d'));
            $this->db->bind('createdby',    $_SESSION['usr']['user']);
            $this->db->execute();
            $rows = 0;

            if($data['immvt'] === "101"){
                $batch = $this->generateBatch();
            
                $query2 = "INSERT INTO t_inv_i(grnum,year,gritem,movement,batchnumber,material,matdesc,quantity,unit,ponum,poitem,resnum,resitem,remark,warehouse,warehouseto,shkzg,createdon,createdby)
                VALUES(:grnum,:year,:gritem,:movement,:batchnumber,:material,:matdesc,:quantity,:unit,:ponum,:poitem,:resnum,:resitem,:remark,:warehouse,:warehouseto,:shkzg,:createdon,:createdby)";
                $this->db->query($query2);
                for($i = 0; $i < count($matnr); $i++){
                    $rows = $rows + 1;
                    $this->db->bind('grnum',    $mblnr);
                    $this->db->bind('year',     date('Y'));
                    $this->db->bind('gritem',   $rows);
                    $this->db->bind('movement', $data['immvt']);
                    $this->db->bind('batchnumber', $batch['nextnumb']);
                        
                    $this->db->bind('material', $matnr[$i]);
                    $this->db->bind('matdesc',  $maktx[$i]);
                        
                    $_menge = "";
                    $_menge = str_replace(".", "",  $menge[$i]);
                    $_menge = str_replace(",", ".", $_menge);
                    $this->db->bind('quantity', $_menge);
                    $this->db->bind('unit',     $meins[$i]);
                    $this->db->bind('ponum',     $refnum[$i]);
                    $this->db->bind('poitem',    $refitem[$i]);
                    $this->db->bind('resnum',    null);
                    $this->db->bind('resitem',   null);
                    $this->db->bind('shkzg',   '+');
            
                    // if($data['immvt'] === "101"){
                    // }elseif($data['immvt'] === "201" || $data['immvt'] === "211"){
                    //     $this->db->bind('ponum',     null);
                    //     $this->db->bind('poitem',    null);
                    //     $this->db->bind('resnum',    $refnum[$i]);
                    //     $this->db->bind('resitem',   $refitem[$i]);
                    //     $this->db->bind('shkzg',   '+');
                    // }elseif($data['immvt'] === "261"){
                    //     $this->db->bind('ponum',     null);
                    //     $this->db->bind('poitem',    null);
                    //     $this->db->bind('resnum',    $refnum[$i]);
                    //     $this->db->bind('resitem',   $refitem[$i]);
                    //     $this->db->bind('shkzg',   '-');
                    // }
            
                    $this->db->bind('remark',      $txz01[$i]);
                    $this->db->bind('warehouse',   $lgort[$i]);
                    if($data['immvt'] === "101"){
                        $this->db->bind('warehouseto', null);
                    }elseif($data['immvt'] === "201" || $data['immvt'] === "211"){
                        $this->db->bind('warehouseto', $lgort2[$i]);
                    }elseif($data['immvt'] === "261"){
                        $this->db->bind('warehouseto', null);
                    }
                        
                    $this->db->bind('createdon',   date('Y-m-d'));
                    $this->db->bind('createdby',   $_SESSION['usr']['user']);
                    $this->db->execute();
                }
            }else{
                if($data['immvt'] === "201" || $data['immvt'] === "211"){
                    for($i = 0; $i < count($matnr); $i++){
                        $_matnr = $matnr[$i];
                        $_menge = "";
                        $_menge = str_replace(".", "",  $menge[$i]);
                        $_menge = str_replace(",", ".", $_menge);
                        $_maktx = $maktx[$i];
                        $_meins = $meins[$i];
                        $_refnum  = $refnum[$i];
                        $_refitem = $refitem[$i];
                        $_whs1    = $lgort[$i];
                        $_whs2    = $lgort2[$i];

                        if($data['immvt'] === "201"){
                            $this->db->query("CALL getBatchByFIFO(
                                '$_matnr',
                                '$_whs1',
                                '$_menge',
                                '$mblnr',
                                '$year',
                                '201', 
                                '$_maktx',
                                '$_meins',
                                '$_whs1',
                                '$_whs2',
                                '+',
                                '$_refnum',
                                '$_refitem',
                                '$user'
                            )");
                            $this->db->execute(); 
                        }else{
                            $this->db->query("CALL getBatchByFIFO(
                                '$_matnr',
                                '$_whs1',
                                '$_menge',
                                '$mblnr',
                                '$year',
                                '211', 
                                '$_maktx',
                                '$_meins',
                                '$_whs1',
                                '$_whs2',
                                '+',
                                '',
                                '',
                                '$user'
                            )");
                            $this->db->execute(); 
                        }

                        // $rows = $rows + 1;
                        // $this->db->bind('grnum',    $mblnr);
                        // $this->db->bind('year',     date('Y'));
                        // $this->db->bind('gritem',   $rows);
                        // $this->db->bind('movement', $data['immvt']);
                        // $this->db->bind('batchnumber', $batchnum[$i]);
                        // $this->db->bind('material', $matnr[$i]);
                        // $this->db->bind('matdesc',  $maktx[$i]);
                        
                        // $_menge = "";
                        // $_menge = str_replace(".", "",  $menge[$i]);
                        // $_menge = str_replace(",", ".", $_menge);
                        // $this->db->bind('quantity', $_menge);
                        // $this->db->bind('unit',     $meins[$i]);
                        // $this->db->bind('ponum',     null);
                        // $this->db->bind('poitem',    null);
                        // $this->db->bind('resnum',    $refnum[$i]);
                        // $this->db->bind('resitem',   $refitem[$i]);
                        // $this->db->bind('shkzg',   '-');        
                        // $this->db->bind('remark',      $txz01[$i]);
                        // $this->db->bind('warehouse',   $lgort2[$i]);
                        // $this->db->bind('warehouseto', $lgort[$i]);                    
                        // $this->db->bind('createdon',   date('Y-m-d'));
                        // $this->db->bind('createdby',   $_SESSION['usr']['user']);
                        // $this->db->execute();
                    }
                }
            }
        
    
                // return $this->db->rowCount();

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

    public function delete($mblnr){
        $query = "DELETE FROM t_inv_h WHERE grnum=:grnum";
        $this->db->query($query);
      
        $this->db->bind('grnum',  $mblnr);
        $this->db->execute();
    }
}