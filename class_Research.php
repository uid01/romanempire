<?php
class Research extends Common {
	public function __construct($server,$key,$playerInfo){
		$this->playerInfo 	= $playerInfo;
		$this->server 		= $server;
		$this->key 			= $key;
		$this->rInfo 		= "JayBau";

		// Get Research Levels
		start:
		$time = time();
		$var = @file_get_contents($this->server."game/study_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$this->key."&city=".$this->playerInfo['ret']['user']['city'][0]['id']."&_l=en&_p=RE");
		if (!(strpos($var,'})') !== false)) {
		    goto start;
		}
		parent::setTime($time);
		$var = parent::stripTojSon($var);
		if($var['code']!=903){
			$this->rInfo = $var['ret'];
		}
	}

	public $techCode = array(
		"Forging"			=> 1,
		"Marching"			=> 2,
		"Scouting"			=> 3,
		"Logistics"			=> 4,
		"EfficientTraning"	=> 5,
		"AdvancedWeapon"	=> 6,
		"AdvancedArmor"		=> 7,
		"Taming"			=> 8,
		"DefenseFacility"	=> 9,
		"HeavyEquipment"	=> 10,
		"Targeting"			=> 11,
		"Mining"			=> 12,
		"Logging"			=> 13,
		"Alchemy"			=> 14,
		"Agriculture"		=> 15,
		"Masonry"			=> 16,
		"Artifact"			=> 17,
		"AttackFormation"	=> 18,
		"DefenseFormation"	=> 19,
		"Collection"		=> 20,
		"Enahancement"		=> 21,
		"Rescue"			=> 22,
		"Resurrection"		=> 23
		);


	private function checkrSlot($city){
		job:
		$time = time();
		$var = @file_get_contents($this->server."game/get_cdinfo_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$this->key."&city=".$city."&_l=en&_p=RE");
		if (!(strpos($var,'})') !== false)) {
		    goto job;
		}

		parent::setTime($time);
		$var = parent::stripTojSon($var);
		$research = 0;
		for($ctr=0;$ctr<count($var['ret']['cdlist']);$ctr++){
			if($var['ret']['cdlist'][$ctr]['cdtype']==2){
				$research++;
			}
		}
		if($research==0){
			return true;
		}
		return false;
	}

	private function getTechLevel($tech){
		for($ctr=0;$ctr<count($this->rInfo);$ctr++){
			if($this->rInfo[$ctr][0]==$tech){
				return $this->rInfo[$ctr][1];
			}
		}
		return 0;
	}

	public function researchTech($learn,$targetLevel){
		$tech = $this->techCode[$learn];
		if($this->rInfo!="JayBau"){
			# Check Tech level before upgrading
			if($this->getTechLevel($tech)<$targetLevel){
				# Check City where you can execute the upgrade
				for($ctr=0;$ctr<count($this->playerInfo['ret']['user']['city']);$ctr++){
					if($this->checkrSlot($this->playerInfo['ret']['user']['city'][$ctr]['id'])){
						$this->upgradeTech($tech,$this->playerInfo['ret']['user']['city'][$ctr]['id']);
						break;
					}
				}
			}
		}
	}

	private function upgradeTech($tech,$city){
		upgrade:
		$time = time();
		$var = @file_get_contents($this->server."game/study_mod_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$this->key."&city=".$city."&tech=".$tech."&_l=en&_p=RE");
		if (!(strpos($var,'})') !== false)) {
		    goto upgrade;
		}
	}

}



?>