<?php 
class Trade extends Common {
	public $playerInfo;
	public $server;
	public $key;

	# For Alliance money making
	private function checkSilver(){
		checkSilver:
		$time = time();
		$var = @file_get_contents($this->server."game/get_cityinfo_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$this->key."&city=".$this->playerInfo['ret']['user']['city'][0]['id']."&_l=en&_p=RE");
		if (!(strpos($var,'})') !== false)) {
		    goto checkSilver;
		}

		parent::setTime($time);
		$var = parent::stripTojSon($var);
		//print_r($var['ret']['city'][2]);die();
		if($var['ret']['city'][2]<5000000){
			return false;
		}
		else{
			return true;
		}
	}

	private function checkTrade(){
		cTrade:
		$time = time();
		$var = @file_get_contents($this->server."game/safe_goods_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$this->key."&action=list_auction_item&type=&city=".$this->playerInfo['ret']['user']['city'][0]['id']."&page=1&_l=en&_p=RE");
		if (!(strpos($var,'})') !== false)) {
			echo "\n".$var."\n";
		    goto cTrade;
		}
		parent::setTime($time);
		$var = parent::stripTojSon($var);
		if(count($var['ret']['item'])==0){
			return true;
		}
		else{
			return false;
		}
	}

	public function shopAndTrade($value){
		if($this->checkTrade()){
			//echo $this->checkSilver();die();
			if($this->checkSilver()==false){
				#die("less");
				shop:
				$time = time();
				$var = @file_get_contents($this->server."game/sys_shop_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$this->key."&action=purchase&type=1&city=".$this->playerInfo['ret']['user']['city'][0]['id']."&id=73&_l=en&_p=RE");
				if (!(strpos($var,'})') !== false)) {
					echo "\n".$var."\n";
				    goto shop;
				}
				parent::setTime($time);
				$var = parent::stripTojSon($var);

				pTrade:
				$time = time();
				$var = @file_get_contents($this->server."game/safe_goods_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$this->key."&action=my_goods_safe&city=".$this->playerInfo['ret']['user']['city'][0]['id']."&id=".$var['ret']['itemid']."&safe_num=1&price=".$value."&player_pname=&_l=en&_p=RE");
				if (!(strpos($var,'})') !== false)) {
					echo "\n".$var."\n";
				    goto pTrade;
				}

				beg:
				$time = time();
				$var = @file_get_contents($this->server."game/api_chat2.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$this->key."&targetid=".$this->playerInfo['ret']['user']['guildid']."&targettype=1&txt=".time()."%20Bot%20donator%20here%20please%20%20buy%20my%20spear%20worth%20".$value."%20check%20trade%20in%2015mins&_l=en&_p=RE");
				if (!(strpos($var,'})') !== false)) {
					echo "\n".$var."\n";
				    goto beg;
				}
				
			}
		}
	}

	public function beg($value){
		beg:
		$time = time();
		$var = @file_get_contents($this->server."game/api_chat2.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$this->key."&targetid=199&targettype=1&txt=".time()."%20can%20someone%20please%20buy%20my%20spear%20worth%20".$value."%20please%20check%20in%2015mins&_l=en&_p=RE");
		if (!(strpos($var,'})') !== false)) {
			echo "\n".$var."\n";
		    goto beg;
		}
	}
	# End of 	# For Alliance money making

	public function __construct($server,$key,$playerInfo){
		$this->playerInfo 	= $playerInfo;
		$this->server 		= $server;
		$this->key 			= $key;
	}

	public function buyItem($price){
		$tradeList = $this->getTradeList($price);
		for($ctr=0;$ctr<count($tradeList);$ctr++){
			if($tradeList[$ctr][2]<$price){
				if($this->getSilver()>$price){
					$this->buyNow($tradeList[$ctr][0]);
					echo "Normal Buy\n";
				}
			}
		}
	}

	public function sell($sellItem){
		sell:
		$time = time();
		$var = @file_get_contents($this->server."game/goods_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$this->key."&action=goods_list&type=6&page=1&_l=en&_p=RE");
		if (!(strpos($var,'})') !== false)) {
		    goto sell;
		}
		parent::setTime($time);
		$var = parent::stripTojSon($var);
		#print_r($var['ret']['item']);die();
		for($ctr=0;$ctr<count($var['ret']['item']);$ctr++){
			if($var['ret']['item'][$ctr]['item']['name']==$sellItem){
				#echo $var['ret']['item'][$ctr]['item']['id']."\n";
				$this->saleNow($var['ret']['item'][$ctr]['item']['id']);
			}
		}
		die();
	}

	private function saleNow($itemid){


		sell2:
		$time = time();
		$var = @file_get_contents($this->server."game/goods_mod_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$this->key."&action=sale&city=327552&id=".$itemid."&num=1&_l=en&_p=RE");
		if (!(strpos($var,'})') !== false)) {
		    goto sell2;
		}
		echo "Sold ".$itemid."\n";

	}

	public function forceBuyItem($price){
		$tradeList = $this->getTradeList($price);
		for($ctr=0;$ctr<count($tradeList);$ctr++){
			if($tradeList[$ctr][2]<$price){
				$this->buyNow($tradeList[$ctr][0]);
				#$myfile = @fopen("buy.txt", "a") or die("Unable to open file!\n");
				#fwrite($myfile, $tradeList[$ctr][0]."\n");
				#fclose($myfile);
				echo "Bought: ".$tradeList[$ctr][0]."\n";
			}
		}
	}

	private function buyNow($itemId){
		buy:
		$time = time();
		$var = @file_get_contents($this->server."game/safe_market_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$this->key."&action=purchasing&city=".$this->playerInfo['ret']['user']['city'][0]['id']."&id=".$itemId."&type=1&page=1&_l=en&_p=RE");
		if (!(strpos($var,'})') !== false)) {
			echo "\n".$var."\n";
		    goto buy;
		}
	}

	private function getSilver(){
			checkSilver:
			$time = time();
			$var = @file_get_contents($this->server."game/get_cityinfo_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$this->key."&city=".$this->playerInfo['ret']['user']['city'][0]['id']."&_l=en&_p=RE");
			if (!(strpos($var,'})') !== false)) {
			    goto checkSilver;
			}
			parent::setTime($time);
			$var = parent::stripTojSon($var);
			return $var['ret']['city'][2];
	}

	private function getTradeList($price){
		lister:
		$time = time();
		$var = @file_get_contents($this->server."game/safe_market_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$this->key."&type=1&page=1&_l=en&_p=RE");
		if (!(strpos($var,'})') !== false)) {
		    goto lister;
		}
		parent::setTime($time);
		$var = parent::stripTojSon($var);
		return $var['ret']['item'];
	}

}
?>