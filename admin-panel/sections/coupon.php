<?php
	if(! defined('BASEPATH') ){ exit('Unable to view file.'); }

	

	$sql = $db->Query("SELECT id FROM `louckyCoupon`");
	$total_pages = $db->GetNumRows($sql);
	$message = '';
	
	if(isset($_GET['add']))
	{
		if(isset($_POST['submit']))
		{
		    
			$coupn = $db->EscapeString($_POST['coupn']);			
			$tim = $db->EscapeString($_POST['tim']);
			$coin = $db->EscapeString($_POST['coin']);
			
			$corenttime=time();
			$ftime=$corenttime+($tim*60);

			$db->Query("INSERT INTO `louckyCoupon`( `coupon`, `couponPrice`, `Activity`, `tim`) VALUES ('$coupn',$coin,0,$ftime)");
			$message = '<div class="alert success"><span class="icon"></span><strong>Success!</strong> Coupon successfully Aded!</div>';
		}
	}

	


	elseif(isset($_GET['del']) && is_numeric($_GET['del']))
	{
		$del = $db->EscapeString($_GET['del']); 
		$db->Query("DELETE FROM `louckyCoupon` WHERE `id`='".$del."'");
	}
?>
<section id="content" class="container_12 clearfix ui-sortable">
	
	<div class="grid_12">
		<?php
		
	if(isset($_GET['add']))
			{
			
		
		?>
		<form action="" method="post" class="box">
			<div class="header">
				<h2>Add New Coupon</h2>
			</div>
			<div class="content">
				<div class="row">
					<label><strong>Coupon Code</strong></label>
					<div><input type="text" name="coupn" value="<?=(isset($_POST['coupn']) ? $db->EscapeString($_POST['coupn']) : '')?>" placeholder="Coupon Code" required="required" /></div>
				</div>
				
				<div class="row">
					<label><strong>Left Time </strong></label>
					<div><input type="text" name="tim" value="<?=(isset($_POST['tim']) ? $db->EscapeString($_POST['tim']) : '')?>" placeholder="munite" required="required" /></div>
				</div>
				
				
				<div class="row">
					<label><strong>Reword Coin</strong></label>
					<div><input type="text" name="coin" value="<?=(isset($_POST['coin']) ? $db->EscapeString($_POST['coin']) : '')?>" placeholder="Reword Coin" required="required" /></div>
				</div>
              
			</div>
			<div class="actions">
				<div class="right">
					<input type="submit" value="Submit" name="submit" />
				</div>
			</div>
		</form>
		
		
		
		
		
		
		<?php }
      
   
 
        else{         ////////////submited by admin////////////
		?>
        <h1 class="grid_12">All Winner</h1>
				<div class="box">
					<table class="styled">
						<thead>
							<tr>										
								<th>Coupon Code</th>								
								<th>Price</th>								
								<th>Activity</th>
								<th>User Name</th>
								<th>Phone</th>
							</tr>
						</thead>
						<tbody>
		<?php
            $idd=$data['id'];
		  $jobs = $db->QueryFetchArrayAll("SELECT * FROM `louckyCoupon` ORDER BY id DESC LIMIT 10");

		  foreach($jobs as $video){
		
		?>	
							<tr>
								<td><?=$video['coupon']?></td>
								<td><?=$video['couponPrice']?></td>
								<td><?=$video['Activity']?></td>
								<td><?=$video['sername']?></td>
								<td><?=$video['userphon']?></td>
                                
								<td class="center">
									<a href="index.php?x=coupon&del=<?=$video['id']?>" class="button small grey tooltip" data-gravity=s title="Delete"><i class="icon-remove"></i></a>
									
								</td>
							</tr>
		<?php }?>
						</tbody>
					</table>
		
			
		
		</div>
		<?php }
        
        
        ?>
	</div>
</section>