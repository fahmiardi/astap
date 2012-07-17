<?php
	header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
	header('Cache-Control: no-store, no-cache, must-revalidate');
	header('Cache-Control: post-check=0, pre-check=0, false');
	
	session_start();
	include_once "./library/kelasPelanggan.php";
	include_once "./include/functions.php";
	include_once "./include/functions-cart.php";
	
	$title="::$JUDUL | Halaman Katalog::";
	$katalog = new Pelanggan();
	$isi_2="<tr>
				<td colspan=\"2\" valign=\"top\" style=\"padding-top: 10px;\">
					<table cellpadding=\"0\" cellspacing=\"0\" align=\"center\" bgcolor=\"#$TRIP\" width=\"100%\">
						<tr bgcolor=\"#$BACK\">
							<td vailgn=\"top\"> 
								<div style=\"background-color: #$TRIP; width:162px; text-align: center;  font-family: tahoma; font-size: 13px; font-weight: bold; color: #$TEXT;\">Daftar Katalog</div>								
								<div style=\"border: 1px solid #$TRIP; padding: 10px 10px 10px 10px;\">";									
									if(isset($_SESSION['ASTA_HASH'])) {
										$form2="$_SERVER[PHP_SELF]?page=$_GET[page]&token=$_GET[token]";
										$tok="<input type=\"hidden\" name=\"token\" value=\"$_SESSION[ASTA_HASH]\">";
									}
									else {
										$form2="$_SERVER[PHP_SELF]?page=$_GET[page]";
										$tok="";
									}
									$isi_2.="
									<div>
										<form action=\"$form2\" method=\"GET\">
											<table cellpadding=\"0\" cellspacing=\"0\" align=\"center\" border=\"0\" width=\"466\">
												<tr><td>
													$tok
													<select name=\"page\" onChange=\"this.form.submit()\">
													<option value=\"\">Pilih Kategory</option>";
													if($_GET['page']=="All") {														
														$isi_2.="<option value=\"All\" SELECTED>All</option>";
													}
													else {
														$isi_2.="<option value=\"All\">All</option>";
													}
													$sqlList="SELECT * FROM kategori ORDER BY namaKategori";
													$queryList=mysql_query($sqlList,opendb())or die(mysql_error());
													if($queryList != null) {
														if(mysql_num_rows($queryList)>0) {
															while($rowList=mysql_fetch_array($queryList)) {
																if($_GET['page']==$rowList['idKategori']) {
																	$isi_2.="<option value=\"$rowList[idKategori]\" SELECTED>$rowList[namaKategori]</option>";
																}
																else {
																	$isi_2.="<option value=\"$rowList[idKategori]\">$rowList[namaKategori]</option>";
																}
															}
														}
													}
										$isi_2 .="	</td></tr>
												</table>
											</form>
										</div>";
									if(isset($_GET['page'])) {
									$isi_2.="
									<div>
										<table cellpadding=\"2\" cellspacing=\"1\" align=\"center\" bgcolor=\"#364b1a\" width=\"100%\">
											<tr>
												<td>
													<div align=\"center\">";
														if(isset($_SESSION['ASTA_HASH'])) {
															$form="$_SERVER[PHP_SELF]?page=$_GET[page]&token=$_GET[token]";		
															$cart="cart.php?token=$_SESSION[ASTA_HASH]&";
															$head="index1.php?token=$_SESSION[ASTA_HASH]";
														}
														else {
															$form="$_SERVER[PHP_SELF]?page=$_GET[page]";
															$cart="cart.php?";
															$head="index1.php";
														}
														$isi_2.="
														<form action=\"$form\" method=\"POST\">";
															if(isset($_GET['page'])&&$_GET['page']!="") {
																if($_GET['page']=="All") {
																	$sql_cek="SELECT idKategori, namaKategori FROM kategori";
																}
																else {
																	$sql_cek="SELECT idKategori, namaKategori FROM kategori WHERE idKategori='$_GET[page]'";
																}
																$query_cek=mysql_query($sql_cek,opendb())or die(mysql_error());
																if(mysql_num_rows($query_cek)==1) {
																	$row_cek=mysql_fetch_array($query_cek);
																}
																if($_GET['page']=="$row_cek[idKategori]"||$_GET['page']=="All") {
																	$arr=array('2'=>'All','3'=>"Judul",'4'=>"Produsen");
																	$kat=$row_cek['idKategori'];
																	if($_GET['page']=="$row_cek[idKategori]") {
																		$sql_kat="	SELECT P.idProduk, P.stockProduk, P.namaProduk, P.hargaProduk, D.namaProdusen, P.konten, P.pathImage 
																					FROM produk P, produsen D, kategori K 
																					WHERE P.idKategori='$kat' 
																					AND P.idProdusen=D.idProdusen 
																					AND K.idKategori=P.idKategori";
																	}
																	if($_GET['page']=="All") {
																		$sql_kat="	SELECT P.idProduk, P.stockProduk, P.namaProduk, P.hargaProduk, D.namaProdusen, P.konten, P.pathImage 
																					FROM produk P, produsen D, kategori K 
																					WHERE P.idProdusen=D.idProdusen 
																					AND K.idKategori=P.idKategori";
																	}
																	if(isset($_POST['cari'])) {	
																		if($_POST['arah']=="3") {
																			$sql_kat.="	AND P.namaProduk LIKE '%$_POST[query]%' ";	
																		}
																		elseif($_POST['arah']=="4") {
																			$sql_kat.="	AND D.namaProdusen LIKE '%$_POST[query]%' ";
																		}
																		else {
																			$sql_kat.=" GROUP BY namaProduk ASC";
																		}
																	}
																}																
																else {																	
																	header("Location: $head");
																}
												
												$isi_2 .="	<div>
																<input type=\"text\" name=\"query\" size=\"20\" value=\"$_POST[query]\">";																																	
																	if(isset($_POST['arah'])) {
															$isi_2.="	<select name=\"arah\" onChange=\"this.form.submit()\">";																			
																			foreach($arr as $key=>$val) {																				
																				if($key=="$_POST[arah]") {
																					$isi_2.="<option value=\"$key\">$val</option>";
																					break;
																				}
																			}
																			foreach($arr as $key=>$val) {																				
																				if($key!="$_POST[arah]") {
																					$isi_2.="<option value=\"$key\">$val</option>";
																				}
																			}																			
																$isi_2 .="	</select>";																			
																	}
																	else {																		
															$isi_2.="	<select name=\"arah\" onChange=\"this.form.submit()\">";
																			foreach($arr as $key=>$val) {
																				$isi_2 .="<option value=\"$key\">$val</option>";
																			}
																$isi_2 .="	</select>";	
																	}															
													$isi_2.="		<input type=\"submit\" name=\"cari\" value=\"Cari\" class=\"ctombol\">
																</div>															
															<div style=\"padding: 20px 5px 20px 5px;\" id=\"content\">
																<table cellpadding=\"2\" cellspacing=\"0\" align=\"center\" bgcolor=\"#364b1a\" width=\"100%\" border=\"0\">";
																	$query_kat=mysql_query($sql_kat,opendb())or die(mysql_error());
																	if($query_kat != null) {
																		if(mysql_num_rows($query_kat)>0) {
																			$isi_2.="<tr>
																						<td class=\"cart\" width=\"8%\" style=\"color: #ffffff;\"><b>No</b></td>
																						<td class=\"cart\" width=\"35%\" style=\"color: #ffffff;\"><b>Nama Produk</b></td>
																						<td class=\"cart\" width=\"15%\" style=\"color: #ffffff;\"><b>Harga</b></td>
																						<td class=\"cart\" width=\"8%\" style=\"color: #ffffff;\"><b>Det</b></td>
																						<td></td>
																						</tr>";
																			$no=1;
																			$j=0;																			
																			while($row_kat=mysql_fetch_array($query_kat)) {
																				if($j==0) {
																					$bg="#b08903";
																					$j++;
																				}
																				else {
																					$bg="#b29739";
																					$j--;
																				}
																				$isi_2.="	<tr bgcolor=\"$bg\">
																								<td class=\"cart\" width=\"8%\" style=\"color: #364b1a;\">$no</td>
																								<td class=\"cart\" width=\"40%\" style=\"color: #364b1a;\">$row_kat[namaProduk]</td>
																								<td class=\"cart\" width=\"10%\" style=\"color: #364b1a;\">$row_kat[hargaProduk]</td>
																								<td class=\"cart\" width=\"8%\" style=\"color: #364b1a;\">
																									<div class=\"tab\" style=\"margin: 0px 0px 0px 0px;\"></div>
																									<div class=\"tab\" style=\"margin: 0px 0px 0px 0px;\"><a href=\"#detail\"><img src=\"./imagea/right.ico\" width=\"16\" height=\"16\"></a></div>
																									</td>
																								<td width=\"\">
																									<div class=\"boxholder\" style=\"border: 0px; background-color: $bg; padding: 0 0 0 0;\">
																										<div class=\"box\" style=\"height: 0px; padding: 0px;\"></div>
																										<div class=\"box\" style=\"padding: 0px 5px 0px 5px;\">
																											<div style=\"text-align: left;\">
																												<img src=\"./imagea/product/$row_kat[pathImage]\" width=\"50\" height=\"50\">
																												&nbsp;<a href=\"$cart"."pd_id=$row_kat[idProduk]\"><font style=\"font-size: 10px;\">AddToCart</font></a>
																												</div>
																											<div>																											
																												<table cellpadding=\"0\" cellspacing=\"0\" align=\"center\" width=\"100%\">
																													<tr>
																														<td style=\"color: #364b1a; text-align: left;\">";																																																														
																													$isi_2.="	<div><b><i>produsen:</i></b> $row_kat[namaProdusen]</div>
																																<div><b><i>deskripsi:</i></b> $row_kat[konten]</div>
																																<div><b><i>stock:</i></b> $row_kat[stockProduk]</div>
																															</td>
																														</tr>
																													</table>
																												</div>
																											</div>
																										</div>
																									</td>
																								</tr>";
																				$no++;
																			}
																		}
																		else {
																			$isi_2.="<tr>
																						<td colspan=\"5\" align=\"center\" style=\"color: #ffffff;\"><i>Maaf, data tidak ditemukan.</i></td>
																						</tr>";
																		}
																	}	
														$isi_2.="	<tr>
																		<td colspan=\"5\" style=\"padding-top: 3px;\"></td>
																		</tr>
																	</table>
																</div>";
															}
												$isi_2 .= "	</form>
														</div>															
													</td>
												</tr>
											</table>
										</div>";
									}
									$isi_2.="
									</div>													
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
				//generate ulang ID Session
				session_id();
				if(!empty($_SESSION)) {
					session_regenerate_id(true);
				}
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