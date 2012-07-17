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
			}
			$ttimestamp=mktime($chour,$cmin+$refresh_time,$csec,$cmon,$cday,$cyear);
			$_SESSION['ASTA_ADM_TIMESTAMP']=$ttimestamp;
			session_id();
			if(!empty($_SESSION)){
				session_regenerate_id(true);
			}
			//content is here
			$title=":: $JUDUL | Halaman Profil ::";
			$isiLink="<tr><td><a href=\"index2.php?act=logout&token=$_SESSION[ASTA_ADM_HASH]\" class=\"menuItem\" alt=\"Logout\" title=\"Logout\"><div class=\"break\">Logout</div></a></td></tr>";
			$token="?token=".$_SESSION['ASTA_ADM_HASH'];
			$arrayMenu=array("index.php$token"=>'Home',"produk.php$token"=>'Produk',"pemesanan.php$token"=>'Pemesanan',"konfirmasi.php$token"=>'Konfirmasi',"Pelanggan.php$token"=>'Pelanggan',"kategori.php$token"=>'Kategori');
				
			$konten="<tr><td colspan=\"2\" style=\"padding: 10px 10px 10px 10px;\">
							<table cellpadding=\"1\" cellspacing=\"1\" align=\"center\" bgcolor=\"orange\" width=\"100%\">
								<tr bgcolor=\"#607c3c\">
									<div style=\"background: url(./imagea/tab2.jpg); height:23px;\">
									<div style=\"padding-top:4px; text-align:center; width:723px;\"><font color='#ffffff' style=\"padding-top:20px; font-size:14px\">Profil</font>
									</div></div>
									<td>";
							opendb();
								$proses=$_GET['proses'];
								$proses=filter($proses);
								
								switch($proses){
									case 'tambah':
									$konten.="	<div style=\"padding: 10px 10px 10px 10px;\">
												<div style=\"background: orange; color: white; text-align: center; width: 100px;\">Input Profil</div>
												<div style=\"border: 1px solid orange; padding: 10px 10px 10px 10px; width: 723px;\">";
										$konten.="
											<form action=\"profil.php$token&proses=input\" method=\"post\" ENCTYPE=\"MULTIPART/FORM-DATA\">
												<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\">
													<tr style=\"color:#ffffff; padding-top:10px;\">
														<td style=\"color:#ffffff;\">Judul</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><input type=\"text\" name=\"judulKonten\" size=\"30\"></td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Deskripsi</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff; width:100px; \">
														<textarea id=\"elm1\" name=\"deskripsiKonten\" rows=\"10\" cols=\"50\"></textarea></td>
													</tr>
													<tr style=\"color:#ffffff; padding-top:10px;\">
														<td style=\"color:#ffffff;\">Posisi</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\">
														<SELECT name=\"idPosisi\">
														<OPTION value=\"\">Posisi</OPTION>";
														$sqlPosisi="SELECT * FROM posisi";
														$queryPosisi=mysql_query($sqlPosisi);
														while($rowPosisi=mysql_fetch_array($queryPosisi)){
															$konten.="<OPTION value=$rowPosisi[idPosisi]>$rowPosisi[namaPosisi]</OPTION>";
														}
														$konten.="</SELECT>
														</td>
													</tr>
													</tr>
													<tr>
														<td colspan=\"3\" style=\"color:#ffffff\">
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
												<div style=\"background: orange; color: white; text-align: center; width: 100px;\">Edit Profil</div>
												<div style=\"border: 1px solid orange; padding: 10px 10px 10px 10px; width: 723px;\">";
										$id=(int)$_GET['id'];
										$token=$_GET['token'];
										$sqlEdit="SELECT T.judulKonten, T.deskripsiKonten, T.idPosisi, T.idTentang
												FROM tentangkami T, posisi P 
												WHERE T.idPosisi=P.idPosisi 
												AND 
												T.idTentang='$id'";
										$queryEdit=mysql_query($sqlEdit);
										$jumEdit=mysql_num_rows($queryEdit);
											if($jumEdit==0){
												$konten.="<div style=\"padding-top:10px; background-color: #607c3c\">
												<a href=\"index.php$token\">Halaman utama</a> 
												<a href=profil.php?$token&proses=tambah>Tambah Data</a>
												</div>";
											}
											else{
												$rowEdit=mysql_fetch_array($queryEdit);
												$konten.="
											<form action=\"profil.php?token=$token&proses=update\" method=\"post\" ENCTYPE=\"MULTIPART/FORM-DATA\">
												<table align=\"center\">
													<tr style=\"color:#ffffff; padding-top:10px;\">
														<td style=\"color:#ffffff;\">Judul</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><input type=\"text\" name=\"judulKonten\" size=\"30\" value=\"$rowEdit[judulKonten]\"></td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">detailProfil</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><textarea id=\"elm1\" name=\"deskripsiKonten\" rows=\"10\" cols=\"50\">$rowEdit[deskripsiKonten]</textarea></td>
													</tr>
													<tr style=\"color:#ffffff; padding-top:10px;\">
														<td style=\"color:#ffffff;\">Posisi</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\">
														<SELECT name=\"idPosisi\">
														<OPTION value=\"\">Posisi</OPTION>";
														$sqlPosisi="SELECT * FROM posisi";
														$queryPosisi=mysql_query($sqlPosisi);
														while($rowPosisi=mysql_fetch_array($queryPosisi)){
															if($rowPosisi[idPosisi]==$rowEdit[idPosisi]){
																$konten.="<OPTION value=$rowPosisi[idPosisi] SELECTED>$rowPosisi[namaPosisi]</OPTION>";
															}
															else{
																$konten.="<OPTION value=$rowPosisi[idPosisi]>$rowPosisi[namaPosisi]</OPTION>";
															}
														}
													$konten.="</SELECT>
													</td>
													<tr>
														<td colspan=\"3\" style=\"color:#ffffff\" align=\"center\">
															<div style=\"padding-top:10px\"><input type=\"submit\" name=\"submit\" value=\"Update\" style=\"border:1px solid grey\"></div>
															<input type=\"hidden\" name=\"id\" value=\"$rowEdit[idTentang]\">
														</td>
													</tr>
												</table>
											</form>
											<div align=\"left\" style=\"padding-tp:10px;\">
											<input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
											</div>
													";
												}
										break;
									
									case 'update':
									$id=(int)$_POST['id'];
									$judulKonten=$_POST['judulKonten'];
									$deskripsiKonten=$_POST['deskripsiKonten'];
									$idPosisi=$_POST['idPosisi'];
									$token=$_GET['token'];
										if($judulKonten !="" && $deskripsiKonten !="" && $idPosisi !=""){
											$sqlUpdate="UPDATE tentangkami SET judulKonten='$judulKonten', deskripsiKonten='$deskripsiKonten', 
											idPosisi='$idPosisi' WHERE 
											idTentang='$id'";
											$queryUpdate=mysql_query($sqlUpdate);
												if($queryUpdate){
													header("Location: profil.php?token=$token");
												}
												else{
													$konten.="<div style=\"padding-top:10px; background-color: #607c3c; padding-bottom:10px;\"><font color=\"#ffffff\">Failed to update Data</font>
													<div style=\"padding-top:10px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
													</div></div>";
												}
										}
										else{
											$konten.="<div style=\"padding-top:10px; background-color: #607c3c; padding-bottom:10px;\"><font color=\"#ffffff\">Failed to update Data. Some empty fields found</font>
												<div style=\"padding-top:10px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
												</div></div>";
										}
									break;
									
									case 'hapus':
										$id=(int)$_GET['id'];
										$token=$_GET['token'];
										$queryHapus=mysql_query("DELETE FROM tentangkami WHERE idTentang='$id'");
											if(!$queryHapus){
												$konten.="<div style=\"padding-top:10px; background-color: #607c3c; padding-bottom:10px;\">Failed to delete
												<div style=\"padding-top:10px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
												</div></div>";
											}
											else{
												header("Location: profil.php?token=$token");
											}
									break;
									
									case 'input':
									$judulKonten=$_POST['judulKonten'];
									$deskripsiKonten=$_POST['deskripsiKonten'];
									$idPosisi=$_POST['idPosisi'];
									$token=$_GET['token'];
										if($judulKonten !="" && $deskripsiKonten !="" && $idPosisi !=""){
											$sqlInput="INSERT INTO tentangkami VALUES ('','$judulKonten','$deskripsiKonten','$idPosisi')";
											$queryInput=mysql_query($sqlInput);
												if($queryInput){
													header("Location: profil.php?token=$token");
												}
												else{
													$konten.="<div style=\"padding-top:10px; background-color: #607c3c; padding-bottom:10px;\"><font color=\"#ffffff\">Failed to Input Data</font>
													<div style=\"padding-top:10px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
													</div></div>";
												}
										}
										else{
											$konten.="<div style=\"padding-top:10px; background-color: #607c3c; padding-bottom:10px;\"><font color=\"#ffffff\">Failed to input Data. Some empty fields found</font>
												<div style=\"padding-top:10px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
												</div></div>";
										}
									break;
									
									default:
									$sqlView="SELECT T.judulKonten, T.deskripsiKonten, T.idTentang, P.namaPosisi  
											FROM tentangkami T, posisi P
											WHERE P.idPosisi=T.idPosisi";
									$queryView=mysql_query($sqlView);
									$jumView=mysql_num_rows($queryView);
										if($jumView==0){
											$konten.="<div style=\"padding-top:10px; background-color: #607c3c\">No Data</div><div style=\"padding-top:10px; background-color: #607c3c\">
												<a href=\"index.php$token\">Halaman utama</a> 
												<a href=profil.php$token&proses=tambah>Tambah Data</a>
												</div>";
										}
										else{
											$konten.="<table align=\"center\" cellpadding=\"3\" cellspacing=\"0\" width=\"100%\" bgcolor=\"#364b1a\" border=\"0\">
													<tr>
														<td class=\"cart\" style=\"color:#ffffff;\">No</td>
														<td class=\"cart\" style=\"color:#ffffff;\">Judul</td>
														<td class=\"cart\" style=\"color:#ffffff;\">Posisi</td>
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
																<td class=\"cart\">$rowView[judulKonten]</td>
																<td class=\"cart\">$rowView[namaPosisi]</td>
																<td class=\"cart\">[<a href=\"profil.php$token&proses=edit&id=$rowView[idTentang]\">Edit</a> | <a href=\"profil.php$token&proses=hapus&id=$rowView[idTentang]\" onClick=\"return confirm('Anda Yakin Akan Menghapus?');\">Hapus</a>]</td>
															</tr>
														";
														$i++;
													}
												$konten.="</table>
												<div style=\"padding-top:10px; background-color: #607c3c\">
												<a href=\"index.php$token\">Halaman utama</a> 
												<a href=profil.php$token&proses=tambah>Tambah Data</a>
												</div>";
										}
									break;
								}
							closedb();
								$konten.="
								</td>
							</tr>
						</table>
					</center>
					</td>
				</tr>";
			
			$profil=new Admin();
			$profil->setTitle($title);
			$profil->setIsi($konten);
			$profil->setArrayMenu($arrayMenu);
			$profil->setLinkLogout($isiLink);
			$profil->getTampilkan();
				
			
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
			header("Location: index.php?wrong2");
			exit();
	}
}
else{
	header("Location: index.php");
}
