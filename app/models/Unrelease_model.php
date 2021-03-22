<?php

class Unrelease_model{

	private $db;

	public function __construct()
	{
		$this->db = new Database;
    }

    public function prlist(){
        $this->db->query("SELECT * FROM v_pr003 WHERE info is null and approvestat='2'");
        return $this->db->resultSet();
    }

    public function polist(){
        $this->db->query("SELECT * FROM v_po003 WHERE isgr is null and approvestat='2'");
        return $this->db->resultSet();
    }

    public function unrelpr($prnum){
        $query1 = "UPDATE t_pr01 SET approvestat=:approvestat WHERE prnum=:prnum";
		$this->db->query($query1);
		$this->db->bind('prnum',       $prnum);
		$this->db->bind('approvestat', "1");
		$this->db->execute();

		return $this->db->rowCount();
    }

    public function unrelpo($ponum){
        $query1 = "UPDATE t_po01 SET approvestat=:approvestat WHERE ponum=:ponum";
		$this->db->query($query1);
		$this->db->bind('ponum',       $ponum);
		$this->db->bind('approvestat', "1");
		$this->db->execute();

		return $this->db->rowCount();       
    }
}