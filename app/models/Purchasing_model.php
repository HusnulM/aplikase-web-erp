<?php

class Purchasing_model{

	private $db;	

	public function __construct()
	{
		$this->db = new Database;
	}

	public function getOpenPR()
	{
		// $this->db->query('SELECT * FROM ');
		// return $this->db->resultSet();
    }
    
    public function getAllPR(){
        // $this->db->query('SELECT * FROM productgroup');
		// return $this->db->resultSet();
    }

    public function createPR($data, $prnumb){
		
		$header = $data['header'][0];
		$items = $data['items'];
		$rows   = $data['rows'][0];
		//Insert Header Data
		$query1 = "INSERT INTO tblprheader(prnum,createdBy,createdOn,requiredDate,remark,currency,approveStat, 						 idproject)
				   VALUES(:prnum,:createdBy,:createdOn,:requiredDate,:remark,:currency,:approveStat,:idproject)";

		$this->db->query($query1);
		$this->db->bind('prnum',	   	$prnumb);
        $this->db->bind('createdBy',   	$_SESSION['usr']['user']);
		$this->db->bind('createdOn',   	$header['dcdate']);
		$this->db->bind('requiredDate',	$header['rqdate']);
		$this->db->bind('remark',	   	$header['project']);
		$this->db->bind('currency',		$header['currency']);
		$this->db->bind('idproject',	$header['idproject']);
		$this->db->bind('approveStat','0');
		$this->db->execute();

		if ($this->db->rowCount() > 0){
			$query2 = "INSERT INTO tblpritem(prnum,pritem,text,quantity,unit,price,totalPrice,item_remark)
				       VALUES(:prnum,:pritem,:text,:quantity,:unit,:price,:totalPrice,:item_remark)";
			$this->db->query($query2);
			for($i=0; $i<$rows; $i++){
				$this->db->bind('prnum',	  $prnumb);
				$this->db->bind('pritem', 	  $items[$i]['prItem']);
				$this->db->bind('text',		  $items[$i]['ItemName']);
				$this->db->bind('quantity',	  $items[$i]['qty']);
				$this->db->bind('unit',		  $items[$i]['uom']);
				$this->db->bind('price',	  $items[$i]['price']);
				$this->db->bind('totalPrice', $items[$i]['total']);				
				$this->db->bind('item_remark',$items[$i]['remark']);
				$this->db->execute();
			}			

			return $this->db->rowCount();
		}
	}
	
	public function updatePR($data, $prnumb){

		// $this->deletepr($prnumb);

		$header = $data['header'][0];
		$items = $data['items'];
		$rows   = $data['rows'][0];
		//Insert Header Data
		$query1 = "INSERT INTO tblprheader(prnum,createdBy,createdOn,requiredDate,remark,currency,approveStat, 						 idproject)
				   VALUES(:prnum,:createdBy,:createdOn,:requiredDate,:remark,:currency,:approveStat,:idproject)";

		$this->db->query($query1);
		$this->db->bind('prnum',	   	$prnumb);
        $this->db->bind('createdBy',   	$_SESSION['usr']['user']);
		$this->db->bind('createdOn',   	$header['dcdate']);
		$this->db->bind('requiredDate',	$header['rqdate']);
		$this->db->bind('remark',	   	$header['project']);
		$this->db->bind('currency',		$header['currency']);
		$this->db->bind('idproject',	$header['idproject']);
		$this->db->bind('approveStat','0');
		$this->db->execute();

		if ($this->db->rowCount() > 0){
			$query2 = "INSERT INTO tblpritem(prnum,pritem,text,quantity,unit,price,totalPrice,item_remark)
				       VALUES(:prnum,:pritem,:text,:quantity,:unit,:price,:totalPrice,:item_remark)";
			$this->db->query($query2);
			for($i=0; $i<$rows; $i++){
				$this->db->bind('prnum',	  $prnumb);
				$this->db->bind('pritem', 	  $items[$i]['prItem']);
				$this->db->bind('text',		  $items[$i]['ItemName']);
				$this->db->bind('quantity',	  $items[$i]['qty']);
				$this->db->bind('unit',		  $items[$i]['uom']);
				$this->db->bind('price',	  $items[$i]['price']);
				$this->db->bind('totalPrice', $items[$i]['total']);				
				$this->db->bind('item_remark',$items[$i]['remark']);
				$this->db->execute();
			}			

			return $this->db->rowCount();
		}
		// $header = $data['header'][0];
		// $items  = $data['items'];
		// $rows   = $data['rows'][0];

		// // return $items[0];
		// //UPDATE Header Data
		// $query1 = "UPDATE tblprheader set createdBy=:createdBy,createdOn=:createdOn,requiredDate=:requiredDate,remark=:remark,currency=:currency,idproject=:idproject WHERE prnum=:prnum";

		// $this->db->query($query1);
		// $this->db->bind('prnum',	   	$prnumb);
        // $this->db->bind('createdBy',   	$_SESSION['usr']['user']);
		// $this->db->bind('createdOn',   	$header['dcdate']);
		// $this->db->bind('requiredDate',	$header['rqdate']);
		// $this->db->bind('remark',	   	$header['project']);
		// $this->db->bind('currency',		$header['currency']);
		// $this->db->bind('idproject',	$header['idproject']);
		// $this->db->execute();

		// $return = $this->db->rowCount();
		// if ($this->db->rowCount() > 0){
		// 	$query2 = "UPDATE tblpritem set text=:text,quantity=:quantity,unit=:unit,price=:price,totalPrice=:totalPrice,item_remark=:item_remark WHERE prnum=:prnum and pritem=:pritem";
			
		// 	// $this->db->query($query2);
		// 	// 	$this->db->bind('prnum',	  $prnumb);
		// 	// 	$this->db->bind('pritem', 	  $items[0]['prItem']);
		// 	// 	$this->db->bind('text',		  $items[0]['ItemName']);
		// 	// 	$this->db->bind('quantity',	  $items[0]['qty']);
		// 	// 	$this->db->bind('unit',		  $items[0]['uom']);
		// 	// 	$this->db->bind('price',	  $items[0]['price']);
		// 	// 	$this->db->bind('totalPrice', $items[0]['total']);				
		// 	// 	$this->db->bind('item_remark',$items[0]['remark']);
		// 	// 	$this->db->execute();
		// 	// 	return $this->db->rowCount();
			
		// 	for($i=0; $i<$rows; $i++){
		// 		$this->db->query($query2);
		// 		$this->db->bind('prnum',	  $prnumb);
		// 		$this->db->bind('pritem', 	  $items[$i]['prItem']);
		// 		$this->db->bind('text',		  $items[$i]['ItemName']);
		// 		$this->db->bind('quantity',	  $items[$i]['qty']);
		// 		$this->db->bind('unit',		  $items[$i]['uom']);
		// 		$this->db->bind('price',	  $items[$i]['price']);
		// 		$this->db->bind('totalPrice', $items[$i]['total']);				
		// 		$this->db->bind('item_remark',$items[$i]['remark']);
		// 		$this->db->execute();
				
		// 		// $this->db->rowCount();
		// 	}			

		// 	// return $this->db->rowCount();
		// 	return $return;
			
		// }
	}
	
