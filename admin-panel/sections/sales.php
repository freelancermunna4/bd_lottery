<?php
if(! defined('BASEPATH') ){ exit('Unable to view file.'); }

if(isset($_GET['del']) && is_numeric($_GET['del']))
{
    $id = $db->EscapeString($_GET['del']);     
   	$user = $db->Query("UPDATE `deposit` SET status=2  WHERE id=$id");
    if($user){ echo '<div class="col-md-12 text-center" style="margin-left: 250px;"><br>
        <div class="col-md-12 text-center">Successfully Reject</div><br>
    </div>';}
    else {echo '<div class="col-md-12 text-center" style="margin-left: 250px;"><br>
        <div class="col-md-12 text-center">Poos!! Something wrong</div><br>
    </div>';}
    }
    
 ?>
  
<?php
       


if(isset($_GET['ok']) && is_numeric($_GET['ok'])){
    $id = $db->EscapeString($_GET['ok']);     
   
    
   	$user = $db->Query("UPDATE `deposit` SET status=1  WHERE id=$id");
    
    $user = $db->QueryFetchArray("SELECT * FROM `deposit` WHERE id=$id");
    $userid=$user['user_id'];
    $amount=$user['coins'];
    $userinfo = $db->QueryFetchArray("SELECT * FROM `users` WHERE id=$userid");
    $userCoin=$userinfo['coins'];
    $finalcoin=$userCoin+$amount;
    $user = $db->Query("UPDATE `users` SET coins=$finalcoin  WHERE id=$userid");
    
    if($user){ echo '<div class="col-md-12 text-center" style="margin-left: 250px;"><br>
        <div class="col-md-12 text-center">Successfully Aprove</div><br>
    </div>';}
    else {echo '<div class="col-md-12 text-center" style="margin-left: 250px;"><br>
        <div class="col-md-12 text-center">Poos!! Something wrong</div><br>
    </div>';}
   
}

$total_pages = $db->QueryGetNumRows("SELECT id FROM `deposit`");

?>
<section id="content" class="container_12 clearfix">
	<h1 class="grid_12">Total Deposit Request (<?=number_format($total_pages)?>)</h1>
	<div class="grid_12">
		<div class="box">
			<table class="styled">
				<thead>
					<tr>
						<th>User Id</th>
						<th>User Name</th>
						<th>Transaction ID</th>
						<th>Coin</th>
						<th>Money</th>
						<th>Acaunt</th>
						<th>Gateway</th>
						<th>Status</th>
						<th>Date</th>
						<th>IP</th>
                        <th>Aprove</th>
						<th>Reject</th>
					</tr>
				</thead>
				<tbody>
<?php
	$trans = $db->QueryFetchArrayAll("SELECT * FROM `deposit` WHERE status=0 ORDER BY `timestamp` DESC LIMIT 25");
	
	if(!count($trans))
	{
		echo '<tr><td colspan="9"><center>There is no transaction yet!</center></td></tr>';
	}

	foreach($trans as $tra){
	                $uid=$tra['user_id'];
	                $tr = $db->QueryFetchArray("SELECT * FROM `users` WHERE id=$uid LIMIT 25");
?>	            
					<tr>
						<td><?=(!empty($tra['user_id']) ? '<a href="index.php?x=users&edit='.$tra['user_id'].'">'.$tra['user_id'].'</a>' : $tra['user_id'])?></td>
						<td><?=$tr['username']?></td>
						<td><?=(empty($tra['trx_id']) ? 'N/A' : $tra['trx_id'])?></td>
						<td><?=$tra['coins']?> Coins</td>
						<td><?=$tra['cash']?></td>
						<td><?=$tra['payment_info']?></td>
						<td><?=ucfirst($tra['method'])?></td>
						<td><?=($tra['paid'] == 1 ? '<font color="green"><b>Complete</b></font>' : '<b>Pending</b>')?></td>
						<td><?=date('d M Y - H:i', $tra['date'])?></td>
						<td><?=(empty($tra['ip_address']) ? 'N/A' : '<a href="index.php?x=users&s_type=2&su='.$tra['ip_address'].'">'.$tra['ip_address'].'</a>')?></td>
                         <td class="center">
									<a href="index.php?x=sales&ok=<?=$tra['id']?>" class="button small grey tooltip" data-gravity=s title="Edit"><i class="icon-check"></i></a>
						</td>
                        
                         <td class="center">
									<a href="index.php?x=sales&del=<?=$tra['id']?>" class="button small grey tooltip" data-gravity=s title="Edit"><i class="icon-remove"></i></a>
									
						</td>
					</tr>
<?php } ?>
				</tbody>
			</table>
		
		</div>
	</div>
</section>