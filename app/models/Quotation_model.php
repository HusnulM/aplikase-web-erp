<?php

class Quotation_model{

    private $db;

    public function __construct()
	{
		$this->db = new Database;
    }

    public function listquotation(){
        $this->db->query("SELECT * FROM t_quotation01");
        return $this->db->resultSet();
    }

    public function bomDetail($bomid){
        $this->db->query("SELECT * FROM v_quotation WHERE bomid='$bomid'");
        return $this->db->resultSet(); 
    }

    public function totalCycleTime($bomid){
        $this->db->query("SELECT sum(totaltime) as 'total' FROM t_totalcycletime WHERE bomid='$bomid'");
        return $this->db->single(); 
    }

    public function  save($data){
        $query = "INSERT INTO t_approval (object,creator,approval) 
                      VALUES(:object,:creator,:approval)";
        $this->db->query($query);
        
        $this->db->bind('object',   $data['object']);
        $this->db->bind('creator',  $data['creator']);
        $this->db->bind('approval', $data['approval']);
        $this->db->execute();

        return $this->db->rowCount();
    }
}