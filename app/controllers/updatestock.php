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
        if( $this->model('Updatestock_model')->post($_POST) > 0 ) {
			Flasher::setMessage('Update Material Stock ', ' Success!', 'success');
			header('location: '. BASEURL . '/updatestock');
			exit;			
		}else{
			$result = ["msg"=>"error"];
			header('location: '. BASEURL . '/updatestock');
			exit;	
        }
    }

    public function oldqty($material,$whs){
        $data = $this->model('Updatestock_model')->getOldQty($material,$whs);
        echo json_encode($data);
    }
}