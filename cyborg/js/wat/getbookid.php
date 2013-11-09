<?php
//get the wattpad code
//go to chapter url
//get book url
//get all parts

$wattpadcode = $_GET['wattcode'];

$chapter_url_data = doCurl("http://m.wattpad.com/go?id=" . $wattpadcode);
 
if (strpos($chapter_url_data,'gopart.php?id=') !== false) {
				
	preg_match("/gopart.php.id=([0-9]+)/",$chapter_url_data,$bookid);
	
	if(is_array($bookid) && isset($bookid[1])){
		//good
		$bookid =  $bookid[1];
		echo $bookid;
		
	} else {
		echo "ERROR";
	}
} else {
	echo "NOT_FOUND";
} //end check chapter url



function debug($variable) {
	echo "<textarea cols='15' rows='10'>" . $variable . "</textarea>";
}


function doCurl($url){
	$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		$output = curl_exec($ch); 
		curl_close($ch);  
		// handle error; error output
		

		  return ($output);
		
 }
?>