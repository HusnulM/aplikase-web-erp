<?php

class Aplikator extends Controller{
    public function __construct(){
		if( isset($_SESSION['usr']) ){

		}else{
			header('location:'. BASEURL);
		}
    }

    public function index(){
        $check = $this->model('Home_model')->checkUsermenu('aplikator','Create');
        if ($check){
            $data['title'] = 'Master Aplikator';
            $data['menu']  = 'Master Aplikator';

            // Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
            //-------------------------------------------------------------------------   

            $this->view('templates/header_a', $data);
            $this->view('aplikator/index', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function display(){
        $check = $this->model('Home_model')->checkUsermenu('aplikator','Read');
        if ($check){
            $data['title'] = 'Master Aplikator';
            $data['menu']  = 'Master Aplikator';

            // Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
            //-------------------------------------------------------------------------   

            $this->view('templates/header_a', $data);
            $this->view('aplikator/reports', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }
}