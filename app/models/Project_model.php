<?php

class Project_model{

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

	public function saveproject($data){

		$date   = date("Y-m-d");      

		$query1 = "INSERT INTO tblproject(namaproject,status,createdon,createdby)
				   VALUES(:namaproject,:status,:createdon,:createdby)";
		$this->db->query($query1);
		$this->db->bind('namaproject', 	$data['namaproject']);
		$this->db->bind('status',	    $data['status']);
		$this->db->bind('createdon',   	$date);
		$this->db->bind('createdby',   	$_SESSION['usr']['user']);
		
		$this->db->execute();

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