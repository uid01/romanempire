<?php
class Login extends Common {

	private $userName;
	private $password;
	private $loginURL;
	private $servers = array(
		"RE"=>"http://m.romanempire.com/",
		"EW"=>"http://m.emrosswar.com/"
		);
	private $serverURL;
	private $key;
	private $session = 1;

	public function __construct($userName,$password,$loginURL="RE"){
		$this->setUsername($userName);
		$this->setPassword($password);
		$this->setURL($loginURL);
	}

	private function setURL($loginURL){
		$this->loginURL = $loginURL;
	}

	private function setUsername($userName){
		$this->userName = $userName;
	}

	private function setPassword($password){
		$this->password = $password;
	}

	private function setServerURL($url){
		$this->serverURL = $url;
	}

	public function login(){
		$realName = $this->getRealUserName();
		if($realName['code']==0){
			$this->setServerURL($realName['ret']['server']);
			$this->loginToServer($realName);
		}else{
			#echo "\nInvalid Username/Password\n";
			$this->session = 0;
		}
	}

	public function getServer(){
		return $this->serverURL;
	}

	public function getSession(){
		return $this->session;
	}

	private function setKey($key){
		$this->key = $key;
	}

	public function getKey(){
		return $this->key;
	}

	private function loginToServer($realName){
		login:
		$time = time();
		$var = @file_get_contents($realName['ret']['server']."game/login_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&username=".$realName['ret']['user']."&password=".$this->password."&picture=&session=temp&_l=en&_p=RE");
		if (!(strpos($var,'})') !== false)) {
		    goto login;
		}
		parent::setTime($time);
		$var = parent::stripTojSon($var);
		if($var['code']==0){
			$this->setKey($var['ret']['key']);
		}else{
			#echo "\nInvalid Password for ".$this->userName."\n";
			$this->session = 0;
		}
	}

	private function getRealUserName(){
		start:
		$time = time();
		$var = @file_get_contents($this->servers[$this->loginURL]."info.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&user=".urlencode($this->userName)."&action=login&pvp=0&_l=en&_p=RE");
		if (!(strpos($var,'})') !== false)) {
		    goto start;
		}
		parent::setTime($time);
		return parent::stripTojSon($var);
	}

}

?>