<?php
class Gift extends Common {

	public function getDailyGift($server,$key,$playerInfo){
		$time = time();
		start:
		$gift = @file_get_contents($server."game/goods_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$key."&action=gift&id=168&_l=en&_p=RE");
		if (!(strpos($gift,'})') !== false)) {
		    goto start;
		}
		parent::setTime($time);
		return $this->gift = parent::stripTojSon($gift);
	}

	public function getWeeklyGift($server,$key,$playerInfo){
		$time = time();
		weekly:
		$gift = @file_get_contents($server."game/goods_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$key."&action=reward&actid=2&_l=en&_p=RE");
		if (!(strpos($gift,'})') !== false)) {
		    goto weekly;
		}
	}

}

?>