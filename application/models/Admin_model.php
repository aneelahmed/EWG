<?php class Admin_model extends CI_Model {

	public function __construct() {

        parent::__construct();

    }//end function

   

  



   public function validate(){

        // grab user input

        $email = $this->db->escape_str($this->input->post('email'));

        $password = $this->db->escape_str($this->input->post('password'));

        $password=md5($password);



        // Run the query

        $query = $this->db->query("select * from admin where (email = '$email' or username = '$email') and password = '$password' ");

		//print_r($this->db->last_query($query)); die;

        // Let's check if there are any results

        if($query->num_rows() == 1)

        {

            // If there is a user, then create session data

            $row = $query->row();

            $this->session->set_userdata(objectToArray($row));

			$this->session->set_userdata('admin',true);

            return true;

        }

        // If the previous process did not validate

        // then return false.

        return false;

    }//end function

	

	public function generatePassword($email){

	$email = $this->db->escape_str($email);

	$password = $this->db->escape_str(createRandomString());

	

	// Prep the query

    $this->db->where('email', $email);        

    // Run the query

    $query = $this->db->get('admin');

	 if($query->num_rows() == 1)

     {

		 // If there is a user, then create session data

         $this->db->query("update `admin` set password='".md5($password)."' where email='$email'");

		 $afftectedRows = $this->db->affected_rows();

		 if($afftectedRows == 1){

			 return $password;

			 }else{

			 	return false;

			 }

         

        }

		return false;

	}//end function


	function services(){

	$services = $this->db->query("select * from services where parent=0 order by name");

	if ($services->num_rows()>0) {

	$data = $services->result();
	foreach ($data as $row) {
		$row->service_type='parentService';
		$allServices[] = $row;
		$subServices = $this->db->query("select * from services where parent=".$row->id." order by name");
		if ($subServices->num_rows()>0) {
			$subData = $subServices->result();
			foreach ($subData as $subRow) {
				$subRow->service_type='childService';
				$allServices[]=$subRow;
			}//end foreach
		}//end if
		
	}//end foreach
	return $allServices;
	}//end if
	else{

		$data = false;

		}

	return $data;

	}//end function		

	function serviceStatus($status,$id){

	$this->db->query("update `services` set status='$status' where id='$id'");

		$afftectedRows = $this->db->affected_rows();

		return $afftectedRows;

	}//end function

	function sellers(){

	$sellers = $this->db->query("select seller.*,services.name as serviceName from seller,services where seller.service=services.id order by id");

	if ($sellers->num_rows()>0) {
	$data = $sellers->result();
	$loadData = "";
	foreach ($data as $key => $value) {
		if($value->status == 0){
		$loadData['new'][] = $value;
		}
		$loadData['all'][] = $value;
	}
	$data = $loadData;
	}//end if
	else{

		$data = false;

		}
	return $data;

	}//end function

	function sellerDetails($id){

	$sellerDetails = $this->db->query("select seller.*,services.name as serviceName 
		from seller,services 
		where seller.id='$id' AND
		seller.service=services.id 
		order by id");

	if ($sellerDetails->num_rows()>0) {

	$data = $sellerDetails->row();
	}//end if
	else{

		$data = false;

		}

	return $data;

	}//end function	

	function buyers(){

	$buyers = $this->db->query("select * from buyer order by id desc");

	if ($buyers->num_rows()>0) {

	$data = $buyers->result();
	}//end if
	else{

		$data = false;

		}

	return $data;

	}//end function	

	function getParentServices(){

	$getParentServices = $this->db->query("select * from services where parent=0 and status=1 order by id desc");

	if ($getParentServices->num_rows()>0) {

	$data = $getParentServices->result();
	}//end if
	else{

		$data = false;

		}

	return $data;

	}//end function

	function orders(){

	/*$orders = $this->db->query("select buyerorders.*,seller.companyName,buyer.fName,buyer.lName
		from buyerorders,seller,buyer
		where buyerorders.sellerId=seller.id 
		and buyerorders.buyerId=buyer.id 
		group by buyerorders.id 
		order by id desc");

	if ($orders->num_rows()>0) {

	$data = $orders->result();
	foreach ($data as $row) {
		$productDetails = $this->db->query("select image from sellerproductimages where sellerProductId =".$row->productId);

		/*$productImages = $this->db->query("select image from sellerproductimages where sellerProductId =".$row->productId);
		if ($productImages->num_rows()>0) {
			$row->images = $productImages->result();
			$loadData[] = $row;
		}else{
			$row->images = false;
			$loadData[] = $row;
		}	
		}//end foreach
		return $loadData;
	}//end if
	else{

		$data = false;

		}

	return $data;*/

	$buyerorders = $this->db->query("SELECT  *
			FROM buyerorders
			ORDER BY id desc");

		//print_r($productReviews->num_rows()); die;

		if ($buyerorders->num_rows() > 0) {

			$data = $buyerorders->result();
			foreach ($data as $row) {
				$row->sellerDetails = $this->getSellerDetailsById($row->sellerId);
				$row->buyerDetails = $this->getBuyerDetailsById($row->buyerId);
				$details = $this->db->query("SELECT count(id) as noOfServices from buyerorderdetails where buyerOrderId = '".$row->id."'");
				if($details->num_rows()>0){
					$detailsRow = $details->row();
					$row->noOfServices = $detailsRow->noOfServices;
				}else{
					$row->noOfServices = 0;
				}

				$sum = $this->db->query("SELECT sum(price) as totalPrice from buyerorderdetails where buyerorderdetails.buyerOrderId = '".$row->id."'");
				if($sum->num_rows()>0){
					$sumRow = $sum->row();
					$row->totalPrice = $sumRow->totalPrice;
				}else{
					$row->totalPrice = 0;
				}

				$serviceType = $this->db->query("SELECT categoryType from services where id = '".$row->sellerDetails->service."'");
				if($serviceType->num_rows()>0){
					$serviceTypeRow = $serviceType->row();
					$row->categoryType = $serviceTypeRow->categoryType;
				}else{
					$row->categoryType = false;
				}

				switch ($row->status) {
				case 0:
					$loadData['recent'][] = $row;
					break;
				case 1:
					$loadData['inProcess'][] = $row;
					break;
				case 2:
					$loadData['reject'][] = $row;
					break;

				case 3:
					$loadData['complete'][] = $row;
					break;
				
				default:
					$loadData['dispute'][] = $row;
					break;
			}

			}

			$data = $loadData;

		}else{

			$data = false;

		}
		/*echo "<pre>";
		print_r($data);
		exit;*/
		return $data;

	}//end function

	function orderDetails($id){

	/*$orders = $this->db->query(
		"select buyerorders.*,buyerorders.status as orderStatus,
		seller.companyName,seller.email as sellerEmail,seller.mobileNo as sellerMobileNo,seller.phoneNo as sellerPhoneNo,seller.tradeNo,seller.status as sellerStatus,seller.address as sellerAddress,
		buyer.fName as buyerFname, buyer.lName as buyerLname,buyer.email as buyerEmail,
		sellerproducts.*,sellerproducts.id as productId
		from buyerorders,seller,buyer,sellerproducts 
		where buyerorders.id=$id  
		and buyerorders.sellerId=seller.id 
		and buyerorders.buyerId=buyer.id 
		and sellerproducts.id=buyerorders.productId
		group by buyerorders.id ");

	if ($orders->num_rows()>0) {

	$row = $orders->row();
		$productImages = $this->db->query("select image from sellerproductimages where sellerProductId =".$row->productId);
		if ($productImages->num_rows()>0) {
			$row->images = $productImages->result();
		}else{
			$row->images = false;
		}		
			return $row;
	}//end if
	else{

		$data = false;

		}

	return $data;*/

	$orders = $this->db->query("select * from buyerorders where id='$id' order by id desc");
		if ($orders->num_rows() == 1) {
			$data = $orders->row();
			$data->sellerDetails = $this->getSellerDetailsById($data->sellerId);
			$data->buyerDetails = $this->getBuyerDetailsById($data->buyerId);
			$data->orderDetails = false;
			$data->messages = false;

			$orderdetails = $this->db->query("select * from buyerorderdetails where buyerOrderId='$id' order by id desc");
			if ($orderdetails->num_rows() > 0) {
				$orderDetailsData = array();
			foreach ($orderdetails->result() as $row) {
				$serviceDetails = $this->getServiceDetails($row->serviceId);
				$productDetails = $this->productDetails($row->productId);
				$productDetails->price = $row->price;
				$orderDetailsData[] = array(
					"serviceDetails"=>$serviceDetails,
					"productDetails"=>$productDetails,
					"quantity"=>$row->quantity
					);
			}

			$data->orderDetails= $orderDetailsData;
			}

			$messages = $this->db->query("select * from messages where orderId='$id' order by id desc");
			if ($messages->num_rows() > 0) {
				$messagesData = array();
			foreach ($messages->result() as $row) {
				$messagesData[] = $row;
			}
			
			$data->messages= $messagesData;
			}

		}else{
			$data = false;
		}
		/*echo "<pre>";
		print_r($data);
		exit;*/
		return $data;

	}//end function

	function getServiceById($id){

	$getServiceById = $this->db->query("select * from services where id=$id");

	if ($getServiceById->num_rows()>0) {

	$data = $getServiceById->row();
	}//end if
	else{

		$data = false;

		}

	return $data;

	}//end function

	function submitService($params){
		if($params['parent']){
			$parentRow = $this->getServiceById($params['parent']);
			$params['categoryType'] = $parentRow->categoryType;
		}
		$submitService = $this->db->query("insert into services(`name`,`parent`,`description`,`thumb`,`categoryType`)values('{$params['name']}','{$params['parent']}','{$params['description']}','{$params['thumb']}','{$params['categoryType']}')");
		return true;

	}

	function updateService($params){
		if(array_key_exists("thumb",$params)){
			$this->db->set('thumb', $params['thumb']);
		}

		if($params['parent']){
			$parentRow = $this->getServiceById($params['parent']);
			$params['categoryType'] = $parentRow->categoryType;
		}else{
			$this->db->query("update services set categoryType = '{$params['categoryType']}' where parent = '{$params['id']}'");
		}

		$this->db->set('name', $params['name']);
		$this->db->set('description', $params['description']);
		$this->db->set('parent', $params['parent']);
		$this->db->set('categoryType', $params['categoryType']);
		$this->db->where('id', $params['id']);
		$this->db->update('services');
		return true;

	}


	function products(){

	$products = $this->db->query("select sellerproducts.*,seller.companyName,services.name as serviceName
		from sellerproducts,seller,services
		where sellerproducts.sellerId=seller.id
		AND sellerproducts.serviceId = services.id
		GROUP BY sellerproducts.id
		order by sellerproducts.id desc");

	if ($products->num_rows()>0) {

	$data = $products->result();

	foreach ($data as $row) {
		$productImages = $this->db->query("select image from sellerproductimages where sellerProductId =".$row->id);
		if ($productImages->num_rows()>0) {
			$row->images = $productImages->result();
		}else{
			$row->images = false;
		}
		switch($row->status){
		    case 0:
		       $loadData['pending'][]=$row;
		        break;
		    case 1:
		        $loadData['enable'][]=$row;
		        break;
		    case 2:
		        $loadData['disable'][]=$row;
		        break;
		    default:
		        $loadData['blocked'][]=$row;
		}
		
		}//end foreach
			return $loadData;
	}//end if
	else{

		$data = false;

		}

	return $data;

	}//end function	

function productDetails($id=0){

	$productDetails = $this->db->query("select sellerproducts.*,sellerproducts.id as productId,sellerproducts.status as productStatus,seller.*,sellerproducts.id as productId,services.name as serviceName
		from sellerproducts,seller,services
		where sellerproducts.sellerId=seller.id
		AND sellerproducts.serviceId = services.id
		AND sellerproducts.id=$id
		GROUP BY sellerproducts.id
		order by sellerproducts.id desc");

	if ($productDetails->num_rows()>0) {

	$row = $productDetails->row();	
		$productImages = $this->db->query("select image from sellerproductimages where sellerProductId =".$row->productId);
		if ($productImages->num_rows()>0) {
			$row->images = $productImages->result();
		}else{
			$row->images = false;
		}					
			return $row;
	}//end if
	else{

		$data = false;

		}

	return $data;

	}//end function	

function approveProduct($id=0){

	$productDetails = $this->db->query("update sellerproducts set status=1 where id = $id");
	$data = $this->productDetails($id);
	$result = getDeviceInfo("seller",$data->sellerId);
	if($result){
		$msg = "Product approved by admin";
		$extras = array("to"=>"seller","msgType"=>"product","type"=>"approved");

		if($result->deviceType == 'iphone'){
			sendIosNofification($result->deviceToken, $msg, $extras);
		}else{
			$extras['alert'] = $msg;
			$registrationIds[] = $result->deviceToken;
			sendAndroidNofification($registrationIds, $extras);
		}
	}
	return $data;

	}//end function	

function blockProduct($id=0){

	$productDetails = $this->db->query("update sellerproducts set status=3 where id = $id");
	$data = $this->productDetails($id);
	$result = getDeviceInfo("seller",$data->sellerId);
	if($result){
		$msg = "Product rejected by admin";
		$extras = array("to"=>"seller","msgType"=>"product","type"=>"rejected");

		if($result->deviceType == 'iphone'){
			sendIosNofification($result->deviceToken, $msg, $extras);
		}else{
			$extras['alert'] = $msg;
			$registrationIds[] = $result->deviceToken;
			sendAndroidNofification($registrationIds, $extras);
		}
	}
	return $data;

	}//end function

function getSellerDetailsById($id = 0){
    $getSellerDetails = $this->db->query("select * from seller where id='".$this->db->escape_str($id)."' order by id desc");

	//print_r($this->db->last_query($getSellerDetails)); die;

	if ($getSellerDetails->num_rows()==1) {

		$row = $getSellerDetails->row();
		$row->sellerRatings = $this->getSellerRatings($row->id);
		$data = $row;
	}else{

		$data = false;
		}
	return $data;
    }//end function

function getBuyerDetailsById($id=0){

		$query = $this->db->query("select * from `buyer` where id='$id'");

		if ($query->num_rows()>0) { 

			$data = $query->row();

		} else { 

			$data = false;

		}

		return $data;

	}//end function

function getSellerRatings($id){

		$sellerRating = $this->db->query("SELECT  AVG(stars) as rating
			FROM ratings
			WHERE sellerId = $id");

		//print_r($productReviews->num_rows()); die;

		if ($sellerRating->num_rows() > 0) {

			$data = $sellerRating->row();

		}else{

			$data = false;

		}

		return $data;

	}//end function

function getServiceDetails($id = 0){



    $getServices = $this->db->query("select * from services where id='$id' order by id desc");

	if ($getServices->num_rows()>0) {

	$data = $getServices->row();

	}else{

		$data = false;

		}

	return $data;

    

    }//end function


function approveSeller($id=0){

	$sellerApprove = $this->db->query("update seller set status=1 where id = $id");
	$results = $this->getSellerDetailsById($id);
	return $results;

	}//end function

function blockSeller($id=0){

	$results = $this->getSellerDetailsById($id);

	$productDetails = $this->db->query("delete from seller where id = $id");
	return $results;

	}//end function

function activateBuyer($id=0){

	$sellerApprove = $this->db->query("update buyer set status=1 where id = $id");
	//$results = $this->getSellerDetailsById($id);
	return true;

	}//end function

function deActivateBuyer($id=0){

	$productDetails = $this->db->query("update buyer set status=0 where id = $id");
	return true;

	}//end function

function adminDashboard(){
	$data['activeBuyers'] = 0;
	$data['inActiveBuyers'] = 0;
	$data['activeSellers'] = 0;
	$data['newSellers'] = 0;
	$data['pendingProducts'] = 0;
	$data['activeProducts'] = 0;
	$data['disabledProducts'] = 0;
	$data['blockedProducts'] = 0;
	$data['newOrders'] = 0;
	$data['inProcessOrders'] = 0;
	$data['rejectedOrders'] = 0;
	$data['completeOrders'] = 0;
	$data['disputeOrders'] = 0;
	
	$queryActiveBuyers = $this->db->query("select count(id) as activeBuyers from buyer where status = 1");
	if($queryActiveBuyers->num_rows()>0){
		$row = $queryActiveBuyers->row();
		$data['activeBuyers'] = $row->activeBuyers;
	}
	
	$queryInActiveBuyers = $this->db->query("select count(id) as inActiveBuyers from buyer where status = 0");
	if($queryInActiveBuyers->num_rows()>0){
		$row = $queryInActiveBuyers->row();
		$data['inActiveBuyers'] = $row->inActiveBuyers;
	}
	
	$queryActiveSellers = $this->db->query("select count(id) as activeSellers from seller where status = 1");
	if($queryActiveSellers->num_rows()>0){
		$row = $queryActiveSellers->row();
		$data['activeSellers'] = $row->activeSellers;
	}
	
	$queryInActiveSellers = $this->db->query("select count(id) as newSellers from seller where status = 0");
	if($queryInActiveSellers->num_rows()>0){
		$row = $queryInActiveSellers->row();
		$data['newSellers'] = $row->newSellers;
	}
	
	$queryPendingProducts = $this->db->query("select count(id) as pendingProducts from sellerproducts where status = 0");
	if($queryPendingProducts->num_rows()>0){
		$row = $queryPendingProducts->row();
		$data['pendingProducts'] = $row->pendingProducts;
	}
	
	$queryActiveProducts = $this->db->query("select count(id) as activeProducts from sellerproducts where status = 1");
	if($queryActiveProducts->num_rows()>0){
		$row = $queryActiveProducts->row();
		$data['activeProducts'] = $row->activeProducts;
	}
	
	$queryDisabledProducts = $this->db->query("select count(id) as disabledProducts from sellerproducts where status = 2");
	if($queryDisabledProducts->num_rows()>0){
		$row = $queryDisabledProducts->row();
		$data['disabledProducts'] = $row->disabledProducts;
	}
	
	$queryBlockedProducts = $this->db->query("select count(id) as blockedProducts from sellerproducts where status = 3");
	if($queryBlockedProducts->num_rows()>0){
		$row = $queryBlockedProducts->row();
		$data['blockedProducts'] = $row->blockedProducts;
	}
	
	$queryNewOrders = $this->db->query("select count(id) as newOrders from buyerorders where status = 0");
	if($queryNewOrders->num_rows()>0){
		$row = $queryNewOrders->row();
		$data['newOrders'] = $row->newOrders;
	}
	
	$queryInProcessOrders = $this->db->query("select count(id) as inProcessOrders from buyerorders where status = 1");
	if($queryInProcessOrders->num_rows()>0){
		$row = $queryInProcessOrders->row();
		$data['inProcessOrders'] = $row->inProcessOrders;
	}
	
	$queryRejectedOrders = $this->db->query("select count(id) as rejectedOrders from buyerorders where status = 2");
	if($queryRejectedOrders->num_rows()>0){
		$row = $queryRejectedOrders->row();
		$data['rejectedOrders'] = $row->rejectedOrders;
	}
	
	$queryCompleteOrders = $this->db->query("select count(id) as completeOrders from buyerorders where status = 3");
	if($queryCompleteOrders->num_rows()>0){
		$row = $queryCompleteOrders->row();
		$data['completeOrders'] = $row->completeOrders;
	}
	
	$queryDisputeOrders = $this->db->query("select count(id) as disputeOrders from buyerorders where status = 4");
	if($queryDisputeOrders->num_rows()>0){
		$row = $queryDisputeOrders->row();
		$data['disputeOrders'] = $row->disputeOrders;
	}
	
	return $data;
}

}//end model

?>