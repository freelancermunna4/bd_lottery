<?php
	if(! defined('BASEPATH') ){ exit('Unable to view file.'); }
		
	// Load Captcha Library
	switch ($config['captcha_sys']) {
		case 1:
			include('system/libs/recaptcha/autoload.php');
			break;
		case 2:
			include('system/libs/solvemedialib.php');
			break;
	}

	$IP = VisitorIP();
	$IP = ($IP != '' ? $IP : 0);

	$countries = $db->QueryFetchArrayAll("SELECT id,country,code FROM `list_countries` ORDER BY country ASC");
	$ctrs = array();
	foreach($countries as $row) {
		$ctrs[] = $row['id'];
	}

	$errMessage = '';
	if(isset($_POST['register'])){
		$name = $db->EscapeString($_POST['username']);
		$email = $db->EscapeString($_POST['email']);
		$email2 = $db->EscapeString($_POST['email2']);
		$gender = $db->EscapeString($_POST['gender']);
		$pass1 = $db->EscapeString($_POST['password']);
		$pass2 = $db->EscapeString($_POST['password2']);
		$subs = (isset($_POST['subscribe']) ? 1 : 0);
		$country = $db->EscapeString($_POST['country']);
		
		$captcha_valid = 1;
		if($config['captcha_sys'] == 1){
			$recaptcha = new \ReCaptcha\ReCaptcha($config['recaptcha_sec']);
			$recaptcha = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
		
			if($recaptcha->isSuccess()){
				$captcha_valid = 1;
			}else{
				$captcha_valid = 0;
			}
		}elseif($config['captcha_sys'] == 2){
			$solvemedia_response = solvemedia_check_answer($config['solvemedia_v'],$_SERVER["REMOTE_ADDR"],$_POST["adcopy_challenge"],$_POST["adcopy_response"],$config['solvemedia_h']);
			if(!$solvemedia_response->is_valid){
				$captcha_valid = 0;
			}else{
				$captcha_valid = 1;
			}
		}
		
		if(!isset($_SESSION['token']) || $_SESSION['register_token'] != $_POST['token']){
			$errMessage = '<div class="alert alert-danger" role="alert">'.$lang['b_112'].'</div>';
		}elseif(!$captcha_valid){
			$errMessage = '<div class="alert alert-danger" role="alert">'.$lang['b_113'].'</div>';
		}elseif(!isUserID($name)) {
			$errMessage = '<div class="alert alert-danger" role="alert">'.$lang['b_114'].'</div>';
		}elseif(!isEmail($email)) {
			$errMessage = '<div class="alert alert-danger" role="alert">'.$lang['b_115'].'</div>';
		}elseif(!checkPwd($pass1,$pass2)) {
			$errMessage = '<div class="alert alert-danger" role="alert">'.$lang['b_116'].'</div>';
		}elseif($email != $email2) {
			$errMessage = '<div class="alert alert-danger" role="alert">'.$lang['b_117'].'</div>';
		}elseif($gender != 1 && $gender != 2) {
			$errMessage = '<div class="alert alert-danger" role="alert">'.$lang['b_118'].'</div>';
		}elseif($db->QueryGetNumRows("SELECT id FROM `users` WHERE `username`='".$name."' OR `email`='".$email."' LIMIT 1") > 0) {
			$errMessage = '<div class="alert alert-danger" role="alert">'.$lang['b_119'].'</div>';
		}elseif($config['more_per_ip'] != 1 && isset($_COOKIE['AccExist'])) {
			$errMessage = '<div class="alert alert-danger" role="alert">'.$lang['b_120'].'</div>';
		}elseif($config['more_per_ip'] != 1 && $db->QueryGetNumRows("SELECT id FROM `users` WHERE `reg_ip`='".$IP."' OR `log_ip`='".$IP."' LIMIT 1") > 0) {
			$errMessage = '<div class="alert alert-danger" role="alert">'.$lang['b_120'].'</div>';
		}elseif(!in_array($country, $ctrs)) {
			$errMessage = '<div class="alert alert-danger" role="alert">'.$lang['b_121'].'</div>';
		}else{
			$activate = 0;
			$referal = (isset($_COOKIE['PT_REF_ID']) ? $db->EscapeString($_COOKIE['PT_REF_ID']) : 0);

			if($referal != 0 && $db->QueryGetNumRows("SELECT id FROM `users` WHERE `id`='".$referal."' LIMIT 1") == 0) {
				$referal = 0;
			}

			if($config['reg_reqmail'] == 1){
				require('system/libs/PHPMailer/PHPMailerAutoload.php');
				$activate = GenerateKey(32);
				
				$mailer = new PHPMailer();
				
				if($config['mail_delivery_method'] == 1){
					$mailer->isSMTP();
					$mailer->Host = $config['smtp_host'];
					$mailer->Port = $config['smtp_port'];

					if(!empty($config['smtp_auth'])){
						$mailer->SMTPSecure = $config['smtp_auth'];
					}
					$mailer->SMTPAuth = (empty($config['smtp_username']) || empty($config['smtp_password']) ? false : true);
					if($mailer->SMTPAuth){
						$mailer->Username = $config['smtp_username'];
						$mailer->Password = $config['smtp_password'];
					}
				}
				
				$mailer->AddAddress($email, $name);
				$mailer->SetFrom((!empty($config['noreply_email']) ? $config['noreply_email'] : $config['site_email']), $config['site_name']);
				$mailer->Subject = 'Activate your account';
				$mailer->MsgHTML('<html>
									<body style="font-family: Verdana; color: #333333; font-size: 12px;">
										<table style="width: 400px; margin: 0px auto;">
											<tr style="text-align: center;">
												<td style="border-bottom: solid 1px #cccccc;"><h1 style="margin: 0; font-size: 20px;"><a href="'.$config['site_url'].'" style="text-decoration:none;color:#333333"><b>'.$config['site_name'].'</b></a></h1><h2 style="text-align: right; font-size: 14px; margin: 7px 0 10px 0;">Activate your account</h2></td>
											</tr>
											<tr style="text-align: justify;">
												<td style="padding-top: 15px; padding-bottom: 15px;">
													Hello '.$name.',
													<br /><br />
													Click on this link to activate your account:<br />
													<a href="'.$config['site_url'].'/?page=activate&code='.$activate.'">'.$config['site_url'].'/?page=activate&code='.$activate.'</a>
												</td>
											</tr>
											<tr style="text-align: right; color: #777777;">
												<td style="padding-top: 10px; border-top: solid 1px #cccccc;">
													Best Regards!
												</td>
											</tr>
										</table>
									</body>
								</html>');
				$mailer->Send();
			}

			$passc = MD5($pass1);
			if(isset($_COOKIE['RefSource'])){
				$ref_source = $db->EscapeString($_COOKIE['RefSource']);
			}else{
				$ref_source = '0';
			}
			
			if(!isset($_COOKIE['AccExist'])){
				setcookie('AccExist', $name, time()+604800, '/');
			}
			
			$db->Query("INSERT INTO `users`(`email`,`username`,`country_id`,`gender`,`coins`,`reg_ip`,`password`,`ref`,`reg_time`,`newsletter`,`activate`,`ref_source`) VALUES ('".$email."','".$name."','".$country."','".$gender."','".$config['reg_coins']."','".$IP."','".$passc."','".$referal."','".time()."','".$subs."','".$activate."','".$ref_source."')");

			$user_id = $db->GetLastInsertId();
			if($config['reg_reqmail'] != 1 && $user_id > 0) {
				$_SESSION['PT_User'] = $user_id;
				redirect($config['site_url']);
			}
			
			$errMessage = '<div class="alert alert-success" role="alert">'.($config['reg_reqmail'] == 1 ? $lang['b_122'] : $lang['b_123']).'</div>';
		}
	}
?>
	<script type="text/javascript">
		function check_username(){var b=$('#username').val();if(b.length<3){$('#username').addClass('is-invalid')}else{$.get("system/ajax.php?a=checkUser",{data:b},function(a){if(a==1){$('#username').removeClass('is-invalid').addClass('is-valid')}else{$('#username').removeClass('is-valid').addClass('is-invalid')}})}}function check_email(){var b=$('#email').val();if(b.length<6){$('#email').addClass('is-invalid')}else{$.get("system/ajax.php?a=checkEmail",{data:b},function(a){if(a==1){$('#email').removeClass('is-invalid').addClass('is-valid')}else{$('#email').removeClass('is-valid').addClass('is-invalid')}})}}function check_email2(){var a=new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);var b=$('#email').val();var c=$('#repeat_email').val();if(!a.test(c)){$('#repeat_email').removeClass('is-valid').addClass('is-invalid')}else if(b==c){$('#repeat_email').removeClass('is-invalid').addClass('is-valid')}else{$('#repeat_email').removeClass('is-valid').addClass('is-invalid')}}
	</script>

    <main role="main" class="container">
        
        
        
        
      <div class="row">
          
		<div class="col-12 ">
			<div class="my-3 ml-2 p-3 bg-white rounded box-shadow box-style">
				<div id="grey-box">
					<div class="title">
						<?=$lang['b_07']?>
					</div>
					
					<div class="content">
						<?=$errMessage?>
						<form method="post">
						  <input type="hidden" name="token" value="<?=GenRegisterToken()?>">
						  <div class="form-row">
							<div class="form-group col-md-6">
							  <label for="username"><?=$lang['b_124']?></label>
							  <div class="input-group mb-2 mr-sm-2">
								<div class="input-group-prepend"><div class="input-group-text"><i class="fa fa-user"></i></div></div>
								<input type="text" class="form-control" id="username" name="username" placeholder="John_Doe" onchange="check_username()">
							  </div>
							 </div>
						  </div>
						  <div class="form-row">
							<div class="form-group col-md-6">
							  <label for="email"><?=$lang['b_55']?></label>
							  <div class="input-group mb-2 mr-sm-2">
								<div class="input-group-prepend"><div class="input-group-text"><i class="fa fa-envelope"></i></div></div>
								<input type="email" class="form-control" id="email" name="email" placeholder="name@domain.com" onchange="check_email()">
							  </div>
							</div>
							<div class="form-group col-md-6">
							  <label for="repeat_email"><?=$lang['b_125']?></label>
							  <div class="input-group mb-2 mr-sm-2">
								<div class="input-group-prepend"><div class="input-group-text"><i class="fa fa-envelope"></i></div></div>
								<input type="email" class="form-control" id="repeat_email" name="email2" placeholder="name@domain.com" onchange="check_email2()">
							  </div>
							</div>
						  </div>
						  <div class="form-row">
							<div class="form-group col-md-6">
							  <label for="password"><?=$lang['b_82']?></label>
							  <div class="input-group mb-2 mr-sm-2">
								<div class="input-group-prepend"><div class="input-group-text"><i class="fa fa-key"></i></div></div>
								<input type="password" class="form-control" id="password" name="password" placeholder="1234">
							  </div>
							</div>
							<div class="form-group col-md-6">
							  <label for="repeat_password"><?=$lang['b_89']?></label>
							  <div class="input-group mb-2 mr-sm-2">
								<div class="input-group-prepend"><div class="input-group-text"><i class="fa fa-key"></i></div></div>
								<input type="password" class="form-control" id="repeat_password" name="password2" placeholder="1234">
							  </div>
							</div>
						  </div>
						  <div class="form-row">
							<div class="form-group col-md-6">
							  <label for="gender"><?=$lang['b_126']?></label>
							  <select id="gender" name="gender" class="form-control custom-select">
								<option value="0">Choose...</option>
								<option value="1"><?=$lang['b_127']?></option>
								<option value="2"><?=$lang['b_128']?></option>
							  </select>
							</div>
							<div class="form-group col-md-6">
							  <label for="country"><?=$lang['b_129']?></label>
							  <select id="country" name="country" class="form-control custom-select">
								<?php
									if($c_done == 1){
										$ctr = $db->QueryFetchArray("SELECT country,id FROM `list_countries` WHERE `code`='".$country."'"); 
										echo '<option value="'.$ctr['id'].'">'.$ctr['country'].'</option>';
									}else{
										$countries = $db->QueryFetchArrayAll("SELECT country,id FROM `list_countries` ORDER BY country ASC"); 
										echo '<option value="0">Choose...</option>';
										foreach($countries as $country){ 
											echo '<option value="'.$country['id'].'">'.$country['country'].'</option>';
										}
									}
								?>
							  </select>
							</div>
						  </div>
							<?php 
								if($config['captcha_sys'] == 1 || $config['captcha_sys'] == 2) {
									echo '<p>';
									
									if($config['captcha_sys'] == 1){
										echo '<script src="https://www.google.com/recaptcha/api.js"></script><div class="g-recaptcha" data-sitekey="'.$config['recaptcha_pub'].'"></div>';
									}elseif($config['captcha_sys'] == 2){
										echo solvemedia_get_html($config['solvemedia_c']);
									}

									echo '</p>';
								} 
							  ?>
						  <div class="form-group">
							<div class="form-check">
							  <input class="form-check-input" type="checkbox" id="newsletter" name="subscribe">
							  <label class="form-check-label" for="newsletter">
								<?=$lang['b_84']?>
							  </label>
							</div>
						  </div>
						  <button type="submit" name="register" class="btn btn-primary"><?=$lang['b_07']?></button>
						</form>
					</div>
				</div>
			</div>
		</div>
	  </div>
    </main>