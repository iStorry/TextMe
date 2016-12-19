<?php
class TextMe

{
	protected $url = "https://api.textme-app.com/api";
	protected $bundle_id = "com.textmeinc.textme2.android";
	protected $version = "3.7.10";
	protected $appID = "00f00c000f00f0fd";
	protected $uuid = "00000a00-c000-0000-070e-000bdd0d000a";
	protected $rand = "https://api.randomuser.me/?nat=en";
	protected $ver = "3249f6f831d6ae44eb4ce0801530db8dfb699bce122e1f2dfdc171158aa756bf";
	protected $time = "1482126920015";
	protected $password;
	protected $mail;
	protected $username;
	protected 
	function randuser()
	{
		return json_decode(file_get_contents($this->rand));
	}


	public
	function __construct()
	{
		$this->gen($this->appID);
		$this->gen($this->uuid);
		$this->gen($this->time);
	}
	public
	function signup()
	{
		$this->password = urlencode($this->randuser()->results[0]->login->password) . "1onn";
		$this->username = $this->randuser()->results[0]->login->username;
		$this->email = $this->randuser()->results[0]->email;
		$post = "username=".$this->username."&password=" . $this->password . "1on&email=" . $this->email . "&device_uid=$this->uuid";
		$results =  $this->execute($this->url() , $post, $this->header($post));
		if (isset($results->token))
		{
			echo json_encode(array("email" => $this->email, "password" => $this->password, "username" => $this->username, "token" => $results->token));
		} else {
			$file = fopen("save/".$this->email.".txt", "w") or die("Unable to open file!");
			$txt = $this->email.":".$this->password.":".$this->username.":".$this->uuid;
			fwrite($file, $txt);
			fclose($file);
			header("Location: ".$results->verification_url."&redirect=http://example.com/TextMe/Phone.php?email=".$this->email);

		}
	}

	public
	function signupWithToken($token, $username, $email, $password, $uuid)
	{
		$post = "username=".$username."&password=" . $password . "&email=" . $email . "&device_uid=".$uuid."&verification_token=".$token;
		$results =  $this->execute($this->url() , $post, $this->header($post));
		
	}


	public

	function url()
	{
		return $url = $this->url . "/signup/?device_uid=" . $this->uuid . "&android_id=" . $this->appID . "&app_version=" . $this->version . "&bundle_id=" . $this->bundle_id;
	}

	protected
	function header($post)
	{
		$arr = array();
		$arr[] = "User-Agent: TextMe/3.7.10 (Android 5.1.1; HTC One X;)";
		$arr[] = "X-HGYVER: " . $this->gen($this->ver);
		$arr[] = "X-BUNDLE-ID: " . $this->bundle_id;
		$arr[] = "X-TIMESTAMP: " . $this->time;
		$arr[] = "Content-Type: application/x-www-form-urlencoded; charset=UTF-8";
		$arr[] = "Host: api.textme-app.com";
		$arr[] = "Connection: Keep-Alive";
		$arr[] = "Accept-Encoding: gzip";
		$arr[] = "Content-Length: " . strlen($post);
		return $arr;
	}

	public

	function captcha($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Host: api.textme-app.com'));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$server_output = curl_exec($ch);
		return $server_output;
	

	}
	public

	function execute($url, $post, $customHeaders)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $customHeaders);
		curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$server_output = json_decode(curl_exec($ch));
		return $server_output;
	}

	protected
	function gen(&$s)
	{
		global $a;
		$len = strlen($s);
		for ($i = 0; $i < $len; $i++) {
			if ($s[$i] == '-') continue;
			if ($s[$i] >= '0' && $s[$i] <= '9') $s[$i] = rand(1, 9);
			else
			if ($s[$i] >= 'A' && $s[$i] <= 'Z') $s[$i] = $a[rand(0, 25) ];
		}
	}
}

