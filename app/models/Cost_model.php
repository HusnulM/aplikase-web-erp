<?php

class Cost_model{

    private $db;

    public function __construct()
    {
		$this->db = new Database;
    }

    public function getPartList(){
        $this->db->query("SELECT * FROM t_bom01");
        return $this->db->resultSet();
    }

    public function getCostDetail($bomid){
        $this->db->query("SELECT * FROM v_detailcost where bomid='$bomid'");
        return $this->db->resultSet();
    }

    public function getUpah(){
        $this->db->query("SELECT * FROM t_config01 where object='OB_UPAH_KERJA'");
        return $this->db->single();
    }

    public function checkauthdisplaycost(){
        $user = $_SESSION['usr']['user'];
        $this->db->query("SELECT count(*) as 'rows' FROM t_user_object_auth WHERE ob_auth = 'OB_UPAH_KERJA' AND username = '$user'");
            return $this->db->single();
      }

    public function save($data){
        try {

            $this->delete($data['bomid']);

            $actid = $data['itm_id'];
            $menge = $data['itm_qty'];

            $query1 = "INSERT INTO t_cost01(bomid,partnumber,createdon,createdby)
                            VALUES(:bomid,:partnumber,:createdon,:createdby)";
        
            $this->db->query($query1);
            $this->db->bind('bomid',        $data['bomid']);
            $this->db->bind('partnumber',   $data['partnumb']);
            $this->db->bind('createdon',    date('Y-m-d'));
            $this->db->bind('createdby',    $_SESSION['usr']['user']);
            $this->db->execute();

            $query2 = "INSERT INTO t_cost02(bomid,activity,partnumber,quantity)
                       VALUES(:bomid,:activity,:partnumber,:quantity)";

            $this->db->query($query2);
            for($i = 0; $i < count($actid); $i++){
                $this->db->bind('bomid',      $data['bomid']);
                $this->db->bind('activity',   $actid[$i]);
                $this->db->bind('partnumber', $data['partnumb']);
                $_menge = "";
                $_menge = str_replace(".", "",  $menge[$i]);
                $_menge = str_replace(",", ".", $_menge);
                $this->db->bind('quantity',   $_menge);
                $this->db->execute();
            }

             // return $this->db->rowCount();

             $return = array(
                "msgtype" => "1",
                "message" => "Post Success",
                "data"    => null
            );

            return 1;    
        }catch (Exception $e) {
            $message = 'Caught exception: '.  $e->getMessage(). "\n";
            Flasher::setErrorMessage($message,'error');
            $return = array(
                "msgtype" => "0",
                "message" => $message,
                "data"    => $message
            );
            return $return;
        }
    }

    public function updateupah($upah){
        $newcurs = "";
        $newcurs = str_replace(".", "",  $upah);
        $query = "UPDATE t_config01 set value=:value WHERE object=:object";
        $this->db->query($query);
      
        $this->db->bind('object',   'OB_UPAH_KERJA');
        $this->db->bind('value',     $newcurs);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function delete($bomid){
        $this->db->query('DELETE FROM t_cost01 WHERE bomid=:bomid');
        $this->db->bind('bomid',$bomid);
        $this->db->execute();  
        return $this->db->rowCount();
    }
}