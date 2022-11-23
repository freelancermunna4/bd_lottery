<?php
define('BASEPATH', true);
require('../../init.php');
require('PaypalIPN.php');

$ipn = new PaypalIPN();

// Use the sandbox endpoint during testing.
// $ipn->useSandbox();
$verified = $ipn->verifyIPN();
if ($verified) {
	$item_name = $_POST['item_name'];
	$payment_status = $_POST['payment_status'];
	$payment_amount = $_POST['mc_gross'];
	$payment_currency = $_POST['mc_currency'];
	$txn_id = $_POST['txn_id'];
	$parent_txn_id = $_POST['parent_txn_id'];
	$subscr_id = $_POST['subscr_id'];
	$receiver_email = $_POST['receiver_email'];
	$payer_email = $_POST['payer_email'];
	$custom = $_POST['custom'];

	$get_data = explode('|', $custom);

	if($payment_status == 'Completed' && $payment_currency == $config['currency_code'])
	{
		if($get_data[1] == 'membership' && $payment_amount >= $config['vip_subscription_price'])
		{
			$user = $db->QueryFetchArray("SELECT * FROM `users` WHERE `id`='".$get_data[0]."' LIMIT 1");

			if(!empty($user['id']) && $db->QueryGetNumRows("SELECT * FROM `transactions` WHERE `gateway`='paypal' AND `trans_id`='".$txn_id."' LIMIT 1") == 0){
				$db->Query("INSERT INTO `transactions` (`user`, `user_id`, `type`, `amount`, `money`, `gateway`, `date`, `payer_email`, `user_ip`, `trans_id`) VALUES('".$user['username']."','".$user['id']."', '1', '30', '".$payment_amount."', 'paypal', '".time()."', '".$payer_email."', '".$get_data[2]."', '".$txn_id."')");
				if($user['id'] > 0){
					$premium = ($user['membership'] == 0 ? (time()+2592000) : (2592000+$user['membership']));
					$db->Query("UPDATE `users` SET `membership`='".$premium."' WHERE `id`='".$user['id']."'");
					$db->Query("INSERT INTO `user_transactions` (`user_id`,`type`,`value`,`cash`,`date`)VALUES('".$user['id']."','1','30','".$config['vip_subscription_price']."','".time()."')");
				}
			}
		}
		elseif($get_data[1] == 'ads')
		{
			$tid = $db->EscapeString($get_data[2]);
			$temporary = $db->QueryFetchArray("SELECT * FROM `ads_temporary` WHERE `user_id`='".$get_data[0]."' AND `id`='".$tid."' LIMIT 1");
			
			if(!empty($temporary['id']))
			{
				$ad_pack = $db->QueryFetchArray("SELECT * FROM `ads_packs` WHERE `id`='".$temporary['ad_pack']."' LIMIT 1");
			
				if(!empty($ad_pack['id']))
				{
					$price = number_format($temporary['clicks'] * $ad_pack['price'], 2);
					
					if($price <= $payment_amount)
					{
						$user = $db->QueryFetchArray("SELECT * FROM `users` WHERE `id`='".$get_data[0]."' LIMIT 1");

						if(!empty($user['id']) && $db->QueryGetNumRows("SELECT * FROM `transactions` WHERE `gateway`='paypal' AND `trans_id`='".$txn_id."' LIMIT 1") == 0){
							$db->Query("INSERT INTO `transactions` (`user`, `user_id`, `type`, `amount`, `ad_pack`, `money`, `gateway`, `date`, `payer_email`, `user_ip`, `trans_id`) VALUES('".$user['username']."','".$user['id']."', '2', '".$temporary['clicks']."', '".$ad_pack['id']."', '".$payment_amount."', 'paypal', '".time()."', '".$payer_email."', '".$get_data[3]."', '".$txn_id."')");

							if($user['id'] > 0)
							{
								$db->Query("INSERT INTO `ads_sites` (`user_id`,`url`,`title`,`daily_clicks`,`status`,`ad_pack`,`clicks`,`country`,`gender`,`noref`,`time`) VALUES('".$data['id']."', '".$temporary['url']."', '".$temporary['title']."', '".$temporary['daily_clicks']."', '0', '".$ad_pack['id']."', '".$temporary['clicks']."', '".$temporary['country']."', '".$temporary['gender']."', '".$temporary['noref']."', '".time()."') ");
								$db->Query("UPDATE `ads_temporary` SET `status`='1' WHERE `user_id`='".$get_data[0]."' AND `id`='".$tid."'");
								$db->Query("INSERT INTO `user_transactions` (`user_id`,`type`,`value`,`cash`,`date`)VALUES('".$user['id']."','2','".$temporary['clicks']."','".$price."','".time()."')");
							}
						}
					}
				}
			}
		}
		elseif($get_data[1] == 'vad')
		{
			$tid = $db->EscapeString($get_data[2]);
			$temporary = $db->QueryFetchArray("SELECT * FROM `vad_temporary` WHERE `user_id`='".$get_data[0]."' AND `id`='".$tid."' LIMIT 1");
			
			if(!empty($temporary['id']))
			{
				$ad_pack = $db->QueryFetchArray("SELECT * FROM `vad_packs` WHERE `id`='".$temporary['ad_pack']."' LIMIT 1");
			
				if(!empty($ad_pack['id']))
				{
					$price = number_format($temporary['clicks'] * $ad_pack['price'], 2);
					
					if($price <= $payment_amount)
					{
						$user = $db->QueryFetchArray("SELECT * FROM `users` WHERE `id`='".$get_data[0]."' LIMIT 1");

						if(!empty($user['id']) && $db->QueryGetNumRows("SELECT * FROM `transactions` WHERE `gateway`='paypal' AND `trans_id`='".$txn_id."' LIMIT 1") == 0){
							$db->Query("INSERT INTO `transactions` (`user`, `user_id`, `type`, `amount`, `ad_pack`, `money`, `gateway`, `date`, `payer_email`, `user_ip`, `trans_id`) VALUES('".$user['username']."','".$user['id']."', '3', '".$temporary['clicks']."', '".$ad_pack['id']."', '".$payment_amount."', 'paypal', '".time()."', '".$payer_email."', '".$get_data[3]."', '".$txn_id."')");

							if($user['id'] > 0)
							{
								$db->Query("INSERT INTO `vad_videos` (`user_id`,`video_id`,`title`,`daily_clicks`,`status`,`ad_pack`,`clicks`,`country`,`gender`,`time`) VALUES('".$data['id']."', '".$temporary['video_id']."', '".$temporary['title']."', '".$temporary['daily_clicks']."', '0', '".$ad_pack['id']."', '".$temporary['clicks']."', '".$temporary['country']."', '".$temporary['gender']."', '".time()."') ");
								$db->Query("UPDATE `vad_temporary` SET `status`='1' WHERE `user_id`='".$get_data[0]."' AND `id`='".$tid."'");
								$db->Query("INSERT INTO `user_transactions` (`user_id`,`type`,`value`,`cash`,`date`)VALUES('".$user['id']."','2','".$temporary['clicks']."','".$price."','".time()."')");
							}
						}
					}
				}
			}
		}
	}
}

// Reply with an empty 200 response to indicate to paypal the IPN was received correctly.
header("HTTP/1.1 200 OK");
?>