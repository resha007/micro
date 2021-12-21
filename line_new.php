<!DOCTYPE HTML>
<?PHP
	require 'functions.php';
	checkLogin();
	$db_link = connect();

	//Generate timestamp
	$timestamp = time();

	//CREATE-Button
	if (isset($_POST['create'])){

		//Sanitize user input
		$line_code = sanitize($db_link, $_POST['line_code']);
		$line_name = sanitize($db_link, $_POST['line_name']);
		$rider = sanitize($db_link, $_POST['rider_id']);
		$opt_rider = sanitize($db_link, $_POST['optRider_id']);
		$line_status = sanitize($db_link, $_POST['line_status']);

		//Insert new Line into Line
		$sql_insert = "INSERT INTO Line (code, name,rider_id,opt_rider_id, status) VALUES ('$line_code', '$line_name','$rider','$opt_rider', '$line_status')";
		$query_insert = mysqli_query($db_link, $sql_insert);
		checkSQL($db_link, $query_insert);

		//Get new Lines's ID from Line
		

		// Refer to empl_new_pic.php
		//header('Location: empl_new_pic.php');
	}

	//Select riders for Drop-down-Menu
	$sql_rider = "SELECT * FROM employee where empl_type = 'Rider'";
	$query_rider = mysqli_query($db_link, $sql_rider);
	checkSQL($db_link, $query_rider);

	//Select riders for Drop-down-Menu
	$sql_optrider = "SELECT * FROM employee where empl_type = 'Rider'";
	$query_optrider = mysqli_query($db_link, $sql_optrider);
	checkSQL($db_link, $query_optrider);
	
?>

<html>
	<?PHP includeHead('New Line',0) ?>
		
	</head>
	<body>
		<!-- MENU -->
		<?PHP includeMenu(8); ?>
		<div id="menu_main">
			<!-- <a href="empl_search.php">Search</a> -->
			<a href="line_new.php" id="item_selected">New Line</a>
			<a href="line_curr.php">Current Lines</a>
		</div>

		<!-- PAGE HEADING -->
		<p class="heading">New Line</p>

		<!-- CONTENT -->
		<div class="content_center">
			<form action="line_new.php" method="post" onSubmit="true" enctype="multipart/form-data">

				<table id ="tb_fields" style="max-width:1000px;">
					<tr>
						<td>Code:</td>
						<td><input type="text" name="line_code" placeholder="Line Code" tabindex=8 /></td>
					</tr>
					<tr>
						<td>Name:</td>
						<td><input type="text" name="line_name" placeholder="Line Name" tabindex=2 /></td>
					</tr>
					<tr>
							<td>Rider:</td>
							<td>
								<select name="rider_id" size="1" tabindex=5>';
									<option selected disabled>Select a Rider</option>
									<?PHP
									while ($row_line = mysqli_fetch_assoc($query_rider)){
										echo '<option value="'.$row_line['empl_id'].'">'.$row_line['empl_name'].'</option>';
									}
									?>
								</select>
							</td>
							
					</tr>
					<tr>
							<td>Optional Rider:</td>
							<td>
								<select name="optRider_id" size="1" tabindex=5>';
									<option selected disabled>Select a optional Rider</option>
									<?PHP
									while ($row_line = mysqli_fetch_assoc($query_optrider)){
										echo '<option value="'.$row_line['empl_id'].'">'.$row_line['empl_name'].'</option>';
									}
									?>
								</select>
							</td>
							
					</tr>
					<tr>
						<td>Status:</td>
						<td>
							<select name="line_status" size="1" tabindex=3>';
								<option value="1">Active</option>
								<option value="2">Inactive</option>
								
							</select>
						</td>
						
					</tr>
					
					
					<tr>
						<td colspan="4" class="center">
							<input type="submit" name="create" value="Continue" tabindex=12 />
						</td>
						<td></td>
						<td></td>
					</tr>
				</table>
			</form>
		</div>
	</body>
</html>
