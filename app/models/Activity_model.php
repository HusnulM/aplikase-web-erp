<?php

class Activity_model{

    private $db;

    public function __construct()
    {
		$this->db = new Database;
    }

    public function activityList(){
        $this->db->query("SELECT * FROM t_activity");
        return $this->db->resultSet(); 
    }

    public function activityDetail($id){
        $this->db->query("SELECT * FROM t_activity WHERE id='$id'");
        return $this->db->single(); 
    }

    public function delete($id){
        $this->db->query('DELETE FROM t_activity WHERE id=:id');
        $this->db->bind('id',$id);
        $this->db->execute();  
        return $this->db->rowCount();
    }

    public function update($data){
        $query1 = "UPDATE t_activity set activity=:activity,cycletime=:cycletime,cycvleunit=:cycvleunit WHERE id=:id";

        $this->db->query($query1);
        $this->db->bind('id',           $data['activityid']);
        $this->db->bind('activity',     $data['process']);

        $_menge = "";
        $_menge = str_replace(".", "",  $data['cycletime']);
        $_menge = str_replace(",", ".", $_menge);

        $this->db->bind('cycletime',    $_menge);
        $this->db->bind('cycvleunit',   $data['cycleunit']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function save($data){
        $createdon = date('Y-m-d h:m:s');

        $query1 = "INSERT INTO t_activity(activity,cycletime,cycvleunit,createdon,createdby)
                   VALUES(:activity,:cycletime,:cycvleunit,:createdon,:createdby)";

        $this->db->query($query1);
        $this->db->bind('activity',     $data['process']);

        $_menge = "";
        $_menge = str_replace(".", "",  $data['cycletime']);
        $_menge = str_replace(",", ".", $_menge);

        $this->db->bind('cycletime',    $_menge);
        $this->db->bind('cycvleunit',   $data['cycleunit']);
		$this->db->bind('createdon',    $createdon);
        $this->db->bind('createdby',    $_SESSION['usr']['user']);
        $this->db->execute();

        return $this->db->rowCount();
    }
}