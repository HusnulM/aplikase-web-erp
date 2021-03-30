<?php

class Wosprocess extends Controller {
    public function __construct(){
		if( isset($_SESSION['usr']) ){
		}else{
			header('location:'. BASEURL);
		}
    }
    
    public function index(){
        $check = $this->model('Home_model')->checkUsermenu('wosprocess','Read');
        if ($check){
            $data['title'] = 'WOS Process';
            $data['menu']  = 'WOS Process';

            // Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
            //-------------------------------------------------------------------------   

            $this->view('templates/header_a', $data);
            $this->view('wosprocess/index', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function processwos(){        
        $data = $_POST['items'][0];
        $idpr = $_POST['items'][1]['process'];
        $checkwos = $this->model('Wosprocess_model')->getWOSLastProcessByReffid($data['wosrfid'],$data['reffidmesin'],$idpr);
        if($checkwos['rows'] > 0){
            $return = array(
                "msgtype" => "2",
                "message" => "WOS already processed in area ". $data['reffidmesin']
            );
            echo json_encode($return);
            exit;
        }else{
            if( $this->model('Wosprocess_model')->save($_POST) > 0 ) {
                $return = array(
                    "msgtype" => "1",
                    "message" => "WOS Data Processed"
                );
                echo json_encode($return);
                exit;				
            }else{
                $return = array(
                    "msgtype" => "2",
                    "message" => "Error"
                );
                echo json_encode($return);
                exit;	
            }
        }
    }
}