<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api_ctrl extends CI_Controller {

	private $T_admin   = ["admin_id","username","password","branch_id","superadmin"];
	private $T_booking = ["book_id","name","person","book_branch","book_time","status","created_time","comment","created_time>","created_time<"];
	private $T_order   = ["order_id","order_branch","deliver","address","order_by","items","total","created_time","status","created_time>","created_time<"];
	private $T_branch  = ["branch_id","location","branch_name","description","images","is_deleted"];
	private $T_menu    = ["menu_id","img","category","prod_name","price","description","is_deleted"];
	private $T_about   = ["logo","company_name","description","customer_service_no","bussiness_name","bussiness_no"];

	private $stat = [
		"ok",
		'error'
	];

	private $err = [
		"Unvalid Path.",//url
		"Unvalid Action-",//url
		"Unvalid Param-",//get
		"Post Fields Is Empty.",//post
		"Permission Denied.",//mod session required
		"Required Higher Permission."//superadmin required
	];

	private function response($status,$error,$result){
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Headers: *");

		header('Content-Type: application/json; charset=utf-8');
		echo json_encode([
			"status"=>$status,
			"error"=>$error,
			"result"=>$result,
		]);
	}

	// ========== Verify ========== //

	private function ismod(){
		$this->load->library('session');
		if(!$this->session->has_userdata('mod')){
			$this->response($this->stat[1],$this->err[4],"");
			return false;
		} else {
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
				$this->response($this->stat[1],$this->err[5],"");
				return false;
			} else {
				return true;
			}
		}
	}

	private function validParam($input,$checkList){
		$input = array_keys($input);

		foreach($input as $i){
			if(!in_array($i,$checkList)){
				$status = $this->stat[1];
				$error = $this->err[2].$i.'.';
				$this->response($status,$error,"");
				return false;
			};
		};
		return true;
	}

	// ========== API ========== //
	// ========== API ========== //
	// ========== API ========== //

	public function api($action, $path){

		try {
			$this->load->library('session');
			$status = $this->stat[0];
			$error  = "";
			$result = "";

			// catch json post & assign to native post handler
			if( isset($_SERVER["CONTENT_TYPE"]) && $_SERVER["CONTENT_TYPE"]=="application/json"){
				$_POST = json_decode(file_get_contents("php://input"),1);
			};
			
			// catch all input
			$post = $this->input->post(NULL, TRUE);
			$get = $this->input->get(NULL, TRUE);

			// format filter
			$readlimit = 99;
			$order = null;
			if(isset($get[0])){unset($get[0]);};
			if(isset($get['limit'])){
				$readlimit = $get["limit"];
				unset($get["limit"]);
			};
			if(isset($get["order"])){
				$order = $get["order"];
				unset($get["order"]);
			}
			
			// post but empty body
			if ( $_SERVER['REQUEST_METHOD'] === 'POST' && empty($post)) {
				$error = $this->err[3];
			};

			// api
			switch ($path) {
				case "booking":
					$this->load->model("Booking_model");
					if ($action == "create") {
						$post['create']['status']="pending";
						$post['create']['created_time']=time();

						if(isset($post['create'])){
							if ($this->validParam($post['create'],$this->T_booking)){
								$result = $this->Booking_model->create($post['create']);
								$this->response($status,$error,$result);
								return;
							}else {
								return;
							};
						} else {
							$error  = $this->err[2];
							$this->response($status,$error,$result);
							return;
						};
						$this->response($status,$error,$result);
						return;
					} else if ($action == "read") {

						if ($this->validParam($get,$this->T_booking)){
							$result = $this->Booking_model->read($get, $readlimit, $order);
							$this->response($status,$error,$result);
							return;
						}else {
							return;
						};
					} else if ($action == "update") {
						if(!$this->ismod()){return;};
						$result = $this->Booking_model->update($post['update_where'], $post['update']);
						$this->response($status,$error,$result);
						return;
					} else {
						$error = $this->err[1].$action;
						$this->response($status,$this->err[1].$action,$result);
					};
					break;
				case "order":
					$this->load->model("Order_model");
					if ($action == "create") {
						$post['create']['status']="pending";
						$post['create']['created_time']=time();
						if(isset($post['create'])){
							if ($this->validParam($post['create'],$this->T_order)){
								$post['create']['items'] = json_encode($post['create']['items']);
								$result = $this->Order_model->create($post['create']);
								$this->response($status,$error,$result);
								return;
							};
						} else {
							$error  = $this->err[2];
							$this->response($status,$error,$result);
							return;
						};
					} else if ($action == "read") {
						if ($this->validParam($get,$this->T_order)){
							$result = $this->Order_model->read($get, $readlimit, $order);
							$this->response($status,$error,$result);
							return;
						};
					} else if ($action == "update") {
						if(!$this->ismod()){return;};
						$result = $this->Order_model->update($post['update_where'], $post['update']);
						$this->response($status,$error,$result);
						return;
					} else {
						$error = $this->err[1].$action;
						$this->response($status,$this->err[1].$action,$result);
					};
					break;
				case "menu":
					$this->load->model("Menu_model");
					if ($action == "create") {
						if(!$this->issuper()){return;};
						$result = $this->Menu_model->create($post['create']);
						$this->response($status,$error,$result);
						return;
					} else if ($action == "read") {
						if(!isset($get["is_deleted"])){$get["is_deleted"] = 0;}
						if($this->validParam($get,$this->T_menu)){
							$result = $this->Menu_model->read($get, $readlimit, $order);
							$this->response($status,$error,$result);
							return;
						}else {
							return;
						};
					} else if ($action == "update") {
						if(!$this->issuper()){return;};
						$result = $this->Menu_model->update($post['update_where'], $post['update']);
						$this->response($status,$error,$result);
						return;
					} else if ($action == "delete") {
						if(!$this->issuper()){return;};
						$result = $this->Menu_model->soft_delete($post['delete']);
						$this->response($status,$error,$result);
						return;
					} else {
						$error = $this->err[1].$action;
						$this->response($status,$error,$result);
						return;
					};
					break;
				case "branch":
					$this->load->model("Branch_model");
					if ($action == "create") {
						if(!$this->issuper()){return;};
						$result = $this->Branch_model->create($post['create']);
						$this->response($status,$error,$result);
						return;
					} else if ($action == "read") {
						if(!isset($get["is_deleted"])){$get["is_deleted"] = 0;}
						if($this->validParam($get,$this->T_branch)){
							$result = $this->Branch_model->read($get, $readlimit, $order);
							$this->response($status,$error,$result);
							return;
						}else {
							return;
						};
					} else if ($action == "update") {
						if(!$this->issuper()){return;};
						$result = $this->Branch_model->update($post['update_where'], $post['update']);
						$this->response($status,$error,$result);
						return;
					} else if ($action == "delete") {
						if(!$this->issuper()){return;};
						$result = $this->Branch_model->soft_delete($post['delete']);
						$this->response($status,$error,$result);
						return;
					} else {
						$error = $this->err[1].$action;
						$this->response($status,$error,$result);
						return;
					};
					break;
				case "about":
					$this->load->model("About_model");
					// if ($action == "create") {
					// 	$result = $this->About_model->create($post['create']);
					// 	$this->response($status,$error,$result);
					return;
					// } else 
					if ($action == "read") {
						if($this->validParam($get,$this->T_about)){
							$result = $this->About_model->read($get, $readlimit, $order);
							$this->response($status,$error,$result);
							return;
						}else {
							return;
						};
					} else if ($action == "update") {
						if(!$this->issuper()){return;};
						$result = $this->About_model->update($post['update_where'], $post['update']);
						$this->response($status,$error,$result);
						return;
					// } else if ($action == "delete") {
					// 	$result = $this->About_model->soft_delete($post['delete']);
					// 	$this->response($status,$error,$result);
					return;
					} else {
						$error = $this->err[1].$action;
						$this->response($status,$error,$result);
						return;
					};
					break;
				case "admin":
					$this->load->model("Admin_model");
					if(!$this->issuper()){return false;};
					if ($action == "create") {
						$result = $this->Admin_model->create($post['create']);
						$this->response($status,$error,$result);
						return;
					} else if ($action == "read") {
						if($this->validParam($get,$this->T_admin)){
							$result = $this->Admin_model->read($get, $readlimit, $order);
							$this->response($status,$error,$result);
							return;
						}else {
							return;
						};
					} else if ($action == "update") {
						$result = $this->Admin_model->update($post['update_where'], $post['update']);
						$this->response($status,$error,$result);
						return;
					} else if ($action == "delete") {
						$result = $this->Admin_model->soft_delete($post['delete']);
						$this->response($status,$error,$result);
						return;
					} else {
						$error = $this->err[1].$action;
						$this->response($status,$error,$result);
						return;
					};
					break;
				default:
					$error = $this->err[0];
					$this->response($status,$error,$result);
					return;
					break;
			}
		} catch (Exception $e) {
			echo 'Message: ' . $e->getMessage();
		}
	}
}

// echo $this->db->last_query();
