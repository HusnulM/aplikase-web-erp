<?php

class Product_model{

	private $db;
	private $table = 'product';

	public function __construct()
	{
		$this->db = new Database;
	}

	public function getAllProduct()
	{
		$this->db->query('SELECT * FROM vProduct');
		return $this->db->resultSet();
    }
    
    public function gerProductGroup(){
        $this->db->query('SELECT * FROM productgroup');
		return $this->db->resultSet();
    }

    public function createProduct($data){
        $currentDate = date('Y-m-d');
		$query = "INSERT INTO product (ItemCode, ItemName, ItemGroup, ItemUnit,createdOn) 
                  VALUES(:ItemCode,:ItemName,:ItemGroup,:ItemUnit,:createdOn)";
		$this->db->query($query);
		
		$this->db->bind('ItemCode',$data['itemcode']);
        $this->db->bind('ItemName',$data['itemname']);
        $this->db->bind('ItemGroup',$data['itemgroup']);
        $this->db->bind('ItemUnit',$data['itemuom']);
        $this->db->bind('createdOn',$currentDate);
		$this->db->execute();

		return $this->db->rowCount();
    }

    public function deleteProduct($id){
        $this->db->query('DELETE FROM ' . $this->table . ' WHERE ItemCode=:ItemCode');
		$this->db->bind('ItemCode',$id);
		$this->db->execute();

		return $this->db->rowCount();
    }
}