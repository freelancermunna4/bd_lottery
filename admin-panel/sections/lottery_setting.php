<?php
	if(! defined('BASEPATH') ){ exit('Unable to view file.'); }	

	$sql = $db->Query("SELECT id FROM `louckyCoupon`");	
	$message = '';
	
	if(isset($_GET['add']))
	{
		if(isset($_POST['submit']))
		{
		    
						
			$sirstSecond = $db->EscapeString($_POST['sirstSecond']);			
			$priceName = $db->EscapeString($_POST['priceName']);
			$priceValue = $db->EscapeString($_POST['priceValue']);
			$image = $_FILES['file'];
			$filename=$_FILES['file']['name'];
			$fileTmpName=$_FILES['file']['tmp_name'];
			$image_ext = explode(".", $filename);
			$imgActualExt=strtolower(end($image_ext));
			$allowed=array('jpg','jpeg','png');
			if (in_array($imgActualExt,$allowed)) {
				$fileNew=uniqid('',true).".".$imgActualExt;
				$fileDestiNation="../template/default/static/images/".$fileNew;
				move_uploaded_file($fileTmpName,$fileDestiNation);
			}
			
			$corenttime=time();
			$d=$db->QueryFetchArrayAll('SELECT * FROM `lottary` WHERE first_secon="'.$sirstSecond.'"');
			
			
			if(count($d)<1){
				$db->Query("INSERT INTO `lottary`(`first_secon`, `price_name`, `pricevalue`, `time`,`img`) VALUES ('$sirstSecond','$priceName','$priceValue','$corenttime','$fileNew')");
				 $message = '<div class="alert success"><span class="icon"></span><strong>Success!</strong> Coupon successfully Aded!</div>';
			}
			else{
				 $message = '<div class="alert success">
				 <strong>Warning!</strong> Already have this Lottery, Please Delete it First.
			   </div>';
			}	
			
		}
// new lottery
if(isset($_POST['submitnew']))
		{
		    $stardDays = $db->EscapeString($_POST['stardDays']);
			$timss= $db->EscapeString($_POST['sirstSecond']);			
			$minit= $db->EscapeString($_POST['minit']);			
			$vall= $db->EscapeString($_POST['lotteryValue']);	
			$percent= $db->EscapeString($_POST['percent']);	

			$minitf=($minit*60);
			$stardDays=($stardDays*86400)+$minitf;		
			
			
			$corenttime=time();	
			$wtimess=$stardDays+($corenttime+($timss*60*60));
			$wtime=$wtimess;
			$db->Query("DELETE FROM `lottarybuy`");			
			$db->Query("DELETE FROM `lottery_setting`");		
				$db->Query("INSERT INTO `lottery_setting`(`name`,`adminpercent`,`sactivity`,`price`,`withdrawtime`) VALUES ('lottery',$percent,1,$vall,$wtime)");
				 $message = '<div class="alert success"><span class="icon"></span><strong>Success!</strong> Coupon successfully Aded!</div>';
			
			
		}


	}



// add more time


if(isset($_POST['addtime']))
		{
		    
			$timss= $db->EscapeString($_POST['sirstSecond']);	
			$corenttime=time();	
			$wtime=$corenttime+($timss*60*60);				
				$db->Query("UPDATE `lottery_setting` SET `withdrawtime`=$wtime WHERE name='lottery'");
				 $message = '<div class="alert success"><span class="icon"></span><strong>Success!</strong> Coupon successfully Aded!</div>';
			
			
		}

