<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if( ! function_exists('InvesterValidate'))

{

function InvesterValidate()

{

	$ci =& get_instance();



	 if(! $ci->session->userdata('Invester')){

            return false;

        }else{

			return true; 

			}

}

//function end

}



if( ! function_exists('admin'))

{

function admin()

{

	$ci =& get_instance();



	 if(! $ci->session->userdata('admin')){

            return false;

        }else{

			return true; 

			}

}

//function end

}



if( ! function_exists('getUniqueChatId'))

{

function getUniqueChatId($id1,$id2)

{

	if($id1<$id2){

		return $id1.'pchat'.$id2;

		}else{

			return $id2.'pchat'.$id1;

			}

}

//function end

}



if( ! function_exists('converTIme'))

{

function converTIme($time)

{

$remainder=($time % 15);

if($remainder==0){

	return ($time+15);

	}else{

$toAdd=15-$remainder;

$total_time=$time+$toAdd+15;

return $total_time;

	}

}

//function end

}



if( ! function_exists('timezoneList'))

{

function timezoneList()

{

    $timezoneIdentifiers = DateTimeZone::listIdentifiers();

    $utcTime = new DateTime('now', new DateTimeZone('UTC'));



    $tempTimezones = array();

    foreach ($timezoneIdentifiers as $timezoneIdentifier) {

        $currentTimezone = new DateTimeZone($timezoneIdentifier);



        $tempTimezones[] = array(

            'offset' => (int)$currentTimezone->getOffset($utcTime),

            'identifier' => $timezoneIdentifier

        );

    }



    // Sort the array by offset,identifier ascending

    usort($tempTimezones, function($a, $b) {

		return ($a['offset'] == $b['offset'])

			? strcmp($a['identifier'], $b['identifier'])

			: $a['offset'] - $b['offset'];

    });



	$timezoneList = array();

    foreach ($tempTimezones as $tz) {

		$sign = ($tz['offset'] > 0) ? '+' : '-';

		$offset = gmdate('H:i', abs($tz['offset']));

        $timezoneList[$tz['identifier']] = '(UTC ' . $sign . $offset . ') ' .

			$tz['identifier'];

    }



    return $timezoneList;

}

//function end

}



function objectToArray($d) {

		if (is_object($d)) {

			// Gets the properties of the given object

			// with get_object_vars function

			$d = get_object_vars($d);

		}

 

		if (is_array($d)) {

			/*

			* Return array converted to object

			* Using __FUNCTION__ (Magic constant)

			* for recursive call

			*/

			return array_map(__FUNCTION__, $d);

		}

		else {

			// Return array

			return $d;

		}

	}



function arrayToObject($d) {

		if (is_array($d)) {

			/*

			* Return array converted to object

			* Using __FUNCTION__ (Magic constant)

			* for recursive call

			*/

			return (object) array_map(__FUNCTION__, $d);

		}

		else {

			// Return object

			return $d;

		}

	}



function dateDiff ($d1,$d2,$type='seconds') {

if($type=='minutes'){

	$divider=60;

	}elseif($type=='hours'){

		$divider=60*60;

		}elseif($type=='days'){

		$divider=60*60*24;

		}else{

			$divider=1;

			}

 return round(abs(strtotime($d1)-strtotime($d2))/$divider);

}



if( ! function_exists('converToTz'))

{

function converToTz($time="",$toTz='',$fromTz='')

	{	

		// timezone by php friendly values

		$date = new DateTime($time, new DateTimeZone($fromTz));

		$date->setTimezone(new DateTimeZone($toTz));

		$time= $date->format('Y-m-d H:i:s');

		return $time;

	}

}//function end



if( ! function_exists('searchForId'))

{

function searchForId($id, $array) {

	if($array == NULL) return -100;

   foreach ($array as $key => $val) {

       if ($val['hour'] == $id) {

           return $key;

       }

   }

   return -100;

}

}//function end



if( ! function_exists('searchForIdTimeStamp'))

{

function searchForIdTimeStamp($id, $array) {

	if($array == NULL) return -100;

   foreach ($array as $key => $val) {

       if ($val['timestamp'] == $id) {

           return $key;

       }

   }

   return -100;

}

}//function end



if( ! function_exists('time_intevals'))

