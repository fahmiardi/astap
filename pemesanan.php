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
				//generate ulang ID Session
				session_id();
				if(!empty($_SESSION)) {
					session_regenerate_id(true);
				}
				//content
				$title="::$JUDUL | Halaman Pemesanan::";
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
				$isi_2="<tr>
							<td colspan=\"2\" valign=\"top\" style=\"padding-top: 10px;\">
								<table cellpadding=\"0\" cellspacing=\"0\" align=\"center\" bgcolor=\"#$TRIP\" width=\"100%\">
									<tr bgcolor=\"#$BACK\">
										<td vailgn=\"top\"> 
											<div style=\"background-color: #$TRIP; width:162px; text-align: center;  font-family: tahoma; font-size: 13px; font-weight: bold; color: #$TEXT;\">Tabel Pemesanan</div>
											<div style=\"border: 1px solid #$TRIP; padding: 10px 10px 10px 10px;\" id=\"content\">
												<table cellpadding=\"2\" cellspacing=\"0\" align=\"center\" bgcolor=\"#364b1a\" width=\"100%\">";
												$un=$_SESSION['ASTA_USERNAME'];
												$pass=$_SESSION['ASTA_PASSWORD'];
												$sql_show="	SELECT D.noFaktur, M.tgl, M.idStatusPesan, D.idProduk, M.ongkosKirim, M.jmlhBayar 
															FROM pelanggan P, pemesanan M, detpemesanan D, username U 
															WHERE D.noFaktur=M.noFaktur 
															AND M.idPelanggan=P.idPelanggan 
															AND P.idUser=U.idUser 
															AND U.username='$un' 
															AND U.password='$pass' 
															GROUP BY D.noFaktur 
															ORDER BY D.idDetPemesanan DESC";
												$query_show=mysql_query($sql_show,opendb())or die(mysql_error());
												if($query_show != null) {
													if(mysql_num_rows($query_show)>0) {
										$isi_2.="	<tr>
															<td class=\"cart\" width=\"8%\" style=\"color: #ffffff;\"><b>No</b></td>
															<td class=\"cart\" width=\"20%\" style=\"color: #ffffff;\"><b>No. Tiket</b></td>
															<td class=\"cart\" width=\"20%\" style=\"color: #ffffff;\"><b>Tanggal</b></td>
															<td class=\"cart\" width=\"40%\" style=\"color: #ffffff;\"><b>Status</b></td>
															<td class=\"cart\" style=\"color: #ffffff;\"><b>Detail</b></td>
															</tr>";
														$i=1;
														$j=0;
														while($row_show=mysql_fetch_array($query_show)) {
															$idPesan=$row_show['idStatusPesan'];
															if($idPesan == 1) {
																$pes="Menunggu ongkos kirim";
																$warning="Silahkan Anda hubungi Customer Service kami untuk di-set ongkos kirim";
															}
															elseif($idPesan == 2) {
																$pes="Pesanan belum dibayar";
																$warning="Jangan lupa sertakan 3 digit angka unik di belakang untuk pembayaran. Kami tunggu...";
															}
															elseif($idPesan == 3) {
																$pes="Pesanan sudah dibayar";
																$warning="Barang pesanan Anda akan segera kami kirim";
															}
															elseif($idPesan == 4) {
																$pes="Pesanan sudah dikirim";
																$warning="Terima kasih Anda sudah membeli produk kami";
															}
															else {
																$pes="Pesanan bermasalah";
															}
															
															if($j==0) {
																$bg="#b08903";
																$j++;
															}
															else {
																$bg="#b29739";
																$j--;
															}
													$isi_2 .="	<tr bgcolor=\"$bg\">
																	<td class=\"cart\" style=\"color: #364b1a;\">$i</td>
																	<td class=\"cart\" style=\"color: #364b1a;\"><b>$row_show[noFaktur]</b></td>
																	<td class=\"cart\" style=\"color: #364b1a;\">$row_show[tgl]</td>
																	<td class=\"cart\" style=\"color: #364b1a;\">$pes</td>
																	<td class=\"cart\" style=\"color: #364b1a;\">
																		<div class=\"tab\"></div>
																		<div class=\"tab\"><a href=\"#detail\"><img src=\"./imagea/right.ico\" width=\"16\" height=\"16\"></a></div>																		
																		</td>
																	</tr>
																<tr>
																	<td colspan=\"5\">
																		<div class=\"boxholder\" style=\"border: 0; background-color: #364b1a;\">
																			<div class=\"box\"></div>
																			<div class=\"box\" style=\"padding: 0 10px 0 10px;\">
																				<div style=\"text-align: center; font-size: 10px; padding-bottom: 10px; font-family: tahoma; color: #ffffff;\"><i>Data Pesanan</i></div>
																				<div style=\"padding-bottom: 10px;\">
																					<table cellpadding=\"0\" cellspacing=\"0\" align=\"center\" bgcolor=\"#364b1a\" width=\"100%\">
																						<tr bgcolor=\"#364b1a\">
																							<td class=\"cart\" width=\"8%\" style=\"color: #ffffff;\"><b>No</b></td>
																							<td class=\"cart\" width=\"\" style=\"color: #ffffff;\"><b>Nama Produk</b></td>
																							<td class=\"cart\" width=\"8%\" style=\"color: #ffffff;\"><b>Qty</b></td>
																							<td class=\"cart\" width=\"20%\" style=\"color: #ffffff;\"><b>Harga</b></td>
																							<td class=\"cart\" width=\"20%\" style=\"color: #ffffff;\"><b>Total</b></td>
																							</tr>";
																						$sql_detShow="	SELECT P.namaProduk, P.hargaProduk, D.jumlah, D.totalBayar 
																										FROM produk P, detpemesanan D 
																										WHERE D.noFaktur='$row_show[noFaktur]' 
																										AND P.idProduk=D.idProduk";
																						$query_detShow=mysql_query($sql_detShow)or die(mysql_error());
																						if($query_detShow != null) {
																							if(mysql_num_rows($query_detShow)>0) {
																								$no=1;
																								$a=0;
																								while($row_detShow=mysql_fetch_array($query_detShow)) {																								
																									if($a==0) {
																										$col="#b29739";
																										$a++;
																									}
																									else {
																										$col="#b08903";
																										$a--;
																									}																									
																									$isi_2 .= "	<tr bgcolor=\"$col\">
																													<td class=\"cart\" style=\"color: #000000;\">$no</td>
																													<td class=\"cart\" style=\"color: #000000;\">$row_detShow[namaProduk]</td>
																													<td class=\"cart\" style=\"color: #000000;\">$row_detShow[jumlah]</td>
																													<td class=\"cart\" style=\"color: #000000;\">$row_detShow[hargaProduk]</td>
																													<td class=\"cart\" style=\"color: #000000;\">$row_detShow[totalBayar]</td>
																													</tr>";
																									$no++;
																								}																								
																							}
																						}
																						$ongkos=$row_show['ongkosKirim'];
																						$trf=$row_show['jmlhBayar'];
																			$isi_2 .= "	<tr bgcolor=\"#364b1a\">
																							<td colspan=\"4\" style=\"text-align: right;\" valign=\"top\">
																								<div style=\"color: #ffffff;\">Ongkos Kirim : </div>
																								<div style=\"color: #ffffff;\">Jumlah yang harus Anda Transfer : </div>
																								</td>
																							<td valign=\"top\">
																								<div style=\"color: #ffffff;\">$ongkos</div>
																								<div style=\"font-size: 12px; font-weight: bold; color: white;\">$trf</div>
																								</td>																													
																							</tr>
																						</table>
																						<div style=\"padding-top: 10px; text-align: center; color: #ffffff;\">
																							<i>$warning</i>
																							</div>
																					</div>
																				</div>
																			</div>
																		</td>
																	</tr>";
															$i++;
														}
													}
													else {
														$isi_2.="<tr bgcolor=\"#$BACK\"><td colspan=\"5\" align=\"center\">Anda belum pernah melakukan pemesanan.</td></tr>";
													}
												}
													
									$isi_2 .="		</table>
												</div>													
											</td>
										</tr>
									</table>
								</td>
							<tr>";
				
				$pemesanan = new Pelanggan();
				$pemesanan->setTitle($title);
				$pemesanan->setLinkLogout($isiLink);
				$pemesanan->setMenuAtas($menuAtas);
				$pemesanan->setArrayMenu($arrayMenu);
				$pemesanan->setIsi_2($isi_2);
				$pemesanan->getTampilkan();
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