<?php
	header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
	header('Cache-Control: no-store, no-cache, must-revalidate');
	header('Cache-Control: post-check=0, pre-check=0, false');
	
	session_start();
	include_once "./library/kelasPelanggan.php";
	include_once "./include/functions.php";
	include_once "./include/functions-cart.php";
	
	$title="::$JUDUL | Halaman Konfirmasi::";
	$konfirmasi = new Pelanggan();
	if(isset($_SESSION['ASTA_HASH'])) {
		if($_SESSION['ASTA_HASH'] == $_GET['token']) {
			$link="$_SERVER[PHP_SELF]?token=$_SESSION[ASTA_HASH]";
			$head="Refresh: 3; URL= index1.php?token=$_SESSION[ASTA_HASH]";
		}
		else {
			$head="Location: index1.php";
			$link="$_SERVER[PHP_SELF]";
			$form="konfirm.php";
		}
	}
	$isi_2="<tr>
				<td colspan=\"2\" valign=\"top\" style=\"padding-top: 10px;\">
					<table cellpadding=\"0\" cellspacing=\"0\" align=\"center\" bgcolor=\"#$TRIP\" width=\"100%\">
						<tr bgcolor=\"#$BACK\">
							<td vailgn=\"top\"> 
								<div style=\"background-color: #$TRIP; width:162px; text-align: center;  font-family: tahoma; font-size: 13px; font-weight: bold; color: #$TEXT;\">Konfirmasi</div>
								<div style=\"border: 1px solid #$TRIP; padding: 10px 10px 10px 10px;\">";
									if(isset($_GET['ac']) && $_GET['ac'] != "") {
										if($_GET['ac'] == "finish") {
											$isi_2 .= "<div align=\"center\">Terima kasih. Konfirmasi Anda akan segera kami proses.";
											header ($head);
										}
										else {
											header($head);
										}
									}
									else {
						$isi_2 .="	<div style=\"padding: 10px 10px 10px 10px;\">
										<div style=\"background: #$TRIP; color: #$TEXT; text-align: center; width: 100px;\">Form</div>
										<div style=\"border: 1px solid #$TRIP; padding: 10px 10px 10px 10px; width: 425px;\">
											<form action=\"$link\" method=\"post\">
											<table cellpadding=\"2\" cellspacing=\"0\" width=\"100%\" align=\"center\" valign=\"top\" border=\"0\">";
												$aksi1=false;
												$aksi3=false;
												$aksi4=false;
												$aksi5=false;
												
												if($_POST['submit']) {
													if($_POST['noTiket'] == "" || !is_Numeric($_POST['noTiket'])) {
														$mark1="#$TRIP";
													}
													else {
														$mark1="white";
														$aksi1=true;
													}
												}
												else {
													$mark1="white";														
												}
									$isi_2 .="	<tr>
													<td valign=\"top\">No. Tiket</td>
													<td valign=\"top\" width=\"10\">:</td>
													<td valign=\"top\"><input type=\"text\" name=\"noTiket\" size=\"30\" value=\"$_POST[noTiket]\" style=\"background-color: $mark1;\"></td>
													</tr>";											
												
									$isi_2 .="	<tr>
													<td valign=\"top\" align=\"left\"  style=\"padding-top: 25px;\"><b>Data Transfer</b></td>
													</tr>
												<tr>
													<td valign=\"top\">Nama Bank Pemilik</td>
													<td valign=\"top\">:</td>
													<td valign=\"top\">";
														$sql_bank="SELECT idBank, namaBank FROM bank";
														$query_bank=mysql_query($sql_bank,opendb())or die(mysql_error());
														if($query_bank != null) {
															if(mysql_num_rows($query_bank)>0) { 
																while($row_bank=mysql_fetch_array($query_bank)) {
																	$isi_2 .= "<input type=\"radio\" name=\"idBank\" value=\"$row_bank[idBank]\" checked>$row_bank[namaBank]";
																}
															}
														}
											$isi_2 .="	</td>
													</tr>";
												
												if($_POST['submit']) {
													if($_POST['noRek'] == "" || !is_Numeric($_POST['noRek'])) {
														$mark3="#$TRIP";
													}
													else {
														$mark3="white";
														$aksi3=true;
													}
												}
												else {
													$mark3="white";														
												}
									$isi_2 .="	<tr>
													<td valign=\"top\">No. Rek. Pemilik</td>
													<td valign=\"top\">:</td>
													<td valign=\"top\"><input type=\"noRek\" name=\"noRek\" size=\"30\" value=\"$_POST[noRek]\" style=\"background-color: $mark3;\"></td>
													</tr>";
													
												if($_POST['submit']) {
													if($_POST['namaRek'] == "") {
														$mark4="#$TRIP";
													}
													else {
														$mark4="white";
														$aksi4=true;
													}
												}
												else {
													$mark4="white";														
												}
									$isi_2 .="	<tr>
													<td valign=\"top\">Nama Pemilik Rek.</td>
													<td valign=\"top\">:</td>
													<td valign=\"top\"><input type=\"text\" name=\"namaRek\" size=\"30\" value=\"$_POST[namaRek]\" style=\"background-color: $mark4;\"></td>
													</tr>";
													
												if($_POST['submit']) {
													if($_POST['jmlh'] == "" || !is_Numeric($_POST['jmlh'])) {
														$mark5="#$TRIP";
													}
													else {
														$mark5="white";
														$aksi5=true;
													}
												}
												else {
													$mark5="white";														
												}
									$isi_2 .="	<tr>
													<td valign=\"top\">Jumlah Transfer</td>
													<td valign=\"top\">:</td>
													<td valign=\"top\"><input type=\"text\" name=\"jmlh\" size=\"30\" value=\"$_POST[jmlh]\" style=\"background-color: $mark5;\"></td>
													</tr>";
													
									$isi_2 .="	<tr>
													<td valign=\"top\">Pesan</td>
													<td valign=\"top\">:</td>
													<td valign=\"top\"><textarea style=\"font-family: tahoma; font-weight: bold; font-size: 10px; background-color: white;\" name=\"pesan\" rows=\"7\" cols=\"40\" wrap>$_POST[pesan]</textarea></td>
													</tr>";
																					
									$isi_2 .="	</table>
											</div>
											<div style=\"padding-top: 10px;\"></div>
											<div style=\"text-align: center;\"><a href=\"$link\"><input type=\"reset\" value=\"Reset\" class=\"ctombol\"></a> <input type=\"submit\" name=\"submit\" value=\"Konfirm\" class=\"ctombol\"></div>
											<div><small><b><u>Note :</u></b></small></div>
											<div><small>Semua FORM wajib diisi.</small></div>
										</div>";
										if($aksi1 && $aksi3 && $aksi4 && $aksi5) {
											$noTiket=$_POST['noTiket'];
											$idBank=$_POST['idBank'];
											$noRek=$_POST['noRek'];
											$namaRek=$_POST['namaRek'];
											$jmlh=$_POST['jmlh'];
											$pesan=$_POST['pesan'];
											
											$sql_insKonf="	INSERT INTO konfirmasi 
															VALUES(	'',
																	'$noTiket',
																	'$idBank',
																	'$noRek',
																	'$namaRek',
																	'$jmlh',
																	'$pesan',
																	'unread')";
											$query_insKonf=mysql_query($sql_insKonf,opendb())or die(mysql_error());
											if($query_insKonf) {
												header("Location: $link&ac=finish");
											}
										}
									}
						$isi_2 .="	</div>													
								</td>
							</tr>
						</table>
					</td>
				<tr>";
	
	if(isset($_SESSION['ASTA_HASH'])) {
		if($_SESSION['ASTA_HASH'] == $_GET['token']) {
			if(!authPelanggan($_SESSION['ASTA_USERNAME'], $_SESSION['ASTA_PASSWORD'])) {
				emptyCart($_SESSION['ASTA_HASH']);
				unset($_GET['token']);
				unset($_SESSION['ASTA_USERNAME']);
				unset($_SESSION['ASTA_PASSWORD']);
				unset($_SESSION['ASTA_HASH']);
				unset($_SESSION['ASTA_TIMESTAMP']);
				unset($_SESSION['ASTA_TOKEN']);
				session_destroy();
				header("Location: index1.php?naughty");
			}
			else {
				//untuk expired timed 
				$refresh_time=10; //dalam menit 
				$chour = date('H'); //jam 
				$cmin = date('i'); //menit
				$csec = date('s'); //detik 
				$cmon = date('m'); //bulan 
				$cday = date('d'); //tanggal 
				$cyear = date('Y'); //tahun 
				$ctimestamp = mktime($chour,$cmin,$csec,$cmon,$cday,$cyear); 
				$ttimestamp=$_SESSION['ASTA_TIMESTAMP']; 
				if ($ttimestamp < $ctimestamp) { 
					emptyCart($_SESSION['ASTA_HASH']);
					unset($_POST['uname']);
					unset($_POST['cpass']);
					unset($_POST['enctoken']);
					unset($_POST['cmd_submit']);
					unset($_SESSION['ASTA_USERNAME']);
					unset($_SESSION['ASTA_PASSWORD']);
					unset($_SESSION['ASTA_HASH']);
					unset($_SESSION['ASTA_TIMESTAMP']);
					unset($_SESSION['ASTA_TOKEN']);
					session_destroy(); 					
					header('Location: index1.php?timeout');
				} 
				$ttimestamp = mktime($chour,$cmin+$refresh_time,$csec,$cmon,$cday,$cyear); 
				$_SESSION['ASTA_TIMESTAMP']=$ttimestamp;
				
				//content				
				if(isset($_SESSION['ASTA_HASH'])) {
					$sql_user="	SELECT usernameAsal 
								FROM username 
								WHERE username='$_SESSION[ASTA_USERNAME]'";
					$query_user=mysql_query($sql_user,opendb())or die(mysql_error());
					if($query_user != null) {
						if(mysql_num_rows($query_user)==1) {
							$row_user=mysql_fetch_array($query_user);
							$user=$row_user['usernameAsal'];
						}
					}
				}
				else {
					$user="Guest";
				}
				$isiLink="	<tr><td><a href=\"index2.php?act=logout&token=$_SESSION[ASTA_HASH]\" class=\"menuItem\" alt=\"Logout\" title=\"Logout\"><div class=\"break\">Logout</div></a></td></tr>
							<tr><td><div style=\"padding: 10px 0px 10px 0px; text-align: center;\">Selamat Datang <b>".$user."</b></div></td></tr>";
				$token="?token=".$_SESSION['ASTA_HASH'];
				$arrayMenu=array("pemesanan.php$token"=>'Pemesanan',"viewCart.php$token"=>'Kantong Belanja',"katalog.php$token"=>'Katalog',"konfirm.php$token"=>'Konfirmasi',"myAccount.php$token"=>'My Account');
				opendb();
				$sql_item="SELECT idCart FROM cart WHERE ct_token='$_SESSION[ASTA_HASH]'";
				$query_item=mysql_query($sql_item) or die(mysql_error());
				if($query_item != null) {
					$jmlh_item=mysql_num_rows($query_item);
					if($jmlh_item==0) {
						$item="$jmlh_item Item";
					}
					elseif($jmlh_item==1) {
						$item="$jmlh_item Item <br>CHECKOUT";
					}
					else {
						$item="$jmlh_item Items <br>CHECKOUT";
					}
				}
				$menuAtas=array("index1.php$token"=>'Home',"informasi.php$token&opt=contact"=>'Contact',"viewCart.php$token"=>$item);								
				
							
				$konfirmasi->setMenuAtas($menuAtas);
				$konfirmasi->setArrayMenu($arrayMenu);
				$konfirmasi->setLinkLogout($isiLink);		
				
			}
		}
		else {
			emptyCart($_SESSION['ASTA_HASH']);
			unset($_GET['token']);
			unset($_SESSION['ASTA_USERNAME']);
			unset($_SESSION['ASTA_PASSWORD']);
			unset($_SESSION['ASTA_HASH']);
			unset($_SESSION['ASTA_TIMESTAMP']);
			unset($_SESSION['ASTA_TOKEN']);
			session_destroy();
			header("Location: index1.php?wrong2");
		}
	}
	else {
		emptyCart($_SESSION['ASTA_HASH']);	
	}
	$konfirmasi->setTitle($title);
	$konfirmasi->setIsi_2($isi_2);
	$konfirmasi->getTampilkan();
?>