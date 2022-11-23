<?php
if(! defined('BASEPATH') ){ exit('Unable to view file.'); }
if(isset($_GET['del']) && is_numeric($_GET['del'])){
	$del = $db->EscapeString($_GET['del']);
	if($db->QueryGetNumRows("SELECT * FROM `users` WHERE `id`='".$del."' LIMIT 1") > 0){
		$db->Query("DELETE FROM `users` WHERE `id`='".$del."'");
		$db->Query("UPDATE `users` SET `ref`='0' WHERE `ref`='".$del."'");
	}
}elseif(isset($_GET['confirm']) && is_numeric($_GET['confirm'])){
	$confirm = $db->EscapeString($_GET['confirm']);
	$db->Query("UPDATE `users` SET `activate`='0' WHERE `id`='".$confirm."'");
}

if(isset($_GET['edit']) && is_numeric($_GET['edit'])){
	$id = $db->EscapeString($_GET['edit']);
	$edit = $db->QueryFetchArray("SELECT * FROM `users` WHERE `id`='".$id."' LIMIT 1");
	$membership_days = round(($edit['membership']-time())/86400, 0);
}

$order_value = 'id ASC';
$order_by = (isset($_GET['oby']) ? $_GET['oby'] : '');
$sorting = (isset($_GET['sort']) ? $_GET['sort'] : '');
if(!empty($sorting) && !empty($order_by)){
	$sort = ($sorting == 'asc' ? 'ASC' : 'DESC');
	if($order_by == 1){
		$order_value = 'id '.$sort;
	}elseif($order_by == 2){
		$order_value = 'coins '.$sort;
	}elseif($order_by == 3){
		$order_value = 'total '.$sort;
	}
}

$db_value = '';
$url_value = '';
if(isset($_GET['su'])){
	$search = $db->EscapeString($_GET['su']);
	if($_GET['s_type'] == 1){
		$db_value = ($search != '' ?  " WHERE `email` LIKE '%".$search."%'" : "");
	}elseif($_GET['s_type'] == 2){
		$db_value = ($search != '' ?  " WHERE `reg_ip` LIKE '%".$search."%' OR `log_ip` LIKE '%".$search."%'" : "");
	}elseif($_GET['s_type'] == 3){
		$db_value = ($search != '' ?  " WHERE `ref_source` LIKE '%".$search."%'" : "");
	}else{
		$db_value = ($search != '' ?  " WHERE `username` LIKE '%".$search."%'" : "");
	}
}elseif(isset($_GET['online'])){
	$db_value = ' WHERE ('.time().'-`last_activity`) < 900';
	$url_value = '&online';
}elseif(isset($_GET['today'])){
	$db_value = " WHERE `reg_time` >= '".strtotime(date('d M Y'))."'";
	$order_value = 'reg_time DESC';
	$url_value = '&today';
}elseif(isset($_GET['premium'])){
	$db_value = " WHERE membership > '0'";
	$url_value = '&premium';
}elseif(isset($_GET['country'])){
	$code = $db->EscapeString($_GET['country_id']);
	$db_value = " WHERE country_id = '".$code."'";
	$url_value = '&country='.$code;
}elseif(isset($_GET['refid'])){
	$refid = $db->EscapeString($_GET['refid']);
	$db_value = " WHERE ref = '".$refid."'";
	$url_value = '&online='.$refid;
}elseif(isset($_GET['banned'])){
	$db_value = " WHERE disabled > '0'";
	$url_value = '&banned';
}elseif(isset($_GET['unverified'])){
	$db_value = " WHERE activate > '0'";
	$url_value = '&unverified';
}

$page = (isset($_GET['p']) ? $_GET['p'] : 0);
$limit = 20;
$start = (is_numeric($page) && $page > 0 ? ($page-1)*$limit : 0);

$total_pages = $db->QueryGetNumRows("SELECT id FROM users ".$db_value);
include('../system/libs/apaginate.php');

