<?php
	if(! defined('BASEPATH') ){ exit('Unable to view file.'); }

	

	$sql = $db->Query("SELECT id FROM `louckyCoupon`");
	$total_pages = $db->GetNumRows($sql);
	$message = '';
	
	if(isset($_GET['add']))
	{
		if(isset($_POST['submit']))
		{
		    
			$sirstSecond = $db->EscapeString($_POST['sirstSecond']);			
			$priceName = $db->EscapeString($_POST['priceName']);
			$priceValue = $db->EscapeString($_POST['priceValue']);			
			$corenttime=time();
			$d=$db->QueryFetchArrayAll('SELECT * FROM `lottary` WHERE first_secon="'.$sirstSecond.'"');
			
			echo count($d);
			
			if(count($d)<1){
				$db->Query("INSERT INTO `lottary`(`first_secon`, `price_name`, `pricevalue`, `time`) VALUES ('$sirstSecond','$priceName','$priceValue','$corenttime')");
				 $message = '<div class="alert success"><span class="icon"></span><strong>Success!</strong> Coupon successfully Aded!</div>';
			}
			else{
				 $message = '<div class="alert success">
				 <strong>Warning!</strong> Already have this Lottery, Please Delete it First.
			   </div>';
			}	

/*
			$db->Query("INSERT INTO `louckyCoupon`( `coupon`, `couponPrice`, `Activity`, `tim`) VALUES ('$coupn',$coin,0,$ftime)");
			$message = '<div class="alert success"><span class="icon"></span><strong>Success!</strong> Coupon successfully Aded!</div>';*/
			
		}
	}

	


	elseif(isset($_GET['del']) && is_numeric($_GET['del']))
	{
		$del = $db->EscapeString($_GET['del']); 
		$db->Query("DELETE FROM `lottary` WHERE `id`='".$del."'");
	}
?>
<section id="content" class="container_12 clearfix ui-sortable">
	
	<div class="grid_12">
		<?php
		
	if(isset($_GET['add']))
			{?>
 			<h1 class="grid_12">All Lottery</h1>
				<div class="box">
					<table class="styled">
						<thead>
							<tr>										
								<th>Price</th>								
								<th>Price Name</th>								
								<th>Price Value</th>								
								<th>time</th>
								<th>Action</th>
								
							</tr>
						</thead>
						<tbody>
		<?php
            $idd=$data['id'];
		  $lottary = $db->QueryFetchArrayAll("SELECT * FROM `lottary` ORDER BY id ASC");		
		  foreach($lottary as $video){
		
		?>	
							<tr>
								<td><?=$video['first_secon']?></td>
								<td><?=$video['price_name']?></td>
								<td><?=$video['pricevalue']?></td>
								<td><?=date("d-m-Y",$video['time'])?></td>
								
                                
								<td class="center">
									<a href="index.php?x=lottery&del=<?=$video['id']?>" class="button small grey tooltip" data-gravity=s title="Delete"><i class="icon-remove"></i></a>
									
								</td>
							</tr>
		<?php }?>
						</tbody>
					</table>
		</div>
<?php echo  $message; ?>
		<form action="" method="post" class="box">
			<div class="header">
				<h2>Add New Lottery</h2>
			</div>
			<div class="content">
				<div class="row">
				<label><strong>Price</strong></label><div>
				<select name="sirstSecond">
				<option value="first">First Price</option>
				<option value="second">Second Price</option>
				<option value="third">Third Price</option>
				</select></div>
				</div>

				<div class="row">
					<label><strong>Price Name</strong></label>
					<div><input type="text" name="priceName" placeholder="Price Name Example: Car" required="required" /></div>
				</div>
				
				<div class="row">
					<label><strong>Price Value</strong></label>
					<div><input type="text" name="priceValue" placeholder="Price Value Example:100000 taka" required="required" /></div>
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
        	<h1 class="grid_12">All Lottery</h1>
				<div class="box">
					<table class="styled">
						<thead>
							<tr>										
								<th>Price</th>								
								<th>Price Name</th>								
								<th>Price Value</th>								
								<th>time</th>
								<th>Action</th>
								
							</tr>
						</thead>
						<tbody>
		<?php
            $idd=$data['id'];
		  $lottary = $db->QueryFetchArrayAll("SELECT * FROM `lottary` ORDER BY id ASC");		
		  foreach($lottary as $video){
		
		?>	
							<tr>
								<td><?=$video['first_secon']?></td>
								<td><?=$video['price_name']?></td>
								<td><?=$video['pricevalue']?></td>
								<td><?=date("d-m-Y",$video['time'])?></td>
								
                                
								<td class="center">
									<a href="index.php?x=lottery&del=<?=$video['id']?>" class="button small grey tooltip" data-gravity=s title="Delete"><i class="icon-remove"></i></a>
									
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