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
			$title=":: $JUDUL | Halaman Pelanggan ::";
			$isiLink="<tr><td><a href=\"index2.php?act=logout&token=$_SESSION[ASTA_ADM_HASH]\" class=\"menuItem\" alt=\"Logout\" title=\"Logout\"><div class=\"break\">Logout</div></a></td></tr>";
			$token="?token=".$_SESSION['ASTA_ADM_HASH'];
			$arrayMenu=array("index.php$token"=>'Home',"produk.php$token"=>'Produk',"pemesanan.php$token"=>'Pemesanan',"konfirmasi.php$token"=>'Konfirmasi',"Pelanggan.php$token"=>'Pelanggan',"kategori.php$token"=>'Kategori');
			$konten="<tr>
						<td colspan=\"2\" style=\"padding: 10px 10px 10px 10px;\">
							<div style=\"background: url(./imagea/tab2.jpg); height:23px;\">
								<div style=\"padding-top:4px; text-align: center; width:723px\">
									<font color='#ffffff' style=\"padding-top:20px; font-size:14px;\">My Account</font>
								</div>
								</div>
							<table cellpadding=\"1\" cellspacing=\"1\" align=\"center\" bgcolor=\"orange\" width=\"100%\">
								<tr bgcolor=\"#607c3c\">									
									<td>";
									opendb();
									$proses=$_GET['proses'];
									$proses=filter($proses);
									switch($proses){
									case "update":
										if(isset($_POST[update])){
											if($_POST[usernameAsal] !="" && $_POST[passwordAsal] !=""){
												$username=Encrypt($_POST['usernameAsal']);
												$password=Encrypt($_POST['passwordAsal']);
												$usernameAsal=$_POST['usernameAsal'];
												$passwordAsal=$_POST['passwordAsal'];
													$sqlUpdate="UPDATE username SET 
																username='$username', 
																password='$password', 
																usernameAsal='$usernameAsal', 
																passwordAsal='$passwordAsal' 
																WHERE 
																idUser='1'";
													$queryUpdate=mysql_query($sqlUpdate);
													if($queryUpdate){
														$konten.="<div style=\"padding-top:10px; padding-left:5px; background-color: #607c3c; padding-bottom:10px;\"><font color=\"#ffffff\">Username dan Password telah berhasil diganti</font>";
													}
													else{
														$konten.="<div style=\"padding-top:10px; pading-left:5px; background-color: #607c3c; padding-bottom:10px;\"><font color=\"#ffffff\">Failed to update data.</font>
														<div style=\"padding-top:10px; padding-left:5px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
														</div></div>";
													}
											}
											else{
												$konten.="<div style=\"padding-top:10px; padding-left:5px; background-color: #607c3c; padding-bottom:10px;\"><font color=\"#ffffff\">Failed to update data. Some empty fields found</font>
														<div style=\"padding-top:10px; padding-left:5px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
														</div></div>";
											}
										}
										else{
											$konten.="<div style=\"padding-top:10px; pading-left:5px; background-color: #607c3c; padding-bottom:10px;\"><font color=\"#ffffff\">Failed to update data.No data submitted</font>
													<div style=\"padding-top:10px; padding-left:5px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
													</div></div>";
										}
									break;
									default:
										$konten.="<div style=\"padding: 10px 10px 10px 10px;\">
											<div style=\"background: orange; color: white; text-align: center; width: 100px;\">Edit Password</div>
											<div style=\"border: 1px solid orange; padding: 10px 10px 10px 10px; width: width:723px;\">";
											$token=$_GET['token'];
											$sql_edit="SELECT username, password, usernameAsal, passwordAsal, idUser 
														FROM username 
														WHERE idUser='1'";
											$query_edit=mysql_query($sql_edit); 
											$jum=mysql_num_rows($query_edit);
											if($jum==0){
												$konten.="<div style=\"padding-top:10px; background-color: #ffffff; padding-bottom:10px;\"><font color=#ffffff>Tidak ada data yang dapat diedit</font>
														<div style=\"padding-top:10px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
														</div></div>";	
											}
											else
											{
												$row = mysql_fetch_array($query_edit);
													$konten.="<form action=myAccount.php?token=$token&proses=update method=\"post\">
														<table align=\"center\">
														  <tr>
														    <td style=\"color:#ffffff\">Username</td>
														    <td style=\"color:#ffffff\">:</td>
														    <td style=\"color:#ffffff\"><input type=\"text\" name=\"usernameAsal\" value=\"$row[usernameAsal]\"></td>
														  </tr>
														  <tr>
														    <td style=\"color:#ffffff\">Password</td>
														    <td style=\"color:#ffffff\">:</td>
														    <td style=\"color:#ffffff\"><input type=\"password\" name=\"passwordAsal\" value=\"$row[passwordAsal]\"></td>
														  </tr>
										
														<tr>
														    <td colspan=\"3\" style=\"color:#ffffff\" align=\"center\">
																<input type=\"submit\" name=\"update\" value=\"update\" style=\"border:1px solid grey\">
																<input type=\"hidden\" name=\"id\" value='".$row[idUser]."'>
															</td>
														  </tr>
													</table>
												</form>";
											$konten.="<div align=\"left\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\"></div>";
											break;
											}
									}
									closedb();
								$konten.="
								</td>
							</tr>
						</table>
					</td>
				</tr>";
			$myAccount=new Admin();
			$myAccount->setTitle($title);
			$myAccount->setIsi($konten);
			$myAccount->setArrayMenu($arrayMenu);
			$myAccount->setLinkLogout($isiLink);
			$myAccount->getTampilkan();	
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
	}
}
else{
	header("Location: index.php");
}