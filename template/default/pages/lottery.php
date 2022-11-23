<?php
	if(! defined('BASEPATH') ){ exit('Unable to view file.'); }


	$countries = $db->QueryFetchArrayAll("SELECT * FROM `list_countries` ORDER BY country");
	
	$lastwinner = $db->QueryFetchArrayAll("SELECT * FROM `last3winner`ORDER BY id ASC");
	
?>
	<main role="main" class="container">
      <div class="row">
		<?php 
			require_once(BASE_PATH.'/template/'.$config['theme'].'/common/sidebar.php');
			$lsetting = $db->QueryFetchArray("SELECT * FROM `lottery_setting` Limit 1");
			$fPricess = $db->QueryFetchArray("SELECT * FROM `lottary` WHERE first_secon='first' Limit 1");
			$sPricess = $db->QueryFetchArray("SELECT * FROM `lottary` WHERE first_secon='second' Limit 1");
			$tPricess = $db->QueryFetchArray("SELECT * FROM `lottary` WHERE first_secon='third' Limit 1");
			$frPricess = $db->QueryFetchArray("SELECT * FROM `lottary` WHERE first_secon='Fourth' Limit 1");
			$fvPricess = $db->QueryFetchArray("SELECT * FROM `lottary` WHERE first_secon='Fifth' Limit 1");
			$sxPricess = $db->QueryFetchArray("SELECT * FROM `lottary` WHERE first_secon='Sixth' Limit 1");
			$svPricess = $db->QueryFetchArray("SELECT * FROM `lottary` WHERE first_secon='Seventh' Limit 1");
			$etPricess = $db->QueryFetchArray("SELECT * FROM `lottary` WHERE first_secon='Eighth' Limit 1");
			$nnPricess = $db->QueryFetchArray("SELECT * FROM `lottary` WHERE first_secon='Ninth' Limit 1");
			//echo date("d-m-Y", 1388516401);
		?>
		
		
		<div class="col-md-9 col-sm-7 col-xs-7">

			<div class="my-3 ml-2 p-3 bg-white rounded box-shadow box-style"> 
                   <div id="top-ads" class="my-3 p-3 bg-white rounded box-shadow box-style"></div> 
				   
		<div class="main-div">

		<div class="videoContainer">
	
		</div>

	<!--	<audio id="myAudio" controls loop autoplay >
		<source src="static/img/win.mp3" type="audio/ogg">
		</audio> -->





	<div class="watingbox">								
		<div id="grey-box">
			<div class="content" style="height: 250px;background-image: url(&quot;static/img/lt.gif&quot;);">
			<h2  class="time00text">
				Waiting for Lottery Draw
			</h2>

			</div>
		</div>
	</div>	

	<div class="mainContainer">
	<div id="grey-box" >
				<div class="title">LOTTERY JECPOT</div>



					<!-- timer start -->
					<div class="container containertimercard">
					<div class="container-segment">						
						<div class="segment">
							<div class="flip-card" data-days-tens>
							<div class="top">0</div>
							<div class="bottom">0</div>
							</div>
							<div class="flip-card" data-days-ones>
							<div class="top">0</div>
							<div class="bottom">0</div>
							</div>
						</div>
						<div class="segment-title">Days</div>
						</div>

						<div class="container-segment">						
						<div class="segment">
							<div class="flip-card" data-hours-tens>
							<div class="top">0</div>
							<div class="bottom">0</div>
							</div>
							<div class="flip-card" data-hours-ones>
							<div class="top">0</div>
							<div class="bottom">0</div>
							</div>
						</div>
						<div class="segment-title">Hours</div>
						</div>
						<div class="container-segment">
						
						<div class="segment">
							<div class="flip-card" data-minutes-tens>
							<div class="top">0</div>
							<div class="bottom">0</div>
							</div>
							<div class="flip-card" data-minutes-ones>
							<div class="top">0</div>
							<div class="bottom">0</div>
							</div>							
						</div>
						<div class="segment-title">Minutes</div>
						</div>
						<div class="container-segment">						
						<div class="segment">
							<div class="flip-card" data-seconds-tens>
							<div class="top">0</div>
							<div class="bottom">0</div>
							</div>
							<div class="flip-card" data-seconds-ones>
							<div class="top">0</div>
							<div class="bottom">0</div>
							</div>
							
						</div>
						<div class="segment-title">Seconds</div>
						</div>
						
					</div>
					<br>
					<!-- end timer-->

















			<div  class="content" style="margin-top: -22px;">

				
				<div class="winner_block">	
					<div style="background: #fff;">			
						<div class="inside" style="background-image: url('https://bdlottery.net/template/default/static/images/<?php 
						if(count($fPricess)>0){
							echo $fPricess['img'];
						}
						else{
							echo "noimage.png";
						}
						?>');background-repeat: no-repeat; color: #FFFFFF; height: 125px;">
								<div class="ribbon-green"><i class="fa fa-gift fa-2x"></i></div>
								<p class="winner text-left" >First Price</p>
							</div>
							<p class="text-center" style="color: #000;font-size: 16px;margin-top: -10px;padding-bottom: 10px;"><?php echo $fPricess['price_name']; ?></p>
						</div>
					</div>						

					<div class="winner_block">
					<div style="background: #fff;">	
						<div class="inside" style="background-image:  url('https://bdlottery.net/template/default/static/images/<?php
						if(count($sPricess)>0){
							echo $sPricess['img'];
						}
						else{
							echo "noimage.png";
						}
						 ?>');background-repeat: no-repeat; color: #FFFFFF;  height: 125px;">
							<div class="ribbon-green"><i class="fa fa-gift fa-2x"></i></div>
							<p class="winner text-left">Second Price</p>
						</div>
						<p class="text-center" style="color: #000;font-size: 16px;margin-top: -10px;padding-bottom: 10px;"><?php echo $sPricess['price_name']; ?></p>
					</div>
					</div>



			<!-- -------------block---------------->
			<div class="winner_block" >
				<div style="background: #fff;">	
					<div class="inside" style="background-image:  url('https://bdlottery.net/template/default/static/images/<?php 
					if(count($tPricess)>0){
						echo $tPricess['img'];
					}
					else{
						echo "noimage.png";
					}
					?>');background-repeat: no-repeat; color: #FFFFFF;  height: 125px;">
							<div class="ribbon-green"><i class="fa fa-gift fa-2x"></i></div>
							<p class="winner text-left">Third Price</p>
						</div>
						<p class="text-center" style="color: #000;font-size: 16px;margin-top: -10px;padding-bottom: 10px;"><?php echo $tPricess['price_name']; ?></p>
				</div>
			</div>
			<!-- -------------block---------------->
			<div class="winner_block" >
				<div style="background: #fff;">	
					<div class="inside" style="background-image:  url('https://bdlottery.net/template/default/static/images/<?php 
					if(count($frPricess)>0){
						echo $frPricess['img'];
					}
					else{
						echo "noimage.png";
					}
					?>');background-repeat: no-repeat; color: #FFFFFF;  height: 125px;">
							<div class="ribbon-green"><i class="fa fa-gift fa-2x"></i></div>
							<p class="winner text-left">Fourth Price</p>
						</div>
						<p class="text-center" style="color: #000;font-size: 16px;margin-top: -10px;padding-bottom: 10px;"><?php echo $frPricess['price_name']; ?></p>
				</div>
			</div>
			<!-- -------------block---------------->
			<div class="winner_block" >
				<div style="background: #fff;">	
					<div class="inside" style="background-image:  url('https://bdlottery.net/template/default/static/images/<?php 
					if(count($fvPricess)>0){
						echo $fvPricess['img'];
					}
					else{
						echo "noimage.png";
					}
					?>');background-repeat: no-repeat; color: #FFFFFF;  height: 125px;">
							<div class="ribbon-green"><i class="fa fa-gift fa-2x"></i></div>
							<p class="winner text-left">Fifth Price</p>
						</div>
						<p class="text-center" style="color: #000;font-size: 16px;margin-top: -10px;padding-bottom: 10px;"><?php echo $fvPricess['price_name']; ?></p>
				</div>
			</div>
			<!-- -------------block---------------->
			<div class="winner_block" >
				<div style="background: #fff;">	
					<div class="inside" style="background-image:  url('https://bdlottery.net/template/default/static/images/<?php 
					if(count($sxPricess)>0){
						echo $sxPricess['img'];
					}
					else{
						echo "noimage.png";
					}
					?>');background-repeat: no-repeat; color: #FFFFFF;  height: 125px;">
							<div class="ribbon-green"><i class="fa fa-gift fa-2x"></i></div>
							<p class="winner text-left">Sixth Price</p>
						</div>
						<p class="text-center" style="color: #000;font-size: 16px;margin-top: -10px;padding-bottom: 10px;"><?php echo $sxPricess['price_name']; ?></p>
				</div>
			</div>
			<!-- -------------block---------------->
			<div class="winner_block" >
				<div style="background: #fff;">	
					<div class="inside" style="background-image:  url('https://bdlottery.net/template/default/static/images/<?php 
					if(count($svPricess)>0){
						echo $svPricess['img'];
					}
					else{
						echo "noimage.png";
					}
					?>');background-repeat: no-repeat; color: #FFFFFF;  height: 125px;">
							<div class="ribbon-green"><i class="fa fa-gift fa-2x"></i></div>
							<p class="winner text-left">Seventh Price</p>
						</div>
						<p class="text-center" style="color: #000;font-size: 16px;margin-top: -10px;padding-bottom: 10px;"><?php echo $svPricess['price_name']; ?></p>
				</div>
			</div>
			<!-- -------------block---------------->
			<div class="winner_block" >
				<div style="background: #fff;">	
					<div class="inside" style="background-image:  url('https://bdlottery.net/template/default/static/images/<?php 
					if(count($etPricess)>0){
						echo $etPricess['img'];
					}
					else{
						echo "noimage.png";
					}
					?>');background-repeat: no-repeat; color: #FFFFFF;  height: 125px;">
							<div class="ribbon-green"><i class="fa fa-gift fa-2x"></i></div>
							<p class="winner text-left">Eighth Price</p>
						</div>
						<p class="text-center" style="color: #000;font-size: 16px;margin-top: -10px;padding-bottom: 10px;"><?php echo $etPricess['price_name']; ?></p>
				</div>
			</div>
			<!-- -------------block---------------->
			<div class="winner_block" >
				<div style="background: #fff;">	
					<div class="inside" style="background-image:  url('https://bdlottery.net/template/default/static/images/<?php 
					if(count($nnPricess)>0){
						echo $nnPricess['img'];
					}
					else{
						echo "noimage.png";
					}
					?>');background-repeat: no-repeat; color: #FFFFFF;  height: 125px;">
							<div class="ribbon-green"><i class="fa fa-gift fa-2x"></i></div>
							<p class="winner text-left">Ninth Price</p>
						</div>
						<p class="text-center" style="color: #000;font-size: 16px;margin-top: -10px;padding-bottom: 10px;"><?php echo $nnPricess['price_name']; ?></p>
				</div>
			</div>


		</div>

				
