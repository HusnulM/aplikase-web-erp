<?php

class Project extends Controller {

    public function __construct(){
		if( isset($_SESSION['usr']) ){
		}else{
			header('location:'. BASEURL);
		}
    }
    
    public function index()
	{
		$check = $this->model('Home_model')->checkUsermenu('project','Read');
		if ($check){

			$data['title'] = 'Project';
			$data['menu'] = 'Project';

			// Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
            //-------------------------------------------------------------------------   
            $data['rdata']    = $this->model('Project_model')->projectList();

			$this->view('templates/header_a', $data);
			$this->view('project/index', $data);
			$this->view('templates/footer_a');
		}else{
			$this->view('templates/401');
		}
    }
    
    public function create()
	{
		$check = $this->model('Home_model')->checkUsermenu('project','Create');
		if ($check){
			$data['title'] = 'Project';
			$data['menu'] = 'Create';
            // Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
            //-------------------------------------------------------------------------   

			$this->view('templates/header_a', $data);
			$this->view('project/create', $data);
			$this->view('templates/footer_a');
		}else{
			$this->view('templates/401');
		}
    }
    
    public function edit($idproject)
	{
		$check = $this->model('Home_model')->checkUsermenu('project','Update');
		if ($check){
			$data['title'] = 'Project';
			$data['menu'] = 'Edit';
            // Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
			//-------------------------------------------------------------------------   
			
            $data['rdata'] = $this->model('Project_model')->getprojectbyid($idproject);

			$this->view('templates/header_a', $data);
			$this->view('project/edit', $data);
			$this->view('templates/footer_a');
		}else{
			$this->view('templates/401');
		}
	}
	
	public function getprojectbyid($idproject){
		$data = $this->model('Project_model')->getprojectbyid($idproject);
		echo json_encode($data);
	}

    public function save(){
        if( $this->model('Project_model')->saveproject($_POST) > 0 ) {
			Flasher::setMessage('New Project ','Created','success');
			header('location: '. BASEURL . '/project');
			exit;			
		}else{
			Flasher::setMessage('Error','','danger');
			header('location: '. BASEURL . '/project');
			exit;	
		}
    }

    public function update(){
        if( $this->model('Project_model')->updateproject($_POST) > 0 ) {
			Flasher::setMessage('Project ','Updated','success');
			header('location: '. BASEURL . '/project');
			exit;			
		}else{
			Flasher::setMessage('Error','','danger');
			header('location: '. BASEURL . '/project');
			exit;	
		}
	}
	
	public function delete($idproject){
		$check = $this->model('Home_model')->checkUsermenu('project','Delete');
		if ($check){
			if( $this->model('Project_model')->deleteproject($idproject) > 0 ) {
				Flasher::setMessage('Project berhasil ','di hapus','success');
				header('location: '. BASEURL . '/project');
				exit;			
			}else{
				Flasher::setMessage('Error','','danger');
				header('location: '. BASEURL . '/project');
				exit;	
			}
		}else{
			$this->view('templates/401');
		}
    }

}