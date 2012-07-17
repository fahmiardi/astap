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
			$title=":: $JUDUL | Halaman Produsen ::";
			$isiLink="<tr><td><a href=\"index2.php?act=logout&token=$_SESSION[ASTA_ADM_HASH]\" class=\"menuItem\" alt=\"Logout\" title=\"Logout\"><div class=\"break\">Logout</div></a></td></tr>";
			$token="?token=".$_SESSION['ASTA_ADM_HASH'];
			$arrayMenu=array("index.php$token"=>'Home',"produk.php$token"=>'Produk',"pemesanan.php$token"=>'Pemesanan',"konfirmasi.php$token"=>'Konfirmasi',"Pelanggan.php$token"=>'Pelanggan',"kategori.php$token"=>'Kategori');
				
				$konten="<tr><td colspan=\"2\" style=\"padding: 10px 10px 10px 10px;\">
							<table cellpadding=\"1\" cellspacing=\"1\" align=\"center\" bgcolor=\"orange\" width=\"100%\">
								<tr bgcolor=\"#607c3c\">
									<div style=\"background: url(./imagea/tab2.jpg); height:23px;\">
									<div style=\"padding-top:4px; text-align:center; width:723px;\"><font color='#ffffff' style=\"padding-top:20px; font-size:14px\">Produsen</font>
									</div></div>
									<td>";
									opendb();
									$proses=$_GET['proses'];
									switch($proses){
									case 'tambah':
									$konten.="	<div style=\"padding: 10px 10px 10px 10px;\">
												<div style=\"background: orange; color: white; text-align: center; width: 100px;\">Input Produsen</div>
												<div style=\"border: 1px solid orange; padding: 10px 10px 10px 10px; width:723px;\">";
									$konten.="
										<form action=\"produsen.php$token&proses=input\" method=\"post\">
											<table align=\"center\">
												<tr>
													<td valign=\"top\" style=\"color:#ffffff\">Nama Produsen</td>
													<td valign=\"top\" style=\"color:#ffffff\">:</td>
													<td valign=\"top\" style=\"color:#ffffff\"><input type=\"text\" name=\"namaProdusen\" size=\"25\"></td>
												</tr>
												<tr>
													<td  style=\"color:#ffffff\" valign=\"top\" colspan=\"3\" align=\"center\">
														<div style=\"padding-top:10px;\">
															<input type=\"submit\" name=\"submit\" value=\"Input\" style=\"border:1px solid grey\">
															<input type=\"Reset\" name=\"reset\" value=\"Batal\" style=\"border:1px solid grey\">
														</div>
													</td>
												</tr>
											</table>
										</form>
									";
									break;
									
									case 'input':
									$token=$_GET['token'];
									if(isset($_POST['submit'])){
										$namaProdusen=filter($_POST['namaProdusen']);
											if($namaProdusen !=""){
												$sql_input="INSERT INTO produsen VALUES('','$namaProdusen')";
												$query_input=mysql_query($sql_input);
													if(!$query_input){
														$konten.="<div style=\"padding-top:10px; background-color: #607c3c; padding-bottom:10px; padding-left:5px;\">
														<font color='#ffffff'>Failed to Input some empty fields found</font>
														<div style=\"padding-top:10px; padding-left:5px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
														</div></div>";
													}
													else{
														header("Location: produsen.php?token=$token");
													}
											}
											else{
											$konten.="<div style=\"padding-top:10px; background-color: #607c3c; padding-bottom:10px; padding-left:5px;\">
												<font color='#ffffff'>Failed to Input some empty fields found</font>
												<div style=\"padding-top:10px; padding-left:5px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
												</div></div>";
											}
									}
										else{
											$konten.="<div style=\"padding-top:10px; background-color: #607c3c; padding-bottom:10px; padding-left:5px;\">Failed to Input some empty fields found
													<div style=\"padding-top:10px; padding-left:5px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
													</div></div>";
										}
									break;
									
									case "hapus":
										$id=$_GET['id'];
										$token=$_GET['token'];
										$sqlCek="SELECT P.namaProduk FROM produsen Pro, produk P 
												WHERE P.idProdusen=Pro.idProdusen 
												AND Pro.idProdusen='$id'";
										$queryCek=mysql_query($sqlCek);
										$jumCek=mysql_num_rows($queryCek);
											if($jumCek==0){
												$query_hapus=mysql_query("DELETE FROM produsen WHERE idProdusen='$id'");
												if(!$query_hapus){
												$konten.="<div style=\"padding-top:10px; background-color: #607c3c; padding-bottom:10px; padding-left:5px;\">Failed to delete data
														<div style=\"padding-top:10px; padding-left:5px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
														</div></div>";
												}
												else{
													header("Location: produsen.php?token=$token");
												}
											}
											else{
												$konten.="<div style=\"padding-top:10px; background-color: #607c3c; padding-bottom:10px;\">Gagal menghapus data. Produsen ini masih punya keterkaitan dengan beberapa produk
													<div style=\"padding-top:10px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
													</div></div>";
											}
									break;
									
									case 'edit':
									$id=$_GET['id'];
									$token=$_GET['token'];
										$sql_edit="SELECT * FROM produsen WHERE idProdusen='$id'";
										$query_edit=mysql_query($sql_edit);
										$jum=mysql_num_rows($query_edit);
											if($jum==0){
												$konten.="<div style=\"padding-top:10px; background-color: #607c3c;\">
												<a href=\"index.php$token\">Halaman utama</a> 
												<a href=produsen.php$token&proses=tambah>Tambah Data</a>
												</div>";
											}
											else{
												$konten.="<div style=\"padding: 10px 10px 10px 10px;\">
											<div style=\"background-color: orange; color: white; text-align: center; width: 100px;\">Edit Produsen</div>
											<div style=\"border: 1px solid orange; padding: 10px 10px 10px 10px; width:723px;\">";
										
												$rowEdit=mysql_fetch_array($query_edit);
													$konten.="
														<form action=\"produsen.php?token=$token&proses=update\" method=\"post\">
														<table align=\"center\">
															<tr>
																<td style=\"color:#ffffff\">Nama Produsen</td>
																<td style=\"color:#ffffff\">:</td>
																<td style=\"color:#ffffff\"><input type=\"text\" name=\"namaProdusen\" value=\"$rowEdit[namaProdusen]\"></td>
															</tr>
															<tr>
																<td colspan=\"3\" align=\"center\" style=\"color:#ffffff\">
																	<input type=\"submit\" name=\"update\" value=\"Update\" style=\"border:1px solid grey\">
																	<input type=\"hidden\" name=\"id\" value=\"$rowEdit[idProdusen]\">
																</td>
															</tr>
														</table>
													</form>
													";
												}
									
									break;
									
									case 'update':
									$id=(int)$_POST['id'];
									$update=filter($_POST['update']);
									$namaProdusen=filter($_POST['namaProdusen']);
									$token=$_GET['token'];
										if(!$update){
											$konten.="<div style=\"padding-top:10px; background-color: #607c3c; padding-bottom:10px; padding-left:5px;\"><font color=\"ffffff\">Failed to update data</font>
													<div style=\"padding-top:10px; padding-left:5px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
													</div></div>";
										}
										else{
											if($namaProdusen!=""){
												$sqlUpdate="UPDATE produsen SET namaProdusen='$namaProdusen' WHERE idProdusen='$id'";
												$queryUpdate=mysql_query($sqlUpdate);
														if(!queryUpdate){
															$konten.="<div style=\"padding-top:10px; background-color: #607c3c; padding-left:5px; padding-bottom:10px;\"><font color=\"ffffff\">Failed to update data</font>
															<div style=\"padding-top:10px; padding-left:5px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
															</div></div>";
														}
														else{
															header("Location: produsen.php?token=$token");
														}
											}
											else{
												$konten.="<div style=\"padding-top:10px; background-color: #607c3c; padding-bottom:10px; padding-left:5px;\"><font color=\"#ffffff\">Failed to update data some empty fields found</font>
														<div style=\"padding-top:10px; padding-left:5px;\"><input type=\"button\" value=\"Kembali\" onclick=\"self.history.back()\" style=\"border:1px solid grey\">
														</div></div>";
												}
														
											}
										
									break;
									
									default:
										$sql_view="SELECT * FROM produsen";
										$query_view=mysql_query($sql_view);
										$jum=mysql_num_rows($query_view);
											if($jum==0){
												$konten.="<div style=\"padding-top:10px; background-color: #607c3c\">
												<a href=\"index.php$token\">Halaman utama</a> 
												<a href=produsen.php$token&proses=tambah>Tambah Data</a>
												</div>";
											}
											else{
													$konten.="
														<table align=\"center\" cellpadding=\"3\" cellspacing=\"0\" width=\"100%\" bgcolor=\"#364b1a\" border=\"0\">
															<tr>
																<td class=\"cart\" style=\"color:#ffffff;\">No</td>
																<td class=\"cart\" style=\"color:#ffffff;\">Produsen</td>
																<td class=\"cart\" style=\"color:#ffffff;\">Aksi</td>
															</tr>
													";
													$i=1;
													$j=0;
														while($row_view=mysql_fetch_array($query_view)){
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
																	<td class=\"cart\" align=\"center\">$i</td>
																	<td class=\"cart\" align=\"center\">$row_view[namaProdusen]</td>
																	<td class=\"cart\" align=\"center\">[<a href=\"produsen.php$token&proses=edit&id=$row_view[idProdusen]\">Edit</a>][<a href=\"produsen.php$token&proses=hapus&id=$row_view[idProdusen]\" onClick=\"return confirm('Anda Yakin Akan Menghapus?');\">Hapus</a>]</td>
																</tr>
															";
														$i++;
														}
													$konten.="</table>
												<div style=\"padding-top:10px; background-color: #607c3c\">
												<a href=\"index.php$token\">Halaman utama</a> 
												<a href=produsen.php$token&proses=tambah>Tambah Data</a>
												</div>";
												}
									break;
								}
									
									closedb();
								$konten.="</td>
							</tr>
						</table>
					</td>
				</tr>";
				
			$produsen=new Admin();
			$produsen->setTitle($title);
			$produsen->setIsi($konten);
			$produsen->setArrayMenu($arrayMenu);
			$produsen->setLinkLogout($isiLink);
			$produsen->getTampilkan();
				
			
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
