<?php
/**  
 * Basically do a curl_exec() and return the transfer to the page 
 * 
 * @param 	$url 					string The webpage to curl 
 * @param 	$find_string 	string The search query 
 * @return 	$data					array  An array containing the URL and the number of search results found. False if failure. 
*/ 
function do_curl( $url, $find_string, $show = false ) { 
	$ch = curl_init($url);
		
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true ); 
	
	$curl_result = curl_exec($ch);
	
	$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	
	if ( $code == 200 ) { 
		// find string in webpage
		$haystack = $curl_result;  
		$needle = $find_string; 
		
		$count = 0; 
		
		while ( is_int(strpos($haystack, $needle)) ) { 
			$substr = substr( $haystack, strpos($haystack, $needle), strlen($needle) );
			$haystack = substr( $haystack, strpos($haystack, $needle)+strlen($needle) ); 	
			$count++; 	
		} 
		
		echo "<h1>Curl Results</h1>"; 
		echo "<p>Curl: <strong>$url</strong></p>"; 
		echo "<p>HTTP Code: $code</p>"; 
		echo "<p>Find String: \"$find_string\"</p>"; 
		echo "<p>Found $count occurrences of $find_string.</p>"; 
		
		if ( $show ) 
			echo $curl_result; 
			
		curl_close($ch);
		
		$array = array( "find_string" => $find_string, "url" => $url, "num" => $count ); 
		
		return $array; 
		
	} else { 
		echo "<p>Web host responded with a code $code. You might want to check the URL.</p>"; 
		return false;   
	} 
} 


if ( isset($_REQUEST['url']) ) { 
	$url = "http://" . $_REQUEST['url']; 
} else { 
	$url = "http://www.orgasm.com/free-porn-blog/"; 
} 

if ( isset($_REQUEST['search']) ) { 
	$find_string = $_REQUEST['search'];  
} else { 
	$find_string = "foo"; 
} 

do_curl( $url, $find_string, true ); 
 

//$response = do_curl( "http://www.orgasm.com/free-porn-blog/page/2/", "Porn" ); 
/* 
$page = 2; 
$url = "http://www.orgasm.com/free-porn-blog/page/$page/"; 

while ( $response = do_curl($url, "index.html") ) { 
	$page++; 
	$url = "http://www.orgasm.com/free-porn-blog/page/$page/"; 
	
	if ( is_array($response) ) { 
		$log = "log.txt"; 
		$fh = fopen($log, 'a') or die("Can't open file");
		if ( $response['num'] > 0 ) { 
			// log that we have found some search results 
			$newline = "[{$response['find_string']}] - [{$response['num']}] - {$response['url']}\n";
			fwrite($fh, $newline); 
			fclose($fh);
		}  
	} 
} 
*/ 







































