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
			$title=":: $JUDUL | Halaman Network ::";
			$isiLink="<tr><td><a href=\"index2.php?act=logout&token=$_SESSION[ASTA_ADM_HASH]\" class=\"menuItem\" alt=\"Logout\" title=\"Logout\"><div class=\"break\">Logout</div></a></td></tr>";
			$token="?token=".$_SESSION['ASTA_ADM_HASH'];
			$arrayMenu=array("index.php$token"=>'Home',"produk.php$token"=>'Produk',"pemesanan.php$token"=>'Pemesanan',"konfirmasi.php$token"=>'Konfirmasi',"Pelanggan.php$token"=>'Pelanggan',"kategori.php$token"=>'Kategori');
				
			$konten="<tr><td colspan=\"2\" style=\"padding: 10px 10px 10px 10px;\">
							<table cellpadding=\"1\" cellspacing=\"1\" align=\"center\" bgcolor=\"orange\" width=\"100%\">
								<tr bgcolor=\"#607c3c\">
									<div style=\"background: url(./imagea/tab2.jpg); height:23px;\">
									<div style=\"padding-top:4px; text-align:center; width: 723px;\"><font color='#ffffff' style=\"padding-top:20px; font-size:14px\">Network</font>
									</div></div>
									<td>";
							opendb();
								$proses=$_GET['proses'];
								$proses=filter($proses);
								
								switch($proses){
									case 'tambah':
									$konten.="	<div style=\"padding: 10px 10px 10px 10px;\">
												<div style=\"background: orange; color: white; text-align: center; width: 100px;\">New Network</div>
												<div style=\"border: 1px solid orange; padding: 10px 10px 10px 10px; width: 723px;\">";
										$konten.="
											<form action=\"network.php$token&proses=input\" method=\"post\">
												<table>
													<tr>
														<td valign=\"top\" style=\"color:#ffffff\">Network</td>
														<td valign=\"top\" style=\"color:#ffffff\">:</td>
														<td valign=\"top\" style=\"color:#ffffff\"><input type=\"text\" name=\"namaNetwork\" size=\"25\"></td>
													</tr>
													<tr>
														<td valign=\"top\" style=\"color:#ffffff\">Keterangan</td>
														<td valign=\"top\" style=\"color:#ffffff\">:</td>
														<td valign=\"top\" style=\"color:#ffffff\"><textarea id=\"ab\" name=\"keteranganNetwork\" rows=\"10\" cols=\"50\"></textarea></td>
													</tr>
													<tr>
														<td valign=\"top\" style=\"color:#ffffff\">Link Network</td>
														<td valign=\"top\" style=\"color:#ffffff\">:</td>
														<td valign=\"top\" style=\"color:#ffffff\"><input type=\"text\" name=\"linkNetwork\" sixe=\"25\">
														<small>Contoh : www.ASTAPERAGA.COM.com</small>
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
													<tr>
														<td colspan=\"3\" style=\"color:#ffffff\">
															<div style=\"padding-top:10px\" align=\"center\">
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
												<div style=\"background: orange; color: white; text-align: center; width: 100px;\">Input New Network</div>
												<div style=\"border: 1px solid orange; padding: 10px 10px 10px 10px; width: 723px;\">";
										$id=(int)$_GET['id'];
										$token=$_GET['token'];
										$sqlEdit="SELECT * FROM network WHERE idNetwork='$id'";
										$queryEdit=mysql_query($sqlEdit);
										$jumEdit=mysql_num_rows($queryEdit);
											if($jumEdit==0){
												$konten.="<div style=\"padding-top:10px; background-color: #607c3c\">
												<a href=\"index.php$token\">Halaman utama</a> 
												<a href=network.php$token&proses=tambah>Tambah Data</a>
												</div>";
											}
											else{
												$rowEdit=mysql_fetch_array($queryEdit);
												$konten.="
											<form action=\"network.php?token=$token&proses=update\" method=\"post\">
												<table>
													<tr>
														<td style=\"color:#ffffff\">Network</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><input type=\"text\" name=\"namaNetwork\" size=\"25\" value=\"$rowEdit[namaNetwork]\"></td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Keterangan</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><textarea id=\"ab\" name=\"keteranganNetwork\" rows=\"10\" cols=\"50\">$rowEdit[keteranganNetwork]</textarea></td>
													</tr>
													<tr>
														<td valign=\"top\" style=\"color:#ffffff\">Link Network</td>
														<td valign=\"top\" style=\"color:#ffffff\">:</td>
														<td valign=\"top\" style=\"color:#ffffff\"><input type=\"text\" name=\"linkNetwork\" value=\"$rowEdit[linkNetwork]\"></td>
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
																	<td colspan=\"3\" style=\"color:#ffffff\">
																	<div style=\"padding-top:10px\" align=\"center\">
																		<input type=\"submit\" name=\"submit\" value=\"Update\" style=\"border:1px solid grey\">
																		<input type=\"hidden\" name=\"id\" value=\"$rowEdit[idNetwork]\">
																	</div>
																	</td>
																</tr>
															</table>
														</form>
													";
												}
										break;
									
									case 'update':
									$id=(int)$_POST['id'];
									$namaNetwork=$_POST['namaNetwork'];
									$keteranganNetwork=filter($_POST['keteranganNetwork']);
									$idStatusShow=$_POST['idStatusShow'];
									$linkNetwork=$_POST['linkNetwork'];
									$token=$_GET['token'];
										if($namaNetwork!="" && $keteranganNetwork!="" && $idStatusShow !="" && $linkNetwork !=""){
											$sqlUpdate="UPDATE network SET namaNetwork='$namaNetwork', idStatusShow='$idStatusShow', keteranganNetwork='$keteranganNetwork', linkNetwork='$linkNetwork' WHERE idNetwork='$id'";
											$queryUpdate=mysql_query($sqlUpdate);
												if($queryUpdate){
													header("Location: network.php?token=$token");
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
										$queryHapus=mysql_query("DELETE FROM network WHERE idNetwork='$id'");
													if(!$queryHapus){
														$konten.="<div style=\"padding-top:10px; background-color: #607c3c; padding-bottom:10px;\">Failed to delete data
																<div style=\"padding-top:10px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
																</div></div>";
													}
													else{
														header("Location: network.php?token=$token");
													}
									break;
									
									case 'input':
										$token=$_GET['token'];
										$namaNetwork=$_POST['namaNetwork'];
										$idStatusShow=$_POST['idStatusShow'];
										$keteranganNetwork=filter($_POST['keteranganNetwork']);
										$linkNetwork=$_POST['linkNetwork'];
											if(!isset($_POST['submit'])){
												$konten.="Failed";
											}
												else{
													if($namaNetwork!="" && $idStatusShow !="" && $keteranganNetwork!="" && $linkNetwork !=""){
														$sqlInput="INSERT INTO network VALUES('','$namaNetwork','$idStatusShow','$keteranganNetwork','$linkNetwork')";
														$queryInput=mysql_query($sqlInput);
															if(!$queryInput){
																$konten.="<div style=\"padding-top:10px; background-color: #607c3c; padding-bottom:10px;\">Failed to Input data some empty fields found
																<div style=\"padding-top:10px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
																</div></div>";
															}
															else{
																header("Location: network.php?token=$token");
															}
														}
														else{
															$konten.="<div style=\"padding-top:10px; background-color: #607c3c; padding-bottom:10px;\">Failed to Input some empty fields found
																<div style=\"padding-top:10px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
																</div></div>";
														}
													}
									break;
									
									default:
									$sqlView="SELECT N.idNetwork, N.namaNetwork, S.namaStatusShow, S.idStatusShow, N.keteranganNetwork, N.linkNetwork
											  FROM network N, statusshow S 
											  WHERE 
											  N.idStatusShow=S.idStatusShow";
									$queryView=mysql_query($sqlView);
									$jumView=mysql_num_rows($queryView);
										if($jumView==0){
											$konten.="<div style=\"padding-top:10px; background-color: #607c3c\">No Data</div><div style=\"padding-top:10px; background-color: #607c3c\">
												<a href=\"index.php$token\">Halaman utama</a> 
												<a href=network.php$token&proses=tambah>Tambah Data</a>
												</div>";
										}
										else{
										$j=0;
											$konten.="<table align=\"center\" cellpadding=\"3\" cellspacing=\"0\" width=\"100%\" bgcolor=\"#364b1a\" border=\"0\">
													<tr>
														<td class=\"cart\" style=\"color:#ffffff;\">No</td>
														<td class=\"cart\" style=\"color:#ffffff;\">Network</td>
														<td class=\"cart\" style=\"color:#ffffff;\">Status</td>
														<td class=\"cart\" style=\"color:#ffffff;\">Link Network</td>
														<td class=\"cart\" style=\"color:#ffffff;\">Aksi</td>
													</tr>
												";
												$i=1;
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
																<td class=\"cart\">$rowView[namaNetwork]</td>
																<td class=\"cart\">$rowView[namaStatusShow]</td>
																<td class=\"cart\">$rowView[linkNetwork]</td>
																<td class=\"cart\">[<a href=\"network.php$token&proses=edit&id=$rowView[idNetwork]\">Edit</a> | <a href=\"network.php$token&proses=hapus&id=$rowView[idNetwork]\" onClick=\"return confirm('Anda yakin akan menghapus');\">Hapus</a>]</td>
															</tr>";
														$i++;
													}
												$konten.="</table>
												<div style=\"padding-top:10px; background-color: #607c3c\">
												<a href=\"index.php$token\">Halaman utama</a> 
												<a href=network.php$token&proses=tambah>Tambah Data</a>
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
				
			$network=new Admin();
			$network->setTitle($title);
			$network->setIsi($konten);
			$network->setArrayMenu($arrayMenu);
			$network->setLinkLogout($isiLink);
			$network->getTampilkan();
				
			
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
