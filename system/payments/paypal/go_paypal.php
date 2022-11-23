<?php
	define('BASEPATH', true);
	require('../../init.php');

	if(!$is_online)
	{
		redirect($config['site_url']);
	}

	$s_host = parse_url($config['site_url']);

	if(isset($_GET['t']))
	{
		if($_GET['t'] == 'ads' && isset($_GET['tid']) && is_numeric($_GET['tid']))
		{
			$tid = $db->EscapeString($_GET['tid']);
			$temporary = $db->QueryFetchArray("SELECT * FROM `ads_temporary` WHERE `user_id`='".$data['id']."' AND `id`='".$tid."' LIMIT 1");

			if(!empty($temporary['id']))
			{
				$ad_pack = $db->QueryFetchArray("SELECT * FROM `ads_packs` WHERE `id`='".$temporary['ad_pack']."' LIMIT 1");
			
				if(empty($ad_pack['id']))
				{
					redirect($config['site_url']);
				}
				else
				{
					$price = number_format($temporary['clicks'] * $ad_pack['price'], 2);
				}
			}
		}
		elseif($_GET['t'] == 'vad' && isset($_GET['vid']) && is_numeric($_GET['vid']))
		{
			$tid = $db->EscapeString($_GET['vid']);
			$temporary = $db->QueryFetchArray("SELECT * FROM `vad_temporary` WHERE `user_id`='".$data['id']."' AND `id`='".$tid."' LIMIT 1");

			if(!empty($temporary['id']))
			{
				$ad_pack = $db->QueryFetchArray("SELECT * FROM `vad_packs` WHERE `id`='".$temporary['ad_pack']."' LIMIT 1");
			
				if(empty($ad_pack['id']))
				{
					redirect($config['site_url']);
				}
				else
				{
					$price = number_format($temporary['clicks'] * $ad_pack['price'], 2);
				}
			}
		}
		elseif($_GET['t'] != 'p')
		{
			redirect($config['site_url']);
		}
	}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head><title>Redirecting...</title>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<style>body{background: #fff;font: 13px Trebuchet MS, Arial, Helvetica, Sans-Serif;color: #333;line-height: 160%;margin: 0;padding: 0;text-align: center;}h1{font-size: 200%;font-weight: normal}.centerdiv{position: absolute;top: 50%; left: 50%; width: 340px; height: 200px;margin-top: -100px; margin-left: -160px;}</style>
<script type="text/javascript">
	setTimeout('document.paypalform.submit()',1000);
</script>
</head>
<body>
<div class="centerdiv"><h1>Connecting to Paypal <img src="<?=$config['site_url']?>/static/img/go_loader.gif" /></h1></div>
<?php
	if($_GET['t'] == 'p'){
?>
<form name="paypalform" action="https://www.paypal.com/cgi-bin/webscr" method="post">
	<input type="hidden" name="cmd" value="_xclick-subscriptions">
	<input type="hidden" name="business" value="<?=$config['paypal']?>">
	<input type="hidden" name="item_name" value="VIP Membership">
	<input type="hidden" name="no_note" value="1">
	<input type="hidden" name="no_shipping" value="1">
	<input type="hidden" name="rm" value="1">
	<input type="hidden" name="return" value="<?=$config['site_url']?>/?page=membership&success">
	<input type="hidden" name="cancel_return" value="<?=$config['site_url']?>/?page=membership&cancel">
	<input type="hidden" name="src" value="1">
	<input type="hidden" name="a3" value="<?=$config['vip_subscription_price']?>">
	<input type="hidden" name="p3" value="1">
	<input type="hidden" name="t3" value="M">
	<input type="hidden" name="currency_code" value="USD">
	<input type="hidden" name="bn" value="PP-SubscriptionsBF:btn_subscribeCC_LG.gif:NonHosted">
	<input type="hidden" name="custom" value="<?=($data['id'].'|membership|'.VisitorIP())?>">
	<input type="hidden" name="notify_url" value="<?=$config['site_url']?>/system/payments/paypal/ipn.php">
</form>
<?php
	}
	elseif($_GET['t'] == 'ads')
	{
?>
<form name="paypalform" action="https://www.paypal.com/cgi-bin/webscr" method="post">
	<input type="hidden" name="cmd" value="_xclick">
	<input type="hidden" name="business" value="<?=$config['paypal']?>">
	<input type="hidden" name="item_name" value="Ad Purchase - <?php echo $temporary['clicks']; ?> visits x <?php echo $ad_pack['time']; ?> seconds">
	<input type="hidden" name="item_number" value="<?=$temporary['clicks']?>">
	<input type="hidden" name="custom" value="<?=($data['id'].'|ads|'.$temporary['id'].'|'.VisitorIP())?>">
	<input type="hidden" name="amount" value="<?=$price?>">
	<input type="hidden" name="currency_code" value="USD">
	<input type="hidden" name="button_subtype" value="services">
	<input type="hidden" name="no_note" value="1">
	<input type="hidden" name="no_shipping" value="2">
	<input type="hidden" name="rm" value="1">
	<input type="hidden" name="return" value="<?=$config['site_url']?>">
	<input type="hidden" name="cancel_return" value="<?=$config['site_url']?>">
	<input type="hidden" name="notify_url" value="<?=$config['site_url']?>/system/payments/paypal/ipn.php">
</form>
<?php
	}
	elseif($_GET['t'] == 'vad')
	{
?>
<form name="paypalform" action="https://www.paypal.com/cgi-bin/webscr" method="post">
	<input type="hidden" name="cmd" value="_xclick">
	<input type="hidden" name="business" value="<?=$config['paypal']?>">
	<input type="hidden" name="item_name" value="Video Ad Purchase - <?php echo $temporary['clicks']; ?> views x <?php echo $ad_pack['time']; ?> seconds">
	<input type="hidden" name="item_number" value="<?=$temporary['clicks']?>">
	<input type="hidden" name="custom" value="<?=($data['id'].'|vad|'.$temporary['id'].'|'.VisitorIP())?>">
	<input type="hidden" name="amount" value="<?=$price?>">
	<input type="hidden" name="currency_code" value="USD">
	<input type="hidden" name="button_subtype" value="services">
	<input type="hidden" name="no_note" value="1">
	<input type="hidden" name="no_shipping" value="2">
	<input type="hidden" name="rm" value="1">
	<input type="hidden" name="return" value="<?=$config['site_url']?>">
	<input type="hidden" name="cancel_return" value="<?=$config['site_url']?>">
	<input type="hidden" name="notify_url" value="<?=$config['site_url']?>/system/payments/paypal/ipn.php">
</form>
<?php
	}else{
		redirect('../../../index.php');
	}
?>
</body>
</html>