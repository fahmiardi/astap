<?php
	header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
	header('Cache-Control: no-store, no-cache, must-revalidate');
	header('Cache-Control: post-check=0, pre-check=0, false');
	
	session_start();
	include_once "./library/kelasPelanggan.php";
	include_once "./include/functions.php";
	include_once "./include/functions-cart.php";	
	
	
	$katalog = new Pelanggan();
	$isi_2="<tr>
				<td colspan=\"2\" valign=\"top\" style=\"padding-top: 10px;\">
					<table cellpadding=\"0\" cellspacing=\"0\" align=\"center\" bgcolor=\"#$BACK\" width=\"100%\">
						<tr bgcolor=\"#$BACK\">
							<td vailgn=\"top\"> 
								<div style=\"background-color: #$TRIP; width:162px; text-align: center;  font-family: tahoma; font-size: 13px; font-weight: bold; color: #$TEXT;\">";
									if(isset($_GET['opt'])) {
										$opt2=$_GET['opt'];
										switch($opt2) {
											case 'about':
												$isi_2.="Tentang Kami";
												break;
											case 'porto':
												$isi_2.="Portofolio";
												break;
											case 'contact':
												$isi_2.="Contact";
												break;
											case 'belanja':
												$isi_2.="Cara Belanja";
												break;
											case 'bayar':
												$isi_2.="Cara Pembayaran dan Konfirmasi";
												break;
											case 'kirim':
												$isi_2.="Biaya Pengiriman";
												break;
											default:
												if(isset($_SESSION['ASTA_HASH'])) {
													$head="index1.php?token=$_SESSION[ASTA_HASH]";
												}
												else {
													$hed="index1.php";
												}
												header("Location: $head");
										}								
									}
						$isi_2.="	</div>
								<div style=\"border: 1px solid #$TRIP; padding: 10px 10px 10px 10px;\">";									
									$opt=$_GET['opt'];
									switch($opt) {
										case 'about':											
											$sql_about="SELECT * FROM tentangkami WHERE idPosisi='1'";
											$query_about=mysql_query($sql_about,opendb())or die(mysql_error());
											if($query_about != null) {
												if(mysql_num_rows($query_about)>0) {
													while($row_about=mysql_fetch_array($query_about)) {
														$isi_2.="<div style=\"padding-bottom: 10px;\">
																	<div style=\"padding-left: 316px;\"><div style=\"background-color: #$TRIP; width: 150px; font-family: tahoma;text-align: center; color: #$TEXT;\">$row_about[judulKonten]</div></div>
																	<table width=\"100%\" align=\"center\" cellpadding=\"1\" cellspacing=\"1\" bgcolor=\"#$TRIP\">
																		<tr bgcolor=\"#$BACK\">
																			<td style=\"\" align=\"justify\">
																				<div style=\"text-align: justify; padding:5px 5px 5px 5px;\">$row_about[deskripsiKonten]</div>
																				</td>
																			</tr>
																		<tr>
																			<td colspan=\"2\" align=\"justify\"><div style=\"text-align: justify;\">$lanjut</div></td>
																			</tr>
																		</table>
																	</div>";
													}
												}
											}
											$title="::$JUDUL | Halaman Tentang Kami::";
											break;
										case 'porto':											
											$sql_about="SELECT * FROM tentangkami WHERE idPosisi='2'";
											$query_about=mysql_query($sql_about,opendb())or die(mysql_error());
											if($query_about != null) {
												if(mysql_num_rows($query_about)>0) {
													while($row_about=mysql_fetch_array($query_about)) {
														$isi_2.="<div style=\"padding-bottom: 10px;\">
																	<div style=\"padding-left: 316px;\"><div style=\"background-color: #$TRIP; width: 150px; font-family: tahoma;text-align: center; color: #$TEXT;\">$row_about[judulKonten]</div></div>
																	<table width=\"100%\" align=\"center\" cellpadding=\"1\" cellspacing=\"1\" bgcolor=\"#$TRIP\">
																		<tr bgcolor=\"#$BACK\">
																			<td style=\"\" align=\"justify\">
																				<div style=\"text-align: justify; padding:5px 5px 5px 5px;\">$row_about[deskripsiKonten]</div>
																				</td>
																			</tr>
																		<tr>
																			<td colspan=\"2\" align=\"justify\"><div style=\"text-align: justify;\">$lanjut</div></td>
																			</tr>
																		</table>
																	</div>";
													}
												}
											}
											$title="::$JUDUL | Halaman Portofolio::";										
											break;
										case 'contact': 
											$title="::$JUDUL | Halaman Contact::";
											$isi_2.="<div style=\"padding-bottom: 10px;\">";
														$sql_pt="SELECT * FROM perusahaan";
														$query_pt=mysql_query($sql_pt,opendb())or die(mysql_error());
														if($query_pt != null) {
															if(mysql_num_rows($query_pt)>0) {
																$row_pt=mysql_fetch_array($query_pt);
													$isi_2.="	<table align=\"center\" width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
																	<tr>
																		<td width=\"60\">
																			<img src=\"./imagea/pt.ico\" width=\"48\" height=\"48\">
																			</td>
																		<td colspan=\"2\" style=\"padding-top: 20px;\">
																			<font style=\"color: #$TRIP;\" size=4>".strtoupper($row_pt['namaPerusahaan'])."
																			<hr>
																			</td>
																		</tr>
																	<tr>
																		<td></td>
																		<td width=\"25\">
																			<img src=\"./imagea/alamat.ico\" width=\"16\" height=\"16\">
																			</td>
																		<td style=\"padding-bottom: 5px;\">
																			$row_pt[alamatPerusahaan]
																			</td>
																		</tr>
																	<tr>
																		<td></td>
																		<td width=\"25\">
																			<img src=\"./imagea/phone.ico\" width=\"16\" height=\"16\">
																			</td>
																		<td style=\"padding-bottom: 5px;\">
																			$row_pt[contactPerusahaan]
																			</td>
																		</tr>
																	<tr>
																		<td></td>
																		<td width=\"25\">
																			<img src=\"./imagea/email.ico\" width=\"16\" height=\"16\">
																			</td>
																		<td style=\"padding-bottom: 5px;\">
																			$row_pt[emailPerusahaan]
																			</td>
																		</tr>
																	</table>";																
															}
														}														
											$isi_2.="	</div>
													<div style=\"padding-bottom: 100px;\">";														
															$sql_cs="SELECT * FROM owner";
															$query_cs=mysql_query($sql_cs,opendb())or die(mysql_error());
															if($query_cs != null) {
																if(mysql_num_rows($query_cs)>0) {
																$isi_2.="	<table align=\"center\" width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
																				<tr>
																					<td width=\"60\">
																						<img src=\"./imagea/cs2.ico\" width=\"48\" height=\"48\">
																						</td>
																					<td colspan=\"2\" style=\"padding-top: 20px;\">
																						<font style=\"color: #$TRIP;\" size=4>Customer Service
																						<hr>
																						</td>
																					</tr>";
																	while($row_cs=mysql_fetch_array($query_cs)) {
																		$isi_2 .="<tr>
																					<td></td>
																					<td width=\"25\">
																						<img src=\"./imagea/cs1.ico\" width=\"16\" height=\"16\">
																						</td>
																					<td style=\"padding-bottom: 5px;\">
																						Nama: $row_cs[namaOwner]<br>Email: $row_cs[emailOwner]<br>Contact: $row_cs[contactOwner]
																						</td>
																					</tr>";
																	}
																}
															}															
												$isi_2.="	</table>
														</div>";
											break;
										case 'belanja': 
											$title="::$JUDUL | Halaman Panduan Belanja::";
											$isi_2.="<div>
														<font color=blue size=2><b><u>Cara Belanja:</u></b></font><br>
														Untuk dapat berbelanja di toko online kami, Anda harus menjadi pelanggan kami terlebih dahulu dengan cara mengisi formulir pendaftaran.<br>
														<div style=\"padding-left: 10px;\">
														<table align=center>
															<tr>
																<td>-
																	</td>
																<td>Setelah daftar, Anda akan mendapatkan username dan password yang akan digunakan untuk login.
																	</td>
																</tr>
															<tr>
																<td>-
																	</td>
																<td>Silahkan Anda login pada form yang sudah disediakan menggunakan username dan password yang sudah terdaftar.
																	</td>
																</tr>
															<tr>
																<td>-
																	</td>
																<td>Setelah proses login berhasil, Anda dapat memulai berbelanja di toko kami dengan memilih produk kami.
																	</td>
																</tr>
															<tr>
																<td>-
																	</td>
																<td>Pastikan barang yang Anda beli dengan Deskripsi : <font color=blue>Ready</font>, jika <font color=blue>Kosong</font> maka Anda belum bisa memesannya jadi menunggu stock ada. 
																	</td>
																</tr>
															<tr>
																<td>-
																	</td>
																<td>Untuk memasukkan produk ke dalam keranjang belanja, pilih link <font color=blue>AddToCart</font>.
																	</td>
																</tr>
															<tr>
																<td>-
																	</td>
																<td>Setelah Anda selesai memilih produk yang akan dibeli, silahkan klik menu Kantong Belanja atau gambar icon keranjang belanja di pojok kanan atas untuk proses <font color=blue>Check Out</font>.
																	</td>
																</tr>
															<tr>
																<td>-
																	</td>
																<td>Setelah proses <font color=blue>Check Out</font>, Anda diminta mengikuti langkah-langkah yang tersedia sampai proses Finish.
																	</td>
																</tr>
															<tr>
																<td>-
																	</td>
																<td>Setelah Finish, pemesanan Anda masih terpending dan belum keluar berapa uang yang harus Anda bayar karena masih harus menunggu Admin untuk menentukan ongkos kirim sesuai dengan jarak pengiriman.
																	</td>
																</tr>
															<tr>
																<td>-
																	</td>
																<td>Setelah Ongkos kirim terset, silahkan Anda membuka menu <font color=blue>Pemesanan</font> untuk melihat berapa jumlah uang yang harus Anda transfer.
																	</td>
																</tr>
															<tr>
																<td>-
																	</td>
																<td>Detail transaksi silahkan cek di menu <font color=blue>Pemesanan</font> pada account Anda di web site kami.
																	</td>
																</tr>
															</table></div>
														</div>";
											break;
										case 'bayar': 
											$title="::$JUDUL | Halaman Panduan Pembayaran::";
											$isi_2.="<div>
														<font color=blue size=2><b><u>Cara Pembayaran:</u></b></font>														
														<div style=\"padding-left: 10px;\">
														<table align=center>
															<tr>
																<td>-
																	</td>
																<td>Pembayaran ditransfer ke nomor rekening yang Anda pilih waktu proses <font color=blue>Check Out</font>.
																	</td>
																</tr>
															<tr>
																<td>-
																	</td>
																<td>Jangan lupa, sertakan <font color=blue>tiga digit angka unik</font> waktu transfer uang.
																	</td>
																</tr>
															<tr>
																<td>-
																	</td>
																<td>Anda hanya dibenarkan mentransfer jumlah uang sesuai dengan yang tertulis pada menu <font color=blue>Pemesanan</font>.
																	</td>
																</tr>
															<tr>
																<td>-
																	</td>
																<td>Setelah Anda mentransfer, silahkan konfirmasikan pembayaran Anda melalui menu <font color=blue>Konfirmasi</font> dan atau menghubungi Customer Service kami.
																	</td>
																</tr>
															<tr>
																<td>-
																	</td>
																<td>Apabila jumlah transfer Anda sudah sesuai dengan data yang ada di rekening kami dan sesuai dengan jumlah uang yang semestinya harus ditransfer, maka pesanan Anda akan segera kami kirim ke alamat yang sudah Anda tentukan.
																	</td>
																</tr>
															<tr>
																<td>-
																	</td>
																<td>Ketidak akuratan data akan menyebabkan lambatnya pemrosesan transaksi.
																	</td>
																</tr>
															<tr>
																<td>-
																	</td>
																<td>Detail transaksi bisa dicek di menu <font color=blue>Pemesanan</font> pada account Anda di web site kami.
																	</td>
																</tr>
															<tr>
																<td>-
																	</td>
																<td>Untuk <font color=blue>Konfirmasi</font> bisa melalui web site atau melalui SMS dengan menyertakan No Faktur.
																	</td>
																</tr>
															</table></div>
														</div>";
											break;
										case 'kirim': 
											$title="::$JUDUL | Halaman Panduan Ongkos Kirim::";
											$isi_2.="<div>
														<font color=blue size=2><b><u>Biaya Pengiriman:</u></b></font>														
														<div style=\"padding-left: 10px;\">
														<table align=center>
															<tr>
																<td>-
																	</td>
																<td>Biaya pengiriman akan disesuaikan dengan jarak pengiriman barang itu sendiri. Biaya pengiriman akan diset secara manual oleh Administrator kami. 
																	</td>
																</tr>
															<tr>
																<td>-
																	</td>
																<td>Selama biaya pengiriman belum diset oleh Administrator kami, maka Anda belum diperkenankan untuk mentransfer uang. 
																	</td>
																</tr>
															<tr>
																<td>-
																	</td>
																<td>Detail transaksi silahkan cek di menu <font color=blue>Pemesanan</font> pada account Anda di web site kami.
																	</td>
																</tr>
															</table></div>
														</div>";
										break;
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
				//generate ulang ID Session
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
				$token="?token=".$_SESSION['ASTA_HASH'];
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
							
				$katalog->setMenuAtas($menuAtas);
				$katalog->setArrayMenu($arrayMenu);
				$katalog->setLinkLogout($isiLink);		
				
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
	$katalog->setTitle($title);
	$katalog->setIsi_2($isi_2);
	$katalog->getTampilkan();
?>