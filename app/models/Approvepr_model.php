<?php

class Approvepr_model{

	private $db;

	public function __construct()
	{
		$this->db = new Database;
    }

    public function getPRheader($prnum){
		$this->db->query("SELECT a.*, fGetNamaUser(a.createdby) as 'crtby' From t_pr01 as a Where a.prnum = '$prnum'");
		return $this->db->single();
    }

    public function getOpenPR(){
        $user = $_SESSION['usr']['user'];        
        $this->db->query("SELECT distinct a.prnum, b.prdate, b.note, b.requestby FROM v_pr004 as a inner join t_pr01 as b on a.prnum = b.prnum WHERE a.createdby in(SELECT creator from t_approval where object ='PR' and approval = '$user') and a.approvestat in(SELECT level from t_approval where object ='PR' and approval = '$user')");
        return $this->db->resultSet();
    }

    public function getApprovalLevel($user){
        $this->db->query("SELECT level from t_approval where object ='PR' and approval = '$user'");
        return $this->db->single();
    }

    public function getMaxApprovalLevel(){
        $this->db->query("SELECT level from t_approval where object ='PR' order by level desc limit 1");
        return $this->db->single();
    }

    public function getOpenPRByNum($prnum){
        $user = $_SESSION['usr']['user'];
        $this->db->query("SELECT * FROM v_pr004 WHERE prnum = '$prnum' and approvestat in(SELECT level from t_approval where object ='PR' and approval = '$user') Order BY prnum, pritem");
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

    public function approvepritem($prnum, $data){
        $user     = $_SESSION['usr']['user'];
        $level    = $this->getApprovalLevel($user);
        $maxlevel = $this->getMaxApprovalLevel();

        $finalapprove = null;

        $approvestat = $level['level']+1;
        $pritem = join("','",$data);   

        if($level['level'] === $maxlevel['level']){
            $finalapprove = 'X';
        }
        
        $date = date('Y-m-d');
        $query  = "UPDATE t_pr02 set approvestat='$approvestat', approveby='$user', final_approve='$finalapprove', approvedate='$date' WHERE prnum='$prnum' and pritem in('$pritem')";
        
        $this->db->query($query);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function rejectpritem($prnum, $data){
        $date = date('Y-m-d');
        $pritem = join("','",$data);   
        $user   = $_SESSION['usr']['user'];
        $query  = "UPDATE t_pr02 set approvestat='5', approveby='$user', final_approve='X', approvedate='$date' WHERE prnum='$prnum' and pritem in('$pritem')";
        $this->db->query($query);
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