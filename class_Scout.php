<?php
class Scout extends Common {
	private $playerInfo;
	private $server;
	private $key;
	private $barbLevel;
	private $total;
	private $quota;
	private $lvl = array(
		"6"		=> "1",
		"5"		=> "2",
		"4"		=> "3",
		"3"		=> "4",
		"2"		=> "5",
		"1"		=> "6",
		"7"		=> "7",
		"8"		=> "8",
		"9"		=> "9",
		"10"	=> "10");


	public function __construct($server,$key,$playerInfo){
		$this->playerInfo 	= $playerInfo;
		$this->server 		= $server;
		$this->key 			= $key;
	}

	public function scoutBarb($barbLevel,$quota=0){
		$this->barbLevel=$this->lvl[$barbLevel];
		$this->quota = $quota;
		$this->total = 1;
		$timer = time();
		for($x=1;$x<275;$x=$x+7){
			for($y=1;$y<275;$y=$y+7){
				# Show something working
				if($y%10==0){
					echo gmdate("H:i:s", time()-$timer);
					echo "\n".$this->total." Done\n";
				}
				#echo "------".$x." : ".$y."\n";
				$map = $this->readMap($x,$y);
				$this->sendScout($map,$x,$y);
			}
		}
	}

	private function readMap($x,$y){
		$time = time();
		readMap:
		$map = @file_get_contents($this->server."game/api_world_map.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$this->key."&x=".$x."&y=".$y."&_l=en&_p=RE");
		if (!(strpos($map,'})') !== false)) {
		    goto readMap;
		}
		parent::setTime($time);
		$var = parent::stripTojSon($map);
		return $var['ret']['map'];
	}

	private function sendScout($map,$x,$y){
		for($ctr=0;$ctr<count($map);$ctr++){
			if(($map[$ctr][2]==$this->barbLevel) &&($map[$ctr][3][0]>=$this->quota)) {
				sendScout:
				$time = time();
				$var = @file_get_contents($this->server."game/armament_action_task_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$this->key."&city=".$this->playerInfo['ret']['user']['city'][0]['id']."&action=do_war&attack_type=3&tai_num=1&area=".$map[$ctr][0]."&area_x=".$map[$ctr][1]."&carry=52&cost_food=20&cost_wood=0&cost_iron=0&cost_gold=0&distance=25440&travel_sec=120&_l=en&_p=RE");
				if (!(strpos($var,'})') !== false)) {
				    goto sendScout;
				}
				parent::setTime($time);
				$var = parent::stripTojSon($var);
				if($var['code']==2544){
					echo "\nYou don't have enough scout in your first City\n";
					die();
				}else{
					$this->total++;
				}
			}
		}
	}

}
?>