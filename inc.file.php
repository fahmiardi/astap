<?php
	include_once "./library/kelasCompany.php";
	include_once "./include/functions.php";
	include_once "./include/functions-cart.php";
	include_once "./include/functions-product.php";
	
	$render=new Company();
	
	$opt=$_GET['opt'];
	switch($opt) {
		case 'toko':
		$sql_ol="SELECT online FROM tema";
		$query_ol=mysql_query($sql_ol,opendb())or die(mysql_error());
		if($query_ol != null) {
			if(mysql_num_rows($query_ol)==1) {
				$row_ol=mysql_fetch_array($query_ol);
				$ol=$row_ol['online'];
				if($ol==1) {
					include_once "./index1.php";	
				}
				else {
					include_once "./index.php";
				}
			}
		}	
			break;
		case 'home':
			include_once "./front.php";
			break;
		case 'info':
			include_once "./info.php";
			break;
		case 'news':
			include_once "./news.php";
			break;
		default :
			include_once "./index.php";
			break;
	}
?>