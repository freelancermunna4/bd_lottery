<?php
	if(! defined('BASEPATH') ){ exit('Unable to view file.'); }
	
	/* Load Users Stats */
	$users = array();
	$users['reg_today'] = $db->QueryFetchArray("SELECT COUNT(*) AS `total` FROM `users` WHERE `reg_time` >= '".strtotime(date('d M Y'))."'");
	$users['on_today'] = $db->QueryFetchArray("SELECT COUNT(*) AS `total` FROM `users` WHERE `last_activity` >= '".strtotime(date('d M Y'))."'");
	$users['online'] = $db->QueryFetchArray("SELECT COUNT(*) AS `total` FROM `users` WHERE `last_activity` >= '".(time()-900)."'");
	$users['disabled'] = $db->QueryFetchArray("SELECT COUNT(*) AS `total` FROM `users` WHERE `disabled` = '1'");
	$users['vip'] = $db->QueryFetchArray("SELECT COUNT(*) AS `total`, SUM(`membership`-'".time()."') AS `membership` FROM `users` WHERE `membership` > '0'");
	$users['coins'] = $db->QueryFetchArray("SELECT SUM(`coins`) AS `total` FROM `users` WHERE `disabled` = '0'");
	$users['total'] = $db->QueryFetchArray("SELECT COUNT(*) AS `total` FROM `users`");
	$total_vip = round(($users['vip']['membership']/86400), 0);
	
	/* Load Income / Outcome Stats */
	$ads_income = $db->QueryFetchArray("SELECT SUM(`money`) AS `money`, COUNT(*) AS `total` FROM `transactions`");
	$sent_money = $db->QueryFetchArray("SELECT SUM(`cash`) AS `money`, COUNT(*) AS `total` FROM `withdrawals` WHERE `status`='1'");
	$rejected_money = $db->QueryFetchArray("SELECT SUM(`cash`) AS `money`, COUNT(*) AS `total` FROM `withdrawals` WHERE `status`='2'");
	$pending_money = $db->QueryFetchArray("SELECT SUM(`cash`) AS `money`, COUNT(*) AS `total` FROM `withdrawals` WHERE `status`='0'");
	
	// Last 7 days
	$stats_reg = $db->QueryFetchArrayAll("SELECT COUNT(*) AS `total`, DATE(FROM_UNIXTIME(`reg_time`)) AS `day` FROM `users` GROUP BY `day` ORDER BY `day` DESC LIMIT 7");
	$stats_del= $db->QueryFetchArrayAll("SELECT COUNT(*) AS `total`, DATE(`time`) AS `day` FROM `users_deleted` GROUP BY `day` ORDER BY `day` DESC LIMIT 7");
	$stats_log= $db->QueryFetchArrayAll("SELECT COUNT(DISTINCT `uid`) AS `total`, DATE(`time`) AS `day` FROM `user_logins` GROUP BY `day` ORDER BY `day` DESC LIMIT 7");
	
	$dates = array();
	for ($i = 0; $i < 7; $i++) {
		$dates[] = date('Y-m-d', time() - 86400 * $i);
	}
	$dates = array_reverse($dates);

	$rStatsT = '';
	$rStatsU = '';
	$rStatsD = '';
	$rStatsL = '';
	$j = 0;
	foreach($dates as $date) {
		$registered = 0;
		$deleted = 0;
		$logins = 0;
		$j++;
		foreach($stats_reg as $stat) {
			if($date == $stat['day']) {
				$registered = $stat['total'];
			}
		}
		
		foreach($stats_del as $stat) {
			if($date == $stat['day']) {
				$deleted = $stat['total'];
			}
		}
		
		foreach($stats_log as $stat) {
			if($date == $stat['day']) {
				$logins = $stat['total'];
			}
		}

		$rStatsT .= '<th>'.$date.'</th>';
		$rStatsU .= '<td>'.$registered.'</td>';
		$rStatsD .= '<td>'.$deleted.'</td>';
		$rStatsL .= '<td>'.$logins.'</td>';
	}

	/* Video Ads Stats */
	$vads = array();
	$vads['total'] = $db->QueryFetchArray("SELECT COUNT(*) AS `total` FROM `vad_videos`");
	$vads['active'] = $db->QueryFetchArray("SELECT COUNT(*) AS `total` FROM `vad_videos` WHERE `clicks`>'0'");
	$vads['finished'] = $db->QueryFetchArray("SELECT COUNT(*) AS `total` FROM `vad_videos` WHERE `clicks`='0'");
?>
<section id="content" class="container_12 clearfix" data-sort=true>
	<ul class="stats not-on-phone">
		<li>
			<strong><?=number_format($users['total']['total'])?></strong>
			<small>Total Users</small>
			<span <?=($users['reg_today']['total'] > 0 ? 'class="green" ' : '')?>style="margin:4px 0 -10px 0"><?=$users['reg_today']['total']?> today</span>
		</li>
		<li>
			<strong><?=number_format($users['on_today']['total'])?></strong>
			<small>Active Today</small>
		</li>
		<li>
			<strong><?=get_currency_symbol($config['currency_code']).number_format($ads_income['money'], 2)?></strong>
			<small>Sales Income</small>
			<span class="green" style="margin:4px 0 -10px 0"><?=number_format($ads_income['total'])?> sales</span>
		</li>
		<li>
			<strong><?=get_currency_symbol($config['currency_code']).number_format($sent_money['money'], 2)?></strong>
			<small>Total Paid</small>
			<span <?=($pending_money['total'] > 0 ? 'class="green" ' : '')?>style="margin:4px 0 -10px 0"><?=get_currency_symbol($config['currency_code']).number_format($pending_money['money'], 2)?> pending</span>
		</li>
	</ul>



	<h1 class="grid_12 margin-top">Dashboard</h1>
	<div class="grid_6">
		<div class="box">
			<div class="header">
				<h2><img class="icon" src="img/icons/packs/fugue/16x16/users.png" width="16" height="16">Users statistics</h2>
			</div>
			<div class="content">
				<div class="spacer"></div>
				<div class="full-stats">
					<div class="stat hlist" data-list='[{"val":<?=$users['online']['total'].','.($users['online']['total'] > 999 ? '"format":"0,0",' : '')?>"title":"Online Members","color":"green"},{"val":<?=$users['vip']['total'].','.($users['vip']['total'] > 999 ? '"format":"0,0",' : '')?>"title":"VIP Members"},{"val":<?=$users['disabled']['total'].','.($users['disabled']['total'] > 999 ? '"format":"0,0",' : '')?>"title":"Banned Members","color":"red"},{"val":<?=$users['reg_today']['total'].','.($users['reg_today']['total'] > 999 ? '"format":"0,0",' : '')?>"title":"Registered Today"}]' data-flexiwidth=true></div>
				</div>
			</div>
		</div>
		
	</div>
	<div class="grid_5">
		<div class="box">
			<div class="header">
				<h2><img class="icon" src="img/icons/packs/fugue/16x16/users.png" width="16" height="16">Users activity in past 7 days</h2>
			</div>
			<div class="content">
				<table class="chart"data-type="bars" style="height: 270px;">
					<thead>
						<tr>
							<th></th>
							<?=$rStatsT?>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th>Registered Users</th>
							<?=$rStatsU?>
						</tr>
						<tr>
							<th>Deleted Users</th>
							<?=$rStatsD?>
						</tr>
						<tr>
							<th>Active Users</th>
							<?=$rStatsL?>
						</tr>
					</tbody>	
				</table>
			</div>
		</div>
	</div>
	
	
</section>