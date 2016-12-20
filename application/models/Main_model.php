<?php class Main_model extends CI_Model {

	public function __construct() {
        parent::__construct();
    }//end function

   public function createAccount($array) {
	   //verify email is already registered with this account.
	   $query = $this->db->query("select id from `investers` where email='".$this->db->escape_str($array['email'])."'");
		if ($query->num_rows()>0) { 
			//email already registered with us.
			return 'already';
		} else { 
			//else create account for the new user
			$dateTime = date("Y-m-d H:i:s");
			$code = $this->db->escape_str(createRandomString());
			$this->db->set('fname', $this->db->escape_str($array['fname']));
			$this->db->set('lname', $this->db->escape_str($array['lname']));
			$this->db->set('email', $this->db->escape_str($array['email']));
			$this->db->set('password', md5($this->db->escape_str($array['password'])));
			$this->db->set('datetime', $dateTime);
			$this->db->set('status', 0);
			$this->db->set('activationCode', $code);
			$this->db->set('thumb', '');
			if($this->db->insert('investers')){
				return $code;
				}else{
					return 'server-error';
					}
		}
   }//end function



   public function validate(){

        // grab user input
        $email = $this->db->escape_str($this->input->post('email'));
        $password = $this->db->escape_str($this->input->post('password'));
        $password=md5($password);
        // Prep the query
        $this->db->where('email', $email);
        $this->db->where('password', $password);
		$this->db->where('status', "1");
        
        // Run the query
        $query = $this->db->get('investers');
		//print_r($this->db->last_query($query)); die;
        // Let's check if there are any results

        if($query->num_rows() == 1)
        {
            // If there is a user, then create session data
            $row = $query->row();
            $this->session->set_userdata(objectToArray($row));
			$this->session->set_userdata('Invester',true);
            return true;
        }
        // If the previous process did not validate
        // then return false.
        return false;
    }//end function	

	public function activate($code){

	$code = $this->db->escape_str($code);
	$this->db->query("update `users` set status='1',activationCode='Activated' where activationCode='$code'");
		$afftectedRows = $this->db->affected_rows();
		return $afftectedRows;
	}//end function

	public function generatePassword($email){

	$email = $this->db->escape_str($email);
	$password = $this->db->escape_str(createRandomString());

	// Prep the query
    $this->db->where('email', $email);        
    // Run the query
    $query = $this->db->get('users');
	 if($query->num_rows() == 1)
     {
		 // If there is a user, then create session data
         $this->db->query("update `users` set password='".md5($password)."' where email='$email'");
		 $afftectedRows = $this->db->affected_rows();
		 if($afftectedRows == 1){
			 return $password;
			 }else{
			 	return false;
			 }
        }
		return false;
	}//end function
	
	function getInvesters(){
	if($this->session->userdata('id')){
	$where = " where id<>'".$this->session->userdata('id')."' ";	
	}else{
		$where = '';
		}
	$users = $this->db->query("select * from investers $where order by id desc limit 12");
	if ($users->num_rows()>0) {
	$data = $users->result();
	}else{
		$data = false;
		}
	return $data;
	}//end function

	function getReports(){
	$reportsLocal = $this->db->query("select * from reports where type = 'Local' order by id desc  limit 7");
	if ($reportsLocal->num_rows()>0) {
	foreach($reportsLocal->result() as $row){
	$data['local'][] = $row;
	}
	}else{
		$data['local'] = false;
		}
	$reportsInternational = $this->db->query("select * from reports where type = 'International' order by id desc  limit 7");
	if ($reportsInternational->num_rows()>0) {
	foreach($reportsInternational->result() as $row){
	$data['international'][] = $row;
	}
	}else{
		$data['international'] = false;
		}
	return $data;
	}//end function

	function getGallery(){
	$users = $this->db->query("select * from gallery order by id desc limit 7");
	if ($users->num_rows()>0) {
	$data = $users->result();
	}else{
		$data = false;
		}
	return $data;
	}//end function
	
	function getInvesterProfile(){
	$users = $this->db->query("select * from investers where id=".$this->session->userdata('id'));
	if ($users->num_rows()>0) {
	$data = $users->row();
	}else{
		$data = false;
		}
	return $data;
	}//end function
	
	function updateInvesterInfo($data){
	$dob = $data['year'].'-'.$data['month'].'-'.$data['day'];
	if($data['password']=='123456789'){
		$password='';
	}else{
		$password = ", password ='".md5($data['password'])."' ";
		}

	$query = $this->db->query("update investers set fname = '{$data['fname']}' , lname = '{$data['lname']}' , gender = '{$data['gender']}' , city = '{$data['city']}' , country = '{$data['country']}', dob = '$dob' $password where id = '{$data['id']}'");
	return true;

	}//end function
	
	function updateInvesterDp($data){
	$invester = $this->db->query("select * from investers where id = {$data['investerId']}");
	if ($invester->num_rows()>0) {
	$investerArray = $invester->row();
	if($investerArray->thumb!=''){
	unlink($investerArray->thumb);
	}
	}
	$query = $this->db->query("update investers set thumb = '{$data['thumb']}' where id = '{$data['investerId']}'");
	return true;

	}//end function
	
	
	function updateBlogDp($data){
	$invester = $this->db->query("select * from blogs where id = {$data['blogId']}");
	if ($invester->num_rows()>0) {
	$investerArray = $invester->row();
	if($investerArray->thumb!=''){
	unlink($investerArray->thumb);
	}
	}
	$query = $this->db->query("update blogs set image = '{$data['image']}' where id = '{$data['blogId']}'");
	return true;

	}//end function
	
	
	function getBlogData(){
	$blogs = $this->db->query("select blogs.*,investers.fname,investers.lname from blogs,investers where blogs.invester_id = investers.id");
	
	if ($blogs->num_rows()>0) {
		
		foreach($blogs->result() as $row){
			
		$blogscommentcount = $this->db->query("select count(id) as count_comments from comments where blog_id = '".$row->id."'");
		$data[] = array('row'=>$row,'comments'=>$blogscommentcount->row());
		}
	}else{
		$data = false;
		}
	return $data;
	}//end function
	
	
	function getlatestBlogData(){
	$blogs = $this->db->query("select blogs.*,investers.fname,investers.lname from blogs,investers where blogs.invester_id = investers.id order by blogs.id DESC limit 1");
	if ($blogs->num_rows()>0) {
		foreach($blogs->result() as $row){
		//$data[] = $row;
		
		$blogscommentcount = $this->db->query("select count(id) as count_comments from comments where blog_id = '".$row->id."'");
		$data[] = array('row'=>$row,'comments'=>$blogscommentcount->row());
		
		}
	}else{
		$data = false;
		}
	return $data;
	}//end function
	
	function getBlogDetail($id){
	$blogs = $this->db->query("select blogs.*,investers.fname,investers.lname from blogs,investers where blogs.invester_id = investers.id AND blogs.id = $id");
	if ($blogs->num_rows()>0) {
		foreach($blogs->result() as $row){
		$data[] = $row;
		}
	}else{
		$data = false;
		}
	return $data;
	}//end function
	
	function getBlogComments($id){
	$blogs = $this->db->query("select comments.*,investers.fname,investers.lname,investers.thumb from comments,investers where comments.invester_id = investers.id AND comments.blog_id = $id");
	if ($blogs->num_rows()>0) {
		foreach($blogs->result() as $row){
		$data[] = $row;
		}
	}else{
		$data = false;
		}
	return $data;
	}//end function
	
	function enterBlogData($data){

			$dateTime = date("Y-m-d H:i:s");
			$user_id = $this->session->userdata('id');
			$this->db->set('title', $this->db->escape_str($data['post']['title']));
			$this->db->set('detail', $this->db->escape_str($data['post']['detail']));
			$this->db->set('image', $this->db->escape_str($data['path']));
			$this->db->set('time_stamp', $dateTime);
			$this->db->set('invester_id', $user_id);
			

			if($this->db->insert('blogs')){
				return 'success';
				}else{
					return 'server-error';
					}
	
   }//end funtion
   
   function enterBlogComment($data){

			$dateTime = date("Y-m-d H:i:s");
			$user_id = $this->session->userdata('id');
			$this->db->set('comment_detail', $this->db->escape_str($data['comment']));
			$this->db->set('invester_id', $user_id);
			$this->db->set('blog_id', $this->db->escape_str($data['blog_id']));
			$this->db->set('time_stamp', $dateTime);
			
			

			if($this->db->insert('comments')){
				return $data['blog_id'];
				}else{
					return 'server-error';
					}
	
   }//end funtion
   
   function enterChatPublic($message){
		$data = array('sender' => $this->session->userdata('id') , 'message' => $message , 'chatType' => 'public' );
		$this->db->insert('chat',$data);
		return true;
	}//end funtion
	
	function loadChatPublic(){
	$publicChat = $this->db->query("select chat.*,investers.fname,investers.lname from chat,investers where chatType='public' and investers.id=chat.sender");
	if ($publicChat->num_rows()>0) {
		foreach($publicChat->result() as $row){
		$data[] = $row;
		}
	}else{
		$data = false;
		}
	return $data;
	}//end funtion
	
	function enterChatPersonal($data){
		$insert = array('chatId' => $data['chatId'],'sender' => $this->session->userdata('id') , 'message' => $data['message'] , 'chatType' => 'personal','f1'=>$data['f1'],'f2'=>$data['f2'] );
		$this->db->insert('chat',$insert);
		$this->db->query("update chat set {$data['statusUpdate']}='1' where chatId='{$data['chatId']}'");
		return true;
	}//end funtion
	
	function enterAttachmentPersonal($data){
		$insert = array('chatId' => $data['chatId'],'sender' => $this->session->userdata('id') , 'attachment' => $data['attachment'] , 'chatType' => 'personal','f1'=>$data['f1'],'f2'=>$data['f2'] );
		$this->db->insert('chat',$insert);
		$this->db->query("update chat set {$data['statusUpdate']}='1' where chatId='{$data['chatId']}'");
		return true;
	}//end funtion
	
	function getConversations(){
	$id = $this->session->userdata('id');
	$conversations = $this->db->query("select chat.chatId from chat,investers where chatType='personal' and investers.id=chat.sender and (chatId like '%pchat{$id}' or chatId like '{$id}pchat%') group by chatId");
	if ($conversations->num_rows()>0) {
		foreach($conversations->result() as $row){
		$chatId = explode('pchat',$row->chatId);
		if($chatId[0]==$id){
			$data[] = $chatId[1];
			}else{
				$data[] = $chatId[0];
				}
		}
		
		$list = $this->db->query("select id,fname,lname from investers where id IN(".implode(',',$data).")");
		return $list->result();
	}else{
		$data = false;
		return $data;
		}
	}//end function
	
	function getChatPersonal($id){
	if($id<$this->session->userdata('id')){
		$chatId = "{$id}pchat{$this->session->userdata('id')}";
	}else{
		$chatId = "{$this->session->userdata('id')}pchat{$id}";
		}
	$chatPersonal = $this->db->query("select chat.*,investers.fname,investers.lname from chat,investers where chatType='personal' and investers.id=chat.sender and chat.chatId='$chatId'");
	if ($chatPersonal->num_rows()>0) {
		foreach($chatPersonal->result() as $row){
		$data[] = $row;
		}
		return $data;
	}else{
		$data = false;
		return $data;
		}
	}//end function
	
	function getAllChatPersonal($in){
	$size = sizeof($in);
	$id = $this->session->userdata('id');
	$array = array();
	for($i=0; $i<$size; $i++){
		if($in[$i]<$id){
			$array[] = "'{$in[$i]}pchat{$id}'";
		}else{
			$array[] = "'{$id}pchat{$in[$i]}'";
			}
		}//end for loop
	$chatPersonal = $this->db->query("select chat.*,investers.fname,investers.lname from chat,investers where chatType='personal' and investers.id=chat.sender and chat.chatId IN (".implode(',',$array).") order by chatId");
	
	if ($chatPersonal->num_rows()>0) {
		$current = false;
		foreach($chatPersonal->result() as $row){
			$params = explode('pchat',$row->chatId);
			if($params[0] == $id){
				$key = $params[1];
				}else{
					$key = $params[0];
				}
		if($key == $row->sender){
			$data[$key]['fname'] = $row->fname;
			$data[$key]['lname'] = $row->lname;
			}
		$data[$key]['messages'][] = $row;
		}//end foreach
		return $data;
	}else{
		$data = false;
		return $data;
		}	
	}//end function
	
	function chatreaded($data){
		echo "update chat set {$data['statusUpdate']}='1' where chatId='{$data['chatId']}'";
		$this->db->query("update chat set {$data['statusUpdate']}='1' where chatId='{$data['chatId']}'");
		return true;
	}//end function
	
	function getNotifications(){
	$id = $this->session->userdata('id');
	$conversations = $this->db->query("select chat.chatId from chat,investers where chatType='personal' and investers.id=chat.sender and (chatId like '%pchat{$id}' or chatId like '{$id}pchat%') group by chatId");
	if ($conversations->num_rows()>0) {
		foreach($conversations->result() as $row){
		$chatId = explode('pchat',$row->chatId);
		if($chatId[0]==$id){
			$invester = $chatId[1];
			$key = 'f1';
			}else{
				$invester = $chatId[0];
				$key = 'f2';
				}
		$messageCount = $this->db->query("select count(id) as messageCount from chat where chatId = '{$row->chatId}' and $key = '0'");
		$messageCountRow = $messageCount->row();
		$count = $messageCountRow->messageCount;
		$list = $this->db->query("select id,fname,lname from investers where id='$invester'");
		$listRow = $list->row();
		$data[] = array('invester' => $listRow, 'count' => $count);
		}//end foreach
	}else{
		$data = false;
		}
		return $data;
	}//end function
}//end model

?>