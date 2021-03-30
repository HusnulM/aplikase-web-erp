<?php

class Activity extends Controller {

    public function index(){
        $check = $this->model('Home_model')->checkUsermenu('activity', 'Read');
        if ($check){
            $data['title'] = 'Master activity';
            $data['menu']  = 'Master activity';

            // Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
            //-------------------------------------------------------------------------   

            $data['activity'] = $this->model('Activity_model')->activityList();

            $this->view('templates/header_a', $data);
            $this->view('activity/index', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function create(){
        $check = $this->model('Home_model')->checkUsermenu('activity', 'Create');
        if ($check){
            $data['title'] = 'Create activity';
            $data['menu']  = 'Create activity';

            // Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
            //-------------------------------------------------------------------------  

            $this->view('templates/header_a', $data);
            $this->view('activity/create', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function edit($activityid){
        $check = $this->model('Home_model')->checkUsermenu('activity', 'Update');
        if ($check){
            $data['title'] = 'Detail activity';
            $data['menu']  = 'Detail activity';

            // Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
            //-------------------------------------------------------------------------   

            $data['activity'] = $this->model('Activity_model')->activityDetail($activityid);

            $this->view('templates/header_a', $data);
            $this->view('activity/edit', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function save(){
        if( $this->model('Activity_model')->save($_POST) > 0 ) {
			$return = array(
                "msgtype" => "1",
                "message" => "activity Created!"
            );
            echo json_encode($return);
			exit;			
		}else{
			$return = array(
                "msgtype" => "2",
                "message" => "Error Create activity!"
            );
            echo json_encode($return);
			exit;	
        }
    }

    public function update(){
        if( $this->model('Activity_model')->update($_POST) > 0 ) {
			$return = array(
                "msgtype" => "1",
                "message" => "activity Updated!"
            );
            echo json_encode($return);
			exit;			
		}else{
			$return = array(
                "msgtype" => "2",
                "message" => "Error Update activity!"
            );
            echo json_encode($return);
			exit;	
        }
    }

    public function delete($activityid){
        if($_SESSION['usr']['userlevel'] == "SysAdmin"){
            if( $this->model('Activity_model')->delete($activityid) > 0 ) {
    			Flasher::setMessage('activity','Deleted!','success');
    			header('location: '. BASEURL . '/activity');
    			exit;			
    		}else{
    			Flasher::setMessage('Error','','success');
    			header('location: '. BASEURL . '/activity');
    			exit;	
            }
        }else{
            $this->view('templates/401');
        } 
	}
	
	public function getActivityList(){
		$data['data'] = $this->model('Activity_model')->activityList();
		echo json_encode($data);
	}

    
}