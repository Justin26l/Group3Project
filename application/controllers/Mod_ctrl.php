<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mod_ctrl extends CI_Controller
{

	public function login(){
		$x=$this->input->get('x',1);
		$this->load->view('head',['title'=>'login']);
		$this->load->view('login',["x"=>$x]);
	}

	public function loginverify(){
		$post = $this->input->post(NULL,TRUE);
		$this->load->model("Admin_model");
		$valid_admin = $this->Admin_model->read(['username'=>$post['username'],'password'=>$post['password']]);
		if($valid_admin){
			$this->load->library('session');
			$this->session->set_userdata('mod',['admin_id'=>intval($valid_admin[0]['admin_id'])]);
			header('Location: '.base_url('dashboard'));
		}else{
			header('Location: '.base_url('login?x=Unvalid User.'));
		}
	
	}

	public function dashboard(){
		$this->load->library('session');
		if($this->session->has_userdata('mod')){
			$this->load->model("Admin_model");

			$session = $this->session->userdata('mod');
			$admin = $this->Admin_model->read(['admin_id'=>$session['admin_id']])[0];
			// print_r($admin);exit;
			$this->load->view('head',['title'=>'dashboard']);
			$this->load->view('dashboard',['admin'=>$admin]);
		}else{
			header('Location: '.base_url('login?x=Session Expired.'));
		}
	}

	public function logout(){
		$this->load->library('session');
		if($this->session->has_userdata('mod')){
			$this->session->unset_userdata('mod');
			header('Location: '.base_url('login'));
		}else{
			header('Location: '.base_url('login'));
		}
	}
}
