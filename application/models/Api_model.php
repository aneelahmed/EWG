<?php class Api_model extends CI_Model {



	public function __construct() {



        parent::__construct();



        //print_r($this->db->last_query($query)); die;



    }//end function

public function create_groups($data){
	$this->db->insert("groups",$data);	

	return array("response"=>"Groups Created Successfully","error"=>"false","group_id"=>$this->db->insert_id());

}

public function view_virtual_tour_by_id($id){

	$query=$this->db->query("select * from virtual_tour where virtual_tour_id=".$id);	

	return $query->result_array();
}
public function view_virtual_tour(){

	$query=$this->db->query("select * from virtual_tour");	

	return $query->result_array();
}
public function view_groups_member($data){

$query = $this->db->query("select *, '0' as admin from users where users.user_id in(


select friends_id from groups_joinned where groups_id=".$data['groups_id'].") UNION (select *, '1' as admin from users where users.user_id =".$data['user_id'].")

order by admin desc");
if($query->num_rows()>0){
$res=$query->result_array();

}
else{
$res=array();
}
return array("members_info"=> $res);
}

public function delete_group($data){

$this->db->query("delete from groups where groups_id=".$data['groups_id']);
return array("response"=>"Group Deleted Successfully","error"=>"true");
}
public function leave_group($data){


$this->db->query("delete from groups_joinned where groups_id=".$data['groups_id'].' and friends_id='.$data['user_id']);
return array("response"=>"Group Leaves Successfully","error"=>"true");

}

public function view_create_groups($data){
$query=$this->db->query("select *  from groups where groups_user_id=".$data['user_id']);
if($query->num_rows()>0){
$res=$query->result_array();

}
else{

	$res=array();
}


$query1=$this->db->query("select * from groups_joinned,groups where friends_id=".$data['user_id']." and groups.groups_id=groups_joinned.groups_id");

	if($query1->num_rows()>0){
$res1=$query1->result_array();

}
else{

	$res1=array();
}

return array("created_groups"=>$res,"joinned_groups"=>$res1);

}


public function joinned_groups($data){

$this->db->insert("groups_joinned",$data);	

return array("response"=>"Groups Created Successfully","error"=>"false","group_id"=>$this->db->insert_id());


}
public function update_device_id($data){
	$sql=$this->db->query("update users set deviceid='".$data['deviceid']."' where user_id=".$data['user_id']);
	
	return array("response"=>"Updated Successfully");

}

public function view_user_steps_prof($data){

$query=$this->db->query("select * from users_steps where user_id=".$data['user_id']);
$res=$query->result_array();
	if($query->num_rows()>0){

		$r=array("user_steps"=>$res); 
	}
		else{

		$r=array("user_steps"=>array());
	}	

return $r;

}
public function get_leader_board($arr){
	$query=$this->db->query("(SELECT * from ( select user_id, activity_type, count(activity_type) as total_activity_count ,SUM(activity_distance)as total_distance,Sum(footsteps) as total_footsteps from users_activity WHERE user_id in( select users.user_id from users WHERE users.user_id in( SELECT friends.reciever_id FROM `friends` WHERE sender_id=".$arr['user_id']." and friends.friend_status=2)OR users.user_id in(SELECT friends.sender_id FROM `friends` WHERe friends.reciever_id=".$arr['user_id']." and friends.friend_status=2) order by username asc) or user_id=".$arr['user_id']." GROUP by activity_type, user_id)as leather_table,users where users.user_id=leather_table.user_id order by total_distance desc)UNION(SELECT * from ( select user_id,'0' as activity_type, count(*) as total_activity_count ,SUM(distance)as total_distance,Sum(footsteps) as total_footsteps from users_steps WHERE user_id in( select users.user_id from users WHERE users.user_id in( SELECT friends.reciever_id FROM `friends` WHERE sender_id=".$arr['user_id']." and friends.friend_status=2)OR users.user_id in(SELECT friends.sender_id FROM `friends` WHERe friends.reciever_id=".$arr['user_id']." and friends.friend_status=2) order by username asc) or user_id=".$arr['user_id']." GROUP by activity_type, user_id)as leather_table,users where users.user_id=leather_table.user_id order by total_distance desc)");
	//$sql="(SELECT * from ( select user_id, activity_type, count(activity_type) as total_activity_count ,SUM(activity_distance)as total_distance,Sum(footsteps) as total_footsteps from users_activity WHERE user_id in( select users.user_id from users WHERE users.user_id in( SELECT friends.reciever_id FROM `friends` WHERE sender_id=".$arr['user_id']." and friends.friend_status=2)OR users.user_id in(SELECT friends.sender_id FROM `friends` WHERe friends.reciever_id=".$arr['user_id']." and friends.friend_status=2) order by username asc) or user_id=".$arr['user_id']." GROUP by activity_type, user_id)as leather_table,users where users.user_id=leather_table.user_id order by total_distance desc)UNION(SELECT * from ( select user_id,'0' as activity_type, count(*) as total_activity_count ,SUM(distance)as total_distance,Sum(footsteps) as total_footsteps from users_steps WHERE user_id in( select users.user_id from users WHERE users.user_id in( SELECT friends.reciever_id FROM `friends` WHERE sender_id=".$arr['user_id']." and friends.friend_status=2)OR users.user_id in(SELECT friends.sender_id FROM `friends` WHERe friends.reciever_id=".$arr['user_id']." and friends.friend_status=2) order by username asc) or user_id=".$arr['user_id']." GROUP by activity_type, user_id)as leather_table,users where users.user_id=leather_table.user_id order by total_distance desc)";
	///echo $sql.'<br/>'; 
	$res=$query->result_array();
	$mergeres=array();

	for($i=0;$i<count($res);$i++){
		$x=0;
		for ($j=0;$j<count($mergeres);$j++){
	
			if(intval($mergeres[$j]['activity_type'])==intval($res[$i]['activity_type'])&&intval($mergeres[$j]['user_id'])==intval
		($res[$i]['user_id']))
		{

			$temp=$mergeres[$j];
			$temps=$res[$i];
			$temp['total_activity_count']=strval(intval($temp['total_activity_count'])+intval($temps['total_activity_count']));
			$temp['total_distance']=strval(floatval($temp['total_distance'])+floatval($temps['total_distance']));
			$temp['total_footsteps']=strval(intval($temp['total_footsteps'])+intval($temps['total_footsteps']));
			$mergeres[$j]=$temp;
				$x=1;
				break;
		}
		
		}
		
		
		if($x==0){
		
		array_push($mergeres, $res[$i]);
		}
		
	}

	if($query->num_rows()>0){

		$r=array("leader_board"=>$mergeres); 
	}
		else{

		$r=array("leader_board"=>array());
	}	

return $r;
}

public function add_selected_plans($arr){

	$this->db->insert('users_plans',$arr);
	return array("response"=>"Plans Added Successful");
}

public function update_user_steps($arr){
$query=$this->db->query("select * from users_steps where steps_date like'%".$arr['steps_date']."%' and user_id=".$arr['user_id']);
if($query->num_rows()>0){

	$this->db->query("update users_steps set footsteps=".$arr['footsteps'].",distance=".$arr['distance']."  where user_id=".$arr['user_id']." and steps_date like'%".$arr['steps_date']."%'");
	return array("response"=>"Updated Successfully","success"=>"1");
}
else{
	$this->db->insert("users_steps",$arr);
	return array("response"=>"Inserted Successfully","success"=>"1");
}
}

public function view_user_steps($arr){
$query=$this->db->query("select * from users_steps where user_id=".$arr['user_id']." order by created_date desc LIMIT 7");
$res=$query->result_array();

if($query->num_rows()>0){

$r=array("user_steps"=>$res); 
}
else{

	$r=array("user_steps"=>array());
}

return $r;
}

public function view_virtual_tours($arr){
	
$result=$this->db->query("select plans.*, '1' as selected from users_plans,plans where user_id=".$arr." and plans.plans_id=users_plans.plans_id Union (SELECT *,'0' as selected from plans WHERE plans_id not in (select plans.plans_id from users_plans,plans where user_id=".$arr." and plans.plans_id=users_plans.plans_id) LIMIT 1)");

if($result->num_rows()>0){

	$res=array("virtual_tour"=>$result->result_array());
}
else{

	$res=array("virtual_tour"=>array());
}

return $res;
}


	public function logout_device($arr=array()){

		$data=array('deviceid'=>$arr['deviceid']);
		$this->db->where('user_id',$arr['user_id']);
		$updatequery=$this->db->update('users',$data);
		if($updatequery==1)
			$updatequery='success';
		else
			$updatequery='server-error';
		return $updatequery;
	}
	public function get_plans($arr){
$result=$this->db->query("select * from(select * ,'1'as selected from plans WHERE plans_id in ( select users_plans.plans_id from users_plans where user_id='".$arr['user_id']."') Union select * ,'0'as selected from plans WHERE plans_id not in ( select users_plans.plans_id from users_plans where user_id=".$arr['user_id']."))as us order by plans_id");
;if($result->num_rows()>0){

	$res=array("plans"=>$result->result_array());
}
else{

	$res=array("plans"=>array());
}
return $res;

	}

	public function update_profile($arr=array()){
	if($arr['profilepic']=="")
	{
	$data=array(
				'birth'=>$arr['birth'], 
				'weight'=>$arr['weight'], 
				'gender'=>$arr['gender'], 
				'language'=>$arr['language'], 
				'height'=>$arr['height']);
	}
	else{
	$data=array('profilepic'=>$arr['profilepic'], 
				'birth'=>$arr['birth'], 
				'weight'=>$arr['weight'], 
				'gender'=>$arr['gender'], 
				'language'=>$arr['language'], 
				'height'=>$arr['height']);


	}
	$this->db->where('user_id',$arr['user_id']);
	$this->db->update('users',$data);
	$query=$this->db->query("select * from `users` where user_id=".$arr['user_id']);		
	return $query->result_array(); 

	}	

	public function get_activity($arr){
		$result=$this->db->query("select * from users_activity where user_id=".$arr['user_id']." order by activity_created_date desc");
		if($result->num_rows()>0)
			$res=$result->result_array();
		else
			$res=array();
		return array("activities"=>$res);

	}


	public function register($array) {

	   //verify email is already registered with this account.
	
	   if($array["flag"]=="")
	   $query = $this->db->query("select user_id from `users` where email='".$array['email']."'");
	   else
	
	   $query = $this->db->query("select * from `users` where flag='".$array['flag']."' and socialid =".$array['socialid']);

		if ($query->num_rows()>0 ) { 

			//email already registered with us.
			if($array["flag"]!="")
            {
                $row=$query->result_array();
                $query1=$this->db->query("select activity_type, count(activity_type) as total_activity_count ,SUM(activity_distance)as total_distance,Sum(footsteps) as total_footsteps from users_activity where user_id=".$row[0]['user_id']." group by activity_type ");
                if($query1->num_rows()>0){
                return array('users'=>$query->result_array(),'activity'=>$query1->result_array());
                 }
                else{
                return array('users'=>$query->result_array(),'activity'=>array());
                 }
            
            }
			else
				return 'already';


		} else { 

			//else create account for the new user

			$dateTime = date("Y-m-d H:i:s");

			$this->db->set('email', $array['email']);

			$this->db->set('username', $array['username']);

			$this->db->set('password', md5($array['password']));

			$this->db->set('flag', $array['flag']);
			
			$this->db->set('profilepic',$array['profilepic']);

			$this->db->set('socialid', $array['socialid']);
			
			$this->db->set('datetime', $dateTime);

			if($this->db->insert('users')){

				$insert_id = $this->db->insert_id();

				$getuser = $this->db->query("Select * from users where user_id='".$insert_id."'");
			
			if ($getuser->num_rows()==1) {

				$row = $getuser->result_array();
                $query1=$this->db->query("select activity_type, count(activity_type) as total_activity_count ,SUM(activity_distance)as total_distance,Sum(footsteps) as total_footsteps from users_activity where user_id=".$row[0]['user_id']." group by activity_type ");
                if($query1->num_rows()>0){
                return array('users'=>$row[0],'activity'=>$query1->result_array());
                 }
				else{
					//echo json_encode(array('users'=>$getuser->result_array(),'activtiy'=>array()));
                return array('users'=>$getuser->result_array(),'activity'=>array());
                 }
			
			//return $data;



	}



				}else{



					return 'server-error';



					}



		}



	}//end function

	function forgot_password($arr = array()){
    $getuser = $this->db->query("select * from users where email='".$arr['email']."'");
	if ($getuser->num_rows()==1) {
		
		$password=uniqid();
		$updatequery = $this->db->query("Update users set password = '".md5($password)."' where email = '".$arr['email']."'");
		$row = $getuser->result_array();
        $data = $password;
		}else{
		$data = "invalid";
		}
		return $data;

	}


 public function get_friend_profile($arr){
  $getuser = $this->db->query("select * from users where user_id=".$arr['user_id']);

	if ($getuser->num_rows()==1) {
		$row = $getuser->result_array();
   		$query1=$this->db->query("select activity_type , Sum(total_activity_count) as total_activity_count ,SUM(total_distance)as total_distance,Sum(total_footsteps) as total_footsteps  from (
select activity_type, count(activity_type) as total_activity_count ,SUM(activity_distance)as total_distance,Sum(footsteps) as total_footsteps from users_activity where user_id=".$arr['user_id']." group by activity_type
Union select '0' as activity_type, count(*) as total_activity_count ,SUM(distance)as total_distance,Sum(footsteps) as total_footsteps from users_steps where user_id=".$arr['user_id']." group by activity_type) as sef 
group by activity_type");
             

        $data =	array('users'=>$row,'activity'=>$query1->result_array());
	}else{
		$data =array();
		}
	return array("friend_profile"=>$data);

  }

    function getuser($arr = array()){
	
    $getuser = $this->db->query("select * from users where email='".$arr['email']."' and password = '".md5($arr['password'])."'");

	if ($getuser->num_rows()==1) {
		$updatequery = $this->db->query("Update users set deviceid = '".$arr['deviceid']."' where email = '".$arr['email']."'");
		$row = $getuser->result_array();
   		$query1=$this->db->query("select activity_type, count(activity_type) as total_activity_count ,SUM(activity_distance)as total_distance,Sum(footsteps) as total_footsteps from users_activity where user_id=".$row[0]['user_id']." group by activity_type ");
             

        $data =	array('users'=>$row,'activity'=>$query1->result_array());
	}else{
		$data = "invalid";
		}
	return $data;

    }//end function



   

//end model


public function friends_request1($arr)
{
	
	$query=$this->db->query("select * from friends where (sender_id=".$arr['sender_id']." and reciever_id=".$arr['reciever_id'].' )or('."sender_id=".$arr['sender_id']." and reciever_id=".$arr['reciever_id'].')');
//	echo "select * from friends where (sender_id=".$arr['sender_id']." and reciever_id=".$arr['reciever_id'].' )or('."sender_id=".$arr['sender_id']." and reciever_id=".$arr['reciever_id'].')';
if($query->num_rows()>0){
$this->db->query("update friends set friend_status=".$arr['friend_status']." where sender_id=".$arr['sender_id']." and reciever_id=".$arr['reciever_id']);
//echo "update friends set friend_status=".$arr['friend_status']." where sender_id=".$arr['sender_id']." and reciever_id=".$arr['reciever_id'];
//echo "Updated";
}else{
	echo "Added";
	$this->db->insert('friends',$arr);

}

	$quer=$this->db->query('select * from users where user_id='.$arr['reciever_id']);
	$quer2=$this->db->query('select * from users where user_id='.$arr['sender_id']);
	$qu=$quer->result_array();
	$qu2=$quer2->result_array();
return array($qu[0],$qu2[0]);
}

public function view_all_request($arr){
	$query=$this->db->query("select * from users,friends WHERE friends.sender_id=users.user_id and friends.reciever_id=".$arr['user_id']);
	if($query->num_rows()>0){
		$result=$query->result_array();

	}
	else{
		$result=array();
	}
	return array("all_request"=>$result);
}

public function update_request($arr){
	$query=$this->db->query("update friends set friend_status=".$arr["friend_status"]." where reviever_id=".$arr["reviever_id"]);
	$quer=$this->db->query('select * from users where user_id='.$arr['reciever_id']);
	$quer2=$this->db->query('select * from users where user_id='.$arr['sender_id']);
	$qu=$quer->result_array();
	$qu2=$quer2->result_array();
return array($qu[0],$qu2[0]);
}

public function view_people($arr){
$query=$this->db->query("(select *,'0' as friend_status from users WHERE users.user_id not in( SELECT friends.reciever_id FROM `friends` WHERe sender_id=".$arr["user_id"]." and friends.friend_status>=1)and users.user_id not in(SELECT friends.sender_id FROM `friends` WHERe friends.reciever_id=".$arr["user_id"]." and friends.friend_status>=1)and users.user_id <>".$arr["user_id"]." order by username asc) UNION (select users.*,friends.friend_status from users,friends where users.user_id<>".$arr["user_id"]." and (friends.reciever_id=users.user_id)and friends.friend_status<>2)");
if($query->num_rows()>0){
$result=$query->result_array();

}
else{
	$result=array();
}

return $result;
}


public function view_friends($arr)
{

$query=$this->db->query("select *from users WHERE users.user_id in( SELECT friends.reciever_id FROM `friends` WHERe sender_id=".$arr['user_id']." and friends.friend_status=2)OR users.user_id in(SELECT friends.sender_id FROM `friends` WHERe friends.reciever_id=".$arr['user_id']." and friends.friend_status=2) order by username asc");

$query1=$this->db->query("select *from users WHERE users.user_id in( SELECT friends.reciever_id FROM `friends` WHERe sender_id=".$arr['user_id']." and friends.friend_status=2 order by friends_create_date desc)OR users.user_id in(SELECT friends.sender_id FROM `friends` WHERe friends.reciever_id=".$arr['user_id']." and friends.friend_status=2 order by friends_create_date desc)");
$querycount=$this->db->query("select count(*) as request_count from friends where reciever_id=".$arr['user_id']." and friend_status=1");
	
	if($query->num_rows()>0){
		
		$result=$query->result_array();

	}
	else{
	$result=array();

	}
	if($query1->num_rows()>0){
		
		$result1=$query1->result_array();

	}
	else{
	$result1=array();

	}
	$request_count=$querycount->result_array();
	$data=array('all_friends'=>$result,"recents_friends"=>$result1,"request_count"=>$request_count[0]['request_count']);


	return  $data;


}


public function add_friend_status($arr){

$this->db->insert("friends",$arr);
return "Request Sent SuccessFully";

}

public function update_friend_status($arr){

	$this->db->query("update friends set friend_status=".$arr['friend_status']." where sender_id=".$arr['sender_id']." and reciever_id=".$arr['reciever_id']);
	return "status updated successfully";
}

public function add_activity_users($arr=array()){

$this->db->insert('users_activity',$arr);
$query1=$this->db->query("select activity_type, count(activity_type) as total_activity_count ,SUM(activity_distance)as total_distance,Sum(footsteps) as total_footsteps from users_activity where user_id=".$arr['user_id']." group by activity_type ");
               
return $query1->result_array();
}


}

?>
