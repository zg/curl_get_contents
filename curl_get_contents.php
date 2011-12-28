<?php
function curl_get_contents($url,array $post_data=array(),$verbose=false,$ref_url=false,$cookie_location=false,$return_transfer=true)
{
	$return_val = false;
 
	$pointer = curl_init();
 
    curl_setopt($pointer, CURLOPT_URL, $url);
	curl_setopt($pointer, CURLOPT_TIMEOUT, 40);
	curl_setopt($pointer, CURLOPT_RETURNTRANSFER, $return_transfer);
	curl_setopt($pointer, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.10 (KHTML, like Gecko) Chrome/8.0.552.28 Safari/534.10");
	curl_setopt($pointer, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($pointer, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($pointer, CURLOPT_HEADER, false);
	curl_setopt($pointer, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($pointer, CURLOPT_AUTOREFERER, true);
 
	if($cookie_location !== false)
	{
		curl_setopt($pointer, CURLOPT_COOKIEJAR, $cookie_location);
		curl_setopt($pointer, CURLOPT_COOKIEFILE, $cookie_location);
		curl_setopt($pointer, CURLOPT_COOKIE, session_name() . '=' . session_id());
	}
 
	if($verbose !== false)
	{
		$verbose_pointer = fopen($verbose,'w');
		curl_setopt($pointer, CURLOPT_VERBOSE, true);
		curl_setopt($pointer, CURLOPT_STDERR, $verbose_pointer);
	}
 
	if($ref_url !== false)
	{
	    curl_setopt($pointer, CURLOPT_REFERER, $ref_url);
	}
 
	if(count($post_data) > 0)
	{
	    curl_setopt($pointer, CURLOPT_POST, true);
	    curl_setopt($pointer, CURLOPT_POSTFIELDS, $post_data);
	}
 
	$return_val = curl_exec($pointer);
 
	$http_code = curl_getinfo($pointer, CURLINFO_HTTP_CODE);
 
	if($http_code == 404)
	{
		return false;
	}
 
	curl_close($pointer);
 
	unset($pointer);
 
	return $return_val;
}
?>