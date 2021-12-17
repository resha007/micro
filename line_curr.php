<!DOCTYPE HTML>
<?PHP
	require 'functions.php';
	checkLogin();
	$db_link = connect();

	//Make array for exporting data
	$rep_year = date("Y",time());
	$rep_month = date("m",time());
	$_SESSION['rep_export'] = array();
	$_SESSION['rep_exp_title'] = $rep_year.'-'.$rep_month.'_empl-current';

	$query_linecurr = getLineCurr($db_link);
?>

<html>
	<?PHP includeHead('Current Lines',1) ?>

	<body>
		<!-- MENU -->
		<?PHP includeMenu(8); ?>
		<div id="menu_main">
			<!-- <a href="empl_search.php">Search</a> -->
			<a href="line_new.php">New Line</a>
			<a href="line_curr.php" id="item_selected">Current Lines</a>
		</div>

		<!-- TABLE: Current Lines -->
		<table id="tb_table">
			<colgroup>
				<col width="6%" />
				<col width="14%" />
				<col width="14%" />
				<col width="8%" />
			</colgroup>
			<tr>
				<form class="export" action="rep_export.php" method="post">
					<th class="title" colspan="9">Current Lines
					<!-- Export Button -->
					<input type="submit" name="export_rep" value="Export" />
					</th>
				</form>
			</tr>
			<tr>
				<th>ID</th>
				<th>Code</th>
				<th>Name</th>
				<th>Status</th>
			</tr>
			<?PHP
			$count = 0;
			while ($row_linecurr = mysqli_fetch_assoc($query_linecurr)){
				echo '<tr>
								<td><a href="Line.php?empl='.$row_linecurr['line_id'].'">'.$row_linecurr['line_id'].'</a></td>
								<td>'.$row_linecurr['name'].'</td>
								<td>'.$row_linecurr['code'].'</td>
								<td>'.$row_linecurr['status'].'</td>
							</tr>';

				array_push($_SESSION['rep_export'], array("Line ID" => $row_linecurr['line_id'], "Line Code" => $row_linecurr['code'], "Line Name" => $row_linecurr['name']));

				$count++;
			}
			?>
			<tr class="balance">
				<td colspan="9*">
				<?PHP
				echo $count.' current Line';
				if ($count != 1) echo 's';
				?>
				</td>
			</tr>
		</table>
	</body>
</html>
