<?php
	//buka koneksi ke db
	function opendb() {
		$host="localhost";
		$username="root";
		$pass="";
		$db="asetech";
		$conn=mysql_connect($host,$username,$pass) or die (mysql_error());
		mysql_select_db($db);
		return $conn;
	}
	
	//tutup koneksi db
	function closedb() {
		mysql_close(opendb());
	}
	
	//fungsi untuk menangani karakter khusus
	//@return string yang sudah di-escape
	function myMagic($str){
		if(get_magic_quotes_gpc()){
			$str = stripslashes($str);
		}
		$str = strip_tags(trim($str));
		opendb();
		return mysql_real_escape_string($str);
	}	

	//ngebuat token
	function createRandomtoken() { 
		$sumber = "abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"; 
		srand((double)microtime()*1000000);
		$i = 0; while ($i <= 5) { 
			$num = rand() % 33; 
			$char = substr($sumber, $num, 1); 
			if (!strstr($token, $char))	{ 
				$token .= $char; $i++; 
			} 
		} 
		return $token; 
	}

	//encrypt  string
	function Encrypt($str) {
		$cipher = crypt(md5($str),md5($str)) ;
		return $cipher; 
	} 
		
	//filterisasi string dari inputan
	function filter($word) { 
		$word = (string)myMagic(stripslashes(trim($word))); 
		$word = (string)nl2br($word); 
		$word = (string)htmlentities($word); 
		return $word ; 
	}
	
	//autentifikasi dari form login
	function authPelanggan($user, $pass) {
		opendb();
		$auth = false;
		if(strpos($user, ';') || strpos($pass, ';')) {
			die('Naughty...');
		}	
		$query="SELECT username, password 
				FROM username 
				WHERE username='$user' 
				AND password = '$pass' 
				AND idHak=2";
		$hasil=mysql_query($query,opendb());
		if($hasil != null){
			if(mysql_num_rows($hasil) ==1){
				$auth = true;
			}
		}
		return $auth;
		closedb();
	}
	
	function authAdmin($user, $pass) {
		opendb();
		$auth = false;
		if(strpos($user, ';') || strpos($pass, ';')) {
			die('Naughty...');
		}	
		$query="SELECT username, password 
				FROM username 
				WHERE username='$user' 
				AND password = '$pass' 
				AND idHak=1";
		$hasil=mysql_query($query,opendb());
		if($hasil != null){
			if(mysql_num_rows($hasil) ==1){
				$auth = true;
			}
		}
		return $auth;
		closedb();
	}
	
	//funsi tanggal
	function tanggal() {
		$hari = array("Minggu","Senin","Selasa","Rabu","Kamis","Jum'at","Sabtu");
		$bulan = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","Nopember","Desember");
		$waktu[0] = $hari[date("w", time())];
		$waktu[1] = date("d", time());
		$waktu[2] = date("n", time());
		$waktu[3] = date("Y", time());
		$waktu[4] = date("H", time());
		$waktuJam = $waktu[4];
		if($waktuJam=="00") {
			$waktuJam=23;
		}
		else if ($waktuJam=="1") {
			$waktuJam="00";
		}
		else {
			$waktuJam=$waktu[4];
		}
		$waktu[5] = date("i", time());
		
		$hasil=$waktu[0] .", ". $waktu[1] ." ". $bulan[$waktu[2]-1] ." ". $waktu[3] ."&nbsp;&nbsp;";
		echo $hasil;
	}
	
	function randomFaktur() {
		$sumber = "0123456789"; 
		srand((double)microtime()*1000000);
		$rand=substr(str_shuffle($sumber),0,9);
		return $rand;
	}
	
	function isEmail($str) {
		return (ereg('^[^@]+@([a-z\-]+\.)+[a-z]{2,4}$',$str));
	}
?>