<!-- ============== -->

		
				
		<div class="container">	
					<center>
						<div class="float-left">
							<div id="loterry_stats_header">Lottery Prize</div>
							<div id="loterry_stats"><i class="fa fa-check-circle fa-fw"></i>	
							<?php 
							echo $lsetting['price'];
							?>Coins</div>
							<div id="loterry_stats_header" style="border-radius: 5px;width: 100%;margin-top: -5px;">							
							<?php   
									$sell=$db->QueryFetchArrayAll("SELECT * FROM `lottarybuy` ORDER BY id ASC");
									$sst=$db->QueryFetchArray("SELECT * FROM `lottery_setting`");
									$lt=$db->QueryFetchArrayAll("SELECT * FROM `lottary`");
									$mainAmount="";	
									foreach ($lt as $l) {
										$mainAmount=$mainAmount+$l['pricevalue'];
									}		
									
									$x = $sst['adminpercent'];
									$y =count($sell)/100;
									$d=100-$x;
									$usersell=($y*$d);
									$adminsell=($y*$x);
								echo "Admin Profit: ";
								echo ($usersell*$sst['price'])-$mainAmount
							?>
						
						
						
						
						
						</div>
						</div>

						<div class="float-right">
						
							<div id="loterry_stats_header">Sold Tickets</div>
							<div id="loterry_stats"><i class="fa fa-ticket fa-fw"></i> 
							<?php   
							
							echo $usersell;
							?>
							 tickets</div>


							 <div id="loterry_stats_header" style="border-radius: 5px;width: 100%;margin-top: -5px;">
							 <?php   
							
								$ltbuy=$db->QueryFetchArray("SELECT * FROM `lottery_setting`");
								$s=$ltbuy['price'];
								$mainAmount="";	
									foreach ($lt as $l) {
										$mainAmount=$mainAmount+$l['pricevalue'];
									}	
								echo "Require: ".$mainAmount/$s." Tickets";
							?>
							
							</div>
						</div>
						
				</center>
				</div>
					
					<div method="post" class="gen_but_yellow" style="margin-top: 85px;">
						<input type="submit" class="buy_ticket" value="Buy a Ticket">
					</div>
					<br>
			</div>												
		</div>


		</div>	
	


			<?php 
			$uid=$data['id'];
			$mytiket = $db->QueryFetchArrayAll("SELECT * FROM `lottarybuy` WHERE userid=$uid ORDER BY id DESC");
			$mywin = $db->QueryFetchArrayAll("SELECT * FROM `lottary_winner` WHERE userid=$uid ORDER BY id DESC");
			$luckywinner = $db->QueryFetchArrayAll("SELECT * FROM `lottary_winner`ORDER BY id ASC LIMIT 25");

			
			
		
			?>
			
				<div class="my-3 ml-2 p-3 bg-white rounded box-shadow box-style">
				<div id="grey-box">			
				<div class="btn-group justify-content-center" style="display: block !important;margin-left: 7px;padding-top: 5px;">					
						<button class="btn btn-success " onclick="openCity('London')"  style="margin: 2px;">My Ticket (<?php echo count($mytiket);?>)</button>
						<button class="btn btn-success" onclick="openCity('Paris')" style="margin: 2px;">My Winnings</button>
						<button class="btn btn-success" onclick="openCity('Tokyo')" style="margin: 2px;">Lucky Winners</button>
						<button class="btn btn-success" onclick="openCity('Last')" style="margin: 2px;">Last Price Winners</button>
					</div>
				
			<div id="London" class="w3-container city">				
					<div class="content">					
						<div class="form-row">					
							<table class="table table-striped table-sm table-responsive-sm">						
							<thead class="thead-dark">
								<tr>								
									<th>Lottery Number</th>
									<th>Time</th>		
								</tr>
							</thead>
							<tbody class="table-primary text-dark">
								<?php									
									if(count($mytiket) == 0)
									{	
										echo '<tr><td colspan="5"><center>No Tickets</center></td></tr>';
									}
									else
									{
										foreach($mytiket as $request) 									
										{
											echo '<tr><td>'.$request['lottaryNumber'].'</td>
											<td>'.date("d-m-Y", $request['tim']).'</td>
											</tr>';
								
										}
									}
									
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

		<div id="Paris" class="w3-container city" style="display:none">
				
						<div class="content">					
							<div class="form-row">					
								<table class="table table-striped table-sm table-responsive-sm">						
								<thead class="thead-dark">
									<tr>								
										<th>Lottery Number</th>
										<th>Price Name</th>
										<th>Price</th>
										<th>Time</th>		
									</tr>
								</thead>
								<tbody class="table-primary text-dark">
									<?php									
										if(count($mywin) == 0)
										{	
											echo '<tr><td colspan="5"><center>No Tickets</center></td></tr>';
										}
										else
										{
											foreach($mywin as $request) 									
											{
												echo '<tr><td>'.$request['number'].'</td>
												<td>'.$request['priceName'].'</td>
												<td>'.$request['price'].'</td>
												<td>'.date("d-m-Y", $request['tim']).'</td>
												</tr>';
									
											}
										}
										
									?>
								</tbody>
							</table>
						</div>
					</div>
		</div>

		<div id="Tokyo" class="w3-container city" style="display:none">
		<div class="content">					
							<div class="form-row">					
								<table class="table table-striped table-sm table-responsive-sm">						
								<thead class="thead-dark">
									<tr>								
										<th>User Name</th>
										<th>Price Name</th>
										<th>Price</th>
										<th>Lottery Number</th>
										<th>Time</th>		
									</tr>
								</thead>
								<tbody class="table-primary text-dark">
									<?php									
										if(count($luckywinner) == 0)
										{	
											echo '<tr><td colspan="5"><center>No Tickets</center></td></tr>';
										}
										else
										{
											foreach($luckywinner as $request) 									
											{
												echo '<tr>
												<td>'.$request['username'].'</td>
												<td>'.$request['priceName'].'</td>
												<td>'.$request['price'].'</td>
												<td>'.$request['number'].'</td>
												<td>'.date("d-m-Y", $request['tim']).'</td>
												</tr>';
									
											}
										}
										
									?>
								</tbody>
							</table>
						</div>
					</div>
		</div>

		<div id="Last" class="w3-container city" style="display:none">
		<div class="content">					
							<div class="form-row">					
								<table class="table table-striped table-sm table-responsive-sm">						
								<thead class="thead-dark">
									<tr>								
										<th>User Name</th>
										<th>Price</th>
										<th>Price Name</th>									
										<th>Lottery Number</th>
										<th>Time</th>		
									</tr>
								</thead>
								<tbody class="table-primary text-dark">
									<?php									
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
										
									?>
								</tbody>
							</table>
						</div>
					</div>
		</div>


					<script>
						function openCity(cityName) {
						var i;
						var x = document.getElementsByClassName("city");
						for (i = 0; i < x.length; i++) {
							x[i].style.display = "none";  
						}
						document.getElementById(cityName).style.display = "block";  
						}
					</script>
			 
			
