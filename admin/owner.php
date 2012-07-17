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
			$title=":: $JUDUL | Halaman Customer Service ::";
			$isiLink="<tr><td><a href=\"index2.php?act=logout&token=$_SESSION[ASTA_ADM_HASH]\" class=\"menuItem\" alt=\"Logout\" title=\"Logout\"><div class=\"break\">Logout</div></a></td></tr>";
			$token="?token=".$_SESSION['ASTA_ADM_HASH'];
			$arrayMenu=array("index.php$token"=>'Home',"produk.php$token"=>'Produk',"pemesanan.php$token"=>'Pemesanan',"konfirmasi.php$token"=>'Konfirmasi',"Pelanggan.php$token"=>'Pelanggan',"kategori.php$token"=>'Kategori');
				
			$konten="<tr><td colspan=\"2\" style=\"padding: 10px 10px 10px 10px;\">
							<table cellpadding=\"1\" cellspacing=\"1\" align=\"center\" bgcolor=\"orange\" width=\"100%\">
								<tr bgcolor=\"#607c3c\">
									<div style=\"background: url(./imagea/tab2.jpg); height:23px;\">
									<div align=\"center\" style=\"padding-top:4px; width:723px\"><font color='#ffffff' style=\"padding-top:20px; font-size:14px\">Customer Service</font>
									</div></div>
									<td>";
								
								opendb();
								$proses=$_GET['proses'];
								$proses=filter($proses);
								
								switch($proses){
									case 'tambah':
									$konten.="	<div style=\"padding: 10px 10px 10px 10px;\">
												<div style=\"background: orange; color: white; text-align: center; width: 100px;\">Input New Customer Service</div>
												<div style=\"border: 1px solid orange; padding: 10px 10px 10px 10px; width: 723px;\">";
										$konten.="
											<form action=\"owner.php$token&proses=input\" method=\"post\">
												<table align=\"center\">
													<tr>
														<td style=\"color:#ffffff\">Nama Customer Service</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><input type=\"text\" name=\"namaOwner\" size=\"25\"></td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Email</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><input type=\"text\" name=\"emailOwner\" size=\"25\"></td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Contact Customer Service</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><input type=\"text\" name=\"contactOwner\" size=\"25\"></td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Tampilkan</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\">
															<input type=\"radio\" name=\"idStatusShow\" value=\"1\">Ya
															<input type=\"radio\" name=\"idStatusShow\" value=\"2\">Tidak
														</td>
													</tr>
													<tr>
														<td colspan=\"3\" style=\"color:#ffffff\" align=\"center\">
															<input type=\"submit\" name=\"submit\" value=\"Input\" style=\"border:1px solid grey\">
															<input type=\"reset\" name=\"reset\" value=\"Reset\" style=\"border:1px solid grey\">
														</td>
													</tr>
												</table>
											</form>
										";
									break;
									
									case 'edit':
									$konten.="	<div style=\"padding: 10px 10px 10px 10px;\">
												<div style=\"background: orange; color: white; text-align: center; width: 170px;\">Edit Customer Service</div>
												<div style=\"border: 1px solid orange; padding: 10px 10px 10px 10px; width: 723px;\">";
										$id=filter($_GET['id']);
										$token=$_GET['token'];
										$sqlEdit="SELECT * FROM owner Service WHERE idOwner='$id'";
										$queryEdit=mysql_query($sqlEdit);
										$jumEdit=mysql_num_rows($queryEdit);
											if($jumEdit==0){
												$konten.="<div style=\"padding-top:10px; background-color: #607c3c\">No Data
												<a href=\"index.php$token\">Halaman utama</a> 
												<a href=owner.php$token&proses=tambah>Tambah Data</a>
												</div>";
											}
											else{
												$rowEdit=mysql_fetch_array($queryEdit);
												$konten.="
											<form action=\"owner.php?token=$token&proses=update\" method=\"post\">
												<table align=\"center\">
													<tr>
														<td style=\"color:#ffffff\">Nama Customer Service</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><input type=\"text\" name=\"namaOwner\" size=\"25\" value=\"$rowEdit[namaOwner]\"></td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Email Customer Service</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><input type=\"text\" name=\"emailOwner\" size=\"25\" value=\"$rowEdit[emailOwner]\"></td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Contact Customer Service</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><input type=\"text\" name=\"contactOwner\" size=\"25\" value=\"$rowEdit[contactOwner]\"></td>
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
																		<input type=\"hidden\" name=\"id\" value=\"$rowEdit[idOwner]\">
																	</td>
																</tr>
															</table>
														</form>
													";
												}
										break;
									
									case 'update':
									$id=(int)$_POST['id'];
									$namaOwner=$_POST['namaOwner'];
									$emailOwner=$_POST['emailOwner'];
									$idStatusShow=$_POST['idStatusShow'];
									$contactOwner=$_POST['contactOwner'];
									$token=$_GET['token'];
										if($namaOwner!="" && $emailOwner!="" && $contactOwner !="" && $idStatusShow !=""){
											$sqlUpdate="UPDATE owner SET namaOwner='$namaOwner', emailOwner='$emailOwner', contactOwner='$contactOwner', idStatusShow='$idStatusShow' WHERE idOwner='$id'";
											$queryUpdate=mysql_query($sqlUpdate);
												if($queryUpdate){
													header("Location: owner.php?token=$token");
												}
												else{
													$konten.="<div style=\"padding-top:10px; background-color: #607c3c; padding-bottom:10px;\">Failed to update data
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
										$queryHapus=mysql_query("DELETE FROM owner WHERE idOwner='$id'");
													if(!$queryHapus){
														$konten.="<div style=\"padding-top:10px; background-color: #607c3c; padding-bottom:10px;\">Failed to delete data
																<div style=\"padding-top:10px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
																</div></div>";
													}
													else{
														header("Location: owner.php?token=$token");
													}
									break;
									
									case 'input':
										$token=$_GET['token'];
										$namaOwner=$_POST['namaOwner'];
										$emailOwner=$_POST['emailOwner'];
										$contactOwner=$_POST['contactOwner'];
										$idStatusShow=$_POST['idStatusShow'];
										if(!isset($_POST['submit'])){
												$konten.="<div style=\"padding-top:10px; background-color: #607c3c; padding-bottom:10px;\">Failed to input data
														<div style=\"padding-top:10px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
														</div></div>";
											}
												else{
													if($namaOwner!="" && $emailOwner !="" && $contactOwner !="" && $idStatusShow !=""){
														$sqlInput="INSERT INTO owner VALUES('','$namaOwner','$emailOwner','$contactOwner','$idStatusShow')";
														$queryInput=mysql_query($sqlInput);
															if(!$queryInput){
																$konten.="<div style=\"padding-top:10px; background-color: #607c3c; padding-bottom:10px;\">Failed to input data
																<div style=\"padding-top:10px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
																</div></div>";
															}
															else{
																header("Location: owner.php?token=$token");
															}
													}
													else{
														$konten.="<div style=\"padding-top:10px; background-color: #607c3c; padding-bottom: 10px\">Failed to input data some empty fields found
														<div style=\"padding-top:10px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
														</div></div>";
													}
													
												}												
									break;
									
									default:
									$sqlView="SELECT O.idOwner, O.namaOwner, O.emailOwner, O.contactOwner, S.namaStatusShow, S.idStatusShow 
											FROM owner O, statusshow S 
											WHERE 
											O.idStatusShow=S.idStatusShow";
									$queryView=mysql_query($sqlView);
									$jumView=mysql_num_rows($queryView);
										if($jumView==0){
											$konten.="<div style=\"padding-top:10px; background-color: #607c3c\">
												<a href=\"index.php$token\">Halaman utama</a> 
												<a href=owner.php$token&proses=tambah>Tambah Data</a>
												</div>";
										}
										else{
											$konten.="<table align=\"center\" cellpadding=\"3\" cellspacing=\"0\" width=\"100%\" bgcolor=\"#364b1a\" border=\"0\">
													<tr>
														<td class=\"cart\" style=\"color:#ffffff;\" >No</td>
														<td class=\"cart\" style=\"color:#ffffff;\" >Customer Service</td>
														<td class=\"cart\" style=\"color:#ffffff;\" >Email</td>
														<td class=\"cart\" style=\"color:#ffffff;\" >Contact</td>
														<td class=\"cart\" style=\"color:#ffffff;\" >Status</td>
														<td class=\"cart\" style=\"color:#ffffff;\" >Aksi</td>
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
																<td class=\"cart\" >$i</td>
																<td>$rowView[namaOwner]</td>
																<td class=\"cart\" >$rowView[emailOwner]</td>
																<td class=\"cart\" >$rowView[contactOwner]</td>
																<td class=\"cart\" >$rowView[namaStatusShow]</td>
																<td class=\"cart\" >[<a href=\"owner.php$token&proses=edit&id=$rowView[idOwner]\">Edit</a> | <a href=\"owner.php$token&proses=hapus&id=$rowView[idOwner]\" onClick=\"return confirm('Anda Yakin Akan Menghapus?');\">Hapus</a>]</td>
															</tr>";
														$i++;
													}
												$konten.="</table>
												<div style=\"padding-top:10px; background-color: #607c3c\">
												<a href=\"index.php$token\">Halaman utama</a> 
												<a href=owner.php$token&proses=tambah>Tambah Data</a>
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
				
			$owner=new Admin();
			$owner->setTitle($title);
			$owner->setIsi($konten);
			$owner->setArrayMenu($arrayMenu);
			$owner->setLinkLogout($isiLink);
			$owner->getTampilkan();
				
			
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
