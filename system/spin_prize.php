<?php
	define('BASEPATH', true);
	define('IS_AJAX', true);
	require('init.php');
	
	/* 
		System is simple, will be extracted a random number between 0 and 10000
		Bellow are defined prizes chances, so if the number extracted in between minimum number and maximum number to any
		for the prizes from bellow, this will be the winning prize. Set lower chances for big prizes, making them more hard to be won.
	*/

	// Check user status, coins and last spin
	$spin_price = ($data['membership'] > 0 ? $config['wheel_vip_price'] : $config['wheel_free_price']);
	if(!$is_online || $data['coins'] < $spin_price || $data['last_spin'] > (time()-(3600*$config['wheel_waiting_time']))){ 
		echo '7';
		exit;
	}

	// Set prizes chances (type 0 = coins, type 1 = vip days, type 2 = cash)
	$prizes = array();
	$prizes[1] = array('prize' => 1, 'type' => 0, 'amount' => '30', 'chances' => array(100,900));
	$prizes[2] = array('prize' => 2, 'type' => 1, 'amount' => '2', 'chances' => array(1250,1600));
	$prizes[3] = array('prize' => 3, 'type' => 0, 'amount' => '100', 'chances' => array(2350,2400));
	$prizes[4] = array('prize' => 4, 'type' => 0, 'amount' => '60', 'chances' => array(2750,4100));
	$prizes[5] = array('prize' => 5, 'type' => 1, 'amount' => '1', 'chances' => array(4600,5250));
	$prizes[6] = array('prize' => 6, 'type' => 0, 'amount' => '75', 'chances' => array(5600,5800));
	
	// Select winning number (used to be compared with prizes numbers)
	$winning_number = rand(0,10000);
	
	// 0 and 7 are loosing (is set by default in case there is no prize won)
	$won_prize = 0;
	
	// Remove user coins for spinning
	$db->Query("UPDATE `users` SET `coins`=`coins`-'".$spin_price."' WHERE `id`='".$data['id']."'");
	
	// System process the prize
	foreach($prizes as $key => $prize) {
		if($winning_number >= $prize['chances'][0] && $winning_number <= $prize['chances'][1]) {
			$won_prize = $prize['prize'];
			
			if($prize['type'] == 0)
			{
				$db->Query("UPDATE `users` SET `coins`=`coins`+'".$prize['amount']."', `last_spin`='".time()."' WHERE `id`='".$data['id']."'");
			}
			elseif ($prize['type'] == 1)
			{
				$premium = ($data['membership'] == 0 ? (time()+($prize['amount']*86400)) : (($prize['amount']*86400)+$data['membership']));
				$db->Query("UPDATE `users` SET `membership`='".$premium."', `last_spin`='".time()."' WHERE `id`='".$data['id']."'");
			}

			$db->Query("INSERT INTO `wheel_winners` (`user_id`,`prize_type`,`prize_amount`,`time`) VALUES ('".$data['id']."','".$prize['type']."','".$prize['amount']."','".time()."')");

			break;
		}
	}

	if($won_prize == 0 || $won_prize == 7) {
		$db->Query("INSERT INTO `wheel_loosers` (`user_id`,`coins`,`time`) VALUES ('".$data['id']."','".$spin_price."','".time()."')");
		$db->Query("UPDATE `users` SET `last_spin`='".time()."' WHERE `id`='".$data['id']."'");
	}
	
	echo $won_prize;
?>