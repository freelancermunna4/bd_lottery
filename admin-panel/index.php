<?php
	define('BASEPATH', true);
	define('IS_ADMIN', true);
	include('../system/init.php');
	if($is_online && $data['admin'] == 0){
		redirect($config['site_url']);
	}elseif(!$is_online){
		redirect('login.php');
	}

	/* Define allowed pages */
	$action = array(
		'users' => 1,
		'bank' => 1,
		'settings' => 1,
		'videos' => 1,
		'sales' => 1,
		'search' => 1,
		'requests' => 1,
		'newsletter' => 1,
		'dashboard' => 1,
		'gateways' => 1,
		'captcha' => 1,
		'top_users' => 1,
		'mailset' => 1,
		'coupon' => 1,
		'deposit' => 1,
		'withdraw' => 1,
		'dws' => 1,
		'ads' => 1,
		'lottery' => 1,
		'lottery_setting' => 1,
		'cs_setting' => 1,
		
		
	);

	$page_name = 'dashboard';
	if (isset($_GET['x']) && isset($action[$_GET['x']])) {
		$page_name = $_GET['x'];
	}
?>
<html>
<head><title> Admin Panel</title>
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="author" content="">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/fonts/font-awesome.css">
    <!--[if IE 8]><link rel="stylesheet" href="css/fonts/font-awesome-ie7.css"><![endif]-->
    <link rel="stylesheet" href="css/external/jquery.css">
    <link rel="stylesheet" href="css/elements.css">

	<!-- Load Javascript -->
    <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/libs/jquery-1.10.2.min.js"><\/script>')</script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/libs/jquery-migrate-1.2.1.min.js"><\/script>')</script>
    <script src="//code.jquery.com/ui/1.9.1/jquery-ui.min.js"></script>
    <script>window.jQuery.ui || document.write('<script src="js/libs/jquery-ui-1.9.1.min.js"><\/script>')</script>
    <!--[if gt IE 8]><!-->
    <script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/0.8.2/lodash.min.js"></script>
    <script>window._ || document.write('<script src="js/libs/lo-dash.min.js"><\/script>')</script>
    <!--<![endif]-->
    <!--[if lt IE 9]><script src="//documentcloud.github.com/underscore/underscore.js"></script><![endif]-->
    <script src="//cdnjs.cloudflare.com/ajax/libs/require.js/2.0.6/require.min.js"></script>
    <script>window.require || document.write('<script src="js/libs/require-2.0.6.min.js"><\/script>')</script>
    <script type="text/javascript">
        window.WebFontConfig = {
            google: { families: [ 'PT Sans:400,700' ] },
            active: function(){ $(window).trigger('fontsloaded') }
        };
    </script>
    <script defer async src="//ajax.googleapis.com/ajax/libs/webfont/1.0.28/webfont.js"></script>
    <script src="js/mylibs/polyfills/modernizr-2.6.1.min.js"></script>
    <!--[if lt IE 9]><script src="js/mylibs/polyfills/selectivizr.js"></script><![endif]-->
    <!--[if lt IE 10]><script src="js/mylibs/polyfills/excanvas.js"></script><![endif]-->
    <!--[if lt IE 10]><script src="js/mylibs/polyfills/classlist.js"></script><![endif]-->
    <script src="js/mylibs/jquery.lib.js"></script>
    <script src="js/mylibs/fullstats/jquery.css-transform.js"></script>
    <script src="js/mylibs/fullstats/jquery.animate-css-rotate-scale.js"></script>
    <script src="js/mylibs/forms/jquery.validate.js"></script>
    <script src="js/pespro.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/script.js"></script>
