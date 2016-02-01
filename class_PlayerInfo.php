<?php
class PlayerInfo extends Common {

	public function getInfo($server,$key){
		$time = time();
		start:
		$playerInfo = @file_get_contents($server."game/get_userinfo_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$key."&_l=en&_p=RE");
		if (!(strpos($playerInfo,'})') !== false)) {
		    goto start;
		}
		parent::setTime($time);
		return $this->playerInfo = parent::stripTojSon($playerInfo);
	}

} 