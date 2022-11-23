<?php
	if(! defined('BASEPATH') ){ exit('Unable to view file.'); }
?>
	
	<div class="clearfix"></div>
	<footer class="footer mt-3">
		<nav class="navbar static-bottom navbar-expand-sm navbar-dark bg-dark">
		 <div class="container">
		  <span class="navbar-brand copyright"><span>&#169;</span><?php echo $config['site_name']; ?>.com</span>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#footer_collapse" aria-controls="footer_collapse" aria-expanded="false">
			<span class="navbar-toggler-icon"></span>
		  </button>
		  
		 </div>
		</nav>
	</footer>

	
	
<?php
	if(!empty($config['analytics_id'])) {
?>
	
<?php } ?>
	
  </body>


<script>
  $('#top-ads').hide();   
  $('#bottom-ads').hide();  
  $('#side-ads').hide();  
    
    
 $( document ).ready(function() {
    topads(); 
  bottomads();
  sideads();
});   
    
    
  

//var sideads=$('#bottom-ads');
var ads=ads;
 
 //////////////////   
 function topads(){
      $.ajax({
        type: "POST",
        url: "system/ajax.php",
        data : 'ads='+ads+'&sizet='+1,
            
        success: function(z) {
                if(z!='0'){
                    $('#top-ads').show(); 
                    $('#top-ads').html(z);
                }
               
            }
              
  }) 
 }   
 /////////////// 
  function bottomads(){
      $.ajax({
        type: "POST",
        url: "system/ajax.php",
        data : 'ads='+ads+'&sizeb='+2,
            
        success: function(z) {
                if(z!='0'){
                    $('#bottom-ads').show(); 
                    $('#bottom-ads').html(z); 
                }
               
            }
              
  }) 
 }   
 ///////////////side-ads  
    
    function sideads(){
      $.ajax({
        type: "POST",
        url: "system/ajax.php",
        data : 'ads='+ads+'&side='+3,
            
        success: function(z) {
                if(z!='0'){
                     $('#side-ads').show(); 
                    $('#side-ads').html(z);
                    
                   
                }
               
            }
              
  }) 
 }    
    

</script>



</html>