<?php
class Broadcast extends Common {
	public $playerInfo;
	public $server;
	public $key;

	# 2544 - not emough army

	public function __construct($server,$key,$playerInfo){
		$this->playerInfo 	= $playerInfo;
		$this->server 		= $server;
		$this->key 			= $key;
	}


	public function announce(){
		announce:
		$time = time();
		$var = @file_get_contents($this->server."game/api_chat2.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$this->key."&targetid=0&targettype=0&txt=.&_l=en&_p=RE");
		if (!(strpos($var,'})') !== false)) {
		    goto announce;
		}
	}
}

?>