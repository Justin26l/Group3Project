<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api_ctrl extends CI_Controller {

	private $TopSecret = "ヒグチアイ / 悪魔の子 (アニメスペシャルVer.) | Ai Higuchi “Akuma no Ko” Anime Special Ver. - Ai Higuchi - https://www.youtube.com/watch?v=WPl10ZrhCtk";
	
	/** db param valid */
	private $T_admin   = ["admin_id","username","password","branch","superadmin"];
	private $T_booking = ["book_id","name","person","book_branch","book_time","status","created_time","comment","created_time>","created_time<"];
	private $T_order   = ["order_id","order_branch","deliver","address","order_by","items","total","created_time","status","paid","created_time>","created_time<"];
	private $T_branch  = ["branch_id","location","branch_name","description","img","unavailable_menu","is_deleted"];
	private $T_menu    = ["menu_id","img","category","prod_name","price","description","is_deleted"];
	private $T_about   = ["logo","company_name","description","customer_service_no","bussiness_name","bussiness_no"];

	/** response value */
	private $stat = [
		"ok",
		'error'
	];
	private $err = [
		"Unvalid Path.",//url
		"Unvalid Action->",//url
		"Unvalid Param->",//get
		"Post Fields Is Empty.",//post
		"Permission Denied.",//mod session required
		"Required Higher Permission."//superadmin required
	];

	/** variable */
	private $status = "";
	private $error  = "";
	private $result = "";

	private $get  ;
	private $post ;

	/** function */
	function __construct(){
		parent::__construct();

		// catch json post & assign to native post handler
		if( isset($_SERVER["CONTENT_TYPE"]) && $_SERVER["CONTENT_TYPE"]=="application/json"){
			$_POST = json_decode(file_get_contents("php://input"),1);
		};

		$this->post = $this->input->post(NULL, TRUE);
		$this->get = $this->input->get(NULL, TRUE);
	}

	private function response(){
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Headers: *");

		header('Content-Type: application/json; charset=utf-8');
		echo json_encode([
			"status"=>$this->status,
			"error"=>$this->error,
			"result"=>$this->result,
		]);
	}

	private function ismod(){
		$this->load->library('session');
		if(!$this->session->has_userdata('mod')){
			$this->status = $this->stat[1];
			$this->error = $this->err[4];
			throw new Exception("error");
		}
	}

	private function issuper(){
		$this->load->library('session');
		$this->load->model("Admin_model");

		$this->ismod();

		$session = $this->session->userdata('mod');
		$admin = $this->Admin_model->read(['admin_id'=>$session['admin_id']])[0];

		if(! $admin['superadmin']===1){
			$this->status = $this->stat[1];
			$this->error  = $this->err[5];
			throw new Exception("error");
		};
	}

	private function validParam($checkList){
		$input='';
		if(isset($this->post['create'])){
			$input = array_keys($this->post['create']);
		}
		else if(isset($this->post['update'])){
			$input = array_keys($this->post['update']);
		}
		else if(isset($this->post['delete'])){
			$input = array_keys($this->post['delete']);
		}
		else if(isset($this->get)){
			$input = array_keys($this->get);
		}
		else{
			return;
		};

		foreach($input as $i){
			if(!in_array($i,$checkList)){
				$this->status = $this->stat[1];
				$this->error = $this->err[2].$i.'.';
				throw new Exception("error");
			};
		};
	}

	// ========== API ========== //
	// ========== API ========== //
	// ========== API ========== //

	public function api($action, $path){
		
		try {
			$this->load->library('session');
			$this->status = $this->stat[0];
			$this->error  = "";
			$this->result = "";

			// format filter
			$readlimit = 99;
			$order = null;

			if(isset($this->get[0])){
				unset($this->get[0]);
			};

			if(isset($this->get['limit'])){
				$readlimit = $this->get["limit"];
				unset($this->get["limit"]);
			};

			if(isset($this->get["order"])){
				$order = $this->get["order"];
				unset($this->get["order"]);
			}
			
			// post but empty body
			if ( $_SERVER['REQUEST_METHOD'] === 'POST' && empty($this->post)) {
				$this->error = $this->err[3];
				throw new Exception("error");
			};

			// api
			switch ($path) {
				case "booking":
					$this->load->model("Booking_model");
					$this->validParam($this->T_booking);

					if ($action == "create") {
						if(!isset($this->post['create']));
						$this->post['create']['status']="pending";
						$this->post['create']['created_time']=time();
						$this->result = $this->Booking_model->create($this->post['create']);

					} else if ($action == "read") {
						$this->result = $this->Booking_model->read($this->get, $readlimit, $order);
						
					} else if ($action == "update") {
						$this->ismod();
						if(!isset($this->post['update_where'])|| !isset($this->post['update'])){ 
							$this->error = $this->err[2]; 
							throw new Exception("error"); 
						};
						$this->result = $this->Booking_model->update($this->post['update_where'], $this->post['update']);

					} else {
						$this->error = $this->err[1].$action;
						throw new Exception("error");
					};
					break;
				
				case "order":
					$this->load->model("Order_model");
					$this->validParam($this->T_order);
					
					if ($action == "create") {
						$this->ismod();
						// ismod or app token
						// on app while pay,
						if(!isset($this->post['create'])){ 
							$this->error = $this->err[2]; 
							throw new Exception("error"); 
						};

						$this->post['create']['status']="pending";
						$this->post['create']['items'] = json_encode($this->post['create']['items']);
						$this->post['create']['created_time']=time();
						$this->result = $this->Order_model->create($this->post['create']);

					} else if ($action == "read") {
						$this->result = $this->Order_model->read($this->get, $readlimit, $order);

					} else if ($action == "update") {
						$this->ismod();
						if(!isset($this->post['update_where']) || !isset($this->post['update'])){ 
							$this->error = $this->err[2]; 
							throw new Exception("error"); 
						};
						$this->result = $this->Order_model->update($this->post['update_where'], $this->post['update']);

					} else {
						$this->error = $this->err[1].$action;
						throw new Exception("error");
					};
					break;
				
				case "menu":
					$this->load->model("Menu_model");
					$this->validParam($this->T_menu);

					if ($action == "create") {
						$this->issuper();
						if(!isset($this->post['create'])){ 
							$this->error = $this->err[2]; 
							throw new Exception("error"); 
						};
						$this->result = $this->Menu_model->create($this->post['create']);

					} else if ($action == "read") {
						$this->get["is_deleted"] = 0;
						$this->result = $this->Menu_model->read($this->get, $readlimit, $order);

					} else if ($action == "update") {
						$this->issuper();
						if(!isset($this->post['update_where']) || !isset($this->post['update'])){ 
							$this->error = $this->err[2]; 
							throw new Exception("error"); 
						};
						$this->result = $this->Menu_model->update($this->post['update_where'], $this->post['update']);

					} else if ($action == "delete") {
						$this->issuper();
						if(!isset($this->post['delete'])){ 
							$this->error = $this->err[2]; 
							throw new Exception("error"); 
						};
						$this->result = $this->Menu_model->soft_delete($this->post['delete']);

					} else {
						$this->error = $this->err[1].$action;
						throw new Exception("error");
					};
					break;
				
				case "branch":
					$this->load->model("Branch_model");
					$this->validParam($this->T_branch);

					if ($action == "create") {
						$this->issuper();
						if(!isset($this->post['create'])){ 
							$this->error = $this->err[2]; 
							throw new Exception("error"); 
						};
						$this->result = $this->Branch_model->create($this->post['create']);

					} else if ($action == "read") {
						$this->get['is_deleted']=0;
						$this->result = $this->Branch_model->read($this->get, $readlimit, $order);

					} else if ($action == "update") {
						$this->issuper();
						if(!isset($this->post['update_where']) || !isset($this->post['update'])){ 
							$this->error = $this->err[2]; 
							throw new Exception("error"); 
						};
						$this->result = $this->Branch_model->update($this->post['update_where'], $this->post['update']);

					} else if ($action == "delete") {
						$this->issuper();
						if(!isset($this->post['delete'])){ 
							$this->error = $this->err[2]; 
							throw new Exception("error"); 
						};
						$this->result = $this->Branch_model->soft_delete($this->post['delete']);

					} else {
						$this->error = $this->err[1].$action;
						throw new Exception("error");
					};
					break;
				
				case "about":
					$this->load->model("About_model");
					$this->validParam($this->T_about);

					if ($action == "read") {
						$this->result = $this->About_model->read($this->get, $readlimit, $order);

					} else if ($action == "update") {
						$this->issuper();
						if(!isset($this->post['update_where']) || !isset($this->post['update'])){ 
							$this->error = $this->err[2]; 
							throw new Exception("error"); 
						};
						$this->result = $this->About_model->update($this->post['update_where'], $this->post['update']);

					} else {
						$this->error = $this->err[1].$action;
						throw new Exception("error");
					};
					break;
				
				case "admin":
					$this->load->model("Admin_model");
					$this->validParam($this->T_admin);
					$this->issuper();

					if ($action == "create") {
						if(!isset($this->post['create'])){ 
							$this->error = $this->err[2]; 
							throw new Exception("error"); 
						};
						$this->post['create']['superadmin'] = 0;
						$this->post['create']['password'] = hash_hmac('sha256', $this->post['create']['password'], $this->TopSecret) ;
						$this->result = $this->Admin_model->create($this->post['create']);

					} else if ($action == "read") {
						$this->get['is_deleted']=0;
						$this->db->select(['admin_id','username','branch','superadmin']);
						$this->result = $this->Admin_model->read($this->get, $readlimit, $order);

					} else if ($action == "update") {
						if(!isset($this->post['update_where']) || !isset($this->post['update'])){ 
							$this->error = $this->err[2]; 
							throw new Exception("error"); 
						};
						$this->result = $this->Admin_model->update($this->post['update_where'], $this->post['update']);

					} else if ($action == "delete") {
						if(!isset($this->post['delete'])){ 
							$this->error = $this->err[2]; 
							throw new Exception("error"); 
						};
						$this->result = $this->Admin_model->soft_delete($this->post['delete']);
					} else {
						$this->error = $this->err[1].$action;
						throw new Exception("error");
					};
					break;
				
				default:
					$this->error = $this->err[0];
					break;
			};
			
			/* return */
			$this->response();
		} catch (Exception $e) {
			if($e->getMessage()=="error"){
				$this->response();
			}else{
				echo 'Message: ' . $e->getMessage();
			};
		};
	}


}
