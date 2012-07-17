<?php
	include_once "functions.php";
	
	function setSlide($sql) {
		opendb();
		$query=mysql_query($sql,opendb())or die(mysql_error());
		if($query != null) {
			if(mysql_num_rows($query)>0) {
				$row=mysql_fetch_array($query);
			}
		}
		return $row;
		closedb();
	}
	
	function random($sql){
		opendb();
		$query=mysql_query($sql,opendb())or die(mysql_error());
		if($query != null) {
			$row=mysql_fetch_array($query);
			$jmlh = mysql_num_rows($query);
			$id=$row[idProduk];
			foreach($id as $key) {
				$arr[]=$key;
			}
			if($jmlh != 0){
				$rnd = array_rand($arr,2);
			}
		}
		return $rnd;
		closedb();
		
	}
?>