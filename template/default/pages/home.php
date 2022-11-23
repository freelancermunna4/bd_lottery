<?php
	if(! defined('BASEPATH') ){ exit('Unable to view file.'); }
	

	
	
?>
	<script type="text/javascript"> 
	//	$(document).ready(function(){$.ajaxSetup({cache:false});setInterval(function(){$.getJSON('system/ajax.php?a=getSideStats',function(c){$('#user_count').fadeOut().html(c['members']).fadeIn();$('#payout_count').fadeOut().html(c['payouts']).fadeIn()})},5000)});
	</script>
	<main role="main" class="container">
  <div class="row">
	 

	<div class="col-md-3 col-sm-5 col-xs-5" style="margin-top: 15px !important;">
		<div>
			<div id="sidebar-block" class="box-shadow box-style" style="border-radius: 3px;padding: 8px;"> 
	        <h4 class="title "> &nbsp;  User Login</h4>
          <div class="modal-content">
		
			<div class="col-lg-12 col-sm-12 col-12 user-name">
			</div>
			<div class="col-lg-12 col-sm-12 col-12 form-input">
			  <form method="post">
				<?=$errMessage?>
				<input type="hidden" name="token" value="<?php echo $token; ?>" />
				<div class="form-group">
					<div class="input-group mb-2 mr-sm-2">
						<div class="input-group-prepend"><div class="input-group-text"><i class="fa fa-user"></i></div></div>
						<input type="text" class="form-control" name="user" placeholder="<?=$lang['b_18']?>" required>
					</div> 
				</div>
				<div class="form-group">
					<div class="input-group mb-2 mr-sm-2">
						<div class="input-group-prepend"><div class="input-group-text"><i class="fa fa-key"></i></div></div>
						<input type="password" class="form-control" name="password" placeholder="<?=$lang['b_19']?>" required>
					</div>
				</div>
				<div class="form-group text-left">
				  <input type="checkbox" name="remember" /> <?=$lang['b_20']?>
				</div>
				<button type="submit" name="connect" class="btn btn-success"><?=$lang['b_264']?></button>
			  </form>
			  
			  <a href="https://bdlottery.net/?page=register"><button  class="btn btn-warning">	Register</button></a>
			</div>
			<div class="col-lg-12 col-sm-12 col-12 link-part">
				<a href="<?=GenerateURL('recover')?>"><?=$lang['b_21']?></a>
			</div>
		</div>
		<div>
		
			<div id="home-statistics" class="bg-dark">
					<?php
							$sUsers = $db->QueryFetchArray("SELECT COUNT(*) AS total FROM `users`");
							$sCash = $db->QueryFetchArray("SELECT SUM(`cash`) AS `total` FROM `withdrawals` WHERE `status`='1'");
							echo lang_rep($lang['b_269'], array('-USERS-' => '<i class="fa fa-users"></i> <b id="user_count">'.number_format($sUsers['total']).'</b>', '-CASH-' => '<i class="fa fa-credit-card"></i> <b id="payout_count">'.get_currency_symbol($config['currency_code']).number_format($sCash['total'], 2).'</b>'))
						?>
			</div>
			
	</div>

	</div>
    </div>
	
	
 <div class="my-2">
			 <div id="side-ads" class="my-3 p-3 bg-white rounded box-shadow box-style"></div>			
			</div>
	
	</div>
	
	
	<div class="col-md-9 col-sm-7 col-xs-7">
		<div class="my-3 ml-2 p-3 bg-white rounded box-shadow box-style">
		  <div id="grey-box">
		     
<?php $yt = $db->QueryFetchArray("SELECT * FROM `coustom_config` WHERE name='youtubeLink' LIMIT 1");
		 ?>
			<div>
    		     <div class="video-responsive">
                    <iframe src="https://www.youtube.com/embed/<?php echo $yt['c_value']; ?>" width="720" height="400"></iframe>
                </div>
		    
		  </div>
		      
		      
		      
		 <div class="content">
				<div class="infobox">
			
				Watch video from this page by clicking on "Watch" button (or you can skip them if you don't want to watch them), then wait for the countdown to be credited. You have to watch one video at the time, otherwise you won't be credited.			</div>
			<div class="alert alert-info" role="alert">There is no video available yet!</div>			<div class="clearfix"></div>
		  </div>
		</div>
	  </div>
	</div>
  </div>
</main>
