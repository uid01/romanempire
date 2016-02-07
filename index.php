<?php
include("class_Common.php");
include("class_PlayerInfo.php");
include("class_Visit.php");
include("class_BuyDrink.php");
include("class_Gift.php");
include("class_Resources.php");
include("class_Builder.php");
include("class_Research.php");
include("class_Trade.php");
include("class_Scout.php");
include("class_Favorites.php");
include("class_Alliance.php");
include("class_Login.php");


$users = array(
	array('UserName1','PassWord'),
	array('UserName2','PassWord'),
	array('UserName3','PassWord'),
	array('UserName4','PassWord'),
	array('UserName5','PassWord'),
	array('UserName6','PassWord'),
	array('UserName7','PassWord'),
	array('UserName8','PassWord'),
	array('UserName9','PassWord'),
	array('UserName0','PassWord'));

for($ctr=0;$ctr<count($users);$ctr++){
	#echo "###Script Started for user ".$users[$ctr][0]."###\n";
	$session = new Login($users[$ctr][0],$users[$ctr][1],"RE");
	$session->login();

	if($session->getSession()!=0){
		$key = $session->getKey();
		$server = $session->getServer();
		#echo "Successfully logged in\n";

		#Get Player's information
		$player = new PlayerInfo();
		$playerInfo = $player->getInfo($server,$key);
		#echo "Player information retrieved\n";

		#if($ctr!=0){
		# initiate trade to alliance 
		$shop = new Trade($server,$key,$playerInfo);
		$value = array("5000001","5111111","5222221","5333331","5555551","5666661","5777771","5888881","5999991");
		$value = $value[mt_rand(0, count($value) - 1)];
		$shop->shopAndTrade($value);
		#echo "Checked trade criteria\n";

		# Donate to Alliance
		$donate = new Alliance($server,$key,$playerInfo);
		$donate->donate(20,0);
		#echo "Donates to alliance hall and tech\n";
		#}

		# Daily Gift
		$gift = new Gift();
		$gift->getDailyGift($server,$key,$playerInfo);
		#$gift->getWeeklyGift($server,$key,$playerInfo);
		#echo "Gift claimed\n";

		# Visit and get Reward
		# 10,J,Q,K,A
		$visit = new Visit();
		$heros = $visit->getGenerals($server,$key,$playerInfo,"Q");
		#echo "Check for Visits\n";

		# Buy Drink for all City
		$drink = new BuyDrink($playerInfo);
		$drink->buyNow($server,$key);
		#echo "Bought drink for all castles\n";

		# Maintain resource amount
		$x = new Resources($server,$key,$playerInfo);
		// This will exchange 1m silver if a specific resource is lower than 20m for all the city
		$x->exchangeSilver(1000000,20000000);
		#echo "Check the needs of resource and trade\n";
		
		# Build City Structures
		$build = new Builder($server,$key,$playerInfo);
		#$build->upgradeLumberMill(1);
		#$build->upgradeFarmLands(1);
		#$build->upgradeIronMines(1);
		$build->upgradeConstructionBureau(20);
		#$build->upgradeArena(4);
		$build->upgradeHouses(15);
		$build->upgradeTrainCourt(30);
		$build->upgradeAcademy(30);
		$build->upgradeWall(20);
		#echo "Set Building upgrades\n";

		# Research Facility
		$r = new Research($server,$key,$playerInfo);
		// this will research Forging until it reaches level 20 and so
		$r->researchTech("Forging",10);	
		$r->researchTech("Marching",10);	
		$r->researchTech("Scouting",10);	
		$r->researchTech("Logistics",6);	
		$r->researchTech("EfficientTraning",20);	
		$r->researchTech("AdvancedWeapon",20);	
		$r->researchTech("AdvancedArmor",20);	
		$r->researchTech("Taming",10);	
		$r->researchTech("DefenseFacility",20);	
		#$r->researchTech("HeavyEquipment",20);	$r->researchTech("Masonry",20);	$r->researchTech("Artifact",20);	$r->researchTech("AttackFormation",20);	$r->researchTech("DefenseFormation",20);	$r->researchTech("Collection",20);	$r->researchTech("Enahancement",20);	$r->researchTech("Rescue",20);	$r->researchTech("Resurrection",20);
		#echo "Set Tech upgrades\n";
		echo $playerInfo['ret']['user']['pvp']. "###Script completed for user ".$users[$ctr][0]."###\n";

	}else{
		echo "######################################################\n";
		echo "###Invalid Password for user ".$users[$ctr][0]."###\n";
		echo "######################################################\n";
	}
}
?>