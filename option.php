<?php
	session_start();
	include('processes/process.php');
	$connect = connectDB();

$result=viewTime($connect);
$result1=viewMode($connect);
$result2=viewGrade($connect);
$result3=viewStatus($connect);

if($_SESSION['access_control']<2){
	header('Location: index.php');
}

if(isset($_POST['changeyear'])){
		extract($_POST);
	changeyear($connect, $from, $to);

}

if(isset($_GET['id'])){
	$delTime=delTime($connect, $_GET['id']);
	

	if($delTime){
		echo "Deleted!";
	}
	else{

		echo "Not working!";
	}
}
$getCurrentSY=mysqli_fetch_assoc(getCurrentSY($connect));

if(isset($_POST['setpenalty'])){
	extract($_POST);
	updatePenaltyValue($connect, $penalty);
}



	$header="Options";
	$header2="Other Stuffs";	

	include('header.php');
?>

<head>
	<title>Options</title>
</head>


<div style="position: relative;width: 80%;bottom: -2%; left: 16%;">


</br>
	
	
</br>
		<h5 style="font-weight:bold;">User Accounts</h5>
<h6>Click on a user edit it. Or click "Add User" to add new account</h6>
	<?php
$getUsers=getUsers($connect);
?>

<table>
	<thead>
		<tr>
			<th>Name</th>
			<th>Username</th>
			<th>Access Control</th>
		</tr>
	<thead>
	<?php while($row=mysqli_fetch_assoc($getUsers)){ ?>
	<tr class="clickablerow" href="edituser.php?id=<?=$row['user_id']?>">
		<td><?=$row['first_name']." ".$row['last_name']?></td>
		<td><?=$row['username']?></td>
		<td><?php if($row['access_control']==1) echo "Regular User"; else echo "Administrator"; ?></td>
	</tr>
	<?php } ?> 
	<tr class="clickablerow" href="adduser.php"/>
		<td>Add User</td>
		<td></td>
		<td></td>
</table>
</br>

  <ul class="collapsible" data-collapsible="accordion">
    <li>
      <div class="collapsible-header" style="font-weight:bold;"><i class="mdi-image-filter-drama"></i>
	Current School Year</div>
      <div class="collapsible-body" style=""><p style="">		Change the current school year by selecting from and to. The click save </p>
	<form method="POST" class="row">
<div class="row">
		<p class="blue-text lighten-2" style="font-weight:bold;">From:</p>
		<div style="width:150px;">

	   		<select name="from" value="<?=$getCurrentSY['from']?>">
	    		<?php $getSchoolYears = getSchoolYears($connect);
	    			while($row=mysqli_fetch_array($getSchoolYears, MYSQLI_ASSOC)){
	    				$status=$row["year"]; ?>
	    				<option value="<?=$status?>" <?php if($status==$getCurrentSY['from']) echo "selected"?>><?=$status?></option>
	    		<?php	}
	    		?>
	    	</select>
	    </div>
	  
	    	<p class="blue-text lighten-2" style="font-weight:bold;">To:</p>
			<div style="width:150px;">
   				<select name="to" value="<?=$getCurrentSY['from']?>">
    				<?php $getSchoolYears = getSchoolYears($connect);
    					while($row=mysqli_fetch_array($getSchoolYears, MYSQLI_ASSOC)){
    						$status=$row["year"]; ?>
	    				<option value="<?=$status?>" <?php if($status==$getCurrentSY['to']) echo "selected"?>><?=$status?></option>
	    		<?php	}
    				?>
    			</select>
    		</div></div>
	
		<p><button class="btn waves-effect waves-light white blue-text text-lighten-2"  name="changeyear" value="Save">Save</button></p>

	</form></div>
    </li>
    <li>
      <div class="collapsible-header" style="font-weight:bold;"><i class="mdi-maps-place"></i>Penalty Percentage</div>
      <div class="collapsible-body"><p>
      	Change the penalty percentage by inputting a value then click the set button</p>
	<form method="POST">
	<div style="width: 10%;">
		<?php $selectPenaltyValue=mysqli_fetch_assoc(selectPenaltyValue($connect)); ?>
	<p>	<input type="number" min="0" pattern="[0-9]+([.][0-9]+)?" step="0.01" name="penalty" value="<?=$selectPenaltyValue['penalty']?>"></p>
	</div>
		<p><button class="btn waves-effect waves-light white blue-text text-lighten-2" name="setpenalty" value="Set Penalty">Set</button></p>
	</form></div>
    </li>
    <li>
      <div class="collapsible-header" style="font-weight:bold;"><i class="mdi-social-whatshot"></i>Third</div>
      <div class="collapsible-body"><p>Lorem ipsum dolor sit amet.</p></div>
    </li>
  </ul>


	<h5 class="showmetime" style="font-weight:bold;">Class Timings</h5>
