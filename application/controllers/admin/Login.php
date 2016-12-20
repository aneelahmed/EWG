<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	
	function __construct(){
	parent::__construct();
//	echo "<pre>";
//	print_r($data);
//	exit;
	}
	
	public function index($error = false)
	{
		if(admin()){
            redirect(URL."admin/home");
			}
		$data['error']=$error;
		$this->load->view('admin/login',$data);
	}
	//end function
	
	function verifyUser(){
		// Validate the user can login
        $result = $this->admin_model->validate();
        // Now we verify the result
        if(! $result){
            // If user did not validate, then show them login page again
            $this->index('not-found');
        }else{
            // If user did validate, 
            // Send them to members area
			redirect(URL."admin/home");
        }        
	}
	//end function
	
	function forgotPassword()
	{
		if(admin()){
            redirect(URL."home");
			}
		$data['message']='';
		$this->load->view('admin/forgotPassword.php',$data);
	}//end function
	
	function generatePassword()
	{
		$this->form_validation->set_rules('email', 'email', "trim|required");
		if($this->form_validation->run() == TRUE){
			$email=$this->input->post('email');
			$result = $this->admin_model->generatePassword($email);
			if($result == false){
				$this->index('InvalidEmail');
				}else{
					echo "password is sended to your account<br>$result</a>";
					exit;
					$message = "$result";
					$this->load->library('email');
					$this->email->from("support@oayhoay.com", "OayHoay");
					$this->email->to($_POST['email']);
					$this->email->cc("me_yasirsmart@yahoo.com");
					$this->email->subject('activation link');
					$this->email->message($message);
					$this->email->send();
					redirect(URL."home");
					$this->index('PasswordSend');
					}
		}else{
			$this->index('InvalidEmail');
			}
	}//end function
	
	function logout()
	{
        $this->session->sess_destroy();
        $this->index();
	}
	//end function
}
//end controller