<?php
// a url can be passed via GET 
if ( isset($_REQUEST['url']) ) { 
	$url = "http://" . $_REQUEST['url']; 
} else { 
	$url = "http://www.orgasm.com/free-porn-blog/"; 
} 

// a url can be passed via GET 
if ( isset($_REQUEST['search']) ) { 
	$find_string = $_REQUEST['search'];  
} else { 
	$find_string = "foo"; 
} 

$ch = curl_init($url);


file_put_contents("results.txt", "");

$fp = fopen("results.txt", "w");

curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_HEADER, 0);

$curl_result = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

$webpage = file_get_contents( "results.txt" ); 

// find string in webpage
$haystack = $webpage;  
$needle = $find_string; 

$count = 0; 
while ( is_int(strpos($haystack, $needle)) ) { 
	$substr = substr( $haystack, strpos($haystack, $needle), strlen($needle) );
	$haystack = substr( $haystack, strpos($haystack, $needle)+strlen($needle) ); 	
	$count++; 	
} 

echo "<h1>Curl Results</h1>"; 
echo "<p>Curl: <strong>$url</strong></p>"; 
echo "<p>Status: $curl_result</p>"; 
echo "<p>HTTP Code: $httpCode</p>"; 
echo "<p>Find String: \"$find_string\"</p>"; 
echo "<p>Found $count occurrences of $find_string.</p>"; 

echo $webpage;  

curl_close($ch);
fclose($fp);





































