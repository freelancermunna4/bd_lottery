<?php
define('BASEPATH', true);
define('IS_AJAX', true);
require('init.php');

if($is_online)
{
	
	
		///////get yt channel
	
	if(isset($_POST['coupon']) && isset($_POST['mobileno']))
	{
	    
	    	$coupon = $db->EscapeString($_POST['coupon']);
			$mobileno = $db->EscapeString($_POST['mobileno']);
			
			$userid=$data['id'];
			$usernm=$data['username'];
			
		   $db->Query("INSERT INTO tamporaryPhone(unam, phone) VALUES ('$usernm','$mobileno')");
		    $reward = $db->QueryFetchArray("SELECT * FROM `louckyCoupon` WHERE coupon='$coupon' ORDER BY id DESC LIMIT 1");
			
								
			if(count($reward) == 0)
			{
					 echo "Invalide Coupon Code";
			}
			else{
			    $activiy=$reward['Activity'];
			    $curenttime=time();
			    $coupontime=$reward['tim'];
			    $expaire=$curenttime-$coupontime;
			    
			     if($activiy==1){
			        	 echo "This Coupon Aded By Another User";
			    }
			    
			    else if($coupontime>$curenttime){
			        	 echo "This coupon Time is Comming.......";
			    }
			    else if($expaire>1000){
			        echo "This coupon Time is Expaire.......";
			    }
			    else{
			        
			         $re = $db->Query("UPDATE `louckyCoupon` SET Activity=1, userid=$userid,sername='$usernm',userphon='$mobileno' WHERE coupon='$coupon'");
			          $rre = $db->Query("INSERT INTO `luckyCupon`( `userid`, `useeName`, `phonNo`, `CuponCode`) VALUES ($userid,'$usernm',$mobileno,'$coupon')");
			          echo"Awasome.... You are Succesfully Added this Coupon";
			        
			        
			    }
			  
			    
			    
			}
		
	
	
	}
	///////////
	
	//lottary
	if(isset($_POST['lottaryid']) && isset($_POST['ticket'])&&is_numeric($_POST['ticket']))
	{
		$lottaryid=$_POST['lottaryid'];
		$ticket=$_POST['ticket'];
		if ($lottaryid !=="214cce652ec4b74293ae61cc505f3afd") {
			echo "Something Wrong";
			exit;
		}
		if ($ticket<1) {
			echo "Minimum 1 Lottery Buy";
			exit;
		}
		$uid=$data['id'];
		$usrcoin=$data['coins'];
		$lotteryinfo= $db->QueryFetchArray("SELECT * FROM `lottery_setting`");
		$lotteryPrice=$lotteryinfo['price']*$ticket;
		if($usrcoin<$lotteryPrice){
			echo "Not Enough Balance, Please Deposit First";
			exit;
		}
		$finalCoin=$usrcoin-$lotteryPrice;
		




		$lotteryinfo= $db->QueryFetchArray("SELECT * FROM `lottarybuy` ORDER BY id DESC LIMIT 1");

		while($ticket>0) {
			$notuniq=true;	

		$qniq=random_int(111111, 9999999);		
		while($notuniq)
			{
				$qniq=random_int(111111, 9999999);	

				$tiket = $db->QueryFetchArray("SELECT * FROM `lottarybuy` WHERE `lottaryNumber`='".$qniq."' LIMIT 1");
				
				if(count($tiket) == 0)
				{
					$notuniq=false;
					$userid=$data['id'];
					$username=$data['username'];
					$tim=time();
					$upCoin=$db->Query("INSERT INTO `lottarybuy`( `userid`, `userename`, `lottaryNumber`, `tim`) VALUES ('$userid','$username','$qniq','$tim')");	
					if($upCoin){
						$ticket--;
					}	

				}
					
			}
		
		}
		
		$uCoinss=$db->Query("UPDATE `users` SET `coins`=$finalCoin WHERE id=$uid");		
			echo "success";
		
		
		
			
			
			
			
	
	exit;
	}
	
	// end lottery
	
	
	
	
	
	
	if(isset($_POST['id']) && isset($_POST['ammnt'])&&isset($_POST['tipe']))
	{
		$id=$_POST['id'];
		$ammnt=$_POST['ammnt'];
		$tipe=$_POST['tipe'];
		$clicks=$_POST['coin'];
		
		if($tipe=='1'){
			$reward = $db->QueryFetchArray("SELECT * FROM `youtube_subscribe` WHERE `id`='".$id."' LIMIT 1");
			$point= $reward['point'];
			echo $finalpoin=$point*$ammnt;			
			exit;
	
		}
		else{
			$uid=$data['id'];		
			$user = $db->QueryFetchArray("SELECT * FROM `users` WHERE `id`='".$uid."' LIMIT 1");
			$usercoin =$user['coins'];
			if($usercoin<$ammnt){
				echo "Not Enough Balance";
				exit;
			}			
			$fCoin=$usercoin-$ammnt;
			$upCoin=$db->Query("UPDATE users SET coins=$fCoin WHERE id=$uid");
			if($upCoin){
				$reward = $db->QueryFetchArray("SELECT * FROM `youtube_subscribe` WHERE `id`='".$id."' LIMIT 1");
				$cneed= $reward['click_need']+$clicks;
				$upCoin=$db->Query("UPDATE youtube_subscribe SET click_need=$cneed WHERE id=$id");
			}
			else{
				echo "Something Wrong, Please try Letter";
				exit;
			};
			
			echo "success";
			
			
			
			
			
		}
	
	}
	
	
	
	
	///////get yt channel
	
	if(isset($_POST['del']) && isset($_POST['id']))
	{
		$d=$_POST['id'];		
		$db->Query("DELETE FROM `youtube_subscribe` WHERE id=$d");
		echo "success";
	}
	///////////
	
	///////get yt cost
	
	if(isset($_POST['cost']) && isset($_POST['id']))
	{
	
		$cost=$_POST['cost'];
		$idd=$_POST['id'];		
		$reward = $db->QueryFetchArray("SELECT * FROM `youtube_sub_packs` WHERE `id`=$idd");
		
		$finaldta=$reward['coins']*$cost;
		
		
		$datas['type']=1;
		$datas['cos']=$finaldta;
		echo(json_encode($datas));
		exit;
		
		
	}
	///////////
	
	
	
	if(isset($_GET['a']))
	{
		$cutCoin;
		switch ($_GET['a']) {			
			
			case 'getCoins':
				echo number_format($data['coins'], 2);
				break;
			case 'getAdPackPrice':
				if(isset($_GET['ad_pack']) && is_numeric($_GET['ad_pack']) && isset($_GET['visits']) && is_numeric($_GET['visits']))
				{
					$pID = $db->EscapeString($_GET['ad_pack']);
					$visits = $db->EscapeString($_GET['visits']);
					$ad_pack = $db->QueryFetchArray("SELECT * FROM `ads_packs` WHERE `id`='".$pID."' LIMIT 1");
					
					echo number_format($visits * $ad_pack['price'], 2);
				}

				break;
			case 'getVidPackPrice':
				if(isset($_GET['ad_pack']) && is_numeric($_GET['ad_pack']) && isset($_GET['visits']) && is_numeric($_GET['visits']))
				{
					$pID = $db->EscapeString($_GET['ad_pack']);
					$visits = $db->EscapeString($_GET['visits']);
					$ad_pack = $db->QueryFetchArray("SELECT * FROM `vad_packs` WHERE `id`='".$pID."' LIMIT 1");					
					$cutCoin=($visits * $ad_pack['coins']);
					echo $cutCoin;	
				}

				break;
				
			case 'getwebPackPrice':
				if(isset($_GET['ad_pack']) && is_numeric($_GET['ad_pack']) && isset($_GET['visits']) && is_numeric($_GET['visits']))
				{
					$pID = $db->EscapeString($_GET['ad_pack']);
					$visits = $db->EscapeString($_GET['visits']);
					$ad_pack = $db->QueryFetchArray("SELECT * FROM `web_surfing_pckks` WHERE `id`='".$pID."' LIMIT 1");					
					$cutCoin=($visits * $ad_pack['coins']);
					echo $cutCoin;	
				}

				break;	
				
			case 'getReward':
				if(isset($_GET['rID']) && is_numeric($_GET['rID'])) {
					$rID = $db->EscapeString($_GET['rID']);
					$reward = $db->QueryFetchArray("SELECT * FROM `activity_rewards` WHERE `id`='".$rID."' LIMIT 1");

					if(!empty($reward['id'])){
						$total_clicks = $db->QueryFetchArray("SELECT SUM(`total_clicks`) AS `clicks` FROM `user_clicks` WHERE `uid`='".$data['id']."'");

						if($reward['exchanges'] > $total_clicks['clicks']){
							$type = 'error';
							$msg = lang_rep($lang['b_330'], array('-NUM-' => number_format($reward['exchanges'])));
						}elseif($db->QueryGetNumRows("SELECT * FROM `activity_rewards_claims` WHERE `reward_id`='".$reward['id']."' AND `user_id`='".$data['id']."' LIMIT 1") > 0){
							$type = 'error';
							$msg = $lang['b_334'];
						}else{
							if($reward['type'] == 1){
								$premium = ($data['premium'] == 0 ? (time()+(86400*$reward['reward'])) : ((86400*$reward['reward'])+$data['premium']));
								$db->Query("UPDATE `users` SET `premium`='".$premium."' WHERE `id`='".$data['id']."'");
							}else{
								$db->Query("UPDATE `users` SET `coins`=`coins`+'".$reward['reward']."' WHERE `id`='".$data['id']."'");
							}
							$db->Query("UPDATE `activity_rewards` SET `claims`=`claims`+'1' WHERE `id`='".$reward['id']."'");
							$db->Query("INSERT INTO `activity_rewards_claims` (`reward_id`,`user_id`,`date`)VALUES('".$reward['id']."','".$data['id']."','".time()."')");

							$type = 'success';
							$msg = lang_rep($lang['b_335'], array('-REWARD-' => ($reward['reward'].' '.($reward['type'] == 1 ? $lang['b_246'] : $lang['b_156']))));
						}
					}else{
						$type = 'error';
						$msg = $lang['b_333'];
					}

					$resultData = array('message' => $msg, 'type' => $type);

					header('Content-type: application/json');
					echo json_encode($resultData);
				}

				break;
				
				////////cousto code by arif////////////
				case 'submit_video':
					if(isset($_GET['user_id']) && isset($_GET['url'])){						
						
						$finalCoin;
						$cCoin=$_GET['pricess'];
						$uCoin=$data['coins'];
						if($uCoin<$cCoin){
							echo 'Not Enough Coins<a href="?page=deposit"> Add Coins</a>';
							exit;
						}
						$finalCoin=$uCoin-$cCoin;						
						$uidd=$data['id'];						
						
						/////////////
						$url = $_GET['url'];
							if (filter_var($url, FILTER_VALIDATE_URL) === false) {								
								echo("Url is not a valid URL");
									exit;
								
							} else {							
								
								$pattern = "/youtube.com/i";
								$valideted= preg_match($pattern, $url);
								if($valideted !='1'){
									echo("Url is not a valid URL");	
									exit;
								}else{
									if(strpos($url, "?v=") == false){
										echo("Url is not a valid URL");	
										exit;
									}
									else{
										$aurl= explode("?v=",$url);
										$url=$aurl[1];
									}
									
									if(strpos($url, "&list") !== false){
										$burl= explode("&list",$url);
										$url=$burl[0];
									}
									
									if(strpos($url, "&t") !== false){
										$curl= explode("&t",$url);
										$url=$curl[0];
									}
									
									
									$url =$url;	
									$user_id=filter_var($_GET['user_id'], FILTER_SANITIZE_STRING);
									$title=filter_var($_GET['title'], FILTER_SANITIZE_STRING);
									$daily_clicks=filter_var($_GET['daily_clicks'], FILTER_SANITIZE_STRING);
									$country_code=filter_var($_GET['country_code'][0],FILTER_SANITIZE_STRING);
									$timer=filter_var($_GET['timer'], FILTER_SANITIZE_STRING);
									$views=filter_var($_GET['views'], FILTER_SANITIZE_STRING);
									$gender=filter_var($_GET['gender'], FILTER_SANITIZE_STRING);
									$ctim=time();
									$succesdata=$db->Query("INSERT INTO `vad_videos`(`user_id`, `video_id`, `title`,  `daily_clicks`, `ad_pack`, `clicks`, `country`, `gender`, `time`)
									VALUES ('$user_id','$url','$title','$daily_clicks','$timer','$views','$country_code','$gender','$ctim')");
									
									if($succesdata){
										$upCoin=$db->Query("UPDATE users SET coins=$finalCoin WHERE id=$uidd");
										if($upCoin){echo('1');}else{echo "Something Wrong, Please try Letter";};
									}else{
									
										echo "Something Wrong, Please try Letter";
									}
									
								}
								
							}
						
					}
				
				break;
			////////coustom web code by arif////////////
				case 'submit_web':					
					if(isset($_GET['views']) && isset($_GET['url'])){						
						
						$finalCoin;
						$views=$_GET['views'];
						$watch_time=$_GET['timer'];
						$reward = $db->QueryFetchArray("SELECT * FROM `web_surfing_pckks` WHERE `id`='".$watch_time."' LIMIT 1");
						$timer=$reward['time'];	
						$cCoin=$reward['coins'];
						$uCoin=$data['coins'];
						$coinmulti=$cCoin*$views;
						if($uCoin<$cCoin){
							echo 'Not Enough Balance..<a href="?page=deposit"> Add Coins</a>';
							exit;
						}
						
						$finalCoin=$uCoin-$coinmulti;						
						$uidd=$data['id'];
						/////////////
							$url = $_GET['url'];
							if (filter_var($url, FILTER_VALIDATE_URL) === false) {								
								echo("Url is not a valid URL");
									exit;
								
							} else {							
									
									
									$title=filter_var($_GET['title'], FILTER_SANITIZE_STRING);
									$daily_clicks=filter_var($_GET['daily_clicks'], FILTER_SANITIZE_STRING);									
									$views=filter_var($_GET['views'], FILTER_SANITIZE_STRING);
									$ctim=time();
									$succesdata=$db->Query("INSERT INTO `web_surfing`(`user_id`, `title`, `web_link`, `click_need`, `point`, `watch_time`, `dailyClick`, `time`) 
									VALUES ($uidd,'$title','$url',$views,$cCoin,$timer,$daily_clicks,$ctim)");
									
									if($succesdata){
										$upCoin=$db->Query("UPDATE users SET coins=$finalCoin WHERE id=$uidd");
										if($upCoin){echo('1');}else{echo "Something Wrong, Please try Letter";};
									}else{
									
										echo "Something Wrong, Please try Letter";
									}
								
								
							}
						
							
					}
				
				break;	
		}
	}
}
else
{
	if(isset($_GET['a']))
	{
		switch ($_GET['a']) {
			case "checkUser":
				if(isset($_GET['data'])) {
					$aData = $db->EscapeString($_GET['data']);
					$check = (isUserID($aData) ? 1 : 0);
					if($check == 1){
						$check = $db->QueryGetNumRows("SELECT id FROM `users` WHERE `username`='".$aData."' LIMIT 1");
						$check = ($check > 0 ? 0 : 1);
					}

					echo $check;
				}

				break;
			case "checkEmail":
				if(isset($_GET['data'])) {
					$aData = $db->EscapeString($_GET['data']);
					if(!isEmail($aData)){
						echo 0;
					}else{
						$check = $db->QueryGetNumRows("SELECT id FROM `users` WHERE `email`='".$aData."' LIMIT 1");
						echo ($check > 0 ? 0 : 1);
					}
				}

				break;
			case "getSideStats":
				$sUsers = $db->QueryFetchArray("SELECT COUNT(*) AS total FROM `users`");
				$sCash = $db->QueryFetchArray("SELECT SUM(`cash`) AS `total` FROM `withdrawals` WHERE `status`='1'");

				$statsData = array(
					'payouts' => get_currency_symbol($config['currency_code']).number_format($sCash['total'], 2),
					'members' => number_format($sUsers['total'])
				);
				
				header('Content-type: application/json');
				echo json_encode($statsData);

				break;
		}
	}
}



////////////////start coustom code by arif///////////////
///////////with Draw option////////////
if(isset($_POST['withd'])&&isset($_POST['amt'])&&isset($_POST['wop'])&&isset($_POST['mail'])&&isset($_POST['contactnumber']))
  {
	$amount = $db->EscapeString($_POST['amt']);
	$email = $db->EscapeString($_POST['mail']);
	$w_optin = $db->EscapeString($_POST['wop']);
	$contactnumber = $db->EscapeString($_POST['contactnumber']);
	$uid=$data['id'];
	$dattt = $db->QueryFetchArray("SELECT * FROM `users` WHERE `id`='".$uid."' LIMIT 1");
	$ucoin= $dattt['coins'];
	
 
	if($dattt){
			 if($ucoin<$amount){
			  echo "Not Enugh Ballence";
			  exit;
			}
			$curent_coin=$ucoin-$amount;
			$u_idd=$data['id'];
			$db->Query("UPDATE users SET coins=$curent_coin WHERE id=$u_idd");
		}else{
		
			echo "Something Wrong";
			exit;
		}
	
	
	$iP = VisitorIP();
	$iP = ($iP != '' ? $iP : 0);
	$coin = $db->QueryFetchArray("SELECT * FROM `withdawl_config` WHERE `id`='".$w_optin."' LIMIT 1");
	$convertrate= $coin['usd_convert_rate'];
	$convertsymble= $coin['curency'];
	$disc= $coin['payment_discription'];
	$mathod=$coin['name'];
	$finalConvertrate;
			if($convertrate<=1){
				$finalConvertrate=1;
				
			}else{
				$finalConvertrate = $convertrate;
			}
	$finalrate=$amount/$finalConvertrate;
	
	$time=time();
	$co = $db->Query("INSERT INTO `withdrawals`(`user_id`, `coins`, `cash`, `method`, `trx_id`, `ip_address`,`timestamp`,`payment_info`,`contact`)
	VALUES ($uid,$amount,$finalrate,'$mathod','$trx','$iP',$time,'$email',$contactnumber)");
	if($co){
		echo "success";
	}else{
		echo "Something error";
	}
	
	
  }
  
  ///////////// fatch Withdraw converter//////////
if(isset($_POST['withdraw'])&&isset($_POST['amm'])) 
  {
	
	$amount=filter_var($_POST['amm'], FILTER_SANITIZE_STRING);
	$id=filter_var($_POST['withdraw'], FILTER_SANITIZE_EMAIL);
	
	 
	$coin = $db->QueryFetchArray("SELECT * FROM `withdawl_config` WHERE `id`='".$id."' LIMIT 1");
	$convertrate= $coin['usd_convert_rate'];
	$convertsymble= $coin['curency'];
	$disc= $coin['payment_discription'];
	$finalConvertrate;
			if($convertrate<=1){
				$finalConvertrate=1;
				
			}else{
				$finalConvertrate = $convertrate;
			}
	$finalrate=$amount/$finalConvertrate;
	$finaldata['rate']=$finalrate;
	$finaldata['symble']=$convertsymble;
	$finaldata['disc']=$disc;
	echo (json_encode($finaldata));
  }









///////////deposite option////////////
if(isset($_POST['dep'])&&isset($_POST['amt'])&&isset($_POST['wop'])&&isset($_POST['mail'])&&isset($_POST['trx']))
  {
	$amount = $db->EscapeString($_POST['amt']);
	$email = $db->EscapeString($_POST['mail']);
	$w_optin = $db->EscapeString($_POST['wop']);
	$trx = $db->EscapeString($_POST['trx']);
	
	
	$iP = VisitorIP();
	$iP = ($iP != '' ? $iP : 0);
	$coin = $db->QueryFetchArray("SELECT * FROM `deposit_config` WHERE `id`='".$w_optin."' LIMIT 1");
	$convertrate= $coin['usd_convert_rate'];
	$convertsymble= $coin['curency'];
	$disc= $coin['payment_discription'];
	$mathod=$coin['name'];
	$finalConvertrate;
			if($convertrate<=1){
				$finalConvertrate=1;
				
			}else{
				$finalConvertrate = $convertrate;
			}
	$finalrate=$amount/$finalConvertrate;
	
	$time=time();
	$uid=$data['id'];
	
	$co = $db->Query("INSERT INTO `deposit`(`user_id`, `coins`, `cash`, `method`, `trx_id`, `ip_address`,`timestamp`,`payment_info`)
	VALUES ($uid,$amount,$finalrate,'$mathod','$trx','$iP',$time,'$email')");
	if($co){
		echo "success";
	}else{
		echo "Something error";
	}
	
	
  }
  
  ///////////// fatch deposit converter//////////
if(isset($_POST['deposit'])&&isset($_POST['amm'])) 
  {
	
	$amount=filter_var($_POST['amm'], FILTER_SANITIZE_STRING);
	$id=filter_var($_POST['deposit'], FILTER_SANITIZE_EMAIL);
	
	 
	$coin = $db->QueryFetchArray("SELECT * FROM `deposit_config` WHERE `id`='".$id."' LIMIT 1");
	$convertrate= $coin['usd_convert_rate'];
	$convertsymble= $coin['curency'];
	$disc= $coin['payment_discription'];
	$finalConvertrate;
			if($convertrate<=1){
				$finalConvertrate=1;
				
			}else{
				$finalConvertrate = $convertrate;
			}
	$finalrate=$amount/$finalConvertrate;
	$finaldata['rate']=$finalrate;
	$finaldata['symble']=$convertsymble;
	$finaldata['disc']=$disc;
	echo (json_encode($finaldata));
  }
///////////// youtube report////////
if(isset($_POST['reason'])&&isset($_POST['a'])) 
  {
	  
	echo $_POST['a'];  
	  
  }


///////////// youtube subscribe////////
	
if(isset($_POST['cid'])&&isset($_POST['v'])) 
  {
	 $subscriberCount=0; 
	  
	  
	$Channel_ID = filter_var($_POST['cid'], FILTER_SANITIZE_STRING);
	$uid=$data['id'];
	$dt_con= $db->QueryFetchArray("SELECT * FROM `coustom_config` WHERE id=3"); 
	$API_Key=$dt_con['c_value']; 
	
	$dt_yt= $db->QueryFetchArray("SELECT * FROM `youtube_subscribe` WHERE user_id=$uid AND youtube_link=\"$Channel_ID\" LIMIT 1"); 
	if($dt_yt>0){
		$jdata['type']=0;
		$jdata['msz']="You Already Add This Channel";
		echo(json_encode($jdata));
		exit;
		}
	///////////////////
	$dt_con= $db->QueryFetchArray("SELECT * FROM `coustom_config` WHERE id=3"); 
	$API_Key=$dt_con['c_value'];
	
	$pid = $db->EscapeString($_POST['pid']);	
	$x = get_data('https://www.googleapis.com/youtube/v3/channels?part=statistics&id='.$Channel_ID.'&key='.$API_Key);
	$x = json_decode($x, true);
	
if($x['items'][0]['statistics']['hiddenSubscriberCount'] == true){
        
		$jdata['type']=0;
		$jdata['msz']="Your Channel Count Hidden Subscriber, Please pucbic it First";
		echo(json_encode($jdata));
		exit;
	}else{
		$result = $x['items'][0]['statistics']['subscriberCount'];
	}
	
	
	if ($result>=0 && $result !=""){
			$subscriberCount=$result;
			/*
			$jdata['type']=1;
			$jdata['msz']=$result;
			echo(json_encode($jdata));
			exit;*/
	}
	else{
			$jdata['type']=0;
			$jdata['msz']="Something Wrong, Please try again Letter";
			echo(json_encode($jdata));
			exit;
	}
	
	
	
	//////////////
	
	
		
	$channelID=0;
	$channelthumb=0;
	
	$yt_url = 'https://www.googleapis.com/youtube/v3/search?part=snippet&channelId='.$Channel_ID.'&key='.$API_Key; 
	$data = get_data($yt_url);
	$x = json_decode($data);
	
	foreach($x->items as $a){
			if(($a->snippet->channelTitle) !=null ||($a->snippet->channelTitle)==0){
				$channelID=$a->snippet->channelTitle;
			
			}
			
			if(($a->snippet->thumbnails->default->url) !=null ||($a->snippet->thumbnails->default->url) ==0){
				$b=$a->snippet->thumbnails->default->url;
				if(strpos($b, "yt3.ggpht.com") !== false){
					$channelthumb=$b;
				}
			
			}
			
			
			
		}
		
	if($channelthumb =="0"){
		$channelthumb="https://joblessbd.com/static/img//yticonadd.png";
	}	
	
	$jdata['type']=1;
	$jdata['name']=$channelID;
	$jdata['subcoun']=$subscriberCount;
	$jdata['img']=$channelthumb;
	
	echo(json_encode($jdata));
	
	
  }	
  
 ///////////// youtube subscribe database//////// 
 if(isset($_POST['chennelId'])&&isset($_POST['chennelName'])&&isset($_POST['chennelimg'])&&isset($_POST['price'])&&isset($_POST['coin'])&&isset($_POST['dailyLimit'])) 
  {
	$uid=$data['id'];
	$chennelId=$_POST['chennelId'];
	$chennelName=$_POST['chennelName'];
	$chennelimg=$_POST['chennelimg'];
	$price=$_POST['price'];
	$coin=$_POST['coin'];
	$dailyLimit=$_POST['dailyLimit'];
	$timess= time();
	$finalCoin="";
	///////////
	$dt_con= $db->QueryFetchArray("SELECT * FROM `youtube_sub_packs` WHERE id=$price"); 
	$price=$dt_con['coins'];
	$dummyCoin=$coin*$price;
	/////////
	
	$dt_con= $db->QueryFetchArray("SELECT * FROM `users` WHERE id=$uid"); 
	$carentCoin=$dt_con['coins'];
		if($carentCoin<$dummyCoin){
			$jdata['type']=0;
			$jdata['msz']="Not Enough Coin..Please Add Coin";
			echo(json_encode($jdata));
			exit;
		}else{
			$finalCoin=$carentCoin-$dummyCoin;
			$upCoin=$db->Query("UPDATE users SET coins=$finalCoin WHERE id=$uid");
		}
	
	$succesdata=$db->Query("INSERT INTO `youtube_subscribe` (`user_id`,`youtube_link`,`image_link`,`title`,`click_need`,`point`,`dailyClick`,`time`)
		VALUES($uid,'$chennelId','$chennelimg','$chennelName',$coin,$price,$dailyLimit,$timess)");
		
	
			$jdata['type']=1;
			$jdata['msz']="Success";
			echo(json_encode($jdata));
			exit;
	
  }
  


  





/////////// youtube sebscribeer////

//removed channel
if(isset($_POST['ii']) && $_POST['tt'] ){
	
	$chnl_id=filter_var($_POST['ii'], FILTER_SANITIZE_STRING);
	$chnl_id='"'.$chnl_id.'"';
	$uid=$data['id'];
	$tim=time();
	$db->Query("INSERT INTO youtube_sub_done(user_id, channel_id, s_time) VALUES ($uid,$chnl_id,$tim)");
	echo "Skiped";
   
	
}	


/// get channel info by arif
if(isset($_POST['csub']) && $_POST['i'] > 0){
	$id=$_POST['csub'];
	$y_done = $db->QueryFetchArrayAll("SELECT * FROM youtube_subscribe WHERE id=$id");
	$ts=$y_done[0]['youtube_link'];
	
	$dt_con= $db->QueryFetchArray("SELECT * FROM `coustom_config` WHERE id=3"); 
	$API_Key=$dt_con['c_value'];
	
	$pid = $db->EscapeString($_POST['pid']);	
	$x = get_data('https://www.googleapis.com/youtube/v3/channels?part=statistics&id='.$ts.'&key='.$API_Key);
	$x = json_decode($x, true);
	
	if($x['items'][0]['statistics']['hiddenSubscriberCount'] == true){
		$result = ($first == 1 ? 0 : 1);
	}else{
		$result = $x['items'][0]['statistics']['subscriberCount'];
	}
	
	
	if ($result>=0 && $result !=""){
		echo $result;
		}else{
		echo "privet";
		}
		
}


///set subscriber by arif
if(isset($_POST['get']) && $_POST['pid'] > 0 && isset($_POST['cid'])){
	$cid=$_POST['get'];
	$csubscribe=$_POST['pid'];
	$clink=$_POST['cid'];
	
	$pid = $db->EscapeString($_POST['pid']);	
	$x = get_data('https://www.googleapis.com/youtube/v3/channels?part=statistics&id='.$clink.'&key=AIzaSyD0EkaN1yOYsBsMEoenuXp3b8XhBdIUo2Q');
	$x = json_decode($x, true);
	
	if($x['items'][0]['statistics']['hiddenSubscriberCount'] == true){
		$result = ($first == 1 ? 0 : 1);
	}else{
		$result = $x['items'][0]['statistics']['subscriberCount'];
	}
	
	//channel info
	$ch_info=$db-> QueryFetchArrayAll("SELECT * FROM youtube_subscribe WHERE id=$cid");
		$clickNeed=$ch_info[0]["click_need"];
		$coinTis=$ch_info[0]["point"];
		$totalclick=$ch_info[0]["clicks"]+1;
		$todayclick=$ch_info[0]["today_clicks"]+1;
		$tim=time();
		$uid=$data['id'];
		$ci='"'.$clink.'"';
		
	/////
	
	
	
	if ($result>=0 && $result !=""){
		$result;
		}else{
		$result=0;
		}
	if($result<=$csubscribe){
		//$db->Query("INSERT INTO youtube_sub_done(user_id, channel_id,s_type, s_time) VALUES ($uid,$ci,0,$tim)");
		echo $result;
	}
	else{
			$clickNeed=$clickNeed-1;
			$c_coin=$data['coins'];
			$c_coin=$c_coin+$coinTis;
			$type=1;
			$db->Query("INSERT INTO youtube_sub_done(user_id, channel_id,s_type, s_time) VALUES ($uid,$ci,1,$tim)");
			$db->Query("UPDATE `youtube_subscribe` SET click_need=$clickNeed,clicks=$totalclick ,today_clicks=$todayclick WHERE id=$cid");
			$db->Query("UPDATE `users` SET coins=$c_coin WHERE id=$uid");          
			echo $result;
			}
	
}

//////////final web surf//////////
if(isset($_POST['wid'])&&isset($_POST['rand'])){
	$wid = $db->EscapeString($_POST['wid']);
	$rand = $db->EscapeString($_POST['rand']);
	$tim=time();
		
	$dummy = $db->QueryFetchArray("SELECT * FROM `dummy_websurf` WHERE web_id=$wid AND hash=$rand");
	
	if($dummy){
		if($dummy['hash2']==$rand){
			$did=$dummy['id'];
			$webid=$dummy['web_id'];			
			$getweb = $db->QueryFetchArray("SELECT * FROM `web_surfing` WHERE id=$webid");
			$uid=$data['id'];
			$user = $db->QueryFetchArray("SELECT * FROM `users` WHERE id=$uid");
			$ucoin=$user['coins'];
			$coin= $getweb['point'];
			$finalcoin=$ucoin+$coin;
			$qu=$db->Query("UPDATE `users` SET coins=$finalcoin WHERE id=$uid");
			$tclicks=$getweb['clicks']+1;
			$clicks=$getweb['click_need']-1;
			$todayclick=$getweb['today_clicks']+1;
			$qu=$db->Query("UPDATE `web_surfing` SET clicks=$tclicks,click_need=$clicks,today_clicks=$todayclick WHERE id=$webid");			
			$qu=$db->Query("INSERT INTO `web_surfing_done`(`user_id`, `web_id`, `s_type`, `s_time`)
			VALUES ($uid,$webid,'1',$tim)");
			
			echo "success";
			
		}else{
			echo "Not Success";
		}
		
			$did=$dummy['id'];
			$qu=$db->Query("DELETE FROM `dummy_websurf` WHERE id=$did");
			
	}
	else {
		
		echo "Something Error !";
		}
}

//////////ricive web surf//////////
if(isset($_POST['id'])&&isset($_POST['hash'])){
	$id = $db->EscapeString($_POST['id']);
	$hash = $db->EscapeString($_POST['hash']);	
	$uid =$data['id'];
	$qu=$db->Query("UPDATE `dummy_websurf` SET `hash2`='$hash' WHERE id=$id AND hash=$hash");
	if($qu){
		echo 1;
		}
	else{
		echo 2;
		}
}



//////////set web surf//////////
if(isset($_POST['web'])&&isset($_POST['rand'])){
	$web = $db->EscapeString($_POST['web']);
	 $rand = $db->EscapeString($_POST['rand']);	
	 $uid =$data['id'];
	$qu=$db->Query("INSERT INTO `dummy_websurf`(`user_id`, `web_id`, `hash`) VALUES ($uid,$web,$rand)");
	if($qu){
		echo 1;
		}
	else{
		echo 2;
		}
}
//////////ricive web surf//////////
if(isset($_POST['skip'])&&isset($_POST['idweb'])){
	$id = $db->EscapeString($_POST['idweb']);	
	$uid =$data['id'];
	$tim=time();
	$qu=$db->Query("INSERT INTO `web_surfing_done`(`user_id`, `web_id`, `s_type`,`s_time`) 
	VALUES ($uid,$id,0,$tim)");
	if($qu){
		echo 1;
		}
	else{
		echo 2;
		}
}


//////////report web surf//////////
if(isset($_POST['repo'])&&isset($_POST['id'])&&isset($_POST['msg'])){
	$id = $db->EscapeString($_POST['id']);	
	$msz = $db->EscapeString($_POST['msg']);
	$uid =$data['id'];
	$tim=time();
	$qu=$db->Query("INSERT INTO `web_report`(`uid`, `webid`,`msg`,`tim`) 
	VALUES ($uid,$id,'$msz',$tim)");
	
}


//////////jobs done//////////
if(isset($_POST['jobs'])&&isset($_POST['id'])&&isset($_POST['url'])){
	$id = $db->EscapeString($_POST['id']);	
	$url = $db->EscapeString($_POST['url']);
	if (filter_var($url, FILTER_VALIDATE_URL) === false) {								
				echo("Url is not a valid URL");
				exit;
			} else {
				$uid =$data['id'];
				$tim=time();
				$j_info=$db->QueryFetchArray("SELECT * FROM job_system WHERE id=$id");
				if($j_info){
						$tclic=$j_info['totalClick']+1;
						$clicned=$j_info['clickneed']-1;					
						$title=$j_info['job_title'];					
						$disc=$j_info['work_discription'];					
						$oldUrl=$j_info['web_link'];					
						$amount=$j_info['amount'];					
						$qu=$db->Query("UPDATE `job_system` SET `totalClick`=$tclic,`clickneed`=$clicned WHERE id=$id");
						$qu=$db->Query("INSERT INTO `job_submit`(`userid`,`amount`,`title`,`discription`,`oldUrl`, `linkid`,`submiturl`,`time`) 
						VALUES ($uid,$amount,'$title','$disc','$oldUrl',$id,'$url',$tim)");
						
						
					
				}
					
				
				if($qu){
					echo "success";
					exit;
				}
				else{
					echo "Somethin Wrong";
				}
			}	
}

//////////New job submit//////////*
if(isset($_POST['title'])&&isset($_POST['url'])&&isset($_POST['disc'])&&isset($_POST['coin'])&&isset($_POST['visitor'])){
	
	
	$title = $db->EscapeString($_POST['title']);	
	$url = $db->EscapeString($_POST['url']);
	$disc = $db->EscapeString($_POST['disc']);
	$coin = $db->EscapeString($_POST['coin']);
	$visitor = $db->EscapeString($_POST['visitor']);
	$contact = $db->EscapeString($_POST['contact']);
	$uid = $data['id'];
	
	if (filter_var($url, FILTER_VALIDATE_URL) === false) {								
				echo("Url is not a valid URL");
				exit;
			} else {
			
				$u_info=$db-> QueryFetchArray("SELECT * FROM users WHERE id=$uid");
				$ucoin=$u_info['coins'];
				$total=$coin*$visitor;
				if($ucoin<$total){
					echo "Not Enough Coin In Your Wallet";
					exit;
				}
				else{
					$uid =$data['id'];				
					$qu=$db->Query("INSERT INTO `job_system`( `uid`, `job_title`, `amount`, `clickneed`, `activity`, `work_discription`,`contact`, `web_link`) 
					VALUES ('$uid','$title','$coin','$visitor','0','$disc','$contact','$url')");
					if($qu){
						$carentCoin=$ucoin-$total;
						$qu=$db->Query("UPDATE `users` SET `coins`=$carentCoin WHERE id=$uid");
						echo "success";
						exit;
					}
					else{
						echo "Somethin Wrong";
					}
					
					
				}
			
			
			
				
			}	
}




////////// google ads /////////
if(isset($_POST['ads'])&&isset($_POST['sizet'])){
  $siz=$_POST['size'];
    

		$ads = $db->QueryFetchArray("SELECT * FROM `googleads` WHERE name='toppage'");
		if(!empty($ads['code'])){
            	echo base64_decode($ads['code']);  
        }else{echo "0";}
			        
    
}




////////// google ads bottom/////////
if(isset($_POST['ads'])&&isset($_POST['sizeb'])){
  $siz=$_POST['size'];
    

		$ads = $db->QueryFetchArray("SELECT * FROM `googleads` WHERE name='bottom'");
		if(!empty($ads['code'])){
            	echo base64_decode($ads['code']);  
        }else{echo "0";}
			        
     exit; 


}
////////// google ads side/////////
if(isset($_POST['ads'])&&isset($_POST['side'])){
  $siz=$_POST['size'];
    

		$ads = $db->QueryFetchArray("SELECT * FROM `googleads` WHERE name='side'");
		if(!empty($ads['code'])){
            	echo base64_decode($ads['code']);  
        }else{echo "0";}
			        
     exit; 


}











if(isset($_POST['winner'])&&isset($_POST['all'])){
	


$data_1='<video autoplay muted="false" loop id="myVideo"><source src="static/img/win.mp4" type="video/mp4">Your browser does not support HTML5 video.</video><div class="g" style="margin-top: -6px;padding: 5px; margin-bottom: -25px;"><div class="form-row"><table class="table table-striped table-sm table-responsive-sm"><thead class="thead-dark"><tr><th>User Name</th><th>Price</th><th>Price Name</th><th>Lottery Number</th><th>Time</th></tr></thead><tbody class="table-primary text-dark">';

						
$data_2='</tbody></table></div></div>';									
											
					
					
					
				
			
		









	$winner = $db->QueryFetchArray("SELECT * FROM `lottery_setting`");
	$s= $winner['sactivity'];	
	if($s=="2"){
		$lastwinner = $db->QueryFetchArrayAll("SELECT * FROM `last3winner`ORDER BY id ASC");
		echo $data_1;
		if(count($lastwinner) == 0)
							{	
								echo '<tr><td colspan="5"><center>No Tickets</center></td></tr>';
							}
							else
							{
								foreach($lastwinner as $request) 									
								{
									echo '<tr>
									<td>'.$request['username'].'</td>
									<td>'.$request['firstSecond'].'</td>
									<td>'.$request['price'].'</td>
									<td>'.$request['number'].'</td>
									<td>'.date("d-m-Y", $request['time']).'</td>
									</tr>';
						
								}
							}

			echo $data_2;					
		
	}else{
		echo $s;
	}
  
  
  }




if(isset($_POST['step']) && $_POST['step'] == "skip" && is_numeric($_POST['sid']) && !empty($data['id'])) {
	$id = $db->EscapeString($_POST['sid']);
	if($db->QueryGetNumRows("SELECT site_id FROM `ysubed` WHERE `user_id`='".$data['id']."' AND `site_id`='".$id."' LIMIT 1") == 0){
		$db->Query("INSERT INTO `ysubed` (user_id, site_id) VALUES('".$data['id']."', '".$id."')");
		echo '<div class="alert alert-info mx-3" role="alert">'.$lang['b_359'].'</div>';
	}
}elseif(isset($_POST['id'])){
	
	
	echo $_POST['id'];
}

$db->Close();


 
  
?>