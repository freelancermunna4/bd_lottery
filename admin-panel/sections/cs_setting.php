<?php
	if(! defined('BASEPATH') ){ exit('Unable to view file.'); }	
 

	$sql = $db->Query("SELECT id FROM `louckyCoupon`");	
	$message = '';


// new lottery
if(isset($_POST['setyt']))
		{
		    
			$ytlink= $db->EscapeString($_POST['ytlink']);	
			$db->Query("UPDATE `coustom_config` SET c_value='$ytlink' WHERE id=4");	
		}

if(isset($_POST['contact']))
		{
		    
			$contac= $db->EscapeString($_POST['contac']);	
			$db->Query("UPDATE `coustom_config` SET c_value='$contac' WHERE id=5");	
		}
?>
<section id="content" class="container_12 clearfix ui-sortable">
	
	<div class="grid_12">
<?php
		
 echo  $message; ?>

		<form action="" method="post" class="box">
			<div class="header">
				<h2>Homepage Youtube Video Id</h2>
			</div>
			<div class="content">
				<div class="row">
					<label><strong>Videeo ID </strong></label>
					<div><input type="text" name="ytlink" value="<?php 
					$yt=$db->QueryFetchArray("SELECT * FROM `coustom_config` WHERE name='youtubeLink' LIMIT 1");
					echo $yt['c_value'];
					
					?>" required="required" /></div>
				</div>
			</div>
			<div class="actions">
				<div class="right">
					<input type="submit" value="Set" name="setyt" />
				</div>
			</div>
		</form>


		<form action="" method="post" class="box">
			<div class="header">
				<h2>Imo / Contuct Number With Discription</h2>
			</div>
			<div class="content">
				<div class="row">
					<label><strong>Contuct Info </strong></label>
					<div><input type="text" name="contac" value="<?php 

					$ct=$db->QueryFetchArray("SELECT * FROM `coustom_config` WHERE name='contact' LIMIT 1");
					echo $ct['c_value'];
					
					?>" required="required"/></div>
				</div>
			</div>
			<div class="actions">
				<div class="right">
					<input type="submit" value="Set" name="contact" />
				</div>
			</div>
		</form>

	</div>
</section>