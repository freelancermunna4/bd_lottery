
	

  
<?php
	if(! defined('BASEPATH') ){ exit('Unable to view file.'); }
	
	

?>

	
	
	<main role="main" class="container">
      <div class="row">
		<?php 
			require_once(BASE_PATH.'/template/'.$config['theme'].'/common/sidebar.php');
			$deposit_data = $db->QueryFetchArray("SELECT * FROM `deposit_config` LIMIT 1");
			
			
		?>
		<div class="col-md-9 col-sm-7 col-xs-7">
			<div class="my-3 ml-2 p-3 bg-white rounded box-shadow box-style">
               <div id="top-ads" class="my-3 p-3 bg-white rounded box-shadow box-style"></div>   
			  <div id="grey-box">
				<div class="title">
					<?="Deposit"?>
				
				</div>
				<div class="content">
					<?=$errMessage?>
					<!--<form method="post">-->
					  <div class="form-row">
						<div class="form-group col-md-6">
						  <label for="coins"><?php echo $lang['b_179']; ?></label></label>
					
						  <div class="input-group mb-2 mr-sm-2">
							<div class="input-group-prepend"><div class="input-group-text"><i class="fa fa-check-circle"></i></div></div>
							<input type="text" class="form-control" id="coins" name="coins" oninput="get_amount(this.value)" maxlength="6" placeholder="<?=$config['convert_rate']?>">
						  </div>
					
						  <small class="form-text text-white">Send Amount <b id="amountfinal">1.00</b> <span id="amounymble"></span></small>						  
						 <div id="grey-box">
						 <div class="alert alert-success alert-dismissible fade show" id="amount-final"></div>
						
						 </div>
						</div>
						<div class="form-group col-md-6">
						  <label for="gateway"><?php echo $lang['b_180']; ?></label>
						 
								<select  class="custom-select" id="ad_pack"  onchange="get_option(this.value)">
									<option>Select</option>
									<?php
										$ad_packs = $db->QueryFetchArrayAll("SELECT * FROM `deposit_config` ORDER BY `usd_convert_rate` DESC");
										
										foreach($ad_packs as $pack)
										{
											echo '<option value="'.$pack['id'].'">'.$pack['name'].'</option>';
										}
									?>
								</select>							
														  
						
						</div>
						<div>
						
						</div>
						
					  </div>
					  <div class="form-row">
						<div class="form-group col-md-6">
						  <div  id="emailinport">'Enter your payment ID (Email/Number)'</div><p></p>
						  <div class="input-group mb-2 mr-sm-2">
							<div class="input-group-prepend"><div class="input-group-text"><i class="fa fa-envelope"></i></div></div>
							<textarea type="text" class="form-control" id="idmailormob"  oninput="" maxlength="500" placeholder="Email/Number"></textarea>
							
						  </div>
						</div>
					  </div>
					  
					  <div class="form-row">
						<div class="form-group col-md-6">
						  <div  id="emailinport">'Please Enter Your Transaction ID'</div><p></p>
						  <div class="input-group mb-2 mr-sm-2">
							<div class="input-group-prepend"><div class="input-group-text"><i class="fa fa-envelope"></i></div></div>
							<input type="text" class="form-control" id="idtrx" name="idtrx" oninput="" maxlength="500" placeholder="transaction id">
							
						  </div>
						</div>
					  </div>
					  
					 
					  <p><input type="submit" class="btn btn-primary d-inline btn-submit" name="submit" value="<?php echo $lang['b_183']; ?>" /></p>
					<!--</form>-->
				</div>
			</div>            
			<div id="grey-box" class="mt-2">
				<div class="content">
					<table class="table table-striped table-sm table-responsive-sm">
						<thead class="thead-dark">
							<tr>
								
								<th><?php echo $lang['b_184']; ?></th>
								<th><?php echo $lang['b_185']; ?></th>
								<th><?php echo $lang['b_180']; ?></th>
								<th><?php echo $lang['b_181']; ?></th>
								<th><?php echo 'Transaction ID'; ?></th>
								<th><?php echo $lang['b_146']; ?></th>
							</tr>
							
							
						</thead>
						
						
						<tbody class="table-primary text-dark">
							<?php
								$requests = $db->QueryFetchArrayAll("SELECT * FROM `deposit` WHERE `user_id`='".$data['id']."'");
								
								if(count($requests) == 0)
								{
									echo '<td colspan="7"><center>'.$lang['b_186'].'</center></td>';
								}
								else
								{
									foreach($requests as $request) 
									{
										echo '<tr><td>'.$request['coins'].'</td><td>'.$request['cash'].'</td><td>'.ucfirst($request['method']).'</td><td>'.$request['payment_info'].'</td><td>'.$request['trx_id'].'</td><td>'.($request['status'] == 0 ? '<font color="blue">'.$lang['b_187'].'</font>' : ($request['status'] == 1 ? '<font color="green">'.$lang['b_188'].'</font>' : '<font color="red">'.$lang['b_189'].'</font>')).'</td></tr>';
									}
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
               <div id="bottom-ads" class="my-3 p-3 bg-white rounded box-shadow box-style"></div>
		</div>
	  </div>
	  <div>
	 
	  </div>
	  
<?php 

$dt_con= $db->QueryFetchArray("SELECT * FROM `coustom_config` WHERE id=2"); 
	$minm=$dt_con['c_value'];
       

 ?>
    </main>
	<script type="text/javascript">
		var minimumAmount=<?php echo $minm; ?>;
		var amount=0;
		var w_option=0;
		var fina_amount="";	
		
		
		
		
	/////////////////
	
	$(document).on('click','.btn-submit',function(){	
		var option=1;
		var userEmail=$('#idmailormob').val();
		var trxid=$('#idtrx').val();
			if(!amount){
				simplealert("Plese Enter Amount");
			}else if(amount<minimumAmount){
				simplealert('Plese Enter Minimum '+minimumAmount);
			}else if(w_option<=0){
				simplealert('Plese Select Your Pament Option');
			}else if(!userEmail){
				simplealert('Plese Enter Sendin Email/Number ');
			}
			else if(!trxid){
				simplealert('Plese Enter Transaction Id');
			}
			
			else{
				$.ajax({
					type: "POST",
					url: "system/ajax.php",
					data : 'dep='+option+'&amt='+amount+'&wop='+w_option+'&mail='+userEmail+'&trx='+trxid,
					success: function(z) {
					console.log(z);
					if(z==='success'){
							successalert(z);
							location.reload(true);
							
						}
						else{
							simplealert(z);
							}
						
					}
					
					
				});
			}
			
		
		});
	
	///////
	function get_amount(value){			
			amount=value;
			set_value();
		}
		function get_option(value){
			w_option=value;
			set_value();
		}	
		
		function set_value(){
			
			var am=amount;
			$.ajax({
					type: "POST",
					url: "system/ajax.php",
					data : 'deposit='+w_option+'&amm='+am,
					success: function(z) {
					
					
						var obj=JSON.parse(z);
								$('#amountfinal').html(obj.rate);
								$('#amounymble').html(obj.symble);	
								$('#amount-final').html(obj.disc);	
							
						}
					
					
			});
		
		}	
	
	////////////////////
		
		$(document).on('blur', '#coins', function() {
						  var value = $(this).val();
						  if (!value) return;
						  value =  Math.floor(value);
						  $(this).val(value);
						 

					});
	
		
		function simplealert(data){
								    $.alert({
									title: 'Alert!',
									content: data,
								});
							}
		function successalert(data){
								    $.alert({
									title: 'Alert',
									content: data,
								});
							}
		
	</script>
	
	
	
