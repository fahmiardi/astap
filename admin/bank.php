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
			$title=":: $JUDUL | Halaman Bank ::";
			$isiLink="<tr><td><a href=\"index2.php?act=logout&token=$_SESSION[ASTA_ADM_HASH]\" class=\"menuItem\" alt=\"Logout\" title=\"Logout\"><div class=\"break\">Logout</div></a></td></tr>";
			$token="?token=".$_SESSION['ASTA_ADM_HASH'];
			$arrayMenu=array("index.php$token"=>'Home',"produk.php$token"=>'Produk',"pemesanan.php$token"=>'Pemesanan',"konfirmasi.php$token"=>'Konfirmasi',"Pelanggan.php$token"=>'Pelanggan',"kategori.php$token"=>'Kategori');
				
			$konten="<tr><td colspan=\"2\" style=\"padding: 10px 10px 10px 10px;\">
							<table cellpadding=\"1\" cellspacing=\"1\" align=\"center\" bgcolor=\"orange\" width=\"100%\">
								<tr bgcolor=\"#607c3c\">
									<div style=\"background: url(./imagea/tab2.jpg); height:23px;\">
									<div style=\"padding-top:4px; text-align:center; width:723px;\" ><font color='#ffffff' style=\"padding-top:20px; font-size:14px\">Bank</font>
									</div></div>
									<td>";
							opendb();
								$proses=$_GET['proses'];
								$proses=filter($proses);
								
								switch($proses){
									case 'tambah':
									$konten.="	<div style=\"padding: 10px 10px 10px 10px;\">
												<div style=\"background: orange; color: white; text-align: center; width: 100px;\">Input Data Bank</div>
												<div style=\"border: 1px solid orange; padding: 10px 10px 10px 10px; width: 723px;\">";
										$konten.="
											<form action=\"bank.php$token&proses=input\" method=\"post\" ENCTYPE=\"MULTIPART/FORM-DATA\">
												<table align=\"center\">
													<tr>
														<td style=\"color:#ffffff\">Nama Bank</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><input type=\"text\" name=\"namaBank\" size=\"30\"></td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">No Rekening Bank</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><input type=\"text\" name=\"noRekBank\" size=\"30\"></td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Nama Pemilik</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><input type=\"text\" name=\"namaPemilik\" size=\"30\"></td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Cabang</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><input type=\"text\" name=\"cabang\" size=\"30\"></td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Gambar</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><input type=\"file\" name=\"image\" size=\"30\"></td>
													</tr>
													<tr>
														<td colspan=\"3\" style=\"color:#ffffff\">
														<div align=\"center\" style=\"padding-top:10px;\">
															<input type=\"submit\" name=\"submit\" value=\"Input\" style=\"border:1px solid grey\">
															<input type=\"reset\" name=\"reset\" value=\"Reset\" style=\"border:1px solid grey\">
															<input type=\"hidden\" name=\"maksFile\" value=\"1000000\">
														</div>
														</td>
													</tr>
												</table>
											</form>
										";
									break;
									
									case 'edit':
									$konten.="	<div style=\"padding: 10px 10px 10px 10px;\">
												<div style=\"background: orange; color: white; text-align: center; width: 100px;\">Edit Data Bank</div>
												<div style=\"border: 1px solid orange; padding: 10px 10px 10px 10px; width: 723px;\">";
										$id=filter($_GET['id']);
										$token=$_GET['token'];
										$sqlEdit="SELECT * FROM bank WHERE idBank='$id'";
										$queryEdit=mysql_query($sqlEdit);
										$jumEdit=mysql_num_rows($queryEdit);
											if($jumEdit==0){
												$konten.="<div style=\"padding-top:10px; background-color: #607c3c\">
												<a href=\"index.php$token\">Halaman utama</a> 
												<a href=bank.php$token&proses=tambah>Tambah Data</a>
												</div>";
											}
											else{
												$rowEdit=mysql_fetch_array($queryEdit);
												$konten.="
											<form action=\"bank.php?token=$token&proses=update\" method=\"post\" ENCTYPE=\"MULTIPART/FORM-DATA\">
												<table align=\"center\" width=\"100%\">
													<tr>
														<td style=\"color:#ffffff\">Nama Bank</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><input type=\"text\" name=\"namaBank\" size=\"25\" value=\"$rowEdit[namaBank]\"></td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">No Rekening Bank</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><input type=\"text\" name=\"noRekBank\" size=\"25\" value=\"$rowEdit[noRekBank]\"></td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Nama Pemilik</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><input type=\"text\" name=\"namaPemilik\" size=\"25\" value=\"$rowEdit[namaPemilik]\"></td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Cabang</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><input type=\"text\" name=\"cabang\" size=\"25\" value=\"$rowEdit[cabang]\"></td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Image</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><img src=\"../imagea/".$rowEdit[image]."\" width=\"70px\" height=\"46px\"></td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Image Baru</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><input type=\"file\" name=\"imageBaru\" size=\"25\">
														<small>Kosongkan saja jika tidak ingin merubah gambar sebelumnya</small>
														</td>
													</tr>
													<tr>
														<td colspan=\"3\" style=\"color:#ffffff\">
																		<input type=\"submit\" name=\"submit\" value=\"Update\" style=\"border:1px solid grey\">
																		<input type=\"hidden\" name=\"id\" value=\"$rowEdit[idBank]\">
																		<input type=\"hidden\" name=\"image\" value=\"$rowEdit[image]\">
																		<input type=\"hidden\" name=\"maksFile\" value=\"1000000\">
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
									$namaBank=filter($_POST['namaBank']);
									$noRekBank=filter($_POST['noRekBank']);
									$namaPemilik=filter($_POST['namaPemilik']);
									$cabang=filter($_POST['cabang']);
									$imageBaruName=$_FILES['imageBaru']['name'];
									$imageBaruType=$_FILES['imageBaru']['type'];
									$imageBaruSize=$_FILES['imageBaru']['size'];
									$maksFile=$_POST['maksFile'];
									$noImage="noImage.gif";		
									$token=$_GET['token'];
										if($namaBank!="" && $namaPemilik!="" && $noRekBank !="" && $namaPemilik !="" && $cabang !=""){
											if($_FILES['imageBaru']['error']=='0'){
												if($imageBaruSize <= $maksFile){
													if($imageBaruType == "image/jpg" || $imageBaruType == "image/jpeg" || $imageBaruType == "image/bmp" || $imageBaruType == "image/gif" || $imageBaruType == "image/png"){
														$sqlUpdate="UPDATE bank 
																	SET namaBank = '$namaBank', 
																		noRekBank = '$noRekBank', 
																		namaPemilik = '$namaPemilik', 
																		cabang = '$cabang', 
																		image = '$imageBaruName' 
																		WHERE idBank='$id'";
														$queryUpdate=mysql_query($sqlUpdate)or die(mysql_error());
														copy($HTTP_POST_FILES['imageBaru']['tmp_name'],"../imagea/".$_FILES['imageBaru']['name']);
														if($_POST['image']==$noImage){
															//nothing
														}
														else{
															unlink("../imagea/".$_POST['image']);
														}
															if($queryUpdate){
																header("Location: bank.php?token=$token");
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
											elseif($_FILES['imageBaru']['error']=='4'){
												$sqlUpdate="UPDATE bank SET 
												namaBank = '$namaBank', 
												noRekBank = '$noRekBank', 
												namaPemilik = '$namaPemilik', 
												cabang = '$cabang' 
												WHERE idBank='$id'";
												$queryUpdate=mysql_query($sqlUpdate);
												if($queryUpdate){
													header("Location: bank.php?token=$token");
												}
												else{
													$konten.="<div style=\"padding-top:10px; padding-left:5px; background-color: #607c3c; padding-bottom:10px;\"><font color=#ffffff>Failed to Update some empty fields found</font>
													<div style=\"padding-top:10px; padding-left:5px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
													</div></div>";
												}
											}
											else{
												
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
										$sqlGambar="SELECT image FROM bank WHERE idBank='$id'";
										$queryGambar=mysql_query($sqlGambar);
										$rowGambar=mysql_fetch_array($queryGambar);
										$noImage="noImage.gif";
										$queryHapus=mysql_query("DELETE FROM bank WHERE idBank='$id'");
											if(!$queryHapus){
												$konten.="<div style=\"padding-top:10px; padding-left:5px; background-color: #607c3c; padding-bottom:10px;\"><font color=#ffffff>Failed to delete</font>
												<div style=\"padding-top:10px; padding-left:5px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
												</div></div>";
											}
											else{
												if($rowGambar[image]==$noImage){
													//NOTHING
												}
												else{
													unlink("../imagea/".$rowGambar[image]);
												}
												header("Location: bank.php?token=$token");
											}
									break;
									
									case 'input':
										$token=$_GET['token'];
										$namaBank=filter($_POST['namaBank']);
										$noRekBank=filter($_POST['noRekBank']);
										$namaPemilik=filter($_POST['namaPemilik']);
										$cabang=filter($_POST['cabang']);
										$imageName=$_FILES['image']['name'];
										$imageType=$_FILES['image']['type'];
										$imageSize=$_FILES['image']['size'];
										$maksFile=$_POST['maksFile'];
												if($namaBank !="" && $noRekBank !="" && $namaPemilik !="" && $cabang !=""){
													if($_FILES['image']['error']=='0'){
														if($imageType == "image/jpg" || $imageType == "image/jpeg" || $imageType == "image/png" || $imageType == "image/gif" || $imageType=="image/bmp"){
															if($imageSize <= $maksFile){
																$sqlInput="INSERT INTO bank 
																VALUES
																('','$namaBank','$noRekBank','$namaPemilik','$cabang','$imageName')";
																$queryInput=mysql_query($sqlInput);
																$noImage="noImage.gif";
																if($imageName==$noImage) {
																	//not copy
																}
																else {
																	copy($HTTP_POST_FILES['image']['tmp_name'],"../imagea/".$_FILES['image']['name']);
																}																
																if($queryInput){
																	header("Location: bank.php?token=$token");
																}
																else{
																	$konten.="<div style=\"padding-top:10px; padding-left:5px; background-color: #607c3c; padding-bottom:10px;\"><font color=#ffffff>Failed to Input.</font>
																	<div style=\"padding-top:10px; padding-left:5px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
																	</div></div>";
																}
															}
															else{
																$konten.="<div style=\"padding-top:10px; padding-left:5px; background-color: #607c3c; padding-bottom:10px;\"><font color=#ffffff>Failed to Input.Image Size must not be longer than 1 Mb</font>
																<div style=\"padding-top:10px; padding-left:5px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
																</div></div>";
															}
														}
														else{
															$konten.="<div style=\"padding-top:10px; padding-left:5px; background-color: #607c3c; padding-bottom:10px;\"><font color=#ffffff>Failed to Input. Image must be JPEG, JPG, BMP, GIF or PNG format</font>
																<div style=\"padding-top:10px; padding-left:5px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
																</div></div>";
														}
													}
													elseif($_FILES['image']['error']=='4'){
														$noImage="noImage.gif";
														if($namaBank !="" && $noRekBank !="" && $namaPemilik !="" && $cabang !=""){
															$sqlInput="INSERT INTO bank 
																		VALUES
																		('','$namaBank','$noRekBank','$namaPemilik','$cabang','$noImage')";
															$queryInput=mysql_query($sqlInput);
																if($queryInput){
																	header("Location: bank.php?token=$token");
																}
																else{
																	$konten.="<div style=\"padding-top:10px; padding-left:5px; background-color: #607c3c; padding-bottom:10px;\"><font color=#ffffff>Failed to Input.</font>
																			<div style=\"padding-top:10px; padding-left:5px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
																			</div></div>";
																}
														}
														else{
															$konten.="<div style=\"padding-top:10px; padding-left:5px; background-color: #607c3cf; padding-bottom:10px;\"><font color=#ffffff>Failed to Input some empty fields found</font>
																	<div style=\"padding-top:10px; padding-left:5px; \"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
																	</div></div>";
														}
													}
													else{
														
													}
												}
												else{
													$konten.="<div style=\"padding-top:10px; padding-left:5px;background-color: #607c3c; padding-bottom:10px;\"><font color=#ffffff>Failed to Input some empty fields found</font>
																<div style=\"padding-top:10px; padding-left:5px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
																</div></div>";
													}
									break;
									
									default:
									$sqlView="SELECT * FROM bank";
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
														<td class=\"cart\" style=\"color:#ffffff;\">Nama Bank</td>
														<td class=\"cart\" style=\"color:#ffffff;\">No Rekening</td>
														<td class=\"cart\" style=\"color:#ffffff;\">Nama Pemilik</td>
														<td class=\"cart\" style=\"color:#ffffff;\">Cabang</td>
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
																<td class=\"cart\">$rowView[namaBank]</td>
																<td class=\"cart\">$rowView[noRekBank]</td>
																<td class=\"cart\">$rowView[namaPemilik]</td>
																<td class=\"cart\">$rowView[cabang]</td>
																<td class=\"cart\">[<a href=\"bank.php$token&proses=edit&id=$rowView[idBank]\">Edit</a> | <a href=\"bank.php$token&proses=hapus&id=$rowView[idBank]\" onClick=\"return confirm('Anda Yakin Akan Menghapus?');\">Hapus</a>]</td>
															</tr>
														";
														$i++;
													}
												$konten.="</table>
												<div style=\"padding-top:10px; background-color: #607c3c\">
												<a href=\"index.php$token\">Halaman utama</a> 
												<a href=bank.php$token&proses=tambah>Tambah Data</a>
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
			
			$bank=new Admin();
			$bank->setTitle($title);
			$bank->setIsi($konten);
			$bank->setArrayMenu($arrayMenu);
			$bank->setLinkLogout($isiLink);
			$bank->getTampilkan();
				
			
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
