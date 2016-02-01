<?php
class Levelup extends Common {
	public $playerInfo;
	public $server;
	public $key;

	public function __construct($server,$key,$playerInfo){
		$this->playerInfo 	= $playerInfo;
		$this->server 		= $server;
		$this->key 			= $key;
	}

	public function createSpy($amount){
		start:
		$time = time();
		$var = @file_get_contents($this->server."game/gen_conscribe_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$this->key."&city=".$this->playerInfo['ret']['user']['city'][0]['id']."&action=gen_list&_l=en&_p=RE");
		if (!(strpos($var,'})') !== false)) {
		    goto start;
		}
		parent::setTime($time);
		$var = parent::stripTojSon($var);

		# Create spy
		if(count($var['ret']['hero'])>0){
			# http://s102.romanempire.com/game/soldier_educate_api.php?jsonpcallback=jsonp1454109660639&_=1454109667832&key=73c970d8e8fcf47bf39dbae1c9ec0010&city=xxxxxx&action=soldier_educate&soldier=2&num=2000&gen=203&_l=en&_p=RE-IPHONE-EN
			create:
			$time = time();
			$var = @file_get_contents($this->server."game/soldier_educate_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$this->key."&city=".$this->playerInfo['ret']['user']['city'][0]['id']."&action=gen_list&_l=en&_p=RE");
			if (!(strpos($var,'})') !== false)) {
			    goto create;
			}

			# Disband
			# http://s102.romanempire.com/game/soldier_educate_api.php?jsonpcallback=jsonp1454110415834&_=1454110419263&key=73c970d8e8fcf47bf39dbae1c9ec0010&city=xxxxxxxxxxx&action=disband&soldier_num2=2000&_l=en&_p=RE-IPHONE-EN
		}

	}
}
?>