<div class="modal fade text-center show modalticket" id="login_box" style=" background: #606060c7; padding-right: 17px; display: block;">
	  <div class="modal-dialog modal-dialog-centered">
		<div class="col-lg-8 col-sm-8 col-12 main-section">
		  <div class="modal-content">
			
			<div class="col-lg-12 col-sm-12 col-12 user-name">
			<h1 class="buyinfo" style="color: #3ddcf7;">Buy Lottery Tickets</h1>
			  <button type="button" class="close" data-dismiss="modal">×</button>
			</div>
			<div class="col-lg-12 col-sm-12 col-12 form-input">
			  <div >
					<input type="hidden" name="token" class="token" value="214cce652ec4b74293ae61cc505f3afd">
				
				<div class="form-group"  style="padding-left: 25px;padding-right: 25px;">
				<p style="color: #01f3ff;">Number of tickets</p>
					<div class="input-group mb-2 mr-sm-2">
							
					<span type="submit" name="connect" class="btn btn-primary btn-dec">-</span>					
						<input onkeyup="inputtack(this.value)" type="number" class="form-control tic-amount" placeholder="1" required="">
						<span type="submit" name="connect" class="btn btn-primary btn-inc">+</span>	
					</div>
				</div>
				<div class="form-group text-left">	
				<div class="col text-center">			 
				<button type="submit" name="connect" class="btn btn-success btnbuy" style="width: 150px;">Buy</button>
				</div>
			</div>
			</div>
			
		  </div>
		</div>
	  </div>
	</div>
						<div class="form-row">	
					</div>			
				</div>
			</div>
			
									
			
				
			</div>
		  </div>
		  </div>

		  
           <div id="bottom-ads" class="my-3 p-3 bg-white rounded box-shadow box-style"></div>      
		</div>
		</div>		
	  </div>
