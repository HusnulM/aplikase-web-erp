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

  public function getFile($grnum){
    $this->db->query("SELECT * FROM t_file WHERE object = 'GRPO' and refdoc='$grnum'");
    return $this->db->single();
  }

  public function listgrtoinvoice(){
    $this->db->query("SELECT * FROM v_listgrto_invoice WHERE paymentstat is null order by grnum, year");
    return $this->db->resultSet();
  }

  public function getGrHeader($grnum, $year){
    $this->db->query("SELECT * FROM v_link_gr_project 
      WHERE grnum = '$grnum' and year = '$year'");
    return $this->db->single();
  }

  public function grdata($grnum, $year){
    $this->db->query("SELECT * FROM t_inv_i 
      WHERE grnum = '$grnum' and year = '$year' and paymentstat is null");
    return $this->db->resultSet();
  }

  public function postdata($data, $ivnum){
        $no = 0;
        $year       = date("Y");
        $date       = date("Y-m-d");
        $header = $data['header'][0];
        $items  = $data['items'];

        $query1 = "INSERT INTO t_invoice01(ivnum,ivyear,vendor,total_invoice,note,idproject,bankacc,createdby,createdon)
                   VALUES(:ivnum,:ivyear,:vendor,:total_invoice,:note,:idproject,:bankacc,:createdby,:createdon)";
        
        $this->db->query($query1);
	    	$this->db->bind('ivnum',          $ivnum);
        $this->db->bind('ivyear',         $year);
        $this->db->bind('vendor',         $header['vendor']);
        $this->db->bind('total_invoice',  $header['totalinv']);
        $this->db->bind('note',           $header['note']);
        $this->db->bind('idproject',      $header['project']);
        $this->db->bind('bankacc',        $header['bankacc']);
        $this->db->bind('createdby',      $_SESSION['usr']['user']);
        $this->db->bind('createdon',      date("Y-m-d"));
        $this->db->execute();
        if ($this->db->rowCount() > 0){

            $query2 = "INSERT INTO t_invoice02(ivnum,ivyear,ivitem,ponum,poitem,kodebrg,namabrg,quantity,unit,price,refdoc,refdocitem, ivdate)
                       VALUES(:ivnum,:ivyear,:ivitem,:ponum,:poitem,:kodebrg,:namabrg,:quantity,:unit,:price,:refdoc,:refdocitem,:ivdate)";
            
            $this->db->query($query2);
            for($i = 0; $i < sizeof($items); $i++){
                $this->db->bind('ivnum',      $ivnum);
                $this->db->bind('ivyear',     $year);
                $this->db->bind('ivitem',     $items[$i]['ivitem']);
                $this->db->bind('ponum',      $items[$i]['ponum']);
                $this->db->bind('poitem',     $items[$i]['poitem']);
                $this->db->bind('kodebrg',    $items[$i]['kodebrg']);
                $this->db->bind('namabrg',    $items[$i]['namabrg']);
                $this->db->bind('quantity',   $items[$i]['quantity']);
                $this->db->bind('unit',       $items[$i]['unit']);
                $this->db->bind('price',      $items[$i]['price']);
                $this->db->bind('refdoc',     $items[$i]['refdoc']);
                $this->db->bind('refdocitem', $items[$i]['refdocitem']);
                $this->db->bind('ivdate',     $items[$i]['ivdate']);
                $this->db->execute();
            }
            return $this->db->rowCount();
        }
      return $this->db->rowCount();
  }
}