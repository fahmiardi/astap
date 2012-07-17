<?php
	header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
	header('Cache-Control: no-store, no-cache, must-revalidate');
	header('Cache-Control: post-check=0, pre-check=0, false');
	
	session_start();
	
	include_once "./include/functions.php";
	include_once "./library/kelasPelanggan.php";
	include_once "./include/functions-product.php";
	if(authPelanggan($_SESSION['ASTA_USERNAME'], $_SESSION['ASTA_PASSWORD'])) {
		header("Location: index2.php?token=$_SESSION[ASTA_HASH]");
	}
	else {
		$token=createRandomtoken(); 
		$enctoken=Encrypt($token); 
		$_SESSION['ASTA_TOKEN']=(string)$enctoken; 
		
		if(isset($_GET['timeout'])) {
			$pesan="Maaf, waktu Anda habis. Silahkan login kembali.";
		}
		elseif(isset($_GET['wrong'])){
			$pesan="Maaf, username atau password Anda salah.";
		}		
		elseif(isset($_GET['nosess'])){
			$pesan = "Terima kasih atas kunjungannya.";
		}
		elseif(isset($_GET['wrong2'])) {
			$pesan="Naughty, very naughty...";
		}
		else {
			$pesan="";
		}
		
		$title="::$JUDUL | $RINCIAN::";
		$isiWarning="<tr><td colspan=2><div align=center><font color=black>$pesan</font></div></td></tr>";
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
						$sql_id="SELECT idProduk, stockProduk, namaProduk, hargaProduk, konten, pathImage 
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
												<td valign=\"top\">Stock</td>
												<td valign=\"top\">:</td>
												<td valign=\"top\">$row[stockProduk]</td>
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
																		$sql_det="	SELECT P.idProduk, P.stockProduk, P.konten, K.namaKategori, D.namaProdusen 
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
																						<td valign=\"top\">Stock</td>
																						<td valign=\"top\">:</td>
																						<td valign=\"top\">$row_det[stockProduk]</td>
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
	
		$isi_2=	"<tr><td colspan=\"2\">
			<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\">
				<tr>
					<td>
						<table bgcolor=\"#$TRIP\" cellpadding=\"0\" cellspacing=\"0\" width=\"244\" style=\"font: normal 11px tahoma, arial;\">
							<tr>
								<td style=\"padding: 10px; color:#$TEXT;\"><b>News Ticker</b></td>
								<td></td>
								</tr>
							<tr style=\"background: #$BACK;\">
								<td style=\"padding: 10px;\">
									<marquee behavior=\"scroll\" direction=\"up\" scrollamount=\"2\" style=\"height: 130px;\">";
										$sql_tick="	SELECT isiBerita 
													FROM berita 
													WHERE idKategoriBerita='2'";
										$query_tick=mysql_query($sql_tick,opendb())or die(mysql_error);
										if($query_tick != null) {
											if(mysql_num_rows($query_tick)>0) {
												while($row_tick=mysql_fetch_array($query_tick)) {
													$isi_2 .="<div style=\"padding-bottom: 10px;\">$row_tick[isiBerita]</div>";
												}
											}
										}
							$isi_2.="	</marquee>								
									</td>
								<td></td>
								</tr>
					</table>
				</td>
				<td width=\"1\" bgcolor=\"#$TRIP\">
					</td>
				<td>
					<table bgcolor=\"#$TRIP\" cellpadding=\"0\" cellspacing=\"0\" width=\"244\" style=\"font: normal 11px tahoma, arial;\">
						<tr><td style=\"padding: 10px; color:#$TEXT;\"><b>User Login</b></td><td></td></tr>
						<tr style=\"background: #$BACK;\"><td style=\"padding: 10px; \">
							<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">
								<tr><td>
								<form action=\"index2.php?act=login\" name=\"login\" method=\"POST\">
								<p id=\"login\" style=\"margin-right: 20px; \">
									uname : <input type=\"text\" class=\"ctext\" size=\"20\" name=\"uname\"><br>
									cpass : <input type=\"password\" class=\"ctext\" size=\"20\" name=\"cpass\"><br>
									<span style=\"float: right;\">
									<input type=\"hidden\" name=\"enctoken\" value=\"$enctoken\">
									<input type=\"submit\" name=\"cmd_submit\" value=\"Login\" class=\"ctombol\">
									<input type=\"reset\" value=\"Reset\" class=\"ctombol\"></span>
									<div class=\"small\" style=\"float: left; margin: 0 0 0 2px;\"><br>
									<a href=\"action.php?view=lost\" class=\"small\" title=\"Lupa Password\" alt=\"Lupa Password\"><font color=\"#000000\">Lupa Password?</font></a><br>
									Bukan pelanggan? <a href=\"action.php?view=daftar\" class=\"small\" title=\"Daftar\" alt=\"Daftar\"><font color=\"#000000\">Daftar</font></a></div>
								</p>
								</form>
								</td></tr>
							</table>
						</td>
						<td></td></tr>
					</table>
					</td></tr>
			</table>
			</td>
			</tr>";		
		$isi_3 .=	"<tr><td colspan=\"2\" width=\"487\">
						<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
							<tr><td>
									<!-- start table for gallery -->
									<table width=\"487\" cellpadding=\"0\" cellspacing=\"0\">
										<tr><td>
											<table width=\"487\" cellpadding=\"0\" cellspacing=\"0\" 
											style=\"border: 1px solid #$TRIP; border-left: 0px; border-right: 0px; padding: 0px;\">
												<tr><td style=\"padding: 10px; background: #$TRIP; color:#$TEXT;\"><b>Katalog</b></td></tr>
												<tr><td style=\" width: 487px; overflow: hidden; float: left;\">
													<script type=\"text/javascript\">
													function mycarousel_initCallback(carousel)
													{
														// Disable autoscrolling if the user clicks the prev or next button.
														carousel.buttonNext.bind('click', function() {
															carousel.startAuto(0);
														});

														carousel.buttonPrev.bind('click', function() {
															carousel.startAuto(0);
														});

														// Pause autoscrolling if the user moves with the cursor over the clip.
														carousel.clip.hover(function() {
															carousel.stopAuto();
														}, function() {
															carousel.startAuto();
														});
													};

													jQuery.easing['BounceEaseOut'] = function(p, t, b, c, d) {
														if ((t/=d) < (1/2.75)) {
															return c*(7.5625*t*t) + b;
														} else if (t < (2/2.75)) {
															return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
														} else if (t < (2.5/2.75)) {
															return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
														} else {
															return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
														}
													};

													jQuery.noConflict();
													jQuery(document).ready(function() {
														jQuery('#mycarousel').jcarousel({
															auto: 2,
															wrap: 'last',
															easing: 'BounceEaseOut',
															animation: 800,
															initCallback: mycarousel_initCallback
														});
													});
													</script>";
													opendb();
													$sql_kat="SELECT idProduk FROM produk";
													$query_kat=mysql_query($sql_kat,opendb());
													if($query_kat != null){
														if(mysql_num_rows($query_kat)>0) {
															while($row_kat=mysql_fetch_array($query_kat)) {
																$arrayID_kat[]=$row_kat[idProduk];
															}
															$jum_data=mysql_num_rows($query_kat);
															srand((float) microtime() * 10000000);
															$jum_show=12;
															if($jum_data<$jum_show) {
																$jum_kat=$jum_data;
															}
															else {
																$jum_kat=$jum_show;
															}																
															$rand_kat=array_rand($arrayID_kat,$jum_kat);
														}
													}			
										$isi_3.="	<div id=\"content\">
														<div class=\"tab\"></div>
														<div style=\"height: 150px; overflow: hidden; width: 100%;\">
															<ul id=\"mycarousel\" class=\"jcarousel-skin-tango\">";
															for($idx=0; $idx<$jum_kat; $idx++) {
																$id_kat=$arrayID_kat[$rand_kat[$idx]];
																$sql_idKat="SELECT idProduk, pathImage, namaProduk 
																			FROM produk 
																			WHERE idProduk='$id_kat'";
																$row_show=setSlide($sql_idKat);
																$sub_kat=substr($row_show['namaProduk'],0,12);
																$isi_3 .= "<li>
																				<div class=\"tab\">
																					<div><a href=\"#show\" title=\"$row_show[namaProduk]\" alt=\"$row_show[namaProduk]\"><img src=\"imagea/product/$row_show[pathImage]\" width=\"75\" height=\"75\" border=\"0\" alt=\"$row_show[namaProduk]\" /></a></div>
																					<div class=\"gtitle\"><a href=\"#show\">$sub_kat...</a></div>
																					</div>																		
																				</li>";
															}														
												$isi_3 .="		</ul>
															<span style=\"vertical-align: top; padding-top: 0px;\">
																<a href=\"katalog.php\" class=\"small\">More...</a>
																</span>
															</div>
														<div class=\"boxholder\">
															<div class=\"box\"></div>
															<div>";																
																for($idx2=0; $idx2<$jum_kat; $idx2++) {
																	$id_ShowKat=$arrayID_kat[$rand_kat[$idx2]];
																	$sql_ShowKat="	SELECT P.idProduk, P.stockProduk, P.namaProduk, P.hargaProduk, D.namaProdusen, P.konten, K.namaKategori 
																					FROM produk P, kategori K, produsen D 
																					WHERE P.idProduk='$id_ShowKat' 
																					AND P.idKategori=K.idKategori 
																					AND P.idProdusen=D.idProdusen";
																	$row_ShowKat=setSlide($sql_ShowKat);
																	$isi_3 .= "	<div class=\"box\" style=\"background-color: #$BACK;\">
																					<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" align=\"center\">
																						<tr>
																							<td valign=\"top\" width=\"75\">Nama Produk</td>
																							<td	valign=\"top\" width=\"10\">:</td>
																							<td><b>$row_ShowKat[namaProduk]</b></td>
																							</tr>
																						<tr>
																							<td>Harga Produk</td>
																							<td>:</td>
																							<td>Rp. $row_ShowKat[hargaProduk],-</td>
																							</tr>
																						<tr>
																							<td>Stock</td>
																							<td>:</td>
																							<td>$row_ShowKat[stockProduk]</td>
																							</tr>
																						<tr>
																							<td>Produsen</td>
																							<td>:</td>
																							<td>$row_ShowKat[namaProdusen]</td>
																							</tr>
																						<tr>
																							<td>Deskripsi</td>
																							<td>:</td>
																							<td>$row_ShowKat[konten]</td>
																							</tr>
																						<tr>
																							<td></td>
																							<td></td>
																							<td align=\"left\" style=\"padding-top: 10px;\">																								
																								<div><a href=\"cart.php?pd_id=$row_ShowKat[idProduk]\"><div><img src=\"imagea/trash.ico\" width=\"16\" height=\"16\">&nbsp;&nbsp;AddToCart</div></a></div>																								
																								</td>
																							</tr>
																						<tr>
																							<td colspan=\"3\"><div style=\"padding-top: 30px;\"></div></td>
																							</tr>
																						</table>
																					</div>";
																}
													$isi_3 .= "	</div>
															</div>
														</div>	
													</td></tr>												
											</table>
											</td></tr>
									</table>
									<!-- end of table for gallery -->
								</td></tr>
						</table>
						</td></tr>";
	}

	$index=new Pelanggan();
	$index->setTitle($title);
	$index->setSlide($isiSlide);
	$index->setIsi_2($isi_2);
	$index->setIsi_3($isi_3);
	$index->setLinkLogout("");
	$index->setWarning($isiWarning);
	$index->getTampilkan();
?>