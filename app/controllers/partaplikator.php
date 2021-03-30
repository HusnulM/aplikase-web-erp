<?php

class Partaplikator extends Controller{

    public function __construct(){
		if( isset($_SESSION['usr']) ){

		}else{
			header('location:'. BASEURL);
		}
    }

    public function index(){
        $check = $this->model('Home_model')->checkUsermenu('partaplikator','Create');
        if ($check){
            $data['title'] = 'Spare Part Aplikator';
            $data['menu']  = 'Spare Part Aplikator';

            // Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
            //-------------------------------------------------------------------------   

            $this->view('templates/header_a', $data);
            $this->view('partaplikator/index', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function display(){
        $check = $this->model('Home_model')->checkUsermenu('partaplikator','Read');
        if ($check){
            $data['title'] = 'Spare Part Aplikator';
            $data['menu']  = 'Spare Part Aplikator';

            // Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
            //-------------------------------------------------------------------------   

            $this->view('templates/header_a', $data);
            $this->view('partaplikator/reports', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }
}