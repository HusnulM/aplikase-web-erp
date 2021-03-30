<?php

class Approvepayment_model{
    private $db;

	public function __construct()
	{
		$this->db = new Database;
    }

    public function getOpenPayment(){
        $this->db->query("SELECT a.*, b.namavendor FROM t_invoice01 as a inner join t_vendor as b on a.vendor = b.vendor WHERE approvestat is null");
        return $this->db->resultSet();
    }

    public function getIVheader($ivnum){
        $this->db->query("SELECT a.*, b.namavendor FROM t_invoice01 as a inner join t_vendor as b on a.vendor = b.vendor WHERE ivnum = '$ivnum' and approvestat is null");
        return $this->db->single();
    }

    public function getIVitem($ivnum){
        $this->db->query("SELECT * FROM v_payment02 WHERE ivnum = '$ivnum'");
        return $this->db->resultSet();
    }

    public function getPONumByIV($ivnum){
        $this->db->query("SELECT ponum FROM t_invoice02 WHERE ivnum = '$ivnum' limit 1");
        return $this->db->single();
    }

    public function approvepayment($ivnum){
        $ponum = $this->getPONumByIV($ivnum);

        $query = "UPDATE t_po02 set paymentstat=:paymentstat WHERE ponum=:ponum";
        $this->db->query($query);
        
        $this->db->bind('ponum',       $ponum['ponum']);
        $this->db->bind('paymentstat',  'X');
        $this->db->execute();

        $query2 = "UPDATE t_invoice01 set approvestat=:approvestat, approvedate=:approvedate WHERE ivnum=:ivnum";
        $this->db->query($query2);
    
        $this->db->bind('ivnum',       $ivnum);
        $this->db->bind('approvestat', 'X');
        $this->db->bind('approvedate', date('Y-m-d'));
        $this->db->execute();

        return $this->db->rowCount();  
    }
}