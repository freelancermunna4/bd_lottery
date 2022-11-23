<?php
if(! defined('BASEPATH') ){ exit('Unable to view file.'); }
if(isset($_GET['del']) && is_numeric($_GET['del']))
{
    $id = $db->EscapeString($_GET['del']); 
    
    $ui = $db->QueryFetchArray("SELECT * FROM `withdrawals` WHERE id=$id");
    $userid=$ui['user_id'];
    $coin=$ui['coins'];
    $status=$ui['status'];
    if($status != 2){
    
    $ui2 = $db->QueryFetchArray("SELECT * FROM `users` WHERE id=$userid");
    $usercoin=$ui2['coins'];
    $finalcoin=$usercoin+$coin;
    $user = $db->Query("UPDATE `users` SET coins=$finalcoin  WHERE id=$userid");
    
   	$user = $db->Query("UPDATE `withdrawals` SET status=2  WHERE id=$id");
    if($user){ echo '<div class="col-md-12 text-center" style="margin-left: 250px;"><br>
        <div class="col-md-12 text-center">Successfully Reject</div><br>
    </div>';}
    else {echo '<div class="col-md-12 text-center" style="margin-left: 250px;"><br>
        <div class="col-md-12 text-center">Poos!! Something wrong</div><br>
    </div>';}
    }
    else{ echo "Already rejected";}
 ?>
  
<?php
       
}

if(isset($_GET['ok']) && is_numeric($_GET['ok'])){
    $id = $db->EscapeString($_GET['ok']);     
   
    
   	$user = $db->Query("UPDATE `withdrawals` SET status=1  WHERE id=$id");
    if($user){ echo '<div class="col-md-12 text-center" style="margin-left: 250px;"><br>
        <div class="col-md-12 text-center">Successfully Aprove</div><br>
    </div>';}
    else {echo '<div class="col-md-12 text-center" style="margin-left: 250px;"><br>
        <div class="col-md-12 text-center">Poos!! Something wrong</div><br>
    </div>';}
   
}

   


$total_pages = $db->QueryGetNumRows("SELECT id FROM `withdrawals`  WHERE status=0 ");
?>

<section id="content" class="container_12 clearfix">
	<h1 class="grid_12">Withdraw Rewuest (<?=number_format($total_pages)?>)</h1>
	<div class="grid_12">
		<div class="box">
			<table class="styled">
				<thead>
					<tr>
						<th>User</th>						
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
       
	$trans = $db->QueryFetchArrayAll("SELECT * FROM `withdrawals` WHERE status=0 ORDER BY `timestamp` ASC LIMIT 25");
	
	if(!count($trans))
	{
		echo '<tr><td colspan="9"><center>There is no transaction yet!</center></td></tr>';
	}

	foreach($trans as $tra){
?>	
					<tr>
						<td><?=(!empty($tra['user_id']) ? '<a href="index.php?x=users&edit='.$tra['user_id'].'">'.$tra['user_id'].'</a>' : $tra['user_id'])?></td>						
						<td><?=$tra['coins']?> Coins</td>
						<td><?=$tra['cash']?></td>
						<td><?=$tra['payment_info']?></td>
						<td><?=ucfirst($tra['method'])?></td>
						<td><?=($tra['paid'] == 1 ? '<font color="green"><b>Complete</b></font>' : '<b>Pending</b>')?></td>
						<td><?=date('d M Y - H:i', $tra['date'])?></td>
						<td><?=(empty($tra['ip_address']) ? 'N/A' : '<a href="index.php?x=users&s_type=2&su='.$tra['ip_address'].'">'.$tra['ip_address'].'</a>')?></td>
                        
                        <td class="center">
									<a href="index.php?x=requests&ok=<?=$tra['id']?>" class="button small grey tooltip" data-gravity=s title="Edit"><i class="icon-check"></i></a>
						</td>
                        
                         <td class="center">
									<a href="index.php?x=requests&del=<?=$tra['id']?>" class="button small grey tooltip" data-gravity=s title="Edit"><i class="icon-remove"></i></a>
									
						</td>
                        
                        
                        
					</tr>
<?php } ?>
				</tbody>
			</table>
			
		</div>
	</div>
</section>

