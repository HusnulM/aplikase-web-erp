<?php

class Menu_model{

    private $db;

    public function __construct()
	{
		$this->db = new Database;
    }
    
    public function getListMenu(){
        $this->db->query("SELECT * FROM t_menus order by grouping, route asc");
		return $this->db->resultSet();
    }

    public function getMenuById($id){
        $this->db->query("SELECT * FROM t_menus where id='$id'");
		return $this->db->single();
    }

    public function  save($data){
        $currentDate = date('Y-m-d');
        $query = "INSERT INTO t_menus (menu,route,type,icon,grouping,createdon,createdby) 
                      VALUES(:menu,:route,:type,:icon,:grouping,:createdon,:createdby)";
        $this->db->query($query);
        
        $this->db->bind('menu',     $data['menu']);
        $this->db->bind('route',    $data['route']);
        $this->db->bind('type',     $data['type']);
        $this->db->bind('icon',     '');
        $this->db->bind('grouping', $data['group']);
        $this->db->bind('createdon',$currentDate);
        $this->db->bind('createdby',$_SESSION['usr']['user']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function update($data){
        $query = "UPDATE t_menus set menu=:menu, route=:route, type=:type, grouping=:grouping WHERE id=:id";
        $this->db->query($query);

        $this->db->bind('id',       $data['idmenu']);
        $this->db->bind('menu',     $data['menu']);
        $this->db->bind('route',    $data['route']);
        $this->db->bind('type',     $data['type']);
        $this->db->bind('grouping', $data['group']);
        $this->db->execute();

        return $this->db->rowCount();        
    }
}