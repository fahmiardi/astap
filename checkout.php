<?php	
	header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
	header('Cache-Control: no-store, no-cache, must-revalidate');
	header('Cache-Control: post-check=0, pre-check=0, false');
	
	session_start();
	include_once "./library/kelasPelanggan.php";
	include_once "./include/functions.php";	
	include_once "./include/functions-cart.php";
	
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
				$title="::$JUDUL| Check Out::";
				$isiLink="<tr><td><a href=\"index2.php?act=logout&token=$_SESSION[ASTA_HASH]\" class=\"menuItem\" alt=\"Logout\" title=\"Logout\"><div class=\"break\">Logout</div></a></td></tr>";
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
				$menuAtas=array("index1.php$token"=>'Home',"contact.php$token"=>'Contact',"viewCart.php$token"=>$item);
								
				$isi_2="<tr>
							<td colspan=\"2\" style=\"padding-top: 10px;\">
								<table cellpadding=\"0\" cellspacing=\"0\" align=\"center\" bgcolor=\"#$TRIP\" width=\"100%\">
									<form action=\"$_SERVER[PHP_SELF]?token=$_SESSION[ASTA_HASH]\" method=\"POST\">
									<tr bgcolor=\"#$BACK\">
										<td vailgn=\"top\"> 
											<div style=\"background-color: #$TRIP; width:162px; text-align: center; font-family: tahoma; font-size: 13px; font-weight: bold; color: #$TEXT;\">Pemesanan</div>
											<div style=\"border: 1px solid #$TRIP; padding: 10px 10px 10px 10px;\">";
												if(isset($_POST['step2']) && $_POST['idAlamat'] != "") {
													$title="::$JUDUL | Step 2 of 3::";
													$idAlamat=(int)$_POST['idAlamat'];
													if($idAlamat == "1") {
														$_SESSION['idAlamat']=(string)$idAlamat;
													}
													elseif($idAlamat == "2" && $_POST['alamatLain'] != "") {
														$alamatLain=filter($_POST['alamatLain']);
														$_SESSION['idAlamat']=(string)$idAlamat;
														$_SESSION['alamatLain']=(string)$alamatLain;
													}
													$isi_2 .= "	<div style=\"text-align: center; padding-bottom: 10px;\"><b>Step 2 of 3</b></div>
																<div>
																	<div>Silahkan pilih Bank yang kami miliki yang akan Anda transfer untuk pembayaran :</div>
																	<div style=\"padding-left: 20px; padding-top: 10px;\">
																		<div>";
																			opendb();
																			$sql_bank="SELECT * FROM bank";
																			$query_bank=mysql_query($sql_bank,opendb())or die(mysql_error());
																			if($query_bank != null) {
																				if(mysql_num_rows($query_bank)> 0) {
																					while($row_bank=mysql_fetch_array($query_bank)) {
																						$isi_2 .= "	<div><input type=\"radio\" name=\"idBank\" value=\"$row_bank[idBank]\" checked><b>$row_bank[namaBank]</b></div>
																									<div style=\"padding: 0 0 5px 21px;\">
																										<div>No. Rekening : <b>$row_bank[noRekBank]</b></div>
																										<div>Pemilik : $row_bank[namaPemilik]</div>
																										<div>Cabang : $row_bank[cabang]</div>
																									</div>";
																					}
																				}	
																				else {
																					//kosong
																				}
																			}
																			closedb();
																$isi_2 .="	</div>
																		<div style=\"padding: 10px 0 0 0;\"><input type=\"submit\" name=\"step3\" value=\"Finish\" class=\"ctombol\" style=\"text-align: center; width: 100px;\"></div>
																		</div>
																	</div>";
												}
												elseif(isset($_POST['step3'])) {
													$title="::$JUDUL | Step 3 of 3::";
													if(isset($_POST['idBank'])) {
														$idBank=(int)$_POST['idBank'];
														$_SESSION['idBank']=(string)$idBank;														
														$noFak=randomFaktur();
														//memasukkan data pesanan ke dalam database
														opendb();
														$sql_check="SELECT ct_token FROM cart WHERE ct_token='$_SESSION[ASTA_HASH]'";
														$query_check=mysql_query($sql_check,opendb())or die(mysql_error());
														if($query_check != null) {
															if(mysql_num_rows($query_check) > 0) {
																$un=$_SESSION['ASTA_USERNAME'];
																$pass=$_SESSION['ASTA_PASSWORD'];
																$sql_user="	SELECT idUser 
																			FROM username 
																			WHERE username='$un' 
																			AND password='$pass'";
																$query_user=mysql_query($sql_user,opendb())or die(mysql_error());
																if($query_user != null) {
																	if(mysql_num_rows($query_user) == 1) {
																		$row_user=mysql_fetch_array($query_user);
																		$sql_pelanggan="SELECT idPelanggan 
																						FROM pelanggan 
																						WHERE idUser='$row_user[idUser]'";
																		$query_pelanggan=mysql_query($sql_pelanggan,opendb())or die(mysql_error());
																		if($query_pelanggan != null) {
																			if(mysql_num_rows($query_pelanggan) == 1) {
																				$row_pelanggan=mysql_fetch_array($query_pelanggan);
																				$idPelanggan=$row_pelanggan['idPelanggan'];
																				if($_SESSION['idBank'] != "" && $_SESSION['idBank'] > "0" && $_SESSION['idAlamat'] != "" && $_SESSION['idAlamat'] > "0") {
																					$bank=(int)$_SESSION['idBank'];
																					$alamat=(int)$_SESSION['idAlamat'];
																					$alamatLain=$_SESSION['alamatLain'];
																				}
																				$sql_cek="SELECT noFaktur FROM pemesanan WHERE noFaktur='$noFak'";
																				$query_cek=mysql_query($sql_cek,opendb())or die(mysql_error());
																				if($query_cek != null) {
																					if(mysql_num_rows($query_cek) > 0) {
																						while($row_cek=mysql_fetch_array($query_cek)) {
																							if($row_cek['noFaktur']==$noFak) {
																								$faktur=randomFaktur();
																							}
																							else {
																								$faktur=$noFak;
																							}
																						}
																					}
																					else {
																						$faktur=$noFak;
																					}
																					$tgl=tglDB();
																					if($alamat==1) {
																						$alLa="";
																					}
																					else {
																						$alLa=$alamatLain;
																					}
																					$sql_insPesan="	INSERT INTO pemesanan 
																									VALUES(	'$faktur',
																											'$idPelanggan',
																											'$tgl',
																											'-',
																											'$alamat',
																											'1',
																											'$alLa',
																											'$bank',
																											'')";
																					$query_insPesan=mysql_query($sql_insPesan,opendb())or die(mysql_error());
																					$sql_kantong="SELECT * FROM cart WHERE ct_token='$_SESSION[ASTA_HASH]'";
																					$query_kantong=mysql_query($sql_kantong,opendb())or die(mysql_error());
																					if($query_kantong != null) {																						
																						if(mysql_num_rows($query_kantong)>0) {
																							while($row_kantong=mysql_fetch_array($query_kantong)) {
																								$sql_prod="SELECT hargaProduk FROM produk WHERE idProduk='$row_kantong[idProduk]'";
																								$query_prod=mysql_query($sql_prod,opendb())or die(mysql_error());
																								$row_prod=mysql_fetch_array($query_prod);
																								$totByr=($row_kantong['qty']*$row_prod['hargaProduk']);
																								$sql_detPes="	INSERT INTO detpemesanan 
																												VALUES(	'',
																														'$faktur',
																														'$row_kantong[idProduk]',
																														'$row_kantong[qty]',
																														'$totByr')";
																								$query_detPes=mysql_query($sql_detPes,opendb())or die(mysql_error());
																							}
																						}
																					}
																					if($query_insPesan && $query_detPes) {
																						emptyCart($_SESSION['ASTA_HASH']);
																						$isi_2 .= "	<div style=\"text-align: center; padding-bottom: 10px;\"><b>Step 3 of 3</b></div>
																									<div style=\"padding: 5px 10px 10px 10px;\">
																										<div style=\"text-align: center; font-size: 12px;\">Terima kasih Anda sudah berbelanja di toko kami.</div>
																										<div style=\"text-align: center; font-size: 12px;\">Silahkan kontak Customer Service kami.</div>
																										<div style=\"text-align: center; font-size: 12px;\">Gunakan No. Tiket : <b><font style=\"color: #$TRIP;\">$faktur</font></b> untuk verifikasi.</div>																																																				
																										<div style=\"padding-top: 20px;text-align: center;\">Customer Service kami akan men-set ongkos kirim pesanan. Dan beberapa saat setelah ongkos kirim di-set.</div>
																										<div style=\"text-align: center;\">Informasi selengkapnya tentang history pesanan dan status pesanan dapat Anda lihat di menu <a href=\"pemesanan.php?token=$_SESSION[ASTA_HASH]\"><b><font color=\"#$TEXT\">Pemesanan</b></a>.</div>
																										</div>";
																					}
																				}
																			}
																		}
																	}
																}
															}
															else {
																header("Location: viewCart.php?token=$_SESSION[ASTA_HASH]");
																exit();
															}
														}
														else {
															header("Location: viewCart.php?token=$_SESSION[ASTA_HASH]");
															exit();
														}
													}
													else {
														$isi_2 .= "	<div style=\"text-align: center; padding-bottom: 10px;\"><b>Step 2 of 3</b></div>
																<div>
																	<div>Silahkan pilih Bank yang kami miliki yang akan Anda transfer untuk pembayaran :</div>
																	<div style=\"padding-left: 20px; padding-top: 10px;\">
																		<div>";
																			opendb();
																			$sql_bank="SELECT * FROM bank";
																			$query_bank=mysql_query($sql_bank,opendb())or die(mysql_error());
																			if($query_bank != null) {
																				if(mysql_num_rows($query_bank)> 0) {
																					$i=0;
																					while($row_bank=mysql_fetch_array($query_bank)) {																																											
																						$isi_2 .= "	<div><input type=\"radio\" name=\"idBank\" value=\"$row_bank[idBank]\"><b>$row_bank[namaBank]</b></div>
																									<div style=\"padding: 0 0 5px 21px;\">
																										<div>No. Rekening : <b>$row_bank[noRekBank]</b></div>
																										<div>Pemilik : $row_bank[namaPemilik]</div>
																										<div>Cabang : $row_bank[cabang]</div>
																									</div>";
																						$i++;
																					}
																				}	
																				else {
																					//kosong
																				}
																			}
																			closedb();
																$isi_2 .="	</div>
																		<div style=\"padding: 10px 0 0 0;\"><input type=\"submit\" name=\"step3\" value=\"Finish\" class=\"ctombol\" style=\"text-align: center; width: 100px;\"></div>
																		</div>
																	</div>";
													}
												}
												else {
													$title="::$JUDUL | Step 1 of 3::";
													$isi_2 .= "	<div style=\"text-align: center; padding-bottom: 10px;\"><b>Step 1 of 3</b></div>
																<div>																	
																	<div>Silahkan pilih alamat yang digunakan untuk pengiriman :</div>
																	<div><br>1. Jika memilih <b>'Alamat Tetap'</b> maka alamat pengiriman memakai alamat ketika registrasi<br>
																					2. Jika Anda menghendaki alamat berbeda, silahkan pilih <b>'Alamat Lain'</b>.</div>
																	<div id=\"contact-area\" style=\"padding-left: 20px; padding-top: 10px;\">
																		<div><input type=\"radio\" name=\"idAlamat\" value=\"1\" checked>Alamat Tetap</div>
																		<div style=\"vertical-align: top;\"><input type=\"radio\" name=\"idAlamat\" value=\"2\" style=\"vertical-align: top;\"><span style=\"vertical-align: top;\">Alamat Lain :</span>
																			<textarea name=\"alamatLain\" style=\"width: 250px; height: 100px;\"></textarea></div>
																		<div style=\"padding: 10px 0 0 0;\"><input type=\"submit\" name=\"step2\" value=\"Lanjutkan\" class=\"ctombol\" style=\"text-align: center; width: 100px;\"></div>
																		</div>																	
																	</div>";
												}
									$isi_2.="	</div>";
											
								$isi_2 .="	</td>
										</tr>
										</form>
									</table>
								</td>
							<tr>";
				
				$checkout = new Pelanggan();
				$checkout->setTitle($title);
				$checkout->setLinkLogout($isiLink);
				$checkout->setMenuAtas($menuAtas);
				$checkout->setArrayMenu($arrayMenu);
				$checkout->setIsi_2($isi_2);
				$checkout->getTampilkan();
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
		header("Location: index1.php");
	}
?>