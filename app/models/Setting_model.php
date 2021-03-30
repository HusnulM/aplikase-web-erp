<?php

class Setting_model{
    private $db;	

	public function __construct()
	{
		$this->db = new Database;
    }
    
    public function getgensetting(){
		$this->db->query("SELECT * FROM tblsetting where id = '1'");
		return $this->db->single();
    }
    
    public function savepsetting($data){
        $query1 = "UPDATE tblsetting SET company=:company, address=:address WHERE id=:id";
		$this->db->query($query1);
		$this->db->bind('id',       $data['id']);
		$this->db->bind('company', 	$data['company']);
		$this->db->bind('address',	$data['address']);
		
		$this->db->execute();

		return $this->db->rowCount();
    }
}