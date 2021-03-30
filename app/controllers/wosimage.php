<?php

class Wosimage extends Controller {

    public function index(){
        $check = $this->model('Home_model')->checkUsermenu('wosimage','Read');
        if ($check){
            $data['title'] = 'Maintain WOS Image';
            $data['menu']  = 'Maintain WOS Image';

            // Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
            //-------------------------------------------------------------------------   

            $data['partlist'] = $this->model('Bom_model')->bomList();

            $this->view('templates/header_a', $data);
            $this->view('wosimage/index', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function maintainimage($bomid){
        $check = $this->model('Home_model')->checkUsermenu('wosimage','Create');
        if ($check){
            $data['title'] = 'Maintain WOS Image';
            $data['menu']  = 'Maintain WOS Image';

            // Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
            //-------------------------------------------------------------------------   

            $data['wosimage'] = $this->model('Wosimage_model')->getWosImage($bomid);
            $data['partdata'] = $this->model('Wosimage_model')->getPartDetail($bomid);
            $data['bomid']    = $bomid;

            $this->view('templates/header_a', $data);
            $this->view('wosimage/create', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }  
    }

    public function maintainpartimage($bomid){
        $check = $this->model('Home_model')->checkUsermenu('wosimage','Create');
        if ($check){
            $data['title'] = 'Maintain Part Image';
            $data['menu']  = 'Maintain Part Image';

            // Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
            //-------------------------------------------------------------------------   

            $data['partimage'] = $this->model('Wosimage_model')->gePartImageByBomid($bomid);
            $data['partdata']  = $this->model('Wosimage_model')->getPartDetail($bomid);
            $data['bomid']     = $bomid;

            // echo json_encode($data['partimage']);
            $this->view('templates/header_a', $data);
            $this->view('wosimage/partimage', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }  
    }

    public function partimage($params){
        $url = parse_url($_SERVER['REQUEST_URI']);
        $data = parse_str($url['query'], $params);
		$partnumber = $params['partnumber'];
        $data = $this->model('Wosimage_model')->gePartImage($partnumber);
        echo json_encode($data);
    }

    public function save(){
        if( $this->model('Wosimage_model')->save($_POST) > 0 ) {
            $return = array(
                "msgtype" => "1",
                "message" => "WOS Data created"
            );
            echo json_encode($return);
            exit;				
		}else{
            $return = array(
                "msgtype" => "2",
                "message" => "WOW Error"
            );
            echo json_encode($return);
            exit;	
        }
    }

    public function savepartimage(){
        if( $this->model('Wosimage_model')->savepartimage($_POST) > 0 ) {
            $return = array(
                "msgtype" => "1",
                "message" => "WOS Data created"
            );
            echo json_encode($return);
            exit;				
		}else{
            $return = array(
                "msgtype" => "2",
                "message" => "WOW Error"
            );
            echo json_encode($return);
            exit;	
        }
    }

    public function deleteimage($bomid, $circuitno){
        if( $this->model('Wosimage_model')->deleteimage($bomid, $circuitno) > 0 ) {
			Flasher::setMessage('WOS Image Deleted','','success');
			header('location: '. BASEURL . '/wosimage/maintainimage/'.$bomid);
            exit;
            exit;				
		}else{
			Flasher::setMessage('Failed,','','danger');
			header('location: '. BASEURL . '/wosimage/maintainimage/'.$bomid);
            exit;	
        }
    }
}