<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller {

function __construct(){
parent::__construct();
if(!admin()){
redirect(URL."admin/Login");
}
//	echo "<pre>";
//	print_r($data);
//	exit;
}



public function index()

{
$data['results'] = $this->admin_model->adminDashboard();
$this->load->view('admin/index',$data);

}

//end function



public function services()

{

$data['results'] = $this->admin_model->services();
$this->load->view('admin/services',$data);

}

//end function

public function serviceAdd()

{
$data['results'] = $this->admin_model->getParentServices();
$this->load->view('admin/serviceAdd',$data);

}

//end function

public function serviceSubmit()

{
$post = $this->input->post();


//icon upload start
$config['upload_path']          ='assets/uploads/';
$config['allowed_types'] = '*';
$config['encrypt_name']        = true;
$this->load->library('upload');
$this->upload->initialize($config);
if ( ! $this->upload->do_upload('image')){
	$error = array('error' => $this->upload->display_errors());
	echo "<pre>";
	print_r($error);
	exit;
}else{
		$fileinfo = $this->upload->data();
		$path = $config['upload_path'].$fileinfo['file_name'];
		$params = array('name'=>$post['name'],'parent'=>$post['parent'],'description'=>$post['description'],'categoryType'=>$post['categoryType'],'thumb'=>$path);
		$result = $this->admin_model->submitService($params);
		if($result){
		$this->session->set_flashdata('message', 'Service Added Successfully');
		redirect(URL."admin/home/services");
		}else{
		$this->session->set_flashdata('message', 'Error Occured during service add.');
		redirect(URL."admin/home/serviceAdd");
	}
}	
//icon upload end
}

//end function

public function serviceEdit($id=0)

{
$id	= intval($id);
$data['service'] = $this->admin_model->getServiceById($id);
$data['results'] = $this->admin_model->getParentServices();
if($data['service']!==false){
	$this->load->view('admin/serviceEdit',$data);
}else{
	$this->session->set_flashdata('message', 'Please Select valid Service.');
	redirect(URL."admin/home/services");
}

}

//end functio

public function serviceUpdate()

{
$post = $this->input->post();
if($_FILES['image']['name']!=''){
	$config['upload_path']          ='assets/uploads/';
	$config['allowed_types'] = '*';
	$config['encrypt_name']        = true;
	$this->load->library('upload');
	$this->upload->initialize($config);
	if ( ! $this->upload->do_upload('image')){
	$error = array('error' => $this->upload->display_errors());
	echo "<pre>";
	print_r($error);
	exit;
	}else{
		$fileinfo = $this->upload->data();
		$path = $config['upload_path'].$fileinfo['file_name'];
		$params = array('id'=>$post['id'],'name'=>$post['name'],'parent'=>$post['parent'],'description'=>$post['description'],'thumb'=>$path,'categoryType'=>$post['categoryType']);
		$result = $this->admin_model->updateService($params);
		if($result){
		$this->session->set_flashdata('message', 'Service Edited Successfully');
		redirect(URL."admin/home/services");
		}else{
		$this->session->set_flashdata('message', 'Error Occured during service update.');
		redirect(URL."admin/home/serviceEdit/".$post['id']);
		}//end if else $resutl
	}
}else{
	$params = array('id'=>$post['id'],'name'=>$post['name'],'parent'=>$post['parent'],'description'=>$post['description'],'categoryType'=>$post['categoryType']);
	$result = $this->admin_model->updateService($params);
	if($result){
		$this->session->set_flashdata('message', 'Service Edited Successfully');
		redirect(URL."admin/home/services");
		}else{
		$this->session->set_flashdata('message', 'Error Occured during service update.');
		redirect(URL."admin/home/serviceEdit/".$post['id']);
	}//end if else $resutl

}

}

//end function

public function serviceStatus($status=0,$id=0){

$status = intval($status);

$id = intval($id);

$result = $this->admin_model-> serviceStatus($status,$id);

if($result){

$this->session->set_flashdata('message', 'Service Status Successfully Updated.');

}else{

	$this->session->set_flashdata('message', 'Something went wrong please try again.');

	}

redirect(URL."admin/home/services");

}//end function



public function sellers()

{

$data['results'] = $this->admin_model->sellers();
$this->load->view('admin/sellers',$data);

}

public function sellerDetails($id=0)

{
$id = intval($id);
$data['results'] = $this->admin_model->sellerDetails($id);
$this->load->view('admin/sellerDetails',$data);

}

//end functionn

public function buyers()

{

$data['results'] = $this->admin_model->buyers();
$this->load->view('admin/buyers',$data);

}

//end functionn

public function orders()

{
$data['results'] = $this->admin_model->orders();
$this->load->view('admin/orders',$data);
}

//end functionn

public function orderDetails($id=0)

{
$id= intval($id);
$data['results'] = $this->admin_model->orderDetails($id);
$this->load->view('admin/orderDetails',$data);
}

//end functionn

public function settings()

{

echo "Under Process";
}

//end functionn

public function products()

{

$data['results'] = $this->admin_model->products();
$this->load->view('admin/products',$data);
}

//end functionn

public function productDetails($id=0)

{
$id=intval($id);
$data['results'] = $this->admin_model->productDetails($id);
$this->load->view('admin/productDetails',$data);
}
//end functionn

public function approveProduct($id=0,$page=false)

{
$id=intval($id);
$data['results'] = $this->admin_model->approveProduct($id);
if($page){
	redirect(URL."admin/home/productDetails/".$id);
}
redirect(URL."admin/home/products");
}
//end functionn

public function approveBlockedProduct($id=0)

{
$id=intval($id);
$data['results'] = $this->admin_model->approveProduct($id);
redirect(URL."admin/home/products");
}
//end functionn

public function blockProduct(){
	$id = $this->input->post('id');
	$result = $this->admin_model->blockProduct($id);

	$this->load->library('email');
			$this->email->set_mailtype("html");
            $this->email->from("support@servue.ae", "Servue");
            $this->email->to($result->email);
            $this->email->cc("yasirahmed1909@gmail.com");
            $this->email->subject('Product Blocked');
			
			$content=read_file('application/views/email-templates/productBlocked.html');
			$content = str_replace("{WEBSITEURL}",URL2."assets/imgs/logo.png",$content);
			//$content = str_replace("{ASSETS}",assets,$content);
			$content = str_replace("{PRODUCTNAME}",$result->title,$content);
			$content = str_replace("{PRODUCTDESCRIPTION}",$result->description,$content);
			$content = str_replace("{SERVICENAME}",$result->serviceName,$content);
			$content = str_replace("{REASON}",$this->input->post('reason'),$content);
			$content = str_replace("{SITEURL}",URL2."assets/images/",$content);				
            $this->email->message($content);
            $this->email->send();
	redirect(URL."admin/home/productDetails/".$id);	
}//end function

public function approveSeller($id=0)

{
$id=intval($id);
$result = $this->admin_model->approveSeller($id);
// echo "<pre>";
// print_r($result);
$this->load->library('email');
			$this->email->set_mailtype("html");
            $this->email->from("support@servue.ae", "Servue");
            $this->email->to($result->email);
            $this->email->cc("yasirahmed1909@gmail.com");
            $this->email->subject('Servue Account Approval');
			
			$content=read_file('application/views/email-templates/sellerAprove.html');
			$content = str_replace("{WEBSITEURL}",URL2."assets/imgs/logo.png",$content);
			$content = str_replace("{FNAME}",$result->fName,$content);
			$content = str_replace("{LNAME}",$result->lName,$content);
			$content = str_replace("{LOGINCODE}",$result->activationCode,$content);
			$content = str_replace("{COMPANYNAME}",$result->companyName,$content);
			$content = str_replace("{SITEURL}",URL2."assets/images/",$content);		
            $this->email->message($content);
            $this->email->send();
redirect(URL."admin/home/sellers");
}
//end functionn

public function blockSeller(){
	$id = $this->input->post('id');
	$result = $this->admin_model->blockSeller($id);

	$this->load->library('email');
			$this->email->set_mailtype("html");
            $this->email->from("support@servue.ae", "Servue");
            $this->email->to($result->email);
            $this->email->cc("yasirahmed1909@gmail.com");
            $this->email->subject('Servue Account Rejected');
			
			$content=read_file('application/views/email-templates/sellerBlock.html');
			$content = str_replace("{WEBSITEURL}",URL2."assets/imgs/logo.png",$content);
			$content = str_replace("{FNAME}",$result->fName,$content);
			$content = str_replace("{LNAME}",$result->lName,$content);
			$content = str_replace("{REASON}",$this->input->post('reason'),$content);
			$content = str_replace("{COMPANYNAME}",$result->companyName,$content);
			$content = str_replace("{SITEURL}",URL2."assets/images/",$content);			
            $this->email->message($content);
            $this->email->send();
	redirect(URL."admin/home/sellers/".$id);	
}//end function


public function activateBuyer($id=0)

{
$id=intval($id);
$result = $this->admin_model->activateBuyer($id);
// echo "<pre>";
// print_r($result);
/*$this->load->library('email');
			$this->email->set_mailtype("html");
            $this->email->from("support@servue.ae", "Servue");
            $this->email->to($result->email);
            $this->email->cc("yasirahmed1909@gmail.com");
            $this->email->subject('Servue Account Approval');
			
			$content=read_file('application/views/email-templates/sellerAprove.html');
			$content = str_replace("{WEBSITEURL}",URL2."assets/imgs/logo.png",$content);
			$content = str_replace("{FNAME}",$result->fName,$content);
			$content = str_replace("{LNAME}",$result->lName,$content);
			$content = str_replace("{LOGINCODE}",$result->activationCode,$content);
			$content = str_replace("{COMPANYNAME}",$result->companyName,$content);		
            $this->email->message($content);
            $this->email->send();*/
redirect(URL."admin/home/buyers");
}
//end functionn

public function deActivateBuyer($id = 0){
	$result = $this->admin_model->deActivateBuyer($id);

	/*$this->load->library('email');
			$this->email->set_mailtype("html");
            $this->email->from("support@servue.ae", "Servue");
            $this->email->to($result->email);
            $this->email->cc("yasirahmed1909@gmail.com");
            $this->email->subject('Servue Account Approval');
			
			$content=read_file('application/views/email-templates/sellerBlock.html');
			$content = str_replace("{WEBSITEURL}",URL2."assets/imgs/logo.png",$content);
			$content = str_replace("{FNAME}",$result->fName,$content);
			$content = str_replace("{LNAME}",$result->lName,$content);
			$content = str_replace("{REASON}",$this->input->post('reason'),$content);
			$content = str_replace("{COMPANYNAME}",$result->companyName,$content);		
            $this->email->message($content);
            $this->email->send();*/
	redirect(URL."admin/home/buyers/".$id);	
}//end function

}
//end controller