<h6>Click on a time edit it. Or click the delete button to remove the time schedule.</h6>
<div style="width:20%;display:none;" id="timess">
<table >

	<?php
	while($row=mysqli_fetch_assoc($result)){
		?>
		<tr class="clickablerow" href="edit/editT.php?id=<?=$row['id']?>"> 
			<td><?=$row['time']?></td>
			<td><a href="option.php?id=<?=$row['id']?>" onclick="return confirm('Are you sure you wnt to delete this?');">Delete</a></td>
		</tr>
		<?php
	}
	?>
	
	<tr class="clickablerow" href="add/addT.php"> 
		<td>Add Time</td>
		<td></td>
		<td></td>
	</tr>
	
</table>
</div>


<?php

if(isset($_GET['id'])){
	$delGrade=delGrade($connect, $_GET['id']);
	if($delGrade){
		echo "Deleted!";
	}
	else{
		echo "Not working!";
	}
}
?>
<head>  <link href="asd/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="asd/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="asd/css/init.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
</br>
<script src="jquery-2.1.3.min.js"></script>

		<h5 style="font-weight:bold;">Tuition Fees</h5>
<h6>Click on a grade level to view, edit, or delete tuition fees. Or Click the button to add new tuition fees</h6></br>
<button class="btn waves-effect waves-light white blue-text text-lighten-2 clickablerow modal-trigger" href="addtuition.php" name="addtuition" value="Add New Tuition">Add New Tuition</button>



<div class="modal" id="modal7">
	<div class="modal-content">

<form method="POST">
			<input type="text" placeholder="Grade" name="grade" pattern="[A-Za-z0-9 ]+" required/>
			<br/>
			<select name="fee_type">
			<?php $getPaymentModeDB = getPaymentModeDB($connect);
				while($row=mysqli_fetch_array($getPaymentModeDB, MYSQLI_ASSOC)){
					$status=$row["mode"]; ?>
				<option value="<?=$status?>"><?=$status?></option>
			<?php } ?>
			</select>
			<br/>
			<input type="text" placeholder="Item" name="item" pattern="[A-Za-z0-9]+" required/>
			<br/>
			<input type="number"  placeholder="Tuition Fee" name="tuition_fee"  pattern="[0-9]+([.][0-9]+)?" step="0.01" required/>
			<br/>
			<input type="date" name="due_date"/>
			</br>
			<input type="submit" name="zxc" value="Save"/>
			<br/>
			<input  type="submit" onclick="location.href='option.php'" value="Back"/>
</form>
	</div>
</div>



</br>
<!--<div style="width:20%;">!-->
<?php while($row=mysqli_fetch_assoc($result2)){?>

<div class="showme" data-panelid="<?php echo str_replace(' ', '', $row['grade_levels']);?>"> <?php echo "<h5 style=\"font-weight:bold;\">".$row['grade_levels']. " Tuition Fees </h5>";?></div>
		<div style="width:50%;display:none;" id="<?php echo str_replace(' ', '', $row['grade_levels']);?>">
		<table>
			<tr>
				<th>Payment Mode</th>
				<th>Item</th>
				<th>Tution Fee</th>
				<th>Due Date</th>
			</tr>
			<?php 
			$getTuitionFees=getFeeScheduleOptions($connect, $row['grade_levels']);
			while($row2=mysqli_fetch_assoc($getTuitionFees)){ ?>
			<tr class="clickablerow" href="edit/editG.php?id=<?=$row2['fee_id']?>">
				<td><?=$row2['fee_type']?></td>
				<td><?=$row2['item']?></td>
				<td><?=$row2['fee']?></td>
				<td><?=$row2['due_date']?></td>	
			</tr>
			<?php } ?>
		</table>
		<button class="btn waves-effect waves-light white blue-text text-lighten-2 clickablerow" href="addtuition.php" name="addtuition" value="Add New Tuition">Add New Tuition</button>
	</div>
</br>
<?php }

	if(isset($_POST['dbackup'])){
  		backupDB();
  		echo "<script>alert('Backup Completed');</script>";
	}

	if(isset($_POST['dbrestore'])){
		database_restore();
		echo "<script>alert('Restore Completed');</script>";
	}?>

		<h5 style="font-weight:bold;">Backup & Restore</h5>
<h6>Here you can backup the system data or restore using a backup file from a previous state.</h6>
<form method="POST">
	<button class="btn waves-effect waves-light white blue-text text-lighten-2" name="dbackup" value="Backup">Backup System</button>
	<button class="btn waves-effect waves-light white blue-text text-lighten-2" name="dbrestore" value="Restore">Restore System</button>
</form>

<!--</div>!-->
<!--<script src="jquery-2.1.3.min.js"></script>!
<script src="http://www.gstatic.com/external_hosted/picturefill/picturefill.min.js"></script>
  <script src="asd/js/materialize.js"></script>
  <script src="asd/js/init.js"></script>!-->

<script>

$(function(){
	$(".clickablerow").click(function(){
		window.document.location=$(this).attr("href");
	});

	$(".showme").on('click', function(){
       var panelId = $(this).attr('data-panelid');
       $('#'+panelId).slideToggle();
    });

    $(".showmetime").on('click', function(){
       $('#timess').slideToggle();
    });
});


</script>
  