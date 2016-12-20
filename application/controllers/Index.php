<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Index extends CI_Controller {



	function __construct(){

	parent::__construct();


	}

	

	public function index()

	{
		$data['title']  = "HomePage";
		$this->load->view('seller/index',$data);


	}

	//end function

	public function join()

	{
		$data['title']  = "Apply Job";
		$this->load->view('seller/join',$data);


	}

	//end function

	public function about()

	{
		$data['title']  = "About";
		$this->load->view('seller/about',$data);


	}

	//end function

	public function register()

	{
		$data['title']  = "Register";

		$this->load->view('seller/register',$data);

	}

	//end function

	public function sendEmail()

	{
		$array = $this->input->post();
		$this->load->library('email');
			$this->email->set_mailtype("html");
            $this->email->from($array['email']);
            $this->email->to("malsharhan@servue.ae,marzouq@servue.ae");
            //$this->email->cc("yasirahmed1909@gmail.com");
            $this->email->subject('Servue - Contact Email');
			
			$message = "<b>".$array['name']."<b><br>";	
			$message .= "<p>".$array['message']."</p><br>";			
            $this->email->message($message);
            $this->email->send();
	redirect(URL."index/contact");	

	}

	//end function

	public function contact()

	{
		$data['title']  = "Contact";

		$this->load->view('seller/contact',$data);

	}

	//end function



	public function regCompanyDetails()

	{
		$data['title']  = "Company Details";

		if($this->input->post('fName')){
			$this->session->set_userdata('fName',$this->input->post('fName'));
			$this->session->set_userdata('lName',$this->input->post('lName'));
			$this->session->set_userdata('email',$this->input->post('email'));
			$this->session->set_userdata('password',$this->input->post('password'));

			$this->form_validation->set_rules('fName', 'fName', "trim|required");
			$this->form_validation->set_rules('lName', 'lName', "trim|required");
			$this->form_validation->set_rules('email', 'email', "trim|required");
			$this->form_validation->set_rules('password', 'password', 'trim|required');
				if($this->form_validation->run() == TRUE){
					$data['services'] = $this->seller_model->getServices();
					$this->load->view('seller/regCompanyDetails',$data);	
				}else{
					$this->session->set_flashdata('message', "Invalid values entered.");
					redirect(URL."index/register");
				}

		}elseif($this->session->userdata('email')){
			$data['services'] = $this->seller_model->getServices();
			$data['countries'] = $this->seller_model->getCountries();
			$this->load->view('seller/regCompanyDetails',$data);
		}else{
			redirect(URL."index/register");
		}


		/*if($this->session->userdata('email')){

			$data['services'] = $this->seller_model->getServices();

			$this->load->view('seller/regCompanyDetails',$data);	

		}else{

		$this->session->set_userdata('fName',$this->input->post('fName'));
		$this->session->set_userdata('lName',$this->input->post('lName'));
		$this->session->set_userdata('email',$this->input->post('email'));
		$this->session->set_userdata('password',$this->input->post('password'));


		$this->form_validation->set_rules('fName', 'fName', "trim|required");
		$this->form_validation->set_rules('lName', 'lName', "trim|required");
		$this->form_validation->set_rules('email', 'email', "trim|required");
		$this->form_validation->set_rules('password', 'password', 'trim|required');
			if($this->form_validation->run() == TRUE){
				$data['services'] = $this->seller_model->getServices();
				$this->load->view('seller/regCompanyDetails',$data);	
			}else{
				$this->session->set_flashdata('message', "Invalid values entered.");
				redirect(URL."index/register");
			}

		}//end if else*/

	}

	//end function



	public function submitStoreDetails()

	{

		$this->session->set_userdata('companyName',$this->input->post('companyName'));

		$this->session->set_userdata('tradeNo',$this->input->post('tradeNo'));

		$this->session->set_userdata('mobileNo',$this->input->post('mobileNo'));

		$this->session->set_userdata('phoneNo',$this->input->post('phoneNo'));

		$this->session->set_userdata('address',$this->input->post('address'));

		$this->session->set_userdata('map',$this->input->post('map'));

		$this->session->set_userdata('service',$this->input->post('service'));

		

		$this->form_validation->set_rules('companyName', 'companyName', "trim|required");

		$this->form_validation->set_rules('tradeNo', 'tradeNo', "trim|required");

		$this->form_validation->set_rules('service', 'service', "trim|required");

		

		if($this->form_validation->run() == TRUE){

			$config['upload_path']          ='assets/uploads/';
			$config['allowed_types'] = '*';
			$config['encrypt_name']        = true;
			$this->load->library('upload');
			$this->upload->initialize($config);
			if ($this->upload->do_upload('logo')){
				$fileinfo = $this->upload->data();
				$path = $config['upload_path'].$fileinfo['file_name'];
				$this->session->set_userdata('logo',$path);
			}else{
				$this->session->set_userdata('logo',"");
			}

			if ($this->upload->do_upload('documents')){
				$fileinfo = $this->upload->data();
				$path = $config['upload_path'].$fileinfo['file_name'];
				$this->session->set_userdata('documents',$path);
			}else{
				$this->session->set_userdata('documents',"");
			}
			$result = $this->seller_model->createAccount();

			if($result=='already'){

				$this->session->set_flashdata('message', $this->session->userdata('email').'/'.$this->session->userdata('tradNo').' is already registered with us.');

				redirect(URL."index/register");

			}elseif($result == 'server-error'){

				$this->session->set_flashdata('message', 'Error occured during account creation. Please try again.');

				redirect(URL."index/register");

				}

			elseif($result){
				$this->load->library('email');
				$this->email->set_mailtype("html");
	            $this->email->from("support@servue.ae", "Servue");
	            $this->email->to($this->session->userdata("email"));
	            //$this->email->cc("yasirahmed1909@gmail.com");
	            $this->email->subject('Company Registeration Received');
				
				$content=read_file('application/views/email-templates/registrationReceived.html');
				$content = str_replace("{WEBSITEURL}",URL2."assets/imgs/logo.png",$content);
				//$content = str_replace("{ASSETS}",assets,$content);
				$content = str_replace("{NAME}",$this->session->userdata("fName")." ".$this->session->userdata("lName"),$content);		
	            $this->email->message($content);
	            $this->email->send();

				redirect(URL."index/thanks");

			}

			

		}else{

			$this->session->set_flashdata('message', "Invalid values entered.");

			redirect(URL."index/regCompanyDetails/");

		}

	}

	//end function





	public function thanks()

	{
		$data['title']  = "Thanks";

		$array_items = array('fName','lName', 'email','password','companyName','tradeNo','mobileNo','phoneNo','address','map','service');

		$this->session->unset_userdata($array_items);

		$this->load->view('seller/thanks');

	}

	//end function

}

//end controller