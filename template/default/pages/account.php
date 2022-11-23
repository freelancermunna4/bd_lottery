<?php
	if(! defined('BASEPATH') ){ exit('Unable to view file.'); }

	$errMessage = '';
	if(isset($_POST['change_pass']))
	{
		if (MD5($_POST['old_password']) != $data['password']) {
			$errMessage = '<div class="alert alert-danger" role="alert">'.$lang['b_74'].'</div>';
		}elseif(!checkPwd($_POST['password'],$_POST['password2'])) {
			$errMessage = '<div class="alert alert-danger" role="alert">'.$lang['b_75'].'</div>';
		}else{
			$enpass = MD5($_POST['password']);
			$db->Query("UPDATE `users` SET `password`='".$enpass."' WHERE `id`='".$data['id']."'");
			$errMessage = '<div class="alert alert-success" role="alert">'.$lang['b_76'].'</div>';
		}
	}
	
	if(isset($_POST['change_email']))
	{
		$email = $db->EscapeString($_POST['email']);
		$password = $db->EscapeString($_POST['password']);
		$subs = isset($_POST['subscribe']) ? 1 : 0;

		if (MD5($_POST['password']) != $data['password']) {
			$errMessage = '<div class="alert alert-danger" role="alert">'.$lang['b_77'].'</div>';
		}elseif(!isEmail($email)) {
			$errMessage = '<div class="alert alert-danger" role="alert">'.$lang['b_78'].'</div>';
		}elseif($db->QueryGetNumRows("SELECT id FROM `users` WHERE `email`='".$email."' LIMIT 1") > 0 && $data['email'] != $email){
			$errMessage = '<div class="alert alert-danger" role="alert">'.$lang['b_79'].'</div>';
		}else{
			$db->Query("UPDATE `users` SET `email`='".$email."', `newsletter`='".$subs."' WHERE `id`='".$data['id']."'");
			$errMessage = '<div class="alert alert-success" role="alert">'.$lang['b_80'].'</div>';
		}
	}

    if(isset($_POST['del_acc'])){
        $pass = MD5($_POST['password']);
        if($db->QueryGetNumRows("SELECT id FROM `users` WHERE `id`='".$data['id']."' AND `pass`='".$pass."'") == 0){
            $errMessage = '<div class="alert alert-danger" role="alert">'.$lang['b_357'].'</div>';
        }else{
            $db->Query("INSERT INTO `users_deleted` (`id`,`email`,`login`,`pass`,`sex`,`country`,`time`) values('".$data['id']."','".$data['email']."','".$data['login']."','".$data['password']."','".$data['sex']."','".$data['country']."',NOW())");
            $db->Query("DELETE FROM `users` WHERE `id` = '".$data['id']."' AND `password`='".$pass."'");
            if(isset($_COOKIE['PESAutoLogin'])){
                setcookie('PESAutoLogin', '0', time()-604800);
            }
            session_destroy();
            redirect($config['site_url']);
        }
    }
?> 
	<main role="main" class="container">
      <div class="row">
		<?php 
			require_once(BASE_PATH.'/template/'.$config['theme'].'/common/sidebar.php');
		?>
	  <div class="col-md-9 col-sm-7 col-xs-7">
			<div class="my-3 ml-2 p-3 bg-white rounded box-shadow box-style">
				<?=$errMessage?>
				<div id="grey-box">
					<div class="title">
						<?=$lang['b_11']?>
					</div>
					<div class="content">
						<form method="post">
						  <div class="form-row">
							<div class="form-group col-md-6">
							  <label for="email"><?=$lang['b_55']?></label>
							  <div class="input-group mb-2 mr-sm-2">
								<div class="input-group-prepend"><div class="input-group-text"><i class="fa fa-envelope"></i></div></div>
								<input type="text" class="form-control" id="email" name="email" placeholder="<?=$data['email']?>">
							  </div>
							</div>
							<div class="form-group col-md-6">
							  <label for="password"><?=$lang['b_82']?></label>
							  <div class="input-group mb-2 mr-sm-2">
								<div class="input-group-prepend"><div class="input-group-text"><i class="fa fa-key"></i></div></div>
								<input type="password" class="form-control" id="password" name="password" placeholder="******">
								<input type="submit" class="btn btn-primary d-inline" name="change_email" value="<?=$lang['b_81']?>" />
							  </div>
						    </div>
							<div class="form-group col-md-6">
								<?=$lang['b_84']?> <input type="radio" name="subscribe" value="1" <?=(!isset($_POST['subscribe']) && $data['newsletter'] == 1 ? 'checked="checked" ' : (isset($_POST['subscribe']) && $_POST['subscribe'] == 1 ? 'checked="checked" ' : ''))?>/> <?=$lang['b_85']?> <input type="radio" name="subscribe" value="0" <?=(!isset($_POST['subscribe']) && $data['newsletter'] == 0 ? 'checked="checked" ' : (isset($_POST['subscribe']) && $_POST['subscribe'] == 0 ? 'checked="checked" ' : ''))?>/> <?=$lang['b_86']?>
							</div>
						  </div>
						</form>
					</div>
				</div>
				<div id="grey-box" class="mt-2">
					<div class="title">
						<?=$lang['b_93']?>
					</div>
					<div class="content">
						<form method="post">
						  <div class="form-row">
							<div class="form-group col-md-6">
							  <label for="old_password"><?=$lang['b_87']?></label>
							  <div class="input-group mb-2 mr-sm-2">
								<div class="input-group-prepend"><div class="input-group-text"><i class="fa fa-key"></i></div></div>
								<input type="password" class="form-control" id="old_password" name="old_password" placeholder="*******">
							  </div>
							</div>
						  </div>
						  <div class="form-row">
							<div class="form-group col-md-6">
							  <label for="password"><?=$lang['b_88']?></label>
							  <div class="input-group mb-2 mr-sm-2">
								<div class="input-group-prepend"><div class="input-group-text"><i class="fa fa-key"></i></div></div>
								<input type="password" class="form-control" id="password" name="password" placeholder="Shd67SHB">
							  </div>
							</div>
							<div class="form-group col-md-6">
							  <label for="password2"><?=$lang['b_89']?></label>
							  <div class="input-group mb-2 mr-sm-2">
								<div class="input-group-prepend"><div class="input-group-text"><i class="fa fa-key"></i></div></div>
								<input type="password" class="form-control" id="password2" name="password2" placeholder="Shd67SHB">
								<input type="submit" class="btn btn-primary d-inline" name="change_pass" value="<?=$lang['b_93']?>" />
							  </div>
						    </div>
						  </div>
						</form>
					</div>
				</div>
				<div id="grey-box" class="mt-2">
					<div class="title">
						<?=$lang['b_276']?>
					</div>
					<div class="content">
						<form method="post">
							<div class="form-group col-md-6">
							  <label for="password"><?=$lang['b_82']?></label>
							  <div class="input-group mb-2 mr-sm-2">
								<div class="input-group-prepend"><div class="input-group-text"><i class="fa fa-key"></i></div></div>
								<input type="password" class="form-control" id="password" name="password" placeholder="Shd67SHB">
								<input type="submit" class="btn btn-danger d-inline" name="del_acc" value="<?=$lang['b_276']?>" onclick="return confirm('You sure you want to delete your account?');" />
							  </div>
						    </div>
						  </div>
						</form>
					</div>
				</div>
			</div>
	  </div>
    </main>