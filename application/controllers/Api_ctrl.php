<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api_ctrl extends CI_Controller
{

	private function response($arr){
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($arr);
		return;
	}

	private function ismod(){
		$this->load->library('session');
		if(!$this->session->has_userdata('mod')){
			$result['error'] = "Permission Denied.";
			$this->response($result);
			return false;
		}else{
			return true;
		}
	}

	private function issuper(){
		$this->load->library('session');
		if($this->ismod()){
			$this->load->model("Admin_model");
			$session = $this->session->userdata('mod');
			$admin = $this->Admin_model->read(['admin_id'=>$session['admin_id']])[0];
			if(! $admin['superadmin']===1){
				$result['error'] = "Permission Denied.";
				$this->response($result);
				return;
			}else{
				return true;
			}
		}
	}

	public function api($method, $path){
		try {
			$this->load->library('session');

			$result = [
				"status" => "error",
				"error" => "",
				"result" => "",
			];

			// catch json post
			if( isset($_SERVER["CONTENT_TYPE"]) && $_SERVER["CONTENT_TYPE"]=="application/json"){
				$_POST = json_decode(file_get_contents("php://input"),1);
			};
			
			// catch all input
			$post = $this->input->post(NULL, TRUE);
			$get = $this->input->get(NULL, TRUE);

			// format if client ask for limit
			$readlimit = 99;
			if(isset($get['limit'])){
				$readlimit = $get["limit"];
				unset($get["limit"]);
			};

			// prepair error code , not use now
			if (empty($post)) {
				$result['error'] = "Post Fields Is Empty.";
			};

			// api
			switch ($path) {
				case "booking":
					$this->load->model("Booking_model");
					if ($method == "create") {
						$post['created_time']=time();
						$result['status'] = "ok";
						$result['result'] = $this->Booking_model->create($post['create']);
						$this->response($result);
					} else if ($method == "read") {
						// if(!$this->ismod()){return;};
						$result['status'] = "ok";
						$result['error'] = "";
						$result['result'] = $this->Booking_model->read($get, $readlimit);
						$this->response($result);
					} else if ($method == "update") {
						if(!$this->ismod()){return;};
						$result['status'] = "ok";
						$result['result'] = $this->Booking_model->update($post['update_where'], $post['update']);
						$this->response($result);
					// } else if ($method == "delete") {
					// 	$result['status'] = "ok";
					// 	$result['result'] = $this->Booking_model->soft_delete($post['delete']);
					// 	$this->response($result);
					} else {
						$result['error'] = "Invalid Method.";
						$this->response($result);
					};
					break;
				case "menu":
					$this->load->model("Menu_model");
					if ($method == "create") {
						if(!$this->issuper()){return;};
						$result['status'] = "ok";
						$result['result'] = $this->Menu_model->create($post['create']);
						$this->response($result);
					} else if ($method == "read") {
						if(!isset($get["is_deleted"])){$get["is_deleted"] = 0;}
						$result['status'] = "ok";
						$result['error'] = "";
						$result['result'] = $this->Menu_model->read($get, $readlimit);
						$this->response($result);
					} else if ($method == "update") {
						if(!$this->issuper()){return;};
						$result['status'] = "ok";
						$result['result'] = $this->Menu_model->update($post['update_where'], $post['update']);
						$this->response($result);
					} else if ($method == "delete") {
						if(!$this->issuper()){return;};
						$result['status'] = "ok";
						$result['result'] = $this->Menu_model->soft_delete($post['delete']);
						$this->response($result);
					} else {
						$result['error'] = "Invalid Method.";
						$this->response($result);
					};
					break;
				case "branch":
					$this->load->model("Branch_model");
					if ($method == "create") {
						if(!$this->issuper()){return;};
						$result['status'] = "ok";
						$result['result'] = $this->Branch_model->create($post['create']);
						$this->response($result);
					} else if ($method == "read") {
						if(!isset($get["is_deleted"])){$get["is_deleted"] = 0;}
						$result['status'] = "ok";
						$result['error'] = "";
						$result['result'] = $this->Branch_model->read($get, $readlimit);
						$this->response($result);
					} else if ($method == "update") {
						if(!$this->issuper()){return;};
						$result['status'] = "ok";
						$result['result'] = $this->Branch_model->update($post['update_where'], $post['update']);
						$this->response($result);
					} else if ($method == "delete") {
						if(!$this->issuper()){return;};
						$result['status'] = "ok";
						$result['result'] = $this->Branch_model->soft_delete($post['delete']);
						$this->response($result);
					} else {
						$result['error'] = "Invalid Method.";
						$this->response($result);
					};
					break;
				case "about":
					$this->load->model("About_model");
					// if ($method == "create") {
					// 	$result['status'] = "ok";
					// 	$result['result'] = $this->About_model->create($post['create']);
					// 	$this->response($result);
					// } else 
					if ($method == "read") {
						$result['status'] = "ok";
						$result['error'] = "";
						$result['result'] = $this->About_model->read($get, $readlimit);
						$this->response($result);
					} else if ($method == "update") {
						if(!$this->issuper()){return;};
						$result['status'] = "ok";
						$result['result'] = $this->About_model->update($post['update_where'], $post['update']);
						$this->response($result);
					// } else if ($method == "delete") {
					// 	$result['status'] = "ok";
					// 	$result['result'] = $this->About_model->soft_delete($post['delete']);
					// 	$this->response($result);
					} else {
						$result['error'] = "Invalid Method.";
						$this->response($result);
					};
					break;
				case "admin":
					$this->load->model("Admin_model");
					if(!$this->issuper()){return;};
					
					if ($method == "create") {
						$result['status'] = "ok";
						$result['result'] = $this->Admin_model->create($post['create']);
						$this->response($result);
					} else if ($method == "read") {
						$result['status'] = "ok";
						$result['error'] = "";
						$result['result'] = $this->Admin_model->read($get, $readlimit);
						$this->response($result);
					} else if ($method == "update") {
						$result['status'] = "ok";
						$result['result'] = $this->Admin_model->update($post['update_where'], $post['update']);
						$this->response($result);
					} else if ($method == "delete") {
						$result['status'] = "ok";
						$result['result'] = $this->Admin_model->soft_delete($post['delete']);
						$this->response($result);
					} else {
						$result['error'] = "Invalid Method.";
						$this->response($result);
					};
					break;
				default:
					$result['error'] = "unvalid path.";
					$this->response($result);
					break;
			}
		} catch (Exception $e) {
			echo 'Message: ' . $e; //->getMessage();
		}
	}
}
