<?php

class Updatestock_model{

	private $db;

	public function __construct()
	{
		$this->db = new Database;
	}
	
	public function post($data){
		ini_set('date.timezone', 'Asia/Jakarta');

		$material = $data['itm_material'];
		$warehouse= $data['itm_whs'];
		$quantity = $data['itm_qty'];
		$unit     = $data['itm_unit'];
		$remark   = $data['itm_remark'];

		$d2 = new Datetime("now");
		
		$query1  = "INSERT INTO t_ikpf(docnum,note,createdon,createdby)
					VALUES(:docnum,:note,:createdon,:createdby)";		
		$this->db->query($query1);
		$this->db->bind('docnum',    $d2->format('U'));
		$this->db->bind('note',      $data['note']);
		$this->db->bind('createdon', date('Y-m-d H:m:s'));
		$this->db->bind('createdby', $_SESSION['usr']['user']);
		$this->db->execute();

		$query2  = "INSERT INTO t_iseg(docnum,docitem,material,quantity,unit,remark,warehouse,createdby,createdon) VALUES(:docnum,:docitem,:material,:quantity,:unit,:remark,:warehouse,:createdby,:createdon)";
		$this->db->query($query2);

		$rows = 0;
		for($i = 0; $i < count($material); $i++){
			$rows = $rows + 1;
			$this->db->bind('docnum',     $d2->format('U'));
			$this->db->bind('docitem',    $rows);
			$this->db->bind('material',   $material[$i]);
			$_menge = "";
            $_menge = str_replace(".", "",  $quantity[$i]);
			$_menge = str_replace(",", ".", $_menge);			
			$this->db->bind('quantity',   $_menge);
			$this->db->bind('unit',       $unit[$i]);
			$this->db->bind('remark',     $remark[$i]);
			$this->db->bind('warehouse',  $warehouse[$i]);
			$this->db->bind('createdby',  $_SESSION['usr']['user']);
			$this->db->bind('createdon',  date('Y-m-d H:m:s'));
			
			$this->db->execute();
		}

		return $this->db->rowCount();
	}
}