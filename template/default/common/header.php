<?php
	if(! defined('BASEPATH') ){ exit('Unable to view file.'); }

	// Email confirmation
	$actMessage = false;
	if(isset($_GET['activate']) && $_GET['activate'] > 0){
		$code = $db->EscapeString($_GET['activate']);
		if($db->QueryGetNumRows("SELECT id FROM `users` WHERE `activate`='".$code."' LIMIT 1") > 0){
			if($site['refsys'] == 1 && $site['aff_click_req'] == 0){
				$ref = $db->QueryFetchArray("SELECT id,ref FROM `users` WHERE `activate`='".$code."'");
				if($ref['ref'] > 0){
					$db->Query("UPDATE `users` SET `coins`=`coins`+'".$site['ref_coins']."' WHERE `id`='".$ref['ref']."'");
					$db->Query("UPDATE `users` SET `ref_paid`='1' WHERE `activate`='".$code."'");
					
					if($site['paysys'] == 1 && $site['ref_cash'] > 0){
						affiliate_commission($ref['ref'], $ref['id'], $site['ref_cash'], 'referral_activity');
					}
				}
			}

			$db->Query("UPDATE `users` SET `activate`='0' WHERE `activate`='".$code."'");
			$actMessage = '<div class="alert alert-success mb-0" role="alert">'.$lang['b_23'].'</div>';
		}
	}

	// Proccess Login
	$errMessage = '';
	$login_error = false;
	if(isset($_POST['connect'])) {
		if(isset($_SESSION['token']) && $_SESSION['token'] == $_POST['token'])
		{
			$ip_address = ip2long(VisitorIP());
			$attempts = $db->QueryFetchArray("SELECT count,time FROM `wrong_logins` WHERE `ip_address`='".$ip_address."'");

			if($attempts['count'] >= $config['login_attempts'] && $attempts['time'] > (time() - (60*$config['login_wait_time'])))
			{
				$errMessage = '<div class="alert alert-danger" role="alert">'.lang_rep($lang['b_01'], array('-TIME-' => $config['login_wait_time'])).'</div>';
			}
			else
			{
				$login = $db->EscapeString($_POST['user']);
				$pass = MD5($_POST['password']);
				$data = $db->QueryFetchArray("SELECT id,username,disabled,activate FROM `users` WHERE (`username`='".$login."' OR `email`='".$login."') AND `password`='".$pass."'");

				if($data['disabled'] > 0)
				{
					$errMessage = '<div class="alert alert-danger" role="alert">'.$lang['b_02'].'</div>';
					$login_error = true;
				}
				elseif($data['activate'] > 0)
				{
					$errMessage = '<div class="alert alert-danger" role="alert">'.$lang['b_03'].'</div>';
					$login_error = true;
				}
				elseif(!empty($data['id']))
				{
					$db->Query("UPDATE `users` SET `log_ip`='".VisitorIP()."', `last_activity`='".time()."' WHERE `id`='".$data['id']."'");
					$db->Query("DELETE FROM `wrong_logins` WHERE `ip_address`='".$ip_address."'");
		
					// Store login info
					$browser = $db->EscapeString($_SERVER['HTTP_USER_AGENT']);
					$db->Query("INSERT INTO `user_logins` (`uid`,`ip`,`info`,`time`) VALUES ('".$data['id']."','".$ip_address."','".$browser."',NOW())");

					// Auto-login user
					if(isset($_POST['remember'])){
						setcookie('AutoLogin', 'ses_user='.$data['username'].'&ses_hash='.$pass, time()+604800, '/');
					}
					
					// Set Session
					$_SESSION['PT_User'] = $data['id'];
					
					// Multi-account prevent
					setcookie('AccExist', $data['username'], time()+604800, '/');
					
					// Reload page
					redirect('index.php');
				}
				else
				{
					$db->Query("INSERT INTO `wrong_logins` (`ip_address`,`count`,`time`) VALUES ('".$ip_address."','1','".time()."') ON DUPLICATE KEY UPDATE `count`=`count`+'1', `time`='".time()."'");

					$errMessage = '<div class="alert alert-danger" role="alert">'.$lang['b_04'].'</div>';
					$login_error = true;
				}
			}
		}
	}

	// Generate Security Token
	$token = GenGlobalToken();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head><title><?php echo $config['site_name']; ?></title>
  
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="<?php echo $config['site_description']; ?>" />
	<meta name="keywords" content="<?php echo $config['site_keywords']; ?>" />
	<meta name="author" content="bangladeshisoftware.com" />
	<meta name="version" content="<?php echo $config['version']; ?>" />
	<link href="static/css/bootstrap.min.css" rel="stylesheet">
	<link href="static/css/fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link href="template/<?php echo $config['theme']; ?>/static/theme.css?v=<?php echo $config['version']; ?>" rel="stylesheet">
	<link rel="shortcut icon" href="static/favicon.ico" type="image/x-icon"/>
	<script src="static/js/jquery.min.js"></script>
    <script src="static/js/popper.min.js"></script>
    <script src="static/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
	<!--<link href="template/default//style.css" rel="stylesheet" type="text/css" />-->

	<?php if($login_error == true) { ?>
	<script> $(document).ready(function() { $('#login_box').modal('show'); }); </script>
	<?php } ?>
	<?php if($actMessage != false) { ?>
	<script> $(document).ready(function() { $('#confirm_box').modal('show'); }); </script>
	<?php } ?>
	
	
	<script async src="https://securepubads.g.doubleclick.net/tag/js/gpt.js"></script>
    <script>
      window.googletag = window.googletag || {cmd: []};
      googletag.cmd.push(function() {
        googletag
            .defineSlot(
                '/6355419/Travel/Europe/France/Paris', [300, 250], 'banner-ad')
            .addService(googletag.pubads());
        googletag.enableServices();
      });
    </script>
	
	
	

	
	
	
	
	
  </head>
  <body class="" style="background-color: #fff !important;">
	<nav class="navbar mainNav navbar-expand-md bg-info bg-gradient" style="background-color: #237ba6 !important; " >
	  <div class="container">
        <a class="navbar-brand" href="<?php echo $config['site_url']; ?>"><i class="fa fa-refresh fa-spin fa-fw"></i><?php echo $config['site_logo']; ?></a>
       
       <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false">
          <span class="navbar-toggler-icon" style="color: #fff;font-size: 25px;padding: 6px;">   <i class="fa fa-bars"></i></span>
        </button>

        <div class="navbar-collapse collapse" id="navbar">
          <ul class="navbar-nav ml-auto">
			<?php if($is_online) { ?>
				
				
				<li class="nav-item dropdown">
				  <a class="nav-link" href="<?=GenerateURL('deposit')?>"  aria-haspopup="true" aria-expanded="false"><i class="fa fa-shopping-cart fa-fw"></i> <?php echo "Add Coins"; ?></a>
				</li>
						
				
				
				
				
				
			<?php } else { ?>
				<li class="nav-item">
				  <a class="nav-link" href="javascript:void(0)" data-toggle="modal" data-target="#login_box"><i class="fa fa-sign-in"></i> <?=$lang['b_264']?></a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" href="<?=GenerateURL('register')?>"><i class="fa fa-key"></i> <?=$lang['b_07']?></a>
				  
				   
				</li>
			<?php } ?>
				<li class="nav-item dropdown">
				  <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bars"></i> <?php echo $lang['b_266']; ?></a>
				  
				  
				  <div class="dropdown-menu" aria-labelledby="dropdown">
				      
				    
					<a class="dropdown-item" href="<?=GenerateURL('info')?>"><i class="fa fa-info fa-fw"></i> <?php echo $lang['b_05']; ?></a>
					<a class="dropdown-item" href="<?=GenerateURL('tos')?>"><i class="fa fa-exclamation-circle fa-fw"></i> <?php echo $lang['b_73']; ?></a>
					<a class="dropdown-item" href="<?=GenerateURL('contact')?>"><i class="fa fa-envelope fa-fw"></i> <?php echo $lang['b_22']; ?></a>
					<?php if($is_online && $data['admin'] == 1){  ?>
					<a class="dropdown-item" href="<?=$config['site_url']?>/admin-panel/" target="_blank"><i class="fa fa-lock fa-fw"></i> Admin Panel</a>
					<?php } ?>
				   </div>
				</li>
		  </ul>
        </div>
      </div>
    </nav>

