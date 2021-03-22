<?php

class Setoran_model{

	private $db;	

	public function __construct()
	{
		$this->db = new Database;
	}

	public function getOpenProject(){
		$this->db->query('SELECT * FROM tblproject WHERE status = 0');
		return $this->db->resultSet();
	}

	public function projectList(){
		$this->db->query('SELECT * FROM tblproject');
		return $this->db->resultSet();
	}

	public function getprojectbyid($idproject){
		$this->db->query("SELECT * FROM tblproject WHERE idproject = '$idproject'");
		return $this->db->single();
	}

	public function getNextNumber($object){
		$this->db->query("CALL sp_NextNriv('$object')");
		return $this->db->single();
	}
	
	public function getlastestsaldo($bankno){
		$this->db->query("SELECT * FROM t_arus_kas where frombankacc = '$bankno' order by transnum desc limit 1");
		return $this->db->single();
	}

	public function getfile($transnum){
		$this->db->query("SELECT *, 'st' as 'act' FROM t_arus_kas where transnum = '$transnum' order by transnum desc limit 1");
		return $this->db->single();
	}

	public function getGrfile($ivnum){
		$data = $this->db->query("SELECT * FROM v_payment_files where ivnum = '$ivnum'");
		return $this->db->single();
	}

	public function getbankmaster($bankno){
		$data = $this->db->query("SELECT * FROM v_bank_master where bankno = '$bankno'");
		return $this->db->single();
	}

	public function getsaldobyakun($bankno){
		$this->db->query("SELECT * FROM v_saldo_akhir where bankno = '$bankno'");
		return $this->db->single();
	}

	public function save($data, $numb){

        $filename      = $_FILES['efile']['name'];
		$filename      = $filename;
		$location      = "./images/setoran/". $filename;
		$temp          = $_FILES['efile']['tmp_name'];
		$fileType      = pathinfo($location,PATHINFO_EXTENSION);

		$saldo = $this->getlastestsaldo($data['fromakun']);

		$bankdata = $this->getbankmaster($data['fromakun']);
		$date   = date("Y-m-d");      

		$query1 = "INSERT INTO t_arus_kas(transnum,transdate,note,frombankacc,tobankacc,debet,kredit,saldo,efile,createdon,createdby)
				   VALUES(:transnum,:transdate,:note,:frombankacc,:tobankacc,:debet,:kredit,:saldo,:efile,:createdon,:createdby)";
		
		$this->db->query($query1);
		$this->db->bind('transnum', 	$numb);
        $this->db->bind('transdate',	$data['tglsetor']);
        $this->db->bind('note',  	    'Setoran ke ' . $bankdata['bankacc']);
        $this->db->bind('frombankacc',	$data['fromakun']);
        $this->db->bind('tobankacc',	$data['toakun']);
        $this->db->bind('debet',	    $data['jmlsetor']);
        $this->db->bind('kredit',	    '0');
        $this->db->bind('saldo',	    $saldo['saldo']-$data['jmlsetor']);
        $this->db->bind('efile',	    $filename);
		$this->db->bind('createdon',   	$date);
		$this->db->bind('createdby',   	$_SESSION['usr']['user']);
		
		$this->db->execute();

		move_uploaded_file($temp, $location);
		$this->savekredit($data);
		return $this->db->rowCount();
	}

	public function savekredit($data){

		$numb = $this->getNextNumber('JURNAL');

        $filename      = $_FILES['efile']['name'];
		$filename      = $filename;
		$saldo = $this->getlastestsaldo($data['toakun']);
		$bankdata = $this->getbankmaster($data['toakun']);
		$date   = date("Y-m-d");      

		$query1 = "INSERT INTO t_arus_kas(transnum,transdate,note,frombankacc,tobankacc,debet,kredit,saldo,efile,createdon,createdby)
				   VALUES(:transnum,:transdate,:note,:frombankacc,:tobankacc,:debet,:kredit,:saldo,:efile,:createdon,:createdby)";
		$this->db->query($query1);
		$this->db->bind('transnum', 	$numb['nextnumb']);
        $this->db->bind('transdate',	    $data['tglsetor']);
        $this->db->bind('note',	    'Terima dari ' . $bankdata['bankacc']);
        $this->db->bind('frombankacc',	$data['toakun']);
        $this->db->bind('tobankacc',	$data['fromakun']);
        $this->db->bind('debet',	    '0');
        $this->db->bind('kredit',	    $data['jmlsetor']);
        $this->db->bind('saldo',	    $saldo['saldo']+$data['jmlsetor']);
        $this->db->bind('efile',	    $filename);
		$this->db->bind('createdon',   	$date);
		$this->db->bind('createdby',   	$_SESSION['usr']['user']);
		
		$this->db->execute();

        // move_uploaded_file($temp, $location);
		return $this->db->rowCount();
	}

	public function updateproject($data){

		$query1 = "UPDATE tblproject SET namaproject=:namaproject, status=:status WHERE idproject=:idproject";
		$this->db->query($query1);
		$this->db->bind('idproject',    $data['idproject']);
		$this->db->bind('namaproject', 	$data['projectname']);
		$this->db->bind('status',	    $data['status']);
		
		$this->db->execute();

		return $this->db->rowCount();
	}

	public function deleteproject($idproject){
		$query = "DELETE FROM tblproject WHERE idproject=:idproject";
		$this->db->query($query);
		$this->db->bind('idproject', $idproject);
		
		$this->db->execute();

		return $this->db->rowCount();
	}

}