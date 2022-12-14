<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Img_ctrl extends CI_Controller
{
	public function imgcatch($subdir){
		$target_dir = "asset/img/uploads/";
		$target_file = $target_dir . $subdir . '/' . basename($_FILES["file"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

		$resp=[
			'result'=>'',
			'path'=>''
		];

		// Check if image file is a actual image or fake image
		if(isset($_FILES["file"])) {
		    $check = getimagesize($_FILES["file"]["tmp_name"]);
		    if($check !== false) {
		        $uploadOk = 1;
		    } else {
		        $resp['result'].= "File is not an image.";
		        $uploadOk = 0;
		    }
		}

		// Check file path is exist
		if($subdir !='branch' && $subdir !='menu' && $subdir !='about' ){
			$resp['result'].= "Invalid Path -> ".$subdir;
			$uploadOk = 0;
		}

		// Check if file already exists
		if (file_exists($target_file)) {
			$resp['result'].= "Sorry, file already exists.";
			$resp['path'] = $target_file;
			$uploadOk = 0;
		}

		// Check file size
		if ($_FILES["file"]["size"] > 1048576) {
		    $resp['result'].= "Sorry, your file is too large.";
		    $uploadOk = 0;
		}

		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
		    $resp['result'].= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		    $uploadOk = 0;
		}

		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		    $resp['result'].= " your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
		    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
		        $resp['result'] .= "The file ". htmlspecialchars( basename( $_FILES["file"]["name"])). " has been uploaded.";
				$resp['path'] = $target_file;
			} else {
		        $resp['result'] .= "Sorry, there was an error uploading your file.";
		    }
		}

		echo json_encode($resp);
	}
}
