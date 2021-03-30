<?php

class Wos extends Controller {

    public function index(){
        $check = $this->model('Home_model')->checkUsermenu('wos','Read');
        if ($check){
            $data['title'] = 'Input WOS';
            $data['menu']  = 'Input WOS';

            // Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
            //-------------------------------------------------------------------------   

            $this->view('templates/header_a', $data);
            $this->view('wos/create', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function displaywos(){
        $check = $this->model('Home_model')->checkUsermenu('wos/displaywos','Read');
        if ($check){
            $data['title'] = 'Display WOS';
            $data['menu']  = 'Display WOS';

            // Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
            //-------------------------------------------------------------------------   

            $this->view('templates/header_a', $data);
            $this->view('wos/display', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function receiptwos(){
        $check = $this->model('Home_model')->checkUsermenu('wos/receiptwos','Read');
        if ($check){
            $data['title'] = 'Receipt WOS';
            $data['menu']  = 'Receipt WOS';

            // Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
            //-------------------------------------------------------------------------   

            $data['meja']     = $this->model('Meja_model')->listnomeja();
            $data['userlist'] = $this->model('User_model')->userList();
			$data['activity'] = $this->model('Activity_model')->activityList();
			$data['defect']   = $this->model('Inspection_model')->jenisDefect();
			$data['section']  = $this->model('Inspection_model')->defectSection();

            $this->view('templates/header_a', $data);
            $this->view('wos/receiptwos', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function report(){
        $check = $this->model('Home_model')->checkUsermenu('wos','Read');
        if ($check){
            $data['title'] = 'WOS Report';
            $data['menu']  = 'WOS Report';

            // Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
            //-------------------------------------------------------------------------   

            $this->view('templates/header_a', $data);
            $this->view('wos/reports', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    // wos/receiptwos
    public function getwosdata($reffid){
        $data = $this->model('Wos_model')->getwosdata($reffid);
        echo json_encode($data);
    }

    public function getwoslastposition($reffid){
        $data = $this->model('Wos_model')->checkWosLastPosition($reffid);
        echo json_encode($data);
    }

    public function getwosdatabydate($strdate, $enddate){
        $data['data'] = $this->model('Wos_model')->getwosbydate($strdate, $enddate);
        echo json_encode($data);
    }

    public function save(){
        $isreffidused = $this->model('Wos_model')->reffidvalidation($_POST['reffid']);
        if($isreffidused['rows'] > 0){
            $return = array(
                "msgtype" => "2",
                "message" => "REFFID ". $_POST['reffid'] . " already use in other WOS"
            );
            echo json_encode($return);
            exit;
        }else{
            if( $this->model('Wos_model')->save($_POST) > 0 ) {
                $return = array(
                    "msgtype" => "1",
                    "message" => "WOS Data created"
                );
                echo json_encode($return);
                exit;				
            }else{
                $return = array(
                    "msgtype" => "2",
                    "message" => "WOS Error"
                );
                echo json_encode($return);
                exit;	
            }
        }
    }

    public function checkreffiduse($reffid){
        $data = $this->model('Wos_model')->reffidvalidation($reffid);
        echo json_encode($data);
    }

    public function savewos(){
        
            if( $this->model('Wos_model')->savewos($_POST) > 0 ) {
                $return = array(
                    "msgtype" => "1",
                    "message" => "WOS Data created"
                );
                echo json_encode($return);
                exit;				
            }else{
                $return = array(
                    "msgtype" => "2",
                    "message" => "WOS Error"
                );
                echo json_encode($return);
                exit;	
            }
    }

    public function closewos($reffid){
        if( $this->model('Wos_model')->closewos($reffid,$_POST) > 0 ) {
            $return = array(
                "msgtype" => "1",
                "message" => "WOS REFFID ". $reffid . ' Closed'
            );
            echo json_encode($return);
            exit;				
        }else{
            $return = array(
                "msgtype" => "2",
                "message" => "WOS Error"
            );
            echo json_encode($return);
            exit;	
        }
    }
}