</head>
<body>
	<div id="loading-overlay"></div>
    <div id="loading">
        <span>Loading...</span>
    </div>
	<section id="toolbar">
		<div class="container_12">
			<div class="left">
				<ul class="breadcrumb">
					<li><a href="<?=$config['site_url']?>/admin-panel/">Admin Panel</a></li>
				</ul>
			</div>
			<div class="right">
				<ul>
					<li><a href="http://mn-shop.com" target="_blank"><span id="time"><?=date('H:i:s')?></span>Server Time</a></li>
                    <li class="space"></li>
					<li><a href="<?=$config['site_url']?>">View Website</a></li>
					<li class="red"><a href="<?=$config['site_url']?>/?logout">Logout</a></li>
				</ul>
			</div>
			<div class="phone">
                <li><a class="navigation" href="#"><span class="icon icon-list"></span></a></li>
            </div>
		</div>
	</section>
	<header class="container_12"><br></header>
	<div role="main" id="main" class="container_12 clearfix">
		<section class="toolbar">
			<div class="user">
                <div class="avatar">
                    <img src="http://www.gravatar.com/avatar/<?=md5(strtolower(trim($data['email'])))?>?s=28">
                </div>
                <span><?=$data['username']?></span>
                <ul>
                    <li><a href="index.php?x=users&edit=<?=$data['id']?>">Account Settings</a></li>
                    <li><a href="<?=$config['site_url']?>">View Website</a></li>
                    <li class="line"></li>
                    <li><a href="<?=$config['site_url']?>/?logout">Logout</a></li>
                </ul>
            </div>
		</section>
		<aside>
			<div class="top">
				<nav><ul class="collapsible accordion">
					<li>
						<a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/dashboard.png" alt="" height="16" width="16">Statistics</a>
						<ul>
							<li><a href="index.php"><span class="icon icon-arrow-right"></span> Dashboard</a></li>
						</ul>
					</li>
					<li>
						<a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/coins.png" alt="" height="16" width="16">Bank</a>
						<ul>
							<li><a href="index.php?x=sales"><span class="icon icon-arrow-right"></span> Deposit Request</a></li>
							<li><a href="index.php?x=requests"><span class="icon icon-arrow-right"></span> Withdrawl Requests</a></li>
						</ul>
					</li>
					<li>
						<a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/users.png" alt="" height="16" width="16">Users</a>
						<ul>
							<li><a href="index.php?x=users"><span class="icon icon-arrow-right"></span> All Users</a></li>
							<li><a href="index.php?x=top_users"><span class="icon icon-arrow-right"></span> Top 20 Users</a></li>
							<li><a href="index.php?x=users&today"><span class="icon icon-arrow-right"></span> Registered Today</a></li>
							<li><a href="index.php?x=users&online"><span class="icon icon-arrow-right"></span> Online Users</a></li>
							<li><a href="index.php?x=users&premium"><span class="icon icon-arrow-right"></span> VIP Users</a></li>
							<li><a href="index.php?x=users&unverified"><span class="icon icon-arrow-right"></span> Unconfirmed Email</a></li>
							<li><a href="index.php?x=users&banned"><span class="icon icon-arrow-right"></span> Banned Users</a></li>
							<li><a href="index.php?x=users&countries"><span class="icon icon-arrow-right"></span> Countries Overview</a></li>
							<li><a href="index.php?x=users&multi_accounts"><span class="icon icon-arrow-right"></span> Multiple Accounts</a></li>
						</ul>
					</li>
				
				
					
					
					
					
					
					<li>
						<a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/plus.png" alt="" height="16" width="16">Other Options</a>
						<ul>
							<li><a href="index.php?x=newsletter"><span class="icon icon-arrow-right"></span> Send Newsletter</a></li>
						</ul>
					</li>
					
					
					
					
					
					<li>
						<a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/sett.png" alt="" height="16" width="16">Settings</a>
						<ul>
							<li><a href="index.php?x=settings"><span class="icon icon-arrow-right"></span> General Settings</a></li>
							<li><a href="index.php?x=mailset"><span class="icon icon-arrow-right"></span> Mailing Settings</a></li>
							<li><a href="index.php?x=gateways"><span class="icon icon-arrow-right"></span> Payment Gateways</a></li>
							<li><a href="index.php?x=captcha"><span class="icon icon-arrow-right"></span> Captcha Settings</a></li>
							<li><a href="index.php?x=offerwalls"><span class="icon icon-arrow-right"></span> Offer Walls Settings</a></li>
						</ul>
					</li>
					
					<!-------coustom cod by arif---------->
					<li>
						<a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/sett.png" alt="" height="16" width="16">Coustom Setting</a>
						<ul>
							<li><a href="index.php?x=videos&ytapi"><span class="icon icon-arrow-right"></span>Inportent Seting</a></li>	
							<li><a href="index.php?x=cs_setting"><span class="icon icon-arrow-right"></span> Setting</a></li>
						
							<li><a href="index.php?x=deposit"><span class="icon icon-arrow-right"></span>All Deposit Bank</a></li>
                          
							<li><a href="index.php?x=withdraw"><span class="icon icon-arrow-right"></span> All Withdrawl Bank</a></li>
                            
						</ul>
					</li>
					 
					
				
			
                    
                    
                    <!-------coustom cod by arif  section---------->
					<li>
						<a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/ads.png" alt="" height="16" width="16">Lucky Coupon</a>
						<ul>
							<li><a href="index.php?x=coupon&add"><span class="icon icon-arrow-right"></span> Add New Coupn</a></li>
							<li><a href="index.php?x=coupon"><span class="icon icon-arrow-right"></span>All Coupon</a></li>
							<li><a href="index.php?x=coupon&all"><span class="icon icon-arrow-right"></span>Winner</a></li>
						</ul>
					</li>
					<!-------coustom cod by arif---------->
                     <!-------Lottery coustom cod by arif  section---------->
					<li>
						<a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/ads.png" alt="" height="16" width="16">Lottery</a>
						<ul>
							
						<li><a href="index.php?x=lottery_setting&add"><span class="icon icon-arrow-right"></span> Lottery Setting</a></li>
						<li><a href="index.php?x=lottery"><span class="icon icon-arrow-right"></span> Lottery Winner</a></li>
					
						</ul>
					</li>
					<!-------Lottery coustom cod by arif---------->
                    
                    
                    
                   
					
                    	<!-------google ads by arif Jobs section---------->
					<li>
						<a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/ads.png" alt="" height="16" width="16">Adsense</a>
						<ul>
							<li><a href="index.php?x=ads&tops"><span class="icon icon-arrow-right"></span>Top Ads</a></li>
							<li><a href="index.php?x=ads&bottom"><span class="icon icon-arrow-right"></span>Bottom Ads</a></li>
							<li><a href="index.php?x=ads&side"><span class="icon icon-arrow-right"></span>Sidebar Ads</a></li>
						</ul>
					</li>
					<!-------coustom cod by arif---------->
                   
					
				</ul></nav>		
			</div>
			<div class="bottom sticky">
				<div class="divider"></div>
				<div style="font-size:11px;margin:10px 15px"><b>Script Version:</b> <span style="float:right"><strong style="color:green">1.0.0</strong></span></div>
				</div>
		</aside>
	<?php
		include('sections/'.$page_name.'.php'); 
	?>
	</div>
	<script> $$.loaded(); </script>
	<footer class="container_12">
		<ul class="grid_6">
			<li><a href="http://bangladeshisoftware.com/" target="_blank">Bangladeshi Software</a></li>
			<li><a href="http://bangladeshisoftware.com/" target="_blank">Support Forum</a></li>
		</ul>
		<span class="grid_6">&copy; <?=date('Y')?> <a href="https://www.bangladeshisoftware.com/membership/" target="_blank">Software Buy</a></span>
	</footer>
</body>
</html>