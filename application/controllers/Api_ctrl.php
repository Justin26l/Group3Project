<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api_ctrl extends CI_Controller
{

	private function response($arr){
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($arr);
		return;
	}

	public function api($method, $path){
		try {
			$result = [
				"status" => "error",
				"error" => "",
				"result" => "",
			];

			$post = $this->input->post(NULL, TRUE);
			$get = $this->input->get(NULL, TRUE);

			$readlimit = 99;
			if(isset($get['limit'])){
				$readlimit = $get["limit"];
				unset($get["limit"]);
			}


			if (empty($post)) {
				$result['error'] = "Post Fields Is Empty.";
			}
			// api
			switch ($path) {
				case "branch":
					$this->load->model("Branch_model");
					if ($method == "create") {
						$result['status'] = "ok";
						$result['result'] = $this->Branch_model->create(json_decode($post['create'],1));
						$this->response($result);
					} else if ($method == "read") {
						if(!isset($get["is_deleted"])){$get["is_deleted"] = 0;}
						$result['status'] = "ok";
						$result['error'] = "";
						$result['result'] = $this->Branch_model->read($get, $readlimit);
						$this->response($result);
					} else if ($method == "update") {
						$result['status'] = "ok";
						$result['result'] = $this->Branch_model->update(json_decode($post['update_where'],1), json_decode($post['update'],1));
						$this->response($result);
					} else if ($method == "delete") {
						$result['status'] = "ok";
						$result['result'] = $this->Branch_model->soft_delete(json_decode($post['delete'],1));
						$this->response($result);
					} else {
						$result['error'] = "Invalid Method.";
						$this->response($result);
					}
					break;
				case "menu":
					$this->load->model("Menu_model");
					if ($method == "create") {
						$result['status'] = "ok";
						$result['result'] = $this->Menu_model->create(json_decode($post['create'],1));
						$this->response($result);
					} else if ($method == "read") {
						if(!isset($get["is_deleted"])){$get["is_deleted"] = 0;}
						$result['status'] = "ok";
						$result['error'] = "";
						$result['result'] = $this->Menu_model->read($get, $readlimit);
						$this->response($result);
					} else if ($method == "update") {
						$result['status'] = "ok";
						$result['result'] = $this->Menu_model->update(json_decode($post['update_where'],1), json_decode($post['update'],1));
						$this->response($result);
					} else if ($method == "delete") {
						$result['status'] = "ok";
						$result['result'] = $this->Menu_model->soft_delete(json_decode($post['delete'],1));
						$this->response($result);
					} else {
						$result['error'] = "Invalid Method.";
						$this->response($result);
					}
					break;
				case "booking":
					$this->load->model("Booking_model");
					if ($method == "create") {
						$result['status'] = "ok";
						$result['result'] = $this->Booking_model->create(json_decode($post['create'],1));
						$this->response($result);
					} else if ($method == "read") {
						$result['status'] = "ok";
						$result['error'] = "";
						$result['result'] = $this->Booking_model->read($get, $readlimit);
						$this->response($result);
					} else if ($method == "update") {
						$result['status'] = "ok";
						$result['result'] = $this->Booking_model->update(json_decode($post['update_where'],1), json_decode($post['update'],1));
						$this->response($result);
					// } else if ($method == "delete") {
					// 	$result['status'] = "ok";
					// 	$result['result'] = $this->Booking_model->soft_delete(json_decode($post['delete'],1));
					// 	$this->response($result);
					} else {
						$result['error'] = "Invalid Method.";
						$this->response($result);
					}
					break;
				case "about":
					$this->load->model("About_model");
					// if ($method == "create") {
					// 	$result['status'] = "ok";
					// 	$result['result'] = $this->About_model->create(json_decode($post['create'],1));
					// 	$this->response($result);
					// } else 
					if ($method == "read") {
						$result['status'] = "ok";
						$result['error'] = "";
						$result['result'] = $this->About_model->read($get, $readlimit);
						$this->response($result);
					} else if ($method == "update") {
						$result['status'] = "ok";
						$result['result'] = $this->About_model->update(json_decode($post['update_where'],1), json_decode($post['update'],1));
						$this->response($result);
					// } else if ($method == "delete") {
					// 	$result['status'] = "ok";
					// 	$result['result'] = $this->About_model->soft_delete(json_decode($post['delete'],1));
					// 	$this->response($result);
					} else {
						$result['error'] = "Invalid Method.";
						$this->response($result);
					}
					break;
				case "admin":
					$this->load->model("Admin_model");
					if ($method == "create") {
						$result['status'] = "ok";
						$result['result'] = $this->Admin_model->create(json_decode($post['create'],1));
						$this->response($result);
					} else if ($method == "read") {
						$result['status'] = "ok";
						$result['error'] = "";
						$result['result'] = $this->Admin_model->read($get, $readlimit);
						$this->response($result);
					} else if ($method == "update") {
						$result['status'] = "ok";
						$result['result'] = $this->Admin_model->update(json_decode($post['update_where'],1), json_decode($post['update'],1));
						$this->response($result);
					// } else if ($method == "delete") {
					// 	$result['status'] = "ok";
					// 	$result['result'] = $this->Admin_model->soft_delete(json_decode($post['delete'],1));
					// 	$this->response($result);
					} else {
						$result['error'] = "Invalid Method.";
						$this->response($result);
					}
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
