<?php
session_start();
	include('processes/process.php');
	
	$connect=connectDB();
	if(isset($_POST['add'])){
		$t1=$_POST['time'];
		$time=$t1." ".$_POST['tod'];
			$add=addTime($connect,$time);
			if($add){
				echo "Added successfully";
			}
			else{
				echo "Failed to add";
			}
	 
	}
	include('header.php');
?>
<div style="position: relative;width: 80%;bottom: -2%; left: 16%;">


<form method="POST">

			Time
			<input type="text" name="time" value="hh:mm"/>
			<select name="tod">
				<option value="am">am</option>
				<option value="pm">pm</option>
			</select>
			<input type="submit" name="add" value="Add Record"/>
			<input type="reset" name="clear" value="Clear"/></td>
	
	</form>
			<a href ="../option.php">Back</a>
</div>
