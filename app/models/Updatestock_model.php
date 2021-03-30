<?php

class Updatestock_model{

	private $db;

	public function __construct()
	{
		$this->db = new Database;
	}
	
	public function generateBatch(){
		$this->db->query("CALL sp_NextNriv('BATCH')");
		return $this->db->single();
	} 

	public function post($data, $mblnr){
		ini_set('date.timezone', 'Asia/Jakarta');

		// $material = $data['itm_material'];
		// $warehouse= $data['itm_whs'];
		// $quantity = $data['itm_qty'];
		// $unit     = $data['itm_unit'];
		// $remark   = $data['itm_remark'];

		try {
            $ind = "";
            $matnr = $data['itm_material'];
            $maktx = $data['itm_matdesc'];
            $menge = $data['itm_qty'];
            $meins = $data['itm_unit'];
            $txz01 = $data['itm_remark'];
            $lgort = $data['itm_whs'];
			$price = $data['itm_price'];

            $user  = $_SESSION['usr']['user'];
            $year  = date('Y');

            $query1 = "INSERT INTO t_inv_h(grnum,year,movement,movementdate,note,createdon,createdby)
                            VALUES(:grnum,:year,:movement,:movementdate,:note,:createdon,:createdby)";
        
            $this->db->query($query1);
            $this->db->bind('grnum',        $mblnr);
            $this->db->bind('year',         date('Y'));
            $this->db->bind('movement',     '561');
            $this->db->bind('movementdate', date('Y-m-d'));
            $this->db->bind('note',         $data['note']);
            $this->db->bind('createdon',    date('Y-m-d'));
            $this->db->bind('createdby',    $_SESSION['usr']['user']);
            $this->db->execute();
            $rows = 0;

			$batch = $this->generateBatch();
		
			$query2 = "INSERT INTO t_inv_i(grnum,year,gritem,movement,batchnumber,material,matdesc,quantity,unit,price,remark,warehouse,shkzg,createdon,createdby)
			VALUES(:grnum,:year,:gritem,:movement,:batchnumber,:material,:matdesc,:quantity,:unit,:price,:remark,:warehouse,:shkzg,:createdon,:createdby)";
			$this->db->query($query2);
			for($i = 0; $i < count($matnr); $i++){
				$rows = $rows + 1;
				$this->db->bind('grnum',       $mblnr);
				$this->db->bind('year',        date('Y'));
				$this->db->bind('gritem',      $rows);
				$this->db->bind('movement',    '561');
				$this->db->bind('batchnumber', $batch['nextnumb']);
					
				$this->db->bind('material',    $matnr[$i]);
				$this->db->bind('matdesc',     $maktx[$i]);
					
				$_menge = "";
				$_menge = str_replace(".", "",  $menge[$i]);
				$_menge = str_replace(",", ".", $_menge);
				$this->db->bind('quantity', $_menge);
				$this->db->bind('unit',     $meins[$i]);

				$_price = "";
				$_price = str_replace(".", "",  $price[$i]);
				$_price = str_replace(",", ".", $_price);
				$this->db->bind('price', $_price);

				$this->db->bind('shkzg',   '+');
		
				$this->db->bind('remark',      $txz01[$i]);
				$this->db->bind('warehouse',   $lgort[$i]);					
				$this->db->bind('createdon',   date('Y-m-d'));
				$this->db->bind('createdby',   $_SESSION['usr']['user']);
				$this->db->execute();
			}

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
		// $d2 = new Datetime("now");
		
		// $query1  = "INSERT INTO t_ikpf(docnum,note,createdon,createdby)
		// 			VALUES(:docnum,:note,:createdon,:createdby)";		
		// $this->db->query($query1);
		// $this->db->bind('docnum',    $d2->format('U'));
		// $this->db->bind('note',      $data['note']);
		// $this->db->bind('createdon', date('Y-m-d H:m:s'));
		// $this->db->bind('createdby', $_SESSION['usr']['user']);
		// $this->db->execute();

		// $query2  = "INSERT INTO t_iseg(docnum,docitem,material,quantity,unit,remark,warehouse,createdby,createdon) VALUES(:docnum,:docitem,:material,:quantity,:unit,:remark,:warehouse,:createdby,:createdon)";
		// $this->db->query($query2);

		// $rows = 0;
		// for($i = 0; $i < count($material); $i++){
		// 	$rows = $rows + 1;
		// 	$this->db->bind('docnum',     $d2->format('U'));
		// 	$this->db->bind('docitem',    $rows);
		// 	$this->db->bind('material',   $material[$i]);
		// 	$_menge = "";
        //     $_menge = str_replace(".", "",  $quantity[$i]);
		// 	$_menge = str_replace(",", ".", $_menge);			
		// 	$this->db->bind('quantity',   $_menge);
		// 	$this->db->bind('unit',       $unit[$i]);
		// 	$this->db->bind('remark',     $remark[$i]);
		// 	$this->db->bind('warehouse',  $warehouse[$i]);
		// 	$this->db->bind('createdby',  $_SESSION['usr']['user']);
		// 	$this->db->bind('createdon',  date('Y-m-d H:m:s'));
			
		// 	$this->db->execute();
		// }

		// return $this->db->rowCount();
	}
}