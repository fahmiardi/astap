<?php
	header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
	header('Cache-Control: no-store, no-cache, must-revalidate');
	header('Cache-Control: post-check=0, pre-check=0, false');
	
	session_start();
	include_once "./library/kelasPelanggan.php";
	include_once "./include/functions.php";
	include_once "./include/functions-cart.php";
	include_once "./include/functions-product.php"; 

	$token1=createRandomtoken(); 
	$enctoken1=Encrypt($token1);
	$_SESSION['ASTA_TOKEN']=(string)$enctoken1;
	
	if(isset($_SESSION['ASTA_HASH']) && $_GET['token']==$_SESSION['ASTA_HASH']) {
		if(isset($_GET['pd_id']) && $_GET['pd_id'] > 0) {
			if(!authPelanggan($_SESSION['ASTA_USERNAME'], $_SESSION['ASTA_PASSWORD'])) {
				emptyCart($_SESSION['ASTA_HASH']);
				unset($_GET['token']);
				unset($_SESSION['ASTA_USERNAME']);
				unset($_SESSION['ASTA_PASSWORD']);
				unset($_SESSION['ASTA_HASH']);
				unset($_SESSION['ASTA_TIMESTAMP']);
				unset($_SESSION['ASTA_TOKEN']);
				session_destroy();
				header("Location: index1.php?naughty");
			}
			else {
				//logged pelanggan
				if(addToCart($_GET['pd_id'],$_GET['token'])) {
					header("Location: index2.php?token=$_SESSION[ASTA_HASH]");
				}
			}
		}
		else {
			//milih produk ulang
			header("Location: index2.php?token=$_SESSION[ASTA_HASH]");
		}
	}
	else {
		if($_GET['token'] != $_SESSION['ASTA_HASH']) {
			//jika merubah token
			opendb();
			$sql_konf="SELECT idCart FROM cart WHERE ct_token='$_SESSION[ASTA_HASH]'";
			$query_konf=mysql_query($sql_konf,opendb())or die(mysql_errno());
			if($query_konf != null) {
				$jmlh_konf=mysql_num_rows($query_konf);
				if($jmlh_konf <=0) {
					//kosong
				}
				else {
					$sql_empty="DELETE FROM cart WHERE ct_token='$_SESSION[ASTA_HASH]'";
					$query_empty=mysql_query($sql_empty,opendb())or die(mysql_error());
				}
			}
			closedb();
			emptyCart($_SESSION['ASTA_HASH']);
			unset($_SESSION['ASTA_USERNAME']);
			unset($_SESSION['ASTA_PASSWORD']);
			unset($_SESSION['ASTA_HASH']);
			unset($_SESSION['ASTA_TIMESTAMP']);
			session_destroy();
			header("Location: index1.php?wrong2");
		}
		else {
			//jika tidak ada token, isset isi form pendaftaran dan menu login
			$title="::$JUDUL | Formulir Pendaftaran::";
			opendb();
			$sql_slide="SELECT idProduk FROM produk WHERE idStatusProduk='2'";			
			$hasil = mysql_query($sql_slide,opendb());
			if($hasil != null) {
				if(mysql_num_rows($hasil)>0){
					while($row1=mysql_fetch_array($hasil)) {
						$arrayID[]=$row1[idProduk];
					}
					srand((float) microtime() * 10000000);
					$jum=2;
					$rand=array_rand($arrayID,$jum);
				}
			}		
			
			$isiSlide="<td align=\"left\" valign=\"top\">
					<div class=\"marquee\" style=\"height: 19px; background-color: #$TRIP;\"><marquee behavior=\"scroll\" direction=\"left\" scrollamount=\"2\">";
							$sql_marq="	SELECT * 
										FROM berita B 
										WHERE idKategoriBerita='1' 
										AND idStatusShow='1' 
										ORDER BY idBerita DESC";
							$query_marq=mysql_query($sql_marq,opendb())or die(mysql_error());
							if($query_marq != null) {
								if(mysql_num_rows($query_marq)>0) {
									$row_marq=mysql_fetch_array($query_marq);
									$isiSlide.="<b><font color=\"#$TEXT\">INFO : ".$row_marq['isiBerita']."</font></b>";
								}
							}
			$isiSlide.="</marquee></div>
						<div style=\"padding-top: 21px;\"><div style=\"height: 22px; background-color: #$TRIP; width: 100px;\"><div style=\"padding-top: 4px; color: #$TEXT; text-align: center;\">**<b>NEW PRODUCT</b>**</div></div></div>";
					for($i=0; $i<$jum; $i++) {
						$id=$arrayID[$rand[$i]];
						$sql_id="SELECT idProduk, namaProduk, hargaProduk, konten, pathImage 
								FROM produk 
								WHERE idProduk='$id'";
						$row=setSlide($sql_id);
						$isiSlide.="			
						<div style=\"border: 1px solid #$TRIP; vertical-align: left; padding: 10px 10px 10px 10px;\">
							<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" align=\"center\" border=\"0\">
								<tr>
									<td width=\"75\" valign=\"top\">
										<img src=\"imagea/product/$row[pathImage]\" width=\"75\" height=\"111\">
										</td>
									<td style=\"padding-left: 10px;\" valign=\"top\">
										<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" align=\"center\" border=\"0\">
											<tr>
												<td valign=\"top\" width=\"50\">Nama</td>
												<td valign=\"top\" width=\"10\">:</td>
												<td valign=\"top\"><b>$row[namaProduk]</b></td>
												</tr>											
											<tr>
												<td valign=\"top\">Harga</td>
												<td valign=\"top\">:</td>
												<td valign=\"top\">Rp. $row[hargaProduk],-</td>
												</tr>
											<tr>
												<td valign=\"top\">Deskripsi</td>
												<td valign=\"top\">:</td>
												<td valign=\"top\">";
												$sub = substr($row[konten],0,50);
									$isiSlide .="$sub...</td>
												</tr>
											<tr>
												<td colspan=\"3\" valign=\"top\" style=\"padding-top: 20px;\">
													<div id=\"wrapper2\">
														<div id=\"content\">
															<div class=\"tab\"></div>
															<div class=\"tab\" style=\"background-color: #$TRIP;\"><h3 class=\"tabtxt\" title=\"View\" style=\"background-color: #$TRIP;\"><a href=\"#view\"><div style=\"color: #$TEXT;\"><img src=\"imagea/find.ico\" width=\"16\" height=\"16\">&nbsp;&nbsp;View</div></a></h3></div>
															<div style=\"background-color: #$TRIP;\"><h3 class=\"tabtxt\" title=\"AddToCart\" style=\"background-color: #$TRIP;\"><a href=\"cart.php?pd_id=$row[idProduk]\"><div style=\"color: #$TEXT;\"><img src=\"imagea/trash.ico\" width=\"16\" height=\"16\">&nbsp;&nbsp;AddToCart</div></a></h3></div>
															<div class=\"boxholder\" style=\"background-color: #$TRIP;\">
																<div style=\"border: 1px solid #$TRIP;\">
																	<div class=\"box\" style=\"background-color: #$BACK;\"></div>
																	<div class=\"box\" style=\"padding: 0px 10px 0px 10px; background-color: #$BACK;\">
																		<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" align=\"center\" border=\"0\">";
																		opendb();
																		$sql_det="	SELECT P.idProduk, P.konten, K.namaKategori, D.namaProdusen 
																					FROM produk P, kategori K, produsen D 
																					WHERE P.idProduk='$row[idProduk]' 
																					AND P.idKategori=K.idKategori 
																					AND P.idProdusen=D.idProdusen";
																		$query_det=mysql_query($sql_det,opendb());
																		while($row_det=mysql_fetch_array($query_det)){
																			$isiSlide.= "
																					<tr>
																						<td valign=\"top\" width=\"50\">Kategori</td>
																						<td valign=\"top\" width=\"10\">:</td>
																						<td valign=\"top\">$row_det[namaKategori]</td>
																						</tr>
																					<tr>
																						<td valign=\"top\">Produsen</td>
																						<td valign=\"top\">:</td>
																						<td valign=\"top\">$row_det[namaProdusen]</td>
																						</tr>
																					<tr>
																						<td valign=\"top\">Deskripsi</td>
																						<td valign=\"top\">:</td>
																						<td valign=\"top\">$row_det[konten]</td>
																						</tr>";
																		}
																$isiSlide .="</table><div class=\"tab\" style=\"padding-top: 10px;\"><a href=\"#back\"><i><font color=\"#$TEXT\">Hide</font></i></a></div>																			
																		</div>																			
																	<div class=\"box\"></div>
																	</div>
															</div>
														
														</div>
													</td>
												</tr>
											</table>
										</td>
									</tr>								
								</table>
							</div>";
					}
			$isiSlide.="</td>";
			
			$isi_2=	"<tr><td colspan=\"2\" valign=\"top\">
						<div id=\"content\">
							<table cellpadding=\"0\" cellspacing=\"1\" border=\"0\" width=\"100%\" bgcolor=\"#$TRIP\">
								<tr bgcolor=\"#$BACK\">
									<td width=\"50%\">
										<div style=\"padding: 10px 10px 10px 10px;\">									
											<div style=\"padding-top: 35px; padding-left: 10px;\">
												Apakah Anda <a href=\"action.php?view=daftar\" alt=\"Pelanggan Baru\" title=\"Pelanggan Baru\"><font color=\"#000000\">Pelanggan Baru?</font></a>
												</div>
											</div>
									</td>
									<td>								
										<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" valign=\"top\">
											<tr><td>
												<div style=\"padding: 5px 0 5px 5px;\">Jika Anda pelanggan kami, silahkan Login :</div><div>
												<form action=\"index2.php?act=login\" name=\"login\" method=\"POST\">
													<p id=\"login\" style=\"margin-right: 20px; \">												
														uname : <input type=\"text\" class=\"ctext\" size=\"20\" name=\"uname\"><br>
														cpass : <input type=\"password\" class=\"ctext\" size=\"20\" name=\"cpass\"><br>
														<span style=\"float: right;\">
														<input type=\"hidden\" name=\"enctoken\" value=\"$enctoken1\">
														<input type=\"submit\" name=\"cmd_submit\" value=\"Login\" class=\"ctombol\">
														<input type=\"reset\" value=\"Reset\" class=\"ctombol\"></span>
														<div class=\"small\" style=\"float: left; margin: 0 0 0 2px;\">												
															<a href=\"action.php?view=lost\" class=\"small\" alt=\"Lupa Password\" title=\"Lupa Password\"><div style=\"padding: 5px 0 5px 5px;\">Lupa Password?</div></a>
														</div>
														</p>
													</form>
												</td></tr>
											</table>									
										</td>						
									</tr>								
								</table>
							</div>
					</td></tr>";
				
			$cart=new Pelanggan();
			$cart->setTitle($title);
			$cart->setSlide($isiSlide);
			$cart->setIsi_2($isi_2);
			$cart->getTampilkan();
		}
	}
?>