<?php

class Jabatan_model{

    private $db;
	private $table = 't_jabatan';

    public function __construct()
    {
		  $this->db = new Database;
    }
    
    public function getList()
    {
      $this->db->query('SELECT * FROM t_jabatan');
		  return $this->db->resultSet();
    }

    public function getById($id)
    {
      $this->db->query("SELECT * FROM t_jabatan WHERE id='$id'");
		  return $this->db->single();
    }

    public function  save($data){
        $currentDate = date('Y-m-d h:m:s');
        $query = "INSERT INTO t_jabatan (jabatan,createdon, createdby) 
                      VALUES(:jabatan,:createdon,:createdby)";
        $this->db->query($query);
        
        $this->db->bind('jabatan',  $data['jabatan']);
        $this->db->bind('createdon',$currentDate);
        $this->db->bind('createdby',$_SESSION['usr']['user']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function  update($data){
        $query = "UPDATE t_jabatan set jabatan=:jabatan WHERE id=:id";
        $this->db->query($query);
      
        $this->db->bind('id',     $data['id']);
        $this->db->bind('jabatan',$data['jabatan']);
        $this->db->execute();

      return $this->db->rowCount();
    }

    public function delete($id){
      $this->db->query('DELETE FROM t_jabatan WHERE id=:id');
      $this->db->bind('id',$id);
      $this->db->execute();

      return $this->db->rowCount();
    }
}