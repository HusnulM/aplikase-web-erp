<?php

class Laporan_model{
    private $db;

    public function __construct()
    {
		  $this->db = new Database;
    }

    public function getWhsAuth(){
        $user = $_SESSION['usr']['user'];
        $data = $this->db->query("SELECT * FROM t_user_object_auth WHERE username = '$user' and ob_auth = 'OB_WAREHOUSE' limit 1");
        return $this->db->single();
    }

    public function getStock($material = null, $warehouse = null)
    {
        $user = $_SESSION['usr']['user'];
        $whsAuth = $this->getWhsAuth();

        $query = "SELECT * FROM v_inventory01";

        if(($material == "null" && $warehouse == "null") || ($material == null && $warehouse == null)){
            if($whsAuth['ob_value'] === "*"){
                $this->db->query("SELECT * FROM v_inventory01");
            }else{
                $this->db->query("SELECT * FROM v_inventory01 where warehouse in(select ob_value from t_user_object_auth where username='$user' and ob_auth = 'OB_WAREHOUSE')");
            }            
        }else if($material != null && $warehouse == null){
            if($whsAuth['ob_value'] === "*"){
                $this->db->query("SELECT * FROM v_inventory01 WHERE material = '$material'");
            }else{
                $this->db->query("SELECT * FROM v_inventory01 WHERE material = '$material' and warehouse in(select ob_value from t_user_object_auth where username='$user' and ob_auth = 'OB_WAREHOUSE')");
            } 
        }else if(($material == null || $material == "null" ) && ( $warehouse != null )){
            
            if($whsAuth['ob_value'] === "*"){
                $this->db->query("SELECT * FROM v_inventory01 WHERE warehouse = '$warehouse'");
            }else{
                $this->db->query("SELECT * FROM v_inventory01 WHERE warehouse = '$warehouse' and warehouse in(select ob_value from t_user_object_auth where username='$user' and ob_auth = 'OB_WAREHOUSE')");
            }
        }else{
            $this->db->query("SELECT * FROM v_inventory01 WHERE material = '$material' AND warehouse = '$warehouse'");
        }
        
		return $this->db->resultSet();
    }

    public function getAllStock(){
        $this->db->query("SELECT * FROM v_totalstock");
        return $this->db->resultSet();
    }

    public function breakdownstock($matnr){
        $this->db->query("SELECT * FROM v_stock where material='$matnr'");
        return $this->db->resultSet();
    }

    public function getPR($strdate, $enddate)
    {
        $user = $_SESSION['usr']['user'];
        $dept = $_SESSION['usr']['department'];
        $ob_whs = $this->getWhsAuth();
        if($ob_whs['ob_value'] === "*"){
            $this->db->query("SELECT * FROM v_pr002 WHERE prdate BETWEEN '$strdate' AND '$enddate'");
        }else{
            $this->db->query("SELECT * FROM v_pr002 WHERE prdate BETWEEN '$strdate' AND '$enddate' and warehouse in(select ob_value from t_user_object_auth where username='$user')");
        }
        return $this->db->resultSet();        
    }

    public function getDataPO($strdate, $enddate)
    {
        $user = $_SESSION['usr']['user'];
        $dept = $_SESSION['usr']['department'];
        $this->db->query("SELECT * FROM v_po001 WHERE podat BETWEEN '$strdate' AND '$enddate'");
        return $this->db->resultSet();
    }

    public function getDataGR($strdate, $enddate)
    {
        $user = $_SESSION['usr']['user'];
        $dept = $_SESSION['usr']['department'];
        $this->db->query("SELECT * FROM v_inventory03 WHERE movementdate BETWEEN '$strdate' AND '$enddate' and movement='101'");
		return $this->db->resultSet();
    }

    public function getMovementData($strdate, $enddate)
    {
        $user = $_SESSION['usr']['user'];
        $dept = $_SESSION['usr']['department'];
        $this->db->query("SELECT * FROM v_inventory03 WHERE movementdate BETWEEN '$strdate' AND '$enddate'");
		return $this->db->resultSet();
    }

    public function getReservasiData($strdate, $enddate)
    {
        $user = $_SESSION['usr']['user'];
        $dept = $_SESSION['usr']['department'];
        $ob_whs = $this->getWhsAuth();
        if($ob_whs['ob_value'] === "*"){
            $this->db->query("SELECT * FROM v_reservasi01 WHERE resdate BETWEEN '$strdate' AND '$enddate' order by resnum desc");
        }else{
            $this->db->query("SELECT * FROM v_reservasi01 WHERE resdate BETWEEN '$strdate' AND '$enddate' and ( fromwhs in(select ob_value from t_user_object_auth where username='$user') OR towhs in(select ob_value from t_user_object_auth where username='$user')) order by resnum desc");
        }
		return $this->db->resultSet();
    }

    // header exeport PO
    public function getWosData($strdate, $enddate){
        $this->db->query("SELECT * FROM v_wos01 WHERE createdon BETWEEN '$strdate' AND '$enddate' order by customer, id asc");
        return $this->db->resultSet();
    }

    public function getWosTracking($wosid,$bomid){
        $this->db->query("SELECT * FROM v_wostrackingdetail WHERE wosid = '$wosid' AND bomid = '$bomid' order by processid asc");
        return $this->db->resultSet();
    }
}