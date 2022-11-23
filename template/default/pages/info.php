<?php
	if(! defined('BASEPATH') ){ exit('Unable to view file.'); }
?>

<?php $yt = $db->QueryFetchArrayAll("SELECT * FROM `coustom_config` WHERE name='youtubeLink'");
		echo $yt['c_value']; ?>



	<main role="main" class="container">
      <div class="row">
		<div class="col-md-12">
			<div class="my-3 ml-2 p-3 bg-white rounded box-shadow box-style">
				<div id="grey-box">
					<div class="title">
						<?=$lang['b_05']?>
					</div>
					<div class="content">
						<p><?php echo $lang['b_61']; ?></p>

						<center><img src="static/img/help-page.png" alt="<?php echo $lang['b_05']; ?>"><br></center>

						<h2 class="text-warning"><?php echo $lang['b_62']; ?></h2>
						<p><?php echo $lang['b_63']; ?></p>
						<table cellpadding="4" class="table table-striped table-hover">
							<tr>
								<td><div class="blue-circle">1</div></td>
								<td align="left"><span style="font-weight:bold;font-size:12px;"><?php echo $lang['b_64']; ?></span><br><?php echo $lang['b_65']; ?></td>
							</tr>
							<tr>
								<td><div class="blue-circle">2</div></td>
								<td align="left"><span style="font-weight:bold;font-size:12px;"><?php echo $lang['b_66']; ?></span><br><?php echo lang_rep($lang['b_67'], array('-COMMISSION-' => $config['ref_commission'])); ?></td>
							</tr>
						</table>

						<h2 class="text-warning"><?php echo $lang['b_68']; ?></h2>
						<p><b><?php echo $lang['b_69']; ?></b> = <?php echo $lang['b_70']; ?></p/>

						<h2 class="text-warning"><?php echo $lang['b_71']; ?></h2>
						<p><?php echo lang_rep($lang['b_72'], array('-MIN-' => number_format($config['pay_min'], 2), '-COINS-' => number_format($config['convert_rate'] * $config['pay_min'], 2))); ?></p>
					</div>
				</div>
			</div>
		</div>
	  </div>
    </main>