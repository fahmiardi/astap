<?php
	include_once "../config/config.php";
	//buka koneksi ke db
	function opendb() {
		global $host_con;
		global $username_con;
		global $pass_con;
		global $db_con;
		$conn=mysql_connect($host_con,$username_con,$pass_con) or die (mysql_error());
		mysql_select_db($db_con);
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
	
	function otherMenu(){
	$token="?token=".$_SESSION['SES_HASH'];
		return "
		<div align=\"left\" style=\"padding:5px 5px\">
			<table>
				<tr>
					<td>
						<a href=profil.php$token>Profil</a>
					</td>
				</tr>
				<tr>
					<td>
						<a href=network.php$token>Network</a>
					</td>
				</tr>
				<tr>
					<td>
						<a href=owner.php$token>Owner</a>
					</td>
				</tr>
				<tr>
					<td>
						<a href=berita.php$token>Berita</a>
					</td>
				</tr>
				<tr>
					<td>
						<a href=kategoriberita.php$token>Kategori Berita</a>
					</td>
				</tr>
			</table>
		</div>
		";
	}
	
function traPending(){
	$sqlPend="SELECT COUNT(noFaktur) AS pend FROM pemesanan WHERE idStatusPesan=1";
					$queryPend=mysql_query($sqlPend);
					$jum=mysql_num_rows($queryPend);
					if($jum==0){
						return "No Data";
					}
					else{
						while($rowPend=mysql_fetch_array($queryPend)){
							return "<div align=\"left\" style=\"padding: 5px 5px\">
							<table>
								<tr>
									<td>Jumlah Tansaksi Pending</td>
									<td>:</td>
									<td><font color=\"orange\">".$rowPend[pend]."</font></td>
									<td>$nbsp</td>
									<td><a href=\"#\">Lihat</a></td>
								</tr>
							</table></div>";
						}
					}
}

function traBaru(){
	$sqlNew="SELECT COUNT(noFaktur) AS baru FROM pemesanan WHERE idStatusPesan=2";
					$queryNew=mysql_query($sqlNew);
					$jum=mysql_num_rows($queryNew);
					if($jum==0){
						return "No Data";
					}
					else{
						while($rowNew=mysql_fetch_array($queryNew)){
							return "<div align=\"left\" style=\"padding: 5px 5px\">
							<table>
								<tr>
									<td>Jumlah Transaksi Baru</td>
									<td>:</td>
									<td><font color=\"orange\">".$rowNew[baru]."</font></td>
									<td>$nbsp</td>
									<td><a href=\"#\">Lihat</a></td>
								</tr>
							</table></div>";
						}
					}
}

function traBayar(){
	$sqlPaid="SELECT COUNT(noFaktur) AS terbayar FROM pemesanan WHERE idStatusPesan=3";
					$queryPaid=mysql_query($sqlPaid);
					$jum=mysql_num_rows($queryPaid);
					if($jum==0){
						return "No Data";
					}
					else{
						while($rowPaid=mysql_fetch_array($queryPaid)){
							return "<div align=\"left\" style=\"padding: 5px 5px\"><table>
							<tr>
								<td>Jumlah Transaksi Terbayar</td>
								<td>:</td>
								<td><font color=\"orange\">".$rowPaid[terbayar]."</font></td>
								<td>$nbsp</td>
								<td><a href=\"#\">Lihat</a></td>
							</tr>
							</table></div>";
						}
					}
}

function traKirim(){
	$sqlKirim="SELECT COUNT(noFaktur) AS terkirim FROM pemesanan WHERE idStatusPesan=4";
					$queryKirim=mysql_query($sqlKirim);
					$jum=mysql_num_rows($queryKirim);
					if($jum==0){
						return "No Data";
					}
					else{
						while($rowKirim=mysql_fetch_array($queryKirim)){
							return "<div align=\"left\" style=\"padding: 5px 5px\">
							<table>
								<tr>
									<td>Jumlah Transaksi Terkirim</td>
									<td>:</td>
									<td><font color=\"orange\">".$rowKirim[terkirim]."</font></td>
									<td>$nbsp</td>
									<td><a href=\"#\">Lihat</a></td>
								</tr>
							</table></div>";
						}
					}
}

function jumKonf(){
	$sqlKonf="SELECT COUNT(noFaktur) AS konf FROM konfirmasi";
					$queryKonf=mysql_query($sqlKonf);
					$jum=mysql_num_rows($queryKonf);
					if($jum==0){
						return "No Data";
					}
					else{
						while($rowKonf=mysql_fetch_array($queryKonf)){
							return "<div align=\"left\"  style=\"padding: 5px 5px\">
								<table>
									<tr>
										<td>Jumlah Konfirmasi</td>
										<td>:</td>
										<td><font color=\"orange\">".$rowKonf[konf]."</font></td>
										<td>$nbsp</td>
										<td><a href=\"#\">Lihat</a></td>
									</tr>
								</table></div>";
						}
					}
}
//Untuk Tema
	$sql_tema="SELECT * FROM tema";
	$query_tema=mysql_query($sql_tema,opendb())or die(mysql_error());
	if($query_tema != null) {
		if(mysql_num_rows($query_tema)==1) {
			$row_tema=mysql_fetch_array($query_tema);
			$BODY=$row_tema['bodyTema'];
			$BACK=$row_tema['backTema'];
			$TRIP=$row_tema['tripTema'];
			$TEXT=$row_tema['tripTextTema'];
			$BANER=$row_tema['banerTema'];
			$BANERTRIP=$row_tema['banerTripTema'];
			$JUDUL=$row_tema['title'];
			$RINCIAN=$row_tema['rincian'];
			$DOMAIN=$row_tema['domain'];
		}
	}
?>