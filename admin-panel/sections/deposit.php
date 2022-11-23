<?php
	if(! defined('BASEPATH') ){ exit('Unable to view file.'); }

	$message = '';
	if(isset($_GET['del']) && is_numeric($_GET['del']))
	{
		$del = $db->EscapeString($_GET['del']); 
		$db->Query("DELETE FROM `deposit_config` WHERE `id`='".$del."'");
	}
	elseif(isset($_GET['edit']))
	{
		$edit = $db->EscapeString($_GET['edit']);
		$pack = $db->QueryFetchArray("SELECT * FROM `deposit_config` WHERE `id`='".$edit."'");
		if(isset($_POST['submit']))
		{
			$name = $db->EscapeString($_POST['name']);
			$curency = $db->EscapeString($_POST['curency']);
			$discription = $db->EscapeString($_POST['discription']);

			$db->Query("UPDATE `deposit_config` SET `name`='".$name."', `curency`='".$curency."', `payment_discription`='".$discription."' WHERE `id`='".$edit."'");
			$message = '<div class="alert success"><span class="icon"></span><strong>Success!</strong> Coins pack was successfully edited!</div>';
            
          
		}
	}

	if(isset($_GET['edit']) && !empty($pack['id'])){
?>
<section id="content" class="container_12 clearfix"><?=$message?>
	<div class="grid_12">
		<form action="" method="post" class="box">
			<div class="header">
				<h2>Edit Bank</h2>
			</div>
			<div class="content">
				<div class="row">
					<label><strong>Pack Name</strong></label>
					<div><input type="text" name="name" value="<?=(isset($_POST['name']) ? $_POST['name'] : $pack['name'])?>" required="required" /></div>
				</div>
				<div class="row">
					<label><strong>Curency Symble</strong></label>
					<div><input type="text" name="curency" value="<?=(isset($_POST['curency']) ? $_POST['curency'] : $pack['curency'])?>" required="required" /></div>
				</div>				
				<div class="row">
					<label><strong>Bank Info</strong></label>
					<div><input type="text" name="discription" value="<?=(isset($_POST['discription']) ? $_POST['discription'] : $pack['payment_discription'])?>" required="required" /></div>
				</div>
			</div>
			<div class="actions">
				<div class="right">
					<input type="submit" name="submit" value="Submit" />
				</div>
			</div>
        </form>
	</div>
</section>
<?php
	}
	else
	{
		if(isset($_POST['add_pack']))
		{
			$name = $db->EscapeString($_POST['name']);
			$curency = $db->EscapeString($_POST['curency']);
			$discription = $db->EscapeString($_POST['discription']);

			if($name != '' && $curency !=''&& $discription !=''){
				$db->Query("INSERT INTO `deposit_config` (name, curency, payment_discription) VALUES('".$name."', '".$curency."', '".$discription."')");
				$message = '<div class="alert success"><span class="icon"></span><strong>Success!</strong> Coins pack was successfuly added!</div>';
			}else{
				$message = '<div class="alert error"><span class="icon"></span><strong>Error!</strong> You have to complete all fields!</div>';
			}
		}
?>
<section id="content" class="container_12 clearfix ui-sortable"><?=$message?>
	<h1 class="grid_12">All Deposit Bank Accaunt</h1>
	<div class="grid_8">
		<div class="box">
			<table class="styled">
				<thead>
					<tr>
						<th width="25">ID</th>
						<th>Bank Name</th>
						<th>Curency</th>
						<th>Bank ID & Discription</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
<?php
	$packs = $db->QueryFetchArrayAll("SELECT * FROM `deposit_config` ORDER BY `id` ASC");
	foreach($packs as $pack){
?>	
					<tr>
						<td><?=$pack['id']?></td>
						<td><?=$pack['name']?></td>
						<td><?=$pack['curency']?></td>
						<td><?=$pack['payment_discription']?></td>
						<td class="center">
							<a href="index.php?x=deposit&edit=<?=$pack['id']?>" class="button small grey tooltip" data-gravity=s title="Edit"><i class="icon-pencil"></i></a>
							<a href="index.php?x=deposit&del=<?=$pack['id']?>" class="button small grey tooltip" data-gravity=s title="Remove"><i class="icon-remove"></i></a>
						</td>
					 </tr>
<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="grid_4">
		<form method="post" class="box">
			<div class="header">
				<h2>Add New Bank</h2>
			</div>
			<div class="content">
				<div class="row">
					<label for="v1_charrange"><strong>Bank Name</strong></label>
					<div><input type="text" name="name" placeholder="Paypal" required="required" /></div>
				</div>
				<div class="row">
					<label for="v1_charrange"><strong>Curency Symble</strong></label>
					<div><input type="text" name="curency" placeholder="USD" required="required" /></div>
				</div>
				
				<div class="row">
					<label for="v1_charrange"><strong>Bank Info</strong></label>
					<div><input type="text" name="discription" placeholder="Bank Info" required="required" /></div>
				</div>
			</div>
			<div class="actions">
				<div class="right">
					<input type="submit" name="add_pack" value="Submit" />
				</div>
			</div>
        </form>
	</div>
</section>
<?php } ?>