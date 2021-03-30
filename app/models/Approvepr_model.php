<?php

class Approvepr_model{

	private $db;

	public function __construct()
	{
		$this->db = new Database;
    }

    public function getOpenPR(){
        $user = $_SESSION['usr']['user'];
        $dept = $_SESSION['usr']['department'];
        // if($_SESSION['usr']['userlevel'] === 'SysAdmin'){
        //     $this->db->query("SELECT distinct prnum, prdate, note, requestby, approvestat From v_pr001 WHERE approvestat = '1' order by prnum desc");
        // }elseif($_SESSION['usr']['userlevel'] === 'Admin'){
        //     $this->db->query("SELECT distinct prnum, prdate, note, requestby, approvestat From v_pr001 WHERE approvestat = '1' and createdby in(SELECT creator from t_approval where object ='PR' and approval = '$user') order by prnum desc");
        // }else{
        //     $this->db->query("SELECT distinct prnum, prdate, note, requestby, approvestat From v_pr001 WHERE approvestat = '1' and createdby = '$user' order by prnum desc");
        // }

        $this->db->query("SELECT distinct prnum, prdate, note, requestby, approvestat From v_pr001 WHERE approvestat = '1' and createdby in(SELECT creator from t_approval where object ='PR' and approval = '$user') order by prnum desc");
        
        return $this->db->resultSet();
    }

    public function approvepr($prnum){
        $query = "UPDATE t_pr01 set approvestat=:approvestat, appby=:appby WHERE prnum=:prnum";
        $this->db->query($query);
      
        $this->db->bind('prnum',       $prnum);
        $this->db->bind('approvestat', '2');
        $this->db->bind('appby',       $_SESSION['usr']['user']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function rejectpr($prnum){
        $query = "UPDATE t_pr01 set approvestat=:approvestat, appby=:appby WHERE prnum=:prnum";
        $this->db->query($query);
      
        $this->db->bind('prnum',       $prnum);
        $this->db->bind('approvestat', '3');
        $this->db->bind('appby',        $_SESSION['usr']['user']);
        $this->db->execute();

        return $this->db->rowCount();
    }
}