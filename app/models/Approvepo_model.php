<?php

class Approvepo_model{

	private $db;

	public function __construct()
	{
		$this->db = new Database;
    }

    public function getPOHeader($ponum){
        $this->db->query("SELECT a.ponum, a.warehouse, a.potype, a.podat, a.note, a.vendor, b.namavendor, fGetNamaUser(a.createdby) as 'createdby' FROM t_po01 as a left join t_vendor as b on a.vendor = b.vendor WHERE a.ponum = '$ponum'");
        return $this->db->single();
    }

    public function getApprovalLevel($user){
        $this->db->query("SELECT level from t_approval where object ='PO' and approval = '$user'");
        return $this->db->single();
    }

    public function getMaxApprovalLevel(){
        $this->db->query("SELECT level from t_approval where object ='PO' order by level desc limit 1");
        return $this->db->single();
    }

    public function getOpenPO(){
        $user = $_SESSION['usr']['user'];
        $this->db->query("SELECT distinct ponum, potype, podat, vendor, namavendor, note From v_po001 WHERE createdby in(SELECT creator from t_approval where object ='PO' and approval = '$user') and approvestat in(SELECT level from t_approval where object ='PO' and approval = '$user') order by ponum desc");
        return $this->db->resultSet();
    }

    public function getOpenPOItem($ponum){
        $this->db->query("SELECT *, CAST(subtotal AS DECIMAL(15,2)) as 'subtot'  FROM v_po004 WHERE ponum='$ponum' AND final_approve is null order by ponum, poitem");
        return $this->db->resultSet();
    }

    public function approvepo($ponum){
        $query = "UPDATE t_po01 set approvestat=:approvestat, appby=:appby WHERE ponum=:ponum";
        $this->db->query($query);
      
        $this->db->bind('ponum',       $ponum);
        $this->db->bind('approvestat', '2');
        $this->db->bind('appby',       $_SESSION['usr']['user']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function rejectpo($ponum){
        $query = "UPDATE t_po01 set approvestat=:approvestat, appby=:appby WHERE ponum=:ponum";
        $this->db->query($query);
      
        $this->db->bind('ponum',       $ponum);
        $this->db->bind('approvestat', '3');
        $this->db->bind('appby',        $_SESSION['usr']['user']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function approvepoitem($ponum, $data){
        $user     = $_SESSION['usr']['user'];
        $level    = $this->getApprovalLevel($user);
        $maxlevel = $this->getMaxApprovalLevel();

        $finalapprove = null;

        $approvestat = $level['level']+1;
        $poitem = join("','",$data);   

        if($level['level'] === $maxlevel['level']){
            $finalapprove = 'X';
        }

        $date = date('Y-m-d');
        
        $query  = "UPDATE t_po02 set approvestat='$approvestat', approvedby='$user', final_approve='$finalapprove', approvedate='$date' WHERE ponum='$ponum' and poitem in('$poitem')";
        
        $this->db->query($query);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function rejectpoitem($ponum, $data){
        $poitem = join("','",$data); 
        $user   = $_SESSION['usr']['user'];
        
        $date = date('Y-m-d');
        $query  = "UPDATE t_po02 set approvestat='5', approvedby='$user', final_approve='X', approvedate='$date' WHERE ponum='$ponum' and poitem in('$poitem')";

        $this->db->query($query);
        $this->db->execute();

        return $this->db->rowCount();
    }
}