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
			$title=":: $JUDUL | Halaman Produk ::";
			$isiLink="<tr><td><a href=\"index2.php?act=logout&token=$_SESSION[ASTA_ADM_HASH]\" class=\"menuItem\" alt=\"Logout\" title=\"Logout\"><div class=\"break\">Logout</div></a></td></tr>";
			$token="?token=".$_SESSION['ASTA_ADM_HASH'];
			$arrayMenu=array("index.php$token"=>'Home',"produk.php$token"=>'Produk',"pemesanan.php$token"=>'Pemesanan',"konfirmasi.php$token"=>'Konfirmasi',"Pelanggan.php$token"=>'Pelanggan',"kategori.php$token"=>'Kategori');
				
			$konten="<tr><td colspan=\"2\" style=\"padding: 10px 10px 10px 10px;\">
							<table cellpadding=\"1\" cellspacing=\"1\" align=\"center\" bgcolor=\"orange\" width=\"100%\">
								<tr bgcolor=\"#607c3c\">
									<div style=\"background: url(./imagea/tab2.jpg); height:23px;\">
									<div align=\"center\" style=\"padding-top:4px; width:723px;\"><font color='#ffffff' style=\"padding-top:20px;\">Produk</font>
									</div></div>
									<td>";
								
								opendb();
								$proses=$_GET['proses'];
								$proses=filter($proses);
								
								switch($proses){
									case 'detil':
									$konten.="	<div style=\"padding: 10px 10px 10px 10px;\">
												<div style=\"background: orange; color: white; text-align: center; width: 100px;\">Detail Produk</div>
												<div style=\"border: 1px solid orange; padding: 10px 10px 10px 10px; width: 723px;\">";
										$id=(int)$_GET['id'];
										$token=$_GET['token'];
										$sqlDetil="SELECT P.idProduk, P.namaProduk, P.hargaProduk, P.idKategori, P.stockProduk,
												P.pathImage, P.idStatusProduk, P.konten, 
												S.namaStatus,S.idStatusProduk, K.idKategori, K.namaKategori, R.namaProdusen, R.idProdusen 
												FROM produk P, produsen R, kategori K, statusproduk S 
												WHERE R.idProdusen=P.idProdusen 
												AND K.idKategori=P.idKategori 
												AND P.idStatusProduk=S.idStatusProduk 
												AND P.idProduk='$id'";
										$queryDetil=mysql_query($sqlDetil);
										$jumDetil=mysql_num_rows($queryDetil);
											if($jumDetil==0){
												$konten.="<div style=\"padding-top:10px; background-color: #607c3c\">No Data
												<a href=\"index.php$token\">Halaman utama</a> 
												<a href=produk.php$token&proses=tambah>Tambah Data</a>
												</div>";
											}
											else{
												$rowDetil=mysql_fetch_array($queryDetil);
												$konten.="
												<table align=\"center\" width=\"100%\">
													<tr>
														<td style=\"color:#ffffff;\" width=\"80\">Nama Produk</td>
														<td style=\"color:#ffffff;\">:</td>
														<td style=\"color:#ffffff;\">$rowDetil[namaProduk]</td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Harga</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\">$rowDetil[hargaProduk]</td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Kategori</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\">$rowDetil[namaKategori]</td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Stock</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\">$rowDetil[stockProduk]</td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Image</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><img src=\"../imagea/product/".$rowDetil[pathImage]."\" width=\"75px\" height=\"111px\"</td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Status</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\">$rowDetil[namaStatus]</td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Konten</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\">$rowDetil[konten]</td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Produsen</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\">$rowDetil[namaProdusen]
														</td>
													</tr>
												</table>
											<div style=\"padding-left:5px;\" align=\"left\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
											</div>";
										}
									break;
									case 'tambah':
									$konten.="	<div style=\"padding: 10px 10px 10px 10px;\">
												<div style=\"background: orange; color: white; text-align: center; width: 100px;\">Input Produk</div>
												<div style=\"border: 1px solid orange; padding: 10px 10px 10px 10px; width: 723px;\">";
										$konten.="
											<form action=\"produk.php$token&proses=input\" method=\"post\" ENCTYPE=\"MULTIPART/FORM-DATA\">
												<table align=\"center\">
													<tr>
														<td style=\"color:#ffffff\">Nama Produk</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><input type=\"text\" name=\"namaProduk\" size=\"25\"></td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Harga</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><input type=\"text\" name=\"hargaProduk\" size=\"25\"></td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Kategori</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\">
														<SELECT name=\"idKategori\">
														<OPTION VALUE=\"\">Kategori</OPTION>";
														$sqlKategori="SELECT * FROM kategori";
														$queryKategori=mysql_query($sqlKategori);
														while($rowKategori=mysql_fetch_array($queryKategori)){
															$konten.="<OPTION VALUE=\"$rowKategori[idKategori]\">$rowKategori[namaKategori]</OPTION>";
														}
														$konten.="</SELECT>
														</td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Stock</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><input type=\"text\" name=\"stockProduk\" size=\"10\"></td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Image</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><input type=\"file\" name=\"pathImage\" size=\"30\"></td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Status</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\">
														<SELECT name=\"idStatusProduk\">
														<OPTION VALUE=\"\">Status</OPTION>";
														$sqlStatus="SELECT * FROM statusproduk";
														$queryStatus=mysql_query($sqlStatus);
														while($rowStatus=mysql_fetch_array($queryStatus)){
															$konten.="<OPTION VALUE=\"$rowStatus[idStatusProduk]\">$rowStatus[namaStatus]</OPTION>";
														}
														$konten.="</SELECT>
														</td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Konten</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><textarea id=\"elm1\" name=\"isi\" rows=\"20\" cols=\"50\"></textarea></td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Produsen</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\">
														<SELECT name=\"idProdusen\">
														<OPTION VALUE=\"\">Produsen</OPTION>";
														$sqlProdusen="SELECT * FROM produsen";
														$queryProdusen=mysql_query($sqlProdusen);
														while($rowProdusen=mysql_fetch_array($queryProdusen)){
															$konten.="<OPTION VALUE=\"$rowProdusen[idProdusen]\">$rowProdusen[namaProdusen]</OPTION>";
														}
														$konten.="</SELECT>
														</td>
													</tr>
													<tr>
														<td colspan=\"3\" style=\"color:#ffffff\" align=\"center\">
															<input type=\"submit\" name=\"submit\" value=\"Input\" style=\"border:1px solid grey\">
															<input type=\"reset\" name=\"reset\" value=\"Reset\" style=\"border:1px solid grey\">
															<input type=\"hidden\" name=\"maksFile\" value=\"1000000\">
														</td>
													</tr>
												</table>
											</form>
										";
									break;
									
									case 'edit':
									$konten.="	<div style=\"padding: 10px 10px 10px 10px;\">
												<div style=\"background: orange; color: white; text-align: center; width: 100px;\">Edit Produk</div>
												<div style=\"border: 1px solid orange; padding: 10px 10px 10px 10px; width: 723px;\">";										
										$id=(int)$_GET['id'];
										$sqlEdit="	SELECT P.idProduk, P.namaProduk, P.hargaProduk, P.idKategori, P.stockProduk, P.pathImage, P.idStatusProduk, P.konten, S.namaStatus, K.namaKategori, R.namaProdusen, P.idProdusen 
													FROM produk P, produsen R, kategori K, statusproduk S 
													WHERE R.idProdusen=P.idProdusen 
													AND K.idKategori=P.idKategori 
													AND P.idStatusProduk=S.idStatusProduk 
													AND P.idProduk='$id'";
										$queryEdit=mysql_query($sqlEdit);
										$jumEdit=mysql_num_rows($queryEdit);
											if($jumEdit==0){
												$konten.="<div style=\"padding-top:10px; background-color: #607c3c\">No Data
												<a href=\"index.php$token\">Halaman utama</a> 
												<a href=produk.php$token&proses=tambah>Tambah Data</a>
												</div>";
											}
											else{
												$rowEdit=mysql_fetch_array($queryEdit);
												$konten.="
											<form action=\"produk.php$token&proses=update\" method=\"post\" ENCTYPE=\"MULTIPART/FORM-DATA\">
												<table align=\"center\">
													<tr>
														<td style=\"color:#ffffff\">Nama Produk</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><input type=\"text\" name=\"namaProduk\" size=\"50\" value=\"$rowEdit[namaProduk]\"></td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Harga</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><input type=\"text\" name=\"hargaProduk\" size=\"25\" value=\"$rowEdit[hargaProduk]\"></td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Kategori</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\">
														<SELECT name=\"idKategori\">
														<OPTION VALUE=\"\">Kategori</OPTION>";
														$sqlKategori="SELECT * FROM kategori";
														$queryKategori=mysql_query($sqlKategori,opendb())or die(mysql_error());
														if($queryKategori != null) {
															if(mysql_num_rows($queryKategori)>0) {
																while($rowKategori=mysql_fetch_array($queryKategori)){
																	if($rowKategori[idKategori]==$rowEdit[idKategori]){
																		$konten.="<OPTION VALUE=\"$rowKategori[idKategori]\" SELECTED>$rowKategori[namaKategori]</OPTION>";
																	}
																	else{
																		$konten.="<OPTION VALUE=\"$rowKategori[idKategori]\">$rowKategori[namaKategori]</OPTION>";
																	}
																}
															}
														}														
														$konten.="</SELECT>
														</td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Stock</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><input type=\"text\" name=\"stockProduk\" size=\"10\" value=\"$rowEdit[stockProduk]\"></td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Image Sekarang</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><img src=\"../imagea/product/".$rowEdit[pathImage]."\" width=\"75px\" height=\"111px\"</td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Ganti Image</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><input type=\"file\" name=\"imageBaru\">
														<small>Kosongkan saja field ini jika anda tidak ingin merubah image sebelumnya</small>
														</td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Status</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\">
														<SELECT name=\"idStatus\">
														<OPTION VALUE=\"\">Status</OPTION>";
														$sqlStatus="SELECT * FROM statusproduk";
														$queryStatus=mysql_query($sqlStatus);
														while($rowStatus=mysql_fetch_array($queryStatus)){
															if($rowStatus[idStatusProduk]==$rowEdit[idStatusProduk]){
																$konten.="<OPTION VALUE=\"$rowStatus[idStatusProduk]\" SELECTED>$rowStatus[namaStatus]</OPTION>";
															}
															else{
																$konten.="<OPTION VALUE=\"$rowStatus[idStatusProduk]\">$rowStatus[namaStatus]</OPTION>";
															}
														}
														$konten.="</SELECT>
														</td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Konten</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\"><textarea id=\"elm1\" name=\"isi\" rows=\"20\" cols=\"50\">$rowEdit[konten]</textarea></td>
													</tr>
													<tr>
														<td style=\"color:#ffffff\">Produsen</td>
														<td style=\"color:#ffffff\">:</td>
														<td style=\"color:#ffffff\">
														<SELECT name=\"idPro\">
														<OPTION VALUE=\"\">Produsen</OPTION>";
														$sqlProdusen="SELECT * FROM produsen";
														$queryProdusen=mysql_query($sqlProdusen);
														while($rowProdusen=mysql_fetch_array($queryProdusen)){
															if($rowProdusen[idProdusen]==$rowEdit[idProdusen]){
																$konten.="<OPTION VALUE=\"$rowProdusen[idProdusen]\" SELECTED>$rowProdusen[namaProdusen]</OPTION>";
															}
															else{
																$konten.="<OPTION VALUE=\"$rowProdusen[idProdusen]\">$rowProdusen[namaProdusen]</OPTION>";
															}
														}
														$konten.="</SELECT>
														</td>
													</tr>
													<tr>
														<td colspan=\"3\" style=\"color:#ffffff\" align=\"center\">
															<input type=\"submit\" name=\"submit\" value=\"Update\" style=\"border:1px solid grey\">
															<input type=\"reset\" name=\"reset\" value=\"Reset\" style=\"border:1px solid grey\">
															<input type=\"hidden\" name=\"id\" value=\"$rowEdit[idProduk]\">
															<input type=\"hidden\" name=\"maksFile\" value=\"1000000\">
															<input type=\"hidden\" name=\"pathImage\" value=\"$rowEdit[pathImage]\">
														</td>
													</tr>
												</table>
											</form>
											<div style=\"padding-left:5px;\" align=\"left\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
											</div>";
												}
										break;
									
									case 'update':
									$id=(int)$_POST['id'];
									$namaProduk=$_POST['namaProduk'];
									$hargaProduk=$_POST['hargaProduk'];
									$idKategori=(int)$_POST['idKategori'];
									$stockProduk=$_POST['stockProduk'];
									$idStatusProduk=(int)$_POST['idStatus'];
									$isi=filter($_POST['isi']);
									$idProdusen=(int)$_POST['idPro'];
									$imageBaruName=$_FILES['imageBaru']['name'];
									$imageBaruType=$_FILES['imageBaru']['type'];
									$imageBaruSize=$_FILES['imageBaru']['size'];
									$maksFile=(int)$_POST['maksFile'];
									$noImage="noImage.gif";
									$token=$_GET['token'];
										if($namaProduk !="" && $hargaProduk !="" && $idKategori !="" && $stockProduk !="" && $idStatusProduk !="" && $isi !="" && $idProdusen !=""){
											if($_FILES['imageBaru']['error']=='0'){
												if($imageBaruSize <= $maksFile){
													if($imageBaruType == "image/jpg" || $imageBaruType == "image/jpeg" || $imageBaruType == "image/bmp" || $imageBaruType == "image/gif" || $imageBaruType == "image/png"){
														$sqlUpdate="UPDATE produk 
																	SET namaProduk = '$namaProduk', 
																		hargaProduk = '$hargaProduk', 
																		idKategori = '$idKategori', 
																		stockProduk = '$stockProduk', 
																		pathImage = '$imageBaruName', 
																		idStatusProduk = '$idStatusProduk', 
																		konten = '$isi', 
																		idProdusen = '$idProdusen'  
																		WHERE idProduk='$id'";
														$queryUpdate=mysql_query($sqlUpdate,opendb())or die(mysql_error());
														copy($HTTP_POST_FILES['imageBaru']['tmp_name'],"../imagea/product/".$_FILES['imageBaru']['name']);
														
														if($_POST['pathImage']==$noImage){
															//nothing
														}
														else{
															unlink("../imagea/product/".$_POST['pathImage']);
														}
														if($queryUpdate){
																header("Location: produk.php?token=$token");
															}
														else{
															$konten.="<div style=\"padding-top:10px; padding-left:5px; background-color: #607c3c; padding-bottom:10px;\"><font color=#ffffff>Failed to Update. </font>
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
												$sqlUpdate2="UPDATE produk SET namaProduk='$namaProduk', hargaProduk='$hargaProduk', idKategori='$idKategori', stockProduk='$stockProduk', idProdusen='$idProdusen', idStatusProduk='$idStatusProduk', konten='$isi' WHERE idProduk='$id'";
												$queryUpdate2=mysql_query($sqlUpdate2,opendb())or die(mysql_error());
												if($queryUpdate2 != null){
													header("Location: produk.php?token=$token");
												}
												else{
													$konten.="<div style=\"padding-top:10px; padding-left:5px; background-color: #607c3c; padding-bottom:10px;\"><font color=#ffffff>Failed to Update.</font>
													<div style=\"padding-top:10px; padding-left:5px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
													</div></div>";
												}
											}
											else{
												
											}
										}
										else{
											$konten.="<div style=\"padding-top:10px; padding-left:5px; background-color: #607c3c; padding-bottom:10px;\"><font color=#ffffff>Failed to Update some empty fields found. sama sekali</font>
													<div style=\"padding-top:10px; padding-left:5px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
													</div></div>";
										}
									break;
									
									case 'hapus':
										$id=(int)$_GET['id'];
										$token=$_GET['token'];
										$sqlGambar="SELECT pathImage FROM produk WHERE idProduk='$id'";
										$queryGambar=mysql_query($sqlGambar);
										$rowGambar=mysql_fetch_array($queryGambar);
										$noImage="noImage.gif";
										$queryHapus=mysql_query("DELETE FROM produk WHERE idProduk='$id'");
											if(!$queryHapus){
												$konten.="<div style=\"padding-top:10px; padding-left:5px; background-color: #607c3c; padding-bottom:10px;\"><font color=#ffffff>Failed to delete</font>
												<div style=\"padding-top:10px; padding-left:5px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
												</div></div>";
											}
											else{
												if($rowGambar[pathImage]==$noImage){
													//NOTHING
												}
												else{
													unlink("../imagea/product/".$rowGambar[pathImage]);
												}
												header("Location: produk.php?token=$token");
											}
									break;
									
									case 'input':
										$namaProduk=$_POST['namaProduk'];
										$hargaProduk=$_POST['hargaProduk'];
										$idKategori=$_POST['idKategori'];
										$stockProduk=$_POST['stockProduk'];
										$idStatusProduk=$_POST['idStatusProduk'];
										$isi=filter($_POST['isi']);
										$idProdusen=$_POST['idProdusen'];
										$pathImageName=$_FILES['pathImage']['name'];
										$pathImageType=$_FILES['pathImage']['type'];
										$pathImageSize=$_FILES['pathImage']['size'];
										$maksFile=(int)$_POST['maksFile'];
											if($namaProduk !="" && $hargaProduk !="" && $idKategori !="" && $stockProduk !="" && $idStatusProduk !="" && $isi !="" && $idProdusen !=""){
													if($_FILES['pathImage']['error']=='0'){
														if($pathImageType == "image/jpg" || $pathImageType == "image/jpeg" || $pathImageType == "image/png" || $pathImageType == "image/gif" || $pathImageType =="image/bmp"){
															if($pathImageSize <= $maksFile){
																$sqlInput="INSERT INTO produk 
																VALUES
																('','$namaProduk','$hargaProduk','$idKategori','$stockProduk','$pathImageName','$idStatusProduk','$isi','$idProdusen')";
																$queryInput=mysql_query($sqlInput)or die(mysql_error());
																$noImage="noImage.gif";
																if($pathImageName==$noImage) {
																	//not copy
																}
																else {
																	copy($HTTP_POST_FILES['pathImage']['tmp_name'],"../imagea/product/".$_FILES['pathImage']['name']);
																}
																	if($queryInput){
																		header("Location: produk.php$token");
																	}
																	else{
																		$konten.="<div style=\"padding-top:10px; padding-left:5px; background-color: #607c3c; padding-bottom:10px;\"><font color=#ffffff>Failed to Input.Query</font>
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
															$konten.="<div style=\"padding-top:10px; padding-left:5px; background-color: #ffffff; padding-bottom:10px;\"><font color=#ffffff>Failed to Input. Image must be JPEG, JPG, BMP, GIF or PNG format</font>
																<div style=\"padding-top:10px; padding-left:5px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
																</div></div>";
														}
													}
													elseif($_FILES['pathImage']['error']=='4'){
														$noImage="noImage.gif";
															$sqlInput="INSERT INTO produk 
																		VALUES
																		('','$namaProduk','$hargaProduk','$idKategori','$stockProduk','$noImage','$idStatusProduk','$isi','$idProdusen')";
															$queryInput=mysql_query($sqlInput,opendb())or die(mysql_error());
																if($queryInput){
																	header("Location: produk.php$token");
																}
																else{
																	$konten.="<div style=\"padding-top:10px; padding-left:5px; background-color: #607c3c; padding-bottom:10px;\"><font color=#ffffff>Failed to Input.Query NoImage</font>
																			<div style=\"padding-top:10px; padding-left:5px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
																			</div></div>";
																}
													}
													else{
														$konten.="<div style=\"padding-top:10px; padding-left:5px; background-color: #607c3c; padding-bottom:10px;\"><font color=#ffffff>Failed to Input.Sama Sekali</font>
																<div style=\"padding-top:10px; padding-left:5px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
																</div></div>";
													}
												}
												else{
													$konten.="<div style=\"padding-top:10px; padding-left:5px; background-color: #607c3c; padding-bottom:10px;\"><font color=#ffffff>Failed to Input some empty fields found Syarat</font>
															<div style=\"padding-top:10px; padding-left:5px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
															</div></div>";
												}		
									break;
									
									default:									
									$sqlView="	SELECT P.idProduk, P.namaProduk, P.hargaProduk, P.stockProduk,
												P.pathImage, P.konten, 
												S.namaStatus, K.namaKategori, R.namaProdusen 
												FROM produk P, produsen R, kategori K, statusproduk S 
												WHERE R.idProdusen=P.idProdusen 
												AND K.idKategori=P.idKategori 
												AND P.idStatusProduk=S.idStatusProduk ";
									if(isset($_GET['kat']) && $_GET['kat']!="") {
										$sqlView.="AND K.idKategori='$_GET[kat]' ";
									}
									$sqlView.="ORDER BY namaKategori ASC";
									$queryView=mysql_query($sqlView);
									$jumView=mysql_num_rows($queryView);
									if($jumView==0){
										$konten.="<div style=\"padding-top:10px; background-color: #607c3c\">
													<a href=produk.php$token&proses=tambah>Tambah Data</a>
													</div>";
									}
									else{										
										$konten.="
										<form action=\"produk.php$token\" method=\"GET\">
											<table align=\"center\" cellpadding=\"3\" cellspacing=\"0\" width=\"100%\" bgcolor=\"#364b1a\" border=\"0\">
												<tr>
													<td colspan=\"8\">
														<div>
															<input type=\"hidden\" name=\"token\" value=\"$_GET[token]\">
															<select name=\"kat\" onChange=\"this.form.submit()\">
															<option value=\"\">All Category</option>";	
															$sqlList="SELECT * FROM kategori ORDER BY namaKategori";
															$queryList=mysql_query($sqlList,opendb())or die(mysql_error());
															if($queryList != null) {
																if(mysql_num_rows($queryList)>0) {
																	while($rowList=mysql_fetch_array($queryList)) {
																		if($_GET['kat']==$rowList['idKategori']) {
																			$konten.="<option value=\"$rowList[idKategori]\" SELECTED>$rowList[namaKategori]</option>";
																		}
																		else {
																			$konten.="<option value=\"$rowList[idKategori]\">$rowList[namaKategori]</option>";
																		}
																	}
																}
															}
												$konten.="	</div>
														</td>
													</tr>
												<tr>
													<td class=\"cart\" style=\"color:#ffffff;\" >No</td>
													<td class=\"cart\" style=\"color:#ffffff;\" >Nama Produk</td>
													<td class=\"cart\" style=\"color:#ffffff;\" >Kode</td>
													<td class=\"cart\" style=\"color:#ffffff;\" >Harga</td>
													<td class=\"cart\" style=\"color:#ffffff;\" >Stock</td>
													<td class=\"cart\" style=\"color:#ffffff;\" >Produsen</td>
													<td class=\"cart\" style=\"color:#ffffff;\" >Detil</td>
													<td class=\"cart\" style=\"color:#ffffff;\" >Aksi</td>
												</tr>";
											//Paging
											$batas=20;
											if(($jumView%$batas)==0) {
												$jmlHal=(int)($jumView/$batas);
											}
											else {
												$jmlHal=((int)$jumView/$batas)+1;
											}								
											//inisialisasi variabel page
											if(isset($_GET[hal])) {
												$hal=(int)$_GET[hal];
											}
											else {
												$hal=1;									
											}
											if($hal>$jmlHal) {
												$hal=$jmlHal;
											}
											while($rowView=mysql_fetch_array($queryView)){
												$arrdata[]=$rowView;
											}
											mysql_free_result($queryView);
											//set end dan start page
											$end=(int)($hal*$batas)-1;
											$start=(int)$end-($batas-1);
											if($end>$jumView) {
												$end=$jumView-1;
											}
											for($ix=$start; $ix<=$end; $ix++) {
												$arr[]=$arrdata[$ix];
											}
											//end Batas baris per halaman																	
											$patokan=$_GET['hal'];
											if($patokan =="1" || $patokan=="") {
												$no=1;
											}
											else {
												$no=($patokan+($patokan-2))*10+1;
											}
											//Menampilkan Record Looping	
											$j=0;
											foreach ($arr as $rowView) {
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
														<td class=\"cart\">$no</td>
														<td class=\"cart\">$rowView[namaProduk]</td>
														<td class=\"cart\">$rowView[idProduk]</td>
														<td class=\"cart\">$rowView[hargaProduk]</td>
														<td class=\"cart\">$rowView[stockProduk]</td>
														<td class=\"cart\">$rowView[namaProdusen]</td>
														<td class=\"cart\">[<a href=\"produk.php$token&proses=detil&id=$rowView[idProduk]\">Detil</a>]</td>
														<td class=\"cart\">[<a href=\"produk.php$token&proses=edit&id=$rowView[idProduk]\">Edit</a> | <a href=\"produk.php$token&proses=hapus&id=$rowView[idProduk]\" onClick=\"return confirm('Anda Yakin Akan Menghapus?');\">Hapus</a>]</td>
													</tr>";
												$no++;
											}
											$konten.="
												</table>
											</form>
											<div style=\"padding-top:10px; background-color: #607c3c; text-align: center;\">
												<a href=produk.php$token&proses=tambah>Tambah Data</a>
												</div>
											<div style=\"text-align: center;\">";
												for($n=1; $n<=$jmlHal; $n++) {
													if($n != $hal) {
														$konten.="<a href='produk.php$token&hal=$n'>$n</a> ";
													}
													else {
														$konten.="<b> <font style=\"font-size: 13px;\">$n</font> </b>";
													}
												}												
											$konten.="</div>
											<div style=\"text-align: center;\">";
												for($i=$start; $i<=$end; $i++) {
													$arr1[]=$arrdata[$i];
												}
												foreach($arr1 as $no2) {
													$nn++;
												}
												if($_GET[hal]==1||$_GET[hal]=""||!isset($_GET[hal])) {
													$no1=1;															
												}
												else {
													$no1=($patokan+($patokan-2))*10+1;																
												}
												$no2=$no1-1;
												for($idx=1; $idx<=$nn; $idx++) {
													$no2++;
												}
												$konten.="<div>Record $no1 - $no2 From $jumView</div>
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
