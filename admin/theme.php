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
			$title=":: $JUDUL | Halaman Theme ::";
			$isiLink="<tr><td><a href=\"index2.php?act=logout&token=$_SESSION[ASTA_ADM_HASH]\" class=\"menuItem\" alt=\"Logout\" title=\"Logout\"><div class=\"break\">Logout</div></a></td></tr>";
			$token="?token=".$_SESSION['ASTA_ADM_HASH'];
			$arrayMenu=array("index.php$token"=>'Home',"produk.php$token"=>'Produk',"pemesanan.php$token"=>'Pemesanan',"konfirmasi.php$token"=>'Konfirmasi',"Pelanggan.php$token"=>'Pelanggan',"kategori.php$token"=>'Kategori');
				
			$konten="<tr><td colspan=\"2\" style=\"padding: 10px 10px 10px 10px;\">
							<table cellpadding=\"1\" cellspacing=\"1\" align=\"center\" bgcolor=\"orange\" width=\"100%\">
								<tr bgcolor=\"#607c3c\">
									<div style=\"background: url(./imagea/tab2.jpg); height:23px;\">
									<div style=\"padding-top:4px; text-align:center; width:723px;\" ><font color='#ffffff' style=\"padding-top:20px; font-size:14px\">Theme</font>
									</div></div>
									<td>";
							opendb();
								$proses=$_GET['proses'];
								$proses=filter($proses);
								
								switch($proses){									
									case 'edit':
									$konten.="	<div style=\"padding: 10px 10px 10px 10px;\">
												<div style=\"background: orange; color: white; text-align: center; width: 100px;\">Edit Theme</div>
												<div style=\"border: 1px solid orange; padding: 10px 10px 10px 10px; width: 723px;\">";
										$id=(int)$_GET['id'];
										$token=$_GET['token'];
										$sqlEdit="SELECT * FROM tema WHERE idTema='$id'";
										$queryEdit=mysql_query($sqlEdit);
										$jumEdit=mysql_num_rows($queryEdit);
											if($jumEdit==0){
												$konten.="<div style=\"padding-top:10px; background-color: #607c3c\">
												<a href=\"index.php$token\">Halaman utama</a> 
												<a href=tema.php$token&proses=tambah>Tambah Data</a>
												</div>";
											}
											else{
												$rowEdit=mysql_fetch_array($queryEdit);
												$konten.="
														<form action=\"theme.php?token=$token&proses=update\" method=\"post\" ENCTYPE=\"MULTIPART/FORM-DATA\">
															<table align=\"center\" width=\"100%\">
																<tr>
																	<td style=\"color:#ffffff;\" width=\"20% \">Tema Background</td>
																	<td style=\"color:#ffffff\">:</td>
																	<td style=\"color:#ffffff\"><input style=\"background-color:#$rowEdit[backTema];\" type=\"text\" name=\"backTema\" size=\"30\" value=\"$rowEdit[backTema]\"></td>
																</tr>
																<tr>
																	<td style=\"color:#ffffff;\" width=\"20% \">Tema Body</td>
																	<td style=\"color:#ffffff\">:</td>
																	<td style=\"color:#ffffff\"><input style=\"background-color:#$rowEdit[bodyTema];\" type=\"text\" name=\"bodyTema\" size=\"30\" value=\"$rowEdit[bodyTema]\"></td>
																</tr>
																<tr>
																	<td style=\"color:#ffffff\">Trip Tema</td>
																	<td style=\"color:#ffffff\">:</td>
																	<td style=\"color:#ffffff\"><input style=\"background-color:#$rowEdit[tripTema];\"type=\"text\" name=\"tripTema\" size=\"30\" value=\"$rowEdit[tripTema]\"></td>
																</tr>
																<tr>
																	<td style=\"color:#ffffff\">Text Trip Tema</td>
																	<td style=\"color:#ffffff\">:</td>
																	<td style=\"color:#ffffff\"><input style=\"background-color:#$rowEdit[tripTextTema];\"type=\"text\" name=\"tripTextTema\" size=\"30\" value=\"$rowEdit[tripTextTema]\"></td>
																</tr>
																<tr>
																	<td style=\"color:#ffffff\">Title</td>
																	<td style=\"color:#ffffff\">:</td>
																	<td style=\"color:#ffffff\"><input type=\"text\" name=\"title\" size=\"30\" value=\"$rowEdit[title]\"></td>
																</tr>
																<tr>
																	<td style=\"color:#ffffff\">Rincian</td>
																	<td style=\"color:#ffffff\">:</td>
																	<td style=\"color:#ffffff\"><input type=\"text\" name=\"rincian\" size=\"30\" value=\"$rowEdit[rincian]\"></td>
																</tr>
																<tr>
																	<td style=\"color:#ffffff\">Domain</td>
																	<td style=\"color:#ffffff\">:</td>
																	<td style=\"color:#ffffff\"><input type=\"text\" name=\"domain\" size=\"30\" value=\"$rowEdit[domain]\"></td>
																</tr>
																<tr>
																	<td style=\"color:#ffffff\">Banner Tema Sekarang</td>
																	<td style=\"color:#ffffff\">:</td>
																	<td style=\"color:#ffffff\"><img src=\"../imagea/$rowEdit[banerTema]\" td></td>
																</tr>
																<tr>
																	<td style=\"color:#ffffff\">Banner Trip Tema Sekarang</td>
																	<td style=\"color:#ffffff\">:</td>
																	<td style=\"color:#ffffff\"><img src=\"../imagea/$rowEdit[banerTripTema]\"></td></td>
																</tr>
																<tr>
																	<td style=\"color:#ffffff\">Ganti Banner Tema</td>
																	<td style=\"color:#ffffff\">:</td>
																	<td style=\"color:#ffffff\"><input type=\"file\" name=\"banerTemaBaru\" size=\"30\">
																	<div>
																		<small>Kosongkan jika tidak ingin merubah baner tema sebelumnya</small>
																	</div>
																	</td>
																</tr>
																<tr>
																	<td style=\"color:#ffffff\">Ganti Banner Trip Tema</td>
																	<td style=\"color:#ffffff\">:</td>
																	<td style=\"color:#ffffff\"><input type=\"file\" name=\"banerTripTemaBaru\" size=\"30\">
																	<div>
																		<small>Kosongkan jika tidak ingin merubah baner trip tema sebelumnya</small>
																	</div>
																	</td>
																</tr>
																<tr>
																	<td style=\"color:#ffffff\">Toko Online</td>
																	<td style=\"color:#ffffff\">:</td>
																	<td style=\"color:#ffffff\">";
																		$sql_ol="SELECT online FROM tema";
																		$query_ol=mysql_query($sql_ol,opendb())or die(mysql_error());
																		if($query_ol != null) {
																			if(mysql_num_rows($query_ol)==1) {
																				$row_ol=mysql_fetch_array($query_ol);
																				$ol=$row_ol['online'];																				
																				for($i=0; $i<2; $i++) {
																					if($i==0) {
																						$text="Tidak";
																					}
																					else {
																						$text="Ya";
																					}
																					if($i==$ol) {
																						$konten.="	<input type=\"radio\" name=\"online\" value=\"$ol\" checked>$text";
																					}
																					else {
																						$konten.="	<input type=\"radio\" name=\"online\" value=\"$i\">$text";
																					}
																				}
																			}
																		}																		
														$konten.="	</td>
																</tr>
																<tr>
																	<td colspan=\"3\" style=\"color:#ffffff\">
																	<div align=\"center\" style=\"padding-top:10px;\">
																		<input type=\"submit\" name=\"submit\" value=\"Update\" style=\"border:1px solid grey\">
																		<input type=\"reset\" name=\"reset\" value=\"Reset\" style=\"border:1px solid grey\">
																		<input type=\"hidden\" name=\"maksFile\" value=\"1000000\">
																		<input type=\"hidden\" name=\"id\" value=$rowEdit[idTema]>
																		<input type=\"hidden\" name=\"banerTema\" value=$rowEdit[banerTema]>
																		<input type=\"hidden\" name=\"banerTripTema\" value=$rowEdit[banerTripTema]>
																	</div>
																	</td>
																</tr>
															</table>
														</form>
													";		$konten.="<input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">";
												}
										break;
									
									case 'update':
									$id=(int)$_POST['id'];
									$ol=$_POST['online'];
									$backTema=$_POST['backTema'];
									$bodyTema=$_POST['bodyTema'];
									$tripTema=$_POST['tripTema'];
									$tripTextTema=$_POST['tripTextTema'];
									$title=$_POST['title'];
									$rincian=$_POST['rincian'];
									$domain=$_POST['domain'];
									$banerTemaBaruName=$_FILES['banerTemaBaru']['name'];
									$banerTemaBaruType=$_FILES['banerTemaBaru']['type'];
									$banerTemaBaruSize=$_FILES['banerTemaBaru']['size'];
									$banerTripTemaBaruName=$_FILES['banerTripTemaBaru']['name'];
									$banerTripTemaBaruType=$_FILES['banerTripTemaBaru']['type'];
									$banerTripTemaBaruSize=$_FILES['banerTripTemaBaru']['size'];
									$maksFile=$_POST['maksFile'];
									$token=$_GET['token'];
										if($backTema !="" && $bodyTema!="" && $tripTema!="" && $tripTextTema !="" && $title !="" && $rincian !="" && $domain !=""){
											if($_FILES['banerTemaBaru']['error']=='0'&&$_FILES['banerTripTemaBaru']['error']=='0'){
												if($banerTemaBaruSize <= $maksFile && $banerTripTemaBaruSize <= $maksFile){
													if(($banerTemaBaruType == "image/jpg" || $banerTemaBaruType == "image/jpeg" || $banerTemaBaruType == "image/bmp" || $banerTemaBaruType == "image/gif" || $banerTemaBaruType == "image/png") && 
													($banerTripTemaBaruType == "image/jpg" || $banerTripTemaBaruType == "image/jpeg" || $banerTripTemaBaruType == "image/bmp" || $banerTripTemaBaruType == "image/gif" || $banerTripTemaBaruType == "image/png")){
														$sqlUpdate="UPDATE tema 
																	SET bodyTema = '$bodyTema', 
																		backTema = '$backTema', 
																		tripTema = '$tripTema', 
																		tripTextTema = '$tripTextTema', 
																		banerTema = '$banerTemaBaruName', 
																		banerTripTema = '$banerTripTemaBaruName',
																		domain = '$domain',
																		title = '$title',
																		rincian = '$rincian', 
																		online = '$ol' 
																		WHERE idTema='$id'";
														$queryUpdate=mysql_query($sqlUpdate)or die(mysql_error());
														copy($HTTP_POST_FILES['banerTemaBaru']['tmp_name'],"../imagea/".$_FILES['banerTemaBaru']['name']);
														copy($HTTP_POST_FILES['banerTripTemaBaru']['tmp_name'],"../imagea/".$_FILES['banerTripTemaBaru']['name']);														
														unlink("../imagea/".$_POST['banerTema']);
														unlink("../imagea/".$_POST['banerTripTema']);															
														if($queryUpdate){
															header("Location: theme.php?token=$token");
														}
														else{
															$konten.="<div style=\"padding-top:10px; padding-left:5px; background-color: #607c3c; padding-bottom:10px;\"><font color=#ffffff>Failed to Update some empty fields found</font>
																		<div style=\"padding-top:10px; padding-left:5px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
																		</div></div>";
														}
													}
													else{
														$konten.="<div style=\"padding-top:10px; padding-left:5px; background-color: #607c3c; padding-bottom:10px;\"><font color=#ffffff>Failed to Update. Image Must be JPEG, JPG, BMP, PNG or GIF format</font>
														<div style=\"padding-top:10px; padding-left:5px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
														</div></div>";
													}
												}
												else{
													$konten.="<div style=\"padding-top:10px; padding-left:5px; background-color: #607c3c; padding-bottom:10px;\"><font color=#ffffff>Failed to Update. Image size is longer than 1 Mb</font>
														<div style=\"padding-top:10px; padding-left:5px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
														</div></div>";
												}
											}
											elseif($_FILES['banerTemaBaru']['error']=='4'&&$_FILES['banerTripTemaBaru']['error']=='4'){
												$token=$_GET['token'];
												$sqlUpdate="UPDATE tema SET 
												bodyTema = '$bodyTema', 
												backTema = '$backTema',
												tripTema = '$tripTema', 
												tripTextTema = '$tripTextTema', 
												domain = '$domain',
												title = '$title',
												rincian = '$rincian', 
												online = '$ol' 
												WHERE idTema='$id'";
												$queryUpdate=mysql_query($sqlUpdate);
												if($queryUpdate){
													header("Location: theme.php?token=$token");
												}
												else{
													$konten.="<div style=\"padding-top:10px; padding-left:5px; background-color: #607c3c; padding-bottom:10px;\"><font color=#ffffff>Failed to Update some empty fields found</font>
													<div style=\"padding-top:10px; padding-left:5px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
													</div></div>";
												}
											}
											else{
												$konten.="<div style=\"padding-top:10px; padding-left:5px; background-color: #607c3c; padding-bottom:10px;\"><font color=#ffffff>Failed to Update some empty fields found2</font>
													<div style=\"padding-top:10px; padding-left:5px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
													</div></div>";
											}
										}
										else{
											$konten.="<div style=\"padding-top:10px; padding-left:5px; background-color: #607c3c; padding-bottom:10px;\"><font color=#ffffff>Failed to Update some empty fields found3</font>
													<div style=\"padding-top:10px; padding-left:5px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
													</div></div>";
										}
									break;
									
									
									default:
									$sqlView="SELECT * FROM tema";
									$queryView=mysql_query($sqlView);
									$jumView=mysql_num_rows($queryView);
										if($jumView==0){
											$konten.="<div style=\"padding-top:10px; background-color: #607c3c;\">No Data</div><div style=\"padding-top:10px; background-color: #607c3c\">
												<a href=\"index.php$token\">Halaman utama</a> 
												<a href=tema.php$token&proses=tambah>Tambah Data</a>
												</div>";
										}
										else{
											$konten.="<table align=\"center\" cellpadding=\"3\" cellspacing=\"0\" width=\"100%\" bgcolor=\"#364b1a\" border=\"0\">
													<tr>
														<td class=\"cart\" style=\"color:#ffffff;\">No</td>
														<td class=\"cart\" style=\"color:#ffffff;\">Tema Body</td>
														<td class=\"cart\" style=\"color:#ffffff;\">Trip Tema</td>
														<td class=\"cart\" style=\"color:#ffffff;\">Teks Trip Tema</td>
														<td class=\"cart\" style=\"color:#ffffff;\">Title</td>
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
																<td class=\"cart\">$rowView[bodyTema]</td>
																<td class=\"cart\">$rowView[tripTema]</td>
																<td class=\"cart\">$rowView[tripTextTema]</td>
																<td class=\"cart\">$rowView[title]</td>
																<td class=\"cart\">[<a href=\"theme.php$token&proses=edit&id=$rowView[idTema]\">Edit</a>]</td>
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
			
			$tema=new Admin();
			$tema->setTitle($title);
			$tema->setIsi($konten);
			$tema->setArrayMenu($arrayMenu);
			$tema->setLinkLogout($isiLink);
			$tema->getTampilkan();
				
			
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
