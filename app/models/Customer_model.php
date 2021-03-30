<?php

class Customer_model{

    private $db;

    public function __construct()
    {
		$this->db = new Database;
    }

    public function customerList(){
        $this->db->query("SELECT * FROM t_customer");
        return $this->db->resultSet(); 
    }

    public function getCustomerById($id){
        $this->db->query("SELECT * FROM t_customer WHERE cust_id='$id'");
        return $this->db->single(); 
    }

    public function save($data){
        $query1 = "INSERT INTO t_customer(cust_name,cust_address,cust_email,cust_telp,createdon,createdby)
        VALUES(:cust_name,:cust_address,:cust_email,:cust_telp,:createdon,:createdby)";

        $this->db->query($query1);
        $this->db->bind('cust_name',     $data['custname']);
        $this->db->bind('cust_address',  $data['custaddr']);
        $this->db->bind('cust_email',    $data['custemail']);
        $this->db->bind('cust_telp',     $data['custtelp']);;
        $this->db->bind('createdon',     date('Y-m-d H:m:s'));
        $this->db->bind('createdby',     $_SESSION['usr']['user']);
        $this->db->execute();        

        return $this->db->rowCount();
    }

    public function update($data){
        $query1 = "UPDATE t_customer set cust_name=:cust_name,cust_address=:cust_address,cust_email=:cust_email,cust_telp=:cust_telp WHERE cust_id=:cust_id";

        $this->db->query($query1);
        $this->db->bind('cust_id',       $data['cust_id']);
        $this->db->bind('cust_name',     $data['custname']);
        $this->db->bind('cust_address',  $data['custaddr']);
        $this->db->bind('cust_email',    $data['custemail']);
        $this->db->bind('cust_telp',     $data['custtelp']);
        $this->db->execute();        

        return $this->db->rowCount();
    }

    public function delete($id){
        $query1 = "DELETE FROM t_customer WHERE cust_id=:cust_id";

        $this->db->query($query1);
        $this->db->bind('cust_id',       $id);
        $this->db->execute();        

        return $this->db->rowCount();
    }
}