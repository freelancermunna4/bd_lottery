<?php
if(! defined('BASEPATH') ){ exit('Unable to view file.'); }



	$message = '';
	if(isset($_POST['winner']))
		{
			$firsPrice = $db->EscapeString($_POST['fprice']);			
			$secondPrice = $db->EscapeString($_POST['sprice']);
			$thirdPrice = $db->EscapeString($_POST['tprice']);			
			$fourthPrice = $db->EscapeString($_POST['frprice']);			
			$fifthPrice = $db->EscapeString($_POST['fvprice']);			
			$sixthPrice = $db->EscapeString($_POST['sxprice']);			
			$seventhPrice = $db->EscapeString($_POST['svprice']);			
			$eighthPrice = $db->EscapeString($_POST['etprice']);			
			$ninthPrice = $db->EscapeString($_POST['nnprice']);			
			$corrector=true;

			$firstWinner="";
			$secondWinner="";
			$thirdWinner="";
			$fourthWinner = "";			
			$fifthWinner = "";			
			$sixthWinner = "";			
			$seventhWinner = "";			
			$eighthWinner = "";			
			$ninthWinner = "";	

			
			if (!empty($firsPrice)) {
				$firstWinner=$db->QueryFetchArray("SELECT * FROM `lottarybuy` WHERE lottaryNumber=$firsPrice");
				if(count($firstWinner)<1){
					 $message = '<div class="alert success">
					<strong>Warning!</strong> This Lottery Number('.$firsPrice.') Not Found
					in (First Winner), Please Enter Correct Lottery Number. </div>';
					$corrector=false;
				}
				
			}
			if (!empty($secondPrice)) {
				$secondWinner=$db->QueryFetchArray("SELECT * FROM `lottarybuy` WHERE lottaryNumber=$secondPrice");
				if(count($secondWinner)<1){
					 $message = '<div class="alert success">
					<strong>Warning!</strong> This Lottery Number('.$secondPrice.') Not Found in (Second Winner), Please Enter Correct Lottery Number. </div>';
					$corrector=false;
				}
			}
			if (!empty($thirdPrice)) {
				$thirdWinner=$db->QueryFetchArray("SELECT * FROM `lottarybuy` WHERE lottaryNumber=$thirdPrice");
				if(count($thirdWinner)<1){
					 $message = '<div class="alert success">
					<strong>Warning!</strong> This Lottery Number('.$thirdPrice.') Not Found in (Trird Winner), Please Enter Correct Lottery Number. </div>';
					$corrector=false;
				}
			}
			if (!empty($fourthPrice)) {
				$fourthWinner=$db->QueryFetchArray("SELECT * FROM `lottarybuy` WHERE lottaryNumber=$fourthPrice");
				if(count($fourthWinner)<1){
					 $message = '<div class="alert success">
					<strong>Warning!</strong> This Lottery Number('.$fourthPrice.') Not Found in (Trird Winner), Please Enter Correct Lottery Number. </div>';
					$corrector=false;
				}
			}
			if (!empty($fifthPrice)) {
				$fifthWinner=$db->QueryFetchArray("SELECT * FROM `lottarybuy` WHERE lottaryNumber=$fifthPrice");
				if(count($fifthWinner)<1){
					 $message = '<div class="alert success">
					<strong>Warning!</strong> This Lottery Number('.$fifthPrice.') Not Found in (Trird Winner), Please Enter Correct Lottery Number. </div>';
					$corrector=false;
				}
			}
			if (!empty($sixthPrice)) {
				$sixthWinner=$db->QueryFetchArray("SELECT * FROM `lottarybuy` WHERE lottaryNumber=$sixthPrice");
				if(count($sixthWinner)<1){
					 $message = '<div class="alert success">
					<strong>Warning!</strong> This Lottery Number('.$sixthPrice.') Not Found in (Trird Winner), Please Enter Correct Lottery Number. </div>';
					$corrector=false;
				}
			}		
			if (!empty($seventhPrice)) {
				$seventhWinner=$db->QueryFetchArray("SELECT * FROM `lottarybuy` WHERE lottaryNumber=$seventhPrice");
				if(count($seventhWinner)<1){
					 $message = '<div class="alert success">
					<strong>Warning!</strong> This Lottery Number('.$seventhPrice.') Not Found in (Trird Winner), Please Enter Correct Lottery Number. </div>';
					$corrector=false;
				}
			}	
			if (!empty($eighthPrice)) {
				$eighthWinner=$db->QueryFetchArray("SELECT * FROM `lottarybuy` WHERE lottaryNumber=$eighthPrice");
				if(count($eighthWinner)<1){
					 $message = '<div class="alert success">
					<strong>Warning!</strong> This Lottery Number('.$eighthPrice.') Not Found in (Trird Winner), Please Enter Correct Lottery Number. </div>';
					$corrector=false;
				}
			}
			if (!empty($ninthPrice)) {
				$ninthWinner=$db->QueryFetchArray("SELECT * FROM `lottarybuy` WHERE lottaryNumber=$ninthPrice");
				if(count($ninthWinner)<1){
					 $message = '<div class="alert success">
					<strong>Warning!</strong> This Lottery Number('.$ninthPrice.') Not Found in (Trird Winner), Please Enter Correct Lottery Number. </div>';
					$corrector=false;
				}
			}

	}
	
	if(isset($_GET['del']) && is_numeric($_GET['del']))
	{
		$del = $db->EscapeString($_GET['del']); 
		$db->Query("DELETE FROM `lottary` WHERE `id`='".$del."'");
	}
	// bottom function
	$sell=$db->QueryFetchArrayAll("SELECT * FROM `lottarybuy` ORDER BY id ASC");
	$sst=$db->QueryFetchArray("SELECT * FROM `lottery_setting`");
	$lt=$db->QueryFetchArrayAll("SELECT * FROM `lottary`");
	
	$x = (int)$sst['adminpercent'];
	$y =(int)count($sell)/100;
	$d=100-$x;
	$usersell=(int)number_format($y*$d);
	$adminsell=(int)number_format($y*$x);
	//end bottom function


	if(isset($_POST['finalwinner']))
	{
		$_firstWinner="";									
		$_secondWinner="";									
		$_thirdWinner="";
		$_fourthWinner="";
		$_fifthWinner="";
		$_sixthWinner="";
		$_seventhWinner="";
		$_eighthWinner="";
		$_ninthWinner="";
		if(isset($_POST['fprice'])){
			$_firstWinner=$db->EscapeString($_POST['fprice']);
		}
		if(isset($_POST['sprice'])){
		$_secondWinner=$db->EscapeString($_POST['sprice']);
		}
		if(isset($_POST['tprice'])){
		$_thirdWinner=$db->EscapeString($_POST['tprice']);
		}
		if(isset($_POST['frprice'])){
		$_fourthWinner=$db->EscapeString($_POST['frprice']);
		}
		if(isset($_POST['fvprice'])){
		$_fifthWinner=$db->EscapeString($_POST['fvprice']);
		}
		if(isset($_POST['sxprice'])){
		$_sixthWinner=$db->EscapeString($_POST['sxprice']);
		}
		if(isset($_POST['svprice'])){
		$_seventhWinner=$db->EscapeString($_POST['svprice']);
		}
		if(isset($_POST['etprice'])){
		$_eighthWinner=$db->EscapeString($_POST['etprice']);
		}
		if(isset($_POST['nnprice'])){
		$_ninthWinner=$db->EscapeString($_POST['nnprice']);
		}



		$firstWinner="";
		$secondWinner="";
		$thirdWinner="";
		$fourthWinner="";
		$fifthWinner="";
		$sixthWinner="";
		$eighthWinner="";
		$ninthWinner="";
		// start
		if (!empty($_firstWinner)) {
			$firstWinner=$db->QueryFetchArray("SELECT * FROM `lottarybuy` WHERE lottaryNumber=$_firstWinner");
		}
		
		if (!empty($_secondWinner)) {
			$secondWinner=$db->QueryFetchArray("SELECT * FROM `lottarybuy` WHERE lottaryNumber=$_secondWinner");
		}

		if (!empty($_thirdWinner)) {
			$thirdWinner=$db->QueryFetchArray("SELECT * FROM `lottarybuy` WHERE lottaryNumber=$_thirdWinner");
		}

		if (!empty($_fourthWinner)) {
		 	$fourthWinner=$db->QueryFetchArray("SELECT * FROM `lottarybuy` WHERE lottaryNumber=$_fourthWinner");
		}

		if (!empty($_fifthWinner)) {
			$fifthWinner=$db->QueryFetchArray("SELECT * FROM `lottarybuy` WHERE lottaryNumber=$_fifthWinner");
		}

		if (!empty($_sixthWinner)) {
			$sixthWinner=$db->QueryFetchArray("SELECT * FROM `lottarybuy` WHERE lottaryNumber=$_sixthWinner");
		}

		if (!empty($_seventhWinner)) {
			$seventhWinner=$db->QueryFetchArray("SELECT * FROM `lottarybuy` WHERE lottaryNumber=$_seventhWinner");
		}

		if (!empty($_eighthWinner)) {
			$eighthWinner=$db->QueryFetchArray("SELECT * FROM `lottarybuy` WHERE lottaryNumber=$_eighthWinner");
		}

		if (!empty($_ninthWinner)) {
			$ninthWinner=$db->QueryFetchArray("SELECT * FROM `lottarybuy` WHERE lottaryNumber=$_ninthWinner");
		}
		$lotterysetting=$db->QueryFetchArray("SELECT * FROM `lottery_setting` LIMIT 1");
		$curentTime=time();
		$db->Query("DELETE FROM `last3winner`");
		$db->Query("DELETE FROM `showwinner`");
		
		

		if(!empty($firstWinner)){
			$_userid=$firstWinner['userid'];
			$_lottaryNumber=$firstWinner['lottaryNumber'];
			$lottary=$db->QueryFetchArray("SELECT * FROM `lottary` WHERE first_secon='First' LIMIT 1");	
			$dummyuser=$db->QueryFetchArray("SELECT * FROM `users`  WHERE id=$_userid LIMIT 1");			
		
			$Price=$lottary['pricevalue'];
			$price_name=$lottary['price_name'];
			$first_secon=$lottary['first_secon'];

			$userName=$dummyuser['username'];
			$userCoin=$dummyuser['coins'];
			$finalCoin=$userCoin+$Price;

			$db->Query("INSERT INTO `lottary_winner`(`userid`, `username`, `priceName`,`price`, `number`, `tim`) VALUES ($_userid,'$userName','$price_name','$Price',$_lottaryNumber,$curentTime)");
			$db->Query("INSERT INTO `last3winner`(`userid`, `username`,`number`,`firstSecond`, `price`, `priceValue`, `time`) VALUES ($_userid,'$userName','$_lottaryNumber','$first_secon','$price_name','$Price',$curentTime)");
			$db->Query("UPDATE `users` SET`coins`=$finalCoin WHERE id=$_userid");
			$db->Query("INSERT INTO `showwinner`(`usrid`, `username`, `firstSecond`, `pricename`, `number`) VALUES ($_userid,'$userName','First','$price_name',$_lottaryNumber)");

		}
		

		if(!empty($secondWinner)){
			$_userid=$secondWinner['userid'];
			$_lottaryNumber=$secondWinner['lottaryNumber'];
			$lottary=$db->QueryFetchArray("SELECT * FROM `lottary` WHERE first_secon='Second' LIMIT 1");
			$dummyuser=$db->QueryFetchArray("SELECT * FROM `users`  WHERE id=$_userid LIMIT 1");

			$Price=$lottary['pricevalue'];
			$price_name=$lottary['price_name'];
			$first_secon=$lottary['first_secon'];

			$userName=$dummyuser['username'];
			$userCoin=$dummyuser['coins'];
			$finalCoin=$userCoin+$Price;

			$db->Query("INSERT INTO `lottary_winner`(`userid`, `username`, `priceName`,`price`, `number`, `tim`) VALUES ($_userid,'$userName','$price_name','$Price',$_lottaryNumber,$curentTime)");

			$db->Query("INSERT INTO `last3winner`(`userid`, `username`,`number`,`firstSecond`, `price`, `priceValue`, `time`) VALUES ($_userid,'$userName','$_lottaryNumber','$first_secon','$price_name','$Price',$curentTime)");
			$db->Query("UPDATE `users` SET`coins`=$finalCoin WHERE id=$_userid");

			$db->Query("INSERT INTO `showwinner`(`usrid`, `username`, `firstSecond`, `pricename`, `number`) VALUES ($_userid,'$userName','Second','$price_name',$_lottaryNumber)");

		}


		if(!empty($thirdWinner)){
			$_userid=$thirdWinner['userid'];
			$_lottaryNumber=$thirdWinner['lottaryNumber'];
			$lottary=$db->QueryFetchArray("SELECT * FROM `lottary` WHERE first_secon='Third' LIMIT 1");	
			$dummyuser=$db->QueryFetchArray("SELECT * FROM `users`  WHERE id=$_userid LIMIT 1");			
		
			$Price=$lottary['pricevalue'];
			$price_name=$lottary['price_name'];
			$first_secon=$lottary['first_secon'];

			$userName=$dummyuser['username'];
			$userCoin=$dummyuser['coins'];
			$finalCoin=$userCoin+$Price;

			$db->Query("INSERT INTO `lottary_winner`(`userid`, `username`, `priceName`,`price`, `number`, `tim`) VALUES ($_userid,'$userName','$price_name','$Price',$_lottaryNumber,$curentTime)");
			$db->Query("INSERT INTO `last3winner`(`userid`, `username`,`number`,`firstSecond`, `price`, `priceValue`, `time`) VALUES ($_userid,'$userName','$_lottaryNumber','$first_secon','$price_name','$Price',$curentTime)");
			$db->Query("UPDATE `users` SET`coins`=$finalCoin WHERE id=$_userid");			
			$db->Query("INSERT INTO `showwinner`(`usrid`, `username`, `firstSecond`, `pricename`, `number`) VALUES ($_userid,'$userName','Third','$price_name',$_lottaryNumber)");
		}

		if(!empty($fourthWinner)){
			$_userid=$fourthWinner['userid'];
			$_lottaryNumber=$fourthWinner['lottaryNumber'];
			$lottary=$db->QueryFetchArray("SELECT * FROM `lottary` WHERE first_secon='Fourth' LIMIT 1");	
			$dummyuser=$db->QueryFetchArray("SELECT * FROM `users`  WHERE id=$_userid LIMIT 1");			
			
			$Price=$lottary['pricevalue'];
			$price_name=$lottary['price_name'];
			$first_secon=$lottary['first_secon'];

			$userName=$dummyuser['username'];
			$userCoin=$dummyuser['coins'];
			$finalCoin=$userCoin+$Price;

			$db->Query("INSERT INTO `lottary_winner`(`userid`, `username`, `priceName`,`price`, `number`, `tim`) VALUES ($_userid,'$userName','$price_name','$Price',$_lottaryNumber,$curentTime)");
			$db->Query("INSERT INTO `last3winner`(`userid`, `username`,`number`,`firstSecond`, `price`, `priceValue`, `time`) VALUES ($_userid,'$userName','$_lottaryNumber','$first_secon','$price_name','$Price',$curentTime)");
			$db->Query("UPDATE `users` SET`coins`=$finalCoin WHERE id=$_userid");			
			$db->Query("INSERT INTO `showwinner`(`usrid`, `username`, `firstSecond`, `pricename`, `number`) VALUES ($_userid,'$userName','Fourth','$price_name',$_lottaryNumber)");
		}
		if(!empty($fifthWinner)){
			$_userid=$fifthWinner['userid'];
			$_lottaryNumber=$fifthWinner['lottaryNumber'];
			$lottary=$db->QueryFetchArray("SELECT * FROM `lottary` WHERE first_secon='Fifth' LIMIT 1");	
			$dummyuser=$db->QueryFetchArray("SELECT * FROM `users`  WHERE id=$_userid LIMIT 1");			
		
			$Price=$lottary['pricevalue'];
			$price_name=$lottary['price_name'];
			$first_secon=$lottary['first_secon'];

			$userName=$dummyuser['username'];
			$userCoin=$dummyuser['coins'];
			$finalCoin=$userCoin+$Price;

			$db->Query("INSERT INTO `lottary_winner`(`userid`, `username`, `priceName`,`price`, `number`, `tim`) VALUES ($_userid,'$userName','$price_name','$Price',$_lottaryNumber,$curentTime)");
			$db->Query("INSERT INTO `last3winner`(`userid`, `username`,`number`,`firstSecond`, `price`, `priceValue`, `time`) VALUES ($_userid,'$userName','$_lottaryNumber','$first_secon','$price_name','$Price',$curentTime)");
			$db->Query("UPDATE `users` SET`coins`=$finalCoin WHERE id=$_userid");			
			$db->Query("INSERT INTO `showwinner`(`usrid`, `username`, `firstSecond`, `pricename`, `number`) VALUES ($_userid,'$userName','Fifth','$price_name',$_lottaryNumber)");
		}

		if(!empty($sixthWinner)){
			$_userid=$sixthWinner['userid'];
			$_lottaryNumber=$sixthWinner['lottaryNumber'];
			$lottary=$db->QueryFetchArray("SELECT * FROM `lottary` WHERE first_secon='Sixth' LIMIT 1");	
			$dummyuser=$db->QueryFetchArray("SELECT * FROM `users`  WHERE id=$_userid LIMIT 1");			
		
			$Price=$lottary['pricevalue'];
			$price_name=$lottary['price_name'];
			$first_secon=$lottary['first_secon'];

			$userName=$dummyuser['username'];
			$userCoin=$dummyuser['coins'];
			$finalCoin=$userCoin+$Price;

			$db->Query("INSERT INTO `lottary_winner`(`userid`, `username`, `priceName`,`price`, `number`, `tim`) VALUES ($_userid,'$userName','$price_name','$Price',$_lottaryNumber,$curentTime)");
			$db->Query("INSERT INTO `last3winner`(`userid`, `username`,`number`,`firstSecond`, `price`, `priceValue`, `time`) VALUES ($_userid,'$userName','$_lottaryNumber','$first_secon','$price_name','$Price',$curentTime)");
			$db->Query("UPDATE `users` SET`coins`=$finalCoin WHERE id=$_userid");			
			$db->Query("INSERT INTO `showwinner`(`usrid`, `username`, `firstSecond`, `pricename`, `number`) VALUES ($_userid,'$userName','Sixth','$price_name',$_lottaryNumber)");
		}

		if(!empty($seventhWinner)){
			$_userid=$seventhWinner['userid'];
			$_lottaryNumber=$seventhWinner['lottaryNumber'];
			$lottary=$db->QueryFetchArray("SELECT * FROM `lottary` WHERE first_secon='Seventh' LIMIT 1");	
			$dummyuser=$db->QueryFetchArray("SELECT * FROM `users`  WHERE id=$_userid LIMIT 1");			
		
			$Price=$lottary['pricevalue'];
			$price_name=$lottary['price_name'];
			$first_secon=$lottary['first_secon'];

			$userName=$dummyuser['username'];
			$userCoin=$dummyuser['coins'];
			$finalCoin=$userCoin+$Price;

			$db->Query("INSERT INTO `lottary_winner`(`userid`, `username`, `priceName`,`price`, `number`, `tim`) VALUES ($_userid,'$userName','$price_name','$Price',$_lottaryNumber,$curentTime)");
			$db->Query("INSERT INTO `last3winner`(`userid`, `username`,`number`,`firstSecond`, `price`, `priceValue`, `time`) VALUES ($_userid,'$userName','$_lottaryNumber','$first_secon','$price_name','$Price',$curentTime)");
			$db->Query("UPDATE `users` SET`coins`=$finalCoin WHERE id=$_userid");			
			$db->Query("INSERT INTO `showwinner`(`usrid`, `username`, `firstSecond`, `pricename`, `number`) VALUES ($_userid,'$userName','Sventh','$price_name',$_lottaryNumber)");
		}

		if(!empty($eighthWinner)){
			$_userid=$eighthWinner['userid'];
			$_lottaryNumber=$eighthWinner['lottaryNumber'];
			$lottary=$db->QueryFetchArray("SELECT * FROM `lottary` WHERE first_secon='Eighth' LIMIT 1");	
			$dummyuser=$db->QueryFetchArray("SELECT * FROM `users`  WHERE id=$_userid LIMIT 1");			
		
			$Price=$lottary['pricevalue'];
			$price_name=$lottary['price_name'];
			$first_secon=$lottary['first_secon'];

			$userName=$dummyuser['username'];
			$userCoin=$dummyuser['coins'];
			$finalCoin=$userCoin+$Price;

			$db->Query("INSERT INTO `lottary_winner`(`userid`, `username`, `priceName`,`price`, `number`, `tim`) VALUES ($_userid,'$userName','$price_name','$Price',$_lottaryNumber,$curentTime)");
			$db->Query("INSERT INTO `last3winner`(`userid`, `username`,`number`,`firstSecond`, `price`, `priceValue`, `time`) VALUES ($_userid,'$userName','$_lottaryNumber','$first_secon','$price_name','$Price',$curentTime)");
			$db->Query("UPDATE `users` SET`coins`=$finalCoin WHERE id=$_userid");			
			$db->Query("INSERT INTO `showwinner`(`usrid`, `username`, `firstSecond`, `pricename`, `number`) VALUES ($_userid,'$userName','Eighth','$price_name',$_lottaryNumber)");
		}


		if(!empty($ninthWinner)){
			$_userid=$ninthWinner['userid'];
			$_lottaryNumber=$ninthWinner['lottaryNumber'];
			$lottary=$db->QueryFetchArray("SELECT * FROM `lottary` WHERE first_secon='Ninth' LIMIT 1");	
			$dummyuser=$db->QueryFetchArray("SELECT * FROM `users`  WHERE id=$_userid LIMIT 1");			
		
			$Price=$lottary['pricevalue'];
			$price_name=$lottary['price_name'];
			$first_secon=$lottary['first_secon'];

			$userName=$dummyuser['username'];
			$userCoin=$dummyuser['coins'];
			$finalCoin=$userCoin+$Price;

			$db->Query("INSERT INTO `lottary_winner`(`userid`, `username`, `priceName`,`price`, `number`, `tim`) VALUES ($_userid,'$userName','$price_name','$Price',$_lottaryNumber,$curentTime)");
			$db->Query("INSERT INTO `last3winner`(`userid`, `username`,`number`,`firstSecond`, `price`, `priceValue`, `time`) VALUES ($_userid,'$userName','$_lottaryNumber','$first_secon','$price_name','$Price',$curentTime)");
			$db->Query("UPDATE `users` SET`coins`=$finalCoin WHERE id=$_userid");			
			$db->Query("INSERT INTO `showwinner`(`usrid`, `username`, `firstSecond`, `pricename`, `number`) VALUES ($_userid,'$userName','Ninth','$price_name',$_lottaryNumber)");
		}

		$Timer=time();
		$db->Query("UPDATE `lottery_setting` SET `sactivity`=2,`withdrawtime`=$Timer WHERE  name='lottery'");
		$db->Query("DELETE FROM `lottarybuy`");
	}
	

