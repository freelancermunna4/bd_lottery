<?php
define('BASEPATH', true);
require_once('../init.php');
if(!$is_online){
	exit;
}

// Skip Page
if(isset($_GET['step']) && $_GET['step'] == "skip" && is_numeric($_GET['id'])){
	if(isset($_SESSION['token']) && $_SESSION['token'] == $_GET['token']){
		$id = $db->EscapeString($_GET['id']);

		$db->Query("INSERT IGNORE INTO `vad_videos_done` (user_id, video_id, time) VALUES('".$data['id']."', '".$id."', '".time()."')");
		echo '<div class="alert alert-info" role="alert"><b>SUCCESS!</b> Video was successfully skipped!</div>';
	}
}

// Proccess
if(isset($_POST['data']) && isset($_POST['token']) && $_POST['token'] == $_SESSION['token']){
	$vid = $db->EscapeString($_POST['data']);
	$video = $db->QueryFetchArray("SELECT a.id,a.ad_pack,a.clicks,b.coins,b.time FROM vad_videos a LEFT JOIN vad_packs b ON b.id = a.ad_pack LEFT JOIN vad_videos_done c ON c.user_id = '".$data['id']."' AND c.video_id = a.id WHERE a.id = '".$vid."' AND a.status = '0' AND (a.daily_clicks > a.today_clicks OR a.daily_clicks = '0') AND a.clicks > '0' AND c.video_id IS NULL AND (a.country = '0' OR FIND_IN_SET('".$data['country_id']."', a.country)) AND (a.gender = '".$data['gender']."' OR a.gender = '0') LIMIT 1");

	if(empty($video['id']) || empty($data['id']) || $video['clicks'] <= 0){
		echo '<div class="msg"><div class="error"><b>ERROR:</b> This video is no longer available!</div></div>';
	}else{
		$mod_ses = $db->QueryFetchArray("SELECT ses_key FROM `vad_videos_session` WHERE `user_id`='".$data['id']."' AND `video_id`='".$video['id']."' LIMIT 1");
		$valid = false;
		if($mod_ses['ses_key'] != '' && ($mod_ses['ses_key']-2) <= time()){
			$valid = true;
		}
		
		if($valid)
		{
			$db->Query("UPDATE `users` SET `coins`=`coins`+'".$video['coins']."' WHERE `id`='".$data['id']."'");
			$db->Query("UPDATE `vad_videos` SET `clicks`=`clicks`-'1', `visits`=`visits`+'1', `today_clicks`=`today_clicks`+'1' WHERE `id`='".$video['id']."'");
			$db->Query("INSERT INTO `vad_videos_done` (user_id, video_id, time) VALUES('".$data['id']."', '".$video['id']."', '".time()."')");
			$db->Query("DELETE FROM `vad_videos_session` WHERE `user_id`='".$data['id']."' AND `video_id`='".$video['id']."'");

			if(!empty($data['ref']) && $config['ref_commission'] > 0) {
				$commission = number_format(((($data['membership'] > 0 ? $config['vip_ref_commission'] : $config['ref_commission']) / 100) * $video['coins']), 2);
				ref_commission($data['ref'], $data['id'], $commission);
			}
			
			echo '<div class="alert alert-success" role="alert"><b>SUCCESS!</b> You have received <b>'.number_format($video['coins'], 2).' coins</b>!</div>';
		}
		else
		{
			echo '<div class="alert alert-danger" role="alert"><b>ERROR:</b> This page is no longer available!</div>';
		}
	}
}
?>