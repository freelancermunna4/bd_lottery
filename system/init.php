<?php
	/* Error Reporting */
	error_reporting(0);
	ini_set('display_errors', 0);

	/* Server configuration & optimisation */
	ini_set('implicit_flush', 1);
	set_time_limit(0);

	/* Starting session */
	session_start();

	/* Define Base Path */
	define('BASE_PATH', realpath(dirname(__FILE__).'/..'));

	/* Define Database Extension (MySQL or MySQLi) */
	$config['sql_extenstion']  = 'MySQLi';

	/* Load required files */
	require(BASE_PATH.'/system/database.php');
	require(BASE_PATH.'/system/libs/functions.php');
	require(BASE_PATH.'/system/libs/database/'.$config['sql_extenstion'].'.php');

	/* Database connection */
	$db = new MySQLConnection($config['sql_host'], $config['sql_username'], $config['sql_password'], $config['sql_database']);
	$db->Connect();

	unset($config['sql_password']);

	/* Load website settings */
	$config = array();
	$configs = $db->QueryFetchArrayAll("SELECT config_name,config_value FROM `site_config`");
	foreach ($configs as $con)
	{
		$config[$con['config_name']] = $con['config_value'];
	}
	unset($configs); 

	/* Script Version */
	$config['version'] = '2.0.1';
	
	/* Run update */
	if(file_exists(BASE_PATH.'/system/run_update.php')){
		include(BASE_PATH.'/system/run_update.php');
	}

	/* Cron */
	include('cron/cron.php');

	/* Website Theme */
	$config['theme'] = (!empty($config['theme']) && file_exists(BASE_PATH.'/template/'.$config['theme'].'/index.php') ? $config['theme'] : 'default');
	include(BASE_PATH.'/template/'.$config['theme'].'/index.php');
	if(defined('IS_ADMIN')){
		$set_def_theme = '';
		foreach(glob(BASE_PATH.'/template/*/index.php') as $tm){
			include($tm);
			
			$selected = (isset($_POST['set']['theme']) && $_POST['set']['theme'] == $theme['code'] ? ' selected' : (!isset($_POST['set']['theme']) && $config['theme'] == $theme['code'] ? ' selected' : '')); 
			$set_def_theme .= '<option value="'.$theme['code'].'"'.$selected.'>'.$theme['name'].'</option>';
		}
	}
	
	/* User Session */
	$is_online = false;
	if(isset($_SESSION['PT_User'])){
		$ses_id = $db->EscapeString($_SESSION['PT_User']);
		$data = $db->QueryFetchArray("SELECT * FROM `users` WHERE `id`='".$ses_id."' AND `disabled`='0' LIMIT 1");

		$is_online = true;
		if(empty($data['id']))
		{
			session_destroy();
			$is_online = false;
		}
		elseif($data['last_activity']+60 < time() && !defined('IS_AJAX'))
		{
			$db->Query("UPDATE `users` SET `last_activity`='".time()."' WHERE `id`='".$data['id']."'");
			$_SESSION['PT_User'] = $data['id'];
		}
	}
	elseif(isset($_COOKIE['AutoLogin']))
	{
		$sesCookie = $db->EscapeString($_COOKIE['AutoLogin'], 0);
	
		$ses_user 	= '';
		$ses_hash 	= '';
		$sesCookie_exp = explode('&', $sesCookie);
		foreach($sesCookie_exp as $sesCookie_part){
			$find_ses_exp = explode('=', $sesCookie_part);
			if($find_ses_exp[0] == 'ses_user'){
				$ses_user = $db->EscapeString($find_ses_exp[1]);
			}elseif($find_ses_exp[0] == 'ses_hash'){
				$ses_hash = $db->EscapeString($find_ses_exp[1]);
			}
		}
	
		if(!empty($ses_user) && !empty($ses_hash))
		{
			$data = $db->QueryFetchArray("SELECT * FROM `users` WHERE (`username`='".$ses_user."' OR `email`='".$ses_user."') AND (`password`='".$ses_hash."' AND `disabled`='0') LIMIT 1");
			
			if(empty($data['id']))
			{
				unset($_COOKIE['AutoLogin']); 
			}
			else
			{
				$_SESSION['PT_User'] = $data['id'];
				$is_online = true;
				
				$check_activity = $db->QueryGetNumRows("SELECT * FROM `user_logins` WHERE `uid`='".$data['id']."' AND DATE(`time`) = DATE(NOW()) LIMIT 1");
				if($check_activity == 0){
					$ip_address = ip2long(VisitorIP());
					$browser = $db->EscapeString($_SERVER['HTTP_USER_AGENT']);
					$db->Query("INSERT INTO `user_logins` (`uid`,`ip`,`info`,`time`) VALUES ('".$data['id']."','".$ip_address."','".$browser."',NOW())");
				}
			}
		}
		else
		{
			unset($_COOKIE['AutoLogin']); 
		}
	}

	/* Check user membership */
	if($is_online && !defined('IS_AJAX'))
	{
		if($data['membership'] > 0 && $data['membership'] < time())
		{
			$db->Query("UPDATE `users` SET `membership`='0' WHERE `id`='".$data['id']."'");
		}
	}

	/* Language system */
	$lang_select = '';
	if(defined('IS_ADMIN'))
	{ 
		$set_def_lang = ''; 
	}

	$CONF['language'] = (!empty($config['def_lang']) && file_exists('languages/'.$config['def_lang'].'/index.php') ? $config['def_lang'] : 'en');
	foreach(glob(BASE_PATH.'/languages/*/index.php') as $langname)
	{
		$langarray[] = str_replace(array(BASE_PATH.'/languages/', '/index.php'), '', $langname);
		include($langname);
		
		if(defined('IS_ADMIN'))
		{
			$selected = (isset($_POST['set']['def_lang']) && $_POST['set']['def_lang'] == $c_lang['code'] ? ' selected' : (!isset($_POST['set']['def_lang']) && $config['def_lang'] == $c_lang['code'] ? ' selected' : '')); 
			if($c_lang['active'] != 0)
			{
				$set_def_lang .= '<option value="'.$c_lang['code'].'"'.$selected.'>'.$c_lang['lang'].'</option>';
			}
		}
		
		if(isset($_GET['lang']))
		{
			$selected = ($_GET['lang'] == $c_lang['code'] ? ' active' : '');
		}
		elseif(isset($_COOKIE['lang']))
		{
			$selected = ($_COOKIE['lang'] == $c_lang['code'] ? ' active' : '');
		}
		else
		{
			$selected = ($CONF['language'] == $c_lang['code'] ? ' active' : '');
		}

		if($c_lang['active'] != 0){
			$c_lang['code'] = "'".$c_lang['code']."'";
			$lang_select .= '<a class="dropdown-item'.$selected.'" href="javascript:void(0)" onclick="langSelect('.$c_lang['code'].');">'.$c_lang['lang'].'</a>';
		}
	}

	if(isset($_GET['lang']))
	{
		if(in_array($_GET['lang'], $langarray))
		{
			setcookie('lang', $_GET['lang'], time()+360000);
			$CONF['language'] = $_GET['lang'];
		}
	}
	elseif (isset($_COOKIE['lang']) && !empty($_COOKIE['lang']))
	{
		$CONF['language'] = $_COOKIE['lang'];
	}

	// Load main language
	if($CONF['language'] != 'en') {
		if(file_exists(BASE_PATH.'/languages/en/base/lang.php')){ 
			include(BASE_PATH.'/languages/en/base/lang.php'); 
		}
	}
	
	// Load selected language
	if(file_exists(BASE_PATH.'/languages/'.$CONF['language'].'/base/lang.php'))
	{ 
		include(BASE_PATH.'/languages/'.$CONF['language'].'/base/lang.php'); 
	}
	
	/* Set default charset */
	$conf['lang_charset'] = (!empty($c_lang[$CONF['language'].'_charset']) ? $c_lang[$CONF['language'].'_charset'] : 'UTF-8');
	header('Content-type: text/html; charset='.$conf['lang_charset']);
?>