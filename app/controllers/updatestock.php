<?php

class Updatestock extends Controller {

    public function index(){
        $check = $this->model('Home_model')->checkUsermenu('updatestock', 'Read');
        if ($check){
            $data['title'] = 'Update Stock';
            $data['menu']  = 'Update Stock';

            // Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
            //-------------------------------------------------------------------------   

            // $data['whs'] = $this->model('Warehouse_model')->getWarehouseByAuth();

            $this->view('templates/header_a', $data);
            $this->view('updatestock/index', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function post(){      
        $nextNumb = $this->model('Home_model')->getNextNumber('GROTHER');
        if( $this->model('Updatestock_model')->post($_POST, $nextNumb['nextnumb']) > 0 ) {
			// Flasher::setMessage('Update Material Stock ', ' Success!', 'success');
			// header('location: '. BASEURL . '/updatestock');
            $return = array(
                "msgtype" => "1",
                "message" => "Stock Updated",
                "docnum"  => $nextNumb['nextnumb']
            );
            echo json_encode($return);
			exit;			
		}else{
			// $result = ["msg"=>"error"];
			// header('location: '. BASEURL . '/updatestock');
            $return = array(
                "msgtype" => "2",
                "message" => "Error update stock",
                "docnum"  => ""
            );
			exit;	
        }
    }

    public function oldqty($material,$whs){
        $data = $this->model('Updatestock_model')->getOldQty($material,$whs);
        echo json_encode($data);
    }
}