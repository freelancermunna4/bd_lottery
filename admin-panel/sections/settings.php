<?php
	if(! defined('BASEPATH') ){ exit('Unable to view file.'); }
	$message = '';
	if(isset($_POST['submit'])){
		$posts = $db->EscapeString($_POST['set']);
		foreach ($posts as $key => $value){
			if($config[$key] != $value){
				if($key == 'pay_min')
				{
					$value = ($value < 0 ? 0.00 : number_format($value, 2));
				}

				$db->Query("UPDATE `site_config` SET `config_value`='".$value."' WHERE `config_name`='".$key."'");
				$config[$key] = $value;
			}
		}
		
		$message = '<div class="alert success"><span class="icon"></span><strong>Success!</strong> Settings successfully changed</div>';
	}
?>
<section id="content" class="container_12"><?=$message?>
	<div class="grid_6">
		<form action="" method="post" class="box">
			<div class="header">
				<h2>General Settings</h2>
			</div>
			<div class="content">
				<div class="row">
					<label><strong>Site Title</strong></label>
					<div><input type="text" name="set[site_name]" value="<?=$config['site_name']?>" required /></div>
				</div>
				<div class="row">
					<label><strong>Site Logo</strong></label>
					<div><input type="text" name="set[site_logo]" value="<?=$config['site_logo']?>" required /></div>
				</div>
				<div class="row">
					<label><strong>Site Description</strong><small>Website meta description</small></label>
					<div><textarea name="set[site_description]" required><?=$config['site_description']?></textarea></div>
				</div>
				<div class="row">
					<label><strong>Site Keywords</strong><small>Meta keywords separated by comma</small></label>
					<div><textarea name="set[site_keywords]" required><?=$config['site_keywords']?></textarea></div>
				</div>
				<div class="row">
					<label><strong>Site URL</strong><small>Without trailing slash</small></label>
					<div><input type="text" name="set[site_url]" value="<?=$config['site_url']?>" required /></div>
				</div>
				<div class="row">
					<label><strong>Default Language</strong></label>
					<div><select name="set[def_lang]"><?=$set_def_lang?></select></div>
				</div>
				<div class="row">
					<label><strong>Theme</strong></label>
					<div><select name="set[theme]"><?=$set_def_theme?></select></div>
				</div>
				<div class="row">
					<label><strong>Analytics ID</strong><small>Google Analytics tracking ID</small></label>
					<div><input type="text" name="set[analytics_id]" value="<?=$config['analytics_id']?>" placeholder="Leave blank to disable!" /></div>
				</div>
			</div>
			<div class="actions">
				<div class="right">
					<input type="submit" value="Submit" name="submit" />
				</div>
			</div>
		</form>
		
		<form action="" method="post" class="box">
			<div class="header">
				<h2>Login Attempts</h2>
			</div>
			<div class="content">
				<div class="row">
					<label><strong>Max login attempts</strong><small>How many times user can try to login before getting blocked!</small></label>
					<div><input type="text" name="set[login_attempts]" value="<?=$config['login_attempts']?>" maxlength="3" required="required" /></div>
				</div>
				<div class="row">
					<label><strong>Login Cooldown</strong><small>How many minutes user must way before he can try again to login!</small></label>
					<div><input type="text" name="set[login_wait_time]" value="<?=$config['login_wait_time']?>" maxlength="3" required="required" /></div>
				</div>
			</div>
			<div class="actions">
				<div class="right">
					<input type="submit" value="Submit" name="submit" />
				</div>
			</div>
		</form>
	</div>
	<div class="grid_6">
		<form method="post" class="box">
			<div class="header">
				<h2>Registration Settings</h2>
			</div>
			<div class="content">
				<div class="row">
					<label><strong>Coins on Signup</strong><small>Coins added after registration</small></label>
					<div><input type="text" name="set[reg_coins]" value="<?=$config['reg_coins']?>" required /></div>
				</div>
				<div class="row">
					<label><strong>1 account per IP</strong></label>
					<div><select name="set[more_per_ip]"><option value="0">Yes</option><option value="1"<?=($config['more_per_ip'] != 0 ? ' selected' : '')?>>No</option></select></div>
				</div>
				<div class="row">
					<label><strong>Email Confirmation</strong></label>
					<div><select name="set[reg_reqmail]"><option value="1">Enabled</option><option value="0"<?=($config['reg_reqmail'] != 1 ? ' selected' : '')?>>Disabled</option></select></div>
				</div>
			</div>
			<div class="actions">
				<div class="right">
					<input type="submit" value="Submit" name="submit" />
				</div>
			</div>
		</form>
		
		<form method="post" class="box">
			<div class="header">
				<h2>Referral System</h2>
			</div>
			<div class="content">
				<div class="row">
					<label><strong>User Commission</strong><small>% of coins earned by referral</small></label>
					<div><input type="text" name="set[ref_commission]" value="<?=$config['ref_commission']?>" required /></div>
				</div>
			</div>
			<div class="actions">
				<div class="right">
					<input type="submit" value="Submit" name="submit" />
				</div>
			</div>
		</form>
		<?php
			if(file_exists(BASE_PATH.'/template/'.$config['theme'].'/pages/horserace.php')) {
		?>
		<form action="" method="post" class="box">
			<div class="header">
				<h2>HorseRace Settings</h2>
			</div>
			<div class="content">
				<div class="row">
					<label><strong>Ticket Price</strong></label>
					<div><input type="text" name="set[hs_ticket_price]" value="<?=$config['hs_ticket_price']?>" required="required" /></div>
				</div>
				<div class="row">
					<label><strong>Max Tickets</strong><small>How many tickets can buy in the same time.</small></label>
					<div><input type="text" name="set[hs_max_tickets]" value="<?=$config['hs_max_tickets']?>" required="required" /></div>
				</div>
			</div>
			<div class="actions">
				<div class="right">
					<input type="submit" value="Submit" name="submit" />
				</div>
			</div>
		</form>
		<?php } ?>
	</div>
</section>