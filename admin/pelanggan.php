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
								<div style=\"padding-top:4px; text-align: center; width:723px;\">
									<font color='#ffffff' style=\"padding-top:20px; font-size:14px;\">Pelanggan</font>
								</div>
								</div>
							<table cellpadding=\"1\" cellspacing=\"1\" align=\"center\" bgcolor=\"orange\" width=\"100%\">
								<tr bgcolor=\"#607c3c\">									
									<td>";
									opendb();
									$proses=$_GET['proses'];
									switch($proses){
										case "detil":
										$konten.="<div style=\"padding: 10px 10px 10px 10px;\">
											<div style=\"background: orange; color: white; text-align: center; width: 100px;\">Detil Pelanggan</div>
											<div style=\"border: 1px solid orange; padding: 10px 10px 10px 10px; width: 723px;\">";
											$id = $_GET['id'];
											$token=$_GET['token'];
											$sql_detPelanggan="SELECT P.namaPelanggan, P.alamatPelanggan, P.kota, P.propinsi, P.kodepos, P.email, P.phone, U.lastLogin, U.regDate, Q.namaPertanyaan, U.jawaban
														FROM 
														pelanggan P, username U, pertanyaan Q 
														WHERE
														P.idUser=U.idUser 
														AND 
														Q.idPertanyaan=U.idPertanyaan 
														AND
														P.idUser='$id'";
											$query_detPelanggan=mysql_query($sql_detPelanggan); 
											$jum=mysql_num_rows($query_detPelanggan);
											if($jum==0){
												$konten.="<div style=\"padding-top:10px; background-color: #607c3c; padding-bottom:10px;\"><font color=#ffffff>Tidak ada detil yang dapat dilihat</font>
														<div style=\"padding-top:10px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
														</div></div>";
	
											}
											else
											{
												while($row = mysql_fetch_array($query_detPelanggan)){ 
												$konten.="<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" align=\"center\">
												  <tr>
												    <td class=\"cart\" width=\"10%\">Pelanggan</td>
												    <td style=\"color:#ffffff\">:</td>
												    <td style=\"color:#ffffff\">".$row[namaPelanggan]."</td>
												  </tr>
												  <tr>
												    <td style=\"color:#ffffff\">Alamat</td>
												    <td style=\"color:#ffffff\">:</td>
												    <td style=\"color:#ffffff\">".$row[alamatPelanggan]."</td>
												  </tr>
												  <tr>
												    <td style=\"color:#ffffff\">Kota</td>
												    <td style=\"color:#ffffff\">:</td>
												    <td style=\"color:#ffffff\">".$row[kota]."</td>
												  </tr>
												  <tr>
												    <td style=\"color:#ffffff\">Propinsi</td>
												    <td style=\"color:#ffffff\">:</td>
												    <td style=\"color:#ffffff\">".$row[propinsi]."</td>
												  </tr>
												  <tr>
												    <td style=\"color:#ffffff\">Kode Pos</td>
												    <td style=\"color:#ffffff\">:</td>
												    <td style=\"color:#ffffff\">".$row[kodepos]."</td>
												  </tr>
												  <tr>
												    <td style=\"color:#ffffff\">Email</td>
												    <td style=\"color:#ffffff\">:</td>
												    <td style=\"color:#ffffff\">".$row[email]."</td>
												  </tr>
												  <tr>
												    <td style=\"color:#ffffff\">Telepon</td>
												    <td style=\"color:#ffffff\">:</td>
												    <td style=\"color:#ffffff\">".$row[phone]."</td>
												  </tr>
												    <td style=\"color:#ffffff\">Last Login</td>
												    <td style=\"color:#ffffff\">:</td>
												    <td style=\"color:#ffffff\">".$row[lastLogin]."</td>
												  </tr>
												  <tr>
												    <td style=\"color:#ffffff\">Register</td>
												    <td style=\"color:#ffffff\">:</td>
												    <td style=\"color:#ffffff\">".$row[regDate]."</td>
												  </tr>
												  <tr>
												    <td style=\"color:#ffffff\">Pertanyaan</td>
												    <td style=\"color:#ffffff\">:</td>
												    <td style=\"color:#ffffff\">".$row[namaPertanyaan]."</td>
												  </tr>
												  <tr>
												    <td style=\"color:#ffffff\">Jawaban</td>
												    <td style=\"color:#ffffff\">:</td>
												    <td style=\"color:#ffffff\">".$row[jawaban]."</td>
												  </tr>
												</table>";
												}
										$konten.="<div align=\"left\" style=\"padding-top:10px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\"></div>";
											}
										break;
										
										case "edit":
										$konten.="<div style=\"padding: 10px 10px 10px 10px;\">
											<div style=\"background: orange; color: white; text-align: center; width: 100px;\">Edit Pelanggan</div>
											<div style=\"border: 1px solid orange; padding: 10px 10px 10px 10px; width: 723px;\">";
											$id = (int)$_GET['id'];
											$token=$_GET['token'];
											$sql_edit="SELECT P.idPelanggan, P.namaPelanggan, U.usernameAsal, U.passwordAsal, U.idUser 
														FROM 
														pelanggan P, username U
														WHERE
														P.idUser=U.idUser 
														AND
														P.idUser='$id'";
											$query_edit=mysql_query($sql_edit); 
											$jum=mysql_num_rows($query_edit);
											if($jum==0){
												$konten.="<div style=\"padding-top:10px; background-color: #607c3c; padding-bottom:10px;\"><font color=#ffffff>Tidak ada data yang dapat diedit</font>
														<div style=\"padding-top:10px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
														</div></div>";	
											}
											else
											{
												$row = mysql_fetch_array($query_edit);
													$konten.="<form action=\"pelanggan.php?token=$token&proses=update\" method=\"post\">
														<table align=\"center\">
														  <tr>
														    <td style=\"color:#ffffff\">Username</td>
														    <td style=\"color:#ffffff\">:</td>
														    <td style=\"color:#ffffff\"><input type=\"text\" name=\"usernameAsal\" value='".$row[usernameAsal]."'></td>
														  </tr>
														  <tr>
														    <td style=\"color:#ffffff\">Password</td>
														    <td style=\"color:#ffffff\">:</td>
														    <td style=\"color:#ffffff\"><input type=\"password\" name=\"passwordAsal\" value='".$row[passwordAsal]."'></td>
														  </tr>
										
														<tr>
														    <td colspan=\"3\" style=\"color:#ffffff\" align=\"center\">
																<input type=\"submit\" name=\"update\" value=\"update\" style=\"border:1px solid grey\">
																<input type=\"hidden\" name=\"id\" value='".$row[idUser]."'>
															</td>
														  </tr>
													</table>
												</form>";
												
											$konten.="<div align=\"left\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\"></div";
											}
										break;
										
										case "update":
											$token=$_GET['token'];
											$usernameAsal=$_POST['usernameAsal'];
											$passwordAsal=$_POST['passwordAsal'];
											$userBaru=Encrypt($usernameAsal);
											$passBaru=Encrypt($passwordAsal);
											$id=(int)$_POST['id'];
											// lakukan update
											if($usernameAsal !="" && $passwordAsal !=""){
												$sqlEdit="UPDATE username SET username='$userBaru', password='$passBaru', usernameAsal='$usernameAsal', passwordAsal='$passwordAsal'   
												WHERE idUser='$id'";
												$queryEdit=mysql_query($sqlEdit);
													if (!$queryEdit){
														$konten.="<div style=\"padding-top:10px; background-color: #607c3c; padding-left:5px; padding-bottom:10px;\"><font color=#ffffff>Failed to Update.</font>
															<div style=\"padding-top:10px; padding-left:5px; \"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
															</div></div>";
													}
													else {
														header("Location: pelanggan.php?token=$token");
													}
											}
											else{
												$konten.="<div style=\"padding-top:10px; background-color: #607c3c; padding-bottom:10px;\"><font color=#ffffff>Failed to Update some empty fields found</font>
															<div style=\"padding-top:10px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
															</div></div>";
											}
										break;
										
										case "hapus":
										$id=(int)$_GET['id'];
										$token=$_GET['token'];
										$queryHapusPlgn=mysql_query("DELETE FROM pelanggan WHERE idUser='$id'");
										$queryHapusUser=mysql_query("DELETE FROM username WHERE idUser='$id'");										
										if(!$queryHapusPlgn && !$queryHapusUser){
											$konten.="<div style=\"padding-top:10px; background-color: #607c3c; padding-bottom:10px;\"><font color=#ffffff>Failed to delete data</font>
														<div style=\"padding-top:10px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
														</div></div>";
										}else{
											header("Location: pelanggan.php?token=$token");								
										}
										break;
										
										default:
										$batas=100;
										$halaman=$_GET['halaman'];
										if(empty($halaman)){
											$posisi=0;
											$halaman=1;
										}
										else{
											$posisi=($halaman-1)*batas;
										}
										$sql_pelanggan="SELECT P.idPelanggan, P.namaPelanggan, U.usernameAsal, U.passwordAsal, U.idUser 
													FROM 
													pelanggan P, username U
													WHERE
													P.idUser=U.idUser LIMIT $posisi,$batas";
											$query_pelanggan=mysql_query($sql_pelanggan); 
											$jum=mysql_num_rows($query_pelanggan);
											$no=1;
											if($jum==0){
												$konten.="<div style=\"padding-top:10px; background-color: #607c3c\">No Data</div><div style=\"padding-top:10px; background-color: #607c3c\">
												<a href=\"index.php$token\">Halaman utama</a> 
												</div>";
											}
											else
											{
												$konten.="<table align=\"center\" cellpadding=\"3\" cellspacing=\"0\" width=\"100%\" bgcolor=\"#364b1a\" border=\"0\">
													  <tr>
														<td width=\"8%\" class=\"cart\" style=\"color:#ffffff;\" align=\"center\">No</td>
													    <td width=\"20%\" class=\"cart\" style=\"color:#ffffff;\" align=\"center\">Pelanggan</td>
													    <td width=\"20%\" class=\"cart\" style=\"color:#ffffff;\" align=\"center\">Username</td>
														<td class=\"cart\" style=\"color:#ffffff;\" align=\"center\">Password</td>
														<td class=\"cart\" style=\"color:#ffffff;\" align=\"center\">Aksi</td>
													  </tr>";
													  $j=0;
												while ($row = mysql_fetch_array($query_pelanggan)){
													if($j==0){
														$bg="#607c3c";
														$j++;
													}
													else{
														$bg="#9db085";
														$j--;
													}
												$konten.="<tr bgcolor=\"$bg\">
														<td class=\"cart\" align=\"center\" width=\"8%\">".$no."</td>
													    <td class=\"cart\" align=\"left\" width=\"30%\">".$row[namaPelanggan]."</td>
													    <td class=\"cart\" align=\"center\" width=\"20%\">".$row[usernameAsal]."</td>
														<td class=\"cart\" align=\"center\" width=\"20%\">".$row[passwordAsal]."</td>
														<td class=\"cart\" align=\"center\">
															<a href=pelanggan.php$token&proses=detil&id=".$row[idUser]."><img src=\"./imagea/right.ico\" width=\"16\" height=\"16\"></a> | 
															<a href=pelanggan.php$token&proses=edit&id=".$row[idUser]."><img src=\"./imagea/edit.ico\" width=\"16\" height=\"16\"></a> | 
															<a href=pelanggan.php$token&proses=hapus&id=".$row[idUser]." onClick=\"return confirm('Anda yakin akan menghapus?');\"><img src=\"./imagea/del.ico\" width=\"16\" height=\"16\"></a>
															</td>														
													</tr>";
												$no++;
												}
												$konten.="</table>";
												$sql_pelanggan2="SELECT P.idPelanggan, P.namaPelanggan, U.usernameAsal, U.passwordAsal, U.idUser 
													FROM 
													pelanggan P, username U
													WHERE
													P.idUser=U.idUser";
												$query_pelanggan2=mysql_query($sql_pelanggan2); 
												$jum2=mysql_num_rows($query_pelanggan2);
												$jmlHal=ceil($jum2/$batas);
												//$konten.="<div style=\"background-color:#607c3c\"><font color=#ffffff>Halaman	:</font></div>";
												for($n=1;$n<=$jmlHal;$n++){
													if($n != $halaman){
														//$konten.="<div style=\"background-color:#607c3c\"> | <a href=$_SERVER[PHP_SELF]$token&halaman=$n>$n</a> | </div>";
													}
													else{
														//$konten.="<div style=\"background-color:#607c3c\"><font color=#ffffff><b>$n</b></font></div>";
													}
												}
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
				
			$pelanggan=new Admin();
			$pelanggan->setTitle($title);
			$pelanggan->setIsi($konten);
			$pelanggan->setArrayMenu($arrayMenu);
			$pelanggan->setLinkLogout($isiLink);
			$pelanggan->getTampilkan();	
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