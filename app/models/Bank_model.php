<?php

class Bank_model{

    private $db;
	private $table = 't_bank';

    public function __construct()
    {
		  $this->db = new Database;
    }
    
    public function getBankAccount()
    {
        $this->db->query("SELECT a.*, b.deskripsi FROM t_bank as a inner join t_bank_list as b on a.bankid = b.bankey");
		return $this->db->resultSet();
    }

    public function getBankAccountById($bankid,$bankno)
    {
        $this->db->query("SELECT a.*, b.deskripsi FROM t_bank as a inner join t_bank_list as b on a.bankid = b.bankey where a.bankid='$bankid' AND a.bankno = '$bankno'");
		return $this->db->single();
    }

    public function getBankList()
    {
        $this->db->query('SELECT * FROM t_bank_list order by bankey');
		return $this->db->resultSet();
    }

    public function getNextNumber($object){
		$this->db->query("CALL sp_NextNriv('$object')");
		return $this->db->single();
    }

    public function save($data){
        $query = "INSERT INTO t_bank (bankid, bankno, bankacc, npwp) 
                      VALUES(:bankid,:bankno,:bankacc,:npwp)";
        $this->db->query($query);
        
        $this->db->bind('bankid',  $data['bankey']);
        $this->db->bind('bankno',  $data['bankacc']);
        $this->db->bind('bankacc', $data['bankaccname']);
        $this->db->bind('npwp',    $data['npwp']);
        $this->db->execute();

        // var_dump($data);
        // $this->createbeginningbalance($data['bankacc'], $data['balance']);

        return $this->db->rowCount();
    }

    public function getTotalSaldo(){
        $user = $_SESSION['usr']['user'];
        // if($_SESSION['usr']['userlevel'] == 'Admin'){
        //     $this->db->query("SELECT sum(saldo_akhir) as 'saldo' FROM v_saldo_akhir");
        // }else{
        //     $this->db->query("SELECT sum(saldo_akhir) as 'saldo' FROM v_saldo_akhir where user = '$user'");
        // }        
        $this->db->query("SELECT sum(saldo_akhir) as 'saldo' FROM v_saldo_akhir where user = '$user'");
		return $this->db->single();
    }

    public function getlastestsaldo($bankno){
		$this->db->query("SELECT * FROM t_arus_kas where frombankacc = '$bankno' order by transnum desc limit 1");
		return $this->db->single();
    }
    
    public function cekmutasi($bankno)
    {
        $this->db->query("SELECT count(*) as 'rows' FROM t_arus_kas where frombankacc = '$bankno'");
		return $this->db->single();
    }

    public function createbeginningbalance($bankno, $saldoawal){
        $cekmutasi = $this->cekmutasi($bankno);
        if($cekmutasi['rows'] == '0'){
            $date   = date("Y-m-d");
            $numb = $this->getNextNumber('JURNAL');
            
            $saldo = $this->getlastestsaldo($bankno);

            $date   = date("Y-m-d");      

            $query1 = "INSERT INTO t_arus_kas(transnum,transdate,note,frombankacc,tobankacc,debet,kredit,saldo,efile,createdon,createdby)
                    VALUES(:transnum,:transdate,:note,:frombankacc,:tobankacc,:debet,:kredit,:saldo,:efile,:createdon,:createdby)";
            $this->db->query($query1);
            $this->db->bind('transnum', 	$numb['nextnumb']);
            $this->db->bind('transdate',	$date);
            $this->db->bind('note',	        'Saldo Awal');
            $this->db->bind('frombankacc',	$bankno);
            $this->db->bind('tobankacc',	'');
            $this->db->bind('debet',	    '0');
            $this->db->bind('kredit',	    $saldoawal);
            $this->db->bind('saldo',	    $saldoawal);
            $this->db->bind('efile',	    '');
            $this->db->bind('createdon',   	$date);
            $this->db->bind('createdby',   	$_SESSION['usr']['user']);
            
            $this->db->execute();
        }else if($cekmutasi['rows'] == '1'){
            $query1 = "UPDATE t_arus_kas set kredit=:kredit ,saldo=:saldo WHERE frombankacc=:frombankacc";
            $this->db->query($query1);
            $this->db->bind('frombankacc',	$bankno);
            $this->db->bind('kredit',	    $saldoawal);
            $this->db->bind('saldo',	    $saldoawal);
            $this->db->execute();
        }
	}

    public function update($data){

        // $cekmutasi = $this->cekmutasi($data['bankacc']);
        // if($cekmutasi['rows'] == '0'){
        //     $query = "UPDATE t_bank set bankid=:bankid, bankno=:bankno, bankacc=:bankacc, balance=:balance, user=:user where id=:id";
        //     $this->db->query($query);
        //     $this->db->bind('id',     $data['id']);
        //     $this->db->bind('bankid', $data['bankey']);
        //     $this->db->bind('bankno', $data['bankacc']);
        //     $this->db->bind('bankacc',$data['bankaccname']);
        //     $this->db->bind('balance', $data['balance']);
        //     $this->db->bind('user',    $data['userid']);
        //     $this->db->execute();

        //     $this->createbeginningbalance($data['bankacc'], $data['balance']);
        // }else if($cekmutasi['rows'] == '1'){
        //     $query = "UPDATE t_bank set bankid=:bankid, bankacc=:bankacc, balance=:balance, user=:user where id=:id";
        //     $this->db->query($query);
        //     $this->db->bind('id',     $data['id']);
        //     $this->db->bind('bankid', $data['bankey']);
        //     $this->db->bind('bankacc',$data['bankaccname']);
        //     $this->db->bind('balance', $data['balance']);
        //     $this->db->bind('user',   $data['userid']);
        //     $this->db->execute();

        //     $this->createbeginningbalance($data['bankacc'], $data['balance']);
        // }    
        $query = "UPDATE t_bank set bankid=:bankid, bankno=:bankno, bankacc=:bankacc, npwp=:npwp where id=:id";
            $this->db->query($query);
            $this->db->bind('id',     $data['id']);
            $this->db->bind('bankid', $data['bankey']);
            $this->db->bind('bankno', $data['bankacc']);
            $this->db->bind('bankacc',$data['bankaccname']);
            $this->db->bind('npwp',   $data['npwp']);
            
            $this->db->execute();    
        
        return $this->db->rowCount();
    }

    public function delete($id){
        $this->db->query('DELETE FROM t_bank WHERE id=:id');
        $this->db->bind('id',$id);
        $this->db->execute();
  
        return $this->db->rowCount();
      }
}