	public function deletepr($prnum){
		$this->db->query("DELETE From tblprheader WHERE prnum = '$prnum'");
		$this->db->execute();
		$this->db->query("DELETE From tblpritem WHERE prnum = '$prnum'");
		$this->db->execute();
	}

	public function getAllOpenPR(){
		$user = $_SESSION['usr']['user'];
		if($_SESSION['usr']['userlevel'] === "2"){			
			$this->db->query("call sp_getOpenPRhead('$user')");
			return $this->db->resultSet();
		}else{
			$this->db->query("call sp_getOpenPRhead2('$user')");
			return $this->db->resultSet();
		}		
	}

	public function printPRbydate($sDate,$eDate){
		$user = $_SESSION['usr']['user'];
		$this->db->query("call sp_PrintPRBydate('$user','$sDate','$eDate')");
		return $this->db->resultSet();
	}

	public function getHistoryPR($sDate, $eDate){
		// echo json_encode($sDate);
		$user = $_SESSION['usr']['user'];
		$this->db->query("call sp_getOpenPRhead3('$user','$sDate','$eDate')");
		return $this->db->resultSet();
	}

	public function approvePR($prnum){
		$this->db->query('UPDATE tblprheader SET approveStat=:approveStat  WHERE prnum=:prnum');
		$this->db->bind('prnum',$prnum);
		$this->db->bind('approveStat','1');
		$this->db->execute();

		return $this->db->rowCount();
	}

	public function cancelApprovePR($prnum){
		$this->db->query('UPDATE tblprheader SET approveStat=:approveStat  WHERE prnum=:prnum');
		$this->db->bind('prnum',$prnum);
		$this->db->bind('approveStat','0');
		$this->db->execute();

		return $this->db->rowCount();
	}

	public function rejectPR($prnum){
		$this->db->query('UPDATE tblprheader SET approveStat=:approveStat  WHERE prnum=:prnum');
		$this->db->bind('prnum',$prnum);
		$this->db->bind('approveStat','2');	
		$this->db->execute();

		return $this->db->rowCount();
	}
	
	public function getPRHeaderByNum($prnum){
		$this->db->query('SELECT * FROM tblprheader inner join tblproject
						  on tblprheader.idproject = tblproject.idproject
						  WHERE tblprheader.prnum=:prnum');
		$this->db->bind('prnum',$prnum);
		return $this->db->single();
	}

	public function getPRByNum($prnum){
		$this->db->query('SELECT * FROM tblpritem WHERE prnum=:prnum');
		$this->db->bind('prnum',$prnum);
		return $this->db->resultSet();
	}

	public function getNextPRNumb(){
		$this->db->query('call sp_getPRNumb()');
		return $this->db->single();
	}

	public function getCurrencyList(){
		$this->db->query('SELECT * FROM tcurr');
		return $this->db->resultSet();
	}

	public function getOpenProject(){
		$this->db->query('SELECT * FROM tblproject WHERE status = 0');
		return $this->db->resultSet();
	}

}