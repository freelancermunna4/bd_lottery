<?php
	define('BASEPATH', true);

	// Load System Files
	require('system/init.php');

	// Logout system
	if(isset($_GET['logout']))
	{
		if(isset($_COOKIE['AutoLogin'])){
			unset($_COOKIE['AutoLogin']); 
			setcookie('AutoLogin', '', time(), '/');
		}

		session_destroy();

		redirect($config['site_url']);
	}

	// Referral System
	if(!$is_online && isset($_GET['ref']) && is_numeric($_GET['ref']))
	{
		setcookie('PT_REF_ID', $db->EscapeString($_GET['ref']), time()+7200);
	}
	
	// Detect visitor referrer
	if(!$is_online && isset($_SERVER['HTTP_REFERER']) && !isset($_COOKIE['RefSource'])){
		$main_domain = parse_url($config['site_url']);
		$http_referer = parse_url($_SERVER['HTTP_REFERER']);
		if(isset($http_referer['host']) && $http_referer['host'] != $main_domain['host']){
			setcookie('RefSource', $db->EscapeString($_SERVER['HTTP_REFERER']), time()+1800);
		}
	}

	// Email Unsubscribe
	if(isset($_GET['unsubscribe']) && isset($_GET['um'])) {
		$uid = $db->EscapeString($_GET['unsubscribe']);
		$um = $db->EscapeString($_GET['um']);
		if($db->QueryGetNumRows("SELECT id FROM `users` WHERE `id`='".$uid."' AND MD5(`email`)='".$um."'") > 0) {
			$db->Query("UPDATE `users` SET `newsletter`='0' WHERE `id`='".$uid."' AND MD5(`email`)='".$um."'");
		}
	}
	
	// Remove Footer Branding
	if(file_exists(BASE_PATH.'/system/copyright.php')) {
		include(BASE_PATH.'/system/copyright.php');
	}

	/*
		Load Website
	*/

	// Starting compression
	ob_start();

	// Load Header
	require_once(BASE_PATH.'/template/'.$config['theme'].'/common/header.php');

	// Load Content
	$pages = array(
			// script name => (1 = valid, 0 = disabled), (0 = offline, 1 = online, 2 = doesn't matter), File Location
			'contact' => array(1, 2, 'pages/contact'),
			'tos' => array(1, 2, 'pages/tos'),
			'info' => array(1, 2, 'pages/info'),
			'register' => array(1, 0, 'pages/register'),
			'recover' => array(1, 0, 'pages/recover'),
			'activate' => array(1, 0, 'pages/activate'),
			'affiliates' => array(1, 1, 'pages/affiliates'),
			'account' => array(1, 1, 'pages/account'),
			'horserace' => array(1, 1, 'pages/horserace'),
			'withdraw' => array(1, 1, 'pages/withdraw'),
			'luckywheel' => array(1, 1, 'pages/luckywheel'),
			'cpm' => array(1, 1, 'pages/cpm'),
			'lottery' => array(1, 1, 'pages/lottery'),	
			'deposit' => array(1, 1, 'pages/deposit'),	
			
			
		);
		
	$valid = false;
	if (isset($_GET['page']) && $pages[$_GET['page']][0] == 1) {
		if($is_online && $pages[$_GET['page']][1] == 1){
			$valid = true;
		}elseif(!$is_online && $pages[$_GET['page']][1] == 0){
			$valid = true;
		}elseif($pages[$_GET['page']][1] == 2){
			$valid = true;
		}
	}

	$page = ($is_online ? 'pages/dashboard' : 'pages/home');
	if($valid)
	{
		if(file_exists(BASE_PATH.'/template/'.$config['theme'].'/'.$pages[$_GET['page']][2].'.php'))
		{
			$page = $pages[$_GET['page']][2];
		}
	}
	
	// Load Page
	require_once(BASE_PATH.'/template/'.$config['theme'].'/'.$page.'.php');
	
	// Load Footer
	require_once(BASE_PATH.'/template/'.$config['theme'].'/common/footer.php');
	
	// Show website
	ob_end_flush();
?>