<?php
class Resources extends Common {
	public function __construct($server,$key,$playerInfo){
		$this->playerInfo 	= $playerInfo;
		$this->server 		= $server;
		$this->key 			= $key;
	}

	public function tradeWood($woodToSilver){
		$wood = $woodToSilver*17;
		wood:
		$time = time();
		$var = @file_get_contents($this->server."game/local_market_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$this->key."&city=".$city."&reso_put=giveput&g2w=&g2f=0&g2i=0&w2g=".$wood."&f2g=0&i2g=0&_l=en&_p=RE");
		if (!(strpos($var,'})') !== false)) {
		    goto wood;
		}
	}


	

	private function exchangeFood($city){
		xfood:
		$time = time();
		$var = @file_get_contents($this->server."game/local_market_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$this->key."&city=".$city."&reso_put=giveput&g2w=&g2f=".$this->xSilver."&g2i=&w2g=0&f2g=0&i2g=0&_l=en&_p=RE");
		if (!(strpos($var,'})') !== false)) {
		    goto xfood;
		}
	}

	private function exchangeWood($city){
		xwood:
		$time = time();
		$var = @file_get_contents($this->server."game/local_market_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$this->key."&city=".$city."&reso_put=giveput&g2w=".$this->xSilver."&g2f=&g2i=&w2g=0&f2g=0&i2g=0&_l=en&_p=RE");
		if (!(strpos($var,'})') !== false)) {
		    goto xwood;
		}
	}

	private function exchangeIron($city){
		xiron:
		$time = time();
		$var = @file_get_contents($this->server."game/local_market_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$this->key."&city=".$city."&reso_put=giveput&g2w=&g2f=&g2i=".$this->xSilver."&w2g=0&f2g=0&i2g=0&_l=en&_p=RE");
		if (!(strpos($var,'})') !== false)) {
		    goto xiron;
		}
	}

	public function exchangeSilver($xSilver,$floor){
		$this->xSilver = $xSilver;
		for($ctr=0;$ctr<count($this->playerInfo['ret']['user']['city']);$ctr++){
			start:
			$time = time();
			$var = @file_get_contents($this->server."game/get_cityinfo_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$this->key."&city=".$this->playerInfo['ret']['user']['city'][$ctr]['id']."&_l=en&_p=RE");
			if (!(strpos($var,'})') !== false)) {
			    goto start;
			}
			parent::setTime($time);
			$city = parent::stripTojSon($var);

			if($city['ret']['city'][2]<$xSilver){
				echo "\nInsuficient Silver in".$this->playerInfo['ret']['user']['city'][$ctr]['name']."\n";
			}
			else{
				# Exchange Food
				if($city['ret']['city'][4]<$floor){
					$this->exchangeFood($this->playerInfo['ret']['user']['city'][$ctr]['id']);
				}
				# Exchange Wood
				if($city['ret']['city'][6]<$floor){
					$this->exchangeWood($this->playerInfo['ret']['user']['city'][$ctr]['id']);
				}
				# Exchange Iron
				if($city['ret']['city'][8]<$floor){
					$this->exchangeIron($this->playerInfo['ret']['user']['city'][$ctr]['id']);
				}
			}
		}
	}
}

?>