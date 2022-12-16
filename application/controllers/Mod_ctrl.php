<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mod_ctrl extends CI_Controller
{

	private $TopSecret = "ヒグチアイ / 悪魔の子 (アニメスペシャルVer.) | Ai Higuchi “Akuma no Ko” Anime Special Ver. - Ai Higuchi - https://www.youtube.com/watch?v=WPl10ZrhCtk";
	
	public function login(){
		$x=$this->input->get('x',1);
		$this->load->view('head',['title'=>'login']);
		$this->load->view('login',["x"=>$x]);
	}

	public function loginverify(){
		$post = $this->input->post(NULL,TRUE);
		$hash_pass = hash_hmac('sha256', $post['password'], $this->TopSecret);
		$this->load->model("Admin_model");
		$valid_admin = $this->Admin_model->read(['username'=>$post['username'],'password'=>$hash_pass]);
		if($valid_admin){
			$this->load->library('session');
			$this->session->set_userdata('mod',['admin_id'=>intval($valid_admin[0]['admin_id']),'branch'=>intval($valid_admin[0]['branch'])]);
			header('Location: '.base_url('dashboard'));
		}else{
			header('Location: '.base_url('?x=Unvalid User.'));
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
			header('Location: '.base_url('?x=Session Expired.'));
		}
	}

	public function element(){
		$this->load->library('session');
		$path = $this->input->get('path',TRUE);
		if($this->session->has_userdata('mod')){
			$this->load->model("Admin_model");
			$session = $this->session->userdata('mod');
			$admin = $this->Admin_model->read(['admin_id'=>$session['admin_id']])[0];
			$dat = ['admin'=>$admin];

			switch($path){
				case"booking":
					$this->load->view('element/booking',['admin'=>$admin]);
					break;
				case"order":
					$this->load->view('element/order',['admin'=>$admin]);
					break;
				case"setting":
					$this->load->view('element/setting',['admin'=>$admin]);
					break;
				case"menu":
					$this->load->view('element/menu',['admin'=>$admin]);
					break;
				case"branch":
					$this->load->view('element/branch',['admin'=>$admin]);
					break;
				case"about":
					$this->load->model("About_model");
					$about=$this->About_model->readOne();
					$this->load->view('element/about',['admin'=>$admin,"about"=>$about]);
					break;
				case"admin":
					$this->load->view('element/admin',['admin'=>$admin]);
					break;
				default:
					echo "404 Not Found.";
					break;
			}
		}else{
			echo "Invalid Permission";
			return;
		}
	}

	public function logout(){
		$this->load->library('session');
		if($this->session->has_userdata('mod')){
			$this->session->unset_userdata('mod');
			header('Location: '.base_url());
		}else{
			header('Location: '.base_url());
		}
	}
}
