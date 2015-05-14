<?php
	function statusKnown($user, $apiKey, $data){
		$url = "https://".$user.".withknown.com/status/edit";
		$data = "body=".$data;
		$sig = base64_encode(hash_hmac("sha256","/status/edit",$apiKey,true));

		$post = curl_init();
		curl_setopt($post, CURLOPT_URL, $url);
		// curl_setopt($post, CURLOPT_CUSTOMREQUEST, "POST"); 
		curl_setopt($post, CURLOPT_POST, true);
		curl_setopt($post, CURLOPT_POSTFIELDS, $data);
		curl_setopt($post, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($post, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($post, CURLOPT_HTTPHEADER, array(
			'Accept: application/json',
			'X-KNOWN-USERNAME: '.$user,
			'X-KNOWN-SIGNATURE: '.$sig
		));
		$result = curl_exec($post);
		$returningdata = curl_getinfo($post);
		curl_close($post);
		return $returningdata;
	}

	// Make sure you specify the username, api_key and status message here -
	$result = statusKnown('username','api_key','status post');
	echo json_encode($result, JSON_PRETTY_PRINT);
	echo "\n";
?>
