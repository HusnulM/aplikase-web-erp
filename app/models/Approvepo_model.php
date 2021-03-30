<?php

class Approvepo_model{

	private $db;

	public function __construct()
	{
		$this->db = new Database;
    }

    public function getOpenPO(){
        $user = $_SESSION['usr']['user'];
        $this->db->query("SELECT distinct ponum, podat, vendor, namavendor, note From v_po001 WHERE approvestat = '1' and createdby in(SELECT creator from t_approval where object ='PO' and approval = '$user') order by ponum desc");
        return $this->db->resultSet();
    }

    public function approvepo($ponum){
        $query = "UPDATE t_po01 set approvestat=:approvestat, appby=:appby WHERE ponum=:ponum";
        $this->db->query($query);
      
        $this->db->bind('ponum',       $ponum);
        $this->db->bind('approvestat', '2');
        $this->db->bind('appby',       $_SESSION['usr']['user']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function rejectpo($ponum){
        $query = "UPDATE t_po01 set approvestat=:approvestat, appby=:appby WHERE ponum=:ponum";
        $this->db->query($query);
      
        $this->db->bind('ponum',       $ponum);
        $this->db->bind('approvestat', '3');
        $this->db->bind('appby',        $_SESSION['usr']['user']);
        $this->db->execute();

        return $this->db->rowCount();
    }
}