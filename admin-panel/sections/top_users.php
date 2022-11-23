<?php
	if(! defined('BASEPATH') ){ exit('Unable to view file.'); }
?>
<section id="content" class="container_12 clearfix ui-sortable" data-sort=true>
	<h1 class="grid_12">Top 20 Users</h1>
	<div class="grid_12">
		<div class="box">
			<table class="styled">
				<thead>
					<tr>
						<th>#</th>
						<th>Username</th>
						<th>Email</th>
						<th>Country</th>
						<th>Coins</th>
						<th width="90">Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$users = $db->QueryFetchArrayAll("SELECT id,username,email,country_id,coins FROM `users` ORDER BY `coins` DESC LIMIT 20");

						$j = 0;
						foreach($users as $user){
							$j++;
					?>		
					<tr>
						<td><?=$j?></td>
						<td><a href="index.php?x=users&edit=<?=$user['id']?>"><?=$user['username']?></a></td>
						<td><?=$user['email']?></td>
						<td><?=($user['country_id'] == '0' ? 'N/A' : get_country($user['country_id']))?></td>
						<td><?=number_format($user['coins'])?></td>
						<td class="center">
							<a href="index.php?x=users&edit=<?=$user['id']?>" class="button small grey tooltip" data-gravity=s title="Edit"><i class="icon-pencil"></i></a>
							<a href="index.php?x=users&del=<?=$user['id']?>" onclick="return confirm('You sure you want to delete this user?');" class="button small grey tooltip" data-gravity=s title="Remove"><i class="icon-remove"></i></a>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</section>