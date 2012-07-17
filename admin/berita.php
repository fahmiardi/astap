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
			$title=":: $JUDUL | Halaman Berita ::";
			$isiLink="<tr><td><a href=\"index2.php?act=logout&token=$_SESSION[ASTA_ADM_HASH]\" class=\"menuItem\" alt=\"Logout\" title=\"Logout\"><div class=\"break\">Logout</div></a></td></tr>";
			$token="?token=".$_SESSION['ASTA_ADM_HASH'];
			$arrayMenu=array("index.php$token"=>'Home',"produk.php$token"=>'Produk',"pemesanan.php$token"=>'Pemesanan',"konfirmasi.php$token"=>'Konfirmasi',"Pelanggan.php$token"=>'Pelanggan',"kategori.php$token"=>'Kategori');
				
				$konten="<tr><td colspan=\"2\" style=\"padding: 10px 10px 10px 10px;\">
							<table cellpadding=\"1\" cellspacing=\"1\" align=\"center\" bgcolor=\"orange\" width=\"100%\">
								<tr bgcolor=\"#607c3c\">
									<div style=\"background: url(./imagea/tab2.jpg); height:23px;\">
									<div style=\"padding-top:4px; text-align:center; width:723px;\"><font color='#ffffff' style=\"padding-top:20px; font-size:14px\">Berita</font>
									</div></div>
									<td>";
									opendb();
								$proses=$_GET['proses'];
								$proses=filter($proses);
								
								switch($proses){
									case 'tambah':
									$konten.="	<div style=\"padding: 10px 10px 10px 10px;\">
												<div style=\"background: orange; color: white; text-align: center; width: 100px;\">Input Berita</div>
												<div style=\"border: 1px solid orange; padding: 10px 10px 10px 10px; width: 723px;\">";
										$konten.="
											<form action=\"berita.php$token&proses=input\" method=\"post\" ENCTYPE=\"MULTIPART/FORM-DATA\">
												<table width=\"100%\">
													<tr>
														<td style=\"color:#ffffff\">Judul Berita</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><input type=\"text\" name=\"judulBerita\" size=\"30\"></td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Isi</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\">
														<textarea id=\"elm1\" name=\"isiBerita\" rows=\"10\" cols=\"50\"></textarea>
														</td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Tampilkan</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\">
															<input type=\"radio\" name=\"idStatusShow\" value=\"1\">Ya
															<input type=\"radio\" name=\"idStatusShow\" value=\"2\">Tidak
														</td>
													</tr>
													<tr style=\"color:#ffffff\">
														<td style=\"color:#ffffff\">Kategori</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><SELECT NAME=\"idKategoriBerita\">
														<option value=\"\">Kategori</option>
														";
														$sqlKat="SELECT * FROM kategoriberita";
														$queryKat=mysql_query($sqlKat); 
																	while($rowKat=mysql_fetch_array($queryKat)){
																		$konten.="<option value=\"$rowKat[idKategoriBerita]\">$rowKat[namaKategoriBerita]</option>";
																	}
															
														$konten.="</select></td>
													</tr>
													<tr>
														<td colspan=\"3\" style=\"color:#ffffff\" align=\"center\">
															<div align=\"center\" style=\"padding-top:10px;\">
																<input type=\"submit\" name=\"submit\" value=\"Input\" style=\"border:1px solid grey\">
																<input type=\"reset\" name=\"reset\" value=\"Reset\" style=\"border:1px solid grey\">
															</div>
														</td>
													</tr>
												</table>
											</form>
										";
									break;
									
									case 'edit':
									$konten.="	<div style=\"padding: 10px 10px 10px 10px;\">
												<div style=\"background: orange; color: white; text-align: center; width: 100px;\">Edit Berita</div>
												<div style=\"border: 1px solid orange; padding: 10px 10px 10px 10px; width: 723px;\">";
										$id=(int)$_GET['id'];
										$token=$_GET['token'];
										$sqlEdit="SELECT * FROM berita WHERE idBerita='$id'";
										$queryEdit=mysql_query($sqlEdit);
										$jumEdit=mysql_num_rows($queryEdit);
											if($jumEdit==0){
												$konten.="No Data";
											}
											else{
												$rowEdit=mysql_fetch_array($queryEdit);
												$konten.="
											<form action=\"berita.php?token=$token&proses=update\" method=\"post\" ENCTYPE=\"MULTIPART/FORM-DATA\">
												<table align=\"center\">
													<tr>
														<td style=\"color:#ffffff\">Judul Berita</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><input type=\"text\" name=\"judulBerita\" size=\"25\" value=\"$rowEdit[judulBerita]\"></td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Isi</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><textarea id=\"elm1\" name=\"isiBerita\" rows=\"10\" cols=\"50\">$rowEdit[isiBerita]</textarea></td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Kategori</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><SELECT name=\"idKategoriBerita\">";
														$sqlKat="SELECT * FROM kategoriberita";
														$queryKat=mysql_query($sqlKat);
														$jumKat=mysql_num_rows($queryKat);
															if($jumKat==0){
																$konten.="No Data";
															}
															else{
																while($rowKat=mysql_fetch_array($queryKat)){
																	if($rowKat[idKategoriBerita]==$rowEdit[idKategoriBerita]){
																		$konten.="<option value=\"$rowKat[idKategoriBerita]\" SELECTED>$rowKat[namaKategoriBerita]</option>";
																	}
																	else{
																		$konten.="<option value=\"$rowKat[idKategoriBerita]\">$rowKat[namaKategoriBerita]</option>";
																		}
																	}
																}
													$konten.="</select></td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Tampilkan</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\">";
														$sqlStatus="SELECT * FROM statusshow";
																$queryStatus=mysql_query($sqlStatus);
																$jumStatus=mysql_num_rows($queryStatus);
																	if($jumStatus==0){
																		$konten.="No Data";
																	}
																	else{
																		while($rowStatus=mysql_fetch_array($queryStatus)){
																			if($rowStatus[idStatusShow]==$rowEdit[idStatusShow]){
																				$konten.="<input type=\"radio\" name=\"idStatusShow\" value=\"$rowStatus[idStatusShow]\" CHECKED>$rowStatus[namaStatusShow]";
																			}
																			else{
																				$konten.="<input type=\"radio\" name=\"idStatusShow\" value=\"$rowStatus[idStatusShow]\">$rowStatus[namaStatusShow]";
																				}
																			}
																		}
															$konten.="			
																	</td>
																</tr>
																<tr>
																	<td colspan=\"3\" style=\"color:#ffffff\" align=\"center\">
																		<input type=\"submit\" name=\"submit\" value=\"Update\" style=\"border:1px solid grey\">
																		<input type=\"hidden\" name=\"id\" value=\"$rowEdit[idBerita]\">
																	</td>
																</tr>
															</table>
														</form>
													";
												}
										break;
									
									case 'update':
									$id=(int)$_POST['id'];
									$judulBerita=$_POST['judulBerita'];
									$idStatusShow=$_POST['idStatusShow'];
									$idKategoriBerita=$_POST['idKategoriBerita'];
									if($idKategoriBerita==1) {
										$isiBerita=filter($_POST['isiBerita']);
									}
									else {
										$isiBerita=$_POST['isiBerita'];
									}
									$token=$_GET['token'];
										if($judulBerita!="" && $isiBerita!="" && $idStatusShow !="" && $idKategoriBerita!=""){
											$sqlUpdate="UPDATE berita SET judulBerita='$judulBerita', isiBerita='$isiBerita', idStatusShow='$idStatusShow', idKategoriBerita='$idKategoriBerita' WHERE idBerita='$id'";
											$queryUpdate=mysql_query($sqlUpdate);
												if($queryUpdate){
													header("Location: berita.php?token=$token");
												}
												else{
													$konten.="<div style=\"padding-top:10px; background-color: #607c3c; padding-bottom:10px;\">Failed to Update some empty fields found
																<div style=\"padding-top:10px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
																</div></div>";
												}
										}
										else{
											$konten.="<div style=\"padding-top:10px; background-color: #607c3c; padding-bottom:10px;\">Failed to Update some empty fields found
																<div style=\"padding-top:10px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
																</div></div>";
										}
									break;
									
									case 'hapus':
										$id=(int)$_GET['id'];
										$token=$_GET['token'];
										$sqlHapus="DELETE FROM berita WHERE idBerita='$id'";
										$queryHapus=mysql_query($sqlHapus);
										if(!$queryHapus){
											$konten.="<div style=\"padding-top:10px; background-color: #607c3c; padding-bottom:10px;\">Failed to delete data
													<div style=\"padding-top:10px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
													</div></div>";
										}
										else{
											header("Location: berita.php?token=$token");
										}
									break;
									
									case 'input':
										$tahun = date("Y");
										$bulan = date("m");
										$hari = date("d");
										$tgl=$tahun."-".$bulan."-".$hari;
										
										$token=$_GET['token'];
										$judulBerita=$_POST['judulBerita'];										
										$idStatusShow=$_POST['idStatusShow'];
										$idKategoriBerita=$_POST['idKategoriBerita'];
										if($idKategoriBerita==1) {
											$isiBerita=filter($_POST['isiBerita']);
										}
										else {
											$isiBerita=$_POST['isiBerita'];
										}
										
										if($judulBerita !="" && $isiBerita !="" && $idStatusShow !="" && $idKategoriBerita !=""){
											$sqlInput="INSERT INTO berita VALUES ('','$judulBerita','$tgl','$isiBerita','$idStatusShow','$idKategoriBerita')";
											$queryInput=mysql_query($sqlInput,opendb())or die(mysql_error());
											if($queryInput){
												header("Location: berita.php?token=$token");
											}
											else{
												$konten.="<div style=\"padding-top:10px; background-color: #607c3c; padding-bottom:10px;\">Failed to Input Data
																<div style=\"padding-top:10px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
																</div></div>";
											}
										}
										else{
											$konten.="<div style=\"padding-top:10px; background-color: #607c3c; padding-bottom:10px;\">Failed to Input some empty fields found
																<div style=\"padding-top:10px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
																</div></div>";
										}
										
									break;
									
									default:
									$sqlView="SELECT B.judulBerita, B.isiBerita, B.idStatusShow, B.idKategoriBerita, 
											 K.namaKategoriBerita, S.namaStatusShow, S.idStatusShow, B.idBerita 
											FROM 
											berita B, statusshow S, kategoriberita K 
											WHERE 
											B.idStatusShow=S.idStatusShow AND 
											B.idKategoriBerita=K.idKategoriBerita";
									$queryView=mysql_query($sqlView,opendb())or die(mysql_error());
									$jumView=mysql_num_rows($queryView);
										if($jumView==0){
											$konten.="<div style=\"padding-top:10px; background-color: #607c3c\">
												<a href=\"index.php$token\">Halaman utama</a> 
												<a href=berita.php$token&proses=tambah>Tambah Data</a>
												</div>";
										}
											else{
												$konten.="<table align=\"center\" cellpadding=\"3\" cellspacing=\"0\" width=\"100%\" bgcolor=\"#364b1a\" border=\"0\">
													<tr>
														<td class=\"cart\" style=\"color:#ffffff;\">No</td>
														<td class=\"cart\" style=\"color:#ffffff;\">Judul</td>
														<td class=\"cart\" style=\"color:#ffffff;\">Kategori</td>
														<td class=\"cart\" style=\"color:#ffffff;\">Status</td>
														<td class=\"cart\" style=\"color:#ffffff;\">Aksi</td>
													</tr>
												";
												$i=1;
												$j=0;
													while($rowView=mysql_fetch_array($queryView)){
														if($j==0){
															$bg="#607c3c";
															$j++;
														}
														else{
														$bg="#9db085";
														$j--;
														}
														$konten.="
															<tr bgcolor=\"$bg\">
																<td class=\"cart\">$i</td>
																<td>$rowView[judulBerita]</td>
																<td class=\"cart\">$rowView[namaKategoriBerita]</td>
																<td class=\"cart\">$rowView[namaStatusShow]</td>
																<td class=\"cart\">[<a href=\"berita.php$token&proses=edit&id=$rowView[idBerita]\">Edit</a> 
																| <a href=\"berita.php$token&proses=hapus&id=$rowView[idBerita]\" onClick=\"return confirm('Anda yakin akan menghapus');\">Hapus</a>]</td>
															</tr>
														";
														$i++;
													}
												$konten.="</table>
												<div style=\"padding-top:10px; background-color: #607c3c\">
												<a href=\"index.php$token\">Halaman utama</a> 
												<a href=berita.php$token&proses=tambah>Tambah Data</a>
												</div>";
											}
									break;
								}
							closedb();
								$konten.="</td>
							</tr>
						</table>
					</center>
					</td>
				</tr>";
				
			$berita=new Admin();
			$berita->setTitle($title);
			$berita->setIsi($konten);
			$berita->setArrayMenu($arrayMenu);
			$berita->setLinkLogout($isiLink);
			$berita->getTampilkan();
				
			
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
