<?php
	$query = "SELECT * from imp_mas_handholdtype";
	$result = runmysqlquery($query);
	while($fetch = mysqli_fetch_array($result))
	{
		echo('<option value="'.$fetch['slno'].'">'.$fetch['handholdtype'].'</option>');
	}
?>