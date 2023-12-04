<?
	$query = "SELECT slno,activityname from imp_mas_activity order by slno";
	$result = runmysqlquery($query);
	while($fetch = mysqli_fetch_array($result))
	{
		echo('<option value="'.$fetch['slno'].'">'.$fetch['activityname'].'</option>');
	}
?>