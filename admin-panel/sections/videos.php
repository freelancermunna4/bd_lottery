<?php
	if(! defined('BASEPATH') ){ exit('Unable to view file.'); }
	include('../system/libs/apaginate.php');

	$message = '';
	//////////start/////////////
	if(isset($_GET['ytapi']))
	{
		if(isset($_POST['submit']))
		{
			 
			 
			if($_POST['wl']){
			$apikey = $db->EscapeString($_POST['wl']);
			$db->Query("UPDATE `coustom_config` SET `c_value`='$apikey' WHERE id=1");
			$message = '<div class="alert success"><span class="icon"></span><strong>Success!</strong> Page successfully edited!</div>';
			 }
			 
			 
			 if($_POST['dl']){
			$apikey = $db->EscapeString($_POST['dl']);
			$db->Query("UPDATE `coustom_config` SET `c_value`='$apikey' WHERE id=2");
			$message = '<div class="alert success"><span class="icon"></span><strong>Success!</strong> Page successfully edited!</div>';
			 }
		
		}
		
		
		
		
	}

?>
<section id="content" class="container_12 clearfix ui-sortable">
	<h1 class="grid_12">Deposit And Withdraw Setting</h1>
	<div class="grid_12">
		<?php
	
			
			if(isset($_GET['ytapi']))
			{
				echo $message;
		?>
		
		<!------------------>
		<form action="" method="post" class="box">
			<div class="header">
				<h2>Minimum Withdraw</h2>
			</div>
			<div class="content">			
				<div class="row">
					<label><strong>
					<?php $dt_con= $db->QueryFetchArray("SELECT * FROM `coustom_config` WHERE id=1"); 
					echo $dt_con['c_value'];  
					?>
					</strong></label>					
					<div><input type="text" name="wl" value="<?=(isset($_POST['wl']) ? $db->EscapeString($_POST['wl']) : '')?>" placeholder="New WithDraw limit" required="required" /></div>
				</div>
				
			</div>
			<div class="actions">
				<div class="right">
					<input type="submit" value="Submit" name="submit" />
				</div>
			</div>
		</form>
		
		
		<!------------------>
		<form action="" method="post" class="box">
			<div class="header">
				<h2>Minimum Deposit</h2>
			</div>
			<div class="content">			
				<div class="row">
					<label><strong>
					<?php $dt_con= $db->QueryFetchArray("SELECT * FROM `coustom_config` WHERE id=2"); 
					echo $dt_con['c_value'];  
					?>
					</strong></label>					
					<div><input type="text" name="dl" value="<?=(isset($_POST['dl']) ? $db->EscapeString($_POST['dl']) : '')?>" placeholder="New Deposit limit" required="required" /></div>
				</div>
				
			</div>
			<div class="actions">
				<div class="right">
					<input type="submit" value="Submit" name="submit" />
				</div>
			</div>
		</form>
		
		
		
		
		
		
		
		
		<?php ///endcoustom setting ?>
		
		
		
		
		
		
		
		
		
		
		<?php
			}?>
	</div>
</section>