<?php

class Role extends Controller {

    public function index(){
        $check = $this->model('Home_model')->checkUsermenu('role','Read');
        if ($check){
            $data['title'] = 'Role';
            $data['menu']  = 'Role';

            // Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
            //-------------------------------------------------------------------------   

            $data['roles'] = $this->model('Role_model')->getList();   

            $this->view('templates/header_a', $data);
            $this->view('role/index', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function create(){
        $check = $this->model('Home_model')->checkUsermenu('role','Create');
        if ($check){
            $data['title'] = 'Create role';
            $data['menu']  = 'Create role';

            // Wajib di semua route ke view
            $data['setting']  = $this->model('Setting_model')->getgensetting();
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         

            $this->view('templates/header_a', $data);
            $this->view('role/create', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }         
    }

    public function edit($id){
        $check = $this->model('Home_model')->checkUsermenu('role','Update');
        if ($check){
            $data['title'] = 'Edit role';
            $data['menu']  = 'Edit role';

            // Wajib di semua route ke view
            $data['setting']  = $this->model('Setting_model')->getgensetting();
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         

            $data['menus']    = $this->model('Role_model')->getRoleById($id);

            $this->view('templates/header_a', $data);
            $this->view('role/edit', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }         
    }

    public function listrole(){
        $data['data'] = $this->model('Role_model')->getList();   
        echo json_encode($data);
    }

    public function save(){
		if( $this->model('Role_model')->save($_POST) > 0 ) {
			Flasher::setMessage('role created','','success');
			header('location: '. BASEURL . '/role');
			exit;			
		}else{
			Flasher::setMessage('Failed,','','danger');
			header('location: '. BASEURL . '/role');
			exit;	
	    }
    }

    public function update(){
        $check = $this->model('Home_model')->checkUsermenu('role','Update');
        if ($check){
            if( $this->model('Role_model')->update($_POST) > 0 ) {
                Flasher::setMessage('role updated','','success');
                header('location: '. BASEURL . '/role');
                exit;			
            }else{
                Flasher::setMessage('Failed,','','danger');
                header('location: '. BASEURL . '/role');
                exit;	
            }
        }else{
            echo json_encode('un authorized!');
        }  
    }
    
    public function delete($id){
        $check = $this->model('Home_model')->checkUsermenu('role', 'Delete');
        if ($check){
            if( $this->model('Role_model')->delete($id) > 0 ) {
                Flasher::setMessage('role deleted','','success');
                header('location: '. BASEURL . '/role');
                exit;			
            }else{
                Flasher::setMessage('Failed,','','danger');
                header('location: '. BASEURL . '/role');
                exit;	
            }
        }else{
            $this->view('templates/401');
        }         
    }
}