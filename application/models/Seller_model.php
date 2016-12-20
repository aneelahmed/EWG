<?php class Seller_model extends CI_Model {

	public function __construct() {

        parent::__construct();

    }//end function

   

	public function createAccount() {

	   //verify email is already registered with this account.

	   $query = $this->db->query("select id from `seller` where email='".$this->db->escape_str($this->session->userdata('email'))."' or tradeNo = '".$this->db->escape_str($this->session->userdata('tradeNo'))."'");

		if ($query->num_rows()>0) { 

			//email already registered with us.

			return 'already';

		} else { 

			//else create account for the new user

			$dateTime = date("Y-m-d H:i:s");

			$cords = explode(',', $this->db->escape_str($this->session->userdata('map')));

			$code = $this->db->escape_str(createRandomString());

			$this->db->set('fName', $this->db->escape_str($this->session->userdata('fName')));

			$this->db->set('lName', $this->db->escape_str($this->session->userdata('lName')));

			$this->db->set('email', $this->db->escape_str($this->session->userdata('email')));

			$this->db->set('companyName', $this->db->escape_str($this->session->userdata('companyName')));

			$this->db->set('tradeNo', $this->db->escape_str($this->session->userdata('tradeNo')));
			
			$this->db->set('country', $this->db->escape_str($this->session->userdata('country')));
			
			$this->db->set('countryPhonecode', $this->db->escape_str($this->session->userdata('countryPhonecode')));
			
			$this->db->set('mobileNo', $this->db->escape_str($this->session->userdata('mobileNo')));

			$this->db->set('phoneNo', $this->db->escape_str($this->session->userdata('phoneNo')));

			$this->db->set('address', $this->db->escape_str($this->session->userdata('address')));

			$this->db->set('latitude', $cords[0]);

			$this->db->set('longitude', $cords[1]);

			$this->db->set('service', $this->db->escape_str($this->session->userdata('service')));
			
			$this->db->set('logo', $this->db->escape_str($this->session->userdata('logo')));

			$this->db->set('documents', $this->db->escape_str($this->session->userdata('documents')));

			$this->db->set('password', md5($this->db->escape_str($this->session->userdata('password'))));

			$this->db->set('datetime', $dateTime);

			$this->db->set('status', 0);

			$this->db->set('activationCode', $code);

			if($this->db->insert('seller')){

				return $code;

				}else{

					return 'server-error';

					}

		}

	}//end function



	function getServices($id = 0){



    $getServices = $this->db->query("select * from services where parent='$id' order by id asc");

	if ($getServices->num_rows()>0) {

	$data = $getServices->result();

	}else{

		$data = false;

		}

	return $data;

    

    }//end function
	
	function getCountries($id = 0){



    $getCountries = $this->db->query("select * from country");

	if ($getCountries->num_rows()>0) {

	$data = $getCountries->result();

	}else{

		$data = false;

		}

	return $data;

    

    }//end function



}//end model

?>