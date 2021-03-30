<?php

class Wosimage_model{

	private $db;

	public function __construct()
	{
		$this->db = new Database;
    }

    public function gePartImageByBomid($bomid){
        $this->db->query("SELECT * FROM t_part_image WHERE bomid='$bomid'");
        return $this->db->single();
    }

    public function gePartImage($partnumber){
        $this->db->query("SELECT * FROM t_part_image WHERE partnumber='$partnumber'");
        return $this->db->single();
    }

    public function getWosImage($bomid){
        $this->db->query("SELECT * FROM t_wos_image WHERE bomid='$bomid'");
        return $this->db->resultSet();
    }

    public function getPartDetail($bomid){
        $this->db->query("SELECT * FROM t_bom01 WHERE bomid='$bomid'");
        return $this->db->single();
    }

    public function save($data){
        $query1 = "INSERT INTO t_wos_image(bomid,partnumber,circuitno,imagelink,createdon,createdby)
        VALUES(:bomid,:partnumber,:circuitno,:imagelink,:createdon,:createdby)";

        $this->db->query($query1);
        $this->db->bind('bomid',       $data['bomid']);
        $this->db->bind('partnumber',  $data['partnumber']);
        $this->db->bind('circuitno',   $data['circuitno']);
        $this->db->bind('imagelink',   $data['imagelink']);
        $this->db->bind('createdon',   date('Y-m-d'));
        $this->db->bind('createdby',   $_SESSION['usr']['user']);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function savepartimage($data){
        $query1 = "INSERT INTO t_part_image(bomid,partnumber,imagelink,createdon,createdby)
        VALUES(:bomid,:partnumber,:imagelink,:createdby,:createdon)
        ON DUPLICATE KEY UPDATE imagelink=:imagelink,createdby=:createdby,createdon=:createdon";

        $this->db->query($query1);
        $this->db->bind('bomid',       $data['bomid']);
        $this->db->bind('partnumber',  $data['partnumber']);
        $this->db->bind('imagelink',   $data['imagelink']);
        $this->db->bind('createdon',   date('Y-m-d'));
        $this->db->bind('createdby',   $_SESSION['usr']['user']);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function deleteimage($bomid, $circuitno){
        $query = "DELETE FROM t_wos_image WHERE bomid='$bomid' AND circuitno='$circuitno'";
        $this->db->query($query);
        $this->db->execute();
        return $this->db->rowCount();
    }
}