</main>


<script type="text/javascript"> 
		var ticket=1;
		var winnerss=false;
		var shawWinner=true;
$(".hidfordraw").css("visibility", "hidden");		
$(".showfordraw").css("visibility", "hidden");		

		$('.modalticket').hide();
		$('.close').click(()=>{
			$('.modalticket').hide();
		});
		
		//bt
		$('.btn-dec').click(()=>{
			if(ticket>1){
				ticket--;
			}else{
				ticket=1;
			}
			inputshaw(ticket);
		});

		$('.btn-inc').click(()=>{
			ticket++;
			inputshaw(ticket);
		});
		//bt



function inputtack(params) {
	ticket=params;
	inputshaw(ticket);
	
}

function inputshaw(params) {
	if (ticket<1) {
		ticket=1;
	}
	$('.tic-amount').val(Math.floor(ticket));
	
}

$('.btnbuy').click(()=>{
			var lottaryid=$('.token').val();
			$('.btnbuy').hide();
			$.ajax({
								type: "POST",
								url: "system/ajax.php",
								data : 'lottaryid='+lottaryid+'&ticket='+ticket,
								success: function(z) {
										if(z.trim()==="success"){
											$('.buyinfo').html("Successfully Buy Ticket"); 
											$(".buyinfo").css("color", "blue");											
											locationReload();
										}else{
											$('.buyinfo').html(z);
											$(".buyinfo").css("color", "red");
											$('.btnbuy').show();		
										}
										
									}
									
							});
			
});
		
		$(document).on('click','.buy_ticket',function(){
			console.log("cliked");
		    $('.modalticket').show();			
			
			});

	
					
						
					function locationReload(){
						setTimeout(function() { 
							location.reload(true);
						}, 1000);
							
						}
					
					
						
						function simplealert(data){
								    $.alert({
									title: 'Alert!',
									content: data,
								});
							}

							

