<?php
	if(! defined('BASEPATH') ){ exit('Unable to view file.'); }
?> 

	<div class="col-md-3 col-sm-5 col-xs-5" style="margin-top: 15px !important;">
		<div>
			<div id="sidebar-block" class="box-shadow box-style"> 
				<div class="user" style="background: #fff !important;">
					<div class="info">
						<img src="http://www.gravatar.com/avatar/<?=md5(strtolower(trim($data['email'])))?>?s=40" class="border border-dark rounded" />
						<span>
							<?php echo $data['username']; ?><br />
							<span class="logout">
								<a href="<?=GenerateURL('account')?>"><?php echo $lang['b_11']; ?></a> | 
								<a href="<?=$config['site_url']?>/?logout"><?php echo $lang['b_12']; ?></a>
							</span>
						</span>
					</div>
				</div>
				<div class="inner">
					<div class="data">
						<span class="icon"><i class="fa fa-check-circle"></i></span>
						<span><b id="c_coins" class="text-warning"><?php echo number_format($data['coins'], 2); ?>৳ </b><small class="text-success">= <?php echo get_currency_symbol($config['currency_code']).number_format((1/$config['convert_rate']) * $data['coins'], 2); ?></small></span>
					</div><hr />
				
					<div class="btn-group btn-group-sm d-flex justify-content-center">
					  <a class="btn btn-success w-100" href="<?=GenerateURL('deposit')?>"><?php echo "Deposit"; ?></a>
					</div>
					<div class="btn-group btn-group-sm d-flex justify-content-center" style="margin-top: 5px;">
					  <a class="btn btn-primary w-100" href="<?=GenerateURL('withdraw')?>"><?php echo $lang['b_09']; ?></a>
					</div>
				</div>
			</div>
		</div>
		
		
	
			
			
			<div class="my-2">
				<div id="sidebar-block" class="box-shadow rounded box-style"> 
					<div class="title"><i class="fa fa-gamepad fa-lg"></i> <?php echo " Play & Win"; ?></div>
					<div class="menu">					
						<a class="btn btn-sm btn-secondary mb-1 w-100 text-left" href="<?=GenerateURL('lottery')?>"><i class="fa fa-gift fa-fw"></i> <?php echo "Lottery" ?></a>
						<a class="btn btn-sm btn-secondary mb-1 w-100 text-left" href="<?=GenerateURL('#')?>"><i class="fa fa-gift fa-fw"></i> <?php echo "Lucky Spin" ?></a>
						<a class="btn btn-sm btn-secondary mb-1 w-100 text-left" href="<?=GenerateURL('luckywheel')?>"><i class="fa fa-refresh fa-fw"></i> <?php echo " Lucky Recharge" ?></a>
					</div>
				</div>
				
			</div>

			<div class="my-2">
				<div id="sidebar-block" class="box-shadow rounded box-style"> 
					<div class="title"><i class="fa fa-comments-o fa-lg"></i> <?php echo " Contact Admin"; ?></div>
					<div class="menu">					
					<p style="padding: 5px;color: #fff;font-weight: bold;">
					<?php
					$contact=$db->QueryFetchArray("SELECT * FROM `coustom_config` WHERE name='contact'");
					echo $contact['c_value'];

								
					?>			
					</p>
					</div>
				</div>
				
			</div>
            
           
			
		
		
		
		
		<?php
			if(file_exists(BASE_PATH.'/template/'.$config['theme'].'/pages/horserace.php')) {
		?>
		
		<div class="my-2">
			<div id="sidebar-block" class="box-shadow rounded box-style"> 
			
				<div class="title"><i class="fa fa-gamepad fa-lg"></i> <?php echo $lang['b_15']; ?></div>
				<div class="menu">
					<a class="btn btn-sm btn-secondary mb-1 w-100 text-left" href="<?=GenerateURL('horserace')?>"><i class="fa fa-trophy fa-fw"></i> <?php echo $lang['b_17']; ?></a>
				</div>
			</div>
		</div>
        
        
        
		<?php } ?>
        
    
        
	</div>
	
	
