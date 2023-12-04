<?php
	if($handhold == 'yes')
			$assignimp = "imp_implementation.assignhandholdimplementation";
	else
		$assignimp = "imp_implementation.assignimplemenation";
		
	$query = "SELECT distinct inv_mas_product.productcode,inv_mas_product.productname,inv_mas_product.`group` as productgroup 
	FROM imp_implementation left join inv_mas_product on inv_mas_product.productcode = imp_implementation.productcode 
	left join inv_mas_implementer on inv_mas_implementer.slno = $assignimp
	left join inv_invoicenumbers on inv_invoicenumbers.dealerid = imp_implementation.dealerid
	where imp_implementation.productcode!='' and inv_mas_implementer.branchid = '".$branch."' ".$implementerpropiece."";
	$result = runmysqlquery($query);
	while($fetch = mysqli_fetch_array($result))
	{
		 echo('<label for = "'.$fetch['productname'].'"><input checked="checked" type="checkbox" name="productname[]" id="'.$fetch['productname'].'"    value ="'.$fetch['productcode'].'" />&nbsp;'.$fetch['productname']);
		 echo('<font color = "#999999">&nbsp;('.$fetch['productcode'].')</font></label>');
		 echo('<br/>');
	}
?>