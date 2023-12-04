<?php
	$userid = imaxgetcookie('userslno');
	$query = "select distinct imp_mas_activity.slno,imp_mas_activity.activityname from imp_implementationactivity left join imp_mas_activity on imp_implementationactivity.activity = imp_mas_activity.slno left join imp_implementation on imp_implementation.slno = imp_implementationactivity.impref where imp_implementation.customerreference =  '11';";
	$result = runmysqlquery($query);
	while($fetch = mysqli_fetch_array($result))
	{
		echo('<option value="'.$fetch['slno'].'">'.$fetch['businessname'].'</option>');
	}
?>