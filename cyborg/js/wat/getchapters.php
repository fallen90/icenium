<?php
ini_set('max_execution_time', 300);
//get the wattpad code
//go to chapter url
//get book url
//get all parts

$wattpadcode = $_GET['wattcode'];
$bookid  ="";
$chapter_url_data = doCurl("http://m.wattpad.com/go?id=" . $wattpadcode);

if (strpos($chapter_url_data,'gopart.php?id=') !== false) {
				
	preg_match("/gopart.php.id=([0-9]+)/",$chapter_url_data,$bookid);
	
	if(is_array($bookid) && isset($bookid[1])){
		//good
		$bookid =  $bookid[1];
	} else {
		echo "error occured on fetching book id";
	}
	
	$chapter_codes = array();
	$chapter_titles = array();
	$book_url_data = doCurl("http://m.wattpad.com/gopart.php?id=".$bookid);
	
		if (strpos($book_url_data,'go.php?id=') !== false) {
			preg_match_all("/<a href=.(go.php.id=[0-9]+).>(.*?)<.a>/s",$book_url_data,$matches);
			
			$matches = array_filter($matches);
			if(is_array($matches) && isset($matches[1])){
				//good
				foreach($matches[1] as $key => $chapter_code){
					$chapter_codes["Chapter " . ($key+1)] = preg_replace("/go.php.id./","",$chapter_code);
				}
				// // clean the build folder
				foreach($chapter_codes as $key=>$chapter){
					$build = "./jasper/builds/" . $bookid . "/" ;
					if(file_exists($build . $key . ".txt")){
						unlink($build . $key . ".txt");
					} else if(file_exists($build . $chapter . ".txt")){
						unlink($build . $chapter . ".txt");
					}
				}
				
				$cd =json_encode($chapter_codes);
				
				echo $cd;
				
			} else {
				echo "error occured on fetching chapters";
			}
		} else {
			echo "error in fetching chapters";
		} //end check book url
	
	
} else {
	echo "The wattcode is not valid or the page is no longer available.";
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