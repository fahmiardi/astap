<?php
	session_start();
	include_once "./include/functions.php";
	
	function addToCart($pd_id, $token) {
		$match=false;
		if($token==$_SESSION['ASTA_HASH']) {
			opendb();
			$sql_ct="SELECT ct_token FROM cart WHERE ct_token='$token' AND idProduk='$pd_id'";
			$query_ct=mysql_query($sql_ct,opendb())or die(mysql_error());
			if($query_ct != null) {
				$jmlh_ct=mysql_num_rows($query_ct);
				if($jmlh_ct<=0) {
					$tgl=tglDB();
					$sql_add="INSERT INTO cart VALUES (null,'$pd_id','$token','1','$tgl')";
					$query_add=mysql_query($sql_add,opendb())or die(mysql_error());
				}
				else {
					$jml=$jmlh_ct+1;
					$sql_add="UPDATE cart SET qty='$jml' WHERE idProduk='$pd_id'";
					$query_add=mysql_query($sql_add,opendb())or die(mysql_error());
				}
			}
			if($query_add) {
				$match=true;
			}
		}
		closedb();
		return $match;
	}
	
	function sqlCart($sql) {
		opendb();
		mysql_query($sql,opendb())or die(mysql_error());
	}
	
	function emptyCart($token) {
		opendb();
		$sql_emp="DELETE FROM cart WHERE ct_token='$token'";
		mysql_query($sql_emp,opendb())or die(myslq_error());
		closedb();
	}
	
	function tglDB() {
		$dateY=date("Y");
		$dateM=date("m");
		$dateD=date("d");
		$date="$dateY-$dateM-$dateD";
		return $date;
	}
?>