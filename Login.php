<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model("Login_model");
        $this->load->library('session');
        $this->load->library('Password');
    }

	

	public function logincheck()
	{
		$data = array();
		$this->load->view('login/check',$data);
	}

	public function logout(){
        $this->phpsession->clear();
        redirect('login/logincheck');
    }

	public function checkpassword()
	{
		$post = $this->input->post();
		$result = $this->Login_model->checklogin($post);
		if($result == 1)
		{
			redirect('Login/welcome');
		}else{
			$data["errors"][] = "Please enter correct User name and Password";
		}
		$this->load->view('login/check',$data);
	}

	public function welcome()
	{
		 $usertype = $this->phpsession->get('user_type');
        if(empty($usertype)){
            $role = $this->phpsession->get('user_role');
            redirect('Login/logincheck');
        }
         $data = array();
		$this->load->view('login/welcome',$data,$this);
	}

	public function changepassword()
	{
		$usertype = $this->phpsession->get('user_type');
        if(empty($usertype)){
            $role = $this->phpsession->get('user_role');
            redirect('Login/logincheck');
        }
		$this->load->view('login/changepassword');
	}

	public function oldpasscheck()
	{
		$oldpass = trim($_POST['vals']);
		$role  = trim($_POST['role']);
		$res  = $this->Login_model->checkoldpass($oldpass,$role);
		echo $res;
	}


	public function passwordconfirm()
	{
		//$oldpass = $_POST['oldpass'];
		$newpass = trim($_POST['newpass']);
		$role = trim($_POST['userrole']);
		$res = $this->Login_model->confirmpassword($newpass,$role);
		if($res == 1)
		{
			$data["success"][] = "Password changed succesfully.";

            $this->session->sess_destroy();
            redirect('Login/logincheck',$data);
		}

	}

}
