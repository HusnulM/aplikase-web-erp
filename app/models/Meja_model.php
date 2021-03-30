<?php

class Meja_model{

	private $db;

	public function __construct()
	{
		$this->db = new Database;
    }

    public function listnomeja(){
        $this->db->query("SELECT * FROM t_meja order by nomeja");
        return $this->db->resultSet();
    }

    public function listmejaproces($nomeja){
        $this->db->query("SELECT b.idproses, b.nomeja, a.deskripsi as 'mesin', b.deskripsi as 'proses'  FROM t_meja as a inner join t_meja_proses as b on a.nomeja = b.nomeja where b.nomeja = '$nomeja' order by a.nomeja, b.idproses");
        return $this->db->resultSet();
    }

    public function listmejaprocesbyrefid($reffid){
        $this->db->query("SELECT b.idproses, b.nomeja, a.deskripsi as 'mesin', b.deskripsi as 'proses'  FROM t_meja as a inner join t_meja_proses as b on a.nomeja = b.nomeja where a.reffid = '$reffid' order by a.nomeja, b.idproses");
        return $this->db->resultSet();
    }

    public function getmejabyreffid($reffid){
        $this->db->query("SELECT * FROM t_meja WHERE reffid = '$reffid'");
        return $this->db->single();
    }

    public function save($data){
        $query1 = "INSERT INTO t_meja(deskripsi,reffid,createdon,createdby)
        VALUES(:deskripsi,:reffid,:createdon,:createdby)";


        $this->db->query($query1);
        $this->db->bind('deskripsi',    $data['nomeja']);
        $this->db->bind('reffid',       $data['reffid']);
        $this->db->bind('createdon',    date('Y-m-d'));
        $this->db->bind('createdby',    $_SESSION['usr']['user']);
        $this->db->execute();
        
        return $this->db->rowCount();
    }

    public function saveprocess($data){
        $query1 = "INSERT INTO t_meja_proses(nomeja,deskripsi,createdon,createdby)
        VALUES(:nomeja,:deskripsi,:createdon,:createdby)";


        $this->db->query($query1);
        $this->db->bind('nomeja',       $data['_nomejaid']);
        $this->db->bind('deskripsi',    $data['proses']);
        $this->db->bind('createdon',    date('Y-m-d H:m:s'));
        $this->db->bind('createdby',    $_SESSION['usr']['user']);
        $this->db->execute();
        
        return $this->db->rowCount();
    }

    public function deleteprocess($nomeja,$idprocess){
        $query1 = "DELETE FROM t_meja_proses WHERE idproses=:idproses AND nomeja=:nomeja";
        $this->db->query($query1);
        $this->db->bind('idproses', $idprocess);
        $this->db->bind('nomeja',   $nomeja);
        $this->db->execute();
        
        return $this->db->rowCount();
    }

    public function update($data){
        $query1 = "UPDATE t_meja set deskripsi=:deskripsi,reffid=:reffid WHERE nomeja=:nomeja";

        $this->db->query($query1);
        $this->db->bind('nomeja',       $data['nomejaid']);
        $this->db->bind('deskripsi',    $data['nomeja']);
        $this->db->bind('reffid',       $data['reffid']);
        $this->db->execute();
        
        return $this->db->rowCount();
    }

    public function delete($id){
        $query1 = "DELETE FROM t_meja WHERE nomeja=:nomeja";
        $this->db->query($query1);
        $this->db->bind('nomeja',       $id);
        $this->db->execute();

        $query2 = "DELETE FROM t_meja_proses WHERE nomeja=:nomeja";
        $this->db->query($query2);
        $this->db->bind('nomeja',   $id);
        $this->db->execute();
        
        return $this->db->rowCount();
    }
}