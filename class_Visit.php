<?php
class Visit extends Common {
	public function getGenerals($server,$key,$playerInfo,$hero){
		$this->server 	= $server;
		$this->key 		= $key;
		$this->aimRank	= $this->identifyHero($hero);
		$this->city 	= $playerInfo['ret']['user']['city']['0']['id'];
		$this->playerInfo = $playerInfo;

		start:
		$time = time();
		$var = @file_get_contents($this->server."game/gen_visit_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$this->key."&_l=en&_p=RE");
		if (!(strpos($var,'})') !== false)) {
		    goto start;
		}
		parent::setTime($time);
		$this->heroList = parent::stripTojSon($var);

		# Get Reward if there are five the same hero
		$this->getReward();

		# Do visit the target hero
		$this->visitHero();

		# TODO: Create a function that will validate if previous visited
		# hero are the same, else it will clear the list

	}

	private function visitHero(){
		# Get the hero list that a player can visit
		$genList = explode(",",$this->heroList['ret']['can_visit_list']);
		for($ctr=0;$ctr<count($genList);$ctr++){
			if (strpos($genList[$ctr],$this->aimRank) !== false) {
				start:
				$time = time();
				$var = @file_get_contents($this->server."game/gen_visit_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$this->key."&action=visit&visit_gen=".($ctr+1)."&city=".$this->city."&_l=en&_p=RE");
				if (!(strpos($var,'})') !== false)) {
				    goto start;
				}
			}
		}
	}

	private function getReward(){
		# Get the number of hero that you have visited
		$visitedList = explode(",",$this->heroList['ret']['visited_list']);
		#Claim 5 the same hero
		if(count($visitedList)==5){
			start:
			$time = time();
			$var = @file_get_contents($this->server."game/gen_visit_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$this->key."&action=getprice&price_type=5_same&_l=en&_p=RE");
			if (!(strpos($var,'})') !== false)) {
			    goto start;
			}
		}
		# 2_c 		- 1 Pair
		# 3_b_c_d 	- J,Q,K
		# 3_same	- Trio
		# 4_same	- 4 of a kind
		# 4_double	- 2 Pair
		# 5_three	= Full House
		# 5_different = Straight
		# 5_all_same - Royal Flush
	}

	private function identifyHero($hero){
		if($hero=="10"){ return "e";}
		if($hero=="J") { return "d";}
		if($hero=="Q") { return "c";}
		if($hero=="K") { return "b";}
		if($hero=="A") { return "a";}
	}
}

?>