// add more time
if(isset($_POST['cnpercent']))
		{
		    
			$prc= $db->EscapeString($_POST['chparcent']);						
				$db->Query("UPDATE `lottery_setting` SET`adminpercent`=$prc WHERE name='lottery'");
				 $message = '<div class="alert success"><span class="icon"></span><strong>Success!</strong> Coupon successfully Aded!</div>';
			
			
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
		<form action="" method="post" class="box" enctype="multipart/form-data">
			<div class="header">
				<h2>Add New Lottery</h2>
			</div>
			<div class="content">
				<div class="row">
				<label><strong>Price</strong></label><div>
				<select name="sirstSecond">
				<option value="First">First Price</option>
				<option value="Second">Second Price</option>
				<option value="Third">Third Price</option>
				<option value="Fourth">Fourth Price</option>
				<option value="Fifth">Fifth Price</option>
				<option value="Sixth">Sixth Price</option>
				<option value="Seventh">Seventh Price</option>
				<option value="Eighth">Eighth Price</option>
				<option value="Ninth">Ninth Price</option>
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

				<div class="row">
					<label><strong>Select Image</strong></label>
					<div>
					<input type="file" name="file" class="file">
					</div>
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
				<h2>Start New Lottery</h2>
			</div>
			<div class="content">

			<div class="row" >
				<label><strong>Next Days </strong></label><div>
				<select name="stardDays">
				<option value="0">0 Days</option>
				<option value="1">1 Days</option>
				<option value="2">2 Days</option>
				<option value="3">3 Days</option>
				<option value="4">4 Days</option>
				<option value="5">5 Days</option>
				<option value="6">6 Days</option>
				<option value="7">7 Days</option>
				<option value="8">8 Days</option>
				<option value="9">9 Days</option>
				<option value="10">10 Days</option>
				<option value="11">11 Days</option>
				<option value="12">12 Days</option>
				<option value="13">13 Days</option>
				<option value="14">14 Days</option>
				<option value="15">15 Days</option>
				<option value="16">16 Days</option>
				<option value="17">17 Days</option>
				<option value="18">18 Days</option>
				<option value="19">19 Days</option>
				<option value="20">20 Days</option>
				<option value="21">21 Days</option>
				<option value="22">22 Days</option>
				<option value="23">23 Days</option>
				<option value="24">24 Days</option>				
				<option value="25">25 Days</option>				
				<option value="26">26 Days</option>				
				<option value="27">27 Days</option>				
				<option value="28">28 Days</option>				
				<option value="29">29 Days</option>				
				<option value="30">30 Days</option>				
				</select>
			</div>
			</div>
				<div class="row" >
				<label><strong>Next Withdraw </strong></label><div>
				<select name="sirstSecond">
				<option value="0">0 Hour</option>
				<option value="1">1 Hour</option>
				<option value="2">2 Hour</option>
				<option value="3">3 Hour</option>
				<option value="4">4 Hour</option>
				<option value="5">5 Hour</option>
				<option value="6">6 Hour</option>
				<option value="7">7 Hour</option>
				<option value="8">8 Hour</option>
				<option value="9">9 Hour</option>
				<option value="10">10 Hour</option>
				<option value="11">11 Hour</option>
				<option value="12">12 Hour</option>
				<option value="13">13 Hour</option>
				<option value="14">14 Hour</option>
				<option value="15">15 Hour</option>
				<option value="16">16 Hour</option>
				<option value="17">17 Hour</option>
				<option value="18">18 Hour</option>
				<option value="19">19 Hour</option>
				<option value="20">20 Hour</option>
				<option value="21">21 Hour</option>
				<option value="22">22 Hour</option>
				<option value="23">23 Hour</option>
				<option value="24">24 Hour</option>				
				</select>
			</div>
			</div>

			<div class="row" >
				<label><strong>Next Withdraw </strong></label><div>
				<select name="minit">
				<option value="0">0 Minute</option>
				<option value="1">1 Minute</option>
				<option value="2">2 Minute</option>
				<option value="3">3 Minute</option>
				<option value="4">4 Minute</option>
				<option value="5">5 Minute</option>
				<option value="6">6 Minute</option>
				<option value="7">7 Minute</option>
				<option value="8">8 Minute</option>
				<option value="9">9 Minute</option>
				<option value="10">10 Minute</option>
				<option value="11">11 Minute</option>
				<option value="12">12 Minute</option>
				<option value="13">13 Minute</option>
				<option value="14">14 Minute</option>
				<option value="15">15 Minute</option>
				<option value="16">16 Minute</option>
				<option value="17">17 Minute</option>
				<option value="18">18 Minute</option>
				<option value="19">19 Minute</option>
				<option value="20">20 Minute</option>
				<option value="21">21 Minute</option>
				<option value="22">22 Minute</option>
				<option value="23">23 Minute</option>
				<option value="24">24 Minute</option>
				<option value="24">24 Minute</option>				
				<option value="25">25 Minute</option>				
				<option value="26">26 Minute</option>				
				<option value="27">27 Minute</option>				
				<option value="28">28 Minute</option>				
				<option value="29">29 Minute</option>			
				<option value="30">30 Minute</option>			
				<option value="31">31 Minute</option>			
				<option value="32">32 Minute</option>			
				<option value="33">33 Minute</option>			
				<option value="34">34 Minute</option>			
				<option value="35">35 Minute</option>			
				<option value="36">36 Minute</option>			
				<option value="37">37 Minute</option>			
				<option value="38">38 Minute</option>			
				<option value="39">39 Minute</option>			
				<option value="40">40 Minute</option>			
				<option value="41">41 Minute</option>			
				<option value="42">42 Minute</option>			
				<option value="43">43 Minute</option>			
				<option value="44">44 Minute</option>			
				<option value="45">45 Minute</option>			
				<option value="46">46 Minute</option>			
				<option value="47">47 Minute</option>			
				<option value="48">48 Minute</option>			
				<option value="49">49 Minute</option>			
				<option value="50">50 Minute</option>			
				<option value="51">51 Minute</option>			
				<option value="52">52 Minute</option>			
				<option value="53">53 Minute</option>			
				<option value="54">54 Minute</option>			
				<option value="55">55 Minute</option>			
				<option value="56">56 Minute</option>			
				<option value="57">57 Minute</option>			
				<option value="58">58 Minute</option>			
				<option value="59">59 Minute</option>			
				<option value="60">60 Minute</option>			
				</select>
			</div>
			</div>
			


			<div class="row">
					<label><strong>Ticket Price </strong></label>
					<div><input type="number" name="lotteryValue" placeholder="10" required="required" /></div>
			</div>

			<div class="row">
					<label><strong> Profit By %</strong></label>
					<div><input type="number" name="percent" min="0" max="99" placeholder="0" required="required" /></div>
			</div>
				
              
			</div>
			<div class="actions">
				<div class="right">
					<input type="submit" value="Start New Lottery" name="submitnew" />
				</div>
			</div>
		</form>

		<form action="" method="post" class="box">
			<div class="header">
				<h2>Change Profit Percentage</h2>
			</div>
			<div class="content">

			<?php
					$contact=$db->QueryFetchArray("SELECT * FROM `lottery_setting` WHERE name='lottery'");	
			?>	


			<div class="row">
					<label><strong> Profit By %</strong></label>
					<div><input type="number" name="chparcent" min="0" max="99" placeholder="5" value="<?php echo $contact['adminpercent']; ?>" required="required" /></div>
			</div>
				
              
			</div>
			<div class="actions">
				<div class="right">
					<input type="submit" value="Change" name="cnpercent" />
				</div>
			</div>
		</form>





		<form action="" method="post" class="box">
			<div class="header">
				<h2>Add More Withdraw Time</h2>
			</div>
			<div class="content">
				<div class="row" >
				<label><strong>Add Time </strong></label><div>
				<select name="minite">
				<option value="1">1 Hour</option>
				<option value="2">2 Hour</option>
				<option value="3">3 Hour</option>
				<option value="4">4 Hour</option>
				<option value="5">5 Hour</option>
				<option value="6">6 Hour</option>
				<option value="7">7 Hour</option>
				<option value="8">8 Hour</option>
				<option value="9">9 Hour</option>
				<option value="10">10 Hour</option>
				<option value="11">11 Hour</option>
				<option value="12">12 Hour</option>
				<option value="13">13 Hour</option>
				<option value="14">14 Hour</option>
				<option value="15">15 Hour</option>
				<option value="16">16 Hour</option>
				<option value="17">17 Hour</option>
				<option value="18">18 Hour</option>
				<option value="19">19 Hour</option>
				<option value="20">20 Hour</option>
				<option value="21">21 Hour</option>
				<option value="22">22 Hour</option>
				<option value="23">23 Hour</option>
				<option value="24">24 Hour</option>
				
				</select>
			</div>
			</div>
			
				
              
			</div>
			<div class="actions">
				<div class="right">
					<input type="submit" value="Add Time" name="addtime" />
				</div>
			</div>
		</form>
		
		<?php }
      
   
 
        else{         //
		?>
        	<h1 class="grid_12">All Lottery</h1>
				<div class="box">
					<table class="styled">
						<thead>
							<tr>										
								<th>Price</th>								
								<th>Price Name</th>								
								<th>Price Value</th>								
								<th>Time</th>
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