<?php
if(! defined('BASEPATH') ){ exit('Unable to view file.'); }

/* Define functions */
function write_cron($timestamp, $cron_name, $var_name){
	$filename = realpath(dirname(__FILE__)).'/times/'.$cron_name.'.php';
	$content = file_put_contents($filename, '<?php $'.$var_name.'[\'time\'] = \''.$timestamp.'\'; ?>');

	$return = true;
	if(!$content){
		die('<center><b>System ERROR</b><br /><i>system/cron/times/'.$cron_name.'.php</i> must be writable (change permissions to 777)</center>');
		$return = false;
	}
	return $return;
}

/* Times */
$timestamp = time();
$daily_time = strtotime(date('j F Y'));
$lottery_time = strtotime("next Sunday")-60;

/* ---------------Starting Crons------------------ */
$realPath = realpath(dirname(__FILE__));
if(!is_writable($realPath.'/times')){
	die('<center><b>System ERROR</b><br /><i>system/cron/times/</i> directory must be writable (change permissions to 777)</center>');
}


/* Cron 5 minutes */
if(file_exists($realPath.'/times/5min_cron.php')){
	include($realPath.'/times/5min_cron.php');
}

if($cron_5min['time'] < ($timestamp-300)){
	$write = write_cron($timestamp, '5min_cron', 'cron_5min');
	if($write){
		$db->Query("UPDATE `users` SET `membership`='0' WHERE `membership`>'0' AND `membership`<'".time()."'");
		$db->Query("DELETE FROM `wrong_logins` WHERE `time`<'".(time()-$config['login_wait_time'])."'");
		$db->Query("DELETE FROM `vad_videos_session` WHERE `timestamp`<'".(time()-600)."'");
		$db->Query("DELETE FROM `vad_temporary` WHERE `status`='1'");
	}
}


/* Cron 60 minutes */
if(file_exists($realPath.'/times/1h_cron.php')){
	include($realPath.'/times/1h_cron.php');
}

if($cron_1h['time'] < ($timestamp-3600)){
	$write = write_cron($timestamp, '1h_cron', 'cron_1h');
	if($write){
		$db->Query("DELETE FROM `vad_temporary` WHERE `time`<'".(time()-(86400*$config['cron_ads']))."'");
	}
}

/* Daily Cron */
if(file_exists($realPath.'/times/daily_cron.php')){
	include($realPath.'/times/daily_cron.php');
}

if($cron_day['time'] < $daily_time){
	$write = write_cron($daily_time, 'daily_cron', 'cron_day');
	if($write && $cron_day['time'] > 0){
		$db->Query("DELETE FROM `vad_videos_done`");
		$db->Query("UPDATE `vad_videos` SET `today_clicks`='0' WHERE `today_clicks`>'0'");
		
		// Delete Inactive Users
		if($config['cron_users'] > 0) {
			$del_time = (time() - (86400*$config['cron_users']));
			$db->Query("DELETE FROM `users` WHERE `reg_time` < '".$del_time."' AND `reg_time` < '".$del_time."'");
		}
	}
}
?>