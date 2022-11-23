<?php
	if(! defined('BASEPATH') ){ exit('Unable to view file.'); }
	
	$refs = $db->QueryFetchArray("SELECT COUNT(*) AS `total` FROM `users` WHERE `ref`='".$data['id']."'");
	$cms = $db->QueryFetchArray("SELECT SUM(`commission`) AS `total` FROM `ref_commissions` WHERE `user`='".$data['id']."'");
?>
	<main role="main" class="container">
      <div class="row">
		<?php 
			require_once(BASE_PATH.'/template/'.$config['theme'].'/common/sidebar.php');
		?>
		<div class="col-md-9 col-sm-7 col-xs-7">
			<div class="my-3 ml-2 p-3 bg-white rounded box-shadow box-style">
			  <div id="grey-box">
				<div class="title">
					<?=$lang['b_08']?>
				</div>
				<div class="content">
					<div class="infobox">
						<h1><?php echo $lang['b_97']; ?></h1>
						<p><center><?php echo lang_rep($lang['b_99'], array('-COMMISSION-' => $config['ref_commission'])); ?></center></p>
						<p><center><b><?php echo $lang['b_100']; ?></b></center></p>
						<center><input type="text" value="<?php echo $config['site_url']; ?>/?ref=<?php echo $data['id']; ?>" onclick="this.select()" readonly="true" class="form-control text-center w-75" /></center>
					</div>
					<div id="aff-block">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="50%">
									<p class="aff_block_p"><?php echo $lang['b_96']; ?>:</p>
									<p class="aff_block_p2"><?php echo number_format($refs['total']).' '.$lang['b_08']; ?></p>
								</td>
								<td width="50%">
									<p class="aff_block_p"><?php echo $lang['b_98']; ?>:</p>
									<p class="aff_block_p2"><?php echo number_format($cms['total'], 2).' '.$lang['b_13']; ?></p>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		  </div>
		</div>
	  </div>
    </main>