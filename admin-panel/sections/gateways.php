<?php
	if(! defined('BASEPATH') ){ exit('Unable to view file.'); }

	$message = '';
	if(isset($_POST['edit_paypal'])){
		$posts = $db->EscapeString($_POST['set']);
		foreach ($posts as $key => $value){
			if($config[$key] != $value){
				if($key == 'paypal_status'){
					$value = ($value > 2 ? 2 : ($value < 0 ? 0 : $value));
				}

				$db->Query("UPDATE `site_config` SET `config_value`='".$value."' WHERE `config_name`='".$key."'");
				$config[$key] = $db->EscapeString($value);
			}
		}
		
		$message = '<div class="alert success"><span class="icon"></span><strong>Success!</strong> Settings successfully changed</div>';
	}

	if(isset($_POST['edit_bank'])){
		$posts = $db->EscapeString($_POST['set3']);
		foreach ($posts as $key => $value){
			if($config[$key] != $value){
				if($key == 'bank_status'){
					$value = ($value > 2 ? 2 : ($value < 0 ? 0 : $value));
				}

				$db->Query("UPDATE `site_config` SET `config_value`='".$value."' WHERE `config_name`='".$key."'");
				$config[$key] = $db->EscapeString($value);
			}
		}
		
		$message = '<div class="alert success"><span class="icon"></span><strong>Success!</strong> Settings successfully changed</div>';
	}
?>
<section id="content" class="container_12"><?=$message?>
	<div class="grid_6">
		<form action="" method="post" class="box">
			<div class="header">
				<h2>Paypal</h2>
			</div>
			<div class="content">
				<div class="row">
					<label><strong>Paypal Email</strong></label>
					<div><input type="text" name="set[paypal]" value="<?=$config['paypal']?>" required="required" /></div>
				</div>
				<div class="row">
					<label><strong>Status</strong></label>
					<div><select name="set[paypal_status]"><option value="0">Disabled</option><option value="1"<?=($config['paypal_status'] == 1 ? ' selected' : '')?>>Receive & Send</option><option value="2"<?=($config['paypal_status'] == 2 || isset($_POST['paypal_status']) && $_POST['paypal_status'] == 2 ? ' selected' : '')?>>Receive Only</option></select></div>
				</div>
			</div>
			<div class="actions">
				<div class="right">
					<input type="submit" name="edit_paypal" value="Submit" />
				</div>
			</div>
		</form>

		<form action="" method="post" class="box">
			<div class="header">
				<h2>Bank Transfer</h2>
			</div>
			<div class="content">
				<div class="row">
					<label><strong>Bank Details</strong></label>
					<div><textarea name="set3[bank_details]" required="required" /><?=$config['bank_details']?></textarea></div>
				</div>
				<div class="row">
					<label><strong>Status</strong></label>
					<div><select name="set3[bank_status]"><option value="0">Disabled</option><option value="1"<?=($config['bank_status'] == 1 ? ' selected' : '')?>>Receive & Send</option><option value="2"<?=($config['bank_status'] == 2 || isset($_POST['bank_status']) && $_POST['bank_status'] == 2 ? ' selected' : '')?>>Receive Only</option></select></div>
				</div>
			</div>
			<div class="actions">
				<div class="right">
					<input type="submit" name="edit_bank" value="Submit" />
				</div>
			</div>
		</form>
	</div>
	<div class="grid_6">
		<div class="box">
			<div class="header">
				<h2>Paypal Instructions</h2>
			</div>
			<div class="content">
				<p><b>PayPal Email</b> = Here you have to add your primary PayPal email</p>
				<p><b>Status</b> = Enable or Disable this payment gateway. Also, you can choose to use it only to receive money (without allowing users to request payments using this payment gateway).</p>
			</div>
		</div>
	</div>
</section>