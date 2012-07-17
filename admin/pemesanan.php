<?php
	header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
	header('Cache-Control: no-store, no-cache, must-revalidate');
	header('Cache-Control: post-check=0, pre-check=0, false');
	
	session_start();
	include_once "./library/kelasAdmin.php";
	include_once "./include/functions.php";
	include_once "./include/functions-cart.php";
	
	if(isset($_SESSION['ASTA_ADM_HASH'])) {
		if($_SESSION['ASTA_ADM_HASH'] == $_GET['token']) {
			if(!authAdmin($_SESSION['ASTA_ADM_USERNAME'], $_SESSION['ASTA_ADM_PASSWORD'])) {
				unset($_GET['token']);
				unset($_SESSION['ASTA_ADM_USERNAME']);
				unset($_SESSION['ASTA_ADM_PASSWORD']);
				unset($_SESSION['ASTA_ADM_HASH']);
				unset($_SESSION['ASTA_ADM_TIMESTAMP']);
				unset($_SESSION['ASTA_ADM_TOKEN']);
				session_destroy();
				header("Location: index.php?naughty");
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
				
				//content2
				$title="::$JUDUL | Tabel Pemesanan::";
				$isiLink="<tr><td><a href=\"index2.php?act=logout&token=$_SESSION[ASTA_ADM_HASH]\" class=\"menuItem\" alt=\"Logout\" title=\"Logout\"><div class=\"break\">Logout</div></a></td></tr>";
				$token="?token=".$_SESSION['ASTA_ADM_HASH'];
				$arrayMenu=array("informasi.php$token&opt=about"=>'Tentang Kami',"pemesanan.php$token"=>'Pemesanan',"viewCart.php$token"=>'Kantong Belanja',"katalog.php$token"=>'Katalog',"konfirm.php$token"=>'Konfirmasi',"myAccount.php$token"=>'My Account');
				
				$konten="<tr>
						<td colspan=\"2\" style=\"padding: 10px 10px 10px 10px;\" align=\"center\" width=\"100%\">	
							<div align\"center\" style=\"font-size: 15px; font-weight: bold; padding-bottom: 10px; width:100%;\">Pemesanan</div>
							<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\" align=\"center\">
								<tr>
									<td>
										<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">
											<tr>";
											$menu=array ('Pending' => "&token=$_SESSION[ASTA_ADM_HASH]",'New' => "&token=$_SESSION[ASTA_ADM_HASH]",'Paid' => "&token=$_SESSION[ASTA_ADM_HASH]",'Shipped' => "&token=$_SESSION[ASTA_ADM_HASH]");
											@$page=(string)$_GET['page'];
											foreach($menu as $key=>$val) {
												if($key===$page) {
													$konten .= "	<td width=\"25%\" align='center' height=\"24\">
																	<div>
																		<a style=\"cursor: pointer; text-decoration: none;\" href='pemesanan.php?page=$key$val' class='menuKiri'><div style=\"background: url(./imagea/tab2.jpg); height: 23px;\"><div style=\"padding-top: 4px;\"><font color='#ffffff' style=\"padding-top: 20px;\">$key</font></div></div></a>
																		</div>
																	</td>";
												}
												else {
													$konten .= "	<td align='center' width=\"25%\" height=\"24\">
																	<div>
																		<a style=\"cursor: pointer; text-decoration: none;\" href='pemesanan.php?page=$key$val' class='menuKiri'><div style=\"background: url(./imagea/tab.jpg); height: 24px;\"><div style=\"padding-top: 4px;\"><font color='#ffffff'>$key</font></div></div></a>
																		</div>
																	</td>";
												}
											}
								$konten.="		</tr>
											</table>
										<div style=\"width:100%; background: url(./imagea/trip.jpg); height: 10px;\">";
												if(isset($_POST['up'])) {
													$faktur=$_POST['noTik'];
													$idPes=(int)$_POST['naik'];
													
													if($idPes==3) {
														$sql_stok="	SELECT D.idProduk, P.namaProduk, P.stockProduk, D.jumlah 
																	FROM produk P, detpemesanan D 
																	WHERE P.idProduk=D.idProduk 
																	AND D.noFaktur='$faktur'";
														$query_stok=mysql_query($sql_stok,opendb())or die(mysql_error());
														if($query_stok != null) {
															if(mysql_num_rows($query_stok)>0) {
																while($row_stok=mysql_fetch_array($query_stok)) {
																	if($row_stok['stockProduk']==0) {
																		$warning="	<div><i><font style=\"padding-bottom: 10px; font-size: 13px; font-weight: bold;\">Maaf!</font></i></div>
																					<div>ID PRODUK: <b>$row_stok[idProduk]</b></div>
																					<div>NAMA PRODUK: $row_stok[namaProduk]</div>
																					<div>Stocknya habis. Transaksi dengan No. Tiket <b>$faktur</b> dipending.</div>";
																		$exe=false;
																		break;
																	}
																	else {
																		$exe=true;
																		$isi[]="$row_stok[idProduk]/$row_stok[stockProduk]/$row_stok[jumlah]";
																		$cek=$row_stok['stockProduk']-$row_stok['jumlah'];
																		if($cek<0) {
																			$warning="	<div><i><font style=\"padding-bottom: 10px; font-size: 13px; font-weight: bold;\">Maaf!</font></i></div>
																						<div>ID PRODUK: <b>$row_stok[idProduk]</b></div>
																						<div>NAMA PRODUK: $row_stok[namaProduk]</div>
																						<div>Stocknya lebih sedikit daripada pesanan.</div>
																						<div>Transaksi dengan No. Tiket <b>$faktur</b> dipending.</div>";
																			$exe=false;
																			break;
																		}
																	}
																}
																if($exe) {
																	$sql_na="	UPDATE pemesanan 
																				SET idStatusPesan='$idPes' 
																				WHERE noFaktur='$faktur'";
																	mysql_query($sql_na,opendb())or die(mysql_error());
																	foreach($isi as $kon) {
																		$ekstrak=explode("/",$kon);
																		$stok=$ekstrak[1]-$ekstrak[2];
																		$sql_upStok="	UPDATE produk 
																						SET stockProduk='$stok' 
																						WHERE idProduk='$ekstrak[0]'";
																		mysql_query($sql_upStok,opendb())or die(mysql_error());
																	}
																}
															}
														}
													}
													else {
														$sql_na="	UPDATE pemesanan 
																	SET idStatusPesan='$idPes' 
																	WHERE noFaktur='$faktur'";
														mysql_query($sql_na,opendb())or die(mysql_error());
													}
												}
												if(isset($_POST['ongkir'])) {
													if($_POST['ongkos'] != "") {
														if(is_Numeric($_POST['ongkos'])) {
															$ongkir=$_POST['ongkos'];
															$tik=$_POST['noTiket'];
															$sql_itung="SELECT totalBayar 
																		FROM detpemesanan 
																		WHERE noFaktur='$tik'";
															$query_itung=mysql_query($sql_itung,opendb())or die(mysql_error());
															if($query_itung != null) {
																if(mysql_num_rows($query_itung)>0) {
																	while($row_itung=mysql_fetch_array($query_itung)) {
																		$totByr += $row_itung['totalBayar'];
																	}
																	$source="0123456789";
																	srand((float) microtime() * 10000000);
																	$rand=substr(str_shuffle($source),0,3);
																	$tot=$totByr+$ongkir;
																	$jmlhByr=$tot+$rand;															
																	$sql_update="	UPDATE pemesanan 
																					SET ongkosKirim='$ongkir', idStatusPesan='2', jmlhBayar='$jmlhByr' 
																					WHERE noFaktur='$tik'";
																	mysql_query($sql_update,opendb())or die(mysql_error());
																}
															}
														}
													}
												}
												if(isset($_GET['opt'])) {
													if($_GET['opt']!="") {
														if($_GET['opt']=="del") {
															$sql_del1="DELETE FROM pemesanan WHERE noFaktur='$_GET[tiket]'";
															mysql_query($sql_del1,opendb())or die(mysql_error());
															$sql_del2="DELETE FROM detpemesanan WHERE noFaktur='$_GET[tiket]'";
															mysql_query($sql_del2,opendb())or die(mysql_error());
														}
													}
												}
												if(isset($_GET['page'])) {
													$sql_pesan="SELECT 	M.noFaktur, M.tgl, M.ongkosKirim, M.idPengiriman, M.idStatusPesan, M.alamatLain, M.jmlhBayar, 
																		L.namaPelanggan, L.alamatPelanggan, L.kota, L.propinsi, L.kodePos, L.email, L.phone, 
																		B.namaBank 
																FROM pelanggan L, pemesanan M, bank B 
																WHERE M.idPelanggan=L.idPelanggan 
																AND M.idBank=B.idBank ";
													if($_GET['page']=="Pending") {
														$sql_pesan .="AND M.idStatusPesan='1' ";
														function img1($tiket) {
															$img="	<a href=\"#detail\" title=\"Detail\" alt=\"Detail\"><img src=\"./imagea/right.ico\" width=\"16\" height=\"16\"></a>";
															return $img;
														}
													}
													elseif($_GET['page']=="New") {														
														$sql_pesan .="AND M.idStatusPesan='2' ";
														function img1($tiket) {
															$img="	<a href=\"$_SERVER[PHP_SELF]?page=$_GET[page]&opt=del&tiket=$tiket&token=$_SESSION[ASTA_ADM_HASH]\" title=\"Delete\" alt=\"Delete\" onClick=\"return confirm('Anda yakin akan menghapus?');\"><img src=\"./imagea/del.ico\" width=\"16\" height=\"16\"></a> | 
																	<a href=\"#detail\" title=\"Detail\" alt=\"Detail\"><img src=\"./imagea/right.ico\" width=\"16\" height=\"16\"></a>";
															return $img;
														}
													}
													elseif($_GET['page']=="Paid") {
														$sql_pesan .="AND M.idStatusPesan='3' ";
														function img1($tiket) {															
															$img="	<a href=\"#detail\" title=\"Detail\" alt=\"Detail\"><img src=\"./imagea/right.ico\" width=\"16\" height=\"16\"></a>";
															return $img;
														}
													}
													elseif($_GET['page']=="Shipped") {
														$sql_pesan .="AND M.idStatusPesan='4' ";
														function img1($tiket) {
															$img="	<a href=\"#detail\" title=\"Detail\" alt=\"Detail\"><img src=\"./imagea/right.ico\" width=\"16\" height=\"16\"></a>";
															return $img;
														}
													}
													else {
														
													}
													if(isset($_POST['query'])) {
														if($_POST['query']!="" && $_POST['query']!= "No. Tiket...") {
															$sql_pesan .="AND M.noFaktur='$_POST[query]' ";
														}
													}
													$sql_pesan .="ORDER BY M.tgl DESC";
												}
							$konten .="		</div>
										<div style=\"width:100%; background-color: #fa7631;\">
											<div style=\"padding: 5px 10px 10px 10px; color: black;\">
												
													<div>";
														if(isset($_GET['page'])) {
															$konten .="	<form id=\"cari\" action=\"$_SERVER[PHP_SELF]?page=$_GET[page]&token=$_SESSION[ASTA_ADM_HASH]\" method=\"POST\">";
															$konten .="		<input onblur=\"if(this.value=='') this.value='No. Tiket...';\" onfocus=\"if(this.value=='No. Tiket...') this.value='';\" type=\"text\" name=\"query\" value=\"No. Tiket...\" size=\"20\" style=\"border: 1px solid #ffffff; background-color: #CCCCCC;\"> <input type=\"submit\" name=\"submit\" value=\"Cari\" style=\"background-color: #fa7631; border: 1px solid #ffffff; cursor: pointer;\">";
															$konten .="		</form>";
															$konten .="$warning";
															if($_POST['query']!="" && $_POST['query']!="No. Tiket...") {
																$konten.="<i> <small>Anda mencari</small> <b>'$_POST[query]'</b></i>";
															}
															$query_pesan=mysql_query($sql_pesan,opendb())or die(mysql_error());
															if($query_pesan != null) {																
																if(mysql_num_rows($query_pesan)>0) {
															$konten .="	<div style=\"padding-top: 10px;\" id=\"content\">
																			<div class=\"tab\"></div>
																			<table cellpadding=\"1\" cellspacing=\"0\" width=\"100%\" align=\"center\" bgcolor=\"#364b1a\" border=\"0\">
																				<tr>
																					<td class=\"cart\" width=\"6%\" style=\"color: #ffffff;\"><b>No</b></td>
																					<td class=\"cart\" width=\"15%\" style=\"color: #ffffff;\"><b>No. Tiket</b></td>
																					<td class=\"cart\" width=\"15%\" style=\"color: #ffffff;\"><b>Tanggal</b></td>
																					<td class=\"cart\" width=\"\" style=\"color: #ffffff;\"><b>Pemesan</b></td>
																					<td class=\"cart\" width=\"35%\" style=\"color: #ffffff;\"><b>Aksi</b></td>
																					</tr>";
																	$no=1;
																	$j=0;
																	while($row_pesan=mysql_fetch_array($query_pesan)) {
																		if($j==0) {
																			$bg="#607c3c";
																			$j++;
																		}
																		else {
																			$bg="#9db085";
																			$j--;
																		}
																	$konten .="	<tr bgcolor=\"$bg\">
																					<td class=\"cart\" width=\"\">$no</td>
																					<td class=\"cart\" width=\"\">$row_pesan[noFaktur]</td>
																					<td class=\"cart\" width=\"\">$row_pesan[tgl]</td>
																					<td class=\"cart\" width=\"\">$row_pesan[namaPelanggan]</td>
																					<td class=\"cart\" width=\"\">";																						
																						if($_GET['page']!="Pending") {
																							if($_GET['page']!="") {
																								$sql_up="	SELECT * FROM statuspemesanan ";
																								if($_GET['page']=="New") {
																									$text="Paid";
																									$sql_up.="	WHERE idStatusPesan='3'";
																								}
																								else {
																									$text="Shipped";
																									$sql_up.="	WHERE idStatusPesan='4'";
																								}
																								$query_up=mysql_query($sql_up,opendb())or die(mysql_error());
																								if($query_up != null) {
																									if(mysql_num_rows($query_up)>0) {
																										$row_up=mysql_fetch_array($query_up);
																										if($_GET['page']!="Shipped") {
																											$plat="	<input type=\"hidden\" name=\"naik\" value=\"$row_up[idStatusPesan]\">
																													<input type=\"submit\" name=\"up\" value=\"UpTo$text\" class=\"ctombol\" style=\"text-align: center; padding: 0px;\">";
																										}
																									}
																								}
																								$form="	<div class=\"tab\" style=\"padding-top: 0px; text-align: left; margin: 0px;\">
																											<div class=\"tab\" style=\"padding-top:0px; text-align: left; margin: 0px;\">
																												<input type=\"hidden\" name=\"noTik\" value=\"$row_pesan[noFaktur]\">
																												".img1($row_pesan['noFaktur'])."&nbsp;&nbsp;								
																												$plat																												
																												</div>
																											</div>";
																							}
																							$konten .="	<form id=\"set\" action=\"$_SERVER[PHP_SELF]?page=$_GET[page]&token=$_SESSION[ASTA_ADM_HASH]\" method=\"POST\">
																											<table cellpadding=\"0\" cellspacing=\"0\" align=\"center\" border=\"0\" width=\"100%\">
																												<tr>
																													<td align=\"left\">$form</td>
																													</tr>
																												</table>																										
																											</form>";
																						}
																						else {																							
																							$konten .="	<form id=\"set\" action=\"$_SERVER[PHP_SELF]?page=$_GET[page]&token=$_SESSION[ASTA_ADM_HASH]\" method=\"POST\">
																											<table cellpadding=\"0\" cellspacing=\"0\" align=\"center\" border=\"0\" width=\"100%\">
																												<tr>
																													<td align=\"left\"><div class=\"tab\" style=\"padding-top: 0px; text-align: left; margin: 0px;\">
																														<div class=\"tab\" style=\"padding-top:0px; text-align: left; margin: 0px;\">
																															<input type=\"hidden\" name=\"noTiket\" value=\"$row_pesan[noFaktur]\">
																															".img1($row_pesan['noFaktur'])."
																															<input type=\"text\" name=\"ongkos\" value=\"Ongkos...\" size=\"13\" onblur=\"if(this.value=='') this.value='Ongkos...';\" onfocus=\"if(this.value=='Ongkos...') this.value='';\">
																															<input type=\"submit\" name=\"ongkir\" value=\"Set\" class=\"ctombol\" style=\"width: 30px; margin: 0px; padding-top: 0px;\">																														
																															</div>
																														</div>
																														</td>
																													</tr>
																												</table>																										
																											</form>";																							
																						}
																			$konten .="	</td>
																					</tr>";
																				$konten .="	<tr bgcolor=\"$bg\">
																							<td colspan=\"5\">
																								<div class=\"boxholder\" style=\"border: 0px; background-color: $bg;\">
																									<div class=\"box\" style=\"padding: 0px;\"></div>
																									<div class=\"box\" style=\"padding: 0px; background-color: $bg;\">";																										
																										if($row_pesan['idPengiriman']==1) {
																											$alamat="	<table cellpadding=\"1\" cellspacing=\"1\" align=\"center\" border=\"0\" width=\"100%\" bgcolor=\"$bg\">
																															<tr bgcolor=\"$bg\">
																																<td width=\"50%\" style=\"padding: 0 10px 0 10px;\" align=\"top\">
																																	<div style=\"padding-bottom: 10px;\"><i><b>Informasi Pengiriman</b></i></div>
																																	<div>Dikirim ke: </div>
																																	<div>Alamat: $row_pesan[alamatPelanggan]</div>
																																	<div>Kota: $row_pesan[kota]</div>
																																	<div>Propinsi: $row_pesan[propinsi]</div>
																																	<div>Kode Pos: $row_pesan[kodePos]</div>
																																	<div>Phone: $row_pesan[phone]</div>
																																	<div>Email: $row_pesan[email]</div>
																																	</td>
																																<td style=\"padding: 0 10px 0 10px;\" align=\"top\">
																																	<div style=\"padding-bottom: 10px;\"><i><b>Informasi Produk</b></i></div>
																																	<table width=\"100%\" cellpadding=\"2\" cellspacing=\"0\" border=\"0\" align=\"center\" bgcolor=\"$bg\">
																																		<tr bgcolor=\"$bg\">
																																			<td width=\"10%\">No</td>
																																			<td width=\"20%\">Kd Prd</td>
																																			<td width=\"\">Nama Prd</td>
																																			<td width=\"15%\">Qty</td>
																																			</tr>";
																																		$sql_prd="	SELECT P.idProduk, P.namaProduk, D.jumlah 
																																					FROM produk P, detpemesanan D 
																																					WHERE P.idProduk=D.idProduk 
																																					AND D.noFaktur='$row_pesan[noFaktur]'";
																																		$query_prd=mysql_query($sql_prd,opendb())or die(mysql_error());
																																		if($query_prd != null) {
																																			if(mysql_num_rows($query_prd)>0) {
																																				$idx=1;
																																				while($row_prd=mysql_fetch_array($query_prd)) {
																																					$alamat .="	<tr>
																																									<td width=\"10%\">$idx</td>
																																									<td width=\"20%\">$row_prd[idProduk]</td>
																																									<td width=\"\">$row_prd[namaProduk]</td>
																																									<td width=\"15%\">$row_prd[jumlah]</td>
																																									</tr>";
																																					$idx++;
																																				}
																																			}
																																		}
																																			
																															$alamat.="	</table>";
																																	if($_GET['page']!="Pending") {
																																		$alamat.="	<div style=\"padding: 10px 0px 10px 0px;\"><i><b>Informasi Transfer</b></i></div>
																																					<div align=\"center\">Uang yang harus di transfer adalah <font style=\"font-size: 15px;\"><b>$row_pesan[jmlhBayar]</b></font></div>
																																					<div>Menggunakan bank <b>$row_pesan[namaBank]</b></div>";
																																	}
																														$alamat.="	</td>
																																</tr>
																															</table>";
																										}
																										else {
																											$alamat="	<table cellpadding=\"1\" cellspacing=\"1\" align=\"center\" border=\"0\" width=\"100%\" bgcolor=\"$bg\">
																															<tr bgcolor=\"$bg\">
																																<td width=\"50%\" style=\"padding: 0 10px 0 10px;\" align=\"top\">
																																	<div style=\"padding-bottom: 10px;\"><i><b>Informasi Pengiriman</b></i></div>
																																	<div>Dikirim ke: $row_pesan[alamatLain]</div>
																																	<div style=\"padding: 10px 0 10px 0;\"><i><b>Informasi Pelanggan</b></i></div>
																																	<div>Alamat: $row_pesan[alamatPelanggan]</div>
																																	<div>Kota: $row_pesan[kota]</div>
																																	<div>Propinsi: $row_pesan[propinsi]</div>
																																	<div>Kode Pos: $row_pesan[kodePos]</div>
																																	<div>Phone: $row_pesan[phone]</div>
																																	<div>Email: $row_pesan[email]</div>
																																	</td>
																																<td style=\"padding: 0 10px 0 10px;\" align=\"top\">
																																	<div style=\"padding-bottom: 10px;\"><i><b>Informasi Produk</b></i></div>
																																	<table width=\"100%\" cellpadding=\"2\" cellspacing=\"0\" border=\"0\" align=\"center\" bgcolor=\"$bg\">
																																		<tr bgcolor=\"$bg\">
																																			<td width=\"10%\">No</td>
																																			<td width=\"20%\">Kd Prd</td>
																																			<td width=\"\">Nama Prd</td>
																																			<td width=\"15%\">Qty</td>
																																			</tr>";
																																		$sql_prd="	SELECT P.idProduk, P.namaProduk, D.jumlah 
																																					FROM produk P, detpemesanan D 
																																					WHERE P.idProduk=D.idProduk 
																																					AND D.noFaktur='$row_pesan[noFaktur]'";
																																		$query_prd=mysql_query($sql_prd,opendb())or die(mysql_error());
																																		if($query_prd != null) {
																																			if(mysql_num_rows($query_prd)>0) {
																																				$idx=1;
																																				while($row_prd=mysql_fetch_array($query_prd)) {
																																					$alamat .="	<tr bgcolor=\"$bg\">
																																									<td width=\"10%\">$idx</td>
																																									<td width=\"20%\">$row_prd[idProduk]</td>
																																									<td width=\"\">$row_prd[namaProduk]</td>
																																									<td width=\"15%\">$row_prd[jumlah]</td>
																																									</tr>";
																																					$idx++;
																																				}
																																			}
																																		}
																																			
																															$alamat.="	</table>";
																																	if($_GET['page']!="Pending") {
																																		$alamat.="	<div style=\"padding: 10px 0px 10px 0px;\"><i><b>Informasi Transfer</b></i></div>
																																					<div align=\"center\">Uang yang harus di transfer adalah <font style=\"font-size: 15px;\"><b>$row_pesan[jmlhBayar]</b></font></div>
																																					<div>Menggunakan bank <b>$row_pesan[namaBank]</b></div>";																																					
																																	}
																														$alamat.="	</td>
																																</tr>
																															</table>";
																										}
																							$konten.="	<div style=\"padding: 10px 10px 10px 10px;\">$alamat</div>
																										</div>
																									</div>
																								</td>
																							</tr>";
																		$no++;
																	}
																$konten .="		<tr>
																					<td colspan=\"5\"><div style=\"height: 5px;\"></div></td>
																					</tr>
																				</table>
																			</div>";
																}
																else {
																	$konten .="<div style=\"padding-top: 10px; text-align: center;\"><i>Maaf, data tidak ditemukan.</i></div>";
																}																
															}
														}
											$konten.="	</div>
													
												</div>
											</div>
										<div style=\"width:100%; background: url(./imagea/trip2.jpg); height: 18px;\">
											</div>
										</td>
									</tr>
								</table>					
							</td>
						</tr>";
				
				$pemesanan = new Admin();
				$pemesanan->setTitle($title);
				$pemesanan->setLinkLogout($isiLink);
				//$pemesanan->setMenuAtas($menuAtas);
				$pemesanan->setArrayMenu($arrayMenu);
				$pemesanan->setIsi($konten);
				$pemesanan->getTampilkan();
			}
		}
		else {
			unset($_GET['token']);
			unset($_SESSION['ASTA_ADM_USERNAME']);
			unset($_SESSION['ASTA_ADM_PASSWORD']);
			unset($_SESSION['ASTA_ADM_HASH']);
			unset($_SESSION['ASTA_ADM_TIMESTAMP']);
			unset($_SESSION['ASTA_ADM_TOKEN']);
			session_destroy();
			header("Location: index.php?wrong2");
		}
	}
	else {
		header("Location: index.php");
	}
?>