<?php

class User_model{
	
	private $db;
	private $table = 't_user';

	public function __construct()
	{
		$this->db = new Database;
	}

	public function userList(){
		$this->db->query("SELECT *, fGetJabatan(jabatan) as 'jabatan', fGetDepartment(department) as 'department' FROM t_user");
		return $this->db->resultSet();
	}

	public function getUserbyid($username){
		$this->db->query("SELECT * FROM t_user WHERE username = '$username'");
		return $this->db->single();
	}

	public function register($data){

		// var_dump($data);

		$this->db->query('SELECT * FROM t_user WHERE username=:username');
		$this->db->bind('username',$data['username']);
		$this->db->execute();
		$result = $this->db->rowCount();

		if($result > 0 ){
			return 'X';
		}else{
			$currentDate = date('Y-m-d');
			$options = [
			    'cost' => 12,
			];
			$password = password_hash($data['password'], PASSWORD_BCRYPT, $options);

			if($data['typeuser'] === "SysAdmin"){
				$data['jabatan'] = "9";
			}

			$query = "INSERT INTO t_user (username, password, nama, userlevel, department, jabatan, reffid, cust_id, createdby, createdon) 
					  VALUES(:username, :password, :nama, :userlevel, :department, :jabatan, :reffid, :cust_id, :createdby, :createdon)";
			$this->db->query($query);
			$this->db->bind('username',    $data['username']);
			$this->db->bind('password',    $password);
			$this->db->bind('nama',        $data['nama']);
			$this->db->bind('userlevel',   $data['typeuser']);
			$this->db->bind('department',  $data['department']);		
			$this->db->bind('jabatan',     $data['jabatan']);
			$this->db->bind('reffid',      $data['reffid']);
			$this->db->bind('cust_id',     $data['customer']);
			$this->db->bind('createdby',   $_SESSION['usr']['user']);
			$this->db->bind('createdon',   $currentDate);			
			$this->db->execute();

			return $this->db->rowCount();
		}
	}

	public function updateData($data){
		// $query = "UPDATE department set deptName=:deptName";
		// $this->db->query($query);
		// $this->db->bind('deptId',$data['deptId']);
		// $this->db->bind('deptName',$data['deptName']);
		// $this->db->execute();

		// return $this->db->rowCount();
	}

	public function deleteData($id){

		$this->db->query('DELETE FROM t_user WHERE username=:username');
		$this->db->bind('username',$id);
		$this->db->execute();

		return $this->db->rowCount();
	}

	public function updateDept($data){
		$this->db->query('UPDATE ' . $this->table . ' SET deptid=:deptid WHERE username=:username');
		$this->db->bind('deptid',$data['deptid']);
		$this->db->bind('username',$data['username']);
		$this->db->execute();

		return $this->db->rowCount();
	}

	public function updatePass(){
		$options = [
			'cost' => 12,
		];
		$password = password_hash($_POST['password'], PASSWORD_BCRYPT, $options);

		$this->db->query('UPDATE t_user SET password=:password WHERE username=:username');
		$this->db->bind('username',$_POST['username']);
		$this->db->bind('password',$password);
		$this->db->execute();

		return $this->db->rowCount();
	}

	public function updateuser($data){

		$options = [
			'cost' => 12,
		];

		if($_POST['password'] === ""){
			$password = $data['oldpass'];
		}else{
			$password = password_hash($data['password'], PASSWORD_BCRYPT, $options);
		}

		$this->db->query('UPDATE t_user SET password=:password, nama=:nama, userlevel=:userlevel, department=:department, jabatan=:jabatan, reffid=:reffid, cust_id=:cust_id WHERE username=:username');
		$this->db->bind('username',   $data['username']);
		$this->db->bind('password',   $password);
		$this->db->bind('nama',       $data['nama']);
		$this->db->bind('userlevel',  $data['typeuser']);
		$this->db->bind('department', $data['department']);
		$this->db->bind('jabatan',    $data['jabatan']);
		$this->db->bind('reffid',     $data['reffid']);
		$this->db->bind('cust_id',     $data['customer']);
		$this->db->execute();

		return $this->db->rowCount();
	}
}