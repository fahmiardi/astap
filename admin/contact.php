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
			$title=":: $JUDUL | Halaman Contact ::";
			$isiLink="<tr><td><a href=\"index2.php?act=logout&token=$_SESSION[ASTA_ADM_HASH]\" class=\"menuItem\" alt=\"Logout\" title=\"Logout\"><div class=\"break\">Logout</div></a></td></tr>";
			$token="?token=".$_SESSION['ASTA_ADM_HASH'];
			$arrayMenu=array("index.php$token"=>'Home',"produk.php$token"=>'Produk',"pemesanan.php$token"=>'Pemesanan',"konfirmasi.php$token"=>'Konfirmasi',"Pelanggan.php$token"=>'Pelanggan',"kategori.php$token"=>'Kategori');
				
			$konten="<tr><td colspan=\"2\" style=\"padding: 10px 10px 10px 10px;\">
							<table cellpadding=\"1\" cellspacing=\"1\" align=\"center\" bgcolor=\"orange\" width=\"100%\">
								<tr bgcolor=\"#607c3c\">
									<div style=\"background: url(./imagea/tab2.jpg); height:23px;\">
									<div style=\"padding-top:4px; text-align:center; width:723px;\"><font color='#ffffff' style=\"padding-top:20px; font-size:14px\">Perusahaan</font>
									</div></div>
									<td>";
							opendb();
								$proses=$_GET['proses'];
								$proses=filter($proses);
								
								switch($proses){
									case 'tambah':
									$konten.="	<div style=\"padding: 10px 10px 10px 10px;\">
												<div style=\"background: orange; color: white; text-align: center; width: 100px;\">Input Perusahaan</div>
												<div style=\"border: 1px solid orange; padding: 10px 10px 10px 10px; width: 723px;\">";
										$konten.="
											<form action=\"contact.php$token&proses=input\" method=\"post\">
												<table>
													<tr>
														<td style=\"color:#ffffff\">Nama Perusahaan</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><input type=\"text\" name=\"namaPerusahaan\" size=\"30\"></td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Alamat</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><textarea name=\"alamatPerusahaan\" cols=\"30\" rows=\"8\"></textarea></td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Telepon</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><input type=\"text\" name=\"contactPerusahaan\" size=\"30\"></td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Email</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><input type=\"text\" name=\"emailPerusahaan\" size=\"30\">
														<small>* Contoh: xxx@yyy.com</small>
														</td>
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
												<div style=\"background: orange; color: white; text-align: center; width: 100px;\">Edit Perusahaan</div>
												<div style=\"border: 1px solid orange; padding: 10px 10px 10px 10px; width: 723px;\">";
										$id=filter($_GET['id']);
										$token=$_GET['token'];
										$sqlEdit="SELECT * FROM perusahaan WHERE idperusahaan='$id'";
										$queryEdit=mysql_query($sqlEdit);
										$jumEdit=mysql_num_rows($queryEdit);
											if($jumEdit==0){
												$konten.="<div style=\"padding-top:10px; background-color: #607c3c\">
												<a href=\"index.php$token\">Halaman utama</a> 
												<a href=contact.php$token&proses=tambah>Tambah Data</a>
												</div>";
											}
											else{
												$rowEdit=mysql_fetch_array($queryEdit);
												$konten.="
											<form action=\"contact.php?token=$token&proses=update\" method=\"post\">
												<table align=\"center\">
													<tr>
														<td style=\"color:#ffffff\">Nama Perusahaan</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><input type=\"text\" name=\"namaPerusahaan\" size=\"25\" value=\"$rowEdit[namaPerusahaan]\"></td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Alamat</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><textarea name=\"alamatPerusahaan\" rows=\"8\" cols=\"30\">$rowEdit[alamatPerusahaan]</textarea></td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Telepon</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><input type=\"text\" name=\"contactPerusahaan\" size=\"25\" value=\"$rowEdit[contactPerusahaan]\"></td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Email</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><input type=\"text\" name=\"emailPerusahaan\" size=\"25\" value=\"$rowEdit[emailPerusahaan]\"></td>
													</tr>
																<tr>
																	<td colspan=\"3\" style=\"color:#ffffff\" align=\"center\">
																		<input type=\"submit\" name=\"submit\" value=\"Update\" style=\"border:1px solid grey\">
																		<input type=\"hidden\" name=\"id\" value=\"$rowEdit[idPerusahaan]\">
																	</td>
																</tr>
															</table>
														</form>
													";
													$konten.="<input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">";
												}
										break;
									
									case 'update':
									$id=(int)$_POST['id'];
									$namaPerusahaan=$_POST['namaPerusahaan'];
									$alamatPerusahaan=$_POST['alamatPerusahaan'];
									$contactPerusahaan=$_POST['contactPerusahaan'];
									$emailPerusahaan=$_POST['emailPerusahaan'];
									$token=$_GET['token'];
										if($namaPerusahaan !="" && $alamatPerusahaan !="" && $contactPerusahaan !="" && $emailPerusahaan !=""){
											$sqlUpdate="UPDATE perusahaan SET namaPerusahaan='$namaPerusahaan', alamatPerusahaan='$alamatPerusahaan', contactPerusahaan='$contactPerusahaan', emailPerusahaan='$emailPerusahaan' WHERE idPerusahaan='$id'";
											$queryUpdate=mysql_query($sqlUpdate);
												if($queryUpdate){
													header("Location: contact.php?token=$token");
												}
												else{
													$konten.="<div style=\"padding-top:10px; padding-left:5px; background-color: #607c3c; padding-bottom:10px;\"><font color=#ffffff>Failed to Update some empty fields found</font>
													<div style=\"padding-top:10px; padding-left:5px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
													</div></div>";
												}
										}
										else{
											$konten.="<div style=\"padding-top:10px; padding-left:5px; background-color: #607c3c; padding-bottom:10px;\"><font color=#ffffff>Failed to Update some empty fields found</font>
													<div style=\"padding-top:10px; padding-left:5px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
													</div></div>";
										}
									break;
									
									case 'hapus':
										$id=(int)$_GET['id'];
										$token=$_GET['token'];
										$queryHapus=mysql_query("DELETE FROM perusahaan WHERE idPerusahaan='$id'");
													if(!$queryHapus){
														$konten.="<div style=\"padding-top:10px; padding-left:5px; background-color: #607c3c; padding-bottom:10px;\"><font color=#ffffff>Failed to delete</font>
													<div style=\"padding-top:10px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
													</div></div>";
													}
													else{
														header("Location: contact.php?token=$token");
													}
									break;
									
									case 'input':
										$token=$_GET['token'];
										$namaPerusahaan=$_POST['namaPerusahaan'];
										$alamatPerusahaan=$_POST['alamatPerusahaan'];
										$contactPerusahaan=$_POST['contactPerusahaan'];
										$emailPerusahaan=$_POST['emailPerusahaan'];
										if(!isset($_POST['submit'])){
												$konten.="Failed";
											}
												else{
													if($namaPerusahaan!="" && $alamatPerusahaan !="" && $contactPerusahaan!="" && $emailPerusahaan !=""){
														if(!isEmail($emailPerusahaan)){
															$konten.="<div style=\"padding-top:10px; padding-left:5px; background-color: #ffffff; padding-bottom:10px;\"><font color=\"#ffffff\">Failed to Input. Email format must be xxx@yyy.zzz</font>
																<div style=\"padding-top:10px; padding-left:5px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
																</div></div>";
														}
														else{
															$sqlInput="INSERT INTO perusahaan VALUES('','$namaPerusahaan','$alamatPerusahaan','$contactPerusahaan','$emailPerusahaan')";
															$queryInput=mysql_query($sqlInput);
															if(!$queryInput){
																$konten.="<div style=\"padding-top:10px; padding-left:5px; background-color: #607c3c; padding-bottom:10px;\"><font color=\"#ffffff\">Failed to Input some empty fields found</font>
																<div style=\"padding-top:10px; padding-left:5px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
																</div></div>";
															}
															else{
																header("Location: contact.php?token=$token");
															}
														}
													}
													else{
														$konten.="<div style=\"padding-top:10px; padding-left:5px; background-color: #607c3c; padding-bottom:10px;\"><font color=\"#ffffff\">Failed to Input some empty fields found</font>
																<div style=\"padding-top:10px; padding-left:5px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
																</div></div>";
													}
											
												}
									break;
									
									default:
											$sqlView="SELECT * FROM perusahaan";
									$queryView=mysql_query($sqlView);
									$jumView=mysql_num_rows($queryView);
										if($jumView==0){
											$konten.="<div style=\"padding-top:10px; background-color: #607c3c\">No Data</div><div style=\"padding-top:10px; background-color: #607c3c\">
												<a href=\"index.php$token\">Halaman utama</a> 
												<a href=contact.php$token&proses=tambah>Tambah Data</a>
												</div>";
										}
										else{
											$konten.="<table align=\"center\" cellpadding=\"3\" cellspacing=\"0\" width=\"100%\" bgcolor=\"#364b1a\" border=\"0\">
													<tr>
														<td class=\"cart\" style=\"color:#ffffff;\">No</td>
														<td class=\"cart\" style=\"color:#ffffff;\">Nama</td>
														<td class=\"cart\" style=\"color:#ffffff;\">Telepon</td>
														<td class=\"cart\" style=\"color:#ffffff;\">Email</td>
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
																<td>$rowView[namaPerusahaan]</td>
																<td class=\"cart\">$rowView[contactPerusahaan]</td>
																<td class=\"cart\">$rowView[emailPerusahaan]</td>
																<td class=\"cart\">[<a href=\"contact.php$token&proses=edit&id=$rowView[idPerusahaan]\">Edit</a> | <a href=\"contact.php$token&proses=hapus&id=$rowView[idPerusahaan]\" onClick=\"return confirm('Anda Yakin Akan Menghapus?');\">Hapus</a>]</td>
															</tr>
														";
														$i++;
													}
												$konten.="</table>
												<div style=\"padding-top:10px; background-color: #607c3c\">
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
					</center>
					</td>
				</tr>";
			
			$contact=new Admin();
			$contact->setTitle($title);
			$contact->setIsi($konten);
			$contact->setArrayMenu($arrayMenu);
			$contact->setLinkLogout($isiLink);
			$contact->getTampilkan();
				
			
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
