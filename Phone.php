<?php
	require_once __DIR__ . "/TextMe.php";


	 $ne = new TextMe();

	 if (isset($_REQUEST["verification_token"], $_REQUEST["email"]))
	 {
	 	$data = explode(":", file_get_contents("http://example.com/save/".$_REQUEST["email"].".txt"));
	 	$o = $ne->signupWithToken($_REQUEST["verification_token"], $data[2], $data[0], $data[1], $data[3]);
	 	print_r($o);

	 } else {
	 	$ne->signup();
	 }



	 // if (isset($res->verification_url)){

	 // }
	
	