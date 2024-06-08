<?php

#hey is this Dmalf from roman empire/emross? if so, we used to play together toward the end there, and I was wondering if you still had the code for holy crusades and such? I really want to work on it because I want to play these damn games again lol
class Alliance extends Common {
	public $playerInfo;
	public $server;
	public $key;

	public function __construct($server,$key,$playerInfo){
		$this->playerInfo 	= $playerInfo;
		$this->server 		= $server;
		$this->key 			= $key;
	}

	public function donate($techId,$hall=1,$amount=1000000){
		donate:
		$time = time();
		$var = @file_get_contents($this->server."game/api_union_info.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$this->key."&op=tdonate&num=".$amount."&techid=".$techId."&city=".$this->playerInfo['ret']['user']['city'][0]['id']."&_l=en&_p=RE");
		if (!(strpos($var,'})') !== false)) {
			echo "\n".$var."\n";
		    goto donate;
		}
		
		#Uncomment this part to donate to hall
		if($hall==1){
			donate2:
			$time = time();
			$var = @file_get_contents($this->server."game/api_union_info.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$this->key."&op=donate&num=".$amount."&city=".$this->playerInfo['ret']['user']['city'][0]['id']."&_l=en&_p=RE");
			if (!(strpos($var,'})') !== false)) {
				#echo "\n".$var."\n";
			    goto donate2;
			}	
		}

	}
}
?>