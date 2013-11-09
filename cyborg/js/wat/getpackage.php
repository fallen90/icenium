<?php

	include_once("CreateZipFile.inc.php");
	$wattcode=$_POST['wattcode'];
	$bookid = getID($wattcode);
		if($bookid =="NOT_FOUND"){
			$bookid = getID($wattcode);
		}
	$accesscode = $_POST['accesscode'];
	$chapters = json_decode($_POST['chapters'],true);
	$builds = "./". $accesscode . "/builds/" . $bookid . "/";
	$build_folder = "./". $accesscode . "/builds/";
	$root_folder = "./wat/" . $accesscode  . "/builds/";
	 if(!file_exists($build_folder . "packages/")){
		mkdir($build_folder . "packages/",0777,true);
	 }
	if(file_exists($builds)){
	$contents = "";
		foreach($chapters as $index=>$chapter){
			if(file_exists($builds.$chapter.".txt")){
				$contents .= file_get_contents($builds . $chapter . ".txt");
				rename($builds . $chapter . ".txt", $builds . $index . ".txt");
			} else if(file_exists($builds.$index.".txt")){
				$contents .= file_get_contents($builds . $index . ".txt");
			} else {
				echo "ONE_FILE_NOT_FOUND:" . $chapter;
				exit();
			}
		}
		file_put_contents($build_folder . "FULL_STORY_" .$bookid.".txt",$contents);
		
		$files_to_zip = glob($builds . "/*.*");
		array_push($files_to_zip,$build_folder . "FULL_STORY_" .$bookid.".txt");
		echo zipped($files_to_zip,$build_folder . "packages/",$bookid);
		
		
	} else {
		echo "BUILDS_NOT_FOUND<br>";
		print_r($_POST);
	}
	

	function zipped($files,$destination,$filename){
		global $root_folder;
		$createZipFile=new CreateZipFile;
		$rand=md5(microtime().rand(0,999999));
		$zipName=$destination.$rand . $filename . "_FULLPACKAGED.zip";
		
		foreach($files as $file){
			$fileContents=file_get_contents($file);
			$createZipFile->addFile($fileContents, basename($file));
		}	
		$fd=fopen($zipName, "wb");
		$out=fwrite($fd,$createZipFile->getZippedfile());
		fclose($fd);
		return $root_folder . "packages/" . basename($zipName);
		
		
	}	
	function getID($wattpadcode) {
	$chapter_url_data = doCurl("http://m.wattpad.com/go?id=" . $wattpadcode);

	if (strpos($chapter_url_data, 'gopart.php?id=') !== false) {

		preg_match("/gopart.php.id=([0-9]+)/", $chapter_url_data, $bookid);

		if (is_array($bookid) && isset($bookid[1])) {
			//good
			$bookid = $bookid[1];
			return $bookid;
		} else {
			return false;
		}
	} else {
		return "NOT_FOUND";
	} //end check chapter url

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