<?php
	function statusKnown($user, $apiKey, $twitterusername, $data){
		$url = "https://".$user.".withknown.com/status/edit";
		$data = "syndication%5B%5D=twitter%3A%3A".$twitterusername."&body=".$data;
		$sig = base64_encode(hash_hmac("sha256","/status/edit",$apiKey,true));

		$post = curl_init();
		curl_setopt($post, CURLOPT_URL, $url);
		curl_setopt($post, CURLOPT_POST, true);
		curl_setopt($post, CURLOPT_POSTFIELDS, $data);
		curl_setopt($post, CURLOPT_COOKIEJAR, "known_cookies.txt");  //initiates cookie file if needed 
    		curl_setopt($post, CURLOPT_COOKIEFILE, "known_cookies.txt");  // Uses cookies from previous session if exist 
		curl_setopt($post, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($post, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($post, CURLOPT_HTTPHEADER, array(
			'Accept: application/json',
			'X-KNOWN-USERNAME: '.$user,
			'X-KNOWN-SIGNATURE: '.$sig
		));
		$result = curl_exec($post);
		// $returningdata = curl_getinfo($post);
		curl_close($post);
		// return $returningdata;
		return $result;
	}

	// Make sure you specify the username, api_key and status message here -
	$result = statusKnown('username','api_key','twitterusername','status post');
	$obj_a = json_decode($result, true);
	print_r ($obj_a);
	echo "\n";
?>
