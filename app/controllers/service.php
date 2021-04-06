<?php

class Service extends Controller{
    public function __construct(){
		if( isset($_SESSION['usr']) ){

		}else{
			header('location:'. BASEURL);
		}
    }

    public function index(){
        $check = $this->model('Home_model')->checkUsermenu('service','Read');
        if ($check){
            $data['title'] = 'Service Order';
            $data['menu']  = 'Service Order';

            // Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
            //-------------------------------------------------------------------------   

            $data['srvdata'] = $this->model('Service_model')->getOpenServiceData();   

            $this->view('templates/header_a', $data);
            $this->view('service/index', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function create(){
        $check = $this->model('Home_model')->checkUsermenu('service','Create');
        if ($check){
            $data['title'] = 'Create Service Order';
            $data['menu']  = 'Create Service Order';

            // Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
            //-------------------------------------------------------------------------   

            // $data['roles'] = $this->model('Role_model')->getList();   
            $data['whs']      = $this->model('Warehouse_model')->getWarehouseByAuth();  

            $this->view('templates/header_a', $data);
            $this->view('service/create', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function detail($servicenum){
        $check = $this->model('Home_model')->checkUsermenu('service','Read');
        if ($check){
            $data['title'] = 'Detail Service Order';
            $data['menu']  = 'Detail Service Order';

            // Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
            //-------------------------------------------------------------------------   

            // $data['roles'] = $this->model('Role_model')->getList();   
            $data['whs']       = $this->model('Warehouse_model')->getWarehouseByAuth();  
            $data['srvheader'] = $this->model('Service_model')->getOpenServiceByID($servicenum);

            if($data['srvheader']['servicestatus'] === "X"){
                Flasher::setMessage('Service ', $servicenum . ' already confirm!', 'danger');
                header('location: '. BASEURL . '/service');
                exit;	
            }else{
                $data['srvdetail'] = $this->model('Service_model')->getOpenServiceItemByID($servicenum);
    
                $this->view('templates/header_a', $data);
                $this->view('service/detail', $data);
                $this->view('templates/footer_a');
            }
        }else{
            $this->view('templates/401');
        }        
    }

    public function confirm(){
        $check = $this->model('Home_model')->checkUsermenu('service/confirm','Read');
        if ($check){
            $data['title'] = 'Service Order Confirmation';
            $data['menu']  = 'Service Order Confirmation';

            // Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
            //-------------------------------------------------------------------------   

            $data['services'] = $this->model('Service_model')->getOpenServiceData(); 

            $this->view('templates/header_a', $data);
            $this->view('service/servicelist', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function serviceconfirm($servicenum){
        $check = $this->model('Home_model')->checkUsermenu('service/confirm','Create');
        if ($check){
            $data['title'] = 'Service Order Confirmation';
            $data['menu']  = 'Service Order Confirmation';

            // Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
            //-------------------------------------------------------------------------   

            $data['services']     = $this->model('Service_model')->getOpenServiceByID($servicenum);   
            $data['servicesitem'] = $this->model('Service_model')->getOpenServiceItemByID($servicenum);  
            $data['_whs']         = $this->model('Warehouse_model')->getById($data['services']['warehouse']); 

            $this->view('templates/header_a', $data);
            $this->view('service/confirm', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function printservice($servicenum){
        $data['setting']  = $this->model('Setting_model')->getgensetting();
		$data['header']   = $this->model('Service_model')->getOpenServiceByID($servicenum);
		$data['items']    = $this->model('Service_model')->getOpenServiceItemByID($servicenum);
		$this->view('service/cetak', $data);
    }

    // Action
    public function listbatchstock(){
        $data['data'] = $this->model('Service_model')->getBatchStock();  
        echo json_encode($data);
    }

    public function listmaterial($whs){
        $data['data'] = $this->model('Service_model')->getStock($whs);  
        echo json_encode($data);
    }

    public function listreservasi(){
        $data['data'] = $this->model('Movement_model')->getResrvasi();
        echo json_encode($data);
    }

    public function getreservationitem($rsnum){
        $data = $this->model('Reservation_model')->getReservation02($resnum);
        echo json_encode($data);
    }

    public function save(){
        $checkstock = $this->model('Service_model')->checkinventorystock($_POST);
        if(count($checkstock) > 0){
            $return = array(
                "msgtype" => "3",
                "message" => $checkstock
            );
            echo json_encode($return);
        }else{
            $nextNumb = $this->model('Service_model')->getNextPONumber('SERVICE');
            if( $this->model('Service_model')->save($_POST, 'SRV-'.$nextNumb['nextnumb']) > 0 ) {			
                $return = array(
                    "msgtype" => "1",
                    "message" => "Service Order Created",
                    "docnum"  => $nextNumb['nextnumb']
                );
                echo json_encode($return);
                exit;			
            }else{
                $return = array(
                    "msgtype" => "2",
                    "message" => "Error!",
                    "docnum"  => ''
                );
                $this->model('Service_model')->delete($nextNumb['nextnumb']);
                echo json_encode($return);
                exit;	
            }
        }
	}

    public function update(){
        $servicenum = $_POST['servicenum'];
		if( $this->model('Service_model')->update($_POST, $servicenum) > 0 ) {			
			Flasher::setMessage('Service ', $servicenum . ' updated!', 'success');
			header('location: '. BASEURL . '/service');
			exit;			
		}else{
			// $this->model('Service_model')->delete_error('SRV-'.$nextNumb['nextnumb']);
			$result = ["msg"=>"error"];
			header('location: '. BASEURL . '/service');
			exit;	
		}
        // echo json_encode($_POST);
	}

    public function postconfirmservice(){
        // echo json_encode($_POST);
        $checkstock = $this->model('Service_model')->checkinventorystock($_POST);
        // echo json_encode($checkstock);
        if(count($checkstock) > 0){
            $return = array(
                "msgtype" => "3",
                "message" => "Check inventory stock",
                "data"    => $checkstock
            );
            echo json_encode($return);
        }elseif(count($checkstock) == 0){
            $nextNumb = $this->model('Home_model')->getNextNumber('GI');
            if( $this->model('Service_model')->postconfirmservice($_POST, $nextNumb['nextnumb']) > 0 ) {
                $return = array(
                    "msgtype" => "1",
                    "message" => "Service Order Confirmed",
                    "docnum"  => $nextNumb['nextnumb']
                );
                echo json_encode($return);
                exit;			
            }else{
                $return = array(
                    "msgtype" => "2",
                    "message" => "Error!",
                    "data"    => Flasher::errorMessage()
                );
                // $this->model('Service_model')->delete($nextNumb['nextnumb']);
                echo json_encode($return);
                exit;	
            }
        }
    }

    public function delete($servicenum){
		if( $this->model('Service_model')->delete($servicenum) > 0 ) {			
			Flasher::setMessage('Service ', $servicenum . ' deleted!', 'success');
			header('location: '. BASEURL . '/service');
			exit;			
		}else{
			// $this->model('Service_model')->delete_error('SRV-'.$nextNumb['nextnumb']);
			$result = ["msg"=>"error"];
			header('location: '. BASEURL . '/service');
			exit;	
		}
        // echo json_encode($_POST);
	}
}