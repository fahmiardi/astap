<?php
	header('Last-Modified:'.gmdate('D, d M Y H:i:s').' GMT');
	header('Cache-Control: no-store, no-cache, must-revalidate');
	header('Cache-Control: post-check=0, pre-check=0, false');
	
session_start();
include_once("./library/kelasAdmin.php");
include_once("./include/functions.php");

if(isset($_SESSION['ASTA_ADM_HASH'])){
	if($_SESSION['ASTA_ADM_HASH']==$_GET['token']){
		if(!authAdmin($_SESSION['ASTA_ADM_USERNAME'], $_SESSION['ASTA_ADM_PASSWORD'])){
			unset($_GET['token']);
			unset($_SESSION['ASTA_ADM_USERNAME']);
			unset($_SESSION['ASTA_ADM_PASSWORD']);
			unset($_SESSION['ASTA_ADM_HASH']);
			unset($_SESSION['ASTA_ADM_TIMESTAMP']);
			unset($_SESSION['ASTA_ADM_TOKEN']);
			session_destroy();
			header("Location: index.php?naughty");
			exit();
		}
		else{
			//untuk expired time
			$refresh_time=10;
			$chour = date('H');
			$cmin = date('i');
			$csec = date('s');
			$cmon = date('m');
			$cday = date('d');
			$cyear = date('Y');
			$ctimestamp = mktime($chour,$cmin,$csec,$cmon,$cday,$cyear);
			$ttimestamp=$_SESSION['ASTA_ADM_TIMESTAMP'];
			if($ttimestamp < $ctimestamp){
				unset($_POST['uname']);
				unset($_POST['cpass']);
				unset($_POST['enctoken']);
				unset($_POST['cmd_submit']);
				unset($_POST['ASTA_ADM_USERNAME']);
				unset($_POST['ASTA_ADM_PASSWORD']);
				unset($_POST['ASTA_ADM_HASH']);
				unset($_SESSION['ASTA_ADM_TIMESTAMP']);
				unset($_SESSION['ASTA_ADM_TOKEN']);
				session_destroy();
				header("Location: index.php?timeout");
				exit();
			}
			$ttimestamp=mktime($chour,$cmin+$refresh_time,$csec,$cmon,$cday,$cyear);
			$_SESSION['ASTA_ADM_TIMESTAMP']=$ttimestamp;
			session_id();
			if(!empty($_SESSION)){
				session_regenerate_id(true);
			}
			//content is here
			$title=":: $JUDUL | Halaman Konfirmasi ::";
			$isiLink="<tr><td><a href=\"index2.php?act=logout&token=$_SESSION[ASTA_ADM_HASH]\" class=\"menuItem\" alt=\"Logout\" title=\"Logout\"><div class=\"break\">Logout</div></a></td></tr>";
			$token="?token=".$_SESSION['ASTA_ADM_HASH'];
			$arrayMenu=array("index.php$token"=>'Home',"produk.php$token"=>'Produk',"pemesanan.php$token"=>'Pemesanan',"konfirmasi.php$token"=>'Konfirmasi',"Pelanggan.php$token"=>'Pelanggan',"kategori.php$token"=>'Kategori');
				
			$konten="<tr><td colspan=\"2\" style=\"padding: 10px 10px 10px 10px;\">
							<table cellpadding=\"1\" cellspacing=\"1\" align=\"center\" bgcolor=\"orange\" width=\"100%\">
								<tr bgcolor=\"#607c3c\">
									<div style=\"background: url(./imagea/tab2.jpg); height:23px;\">
									<div style=\"padding-top:4px; text-align:center; width:737px\"><font color='#ffffff' style=\"padding-top:20px; font-size:14px;\">Konfirmasi</font>
									</div></div>
									<td>";
									opendb();
									$proses=$_GET['proses'];
									switch($proses){
										case "detil";
											$id=$_GET['id'];
										mysql_query("UPDATE konfirmasi SET mark='read' WHERE noFaktur='$id'");													
										$token=$_GET['token'];
										$konten.="	<div style=\"padding: 10px 10px 10px 10px;\">
														<div style=\"background: orange; color: white; text-align: center; width: 100px;\">Detil Konfirmasi</div>
														<div style=\"border: 1px solid orange; padding: 10px 10px 10px 10px; width:737px\">";
										
										$sql_detil="SELECT O.noFaktur, K.pesan, C.namaPelanggan, C.phone, U.usernameAsal, O.tgl, 
													P.namaProduk, P.hargaProduk, D.jumlah, (D.jumlah*P.hargaProduk) AS total
													FROM pelanggan C, pemesanan O, username U, konfirmasi K, detPemesanan D, produk P 
													WHERE 
													C.idPelanggan=O.idPelanggan 
													AND 
													C.idUser=U.idUser
													AND 
													K.noFaktur=O.noFaktur 
													AND 
													P.idProduk=D.idProduk 
													AND 
													D.noFaktur=O.noFaktur
													AND 
													K.noFaktur=D.noFaktur
													AND 
													O.noFaktur='$id';";
											
										$query_detil=mysql_query($sql_detil);
										$jum=mysql_num_rows($query_detil);
										if($jum==0){
											$konten.="		<div style=\"padding: 10px 0 10px 10px;; background-color: #607c3c;\">No Data</div>
															<div style=\"paddig-top:10px\"><a href=\"index.php$token\">Halaman utama</a></div>
														</div>
													</div>";
										}
										else{
											$row_detA=mysql_fetch_array($query_detil);
											$konten.="		<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
																<tr>
																	<td valign=\"top\" class=\"cart\" style=\"color:#ffffff\" width=\"15%\">No. Tiket</td>
																	<td valign=\"top\" class=\"cart\" style=\"color:#ffffff\" width='2%'>:</td>
																	<td valign=\"top\" class=\"cart\" style=\"color:#ffffff\">$row_detA[noFaktur]</td>
																</tr>
																<tr>
																	<td valign=\"top\" class=\"cart\" style=\"color:#ffffff\">Username</td>
																	<td valign=\"top\" class=\"cart\" style=\"color:#ffffff\">:</td>
																	<td valign=\"top\" class=\"cart\" style=\"color:#ffffff\">$row_detA[usernameAsal]</td>
																</tr>
																<tr>
																	<td valign=\"top\" class=\"cart\" style=\"color:#ffffff\">Nama Pelanggan</td>
																	<td valign=\"top\" class=\"cart\" style=\"color:#ffffff\">:</td>
																	<td valign=\"top\" class=\"cart\" style=\"color:#ffffff\">$row_detA[namaPelanggan]</td>
																</tr>
																<tr>
																	<td valign=\"top\" class=\"cart\" style=\"color:#ffffff\">Phone</td>
																	<td valign=\"top\" class=\"cart\" style=\"color:#ffffff\">:</td>
																	<td valign=\"top\" class=\"cart\" style=\"color:#ffffff\">$row_detA[phone]</td>
																</tr>
																<tr>
																	<td valign=\"top\" class=\"cart\" style=\"color:#ffffff\">Pesan</td>
																	<td valign=\"top\" class=\"cart\" style=\"color:#ffffff\">:</td>
																	<td valign=\"top\" class=\"cart\" style=\"color:#ffffff\">";
																	if($row_detA[pesan]==""){
																		$konten.="-";
																	}
																	else{
																		$konten.=$row_detA[pesan];
																	}
														$konten.="		</td>
																</tr></table>																
																		<table width='100%' border=0 align=\"center\">	
																			<tr>
																				<td colspan=\"6\" style=\"color:#ffffff; text-align: center;\"><b>List Pemesanan</b></td>
																			</tr>
																			<tr>
																				<td colspan=\"5\" style=\"color:#ffffff; text-align: left;\"><b>Tanggal Transaksi : $row_detA[tgl]</b></td>
																			</tr>
																			<tr>
																			<td bgcolor=\"orange\" align=\"center\" class=\"cart\" width=\"5%\">No</td>
																			<td bgcolor=\"orange\" align=\"center\" class=\"cart\" width=\"30%\">Produk</td>
																			<td bgcolor=\"orange\" align=\"center\" class=\"cart\" width=\"8%\">Kd Prd</td>
																			<td bgcolor=\"orange\" align=\"center\" class=\"cart\" width=\"15%\">Harga</td>
																			<td bgcolor=\"orange\" align=\"center\" class=\"cart\" width=\"10%\">Qty</td>
																			<td bgcolor=\"orange\" align=\"right\">Total</td>
																			</tr>";
																		$id=$_GET['id'];
																		$sqlPesan="SELECT P.idProduk, P.namaProduk, P.hargaProduk, D.jumlah, (P.hargaProduk*D.jumlah) AS total 
																					FROM produk P, detPemesanan D 
																					WHERE 
																					P.idProduk=D.idProduk 
																					AND D.noFaktur='$id'";
																		$queryPesan=mysql_query($sqlPesan);
																		$jumPesan=mysql_num_rows($queryPesan);
																		if($jumPesan==0){
																			
																		}
																		else{
																		$n=1;
																			while($rowPesan=mysql_fetch_array($queryPesan)){
																				$konten.="
																					<tr>
																					<td align=\"left\">$n</td>
																					<td align=\"left\">$rowPesan[namaProduk]</td>
																					<td align=\"left\">$rowPesan[idProduk]</td>
																					<td align=\"left\">$rowPesan[hargaProduk]</td>
																					<td align=\"left\">$rowPesan[jumlah]</td>
																					<td align=\"right\">$rowPesan[total]</td>
																					</tr>";
																			$n++;
																			}
																		}
																			$konten.="<tr>
																				<td colspan=\"6\">
																					<div align=\"right\">";
																					$id=$_GET['id'];
																					$sum=0;
																					$sqlSum="SELECT (P.hargaProduk*D.jumlah) AS total FROM 
																							produk P, detPemesanan D 
																							WHERE 
																							P.idProduk=D.idProduk AND 
																							D.noFaktur='$id'";
																					$querySum=mysql_query($sqlSum);
																					while($rowSum=mysql_fetch_array($querySum)){
																						$sum+=$rowSum[total];
																					}
																					$sql_ok="SELECT ongkosKirim, jmlhBayar FROM pemesanan WHERE noFaktur='$id'";
																					$query_ok=mysql_query($sql_ok);
																					if(mysql_num_rows($query_ok)==1) {
																						$row_ok=mysql_fetch_array($query_ok);
																					$konten.="<div style=\"padding-top:15px;\">
																						Jumlah Bayar	: Rp $sum<br>
																						Ongkos Kirim	: Rp $row_ok[ongkosKirim]<br>
																						Uang yang harus ditransfer	: Rp $row_ok[jmlhBayar]</div>";
																					}
																					$konten.="																	
																					</div>
																				</td>
																			</tr>
																		</table>";
														$sql_tran="SELECT K.noRekening, K.namaRekening, B.namaBank, B.noRekBank, B.namaPemilik, B.cabang 
																   FROM bank B, konfirmasi K 
																   WHERE 
																   K.idBank = B.idBank 
																   AND 
																   K.noFaktur='$id'";
														$query_tran=mysql_query($sql_tran);
														$konten.="";
														$jum=mysql_num_rows($query_tran);
															if($jum==0){
																$konten.="No Data";
															}
															else{
															$konten.="
																<div style=\"padding-top:10px;\">
																	<table width='100%' border=0 align=\"center\>
																		<tr>
																			<td colspan=\"6\">
																				<div style=\"padding-bottom:10px;\">Transfer :
																			</div></td>
																		</tr>
																		<tr>
																			<td align=\"center\" bgcolor=\"orange\" class=\"cart\" width=\"18%\">No. Rekening Pengirim</td>
																			<td align=\"center\" bgcolor=\"orange\" class=\"cart\" width=\"18%\">Nama Pengirim</td>
																			<td align=\"center\" bgcolor=\"orange\" class=\"cart\" width=\"13%\">Bank Tujuan</td>
																			<td align=\"center\" bgcolor=\"orange\" class=\"cart\" width=\"18%\">Rekening Tujuan</td>
																			<td align=\"center\" bgcolor=\"orange\" class=\"cart\" width=\"18%\">Nama Pemilik</td>
																			<td align=\"center\" bgcolor=\"orange\" class=\"cart\">Cabang</td>
																		</tr>";
																		while($row_tran=mysql_fetch_array($query_tran)){
																			$konten.="
																			<tr>
																				<td align=\"center\" class=\"cart\">$row_tran[noRekening]</td>
																				<td align=\"center\" class=\"cart\">$row_tran[namaRekening]</td>
																				<td align=\"center\" class=\"cart\">$row_tran[namaBank]</td>
																				<td align=\"center\" class=\"cart\">$row_tran[noRekBank]</td>
																				<td align=\"center\" class=\"cart\">$row_tran[namaPemilik]</td>
																				<td align=\"center\" class=\"cart\">$row_tran[cabang]</td>
																			</tr>
																			";
																		}
																	}
																$konten.="</table>";
															
											$konten.="	<div style=\"padding-top:10px;\"><a href=\"konfirmasi.php?token=$token\">Kembali</a></div>";
											}
										break;
										default:
										$sql_view="SELECT K.noFaktur, P.namaPelanggan, B.namaBank, K.noRekening, K.namaRekening, K.jumlahBayar, K.pesan, K.mark 
												FROM konfirmasi K, pelanggan P, bank B, pemesanan O, detpemesanan D 
												WHERE O.noFaktur=K.noFaktur 
												AND B.idBank=K.idBank 
												AND K.noFaktur=D.noFaktur 
												AND D.noFaktur=O.noFaktur 
												AND P.idPelanggan=O.idPelanggan 
												GROUP BY noFaktur 
												ORDER BY mark DESC";
												
										$query_view=mysql_query($sql_view);
										$jum=mysql_num_rows($query_view);
										$i=1;
											if($jum==0){
												$konten.="	<div style=\"padding:10px 0 0 10px; background-color: #607c3c;\">No Data</div>
															<div style=\"padding:10px 0 0 10px;\"><a href=\"index.php$token\">Halaman utama</a></div>";
											}
											else{
												$konten.="	<table align=\"center\" cellpadding=\"3\" cellspacing=\"0\" width=\"100%\" bgcolor=\"#364b1a\" border=\"0\">
																<tr>
																	<td class=\"cart\" style=\"color:#ffffff;\"><b>No</b></td>
																	<td class=\"cart\" style=\"color:#ffffff;\"><b>Faktur</b></td>
																	<td class=\"cart\" style=\"color:#ffffff;\"><b>Pelanggan</b></td>
																	<td class=\"cart\" style=\"color:#ffffff;\"><b>No. Rekening Pengirim</b></td>
																	<td class=\"cart\" style=\"color:#ffffff;\"><b>Jumlah Bayar</b></td>
																	<td class=\"cart\" style=\"color:#ffffff;\"><b>Ke Bank</b></td>
																	<td class=\"cart\" style=\"color:#ffffff;\"><b>Detil</b></td>
																	<td class=\"cart\" style=\"color:#ffffff;\"><b>Status</b></td>
																</tr>";
													$j=0;
													while($row=mysql_fetch_array($query_view)){
														if($j==0){
															$bg="#607c3c";
															$j++;
														}
														else{
															$bg="#9db085";
															$j--;
														}
														 $konten.="<tr bgcolor=\"$bg\">
																<td class=\"cart\" >$i</td>
																<td class=\"cart\" >$row[noFaktur]</td>
																<td>$row[namaPelanggan]</td>
																<td class=\"cart\" >$row[noRekening]</td>
																<td class=\"cart\" >$row[jumlahBayar]</td>
																<td class=\"cart\" >$row[namaBank]</td>
																<td class=\"cart\" >[<a href=\"konfirmasi.php$token&proses=detil&id=$row[noFaktur]\">Detil</a>]</td>
																<td class=\"cart\" >$row[mark]</td>
														</tr>";
													$i++;
													}
												$konten.="</table>
														<div style=\"padding:10px 0 0 10px; background-color: #607c3c\">
															<a href=\"index.php$token\">Halaman utama</a>
														</div>";
											}
										break;
								}
										
									closedb();
							$konten.="	
								</td>
							</tr>
						</table>
					</td>
				</tr>";
				
			$konfirmasi=new Admin();
			$konfirmasi->setTitle($title);
			$konfirmasi->setIsi($konten);
			$konfirmasi->setArrayMenu($arrayMenu);
			$konfirmasi->setLinkLogout($isiLink);
			$konfirmasi->getTampilkan();
				
			
		}
	}
	else{
			unset($_GET['token']);
			unset($_SESSION['ASTA_ADM_USERNAME']);
			unset($_SESSION['ASTA_ADM_PASSWORD']);
			unset($_SESSION['ASTA_ADM_HASH']);
			unset($_SESSION['ASTA_ADM_TIMESTAMP']);
			unset($_SESSION['ASTA_ADM_TOKEN']);
			session_destroy();
			header("Location: index.php?wrong");
			exit();
	}
}
else{
	header("Location: index.php");
}
