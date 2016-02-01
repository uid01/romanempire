<?php
class BuyDrink extends Common {
	public function __construct($playerInfo){
		$this->playerInfo = $playerInfo;
	}
	public function buyNow($server,$key){
		$this->server 	= $server;
		$this->key 		= $key;	
		# Buy Drinks for all City
		for($ctr=0;$ctr<count($this->playerInfo['ret']['user']['city']);$ctr++){
			start:
			$time = time();
			$var = @file_get_contents($this->server."game/gen_conscribe_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$this->key."&city=".$this->playerInfo['ret']['user']['city'][$ctr]['id']."&action=pub_process&_l=en&_p=RE");
			if (!(strpos($var,'})') !== false)) {
			    goto start;
			}
		}
	}

}
?>