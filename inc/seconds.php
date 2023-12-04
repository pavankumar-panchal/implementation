<?php
	for($i=0;$i<60;$i++)
	{
		if($i <= 9)
		{
			$j = 0;
			echo('<option value="'.$j.$i.'">'.$j.$i.'</option>');
		}
		else
		{
			echo('<option value="'.$i.'">'.$i.'</option>');
		}
	}
?>
