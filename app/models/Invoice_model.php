<?php

class Invoice_model{
    private $db;

	public function __construct()
	{
		$this->db = new Database;
  }

  public function getNextNumber($object){
		$this->db->query("CALL sp_NextNriv('$object')");
		return $this->db->single();
  }

  public function getHeaderInvoice($ivnum){
    $this->db->query("SELECT a.*, b.bankacc as 'bankaccname', c.deskripsi as 'bankname' FROM v_rinvoice01 as a left join t_bank as b on a.bankacc = b.bankno left join t_bank_list as c on b.bankid = c.bankey WHERE a.ivnum='$ivnum'");
    return $this->db->single();
  }

  public function getDetailInvoice($ivnum){
    $this->db->query("SELECT * FROM v_rinvoice02 WHERE ivnum='$ivnum'");
    return $this->db->resultSet();
  }

  public function getFile($grnum){
    $this->db->query("SELECT * FROM t_file WHERE object = 'GRPO' and refdoc='$grnum'");
    return $this->db->single();
  }

  public function getPoHeader($ponum){
    $this->db->query("SELECT * FROM t_po01 WHERE ponum = '$ponum'");
    return $this->db->single();
  }

  public function listgrtoinvoice(){
    $this->db->query("SELECT * FROM v_payment01");
    return $this->db->resultSet();
  }

  public function listpotoinvoice(){
    $this->db->query("SELECT * FROM v_payment01");
    return $this->db->resultSet();
  }

  public function getpodata($ponum){
    $this->db->query("SELECT *, CAST(subtotal AS DECIMAL(15,2)) as 'subtot' FROM v_po004 WHERE ponum = '$ponum' AND paymentstat is null and approvestat <> 5");
    return $this->db->resultSet();
  }

  public function postdata($data, $ivnum){
        $no = 0;
        $year       = date("Y");
        $date       = date("Y-m-d");
        $header = $data['header'][0];
        $items  = $data['items'];

        $query1 = "INSERT INTO t_invoice01(ivnum,ivyear,vendor,total_invoice,note,bankacc,ivdate,createdby,createdon)
                   VALUES(:ivnum,:ivyear,:vendor,:total_invoice,:note,:bankacc,:ivdate,:createdby,:createdon)";
        
        $this->db->query($query1);
	    	$this->db->bind('ivnum',          $ivnum);
        $this->db->bind('ivyear',         $year);
        $this->db->bind('vendor',         $header['vendor']);
        $this->db->bind('total_invoice',  $header['totalinv']);
        $this->db->bind('note',           $header['note']);
        $this->db->bind('bankacc',        $header['bankacc']);
        $this->db->bind('ivdate',         $header['ivdate']);
        $this->db->bind('createdby',      $_SESSION['usr']['user']);
        $this->db->bind('createdon',      date("Y-m-d"));
        $this->db->execute();
        if ($this->db->rowCount() > 0){

            $query2 = "INSERT INTO t_invoice02(ivnum,ivyear,ivitem,ponum,poitem,ivdate)
                       VALUES(:ivnum,:ivyear,:ivitem,:ponum,:poitem,:ivdate)";
            
            $this->db->query($query2);
            for($i = 0; $i < sizeof($items); $i++){
                $this->db->bind('ivnum',      $ivnum);
                $this->db->bind('ivyear',     $year);
                $this->db->bind('ivitem',     $items[$i]['ivitem']);
                $this->db->bind('ponum',      $items[$i]['ponum']);
                $this->db->bind('poitem',     $items[$i]['poitem']);
                $this->db->bind('ivdate',     $items[$i]['ivdate']);
                $this->db->execute();
            }
            return $this->db->rowCount();
        }
      return $this->db->rowCount();
  }

  public function _approvepayment($ponum,$ivnum){
    $query = "UPDATE t_po02 set paymentstat=:paymentstat WHERE ponum=:ponum";
    $this->db->query($query);
  
    $this->db->bind('ponum',       $ponum);
    $this->db->bind('paymentstat',  'X');
    $this->db->execute();

    $query2 = "UPDATE t_invoice01 set approvedate=:approvedate WHERE ivnum=:ivnum";
    $this->db->query($query2);
  
    $this->db->bind('ivnum',       $ivnum);
    $this->db->bind('approvedate', date('Y-m-d'));
    $this->db->execute();

    return $this->db->rowCount();    
  }
}