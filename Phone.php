<?php
	require_once __DIR__ . "/TextMe.php";


	 $ne = new TextMe();

	 if (isset($_REQUEST["verification_token"], $_REQUEST["email"]))
	 {
	 	$data = explode(":", file_get_contents("http://istorry.com/TextMe/save/".$_REQUEST["email"].".txt"));
	 	$ne->signupWithToken($_REQUEST["verification_token"], $data[2], $data[0], $data[1], $data[3]);
	 	echo "Username : " . $data[2] . "<br>";
	 	echo "Email : " . $data[0] . "<br>";
	 	echo "Password : " . $data[1] . "<br>";
	 	echo "UUID : " . $data[3] . "<br>";

	 } else {
	 	$ne->signup();
	 }
