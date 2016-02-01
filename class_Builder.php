<?php
class Builder extends Common {
	public function __construct($server,$key,$playerInfo){
		$this->playerInfo 	= $playerInfo;
		$this->server 		= $server;
		$this->key 			= $key;

		// Get All City Information
		for($ctr=0;$ctr<count($this->playerInfo['ret']['user']['city']);$ctr++){
			start:
			$time = time();
			$var = @file_get_contents($this->server."game/get_cityinfo_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$this->key."&city=".$this->playerInfo['ret']['user']['city'][$ctr]['id']."&_l=en&_p=RE");
			if (!(strpos($var,'})') !== false)) {
			    goto start;
			}
			parent::setTime($time);
			$var = parent::stripTojSon($var);
			$var = $var['ret']['city'];
			array_push($var, $this->playerInfo['ret']['user']['city'][$ctr]['id']);
			$this->city[] = $var;
		}

		# Check if Bless of Building is enabled
		$this->blessed = false;
		for($ctr=0;$ctr<count($this->playerInfo['ret']['events']);$ctr++){
			if($this->playerInfo['ret']['events'][$ctr]['icon']=="gem.jpg"){
				$this->blessed = true;
				break;
			}
		}
	}

	private function checkSlot($city){
		job:
		$time = time();
		$var = @file_get_contents($this->server."game/get_cdinfo_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$this->key."&city=".$city."&_l=en&_p=RE");
		if (!(strpos($var,'})') !== false)) {
		    goto job;
		}
		parent::setTime($time);
		$var = parent::stripTojSon($var);
		$build = 0;
		for($ctr=0;$ctr<count($var['ret']['cdlist']);$ctr++){
			if($var['ret']['cdlist'][$ctr]==1 || $var['ret']['cdlist'][$ctr]==0){
				$build++;
			}
		}
		if($build<=1 && $this->blessed==true){
			return true;
		}
		if($build==1 && $this->blessed==false){
			return false;
		}
		return false;
	}

	# $this->setLumberMill($city['ret']['city'][12]);
	public function upgradeLumberMill($level){
		$slot = false;
		for($ctr=0;$ctr<count($this->city);$ctr++){
			$slot = $this->checkSlot($this->city[$ctr][25]);
			if($this->city[$ctr][12]<$level && $slot==true){ 
				$this->lumberMill($this->city[$ctr][25]); 
			}
			$slot = false;
		}
	}

	private function lumberMill($city){
		lumberMill:
		$time = time();
		$var = @file_get_contents($this->server."game/building_create_task_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$this->key."&city=".$city."&build_type=1&_l=en&_p=RE");
		if (!(strpos($var,'})') !== false)) {
		    goto lumberMill;
		}
	}

	# $this->setIronMines($city['ret']['city'][13]);
	public function upgradeIronMines($level){
		$slot = false;
		for($ctr=0;$ctr<count($this->city);$ctr++){
			$slot = $this->checkSlot($this->city[$ctr][25]);
			if($this->city[$ctr][13]<$level && $slot==true){ 
				$this->ironMines($this->city[$ctr][25]); 
			}
			$slot = false;
		}
	}

	private function ironMines($city){
		ironMines:
		$time = time();
		$var = @file_get_contents($this->server."game/building_create_task_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$this->key."&city=".$city."&build_type=2&_l=en&_p=RE");
		if (!(strpos($var,'})') !== false)) {
		    goto ironMines;
		}
	}

	#$this->setTaxHall($city['ret']['city'][14]);
	public function upgradeTaxHall($level){
		$slot = false;
		for($ctr=0;$ctr<count($this->city);$ctr++){
			$slot = $this->checkSlot($this->city[$ctr][25]);
			if($this->city[$ctr][14]<$level && $slot==true){ 
				$this->taxHall($this->city[$ctr][25]); 
			}
			$slot = false;
		}
	}
	private function taxHall($city){
		taxHall:
		$time = time();
		$var = @file_get_contents($this->server."game/building_create_task_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$this->key."&city=".$city."&build_type=3&_l=en&_p=RE");
		if (!(strpos($var,'})') !== false)) {
		    goto taxHall;
		}
	}

	# $this->setFarmLands($city['ret']['city'][15]);
	public function upgradeFarmLands($level){
		$slot = false;
		for($ctr=0;$ctr<count($this->city);$ctr++){
			$slot = $this->checkSlot($this->city[$ctr][25]);
			if($this->city[$ctr][15]<$level && $slot==true){ 
				$this->farmLands($this->city[$ctr][25]); 
			}
			$slot = false;
		}
	}
	private function farmLands($city){
		farmLands:
		$time = time();
		$var = @file_get_contents($this->server."game/building_create_task_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$this->key."&city=".$city."&build_type=4&_l=en&_p=RE");
		if (!(strpos($var,'})') !== false)) {
		    goto farmLands;
		}
	}

	# $this->setHouses($city['ret']['city'][16]);
	public function upgradeHouses($level){
		$slot = false;
		for($ctr=0;$ctr<count($this->city);$ctr++){
			$slot = $this->checkSlot($this->city[$ctr][25]);
			if($this->city[$ctr][16]<$level && $slot==true){ 
				$this->houses($this->city[$ctr][25]); 
			}
			$slot = false;
		}
	}
	private function houses($city){
		houses:
		$time = time();
		$var = @file_get_contents($this->server."game/building_create_task_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$this->key."&city=".$city."&build_type=5&_l=en&_p=RE");
		if (!(strpos($var,'})') !== false)) {
		    goto houses;
		}
	}

	# $this->setTrainCourt($city['ret']['city'][17]);
	public function upgradeTrainCourt($level){
		$slot = false;
		for($ctr=0;$ctr<count($this->city);$ctr++){
			$slot = $this->checkSlot($this->city[$ctr][25]);
			if($this->city[$ctr][17]<$level && $slot==true){ 
				$this->trainCourt($this->city[$ctr][25]); 
			}
			$slot = false;
		}
	}
	private function trainCourt($city){
		trainCourt:
		$time = time();
		$var = @file_get_contents($this->server."game/building_create_task_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$this->key."&city=".$city."&build_type=8&_l=en&_p=RE");
		if (!(strpos($var,'})') !== false)) {
		    goto trainCourt;
		}
	}

	# $this->setAcademy($city['ret']['city'][18]);
	public function upgradeAcademy($level){
		$slot = false;
		for($ctr=0;$ctr<count($this->city);$ctr++){
			$slot = $this->checkSlot($this->city[$ctr][25]);
			if($this->city[$ctr][18]<$level && $slot==true){ 
				$this->academy($this->city[$ctr][25]); 
			}
			$slot = false;
		}
	}
	private function academy($city){
		academy:
		$time = time();
		$var = @file_get_contents($this->server."game/building_create_task_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$this->key."&city=".$city."&build_type=9&_l=en&_p=RE");
		if (!(strpos($var,'})') !== false)) {
		    goto academy;
		}
	}

	# $this->setArena($city['ret']['city'][19]);
	public function upgradeArena($level){
		$slot = false;
		for($ctr=0;$ctr<count($this->city);$ctr++){
			$slot = $this->checkSlot($this->city[$ctr][25]);
			if($this->city[$ctr][19]<$level && $slot==true){ 
				$this->arena($this->city[$ctr][25]); 
			}
			$slot = false;
		}
	}
	private function arena($city){
		arena:
		$time = time();
		$var = @file_get_contents($this->server."game/building_create_task_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$this->key."&city=".$city."&build_type=10&_l=en&_p=RE");
		if (!(strpos($var,'})') !== false)) {
		    goto arena;
		}
	}

	# $this->setStorage($city['ret']['city'][20]);
	public function upgradeStorage($level){
		$slot = false;
		for($ctr=0;$ctr<count($this->city);$ctr++){
			$slot = $this->checkSlot($this->city[$ctr][25]);
			if($this->city[$ctr][20]<$level && $slot==true){ 
				$this->storage($this->city[$ctr][25]); 
			}
			$slot = false;
		}
	}

	private function storage($city){
		storage:
		$time = time();
		$var = @file_get_contents($this->server."game/building_create_task_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$this->key."&city=".$city."&build_type=11&_l=en&_p=RE");
		if (!(strpos($var,'})') !== false)) {
		    goto storage;
		}
	}

	# $this->setWall($city['ret']['city'][21]);
	public function upgradeWall($level){
		$slot = false;
		for($ctr=0;$ctr<count($this->city);$ctr++){
			$slot = $this->checkSlot($this->city[$ctr][25]);
			if($this->city[$ctr][21]<$level && $slot==true){ 
				$this->wall($this->city[$ctr][25]); 
			}
			$slot = false;
		}
	}
	private function wall($city){
		wall:
		$time = time();
		$var = @file_get_contents($this->server."game/building_create_task_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$this->key."&city=".$city."&build_type=12&_l=en&_p=RE");
		if (!(strpos($var,'})') !== false)) {
		    goto wall;
		}
	}

	# $this->setConstructionBureau($city['ret']['city'][22]);
	public function upgradeConstructionBureau($level){
		$slot = false;
		for($ctr=0;$ctr<count($this->city);$ctr++){
			$slot = $this->checkSlot($this->city[$ctr][25]);
			if($this->city[$ctr][22]<$level && $slot==true){ 
				$this->constructionBureau($this->city[$ctr][25]); 
			}
			$slot = false;
		}
	}
	private function constructionBureau($city){
		constructionBureau:
		$time = time();
		$var = @file_get_contents($this->server."game/building_create_task_api.php?jsonpcallback=jsonp".$time."&_=".($time+1485495)."&key=".$this->key."&city=".$city."&build_type=13&_l=en&_p=RE");
		if (!(strpos($var,'})') !== false)) {
		    goto constructionBureau;
		}
	}


}


?>