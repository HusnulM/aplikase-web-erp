<?php

class Material_model{

    private $db;
	  private $table = 't_barang';

    public function __construct()
    {
		  $this->db = new Database;
    }
    
    public function getListBarang()
    {
      $this->db->query('SELECT * FROM t_material');
		  return $this->db->resultSet();
    }

    public function getBarangByKode($kodebrg)
    {
      $this->db->query("SELECT * FROM t_material WHERE material='$kodebrg'");
		  return $this->db->single();
    }

    public function getNextNumber($object){
      $this->db->query("call sp_NextNriv('$object')");
      return $this->db->single();
    }

    public function  save($data){
        $currentDate = date('Y-m-d');
        $kodebrg = $this->getNextNumber('BARANG');
        $query = "INSERT INTO t_material (material,matdesc, matunit, active, createdon, createdby) 
                      VALUES(:material,:matdesc,:matunit,:active,:createdon,:createdby)";
        $this->db->query($query);
        
        $this->db->bind('material',  $kodebrg['nextnumb']);
            $this->db->bind('matdesc',  $data['namabrg']);
            $this->db->bind('matunit',   $data['satuan']);
            $this->db->bind('active',   '1');
            $this->db->bind('createdon',$currentDate);
            $this->db->bind('createdby',$_SESSION['usr']['user']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function  update($data){
      $query = "UPDATE t_material set matdesc=:matdesc, matunit=:matunit WHERE material=:material";
      $this->db->query($query);
      
      $this->db->bind('material',  $data['kodebrg']);
          $this->db->bind('matdesc',  $data['namabrg']);
          $this->db->bind('matunit',   $data['satuan']);
      $this->db->execute();

      return $this->db->rowCount();
    }

    public function delete($kodebrg){
      $this->db->query("DELETE FROM t_material WHERE material=:material");
      $this->db->bind('material',$kodebrg);
      $this->db->execute();

      return $this->db->rowCount();
    }
}