<?php
	if(! defined('BASEPATH') ){ exit('Unable to view file.'); }

	$countries = $db->QueryFetchArrayAll("SELECT * FROM `list_countries` ORDER BY country");

	
?>
	<main role="main" class="container">
      <div class="row">
		<?php 
			require_once(BASE_PATH.'/template/'.$config['theme'].'/common/sidebar.php');
		?>
		
		
		<div class="col-md-9 col-sm-7 col-xs-7">
			<div class="my-3 ml-2 p-3 bg-white rounded box-shadow box-style">
                   <div id="top-ads" class="my-3 p-3 bg-white rounded box-shadow box-style"></div>   
			  <div id="grey-box">
				<div class="title">Lucky Coupon</div>
				<div class="content">
				
					<div id="error-handle">
						</div>
						<div class="form-row">	
						
							
							
							<div class="form-group col-md-6">
							  <label for="ad_visits"> Cupon Code</label>
							  <input  type="text" class="form-control"  id="coupon" maxlength="30" placeholder="CH5I88Le6" />
							</div>
						
					 		<div class="form-group col-md-6 .a">
							  <label for="ad_visits">Enter Your Recharge Mobile No</label>
							  <input  type="text" class="form-control"  id="mobileno" maxlength="30" placeholder="your Phone No" />
							</div>
							
							
						
						</div>
							
						<div class="form-row">	
							<text type="text" class=" text-white text-center"></text><br>
							 <button type="button" class="btn btn-success w-100 btnsubmit" id="ad_visits" > Submit </button>
						</div>
					</div>	
														
				</div>
			<br>
			
				<div class="my-3 ml-2 p-3 bg-white rounded box-shadow box-style">
			  <div id="grey-box">
				<div class="title">	Lucky Winners</div>
				<div class="content">
					
					<div class="form-row">	
					
						<table class="table table-striped table-sm table-responsive-sm">
						
						<thead class="thead-dark">
							<tr>
								
								<th>User Name</th>
								<th>Mobile No</th>								
								<th>Cupon Code</th>	
							</tr>
						</thead>
						<tbody class="table-primary text-dark">
							<?php
								$uid=$data['id'];
								$jobs = $db->QueryFetchArrayAll("SELECT * FROM `luckyCupon` ORDER By id DESC LIMIT 5");
								
								if(count($jobs) == 0)
								{
								 
                                
									echo '<tr><td colspan="5"><center>No Winner Todays</center></td></tr>';
								}
								else
								{
									foreach($jobs as $request) 									
									{
										 $lastTwoNumbers = substr($request['phonNo'], -2);
									 $finalnumber='**********'.$lastTwoNumbers;
									
										echo '<tr><td>'.$request['useeName'].'</td>
										<td>'.$finalnumber.'</td>
										<td>'.$request['CuponCode'].'</td>
										</tr>';
							
									}
								}
								
								
								
							
								
								
								
								
							?>
						</tbody>
					</table>
					
						<div class="form-row">	
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
		
		
		$(document).on('click','.btnsubmit',function(){
		    
				    	$('.btnsubmit').hide();
						var coupon= $('#coupon').val();
						var mobileno= $('#mobileno').val();						
					
						if(!coupon){
							 simplealert("Please Enter Coupon Code!");	
							 $('.btnsubmit').show();
						}
						else if(!mobileno){
							 simplealert("Please Enter Mobile No!");
							 $('.btnsubmit').show();
						}
						else{
							$.ajax({
								type: "POST",
								url: "system/ajax.php",
								data : 'coupon='+coupon+'&mobileno='+mobileno,
								success: function(z) {
										if(z=='success'){
												simplealert("success");
												setTimeout(locationReload, 2000);
												
										}
										else{
											$('.btnsubmit').show();
											simplealert(z);
										}		
									}
									
							});
						}	
			})
					
					
						
					function locationReload(){
							location.reload(true);
						}
					
					
						
						function simplealert(data){
								    $.alert({
									title: 'Alert!',
									content: data,
								});
							}
		
				
			</script>
