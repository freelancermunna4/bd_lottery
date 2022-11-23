<?php
	if(! defined('BASEPATH') ){ exit('Unable to view file.'); }
	
	$videos = $db->QueryGetNumRows("SELECT * FROM `vad_videos` WHERE `clicks`>'0' AND `status`='0'");
?>
	<main role="main" class="container">
      <div class="row">
		<?php 
			require_once(BASE_PATH.'/template/'.$config['theme'].'/common/sidebar.php');
		?>
		<div class="col-md-9 col-sm-7 col-xs-7">
			<div class="my-3 ml-2 p-3 bg-white rounded box-shadow box-style">
			  <div class="row">
				<div class="col-md-6 p-1">
				  <div id="dashboard-info">
					<div class="avatar"><img src="http://www.gravatar.com/avatar/<?=md5(strtolower(trim($data['email'])))?>?s=110" class="border border-white rounded" /></div>
					<div class="d-inline-block float-right">
						<span class="stats"><?=$lang['b_13']?>:</span>
						<span class="text-warning"><?=number_format($data['coins'], 2)?></span>
						<div class="clearfix"></div>
						<span class="stats"><?=$lang['b_278']?>:</span>
						<span class="text-white"><?=number_format($videos)?></span>
						<div class="clearfix"></div>
					</div>
				  </div>
				</div>
				<div class="col-md-6 p-1">
				  <div id="dashboard-info">
					<h1 class="text-warning"><?php echo $lang['b_97']; ?></h1>
					<p><?php echo lang_rep($lang['b_99'], array('-COMMISSION-' => $config['ref_commission'])); ?></p>
					<input type="text" value="<?php echo $config['site_url']; ?>/?ref=<?php echo $data['id']; ?>" onclick="this.select()" readonly="true" class="form-control" />
				  </div>
				</div>
			</div>
			<div id="grey-box">
				<div class="content">
					<h1 class="text-warning"><?php echo $lang['b_267']; ?></h1>
					<?php echo $lang['b_101']; ?>
				</div>
				<?php
					if(file_exists(BASE_PATH.'/template/'.$config['theme'].'/pages/horserace.php')) {
				?>
				<div class="content">
					<h1 class="text-warning"><?php echo $lang['b_268']; ?></h1>
					<?php echo $lang['b_204']; ?>
				</div>
				<?php } ?>
			</div>
		  </div>
		</div>
	  </div>
    </main>