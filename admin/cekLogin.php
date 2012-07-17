<?php
	session_start();
	if(ereg("cekLogin.php", $SCRIPT_NAME)) { 
		header('Location: index.php');
	}
	if(isset($_POST['cmd_submit']) && isset($_POST['uname']) && isset($_POST['cpass'])) { 	
		session_start(); 
		include_once "./include/functions.php";
		if($_GET['act']=="login") {
			$allowed = array();			
			$allowed[] = 'uname'; 
			$allowed[] = 'cpass'; 
			$allowed[] = 'enctoken'; 
			$allowed[] = 'cmd_submit';
			$sent = array_keys($_POST);
			if ($allowed === $sent) {
				//periksa apakah form berasal dari kita atau session yg sama 
				if($_POST['enctoken'] != $_SESSION['ASTA_ADM_TOKEN']) { 
					//jika tidak maka kembali ke form
					unset($_POST['enctoken']);
					unset($_SESSION['ASTA_ADM_TOKEN']);
					session_destroy(); 
					header("Location: index.php?naughty");
				}
				else { 
					//bersihkan inputan 					
					$clean_user=(string)Encrypt(myMagic(filter($_POST['uname'])));
					$clean_password=(string)Encrypt(myMagic(filter($_POST['cpass']))); 						
					//cek user dalam database 
					if(authAdmin($clean_user, $clean_password)) { 
						//definisi waktu untuk expired time 
						$refresh_time=10; //dalam menit 
						$chour = date('H'); //jam 
						$cmin = date('i'); //menit 
						$csec = date('s'); //detik 
						$cmon = date('m'); //bulan 
						$cday = date('d'); //tanggal 
						$cyear = date('Y'); //tahun 
						$ctimestamp = mktime($chour,$cmin,$csec,$cmon,$cday,$cyear); 
						$ttimestamp = mktime($chour,$cmin+$refresh_time,$csec,$cmon,$cday,$cyear); 
						//daftarkan session variabel baru 
						$_SESSION['ASTA_ADM_USERNAME']=(string)$clean_user;
						session_id();
						if(!empty($_SESSION)) {
							session_regenerate_id(true);
						}																		
						$_SESSION['ASTA_ADM_PASSWORD']=(string)$clean_password;							
						//buat token baru untuk disisipkan dalam setiap page system login
						$hashtoken=createRandomtoken();
						//token ini akan memastikan page hanya yg dari server dengan session yg sama 
						$enchash=Encrypt($hashtoken);
						$_SESSION['ASTA_ADM_HASH']=$enchash; 
						$_SESSION['ASTA_ADM_TIMESTAMP']=$ttimestamp;
					} 
					else { 
						unset($_POST['submit']); 
						unset($_POST['uname']); 
						unset($_POST['cpass']); 
						unset($_POST['enctoken']);
						unset($_SESSION['ASTA_ADM_TOKEN']);
						header("Location: index.php?wrong");
					} 
				} 
			}
		} 
	} 
	else { 	
		session_start(); 
		include_once "./include/functions.php";
		opendb();
		$auth=false;
		$query_login='	SELECT username, password 
						FROM username 
						WHERE username="'.$_SESSION['ASTA_ADM_USERNAME'].'" 
						AND password = "'.$_SESSION['ASTA_ADM_PASSWORD'].'" 
						AND idHak=1';
		$hasil= mysql_query($query_login,opendb()); 
		closedb();
		if($hasil != null) {
			if(mysql_num_rows($hasil)>1) {
				header("Location: index.php?wrong");
			}
			else {
				$auth=true;
			}
		}
		if($auth === false) {
			header("Location: index.php?wrong");
		}
		$row= mysql_fetch_array($hasil); 
		$_SESSION['ASTA_ADM_USERNAME'] = $row['username'];
		$_SESSION['ASTA_ADM_PASSWORD'] = $row['password'];
		session_id();
		if(!empty($_SESSION)) {
			session_regenerate_id(true);
		}
		//untuk expired timed 
		$refresh_time=10; //dalam menit 
		$chour = date('H'); //jam 
		$cmin = date('i'); //menit
		$csec = date('s'); //detik 
		$cmon = date('m'); //bulan 
		$cday = date('d'); //tanggal 
		$cyear = date('Y'); //tahun 
		$ctimestamp = mktime($chour,$cmin,$csec,$cmon,$cday,$cyear); 
		$ttimestamp=$_SESSION['ASTA_ADM_TIMESTAMP']; 
		if ($ttimestamp < $ctimestamp) {
			unset($_POST['uname']);
			unset($_POST['cpass']);
			unset($_POST['enctoken']);
			unset($_POST['cmd_submit']);
			unset($_SESSION['ASTA_ADM_USERNAME']);
			unset($_SESSION['ASTA_ADM_PASSWORD']);
			unset($_SESSION['ASTA_ADM_HASH']);
			unset($_SESSION['ASTA_ADM_TIMESTAMP']);
			unset($_SESSION['ASTA_ADM_TOKEN']);
			session_destroy(); 
			header('Location: index.php?timeout');
		} 
		$ttimestamp = mktime($chour,$cmin+$refresh_time,$csec,$cmon,$cday,$cyear); 
		$_SESSION['ASTA_ADM_TIMESTAMP']=$ttimestamp;
		if($_GET['act']=="logout") {
			unset($_POST['uname']);
			unset($_POST['cpass']);
			unset($_POST['enctoken']);
			unset($_POST['cmd_submit']);
			unset($_SESSION['ASTA_ADM_USERNAME']);
			unset($_SESSION['ASTA_ADM_PASSWORD']);
			unset($_SESSION['ASTA_ADM_HASH']);
			unset($_SESSION['ASTA_ADM_TIMESTAMP']);
			unset($_SESSION['ASTA_ADM_TOKEN']);
			session_destroy();
		}
	}
?>