<?php if(!$is_online) { ?>
	<div class="modal fade text-center" id="login_box">
	  <div class="modal-dialog modal-dialog-centered">
		<div class="col-lg-8 col-sm-8 col-12 main-section">
		  <div class="modal-content">
			<div class="col-lg-12 col-sm-12 col-12 user-img">
			  <img src="template/<?=$config['theme']?>/static/images/login.png">
			</div>
			<div class="col-lg-12 col-sm-12 col-12 user-name">
			  <h1>User Login</h1>
			  <button type="button" class="close" data-dismiss="modal">×</button>
			</div>
			<div class="col-lg-12 col-sm-12 col-12 form-input">
			  <form method="post">
				<?=$errMessage?>
				<input type="hidden" name="token" value="<?php echo $token; ?>" />
				<div class="form-group">
					<div class="input-group mb-2 mr-sm-2">
						<div class="input-group-prepend"><div class="input-group-text"><i class="fa fa-user"></i></div></div>
						<input type="text" class="form-control" name="user" placeholder="<?=$lang['b_18']?>" required>
					</div>
				</div>
				<div class="form-group">
					<div class="input-group mb-2 mr-sm-2">
						<div class="input-group-prepend"><div class="input-group-text"><i class="fa fa-key"></i></div></div>
						<input type="password" class="form-control" name="password" placeholder="<?=$lang['b_19']?>" required>
					</div>
				</div>
				<div class="form-group text-left">
				  <input type="checkbox" name="remember" /> <?=$lang['b_20']?>
				</div>
				<button type="submit" name="connect" class="btn btn-success"><?=$lang['b_264']?></button>
			  </form>
			</div>
			<div class="col-lg-12 col-sm-12 col-12 link-part">
				<a href="<?=GenerateURL('recover')?>"><?=$lang['b_21']?></a>
			</div>
		  </div>
		</div>
	  </div>
	</div>
	<?php if(!empty($actMessage)) { ?>
	<div class="modal fade text-center" id="confirm_box">
	  <div class="modal-dialog modal-dialog-centered">
		<div class="col-lg-8 col-sm-8 col-12 main-section">
		  <div class="modal-content p-3">
			<?=$actMessage?>
		  </div>
		</div>
	  </div>
	</div>
	<?php } ?>
<?php } ?>

 	<script>
		function get_ads(size,id){
						
			$.ajax({
					type: "POST",
					url: "system/ajax.php",
					data : 'ads='+ads+'&size='+size,
					success: function(z) {					
						if(z !=0){
							$('#'+id).html(z);
						}
					}
					
			});
			
			
		
		}	
	</script>