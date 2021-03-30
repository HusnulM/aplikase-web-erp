<?php

class Inspection_model{

	private $db;

	public function __construct()
	{
		$this->db = new Database;
    }

    public function jenisDefect(){
        $this->db->query("SELECT * FROM t_jenis_defect");
        return $this->db->resultSet();
    }

    public function defectSection(){
        $this->db->query("SELECT * FROM t_defect_section");
        return $this->db->resultSet();
    }

    public function defectProcess($section){
        $this->db->query("SELECT * FROM t_defect_process WHERE idsection='$section'");
        return $this->db->resultSet();
    }

    public function defectList($section){
        $this->db->query("SELECT * FROM t_defect_jenis WHERE idsection='$section'");
        return $this->db->resultSet();
    }

    public function reportDefect($strdate, $enddate){
        $this->db->query("SELECT defect,sum(jmlng) as 'jmlng' FROM v_rdefect WHERE isnpecdate BETWEEN '$strdate' AND '$enddate' group by defect order by jmlng desc");
        return $this->db->resultSet();
    }

    public function save($data){
        
        if($data['nomeja'] === "other"){
            $data['nomeja'] = $data['mesinother'];
        }
        
        $query1 = "INSERT INTO t_inspection(lotng,isnpecdate,inspector,customer,operator,assyno,cctno,idsection,process,jumlahcheck,nomeja,jenisdefect,jumlahng,createdon,createdby)
        VALUES(:lotng,:isnpecdate,:inspector,:customer,:operator,:assyno,:cctno,:idsection,:process,:jumlahcheck,:nomeja,:jenisdefect,:jumlahng,:createdon,:createdby)";

        $this->db->query($query1);
        $this->db->bind('lotng',        $data['lotng']);
        $this->db->bind('isnpecdate',   $data['idate']);
        $this->db->bind('inspector',    $data['inspector']);
        $this->db->bind('customer',     $data['cusotmer']);
        $this->db->bind('operator',     $data['operator']);
        $this->db->bind('assyno',       $data['assyno']);
        $this->db->bind('cctno',        $data['cctno']);
        $this->db->bind('idsection',    $data['section']);
        $this->db->bind('process',      $data['process']);
        $this->db->bind('jumlahcheck',  $data['jmlcheck']);
        $this->db->bind('nomeja',       $data['nomeja']);
        $this->db->bind('jenisdefect',  $data['jdefect']);
        $this->db->bind('jumlahng',     $data['jmlng']);
        $this->db->bind('createdon',    date('Y-m-d h:m:s'));
        $this->db->bind('createdby',    $_SESSION['usr']['user']);
        $this->db->execute();
        
        return $this->db->rowCount();
    }
}