<!DOCTYPE HTML>
<?PHP
	require 'functions.php';
	checkLogin();
	$db_link = connect();

	//Generate timestamp
	$timestamp = time();

	// Get line
	if(isset($_GET['line'])) $_SESSION['line_id'] = sanitize($db_link, $_GET['line']);
	else header('Location:line_curr.php');

	//UPDATE-Button
	if (isset($_POST['update'])){

		//Sanitize user input
		$line_code = sanitize($db_link, $_POST['line_code']);
		$line_name = sanitize($db_link, $_POST['line_name']);
		$rider = sanitize($db_link, $_POST['rider_id']);
		$opt_rider = sanitize($db_link, $_POST['optRider_id']);
		$line_status = sanitize($db_link, $_POST['line_status']);

		//Update line
		$sql_update = "UPDATE line SET code = '$line_code', name = '$line_name', rider_id = '$rider', opt_rider_id = '$opt_rider', status = '$line_status' WHERE line_id = $_SESSION[line_id]";
		$query_update = mysqli_query($db_link, $sql_update);
		checkSQL($db_link, $query_update);

		// Forward to this page
		header('Location: line.php?empl='.$_SESSION['line_id']);
	}

	//Select riders for Drop-down-Menu
	$sql_rider = "SELECT * FROM employee where empl_type = 'Rider'";
	$query_rider = mysqli_query($db_link, $sql_rider);
	checkSQL($db_link, $query_rider);

	//Select riders for Drop-down-Menu
	$sql_optrider = "SELECT * FROM employee where empl_type = 'Rider'";
	$query_optrider = mysqli_query($db_link, $sql_optrider);
	checkSQL($db_link, $query_optrider);

	//Select line
	$result_line = getLine($db_link, $_SESSION['line_id']);
?>

<html>
	<?PHP includeHead('Line',0) ?>
		
		
	</head>

	<body>
		<!-- MENU -->
		<?PHP includeMenu(7); ?>
		<div id="menu_main">
			<!-- <a href="empl_search.php">Search</a> -->
			<a href="line_new.php">New Line</a>
			<a href="line_curr.php">Current Lines</a>
		</div>

		<div class="content_center">
			<!-- HEADING -->
			<p class="heading" style="margin-bottom:.3em;">
				<?PHP echo $result_line['name'].' ('.$result_line['line_id'].')'; ?>
			</p>

			<form action="line.php" method="post" onSubmit="true">


			<table id ="tb_fields" style="max-width:1000px;">
					<tr>
						<td>Code:</td>
						<td><input type="text" name="line_code" placeholder="Line Code" tabindex=8 value="<?=$result_line['code']?>" /></td>
					</tr>
					<tr>
						<td>Name:</td>
						<td><input type="text" name="line_name" placeholder="Line Name" tabindex=2 value="<?=$result_line['name']?>" /></td>
					</tr>
					<tr>
							<td>Rider1:</td>
							<td>
								<select name="rider_id" size="1" tabindex=5>';
									<!-- <option selected disabled>Select a Rider</option> -->
									<?PHP
									while ($row_rider = mysqli_fetch_assoc($query_rider)){
										if($row_rider['empl_id'] == $result_line['rider']){ 
											echo '<option selected value="'.$row_rider['empl_id'].'">'.$row_rider['empl_name'].'</option>';
										}
										else echo '<option value="'.$row_rider['empl_id'].'">'.$row_rider['empl_name'].'</option>';
									}
									?>
								</select>
							</td>
							
					</tr>
					<tr>
							<td>Optional Rider:</td>
							<td>
								<select name="optRider_id" size="1" tabindex=5>';
									<!-- <option selected disabled>Select a Rider</option> -->
									<?PHP
									while ($row_rider = mysqli_fetch_assoc($query_optrider)){
										if($row_rider['empl_id'] == $result_line['optrider']){ 
											echo '<option selected value="'.$row_rider['empl_id'].'">'.$row_rider['empl_name'].'</option>';
										}
										else echo '<option value="'.$row_rider['empl_id'].'">'.$row_rider['empl_name'].'</option>';
									}
									?>
								</select>
							</td>
							
					</tr>
					<tr>
						<td>Status:</td>
						<td>
							<select name="line_status" size="1" tabindex=3>';
								<?php
								if($result_line['status'] == 1){ 
									echo '<option selected value="1">Active</option>';
									echo '<option value="2">Inactive</option>';
								}
								
								if($result_line['status'] == 2){ 
									echo '<option value="1">Active</option>';
									echo '<option selected value="2">Inactive</option>';
								}
								
								?>
								
							</select>
						</td>
						
					</tr>
					
					
					<tr>
					<td colspan="6" class="center">
											<input type="submit" name="update" value="Save Changes" tabindex=13 />
										</td>
						<td></td>
						<td></td>
					</tr>
				</table>

				
			</form>
		</div>
	</body>
</html>
