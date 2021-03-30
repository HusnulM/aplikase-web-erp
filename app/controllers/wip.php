<?php

class Wip extends Controller {

    public function index(){
        $check = $this->model('Home_model')->checkUsermenu('wip','Read');
        if ($check){
            $data['title'] = 'Progress WIP Process';
            $data['menu']  = 'Progress WIP Process';

            // Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
            //-------------------------------------------------------------------------   

            $data['meja']     = $this->model('Meja_model')->listnomeja();
            $data['bomdata']  = $this->model('Bom_model')->bomList();
            $data['wipauth']  = $this->model('Wip_model')->getWipProcessAuth();

            $this->view('templates/header_a', $data);
            $this->view('wip/index', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function reportsummary(){
        $check = $this->model('Home_model')->checkUsermenu('wip','Read');
        if ($check){
            $data['title'] = 'Report Summary WIP';
            $data['menu']  = 'Report Summary WIP';

            // Wajib di semua route ke view
            $data['setting']  = $this->model('Setting_model')->getgensetting();
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();    
            
            $data['wip'] = $this->model('Wip_model')->reportSummaryWIP();

            // echo json_encode($data['wip']);

            $this->view('templates/header_a', $data);
            $this->view('wip/summarywip', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }         
    }

    public function reportdetail(){
        $check = $this->model('Home_model')->checkUsermenu('wip','Read');
        if ($check){
            $data['title'] = 'Report Summary WIP';
            $data['menu']  = 'Report Detail WIP';

            // Wajib di semua route ke view
            $data['setting']  = $this->model('Setting_model')->getgensetting();
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         

            $this->view('templates/header_a', $data);
            $this->view('wip/detailwip', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }         
    }

    public function getdetailwip($strdate, $enddate){
        $data['data'] = $this->model('Wip_model')->getDetailWIP($strdate, $enddate);
        echo json_encode($data);
    }

    public function create(){
        $check = $this->model('Home_model')->checkUsermenu('wip','Create');
        if ($check){
            $data['title'] = 'Create wip';
            $data['menu']  = 'Create wip';

            // Wajib di semua route ke view
            $data['setting']  = $this->model('Setting_model')->getgensetting();
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         

            $this->view('templates/header_a', $data);
            $this->view('wip/create', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }         
    }

    public function edit($id){
        $check = $this->model('Home_model')->checkUsermenu('wip','Update');
        if ($check){
            $data['title'] = 'Edit wip';
            $data['menu']  = 'Edit wip';

            // Wajib di semua route ke view
            $data['setting']  = $this->model('Setting_model')->getgensetting();
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         

            $data['whs']      = $this->model('Wip_model')->getById($id);

            $this->view('templates/header_a', $data);
            $this->view('wip/edit', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }         
    }

    public function save(){
		if( $this->model('Wip_model')->save($_POST) > 0 ) {
			// Flasher::setMessage('wip created','','success');
			// header('location: '. BASEURL . '/wip');
            // exit;
            $return = array(
                "msgtype" => "1",
                "message" => "WIP Process created"
            );
            echo json_encode($return);
            exit;				
		}else{
			// Flasher::setMessage('Failed,','','danger');
			// header('location: '. BASEURL . '/wip');
            // exit;	
            $return = array(
                "msgtype" => "2",
                "message" => "WIP Process error"
            );
            echo json_encode($return);
            exit;	
        }
    }

    public function update(){
        if( $this->model('Wip_model')->update($_POST) > 0 ) {
			Flasher::setMessage('wip updated','','success');
			header('location: '. BASEURL . '/wip');
			exit;			
		}else{
			Flasher::setMessage('Failed,','','danger');
			header('location: '. BASEURL . '/wip');
			exit;	
	    }
    }
    
    public function delete($id){
        $check = $this->model('Home_model')->checkUsermenu('wip', 'Delete');
        if ($check){
            if( $this->model('Wip_model')->delete($id) > 0 ) {
                Flasher::setMessage('wip deleted','','success');
                header('location: '. BASEURL . '/wip');
                exit;			
            }else{
                Flasher::setMessage('Failed,','','danger');
                header('location: '. BASEURL . '/wip');
                exit;	
            }
        }else{
            $this->view('templates/401');
        }         
    }

    public function listwip(){
        $data = $this->model('Wip_model')->getwipByAuth();   
        echo json_encode($data);
    }

    public function reportwip($strdate, $enddate){
        $data = $this->model('Wip_model')->getWipData($strdate, $enddate);
        $this->view('wip/pivot', $data);
    }
}