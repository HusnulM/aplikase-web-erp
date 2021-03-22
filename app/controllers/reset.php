<?php

class Reset extends Controller{
    public function __construct(){
		if( isset($_SESSION['usr']) ){
            if($_SESSION['usr']['userlevel'] == 'SysAdmin'){

            }else{
                header('location:'. BASEURL);
            }
		}else{
			header('location:'. BASEURL);
		}
    }
    
    public function index(){
		$check = $this->model('Home_model')->checkUsermenu('reset','Create');
        if ($check){
			$data['title'] = 'Reset Data';
			$data['menu']  = 'Reset Data';
			$data['menu-dsc'] = '';
	
			$data['setting'] = $this->model('Setting_model')->getgensetting();
	
			$this->view('templates/header_a', $data);
			$this->view('reset/index', $data);
			$this->view('templates/footer_a');
		}else{
			$this->view('templates/401');
		}
    }

	public function resetdata(){
		$this->model('Home_model')->resetdata();
	}
}