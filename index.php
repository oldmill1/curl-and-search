<?php
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

function do_curl( $url, $find_string ) { 
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
		
		echo $curl_result; 
		
		curl_close($ch);
		
	} else { 
		die("<p>Web host responded with a code $code. You might want to check the URL.</p>");  
	} 
} 

do_curl( $url, $find_string ); 








































