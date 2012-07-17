<?php
	include_once "./library/kelasPelanggan.php";
	include_once "./include/functions.php";
	include_once "./include/functions-cart.php";
	
	if(isset($_GET['view'])) {
		if($_GET['view']=="daftar") {
			$title="::$JUDUL | Form Registrasi::";
			$isi_2="<tr>
				<td colspan=\"2\" style=\"padding-top: 10px;\">
					<table cellpadding=\"0\" cellspacing=\"0\" align=\"center\" bgcolor=\"#$TRIP\" width=\"100%\">
						<form action=\"$_SERVER[PHP_SELF]?view=daftar\" method=\"POST\">
							<tr bgcolor=\"#$BACK\">
								<td vailgn=\"top\"> 
									<div style=\"background-color: #$TRIP; width:162px; text-align: center; font-family: tahoma; font-size: 13px; font-weight: bold; color: #ffffff;\">Form Registrasi</div>
									<div style=\"border: 1px solid #$TRIP; padding: 10px 10px 10px 10px;\">";
										if(isset($_GET['ac']) && $_GET['ac'] != "") {
											if($_GET['ac'] == "finish") {
												$isi_2 .= "<div>Terima kasih Anda telah menjadi pelanggan kami. Silahkan <a href=\"index1.php\"><b>LOGIN</b></a> untuk mulai berbelanja.</div>";
											}
											else {
												header("Location: index1.php");
											}
										}
										else {
							$isi_2 .="	<div style=\"padding: 10px 10px 10px 10px;\">
											<div style=\"background: #$TRIP; color: #$TEXT; text-align: center; width: 100px;\">Data Diri</div>
											<div style=\"border: 1px solid #$TRIP; padding: 10px 10px 10px 10px; width: 425px;\">
												<table cellpadding=\"2\" cellspacing=\"0\" width=\"100%\" align=\"center\" valign=\"top\" border=\"0\">";
													$aksi1=false;
													$aksi2=false;
													$aksi3=false;
													$aksi4=false;
													$aksi5=false;
													$aksi6=false;
													$aksi7=false;
													$aksi8=false;
													$aksi9=false;
													$aksi10=false;
													if($_POST['submit']) {
														if($_POST['namaPelanggan'] == "") {
															$mark1="#$TRIP";
														}
														else {
															$mark1="white";
															$aksi1=true;
														}
													}
													else {
														$mark1="white";														
													}
										$isi_2 .="	<tr>
														<td valign=\"top\">Nama Lengkap</td>
														<td valign=\"top\" width=\"10\">:</td>
														<td valign=\"top\"><input type=\"text\" name=\"namaPelanggan\" size=\"30\" value=\"$_POST[namaPelanggan]\" style=\"background-color: $mark1;\"></td>
														</tr>";
													
													if($_POST['submit']) {
														if($_POST['alamatPelanggan'] == "") {
															$mark2="#$TRIP";
														}
														else {
															$mark2="white";
															$aksi2=true;
														}
													}
													else {
														$mark2="white";														
													}
										$isi_2 .="	<tr>
														<td valign=\"top\">Alamat</td>
														<td valign=\"top\">:</td>
														<td valign=\"top\"><textarea style=\"font-family: tahoma; font-weight: bold; font-size: 10px; background-color: $mark2;\" name=\"alamatPelanggan\" rows=\"7\" cols=\"40\" wrap>$_POST[alamatPelanggan]</textarea></td>
														</tr>";
													
													if($_POST['submit']) {
														if($_POST['kota'] == "") {
															$mark3="#$TRIP";
														}
														else {
															$mark3="white";
															$aksi3=true;
														}
													}
													else {
														$mark3="white";														
													}
										$isi_2 .="	<tr>
														<td valign=\"top\">Kota</td>
														<td valign=\"top\">:</td>
														<td valign=\"top\"><input type=\"text\" name=\"kota\" size=\"30\" value=\"$_POST[kota]\" style=\"background-color: $mark3;\"></td>
														</tr>";
														
													if($_POST['submit']) {
														if($_POST['propinsi'] == "") {
															$mark4="#$TRIP";
														}
														else {
															$mark4="white";
															$aksi4=true;
														}
													}
													else {
														$mark4="white";														
													}
										$isi_2 .="	<tr>
														<td valign=\"top\">Propinsi</td>
														<td valign=\"top\">:</td>
														<td valign=\"top\"><input type=\"text\" name=\"propinsi\" size=\"30\" value=\"$_POST[propinsi]\" style=\"background-color: $mark4;\"></td>
														</tr>";
														
													if($_POST['submit']) {
														if($_POST['kodepos'] == "") {
															$mark5="#$TRIP";
														}
														else {
															$mark5="white";
															$aksi5=true;
														}
													}
													else {
														$mark5="white";														
													}
										$isi_2 .="	<tr>
														<td valign=\"top\">Kode Pos</td>
														<td valign=\"top\">:</td>
														<td valign=\"top\"><input type=\"text\" name=\"kodepos\" size=\"10\" value=\"$_POST[kodepos]\" style=\"background-color: $mark5;\"></td>
														</tr>";
													
													if($_POST['submit']) {
														if($_POST['email'] == "" || !isEmail($_POST['email'])) {
															$mark6="#$TRIP";
														}
														else {
															$sql_email="SELECT email FROM pelanggan WHERE email='$_POST[email]'";
															$query_email=mysql_query($sql_email,opendb())or die(mysql_error());
															if($query_email != null) {
																if(mysql_num_rows($query_email)>0) {																																	
																	$mark6="#$TRIP";
																	$pe="email sudah dipakai";
																}
																else {
																	$mark6="white";
																	$aksi6=true;
																}
															}																														
														}
													}
													else {
														$mark6="white";														
													}
										$isi_2 .="	<tr>
														<td valign=\"top\">Email</td>
														<td valign=\"top\">:</td>
														<td valign=\"top\"><input type=\"text\" name=\"email\" size=\"30\" value=\"$_POST[email]\" style=\"background-color: $mark6;\"><i> $pe</i></td>
														</tr>";
														
													if($_POST['submit']) {
														if($_POST['phone'] == "") {
															$mark7="#$TRIP";
														}
														else {
															$mark7="white";
															$aksi7=true;
														}
													}
													else {
														$mark7="white";														
													}
										$isi_2 .="	<tr>
														<td valign=\"top\">Phone</td>
														<td valign=\"top\">:</td>
														<td valign=\"top\"><input type=\"text\" name=\"phone\" size=\"30\" value=\"$_POST[phone]\" style=\"background-color: $mark7;\"></td>
														</tr>														
													</table>
												</div>
											<div style=\"padding-top: 10px;\"></div>
											<div style=\"padding-left: 347px;\"><div style=\"background: #$TRIP; color: #$TEXT; text-align: center; width: 100px;\">Account</div></div>
											<div style=\"border: 1px solid #$TRIP; padding: 10px 10px 10px 10px; width: 425px;\">
												<table cellpadding=\"2\" cellspacing=\"0\" width=\"100%\" align=\"center\" valign=\"top\" border=\"0\">";
													opendb();
													$sql_un="SELECT usernameAsal FROM username WHERE usernameAsal='$_POST[username]'";
													$query_un=mysql_query($sql_un,opendb())or die(mysql_error());
													if($query_un != null) {
														if(mysql_num_rows($query_un) > 0) {
															$row_un=mysql_fetch_array($query_un);
															$a=$row_un['usernameAsal'];
														}
														else {
															$a="";
														}
													}
													closedb();														
													if($_POST['submit']) {
														if($_POST['username'] == "") {
															$mark8="#$TRIP";
															$pes="";
														}
														elseif($_POST['username']==$a) {
															$mark8="#$TRIP";
															$pes="<small><i> Username sudah ada</i></small>";
														}
														else {
															$mark8="white";
															$pess="";
															$aksi8=true;
														}
													}
													else {
														$mark8="white";
														$pes="";														
													}
										$isi_2 .="	<tr>
														<td valign=\"top\">Username</td>
														<td valign=\"top\" width=\"10\">:</td>
														<td valign=\"top\"><input type=\"text\" name=\"username\" size=\"30\" value=\"$_POST[username]\" style=\"background-color: $mark8;\">$pes</td>
														</tr>";
														
													if($_POST['submit']) {
														if($_POST['password'] == "") {
															$mark9="#$TRIP";
														}
														elseif($_POST['confPassword'] == "") {
															$mark9="#$TRIP";
														}
														elseif($_POST['password'] != $_POST['confPassword']) {
															$mark9="#$TRIP";
														}
														else {
															$mark9="white";
															$aksi9=true;
														}
													}
													else {
														$mark9="white";														
													}
										$isi_2 .="	<tr>
														<td valign=\"top\">Password</td>
														<td valign=\"top\">:</td>
														<td valign=\"top\"><input type=\"password\" name=\"password\" size=\"30\" style=\"background-color: $mark9;\"></td>
														</tr>
													<tr>
														<td valign=\"top\">Confirm Password</td>
														<td valign=\"top\">:</td>
														<td valign=\"top\"><input type=\"password\" name=\"confPassword\" size=\"30\" style=\"background-color: $mark9;\"></td>
														</tr>
													<tr>
														<td valign=\"top\" style=\"padding-top: 20px;\">Pertanyaan</td>
														<td valign=\"top\" style=\"padding-top: 20px;\">:</td>
														<td valign=\"top\" style=\"padding-top: 20px;\">";
															
														if($_POST['submit']) {
															opendb();
															$sql_tanya="SELECT * FROM pertanyaan WHERE idPertanyaan='$_POST[idTanya]'";
															$query_tanya=mysql_query($sql_tanya,opendb())or die(mysql_error());
															if($query_tanya != null) {
																	$isi_2 .="<select name=\"idTanya\">";
																while($row_tanya=mysql_fetch_array($query_tanya)) {
																	$isi_2 .= "	<option value=\"$row_tanya[idPertanyaan]\">$row_tanya[namaPertanyaan]</option>";																					
																}
																	$sql_po="SELECT * FROM pertanyaan WHERE idPertanyaan !='$_POST[idTanya]'";
																	$query_po=mysql_query($sql_po,opendb())or die(mysql_error());
																	if($query_po != null) {
																		while($row_po=mysql_fetch_array($query_po)) {
																			$isi_2 .= "	<option value=\"$row_po[idPertanyaan]\">$row_po[namaPertanyaan]</option>";
																		}
																	}
																	$isi_2 .="</select>";
															}
														}
														else {
															opendb();
															$sql_tanya="SELECT * FROM pertanyaan";
															$query_tanya=mysql_query($sql_tanya,opendb())or die(mysql_error());
															if($query_tanya != null) {
																	$isi_2 .="<select name=\"idTanya\">";
																while($row_tanya=mysql_fetch_array($query_tanya)) {
																	$isi_2 .= "	<option value=\"$row_tanya[idPertanyaan]\">$row_tanya[namaPertanyaan]</option>";																					
																}
																	$isi_2 .="</select>";
															}
														}
										$isi_2 .= "			</td>
														</tr>";
													
													if($_POST['submit']) {
														if($_POST['jawaban'] == "") {
															$mark10="#$TRIP";
														}
														else {
															$mark10="white";
															$aksi10=true;
														}
													}
													else {
														$mark10="white";
													}
										$isi_2 .="	<tr>
														<td valign=\"top\">Jawaban</td>
														<td valign=\"top\">:</td>
														<td valign=\"top\"><input type=\"text\" name=\"jawaban\" size=\"30\" value=\"$_POST[jawaban]\" style=\"background-color: $mark10;\"></td>
														</tr>														
													</table>
												</div>
											<div style=\"padding-top: 10px;\"></div>
											<div style=\"text-align: center;\"><a href=\"action.php?view=daftar\"><input type=\"reset\" value=\"Reset\" class=\"ctombol\"></a> <input type=\"submit\" name=\"submit\" value=\"Daftar\" class=\"ctombol\"></div>
											<div><small><b><u>Note :</u></b></small></div>
											<div><small>Semua FORM wajib diisi.</small></div>
											</div>";
											if($aksi1 && $aksi2 && $aksi3 && $aksi4 && $aksi5 && $aksi6 && $aksi7 && $aksi8 && $aksi9 && $aksi10) {
												$un=filter($_POST['username']);
												$pass=filter($_POST['password']);
												$unEnc=Encrypt($un);
												$passEnc=Encrypt($pass);
												$idTanya=(int)$_POST['idTanya'];
												$jwbn=filter($_POST['jawaban']);
												$tgl=tglDB();
												
												$sql_inAcc="	INSERT INTO username 
																VALUES(	'',
																		'$unEnc',
																		'$passEnc',
																		'$un',
																		'$pass',
																		'2',
																		'$idTanya',
																		'$jwbn',
																		'',
																		'$tgl')";
												$query_inAcc=mysql_query($sql_inAcc,opendb())or die(mysql_error());
												if($query_inAcc != null) {
													$sql_cek="SELECT idUser FROM username WHERE usernameAsal='$un' AND passwordAsal='$pass'";
													$query_cek=mysql_query($sql_cek,opendb())or die(mysql_error());
													if($query_cek != null) {
														if(mysql_num_rows($query_cek)==1) {
															$row_cek=mysql_fetch_array($query_cek);
															$idUser=$row_cek['idUser'];
															$nama=filter($_POST['namaPelanggan']);
															$alamat=trim($_POST['alamatPelanggan']);
															$email=trim($_POST['email']);
															$kota=filter($_POST['kota']);
															$kode=filter($_POST['kodepos']);
															$prop=filter($_POST['propinsi']);
															$phone=filter($_POST['phone']);
															
															$sql_inPelanggan="	INSERT INTO pelanggan 
																				VALUES(	'',
																						'$nama',
																						'$alamat',
																						'$kota',
																						'$prop',
																						'$kode',
																						'$email',
																						'$phone',
																						'$idUser')";
															$query_inPelanggan=mysql_query($sql_inPelanggan,opendb())or die(mysql_error());															
														}
													}
												}
												if($query_inAcc && $query_inPelanggan) {
													header("Location: action.php?view=daftar&ac=finish");
												}
											}
										}
							$isi_2 .="	</div>									
									</td>
								</tr>
							</form>
						</table>
					</td>
				</tr>";
		}
		elseif($_GET['view']=="lost") {
			$title="::$JUDUL | Halaman Hilang Password::";
			$isi_2="<tr>
				<td colspan=\"2\" style=\"padding-top: 10px;\">
					<table cellpadding=\"0\" cellspacing=\"0\" align=\"center\" bgcolor=\"#$TRIP\" width=\"100%\">
						<form action=\"$_SERVER[PHP_SELF]?view=lost\" method=\"POST\">
							<tr bgcolor=\"#$BACK\">
								<td vailgn=\"top\"> 
									<div style=\"background-color: #$TRIP; width:162px; text-align: center; font-family: tahoma; font-size: 13px; font-weight: bold; color: #$TEXT;\">Hilang Password</div>
									<div style=\"border: 1px solid #$TRIP; padding: 10px 10px 10px 10px;\">
										<div style=\"padding: 10px 10px 10px 10px;\">
											<div style=\"background: #$TRIP; color: #$TEXT; text-align: center; width: 100px;\">Form</div>
											<div style=\"border: 1px solid #$TRIP; padding: 10px 10px 10px 10px; width: 425px;\">
												<table cellpadding=\"2\" cellspacing=\"0\" width=\"100%\" align=\"center\" valign=\"top\" border=\"0\">";
													if($_POST['submit']) {
														if($_POST['email'] == "" || !isEmail($_POST['email'])) {
															$mark1="#$TRIP";
														}
														else {
															$mark1="white";
															$aksi1=true;
														}
													}
													else {
														$mark1="white";														
													}
										$isi_2 .="	<tr>
														<td valign=\"top\">E-mail</td>
														<td valign=\"top\">:</td>
														<td valign=\"top\"><input type=\"text\" name=\"email\" size=\"30\" value=\"$_POST[email]\" style=\"background-color: $mark1;\"></td>
														</tr>
													<tr>
														<td valign=\"top\" style=\"padding-top: 20px;\">Pertanyaan</td>
														<td valign=\"top\" style=\"padding-top: 20px;\">:</td>
														<td valign=\"top\" style=\"padding-top: 20px;\">";
													
													if($_POST['submit']) {
														opendb();
														$sql_tanya="SELECT * FROM pertanyaan WHERE idPertanyaan='$_POST[idTanya]'";
														$query_tanya=mysql_query($sql_tanya,opendb())or die(mysql_error());
														if($query_tanya != null) {
																$isi_2 .="<select name=\"idTanya\">";
															while($row_tanya=mysql_fetch_array($query_tanya)) {
																$isi_2 .= "	<option value=\"$row_tanya[idPertanyaan]\">$row_tanya[namaPertanyaan]</option>";																					
															}
																$sql_po="SELECT * FROM pertanyaan WHERE idPertanyaan !='$_POST[idTanya]'";
																$query_po=mysql_query($sql_po,opendb())or die(mysql_error());
																if($query_po != null) {
																	while($row_po=mysql_fetch_array($query_po)) {
																		$isi_2 .= "	<option value=\"$row_po[idPertanyaan]\">$row_po[namaPertanyaan]</option>";
																	}
																}
																$isi_2 .="</select>";
														}
													}
													else {
														opendb();
														$sql_tanya="SELECT * FROM pertanyaan";
														$query_tanya=mysql_query($sql_tanya,opendb())or die(mysql_error());
														if($query_tanya != null) {
																$isi_2 .="<select name=\"idTanya\">";
															while($row_tanya=mysql_fetch_array($query_tanya)) {
																$isi_2 .= "	<option value=\"$row_tanya[idPertanyaan]\">$row_tanya[namaPertanyaan]</option>";																					
															}
																$isi_2 .="</select>";
														}
													}													
										$isi_2 .= "			</td>
														</tr>";
													
													if($_POST['submit']) {
														if($_POST['jawaban'] == "") {
															$mark2="#$TRIP";
														}
														else {
															$mark2="white";
															$aksi2=true;
														}
													}
													else {
														$mark2="white";
													}
										$isi_2 .="	<tr>
														<td valign=\"top\">Jawaban</td>
														<td valign=\"top\">:</td>
														<td valign=\"top\"><input type=\"text\" name=\"jawaban\" size=\"30\" value=\"$_POST[jawaban]\" style=\"background-color: $mark2;\"></td>
														</tr>														
													</table>
												</div>";																							
												if($aksi1 && $aksi2) {
													$isi_2.="<div style=\"border: 1px solid #$TRIP; padding: 10px 10px 10px 10px; width: 425px;\">";
													$sql_verify="	SELECT U.usernameAsal, U.passwordAsal 
																	FROM pelanggan P, username U 
																	WHERE P.idUser=U.idUser 
																	AND U.idPertanyaan='$_POST[idTanya]' 
																	AND U.jawaban='$_POST[jawaban]'";
													$query_verify=mysql_query($sql_verify,opendb())or die(mysql_error());
													if($query_verify != null) {
														if(mysql_num_rows($query_verify)>0) {
															$row_verify=mysql_fetch_array($query_verify);
															$isi_2.="	<div align=\"center\">username(<i>$row_verify[usernameAsal]</i>)</div>
																		<div align=\"center\">password(<i>$row_verify[passwordAsal]</i>)</div>";
														}
														else {
															$isi_2.="<div align=\"center\"><i>Maaf, data tidak ditemukan.</i></div>";
														}
													}
													$isi_2.="	</div>";
												}								
									$isi_2.="	<div style=\"padding-top: 10px;\"></div>
											<div style=\"text-align: center;\"><a href=\"action.php?view=lost\"><input type=\"reset\" value=\"Reset\" class=\"ctombol\"></a> <input type=\"submit\" name=\"submit\" value=\"Verify\" class=\"ctombol\"></div>
											</div>
										</div>
									</td>
								</tr>
							</form>
						</table>
					</td>
				</tr>";
		}
		else {
			header("Location: index1.php");
		}
	}
	else {
		header("Location: index1.php");
	}
	
	$daftar = new Pelanggan();
	$daftar->setTitle($title);
	$daftar->setIsi_2($isi_2);
	$daftar->getTampilkan();
?>