// timer   sss


const countToDate =<?php echo $lsetting['withdrawtime']; ?> 
let previousTimeBetweenDates;
let tempdate=<?php echo time(); ?>;
var currentDate =<?php echo time(); ?> 
setInterval(() => {

  currentDate++;
  const timeBetweenDates = Math.ceil((countToDate - currentDate));
  console.log(timeBetweenDates);
  if (timeBetweenDates>-1) {

	flipAllCards(timeBetweenDates)
  previousTimeBetweenDates = timeBetweenDates
  }else{
	
		winnerss=true;
		
	
	
  }
 
}, 1000)

function flipAllCards(time) {
  const seconds = time % 60
  const minutes = Math.floor(time / 60) % 60
  const hours = Math.floor(time / 3600)%24
  const days = Math.floor(time / 86400)
  
  flip(document.querySelector("[data-days-tens]"), Math.floor(days / 10))
  flip(document.querySelector("[data-days-ones]"), days % 10)
  flip(document.querySelector("[data-hours-tens]"), Math.floor(hours / 10))
  flip(document.querySelector("[data-hours-ones]"), hours % 10)
  flip(document.querySelector("[data-minutes-tens]"), Math.floor(minutes / 10))
  flip(document.querySelector("[data-minutes-ones]"), minutes % 10)
  flip(document.querySelector("[data-seconds-tens]"), Math.floor(seconds / 10))
  flip(document.querySelector("[data-seconds-ones]"), seconds % 10)
}

