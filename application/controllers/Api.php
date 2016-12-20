<?php



defined('BASEPATH') OR exit('No direct script access allowed');



class Api extends CI_Controller {







function __construct(){


	parent::__construct();



//	echo "<pre>";



//	print_r($data);



//	exit;



}

function updatedeviceid(){
$data=$this->input->post();
$res=$this->api_model->update_device_id($data);
echo json_encode($res);
}


function creategroups(){
	$data=$this->input->post();

	$result=$this->api_model->create_groups($data);
	
	echo json_encode($result);
}

function joinnedgroups(){
	$data=$this->input->post();
	$result=$this->api_model->joinned_groups($data);
	echo json_encode($result);
}

function viewgroupsmember(){
	$data=$this->input->post();
	$res=$this->api_model->view_groups_member($data);
	echo json_encode($res);
}
function deletegroup(){
	$data=$this->input->post();
 	$result=$this->api_model->delete_group($data);
	echo json_encode($result);
}

function leavegroup(){
$data=$this->input->post();
$result=$this->api_model->leave_group($data);
	echo json_encode($result);
}
function viewcreatedgroups(){
$data=$this->input->post();
$result=$this->api_model->view_create_groups($data);
echo json_encode($result);

}


function getleaderboard(){

$data=$this->input->post();

$rest=$this->api_model->get_leader_board($data);
echo json_encode($rest);
}

function getactivity(){

$data=$this->input->post();
$result= $this->api_model->get_activity($data);
echo json_encode($result);
}


function updateusersteps(){
	$data=$this->input->post();
	$res=$this->api_model->update_user_steps($data);
	echo json_encode($res);
}


function viewuserstepsprof(){
	$data=$this->input->post();
	$res= $this->api_model->view_user_steps_prof($data);
	echo json_encode($res);
}

function viewusersteps(){
	$data=$this->input->post();
	$res=$this->api_model->view_user_steps($data);
	echo json_encode($res);
}


function getuser(){


	$array = $this->input->post();
	$result = $this->api_model->getuser($array);
	if($result == 'invalid'){
		$data = array('error'=>true,'data'=>$result);
	}else{
		$data = array('error'=>false,'data'=>$result);
	}
	echo json_encode($data);
}
//end function



function register(){

	$array = $this->input->post();
	$result = $this->api_model->register($array);

//echo $result;

	if($result=='already'){



		$data = array('error'=>true,'data'=>$result);



	}



	elseif($result == 'server-error'){



		$data = array('error'=>true,'data'=>$result);



	}else{
		$data = array('error'=>false,'data'=>$result);
	}

	echo json_encode($data);

}//end function


function logout(){
$array=$this->input->post();
$result=$this->api_model->logout_device($array);
	if($result=='server-error')
		$data = array('error'=>true,'data'=>$result);
	
	else
		$data = array('error'=>false,'data'=>'successfull Logout');
	

echo json_encode($data);
}

function update_profile(){
	
$data= $this->input->post();

$config['upload_path']          ='assets/uploads/';

	$config['allowed_types'] = '*';

	$config['encrypt_name'] = true;

	$this->load->library('upload');
	$this->upload->initialize($config);



	
	


		if ( ! $this->upload->do_upload('image1')){

		$error = array('error' => $this->upload->display_errors());
		$data['profilepic']="";
	//	$data['results'] = array('response'=>false,'data'=>$error);
		
		//echo json_encode($data);

		}else{

			$fileinfo = $this->upload->data();

			$path = $config['upload_path'].$fileinfo['file_name'];
			$data['profilepic']=$fileinfo['file_name'];

			//$data['results'] = array('response'=>true,'data'=>$path);
			//echo json_encode($data);

		}

	$result = $this->api_model->update_profile($data);

	if($result=='server-error'){
		$data = array('error'=>true,'data'=>$result);
	}
	else{
		$data = array('error'=>false,'data'=>$result[0]);
	}

echo json_encode($data);

}

function add_activity(){

$data= $this->input->post();

$config['upload_path']          ='assets/uploads/';

	$config['allowed_types'] = '*';

	$config['encrypt_name'] = true;

	$this->load->library('upload');
	$this->upload->initialize($config);



	
	


		if ( ! $this->upload->do_upload('image1')){

		$error = array('error' => $this->upload->display_errors());
		$data['activity_gpx_path']="";
	//	$data['results'] = array('response'=>false,'data'=>$error);
		
		//echo json_encode($data);

		}else{

			$fileinfo = $this->upload->data();

			$path = $config['upload_path'].$fileinfo['file_name'];
			$data['activity_gpx_path']=$fileinfo['file_name'];

			//$data['results'] = array('response'=>true,'data'=>$path);
			//echo json_encode($data);

		}





	
		if ( ! $this->upload->do_upload('image2')){
		
		$error = array('error' => $this->upload->display_errors());
		
		$data['photo_path']="";
		//$data['results'] = array('response'=>false,'data'=>$error);

		//echo json_encode($data);

		}else{
			
			$fileinfo = $this->upload->data();

			$path = $config['upload_path'].$fileinfo['file_name'];
			$data['photo_path']=$fileinfo['file_name'];
			//$data['results'] = array('response'=>true,'data'=>$path);
		//	echo json_encode($data);

		}



$query= $this->api_model->add_activity_users($data);
echo json_encode(array('error'=>false,"data"=>$query));

}

public function addselectedplans(){
$data=$this->input->post();
$result=$this->api_model->add_selected_plans($data);
echo json_encode($result);
}

public function leaders_board(){
	$data=$this->input->post();


}

public function viewvirtualtours(){

	$data= $this->input->post();
	$result=$this->api_model->view_virtual_tours($data);
	echo json_encode($result);
	


}

public function view_virtual_tourimages($id){
	//1-Abu-Dhabi <a href="http://servue.ae/health/index.php/api/view_virtual_tourimages/1" style="position:absolute;  top:1560px;left:845px;width:100px;height:100px; "></a>
//2-Dubai <a href='http://servue.ae/health/index.php/api/view_virtual_tourimages/2' style='position:absolute;  top:1190px;left:785px;width:100px;height:100px; '></a>
//3-Sharjah <a href='http://servue.ae/health/index.php/api/view_virtual_tourimages/3' style='position:absolute; top:690px;left:1330px;width:100px;height:100px; '></a>
//4-Ajman <a href="http://servue.ae/health/index.php/api/view_virtual_tourimages/4" style="position:absolute; top:570px;left:730px;width:100px;height:100px; "></a>
//5-UmmulQainmah <a href="http://servue.ae/health/index.php/api/view_virtual_tourimages/5" style="position:absolute; top:235px;left:1070px;width:100px;height:100px; "></a>
//6-RasulQaimah  
//7-Alfujarhahh <a href="http://servue.ae/health/index.php/api/view_virtual_tourimages/1" style="position:absolute; top:1220px;left:1820px;width:100px;height:100px; "></a>
	$res=$this->api_model->view_virtual_tour_by_id($id);
	$images=array("","abu_dhabi.jpg","dubai.jpg","sharjah.jpg","Ajman.jpg","Umm_al_quwain.jpg","ras_al_khaimas.jpg","al_fujairah.jpg");

	echo json_encode($res[0]);

}

public function loadCordinate($user_id){
$result=$this->api_model->view_virtual_tours($user_id);
$res=$result['virtual_tour'];
$res2=$this->api_model->view_virtual_tour();
$line="";
$img="";
for($i=0;$i<count($res);$i++){
    $points=explode(" ",$res[$i]['line_draw']);
    $pointH=explode(" ",$res[$i]['img_path']);
    $img=$res[$i]['img_direction'];
if(intval($res[$i]["selected"])==1)
$line.='<line x1="'.$points[0].'" y1="'.$points[1].'" x2="'.$points[2].'" y2="'.$points[3].'" style="stroke:rgb(0,255,0);stroke-width:6;stroke-dasharray=16.76 16.76" />';
else
$line.='<line x1="'.$points[0].'" y1="'.$points[1].'" x2="'.$points[2].'" y2="'.$points[3].'" style="stroke:rgb(75,0,130);stroke-width:0;stroke-dasharray=16.76 16.76-webkit-animation-name: enablea; /* Safari 4.0 - 8.0 */
    -webkit-animation-duration: 7s; /* Safari 4.0 - 8.0 */
    animation-name: enablea;
	 
    animation-duration: 7s;" />';

}
$xmove=intval($points[0])-intval($points[2]);
$ymove=intval($points[1])-intval($points[3]);

settype($xmove, "string");
settype($ymove, "string");

$html='

<svg height="3310" width="7265">
  '.$line.'
  Sorry, your browser does not support inline SVG.
  <image xlink:href="'.base_url().'assets/imgs/'.$img.'" class="disable"  x="'.$pointH[0].'" y="'.$pointH[1].'" width="150" height="60" style="stroke:rgb(0, 0, 153);stroke-width:2">
   <animateTransform attributeName="transform"
    type="translate"
    values="0 0; '.$pointH[2].' '.$pointH[3].'"
    begin="0s"
    dur="'.$pointH[4].'"
    repeatCount="indefinite"
  />
    
</image>
 </svg>';
$link="";
for($i=0;$i<count($res2);$i++){
$link=$link."<a href='".base_url()."index.php/api/view_virtual_tourimages/".$res2[$i]['virtual_tour_id']."' style='".$res2[$i]['virtual_tour_link']."' ></a>";

}
echo $html.$link;
}


public function view_WebView_VirtualTours($user_id,$device_id){


	
echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
  
        $.get("'.base_url().'index.php/Api/loadCordinate2/'.$user_id.'", function(data, status){
			
            document.getElementById(\'link\').innerHTML=data;
          hide();
			
        });
    
});


</script>';

$script="";

if(intval($device_id)==1){
	
$script="<meta name=\"viewport\" content=\"width=device-width, initial-scale=0.5, maximum-scale=2.0\">";

}
echo"


<img id=\"img\" src='".base_url()."assets/imgs/3d_Leftside_map_Sample_opt.jpg' width=\"0\" height=\"0\">
";
//$path =  $_SERVER['DOCUMENT_ROOT'].'/health'."/assets/imgs/3d_Leftside_map_6mb.jpg";
$path = base_url()."/assets/imgs/3d_Leftside_map_6mb.jpg";
 $type = pathinfo($path, PATHINFO_EXTENSION);
 //$data = file_get_contents($path);
 //$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
echo "<img src=\"".$path."\"  style='position:absolute;top:0px; left:0px; width:7265px;height:3310px'  />";
// for ($i=1;$i<10;$i++)
// {
// 	for ($j=1;$j<25;$j++){


// $path = 
// $_SERVER['DOCUMENT_ROOT'].'/health'."/assets/imgs/maps/map__".$i.$j.'.png';
// $type = pathinfo($path, PATHINFO_EXTENSION);
// $data = file_get_contents($path);
// $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
// echo "<img src=\"".$base64."\"  style='position:absolute;top:".(($i-1)*354)."px; left:".(($j-1)*300)."px; width:300px;height:354px'  />";
// 	}


// }
echo "
<canvas id=\"myCanvas\" width=\"7200\" height=\"3186\"  style=\"border:0px solid #d3d3d3;  position :absolute; top:0px;left:0px\">
Your browser does not support the HTML5 canvas tag.
</canvas>
<script type=\"text/javascript\">
function toggleZoomScreen() {
document.body.style.zoom=\"80%\"
} 
</script>

<div id='link' style='position:absolute; top:0px; left:0px'></div>
<style>
.loader {
    border: 16px solid #f3f3f3; /* Light grey */
    border-top: 16px solid #3498db; /* Blue */
    border-radius: 50%;
    width: 120px;
background:white;
opacity:0.7;
    height: 120px;
    animation: spin 2s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

#loadpop{
position:fixed;
top:0px;
left:0px;
right:0px;
bottom:0px;
width:100%;
height:100vh;
margin:0px;
background:transparent;
opacity:0.8; 
align:center;

}
body{
background:#37474F;

}

.enable{

 -webkit-animation-name: enablea; /* Safari 4.0 - 8.0 */
    -webkit-animation-duration: 7s; /* Safari 4.0 - 8.0 */
    animation-name: enablea;
	 
    animation-duration: 7s;
	

}

.disable{
 -webkit-animation-name: disablea; /* Safari 4.0 - 8.0 */
    -webkit-animation-duration: 10s; /* Safari 4.0 - 8.0 */
    animation-name: disablea;
    animation-duration: 10s;
-webkit-animation-iteration-count: 10000;
    
	 animation-iteration-count: 10000;
}
/* Safari 4.0 - 8.0 */
@-webkit-keyframes disablea {
    from {background-color: transparent;}
    to {background-color: #4b0082;}
}

/* Standard syntax */
@keyframes disablea {
    from {background-color: transparent;}
    to {background-color: #4b0082;}
}
@-webkit-keyframes enablea {
    from {background-color: transparent;}
    to {background-color: #00bb00;}
}

/* Standard syntax */
@keyframes enablea {
    from {background-color: transparent;}
    to {background-color: #00bb00;}
}
</style>

<table id='loadpop'>
<tr><td align=\"center\">
<div style=\" background-color:white; \"> </div>
</td>
</tr>
</table>


<script>





function drawLine(){

	 var elem = document.getElementById('loadpop');
 elem.parentNode.removeChild(elem);


}

window.onload = function() {
    var c = document.getElementById(\"myCanvas\");
    var ctx = c.getContext(\"2d\");
    var img = document.getElementById(\"img\");
    ctx.drawImage(img, 7200, 3186);
	setTimeout(drawLine,1000);
setTimeout(function(){
	window.scrollTo(5400, 700);
},300);
//document.getElementById(\"here\").scrollIntoView();
}
</script>
<div id='divline'></div>
";

}

function getplans(){
	$data=$this->input->post();
$result=$this->api_model->get_plans($data);
echo json_encode($result);
}

function friendslist(){


	$data=$this->input->post();
	
	$result=$this->api_model->view_friends($data);

	echo json_encode ($result);
}


public function sendNotification_IOS($data,$deviceid){

// Put your device token here (without spaces):
$deviceToken = $deviceid;

// Put your private key's passphrase here:
$passphrase = '';

// Put your alert message here:
$message = $data['message'];

////////////////////////////////////////////////////////////////////////////////
$contextOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false
        )
    );
    
    
$ctx = stream_context_create($contextOptions);

stream_context_set_option($ctx, 'ssl', 'local_cert', $_SERVER['DOCUMENT_ROOT'].'/health/assets/IOSCertEWG/dev.pem');
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

// Open a connection to the APNS server
$fp = stream_socket_client(
  'ssl://gateway.sandbox.push.apple.com:2195', $err,
  $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

if (!$fp)
  exit("Failed to connect: $err $errstr" . PHP_EOL);

//echo 'Connected to APNS' . PHP_EOL;

// Create the payload body
$body['aps'] = array(
  'alert' => $message,
  
  'sound' => 'default',
  'user'=> $data
  );

// Encode the payload as JSON
$payload = json_encode($body);

// Build the binary notification
$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

// Send it to the server

    
$result = fwrite($fp, $msg, strlen($msg));

    
// if (!$result)
//   echo 'Message not delivered' . PHP_EOL;
// else
//   echo 'Message successfully delivered' . PHP_EOL;

// Close the connection to the server
fclose($fp);


}



function sendNotificationTestIOS(){


// Put your device token here (without spaces):
$deviceToken = 'a3b0b7292cb30d5301140fccfc14c3515d7ef4d1b5eccbb3ed8780f20d766e27';

// Put your private key's passphrase here:
$passphrase = '';

// Put your alert message here:
$message = 'Aneel Ahmed';

////////////////////////////////////////////////////////////////////////////////
$contextOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false
        )
    );
    
    
$ctx = stream_context_create($contextOptions);
echo  $_SERVER['DOCUMENT_ROOT'].'/health/assets/IOSCertEWG/dev.pem';
stream_context_set_option($ctx, 'ssl', 'local_cert', $_SERVER['DOCUMENT_ROOT'].'/health/assets/IOSCertEWG/dev.pem');
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

// Open a connection to the APNS server
$fp = stream_socket_client(
  'ssl://gateway.sandbox.push.apple.com:2195', $err,
  $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

if (!$fp)
  exit("Failed to connect: $err $errstr" . PHP_EOL);

echo 'Connected to APNS' . PHP_EOL;

// Create the payload body
$body['aps'] = array(
  'alert' => $message,
  'badge' => '1',
  'sound' => 'default'
  );

// Encode the payload as JSON
$payload = json_encode($body);

// Build the binary notification
$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

// Send it to the server

    
$result = fwrite($fp, $msg, strlen($msg));

    
// if (!$result)
//   echo 'Message not delivered' . PHP_EOL;
// else
//   echo 'Message successfully delivered' . PHP_EOL;

// Close the connection to the server
fclose($fp);


}

function loadimages(){
	

for ($i=1;$i<10;$i++)
{
	for ($j=1;$j<25;$j++){

echo "<img src=\"".base_url()."assets/imgs/maps/map__".$i.$j.".png\"  style='position:absolute;top:".(($i-1)*354)."px; left:".(($j-1)*300)."px; width:300px;height:354px'  />";
	}


}
;
//echo "<img src=\"".base_url()."/assets/imgs/3d_Leftside_map.jpg\" width=\"2626\" height=\"2254\"  />";
}
function friendrequest1(){
   $data=$this->input->post();
   $result=$this->api_model->friends_request1($data);
 
   $pusdata=$result[1];
  
   if(intval($data['friend_status'])==1)
   {
	    $pusdata['friend_status']=$data['friend_status'];
	$pusdata['message']='You have a new request from '.$pusdata['username'];
    $this->sendNotification_IOS($pusdata,$result[0]['deviceid']);
   }else if(intval($data['friend_status'])==2){
 $pusdata['friend_status']=$data['friend_status'];
$pusdata['message']='You have a new request from '.$result[0]['username'];
 $this->sendNotification_IOS($pusdata,$result[0]['deviceid']);
   }
  
 
  
   echo json_encode(array("response"=>"Response sent Successfully","error"=>false,"data"=>$data));
   
}

function viewpeople(){
	$data=$this->input->post();
	$result=$this->api_model->view_people($data);
	echo json_encode(array("people"=>$result));
}
function viewfriendprofile(){
	$data=$this->input->post();
	$result=$this->api_model->get_friend_profile($data);
	echo json_encode($result);
}
function viewallrequest(){
	$data=$this->input->post();
	$result=$this->api_model->view_all_request($data);
	echo json_encode($result);
}

function forgotPassword(){
   $array = $this->input->post();
   $result = $this->api_model->forgot_password($array);
	if($result=='invalid'){
		$data = array('error'=>true,'data'=>$result);
	}
	elseif($result == 'server-error'){
		$data = array('error'=>true,'data'=>$result);
	}else{
		mail($array['email'],"Password Recovery","Your password is :".$result);
		$data = array('error'=>false,'data'=>@"An email has sent to you","password"=>$result);
	}
	echo json_encode($data);
}
/* 
Animated Gif Maps
<!DOCTYPE html>
<html>
<body>

<canvas id="myCanvas" width="300" height="200" style="border:1px solid #d3d3d3;">
Your browser does not support the HTML5 canvas tag.</canvas>

<script>
var c = document.getElementById("myCanvas");
var ctx = c.getContext("2d");
ctx.moveTo(0,0);
ctx.lineTo(300,200);
ctx.stroke();

setTimeout(move,500);

//var startx=100,starty=200;
var startx=150,starty=100;
var countx=0,county=0;
var stopx=0,stopy=0;
//var endx=150,endy=100;
var endx=100,endy=200;
var directionmove=0;
function move(){
var d=document.getElementById("box");
var sd=document.getElementById("sd");
var left=startx;
var top=starty;
left=((countx/100)*(endx-startx))+startx;
top=((county/100)*(endy-starty))+starty;
if(directionmove==0){
if(startx>endx){

countx++;
}
else{countx--;
}

if(starty<endy){

county++;
}
else{county--;
}




d.style.top=top+"px";
d.style.left=left+"px";
sd.innerHTML="TOP:"+top+" , left:"+left;
if(top==200&&left==100){


directionmove=1;
}

}
if(directionmove==1){
if(startx<endx){

countx++;
}
else{countx--;
}

if(starty>endy){

county++;
}
else{county--;
}




d.style.top=top+"px";
d.style.left=left+"px";
sd.innerHTML="TOP:"+top+" , left:"+left;
if((top==100&&left==150)){

directionmove=0;
}

}
setTimeout(move,50);
} 

</script>

<div id="box1" style="width:20px; height:20px; background:yellow; position:absolute; top:0px;left:0px">

</div>
<div id="box2" style="width:20px; height:20px; background:green; position:absolute; top:100px;left:150px">

</div>
<div id="box3" style="width:20px; height:20px; background:blue; position:absolute; top:200px;left:100px">
</div>
<div id="box" style="width:20px; height:20px; background:red; position:absolute; top:0px;left:0px">


</div>
<div id="sd"></div>
</body>
</html>


*/


function loadingimages($user_id,$device_id){


	
echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
  
        $.get("'.base_url().'index.php/Api/loadCordinate/'.$user_id.'", function(data, status){
			
            document.getElementById(\'link\').innerHTML=data;
          hide();
			
        });
    
});


</script>';

$script="";

if(intval($device_id)==1){
	
$script="<meta name=\"viewport\" content=\"width=device-width, initial-scale=0.5, maximum-scale=2.0\">";

}
echo"


<img id=\"img\" src='".base_url()."assets/imgs/3d_Leftside_map_Sample_opt.jpg' width=\"0\" height=\"0\">
";
//$path =  $_SERVER['DOCUMENT_ROOT'].'/health'."/assets/imgs/3d_Leftside_map_6mb.jpg";
$path = base_url()."/assets/imgs/3d_Leftside_map_6mb.jpg";
 $type = pathinfo($path, PATHINFO_EXTENSION);
 //$data = file_get_contents($path);
 //$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
echo "<img src=\"".$path."\"  style='position:absolute;top:0px; left:0px; width:7265px;height:3310px'  />";
// for ($i=1;$i<10;$i++)
// {
// 	for ($j=1;$j<25;$j++){


// $path = 
// $_SERVER['DOCUMENT_ROOT'].'/health'."/assets/imgs/maps/map__".$i.$j.'.png';
// $type = pathinfo($path, PATHINFO_EXTENSION);
// $data = file_get_contents($path);
// $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
// echo "<img src=\"".$base64."\"  style='position:absolute;top:".(($i-1)*354)."px; left:".(($j-1)*300)."px; width:300px;height:354px'  />";
// 	}


// }
echo "
<canvas id=\"myCanvas\" width=\"7200\" height=\"3186\"  style=\"border:0px solid #d3d3d3;  position :absolute; top:0px;left:0px\">
Your browser does not support the HTML5 canvas tag.
</canvas>
<script type=\"text/javascript\">
function toggleZoomScreen() {
document.body.style.zoom=\"80%\"
} 
</script>

<div id='link' style='position:absolute; top:0px; left:0px'></div>
<style>
.loader {
    border: 16px solid #f3f3f3; /* Light grey */
    border-top: 16px solid #3498db; /* Blue */
    border-radius: 50%;
    width: 120px;
background:white;
opacity:0.7;
    height: 120px;
    animation: spin 2s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

#loadpop{
position:fixed;
top:0px;
left:0px;
right:0px;
bottom:0px;
width:100%;
height:100vh;
margin:0px;
background:transparent;
opacity:0.8; 
align:center;

}
body{
background:#37474F;

}

.enable{

 -webkit-animation-name: enablea; /* Safari 4.0 - 8.0 */
    -webkit-animation-duration: 7s; /* Safari 4.0 - 8.0 */
    animation-name: enablea;
	 
    animation-duration: 7s;
	

}

.disable{
 -webkit-animation-name: disablea; /* Safari 4.0 - 8.0 */
    -webkit-animation-duration: 10s; /* Safari 4.0 - 8.0 */
    animation-name: disablea;
    animation-duration: 10s;
-webkit-animation-iteration-count: 10000;
    
	 animation-iteration-count: 10000;
}
/* Safari 4.0 - 8.0 */
@-webkit-keyframes disablea {
    from {background-color: transparent;}
    to {background-color: #4b0082;}
}

/* Standard syntax */
@keyframes disablea {
    from {background-color: transparent;}
    to {background-color: #4b0082;}
}
@-webkit-keyframes enablea {
    from {background-color: transparent;}
    to {background-color: #00bb00;}
}

/* Standard syntax */
@keyframes enablea {
    from {background-color: transparent;}
    to {background-color: #00bb00;}
}
</style>

<table id='loadpop'>
<tr><td align=\"center\">
<div style=\" background-color:white; \"> </div>
</td>
</tr>
</table>


<script>





function drawLine(){

	 var elem = document.getElementById('loadpop');
 elem.parentNode.removeChild(elem);


}

window.onload = function() {
    var c = document.getElementById(\"myCanvas\");
    var ctx = c.getContext(\"2d\");
    var img = document.getElementById(\"img\");
    ctx.drawImage(img, 7200, 3186);
	setTimeout(drawLine,1000);
setTimeout(function(){
	window.scrollTo(5400, 700);
},300);
//document.getElementById(\"here\").scrollIntoView();
}
</script>
<div id='divline'></div>
";

}

public function loadCordinate2($user_id){
$result=$this->api_model->view_virtual_tours($user_id);
$res=$result['virtual_tour'];
 $res2=$this->api_model->view_virtual_tour();
$line="";
$img="";
for($i=0;$i<count($res);$i++){
    $points=explode(" ",$res[$i]['line_draw']);
    $pointH=explode(" ",$res[$i]['img_path']);
    $img=$res[$i]['img_direction'];
if(intval($res[$i]["selected"])==1)
$line.='<line x1="'.$points[0].'" y1="'.$points[1].'" x2="'.$points[2].'" y2="'.$points[3].'" style="stroke:rgb(0,255,0);stroke-width:6;stroke-dasharray=16.76 16.76" />';
else
$line.='<line x1="'.$points[0].'" y1="'.$points[1].'" x2="'.$points[2].'" y2="'.$points[3].'" style="stroke:rgb(75,0,130);stroke-width:0;stroke-dasharray=16.76 16.76-webkit-animation-name: enablea; /* Safari 4.0 - 8.0 */
    -webkit-animation-duration: 7s; /* Safari 4.0 - 8.0 */
    animation-name: enablea;
	 
    animation-duration: 7s;" />';

}
$xmove=intval($points[0])-intval($points[2]);
$ymove=intval($points[1])-intval($points[3]);

settype($xmove, "string");
settype($ymove, "string");

$html='

<svg height="3310" width="7265">
  '.$line.'
  Sorry, your browser does not support inline SVG.
  <image xlink:href="'.base_url().'assets/imgs/'.$img.'" class="disable"  x="'.$pointH[0].'" y="'.$pointH[1].'" width="150" height="60" style="stroke:rgb(0, 0, 153);stroke-width:2">
   <animateTransform attributeName="transform"
    type="translate"
    values="0 0; '.$pointH[2].' '.$pointH[3].'"
    begin="0s"
    dur="'.$pointH[4].'"
    repeatCount="indefinite"
  />
    
</image>
 </svg>';

 $link="";
for($i=0;$i<count($res2);$i++){
$link=$link."<a href='".base_url()."index.php/api/view_virtual_tourimages/".$res2[$i]['virtual_tour_id']."' style='".$res2[$i]['virtual_tour_link']."' ></a>";

}
echo $html.$link;
}









}//end controllera
