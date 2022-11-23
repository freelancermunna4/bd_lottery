<?php
	define('BASEPATH', true);
	include('../system/init.php');

	if($is_online && $data['admin'] == 0){
		redirect($config['site_url']);
	}elseif($is_online && $data['admin'] == 1){
		redirect('index.php');
	}

	$errMsg = '';
	if(isset($_POST['connect'])) {
		$login = $db->EscapeString($_POST['login']);
		$pass = MD5($_POST['pass']);
		$data = $db->QueryFetchArray("SELECT id,username,admin FROM `users` WHERE (`username`='".$login."' OR `email`='".$login."') AND `password`='".$pass."'");

		if(empty($data['id'])){
			$errMsg = 'Wrong username or password!';
		}elseif($data['admin'] == 0){
			$errMsg = 'You cannot acess this area!';
		}elseif($data['id'] != '') {
			if(isset($_POST['remember'])){
				setcookie('AutoLogin', 'ses_user='.$data['username'].'&ses_hash='.$pass, time()+604800, '/');
			}
			$db->Query("UPDATE `users` SET `log_ip`='".VisitorIP()."', `last_activity`='".time()."' WHERE `id`='".$data['id']."'");
			$_SESSION['PT_User'] = $data['id'];
			redirect('index.php');
		}
	}
?>
<html>
<head><title>PaidTasks v<?=$config['version']?> - Admin Panel</title>
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="author" content="MafiaNet (c) MN-Shop.com">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/fonts/font-awesome.css">
    <!--[if IE 8]><link rel="stylesheet" href="css/fonts/font-awesome-ie7.css"><![endif]-->
    <link rel="stylesheet" href="css/external/jquery.css">
    <link rel="stylesheet" href="css/elements.css">

	<!-- Load Javascript -->
    <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/libs/jquery-1.10.2.min.js"><\/script>')</script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/libs/jquery-migrate-1.2.1.min.js"><\/script>')</script>
    <script src="//code.jquery.com/ui/1.9.1/jquery-ui.min.js"></script>
    <script>window.jQuery.ui || document.write('<script src="js/libs/jquery-ui-1.9.1.min.js"><\/script>')</script>
    <!--[if gt IE 8]><!-->
    <script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/0.8.2/lodash.min.js"></script>
    <script>window._ || document.write('<script src="js/libs/lo-dash.min.js"><\/script>')</script>
    <!--<![endif]-->
    <!-- IE8 doesn't like lodash -->
    <!--[if lt IE 9]><script src="//documentcloud.github.com/underscore/underscore.js"></script><![endif]-->
    <script src="//cdnjs.cloudflare.com/ajax/libs/require.js/2.0.6/require.min.js"></script>
    <script>window.require || document.write('<script src="js/libs/require-2.0.6.min.js"><\/script>')</script>
    <script type="text/javascript">
        window.WebFontConfig = {
            google: { families: [ 'PT Sans:400,700' ] },
            active: function(){ $(window).trigger('fontsloaded') }
        };
    </script>
    <script defer async src="//ajax.googleapis.com/ajax/libs/webfont/1.0.28/webfont.js"></script>
    <script src="js/mylibs/polyfills/modernizr-2.6.1.min.js"></script>
    <script src="js/mylibs/polyfills/respond.js"></script>
    <script src="js/mylibs/polyfills/matchmedia.js"></script>
    <!--[if lt IE 9]><script src="js/mylibs/polyfills/selectivizr.js"></script><![endif]-->
    <!--[if lt IE 10]><script src="js/mylibs/polyfills/excanvas.js"></script><![endif]-->
    <!--[if lt IE 10]><script src="js/mylibs/polyfills/classlist.js"></script><![endif]-->
    <script src="js/mylibs/jquery.hashchange.js"></script>
    <script src="js/mylibs/jquery.idle-timer.js"></script>
    <script src="js/mylibs/jquery.plusplus.js"></script>
    <script src="js/mylibs/jquery.scrollTo.js"></script>
    <script src="js/mylibs/jquery.ui.touch-punch.js"></script>
    <script src="js/mylibs/jquery.ui.multiaccordion.js"></script>
    <script src="js/mylibs/number-functions.js"></script>
    <script src="js/mylibs/fullstats/jquery.css-transform.js"></script>
    <script src="js/mylibs/fullstats/jquery.animate-css-rotate-scale.js"></script>
    <script src="js/mylibs/forms/jquery.validate.js"></script>
    <script src="js/pespro.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/script.js"></script>
</head>
<body class="login">
	<div id="loading-overlay"></div>
	<div id="loading"><span>Loading...</span></div>
	<section id="toolbar">
		<div class="container_12">
			<div class="left">
				<ul class="breadcrumb">
					<li><a href="<?=$config['site_url']?>/admin-panel/">Admin Panel</a></li>
				</ul>
			</div>
			<div class="right">
				<ul>
					<li><a href="<?=$config['site_url']?>">View Website</a></li>
					<li class="red"><a target="_blank" href="http://buy.paidtasks.net">PaidTasks</a></li>
				</ul>
			</div>
		</div>
	</section>
		<header class="container_12">
		<div class="container">
			<a href="<?=$config['site_url']?>/admin-panel"><img src="img/logo.png" alt="PaidTasks" width="181" height="46"></a>
		</div>
	</header>
	<section id="login" class="container_12 clearfix">
		<form method="post" class="box validate">
			<div class="header">
				<h2><span class="icon icon-lock"></span>Login</h2>
			</div>
			<div class="content">
				<?if(!empty($errMsg)){?><div class="login-messages"><div class="message" style="color:#771717"><?=$errMsg?></div></div><?}?>
				
				<div class="form-box">
					<div class="row">
						<label for="login_name">
							<strong>Username / Email</strong>
						</label>
						<div>
							<input tabindex="1" type="text" class="required noerror" name="login" id="login_name" />
						</div>
					</div>
					<div class="row">
						<label for="login_pw">
							<strong>Password</strong>
							<small><a href="<?=$config['site_url']?>/recover.php" id="">Forgot it?</a></small>
						</label>
						<div>
							<input tabindex="2" type="password" class="required noerror" name="pass" id="login_pw" />
						</div>
					</div>
				</div>
			</div>
			<div class="actions">
				<div class="left">
					<div class="rememberme">
						<input tabindex="4" type="checkbox" name="remember" id="remember" /><label for="login_remember">Remember me?</label>
					</div>
				</div>
				<div class="right">
					<input tabindex="3" type="submit" value="Sign In" name="connect" />
				</div>
			</div>
		</form>
	</section>
	<script> $$.loaded(); </script>
</body>
</html>