$mesaj = '';
if(isset($_GET['edit']) && $edit['username'] != ""){
	if(isset($_POST['submit'])){
		$value = ($_POST['pass'] != '' ? ", `password`='".md5($_POST['pass'])."'" : '');
		
		$name = $db->EscapeString($_POST['username']);
		$email = $db->EscapeString($_POST['email']);
		$admin = $db->EscapeString($_POST['admin']);
		$coins = $db->EscapeString($_POST['coins']);
		$country = $db->EscapeString($_POST['country']);
		$sex = ($_POST['gender'] < 0 ? 0 : ($_POST['gender'] > 2 ? 2 : $db->EscapeString($_POST['gender'])));
		$membership = $db->EscapeString($_POST['membership']);
		$membership = ($membership > 0 ? (($membership*86400)+time()) : 0);
		$activate = (isset($_POST['activate']) ? ", `activate`='0'" : '');
		
		if(!isUserID($name)){
			$mesaj = '<div class="alert error"><span class="icon"></span><strong>ERROR:</strong> Please enter an valid username!</div>';
		}elseif(!isEmail($email)){
			$mesaj = '<div class="alert error"><span class="icon"></span><strong>ERROR:</strong> Please enter a valid email address!</div>';
		}elseif($name != $edit['username'] && $db->QueryGetNumRows("SELECT id FROM `users` WHERE `username`='".$name."' ") > 0){
			$mesaj = '<div class="alert error"><span class="icon"></span><strong>ERROR:</strong> Username already registered!</div>';
		}elseif($email != $edit['email'] && $db->QueryGetNumRows("SELECT id FROM `users` WHERE `email`='".$email."'") > 0){
			$mesaj = '<div class="alert error"><span class="icon"></span><strong>ERROR:</strong> Email address already registered!</div>';
		}else{
			$db->Query("UPDATE `users` SET `username`='".$name."', `email`='".$email."', `country_id`='".$country."', `gender`='".$sex."', `admin`='".$admin."'".$value.", `coins`='".$coins."', `membership`='".$membership."'".$activate." WHERE `id`='".$id."'");
			$mesaj = '<div class="alert success"><span class="icon"></span><strong>Success!</strong> User was successfuly edited!</div>';
		}
	}elseif(isset($_POST['warn'])){
		$warn_message = $db->EscapeString($_POST['warn_message']);
		$days = 0;
		if(!empty($warn_message)){
			$days = ($_POST['days'] < 1 ? 1 : $db->EscapeString($_POST['days']));
			$days = ((86400*$days)+time());
		}
		
		if($warn_message != '' && strlen($warn_message) < 10){
			$mesaj = '<div class="alert error"><span class="icon"></span><strong>ERROR:</strong> Warning message must have at least 10 characters!</div>';
		}elseif($warn_message != '' && strlen($warn_message) > 255){
			$mesaj = '<div class="alert error"><span class="icon"></span><strong>ERROR:</strong> Warning message can\'t have more than 255 characters!</div>';
		}else{
			$db->Query("UPDATE `users` SET `warn_message`='".$warn_message."',`warn_expire`='".$days."' WHERE `id`='".$edit['id']."'");
			$mesaj = '<div class="alert success"><span class="icon"></span><strong>SUCCESS:</strong> Warning message was successfully added!</div>';
		}
	}elseif(isset($_POST['ban'])){
		$status = $db->EscapeString($_POST['status']);
		$reason = $db->EscapeString($_POST['ban_reason']);
		
		if($status == 1 && empty($reason)){
			$mesaj = '<div class="alert error"><span class="icon"></span><strong>ERROR:</strong> Please complete all fields!</div>';
		}else{
			$check = $db->QueryGetNumRows("SELECT id FROM `ban_reasons` WHERE `user`='".$edit['id']."'");
			if($check == 0 && !empty($reason)){
				$db->Query("INSERT INTO `ban_reasons` (`user`,`reason`,`date`) VALUES ('".$edit['id']."', '".$reason."', '".time()."')");
			}elseif($check > 0 && !empty($reason)){
				$db->Query("UPDATE `ban_reasons` SET `reason`='".$reason."', `date`='".time()."' WHERE `user`='".$edit['id']."'");
			}
			if($status == 0){
				$db->Query("UPDATE `users` SET `disabled`='0' WHERE `id`='".$edit['id']."'");
			}elseif($status == 1){
				$db->Query("UPDATE `users` SET `coins`='0', `disabled`='1' WHERE `id`='".$edit['id']."'");
			}
			$mesaj = '<div class="alert success"><span class="icon"></span><strong>SUCCESS!</strong> User was successfuly '.($status == 1 ? 'blocked' : 'unblocked').'!</div>';
		}
	}elseif(isset($_POST['username_as'])){
		$_SESSION['PT_User'] = $edit['id'];
		if(isset($_COOKIE['AutoLogin'])){
			setcookie('AutoLogin', '0', time()-604800);
		}
		redirect('/index.php');
	}

	$ban = $db->QueryFetchArray("SELECT reason FROM `ban_reasons` WHERE `user`='".$edit['id']."'");
	$check_ip = $db->QueryGetNumRows("SELECT id FROM `users` WHERE `reg_ip`='".$edit['reg_ip']."'");

	$check_log_ip = 0;
	if($edit['log_ip'] != '0'){
		$check_log_ip = $db->QueryGetNumRows("SELECT id FROM `users` WHERE `log_ip`='".$edit['log_ip']."'");
	}

	$u_refs = $db->QueryGetNumRows("SELECT id FROM `users` WHERE `ref`='".$edit['id']."'");
	$commissions = $db->QueryFetchArray("SELECT SUM(`commission`) AS `coins`, COUNT(*) AS `total` FROM `ref_commissions` WHERE `user`='".$edit['id']."'");
	$payouts = $db->QueryFetchArray("SELECT SUM(`cash`) AS `cash`, COUNT(`id`) AS `total` FROM `withdrawals` WHERE `user_id`='".$edit['id']."'");
?>
<section id="content" class="container_12 clearfix">
	<div class="grid_12 profile">
		<div class="header">
			<div class="title">
				<h2><?=$edit['username']?></h2><h3><?=($edit['admin'] == 1 ? 'Administrator' : 'Member')?></h3>
			</div>
			<div class="avatar">
				<img src="img/<?=((time()-$edit['last_activity']) < 3600 ? 'on' : 'off')?>.png" />
			</div>
			
			<ul class="info">
				<li>
					<a href="javascript:void(0);">
						<strong><?=number_format(isset($_POST['coins']) ? $_POST['coins'] : $edit['coins'], 2)?></strong>
						<small>Coins</small>
					</a>
				</li>
				<li>
					<a href="javascript:void(0);">
						<strong><?=number_format($payouts['total']).' - '.get_currency_symbol($config['currency_code']).number_format($payouts['cash'], 2)?></strong>
						<small>Total Payouts</small>
					</a>
				</li>
				<li>
					<a href="javascript:void(0);">
						<strong><?=(isset($_POST['membership']) ? $_POST['membership'] : ($edit['membership'] > 0 ? $membership_days : 0))?></strong>
						<small>VIP Days</small>
					</a>
				</li>
			</ul>
		</div>
		<?=$mesaj?>
		<div class="details grid_8">
			<h2>Personal Details</h2>
			<section>
				<table>
					<tr>
						<th>Username:</th><td><i><?=$edit['username']?></i></td>
					</tr>
					<tr>
						<th>Email:</th><td><i><?=$edit['email']?></i></td>
					</tr>
					<tr>
						<th>Invited By:</th><td><i><?=($edit['ref'] == 0 ? 'N/A' : '<a href="index.php?x=users&edit='.$edit['ref'].'">'.$edit['ref'].'</a>')?></i></td>
					</tr>
				</table>
			</section>
		</div>
		<div class="details grid_4">
			<h2>Referrals</h2>
			<section>
				<table>
					<tr><th>Total Referrals:</th><td><i><a href="index.php?x=users&refid=<?=$edit['id']?>"><?=number_format($u_refs)?></a></i></td></tr>
					<tr><th>Revenue:</th><td><i><?=number_format($commissions['coins'], 2)?> coins (<?=number_format($commissions['total'])?>)</i></td></tr>
				</table>
			</section>
		</div>
		<div class="details grid_6">
			<h2>Other Info</h2>
			<section>
				<table>
					<tr>
						<th>Registration date:</th><td><i><?=date('d M Y - H:i', $edit['reg_time'])?></i></td>
					</tr>
					<tr>
						<th>Last activity:</th><td><i><?=($edit['last_activity'] == 0 ? 'Never' : date('d M Y - H:i', $edit['last_activity']))?></i></td>
					</tr>
					<tr>
						<th>Registered IP:</th><td><i><a href="index.php?x=users&s_type=2&su=<?=$edit['reg_ip']?>"><?=$edit['reg_ip']?></a> <small style="font-size:10px;">(<?=$check_ip?> account<?=($check_ip > 1 ? 's' : '')?> with this IP)</small></i></td>
					</tr>
					<tr>
						<th>Latest IP used:</th><td><i><?=($edit['log_ip'] == '0' ? 'N/A' : '<a href="index.php?x=users&s_type=2&su='.$edit['log_ip'].'">'.$edit['log_ip'].'</a>')?><?if($check_log_ip != 0){?> <small style="font-size:10px;">(<?=$check_log_ip?> account<?=($check_log_ip > 1 ? 's' : '')?> with this IP)</small><?}?></i></td>
					</tr>
					<tr>
						<th>Source:</th><td><i><?=(empty($edit['ref_source']) ? 'N/A' : '<a href="'.$edit['ref_source'].'" target="_blank">'.truncate($edit['ref_source'], 40).'</a>')?></i></td>
					</tr>
				</table>
			</section>
		</div>
		<div class="details grid_6">
			<h2>Transactions</h2>
			<section>
				<table>
					<?php
						$trans = $db->QueryFetchArray("SELECT SUM(`money`) AS `money`, COUNT(*) AS `total` FROM `transactions` WHERE `user_id`='".$edit['id']."'");
					?>
					<tr><th>Transactions:</th><td><i><?=number_format($trans['total'])?></i></td><td style="width:150px"></td><th>Total money:</th><td><font style="color:green"><?=get_currency_symbol($config['currency_code']).number_format($trans['money'], 2)?></font></td></tr>
				</table>
			</section>
			<h2>Last 5 Transactions</h2>
			<section>
				<table>
				<?php
					$addeds = $db->QueryFetchArrayAll("SELECT * FROM `transactions` WHERE `user_id`='".$edit['id']."' ORDER BY date DESC LIMIT 5");
					foreach($addeds as $added){
				?>
					<tr><th><font color="green"><?=get_currency_symbol($config['currency_code']).$added['money']?></font> generated at <i><?=date('d M Y - H:i', $added['date'])?></i></th></tr>
				<?}?>
				</table>
			</section>
		</div>

		<div class="clearfix"></div>
		<div class="divider"></div>
	</div>
	<div class="grid_7">
		<form action="" method="post" class="box">
			<div class="header">
				<h2>Edit User</h2>
			</div>
				<div class="content">
					<div class="row">
						<label><strong>Username</strong></label>
						<div><input type="text" name="username" value="<?=(isset($_POST['username']) ? $_POST['username'] : $edit['username'])?>" required="required" /></div>
					</div>
					<div class="row">
						<label><strong>Email</strong></label>
						<div><input type="text" name="email" value="<?=(isset($_POST['email']) ? $_POST['email'] : $edit['email'])?>" required="required" /></div>
					</div>
					<div class="row">
						<label><strong>Password</strong></label>
						<div><input type="password" name="pass" placeholder="Leave blank if you don't want to change!" /></div>
					</div>
					<div class="row">
						<label><strong>Gender</strong></label>
						<div><select name="gender"><option value="0"></option><option value="1"<?=($edit['gender'] == 1 ? ' selected' : (isset($_POST['gender']) && $_POST['gender'] == 1 ? ' selected' : ''))?>>Male</option><option value="2"<?=($edit['gender'] == 2 ? ' selected' : (isset($_POST['gender']) && $_POST['gender'] == 2 ? ' selected' : ''))?>>Female</option></select></div>
					</div>
					<div class="row">
						<label><strong>Country</strong></label>
						<div><select name="country"><option value="0"></option>
						<?php
							$countries = $db->QueryFetchArrayAll("SELECT country,id FROM `list_countries` ORDER BY country ASC"); 
							foreach($countries as $country){echo '<option value="'.$country['id'].'"'.($edit['country_id'] == $country['id'] ? ' selected' : (isset($_POST['country']) && $_POST['country'] == $country['id'] ? ' selected' : '')).'>'.$country['country'].'</option>';}
						?>
						</select></div>
					</div>
					<div class="row">
						<label><strong>VIP Days</strong></label>
						<div><input type="text" name="membership" value="<?=(isset($_POST['membership']) ? $_POST['membership'] : ($edit['membership'] > 0 ? $membership_days : 0))?>" required="required" /></div>
					</div>
					<div class="row">
						<label><strong>Coins</strong></label>
						<div><input type="text" name="coins" value="<?=(isset($_POST['coins']) ? $_POST['coins'] : $edit['coins'])?>" required="required" /></div>
					</div>
					<div class="row">
						<label><strong>Type</strong></label>
						<div><select name="admin"><option value="0">User</option><option value="1"<?=($edit['admin'] != 0 ? ' selected' : (isset($_POST['admin']) && $_POST['admin'] == 1 ? ' selected' : ''))?>>Admin</option></select></div>
					</div>
					<?if($edit['activate'] != 0 && !isset($_POST['activate'])){?>
					<div class="row">
						<label><strong>Email address unverified</strong></label>
						<div><div><input type="checkbox" name="activate" id="activate" />  <label for="activate">Confirm email address?</label></div></div>
					</div><?}?>
                </div>
				<div class="actions">
					<div class="right">
						<input type="submit" value="Submit" name="submit" />
					</div>
				</div>
		</form>
	</div>
	<div class="grid_5">
		<form method="post" class="box">
			<div class="header">
				<h2>Warn user</h2>
			</div>
			<div class="content">
				<div class="row">
					<label><strong>Message</strong><small>Will appear on homepage!</small></label>
					<div><textarea name="warn_message"><?=(isset($_POST['warn_message']) ? $_POST['warn_message'] : $edit['warn_message'])?></textarea></div>
				</div>
				<div class="row">
					<label><strong>Days</strong><small>After how many days will expire!</small></label>
					<div><input type="text" name="days" value="<?=(isset($_POST['warn_expire']) ? $_POST['warn_expire'] : ($edit['warn_expire'] > 0 ? round(($edit['warn_expire']-time())/86400, 0) : 1))?>" required="required" /></div>
				</div>
			</div>
			<div class="actions">
				<div class="right">
					<input type="submit" value="Submit" name="warn" />
				</div>
			</div>
		</form>
		<form method="post" class="box">
			<div class="header">
				<h2>Ban User</h2>
			</div>
			<div class="content">
				<div class="row">
					<label><strong>Banned</strong></label>
					<div><select name="status"><option value="0">No</option><option value="1"<?=(!isset($_POST['status']) && $edit['disabled'] != 0 ? ' selected' : (isset($_POST['status']) && $_POST['status'] == 1 ? ' selected' : ''))?>>Yes</option></select></div>
				</div>
				<div class="row">
					<label><strong>Reason</strong><small>Why was this user banned?</small></label>
					<div><textarea name="ban_reason"><?=(isset($_POST['ban_reason']) ? $_POST['ban_reason'] : $ban['reason'])?></textarea></div>
				</div>
			</div>
			<div class="actions">
				<div class="right">
					<input type="submit" value="Submit" name="ban" />
				</div>
			</div>
		</form>
		<form method="post" class="box">
			<div class="actions">
				<div align="center">
					<input type="submit" value="username as this User" name="username_as" /><br />
					<small><i>You will be disconected from current account</i></small>
				</div>
			</div>
		</form>
	</div>
</section>
<?}elseif(isset($_GET['search'])){?>
<section id="content" class="container_12 clearfix">
	<div class="grid_12">
		<form action="" method="get" class="box">
		<input type="hidden" name="x" value="users" /> 
			<div class="header">
				<h2>Search Users</h2>
			</div>
			<div class="content">
				<div class="row">
					<label for="v1_charrange"><strong>Search</strong></label>
					<div><input type="text" name="su" required="required" /></div>
				</div>	
				<div class="row">
					<label for="v1_charrange"><strong>By</strong></label>
					<div><select name="s_type"><option value="0">Username</option><option value="1">Email</option><option value="2">IP</option><option value="3">Source</option></select></div>
				</div>				     
			</div>
			<div class="actions">
				<div class="right">
					<input type="submit" value="Search" />
				</div>
			</div>
        </form>
	</div>
</section>
<?}elseif(isset($_GET['countries'])){?>
<section id="content" class="container_12 clearfix">
	<h1 class="grid_12">Countries Overview</h1>
	<div class="grid_12">
		<div class="box">
			<table class="styled">
				<thead>
					<tr>
						<th>#</th>
						<th>Country</th>
						<th>Code</th>
						<th>Users</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
<?php
$countries = $db->QueryFetchArrayAll("SELECT a.country_id AS uc, COUNT(a.id) AS total, b.country, b.code FROM users a LEFT JOIN list_countries b ON b.id = a.country_id GROUP BY uc ORDER BY total DESC");	
$j = 0;
foreach($countries as $country){
	++$j;
?>	
					<tr>
						<td><?=$j?></td>
						<td><?=(empty($country['country']) ? 'Unknown' : $country['country'])?></td>
						<td><?=(empty($country['code']) ? 'Unknown' : $country['code'])?></td>
						<td><?=number_format($country['total'])?></td>
						<td><a href="index.php?x=users&country=<?=$country['uc']?>">View Users</a></td>
					</tr>
<?}?>
				</tbody>
			</table>
		</div>
	</div>
</section>
<?}elseif(isset($_GET['multi_accounts'])){?>
<section id="content" class="container_12 clearfix">
	<h1 class="grid_12">Multiple accounts on the same IP's</h1>
	<div class="grid_12">
		<div class="box">
			<table class="styled">
				<thead>
					<tr>
						<th>#</th>
						<th>IP Address</th>
						<th>Total Accounts</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
<?php
$accounts = $db->QueryFetchArrayAll("SELECT log_ip, COUNT(*) AS total_accounts FROM users WHERE log_ip != '' GROUP BY log_ip HAVING total_accounts > '1' ORDER BY total_accounts DESC");	
$j = 0;
foreach($accounts as $account){
	++$j;
?>	
					<tr>
						<td><?=$j?></td>
						<td><?=$account['log_ip']?></td>
						<td><b><?=number_format($account['total_accounts'])?> users</b> were logged in on this IP</td>
						<td><center><a href="index.php?x=users&s_type=2&su=<?=$account['log_ip']?>">View Users</a></center></td>
					</tr>
<?}?>
				</tbody>
			</table>
		</div>
	</div>
</section>
<?}else{?>
<section id="content" class="container_12 clearfix" data-sort=true>
	<h1 class="grid_12">Users (<?=$total_pages?>)</h1>
	<div class="grid_9">
		<div class="box">
			<table class="styled">
				<thead>
					<tr>
						<th><a href="index.php?x=users&sort=<?=($sorting == 'desc' ? 'asc' : 'desc')?>&oby=1">ID <img src="img/elements/table/sorting<?=($sorting == 'asc' && $order_by == 1 ? '-asc' : ($sorting == 'desc' && $order_by == 1 ? '-desc' : ''))?>.png" border="0" /></a></th>
						<th>Username</th>
						<th>Email</th>
						<th>Country</th>
						<th><a href="index.php?x=users&sort=<?=($sorting == 'desc' ? 'asc' : 'desc')?>&oby=2">Coins <img src="img/elements/table/sorting<?=($sorting == 'asc' && $order_by == 2 ? '-asc' : ($sorting == 'desc' && $order_by == 2 ? '-desc' : ''))?>.png" border="0" /></a></th>
						<th>Type</th>
						<th width="90">Actions</th>
					</tr>
				</thead>
				<tbody>
<?php
$users = $db->QueryFetchArrayAll("SELECT id, username, email, coins, membership, country_id, admin, disabled FROM users".$db_value." ORDER BY ".$order_value." LIMIT ".$start.",".$limit."");
foreach($users as $user){
?>	
					<tr>
						<td><?=$user['id']?></td>
						<td><?=($user['disabled'] > 0 ? '<del title="Account Banned">'.$user['username'].'</del>' : ($user['membership'] > 0 ? '<font color="green">'.$user['username'].'</font>' : $user['username']))?></td>
						<td><?=$user['email']?></td>
						<td><?=($user['country_id'] == '0' ? 'N/A' : get_country($user['country_id']))?></td>
						<td><?=number_format($user['coins'], 2)?></td>
						<td><?=($user['admin'] == 0 ? 'User' : '<b>Admin</b>')?></td>
						<td class="center">
							<a href="index.php?x=users<?=$url_value?>&edit=<?=$user['id']?>" class="button small grey tooltip" data-gravity=s title="Edit"><i class="icon-pencil"></i></a>
							<a href="index.php?x=users<?=$url_value?>&del=<?=$user['id']?>" onclick="return confirm('You sure you want to delete this user?');" class="button small grey tooltip" data-gravity=s title="Remove"><i class="icon-remove"></i></a>
							<? if(isset($_GET['unverified'])){ ?>
								<a href="index.php?x=users<?=$url_value?>&confirm=<?=$user['id']?>" onclick="return confirm('You sure you want to confirm this user email address?');" class="button small grey tooltip" data-gravity=s title="Confirm Email"><i class="icon-ok"></i></a>
							<?}?>
						</td>
					</tr>
<?}?>
				</tbody>
			</table>
			<?if($total_pages > $limit){?>
			<div class="dataTables_wrapper">
			<div class="footer">
				<div class="dataTables_paginate paging_full_numbers">
					<a class="first paginate_button" href="<?=GetHref('p=1')?>">First</a>
					<?=(($page <= 1 || $page == '') ? '<a class="previous paginate_button">&laquo;</a>' : '<a class="previous paginate_button" href="'.GetHref('p='.($page-1)).'">&laquo;</a>')?>
					<span><?=$pagination?></span>
					<?=(($page >= $lastpage) ? '<a class="next paginate_button">&raquo;</a>' : '<a class="next paginate_button" href="'.GetHref('p='.($page == 0 ? 2 : $page+1)).'">&raquo;</a>')?>
					<a class="last paginate_button" href="<?=GetHref('p='.$lastpage)?>">Last</a>
				</div>
			</div>
			</div>
			<?}?>
		</div>
	</div>
	<div class="grid_3">
		<form method="get" class="box validate">
			<input type="hidden" name="x" value="users" /> 
			<div class="header">
				<h2>Search Users</h2>
			</div>
			<div class="content">
				<div style="height: 10px;" class="clear"></div>
				<p class="_100 small">
					<label for="su">Search</label>
					<input type="text" class="required" name="su" id="su" />
				</p>
				<p class="_100 small">
					<label for="s_type" >By</label>
					<select name="s_type" id="s_type">
						<option value="0">Username</option>
						<option value="1">Email</option>
						<option value="2">IP Address</option>
						<option value="3">Source</option>
					</select>
				</p>
				<div style="height: 10px;" class="clear"></div>
			</div>
			<div class="actions">
				<div class="right">
					<input type="submit" value="Search" />
				</div>
			</div>
		</form>
	</div>
</section>
<?}?>