<?php
	if(! defined('BASEPATH') ){ exit('Unable to view file.'); }

   if(isset($_GET['tops']))
			{
        if(isset($_POST['submit']))
	   {
           
            $code=base64_encode($_POST['topad']);
		    $ads = $db->Query("UPDATE googleads SET code='$code' WHERE id=1");
        }
   }

    if(isset($_GET['bottom']))
                {
            if(isset($_POST['submit']))
           {

                $code=base64_encode($_POST['bottom']);
                $ads = $db->Query("UPDATE googleads SET code='$code' WHERE id=2");
            }
       }

 if(isset($_GET['side']))
                {
            if(isset($_POST['submit']))
           {

                $code=base64_encode($_POST['side']);
                $ads = $db->Query("UPDATE googleads SET code='$code' WHERE id=3");
            }
       }
	
?>
<section id="content" class="container_12 clearfix ui-sortable">
	
	<div class="grid_12">
	<?php
	 if(isset($_GET['tops'])){         ////////////submited by admin////////////
            
            $ads = $db->QueryFetchArray("SELECT * FROM `googleads` WHERE name='toppage'");
            
		?>
        
        <form action="" method="post" class="box">
			<div class="header">
				<h2>Your Top Ads Code Hare</h2>
			</div>
			<div class="content">
				<div class="row">
					
                    <div><input type="text" name="topad" value="<?php echo base64_decode($ads['code']); ?>" placeholder="Top Ads Code" required="required" /></div>
				</div>
				
              
			</div>
			<div class="actions">
				<div class="right">
					<input type="submit" value="Submit" name="submit" />
				</div>
			</div>
		</form>
        
       
		<?php } 
	 else if(isset($_GET['bottom'])){         ////////////submited by admin////////////
            
            $ads = $db->QueryFetchArray("SELECT * FROM `googleads` WHERE name='bottom'");
            
		?>
        
        <form action="" method="post" class="box">
			<div class="header">
				<h2>Your Bottom Ads Code Hare</h2>
			</div>
			<div class="content">
				<div class="row">
					
                    <div><input type="text" name="bottom" value="<?php echo base64_decode($ads['code']); ?>" placeholder="Bottom Ads Code" required="required" /></div>
				</div>
				
              
			</div>
			<div class="actions">
				<div class="right">
					<input type="submit" value="Submit" name="submit" />
				</div>
			</div>
		</form>
        
       
		<?php }
        
        else if(isset($_GET['side'])){         ////////////submited by admin////////////
            
            $ads = $db->QueryFetchArray("SELECT * FROM `googleads` WHERE name='side'");
            
		?>
        
        <form action="" method="post" class="box">
			<div class="header">
				<h2>Your Sidebar Ads Code Hare</h2>
			</div>
			<div class="content">
				<div class="row">
					
                    <div><input type="text" name="side" value="<?php echo base64_decode($ads['code']);?>" placeholder="Sidebar Ads Code" required="required" /></div>
				</div>
				
              
			</div>
			<div class="actions">
				<div class="right">
					<input type="submit" value="Submit" name="submit" />
				</div>
			</div>
		</form>
        
       
		<?php } 
        
        
        
        
        
        
        
        
        ?>  
        
        
	</div>
</section>