{

	//$from,$to

function time_intevals($data)

{

    $slots_all;

	foreach($data as $keys => $values){

		$from=$values['from'];

		$to=$values['to'];

		

		if($from>$to || $from==$to){

			//do nothing

	}else{

		$key=$from;

		while($key<$to){

			

			$slots_all[]=$key;

			$key=date('Y-m-d H:i:s', strtotime($key.'+ 15 minutes'));

			}//end while



		}//end ifelse

		

		}//end foreach

		return $slots_all;	

}

}//function end



function getAllDays($start_date,$end_date,$days)

{

$initial = $start_date;

$final = $end_date;

$all_days=array();

while($initial <= $final)

{

$initial = date('Y-m-d', strtotime($initial.'+ 1 day'));

$day = date("N",strtotime($initial));

if(in_array($day,$days)) {

$all_days[]=$initial;



}//end if



}//end while

return $all_days;//return all days array

}



function getEmail($id){

	$ci =& get_instance();

	$email=$ci->Student_model->getEmail($id);

	return $email;

	}



function createRandomString() { 



    $chars = "abcdefghijkmnopqrstuvwxyz023456789"; 

    srand((double)microtime()*1000000); 

    $i = 0; 

    $pass = '' ; 



    while ($i <= 7) { 

        $num = rand() % 33; 

        $tmp = substr($chars, $num, 1); 

        $pass = $pass . $tmp; 

        $i++; 

    } 



    return $pass; 



}//end function



function ageCalculator($birthDate){

	//explode the date to get month, day and year

	$birthDate = date('Y-m-d',strtotime($birthDate));

	$currentDate = date('Y-m-d');

	

	$diff = abs(strtotime($currentDate) - strtotime($birthDate));

	

	$years = floor($diff / (365*60*60*24));

	$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));

	$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

	

	echo $years;

	

	//printf("%d years, %d months, %d days\n", $years, $months, $days);

}



function getConversations(){

	$ci =& get_instance();

	$list=$ci->main_model->getConversations();

	return $list;

	}



function getActiveConversations(){

	$ci =& get_instance();

	$data = false;

	$array = $ci->session->userdata('boxes');

	if($array){

	foreach ($array as $key =>$value) {

	$data[] = $value;

	}

	}

	if($data){

	$result = $ci->main_model->getAllChatPersonal($data);

	return $result;

	}

	return false;

}

function sendIosNofification($deviceToken, $message, $data){

if($deviceToken == false || strlen($deviceToken)==0){
	return false;
}

$passphrase = '123456789';

////////////////////////////////////////////////////////////////////////////////

$Certs = "assets/IOSCerts/apns-production.pem";
//echo $Certs;
//echo APPPATH.'../apns-dev.pem';
//exit;
$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', $Certs);
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

// Open a connection to the APNS server
$fp = stream_socket_client(
	'ssl://gateway.push.apple.com:2195', $err,
	$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

if (!$fp)
	return false; //failed to connect to APNS

// Create the payload body
$body['aps'] = array(
	'alert' => $message,
	'extras' => $data,
	'sound' => 'default'
	);

// Encode the payload as JSON
$payload = json_encode($body);

// Build the binary notification
$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

// Send it to the server
$result = fwrite($fp, $msg, strlen($msg));

if (!$result)
	return false; //Message not delivered.
else fclose($fp);

return true;
}

function getDeviceInfo($type,$id){

	$ci =& get_instance();

	$result = $ci->api_model->getDeviceInfo($type,$id);

	return $result;

}

function sendAndroidNofification($registatoin_ids, $message) {
// Set POST variables
$url = 'https://android.googleapis.com/gcm/send';

$fields = array(
'registration_ids' => $registatoin_ids,
'data' => $message,
);

$headers = array(
'Authorization: key=' . GOOGLE_API_KEY,
'Content-Type: application/json'
);
// Open connection
$ch = curl_init();

// Set the url, number of POST vars, POST data
curl_setopt($ch, CURLOPT_URL, $url);

curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Disabling SSL Certificate support temporarly
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

// Execute post
$result = curl_exec($ch);
if ($result === FALSE) {
die('Curl failed: ' . curl_error($ch));
}

// Close connection
curl_close($ch);
//echo $result;
}

?>