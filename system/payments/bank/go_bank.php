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
			$temporary = $db->QueryFetchArray("SELECT * FROM `ads_temporary` WHERE `user_id`='".$data['id']."' AND `id`='".$tid."' AND `status`='0' LIMIT 1");

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
			$temporary = $db->QueryFetchArray("SELECT * FROM `vad_temporary` WHERE `user_id`='".$data['id']."' AND `id`='".$tid."' AND `status`='0' LIMIT 1");

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
			else
			{
				redirect($config['site_url']);
			}
		}
		else
		{
			redirect($config['site_url']);
		}
	}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head><title>Swift Transfer</title>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<style>body{background: #fff;font: 13px Trebuchet MS, Arial, Helvetica, Sans-Serif;color: #333;margin: 0;padding: 0;text-align: center;}h1{font-size: 180%;font-weight: normal}.centerdiv{display:block; margin: 120px auto 80px; width: 960px; height: 200px;</style>
</head>
<body>
<div class="centerdiv">
	<a href="<?php echo $config['site_url']; ?>" title="Go Back"><img src="<?php echo $config['site_url']; ?>/static/img/logo.png" alt="" border="0" /></a>
	<h1>Your video was successfully added but is waiting for your payment.<br />Because you chosed to pay by Wire Transfer, send <?php echo get_currency_symbol($config['currency_code']).$price; ?> to following bank account (reference number #<?php echo $temporary['reference_number']; ?>)</h1>
	<div style="display:block;font-size:16px;padding:25px;width:580px;margin:100px auto 25px;background:#efefef;border:2px solid #ccc;border-radius:5px;">
		<p><b><?php echo $config['bank_details']; ?></b></p>
	</div>
	<i><small>*Save reference number for later use to contact website admin in case of any issues with the payment.</small></i>
</div>
</body>
</html>