?>


<?php 
if($corrector){
$fNumber="";
$sNumber="";
$tNumber="";
$frNumber="";
$fvNumber="";
$sxNumber="";
$svNumber="";
$etNumber="";
$nnNumber="";

$firstpric=$db->QueryFetchArray("SELECT * FROM `lottary` WHERE first_secon='first'");
$secondpric=$db->QueryFetchArray("SELECT * FROM `lottary` WHERE first_secon='second'");
$thirdpric=$db->QueryFetchArray("SELECT * FROM `lottary` WHERE first_secon='third'");
$fourthpric=$db->QueryFetchArray("SELECT * FROM `lottary` WHERE first_secon='fourth'");
$fifthpric=$db->QueryFetchArray("SELECT * FROM `lottary` WHERE first_secon='fifth'");
$sixthpric=$db->QueryFetchArray("SELECT * FROM `lottary` WHERE first_secon='sixth'");
$seventhpric=$db->QueryFetchArray("SELECT * FROM `lottary` WHERE first_secon='seventh'");
$eighthpric=$db->QueryFetchArray("SELECT * FROM `lottary` WHERE first_secon='eighth'");
$ninthpric=$db->QueryFetchArray("SELECT * FROM `lottary` WHERE first_secon='ninth'");

// first price
	if (count($firstpric)>0) {
		if (!empty($firsPrice)) {
			$fNumber=$db->QueryFetchArray("SELECT * FROM `lottarybuy` WHERE lottaryNumber='$firsPrice' LIMIT 1");
		}else{
			$fNumber=$db->QueryFetchArray("SELECT * FROM `lottarybuy` ORDER BY RAND() LIMIT 1");
		}
	}
// second price
if (count($secondpric)>0) {
	if (!empty($secondPrice)) {
		$sNumber=$db->QueryFetchArray("SELECT * FROM `lottarybuy` WHERE lottaryNumber='$secondPrice' LIMIT 1");
	}else{
		$sNumber=$db->QueryFetchArray("SELECT * FROM `lottarybuy` ORDER BY RAND() LIMIT 1");
	}
	
}
// Third price
if (count($thirdpric)>0) {
	if (!empty($thirdPrice)) {
		$tNumber=$db->QueryFetchArray("SELECT * FROM `lottarybuy` WHERE lottaryNumber='$thirdPrice' LIMIT 1");
	}else{
		$tNumber=$db->QueryFetchArray("SELECT * FROM `lottarybuy` ORDER BY RAND() LIMIT 1");
	}	
}
// Fourth price
if (count($fourthpric)>0) {
	if (!empty($fourthPrice)) {
		$frNumber=$db->QueryFetchArray("SELECT * FROM `lottarybuy` WHERE lottaryNumber='$fourthPrice' LIMIT 1");
	}else{
		$frNumber=$db->QueryFetchArray("SELECT * FROM `lottarybuy` ORDER BY RAND() LIMIT 1");
	}	
}
// Fifth price
if (count($fifthpric)>0) {
	if (!empty($fifthPrice)) {
		$fvNumber=$db->QueryFetchArray("SELECT * FROM `lottarybuy` WHERE lottaryNumber='$fifthPrice' LIMIT 1");
	}else{
		$fvNumber=$db->QueryFetchArray("SELECT * FROM `lottarybuy` ORDER BY RAND() LIMIT 1");
	}	
}
// Sixth price
if (count($sixthpric)>0) {
	if (!empty($sixthPrice)) {
		$sxNumber=$db->QueryFetchArray("SELECT * FROM `lottarybuy` WHERE lottaryNumber='$sixthPrice' LIMIT 1");
	}else{
		$sxNumber=$db->QueryFetchArray("SELECT * FROM `lottarybuy` ORDER BY RAND() LIMIT 1");
	}	
}
// Seventh price
if (count($seventhpric)>0) {
	if (!empty($seventhPrice)) {
		$svNumber=$db->QueryFetchArray("SELECT * FROM `lottarybuy` WHERE lottaryNumber='$seventhPrice' LIMIT 1");
	}else{
		$svNumber=$db->QueryFetchArray("SELECT * FROM `lottarybuy` ORDER BY RAND() LIMIT 1");
	}	
}
// Eighth price
if (count($eighthpric)>0) {
	if (!empty($eighthPrice)) {
		$etNumber=$db->QueryFetchArray("SELECT * FROM `lottarybuy` WHERE lottaryNumber='$eighthPrice' LIMIT 1");
	}else{
		$etNumber=$db->QueryFetchArray("SELECT * FROM `lottarybuy` ORDER BY RAND() LIMIT 1");
	}	
}
// Ninnth price
if (count($ninthpric)>0) {
	if (!empty($ninthPrice)) {
		$nnNumber=$db->QueryFetchArray("SELECT * FROM `lottarybuy` WHERE lottaryNumber='$ninthPrice' LIMIT 1");
	}else{
		$nnNumber=$db->QueryFetchArray("SELECT * FROM `lottarybuy` ORDER BY RAND() LIMIT 1");
	}	
}

?>





<section id="content" class="container_12 clearfix ui-sortable">
<?php echo $message ;?>

<div class="grid_12">
<form action="" method="post" class="box">
			<div class="header">
				<h2>Add New Lottery</h2>
			</div>
			<div class="content">
				
			<?php 


			if(!empty($fNumber)){
			 ?>
				<div class="row">
					<label><strong><?php echo $fNumber['userename'] ?></strong></label>
					<div><input type="number" name="fprice" value="<?php echo $fNumber['lottaryNumber'] ?>" /></div>
				</div>
			<?php }
			
			if(!empty($sNumber)){
				?>
				   <div class="row">
					   <label><strong><?php echo $sNumber['userename'] ?></strong></label>
					   <div><input type="number" name="sprice" value="<?php echo $sNumber['lottaryNumber'] ?>" /></div>
				   </div>
			   <?php }
			if(!empty($tNumber)){
				?>
				   <div class="row">
					   <label><strong><?php echo $tNumber['userename'] ?></strong></label>
					   <div><input type="number" name="tprice" value="<?php echo $tNumber['lottaryNumber'] ?>" /></div>
				   </div>
			   <?php }
			if(!empty($frNumber)){
				?>
				   <div class="row">
					   <label><strong><?php echo $frNumber['userename'] ?></strong></label>
					   <div><input type="number" name="frprice" value="<?php echo $frNumber['lottaryNumber'] ?>" /></div>
				   </div>
			   <?php }
			if(!empty($fvNumber)){
				?>
				   <div class="row">
					   <label><strong><?php echo $fvNumber['userename'] ?></strong></label>
					   <div><input type="number" name="fvprice" value="<?php echo $fvNumber['lottaryNumber'] ?>" /></div>
				   </div>
			   <?php }
			if(!empty($sxNumber)){
				?>
				   <div class="row">
					   <label><strong><?php echo $sxNumber['userename'] ?></strong></label>
					   <div><input type="number" name="sxprice" value="<?php echo $sxNumber['lottaryNumber'] ?>" /></div>
				   </div>
			   <?php }
			if(!empty($svNumber)){
				?>
				   <div class="row">
					   <label><strong><?php echo $svNumber['userename'] ?></strong></label>
					   <div><input type="number" name="svprice" value="<?php echo $svNumber['lottaryNumber'] ?>" /></div>
				   </div>
			   <?php }
			if(!empty($etNumber)){
				?>
				   <div class="row">
					   <label><strong><?php echo $etNumber['userename'] ?></strong></label>
					   <div><input type="number" name="etprice" value="<?php echo $etNumber['lottaryNumber'] ?>" /></div>
				   </div>
			   <?php }
			if(!empty($nnNumber)){
				?>
				   <div class="row">
					   <label><strong><?php echo $nnNumber['userename'] ?></strong></label>
					   <div><input type="number" name="nnprice" value="<?php echo $nnNumber['lottaryNumber'] ?>" /></div>
				   </div>
			   <?php }		 
			 
			 
			 ?>
				
			</div>
			<div class="actions">
				<div class="right">
					<input type="submit" value="Done Winner" name="finalwinner" />
				</div>
			</div>
		</form>
</div>


</section>
<?php }else {?>

<section id="content" class="container_12 clearfix ui-sortable">

<div class="grid_12">
<h1 class="grid_12">Lottery Info</h1>
<div class="box">
<div class="full-stats flexiwidth">
	<div class="stat hlist"  data-flexiwidth="true">
		<ul>

			<li class="green" style="width: 25%;">
				<div class="value"><?php echo count($sell);?></div>
				<div class="title">Total Ticket Sell</div></li>

			<li style="width: 25%;"><div class="value">
				<?php echo $amount= count($sell)*$sst['price'];?>
			</div><div class="title">Sell Amount</div></li>


			<li style="width: 25%;"><div class="value">
				<?php $lt=$db->QueryFetchArrayAll("SELECT * FROM `lottary`"); $mainAmount="";	foreach ($lt as $l) { $mainAmount=$mainAmount+$l['pricevalue'];} echo $amount-$mainAmount;?>
			</div><div class="title">Profite</div></li>

			<li style="width: 25%;"><div class="value"><?php echo $usersell ?>
			</div><div class="title">Total Tiket Sell(Only for User)</div></li>

			<li style="width: 25%;"><div class="value">
				<?php echo $adminsell ?>
			</div><div class="title">Admin Profit (Ticket)</div></li>

		</ul>
	</div>
</div>
</div>
</div>


	<div class="grid_12">
 			<h1 class="grid_12">Lottery Wine</h1>
				<div class="box">
					<table class="styled">
						<thead>
							<tr>										
								<th>Price</th>								
								<th>Price Name</th>								
								<th>Price Value</th>								
								<th>time</th>							
							</tr>
						</thead>
						<tbody>
						<?php $idd=$data['id'];
						$lottarywin = $db->QueryFetchArrayAll("SELECT * FROM `lottary` ORDER BY id ASC");
						foreach($lottarywin as $win){?>	
							<tr>
								<td><?=$win['first_secon']?></td>
								<td><?=$win['price_name']?></td>
								<td><?=$win['pricevalue']?></td>
								<td><?=date("d-m-Y ",$win['time'])?></td>
							</tr>
							<?php }?>
						</tbody>
					</table>
		</div>
		<?php echo  $message; ?>
		<form action="" method="post" class="box">
			<div class="header">
				<h2>Add New Winner</h2>
			</div>
			<div class="content">				

				<div class="row">
					<label><strong>First Winer Number</strong></label>
					<div><input type="text" name="fprice" placeholder=" 123456 " /></div>
				</div>
				
				<div class="row">
					<label><strong>Second Winer Number</strong></label>
					<div><input type="text" name="sprice" placeholder=" 123456 " /></div>
				</div>
				<div class="row">
					<label><strong>Third Winer Number</strong></label>
					<div><input type="text" name="tprice" placeholder=" 123456 " /></div>
				</div>
				<div class="row">
					<label><strong>Fourth Winer Number</strong></label>
					<div><input type="text" name="frprice" placeholder=" 123456 " /></div>
				</div>
				<div class="row">
					<label><strong>Fifth Winer Number</strong></label>
					<div><input type="text" name="fvprice" placeholder=" 123456 " /></div>
				</div>
				<div class="row">
					<label><strong>Sixth Winer Number</strong></label>
					<div><input type="text" name="sxprice" placeholder=" 123456 " /></div>
				</div>
				<div class="row">
					<label><strong style="font-size:11px">Seventh Winer Number</strong></label>
					<div><input type="text" name="svprice" placeholder=" 123456 " /></div>
				</div>
				<div class="row">
					<label><strong>Eighth Winer Number</strong></label>
					<div><input type="text" name="etprice" placeholder=" 123456 " /></div>
				</div>
				<div class="row">
					<label><strong>Ninth Winer Number</strong></label>
					<div><input type="text" name="nnprice" placeholder=" 123456 " /></div>
				</div>
			</div>
			<div class="actions">
				<div class="right">
					<input type="submit" value="Submit" name="winner" />
				</div>
			</div>
		</form>
		
		
	</div>
</section>

<?php }?>