<?php

class Curs extends Controller {

    public function index(){
        $check = $this->model('Home_model')->checkUsermenu('curs', 'Read');
        if ($check){
            $data['title'] = 'Curs Conversion';
            $data['menu']  = 'Curs Conversion';

            // Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
            //-------------------------------------------------------------------------   

            $data['cursdata'] = $this->model('Curs_model')->cursList();

            $this->view('templates/header_a', $data);
            $this->view('curs/index', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function create(){
        $check = $this->model('Home_model')->checkUsermenu('curs', 'Create');
        if ($check){
            $data['title'] = 'Maintain Curs';
            $data['menu']  = 'Maintain Curs';

            // Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
            //-------------------------------------------------------------------------   

            $data['cursdata'] = $this->model('Curs_model')->cursList();

            $this->view('templates/header_a', $data);
            $this->view('curs/create', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function detail($cursid){
        $check = $this->model('Home_model')->checkUsermenu('curs', 'Update');
        if ($check){
            $data['title'] = 'Detail curs';
            $data['menu']  = 'Detail curs';

            // Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
            //-------------------------------------------------------------------------   

            $data['curshead'] = $this->model('Curs_model')->cursHeader($cursid);
            $data['cursdata'] = $this->model('Curs_model')->cursDetail($cursid);
            $data['cursdtl']  = json_encode($data['cursdata']);
            $data['cursid']   = $cursid;

            $this->view('templates/header_a', $data);
            $this->view('curs/detail', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function save(){
        if( $this->model('Curs_model')->save($_POST) > 0 ) {
			$return = array(
                "msgtype" => "1",
                "message" => "curs Created!"
            );
            echo json_encode($return);
			exit;			
		}else{
			$return = array(
                "msgtype" => "2",
                "message" => "Error Create curs!"
            );
            echo json_encode($return);
			exit;	
        }
    }

    public function update(){
        if( $this->model('Curs_model')->update($_POST) > 0 ) {
			$return = array(
                "msgtype" => "1",
                "message" => "curs Updated!"
            );
            echo json_encode($return);
			exit;			
		}else{
			$return = array(
                "msgtype" => "2",
                "message" => "Error Update curs!"
            );
            echo json_encode($return);
			exit;	
        }
    }

    public function delete($cursid){
        if($_SESSION['usr']['userlevel'] == "SysAdmin"){
            if( $this->model('Curs_model')->delete($cursid) > 0 ) {
    			Flasher::setMessage('curs','Deleted!','success');
    			header('location: '. BASEURL . '/curs');
    			exit;			
    		}else{
    			Flasher::setMessage('Error','','success');
    			header('location: '. BASEURL . '/curs');
    			exit;	
            }
        }else{
            $this->view('templates/401');
        } 
    }
}