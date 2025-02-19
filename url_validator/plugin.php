<?php
/*
Plugin Name: URL Validity
Description: Validates long URL's for reachability and redirection
Version: 1.1.7
Author: Kevin Andrews
Author URI: https://github.com/Kev506/YOURLS-URL-Validity
*/

// No direct call
if( !defined( 'YOURLS_ABSPATH' ) ) die();
yourls_add_filter('shunt_add_new_link', 'check_url_exists');

function check_url_exists($is, $url, $keyword = '' , $title = '') {
    $return = false;

    if ( ! yourls_get_protocol( $url ) ) 
        	$url = 'https://'.$url;
        	
    // validate url
	if(filter_var($url, FILTER_VALIDATE_URL) === false ) {
		$return['status'] = 'fail';
		$return['code']   = 'error:invalid';
		
		/*Change this message to suit your specific requirements - 
		a simple message will suffice, unless you have updated
		the admin or public pages.*/
		$return['message'] = yourls__('<span style="font-size: 20px; font-weight: bold; color: red;">URL Validity: Invalid URL!
		    <br/><br/>Please go back and try again.</span>');
		    
		$return['statusCode'] = '404';
	}

	if ( $return == false || (stripos($url, "http://") !== 0 && stripos($url, "https://") !== 0)) {
         
         // Open curl connection
         $handle = curl_init($url);
            
         // Set curl parameter
         curl_setopt_array($handle, array(
            CURLOPT_FOLLOWLOCATION => 1,     
            CURLOPT_NOBODY => 1,            
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => 1,     
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_ENCODING => '',
	     	CURLOPT_CONNECTTIMEOUT => 4,   
			CURLOPT_TIMEOUT => 5           
         ));
        
         // Get the HTML or whatever is linked in $url.
         $response = curl_exec($handle);
            
         // Get the response code
         $httpCode = curl_getinfo($handle, CURLINFO_RESPONSE_CODE);
          
         // Close curl connection
         curl_close($handle);
		
	    if($httpCode !== 200) {
			$return['status']   = 'fail';
	        $return['code']     = 'error:url';
	        
	        /*Change this message to suit your specific requirements - 
	      	a simple message will suffice, unless you have updated
	    	the admin or public pages.*/
		    $return['message']  = yourls__( '<span style="font-size: 20px; font-weight: bold; color: red;">The URL is INVALID!
		    <br/><br/>Please go back and try again.</span>');
		    
		    $return['statusCode'] = 200; 
		}
	}
            
   return $return;
}