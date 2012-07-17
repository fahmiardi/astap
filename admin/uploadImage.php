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
			$title=":: $JUDUL | Halaman Upload Image ::";
			$isiLink="<tr><td><a href=\"index2.php?act=logout&token=$_SESSION[ASTA_ADM_HASH]\" class=\"menuItem\" alt=\"Logout\" title=\"Logout\"><div class=\"break\">Logout</div></a></td></tr>";
			$token="?token=".$_SESSION['ASTA_ADM_HASH'];
			$arrayMenu=array("index.php$token"=>'Home',"produk.php$token"=>'Produk',"pemesanan.php$token"=>'Pemesanan',"konfirmasi.php$token"=>'Konfirmasi',"Pelanggan.php$token"=>'Pelanggan',"kategori.php$token"=>'Kategori');
				
			$konten="<tr><td colspan=\"2\" style=\"padding: 10px 10px 10px 10px;\">
							<table cellpadding=\"1\" cellspacing=\"1\" align=\"center\" bgcolor=\"orange\" width=\"100%\">
								<tr bgcolor=\"#607c3c\">
									<div style=\"background: url(./imagea/tab2.jpg); height:23px;\">
									<div style=\"padding-top:4px; text-align:center; width:723px;\" ><font color='#ffffff' style=\"padding-top:20px; font-size:14px\">Upload Image</font>
									</div></div>
									<td>";
							opendb();
								$proses=$_GET['proses'];
								$proses=filter($proses);
								
								switch($proses){
									default:
										$konten.="
											<form action=\"uploadImage.php$token&proses=input\" method=\"post\" ENCTYPE=\"MULTIPART/FORM-DATA\">
												<table align=\"center\" style=\"padding-top: 10px;\">
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
									
									case 'input':
										$imageName=$_FILES['image']['name'];
										$imageType=$_FILES['image']['type'];
										$imageSize=$_FILES['image']['size'];
										$maksFile=$_POST['maksFile'];
										if($_FILES['image']['error']=='0'){
											if($imageType == "image/jpg" || $imageType == "image/jpeg" || $imageType == "image/png" || $imageType == "image/gif" || $imageType=="image/bmp"){
												if($imageSize <= $maksFile){
													$upload=copy($HTTP_POST_FILES['image']['tmp_name'],"../imagea/imageUpload/".$_FILES['image']['name']);
													if($upload){
														$konten.="<div style=\"padding-top:10px; padding-left:5px; background-color: #607c3c; padding-bottom:10px;\">
														<font color=#ffffff>
															Path : ./imagea/imageUpload/$imageName
														</font>
														<div style=\"padding-top:10px; padding-left:5px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
														</div></div>";											
													}else{
														$konten.="<div style=\"padding-top:10px; padding-left:5px; background-color: #607c3c; padding-bottom:10px;\"><font color=#ffffff>Failed to Upload.</font>
														<div style=\"padding-top:10px; padding-left:5px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
														</div></div>";
													}
												}else{
													$konten.="<div style=\"padding-top:10px; padding-left:5px; background-color: #607c3c; padding-bottom:10px;\"><font color=#ffffff>File lebih dari 1 mb</font>
														<div style=\"padding-top:10px; padding-left:5px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
														</div></div>";
												}
											}else{
												$konten.="<div style=\"padding-top:10px; padding-left:5px; background-color: #607c3c; padding-bottom:10px;\"><font color=#ffffff>Failed to Upload. File format must be JPEG, JPG, BMP, PNG, GIF</font>
														<div style=\"padding-top:10px; padding-left:5px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
														</div></div>";
											}
											
										}else{
											$konten.="<div style=\"padding-top:10px; padding-left:5px; background-color: #607c3c; padding-bottom:10px;\"><font color=#ffffff>Failed to Upload. Field is still empty</font>
														<div style=\"padding-top:10px; padding-left:5px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
														</div></div>";
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