function flip(flipCard, newNumber) {
  const topHalf = flipCard.querySelector(".top")
  const startNumber = parseInt(topHalf.textContent)
  if (newNumber === startNumber) return

  const bottomHalf = flipCard.querySelector(".bottom")
  const topFlip = document.createElement("div")
  topFlip.classList.add("top-flip")
  const bottomFlip = document.createElement("div")
  bottomFlip.classList.add("bottom-flip")

  top.textContent = startNumber
  bottomHalf.textContent = startNumber
  topFlip.textContent = startNumber
  bottomFlip.textContent = newNumber

  topFlip.addEventListener("animationstart", e => {
    topHalf.textContent = newNumber
  })
  topFlip.addEventListener("animationend", e => {
    topFlip.remove()
  })
  bottomFlip.addEventListener("animationend", e => {
    bottomHalf.textContent = newNumber
    bottomFlip.remove()
  })
  flipCard.append(topFlip, bottomFlip)
}




setInterval(() => {
	
	if(winnerss){
		console.log("timeBetweenDates");
		getWinner();
	}


}, 1000)





function getWinner() {
				var winner="winner";
				var all="all";

		var videodata="";		
				$.ajax({				
					type: "POST",
					url: "system/ajax.php",
					data : 'winner='+winner+'&all='+all,
						success: function(z) {
								if(z.trim()==="1"){
									if(previousTimeBetweenDates>0){
										$('.watingbox').hide();	
										$('.videoContainer').hide();
										$('.mainContainer').show();	

									}else{
										$('.videoContainer').hide();
										$('.mainContainer').hide();							
										$('.watingbox').show();	
									}
								}
								else{
									winnerss=false;
									if(shawWinner){
										$('.watingbox').hide();	
										$('.mainContainer').hide();	
										$('.videoContainer').show();
										$('.videoContainer').html(z);										
										shawWinner=false;
									}
									
								
								}		
							}
									
		});

		
	
}





</script>
