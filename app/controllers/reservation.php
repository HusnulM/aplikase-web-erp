<?php

class Reservation extends Controller {

    public function index(){
        $check = $this->model('Home_model')->checkUsermenu('reservation', 'Read');
        if ($check){
            $data['title'] = 'Create Reservation';
            $data['menu']  = 'Create Reservation';

            // Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
            //-------------------------------------------------------------------------   

            $data['whs'] = $this->model('Warehouse_model')->getWarehouseByAuth();

            $this->view('templates/header_a', $data);
            $this->view('reservation/index', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function post(){
        $nextNumb = $this->model('Home_model')->getNextNumber('RSRV');
		if( $this->model('Reservation_model')->post($_POST, $nextNumb['nextnumb']) > 0 ) {
			$result = ["msg"=>"success", "docnum"=>$nextNumb];
			echo json_encode($result);
			exit;			
		}else{
			$result = ["msg"=> Flasher::errorMessage()];
            echo json_encode($result);
            $this->model('Reservation_model')->delete($nextNumb['nextnumb']);
			exit;	
		}
    }


    public function reservationitem($resnum){
        $check = $this->model('Home_model')->checkUsermenu('reservation', 'Read');
        if ($check){
            $data = $this->model('Reservation_model')->getReservation02($resnum);
            echo json_encode($data);
        }else{
            echo json_encode("unauthorize!");
        }
    }
}