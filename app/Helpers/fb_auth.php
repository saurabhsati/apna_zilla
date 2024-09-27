<?php

function verify_fb_token($fb_access_token)
{
	/* 	
		Sample Error Response 
		{
		   "error": {
		      "message": "Invalid OAuth access token.",
		      "type": "OAuthException",
		      "code": 190,
		      "fbtrace_id": "AbiW2GSEsnw"
		   }
		}	

		---------------------------

		Sample Success Response 

		{
		   "name": "John K Smith",
		   "id": "1800895240137160"
		}

	*/	

	$fb_req = curl_init();
	curl_setopt($fb_req,CURLOPT_URL,"https://graph.facebook.com/me?access_token=".$fb_access_token);
	curl_setopt($fb_req,CURLOPT_RETURNTRANSFER,1);
	$response = curl_exec($fb_req);
	curl_close($fb_req);
	$arr_decoded_dara =  json_decode($response,TRUE);
	return !isset($arr_decoded_dara['error']);
}

