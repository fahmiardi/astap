<?php
	header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
	header('Cache-Control: no-store, no-cache, must-revalidate');
	header('Cache-Control: post-check=0, pre-check=0, false');
	
	session_start();
	include_once "./library/kelasPelanggan.php";
	include_once "./include/functions.php";
	include_once "./include/functions-cart.php";
	
	if(isset($_SESSION['ASTA_HASH'])) {
		if($_SESSION['ASTA_HASH'] == $_GET['token']) {
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
				$token=$_SESSION['ASTA_HASH'];				
				//generate ulang ID Session
				session_id();
				if(!empty($_SESSION)) {
					session_regenerate_id(true);
				}
				//untuk expired timed 
				$refresh_time=10; //dalam menit 
				$chour = date('H'); //jam 
				$cmin = date('i'); //menit
				$csec = date('s'); //detik 
				$cmon = date('m'); //bulan 
				$cday = date('d'); //tanggal 
				$cyear = date('Y'); //tahun 
				$ctimestamp = mktime($chour,$cmin,$csec,$cmon,$cday,$cyear); 
				$ttimestamp=$_SESSION['ASTA_TIMESTAMP']; 
				if ($ttimestamp < $ctimestamp) { 
					emptyCart($_SESSION['ASTA_HASH']);
					unset($_POST['uname']);
					unset($_POST['cpass']);
					unset($_POST['enctoken']);
					unset($_POST['cmd_submit']);
					unset($_SESSION['ASTA_USERNAME']);
					unset($_SESSION['ASTA_PASSWORD']);
					unset($_SESSION['ASTA_HASH']);
					unset($_SESSION['ASTA_TIMESTAMP']);
					unset($_SESSION['ASTA_TOKEN']);
					session_destroy(); 					
					header('Location: index1.php?timeout'); 
				} 
				$ttimestamp = mktime($chour,$cmin+$refresh_time,$csec,$cmon,$cday,$cyear); 
				$_SESSION['ASTA_TIMESTAMP']=$ttimestamp;
				
				//content
				$title="::$JUDUL| My Account::";
				if(isset($_SESSION['ASTA_HASH'])) {
					$sql_user="	SELECT usernameAsal 
								FROM username 
								WHERE username='$_SESSION[ASTA_USERNAME]'";
					$query_user=mysql_query($sql_user,opendb())or die(mysql_error());
					if($query_user != null) {
						if(mysql_num_rows($query_user)==1) {
							$row_user=mysql_fetch_array($query_user);
							$user=$row_user['usernameAsal'];
						}
					}
				}
				else {
					$user="Guest";
				}
				$isiLink="	<tr><td><a href=\"index2.php?act=logout&token=$_SESSION[ASTA_HASH]\" class=\"menuItem\" alt=\"Logout\" title=\"Logout\"><div class=\"break\">Logout</div></a></td></tr>
							<tr><td><div style=\"padding: 10px 0px 10px 0px; text-align: center;\">Selamat Datang <b>".$user."</b></div></td></tr>";
				$token="?token=".$_SESSION['ASTA_HASH'];
				$arrayMenu=array("pemesanan.php$token"=>'Pemesanan',"viewCart.php$token"=>'Kantong Belanja',"katalog.php$token"=>'Katalog',"konfirm.php$token"=>'Konfirmasi',"myAccount.php$token"=>'My Account');
				opendb();
				$sql_item="SELECT idCart FROM cart WHERE ct_token='$_SESSION[ASTA_HASH]'";
				$query_item=mysql_query($sql_item) or die(mysql_error());
				if($query_item != null) {
					$jmlh_item=mysql_num_rows($query_item);
					if($jmlh_item==0) {
						$item="$jmlh_item Item";
					}
					elseif($jmlh_item==1) {
						$item="$jmlh_item Item <br>CHECKOUT";
					}
					else {
						$item="$jmlh_item Items <br>CHECKOUT";
					}
				}
				$menuAtas=array("index1.php$token"=>'Home',"informasi.php$token&opt=contact"=>'Contact',"viewCart.php$token"=>$item);
				
				$token=$_GET['token'];
				$isi_2="<tr>
							<td colspan=\"2\" valign=\"top\" style=\"padding-top: 10px;\">
								<table cellpadding=\"0\" cellspacing=\"0\" align=\"center\" bgcolor=\"#$TRIP\" width=\"100%\">
									<tr bgcolor=\"#$BACK\">
										<td vailgn=\"top\"> 
											<div style=\"background-color: #$TRIP; width:162px; text-align: center;  font-family: tahoma; font-size: 13px; font-weight: bold; color: #$TEXT;\">My Account</div>
											<div style=\"border: 1px solid #$TRIP; padding: 10px 10px 10px 10px;\">
												<form action=\"myAccount.php?token=$_SESSION[ASTA_HASH]\" method=\"post\">";
												if(isset($_POST['submit'])) {
													if($_POST['submit']=="Edit") {
														$sql_edit="	SELECT 	P.idUser, P.idPelanggan, P.namaPelanggan, P.alamatPelanggan, P.kota, P.propinsi, P.kodePos, P.email, P.phone, 
																			U.usernameAsal, U.passwordAsal, U.jawaban, 
																			T.idPertanyaan 
																	FROM pelanggan P, username U, pertanyaan T 
																	WHERE P.idUser=U.idUser 
																	AND U.idPertanyaan=T.idPertanyaan 
																	AND P.idPelanggan='$_POST[idPelanggan]'";
														$query_edit=mysql_query($sql_edit,opendb())or die(mysql_error());
														if($query_edit != null) {
															if(mysql_num_rows($query_edit)==1) {
																$row_acc=mysql_fetch_array($query_edit);
																$isi_2.="	<table width=\"100%\" align=\"center\">
																				<tr>
																					<td class=\"cart\" width=\"21%\">Nama</td>
																					<td class=\"cart\" width=\"2%\">:</td>
																					<td class=\"cart\"><input type=\"text\" name=\"namaPelanggan\" value=\"$row_acc[namaPelanggan]\" size=\"20\"></td>
																					</tr>
																				<tr>
																					<td>Alamat</td>
																					<td>:</td>
																					<td><textarea style=\"font-family: tahoma; font-weight: bold; font-size: 10px;\" name=\"alamatPelanggan\" rows=\"7\" cols=\"40\" wrap>$row_acc[alamatPelanggan]</textarea></td>
																					</tr>
																				<tr>
																					<td>Kota</td>
																					<td>:</td>
																					<td><input type=\"text\" name=\"kota\" value=\"$row_acc[kota]\" size=\"20\"></td>
																					</tr>
																				<tr>
																					<td>Propinsi</td>
																					<td>:</td>
																					<td><input type=\"text\" name=\"propinsi\" value=\"$row_acc[propinsi]\" size=\"20\"></td>
																					</tr>
																				<tr>
																					<td>Kode Pos</td>
																					<td>:</td>
																					<td><input type=\"text\" name=\"kodePos\" value=\"$row_acc[kodePos]\" size=\"20\"></td>
																					</tr>
																				<tr>
																					<td>Email</td>
																					<td>:</td>
																					<td><input type=\"text\" name=\"email\" value=\"$row_acc[email]\" size=\"20\"></td>
																					</tr>
																				<tr>
																					<td>Contact</td>
																					<td>:</td>
																					<td><input type=\"text\" name=\"phone\" value=\"$row_acc[phone]\" size=\"20\"></td>
																					</tr>
																				<tr>
																					<td style=\"padding-top: 10px;\">Username</td>
																					<td style=\"padding-top: 10px;\">:</td>
																					<td style=\"padding-top: 10px;\"><input type=\"text\" name=\"usernameAsal\" value=\"$row_acc[usernameAsal]\" size=\"20\"></td>
																					</tr>
																				<tr>
																					<td>Password</td>
																					<td>:</td>
																					<td><input type=\"password\" name=\"passwordAsal\" value=\"$row_acc[passwordAsal]\" size=\"20\"></td>
																					</tr>
																				<tr>
																					<td>Pertanyaan</td>
																					<td>:</td>
																					<td>
																						<select name=\"idPertanyaan\">";
																						$sql_tanya="SELECT * FROM pertanyaan";
																						$query_tanya=mysql_query($sql_tanya,opendb())or die(mysql_error());
																						if($query_tanya != null) {
																							if(mysql_num_rows($query_tanya)>0) {
																								while($row_tanya=mysql_fetch_array($query_tanya)) {
																									if($row_tanya['idPertanyaan']==$row_acc['idPertanyaan']) {
																										$isi_2.="<option value=\"$row_tanya[idPertanyaan]\" selected>$row_tanya[namaPertanyaan]</option>";																										
																									}
																									else {
																										$isi_2.="<option value=\"$row_tanya[idPertanyaan]\">$row_tanya[namaPertanyaan]</option>";
																									}
																								}
																							}
																						}
																			$isi_2.="	</select>
																						</td>
																					</tr>
																				<tr>
																					<td>Jawaban</td>
																					<td>:</td>
																					<td><input type=\"text\" name=\"jawaban\" value=\"$row_acc[jawaban]\" size=\"20\"></td>
																					</tr>
																				<tr>
																					<td colspan=\"3\" class=\"cart\" style=\"padding-top: 10px;\">
																						<input type=\"submit\" name=\"submit\" value=\"Update\" class=\"ctombol\">
																						<input type=\"hidden\" name=\"idPelanggan\" value=\"$row_acc[idPelanggan]\">
																						<input type=\"hidden\" name=\"idUser\" value=\"$row_acc[idUser]\">
																						</td>
																					</tr>
																				</table>";														
															}
														}
													}
													elseif($_POST['submit']=="Update") {
														$idPelanggan=(int)filter($_POST['idPelanggan']);
														$idUser=(int)filter($_POST['idUser']);
														$namaPelanggan=filter($_POST['namaPelanggan']);
														$alamatPelanggan=filter($_POST['alamatPelanggan']);
														$kota=filter($_POST['kota']);
														$propinsi=filter($_POST['propinsi']);
														$kodePos=filter($_POST['kodePos']);
														$email=filter($_POST['email']);
														$phone=filter($_POST['phone']);
														$usernameAsal=filter($_POST['usernameAsal']);
														$passwordAsal=filter($_POST['passwordAsal']);
														$username=Encrypt($usernameAsal);														
														$password=Encrypt($passwordAsal);
														$idPertanyaan=filter($_POST['idPertanyaan']);
														$jawaban=filter($_POST['jawaban']);
														$auth=false;
														if($namaPelanggan!="" && $alamatPelanggan!="" && $kota!="" && $propinsi!="" && $kodePos!="" 
															&& $email!="" && $phone!="" && $usernameAsal!="" && $passwordAsal!="" 
															&& $jawaban!="") {															
															if(is_Numeric($kodePos)) {
																$auth=true;
															}
															else {
																header("Location: myAccount.php?token=$_SESSION[ASTA_HASH]&error=pos");
															}
															if(isEmail($email)) {
																$auth=true;	
															}
															else {
																header("Location: myAccount.php?token=$_SESSION[ASTA_HASH]&error=email");																															
															}
															if(is_Numeric($phone)) {
																$auth=true;
															}
															else {
																header("Location: myAccount.php?token=$_SESSION[ASTA_HASH]&error=phone");
															}
															if($usernameAsal != $row_acc['usernameAsal']) {
																$sql_un="SELECT usernameAsal FROM username WHERE usernameAsal != '$usernameAsal'";
																$query_un=mysql_query($sql_un,opendb())or die(mysql_error());
																if($query_un != null) {
																	if(mysql_num_rows($query_un)>0) {
																		while($row_un=mysql_fetch_array($query_un)) {
																			if($usernameAsal==$row_un['usernameAsal']) {
																				$auth=false;																				
																				break;
																				header("Location: myAccount.php?token=$_SESSION[ASTA_HASH]&error=un");
																			}
																			else {
																				$auth=true;
																			}
																		}
																	}
																}
															}
															if($auth) {
																$sql_upd1="	UPDATE pelanggan 
																			SET namaPelanggan='$namaPelanggan', 
																				alamatPelanggan='$alamatPelanggan', 
																				kota='$kota', 
																				propinsi='$propinsi', 
																				kodePos='$kodePos', 
																				email='$email', 
																				phone='$phone' 
																			WHERE idPelanggan='$idPelanggan'";
																$query_upd1=mysql_query($sql_upd1,opendb())or die(mysql_error());
																$sql_upd2="	UPDATE username 
																			SET username='$username', 
																				password='$password', 
																				usernameAsal='$usernameAsal', 
																				passwordAsal='$passwordAsal', 
																				idPertanyaan='$idPertanyaan', 
																				jawaban='$jawaban' 
																			WHERE idUser='$idUser'";
																$query_upd2=mysql_query($sql_upd2,opendb())or die(mysql_error());
																if($query_upd1 && $query_upd2) {
																	header("Location: myAccount.php?token=$_SESSION[ASTA_HASH]&error=sukses");
																}
															}	
														}
														else {
															header("Location: myAccount.php?token=$_SESSION[ASTA_HASH]&error=empty");
														}
													}
													else {
														header("Location: myAccount.php?token=$_SESSION[ASTA_HASH]");
													}
												}
												else {
													if(isset($_GET['error'])) {
														if($_GET['error']=="empty") {
															$war="Form tidak boleh kosong";
														}
														elseif($_GET['error']=="pos") {
															$war="Cek Kode Pos";
														}
														elseif($_GET['error']=="email") {
															$war="Cek Email";
														}
														elseif($_GET['error']=="phone") {
															$war="Cek No. Contact";
														}
														elseif($_GET['error']=="un") {
															$war="Username sudah ada yang pakai";
														}
														elseif($_GET['error']=="sukses") {
															$war="Update berhasil";
														}
														else {
															$war="";
														}
													}
													$sql_acc="	SELECT 	P.idPelanggan, P.namaPelanggan, P.alamatPelanggan, P.kota, P.propinsi, P.kodePos, P.email, P.phone, 
																		U.usernameAsal, U.passwordAsal, U.regDate, U.jawaban, 
																		T.namaPertanyaan 
																FROM pelanggan P, username U, pertanyaan T 
																WHERE P.idUser=U.idUser 
																AND U.idPertanyaan=T.idPertanyaan 
																AND U.username='$_SESSION[ASTA_USERNAME]' 
																AND U.password='$_SESSION[ASTA_PASSWORD]'";
													$query_acc=mysql_query($sql_acc,opendb())or die(mysql_error());
													if($query_acc != null) {
														if(mysql_num_rows($query_acc)==1) {
															$row_acc=mysql_fetch_array($query_acc);
															$isi_2.="	<div align=\"center\"><b>$war</b></div>
																		<table width=\"100%\" align=\"center\">
																			<tr>
																				<td class=\"cart\" width=\"21%\">Nama</td>
																				<td class=\"cart\" width=\"2%\">:</td>
																				<td class=\"cart\">$row_acc[namaPelanggan]</td>
																				</tr>
																			<tr>
																				<td>Alamat</td>
																				<td>:</td>
																				<td>$row_acc[alamatPelanggan]</td>
																				</tr>
																			<tr>
																				<td>Kota</td>
																				<td>:</td>
																				<td>$row_acc[kota]</td>
																				</tr>
																			<tr>
																				<td>Propinsi</td>
																				<td>:</td>
																				<td>$row_acc[propinsi]</td>
																				</tr>
																			<tr>
																				<td>Kode Pos</td>
																				<td>:</td>
																				<td>$row_acc[kodePos]</td>
																				</tr>
																			<tr>
																				<td>Email</td>
																				<td>:</td>
																				<td>$row_acc[email]</td>
																				</tr>
																			<tr>
																				<td>Contact</td>
																				<td>:</td>
																				<td>$row_acc[phone]</td>
																				</tr>
																			<tr>
																				<td style=\"padding-top: 10px;\">Username</td>
																				<td style=\"padding-top: 10px;\">:</td>
																				<td style=\"padding-top: 10px;\"><i>$row_acc[usernameAsal]</i></td>
																				</tr>
																			<tr>
																				<td>Password</td>
																				<td>:</td>
																				<td><i>$row_acc[passwordAsal]</i></td>
																				</tr>
																			<tr>
																				<td>Pertanyaan</td>
																				<td>:</td>
																				<td>$row_acc[namaPertanyaan]</td>
																				</tr>
																			<tr>
																				<td>Jawaban</td>
																				<td>:</td>
																				<td>$row_acc[jawaban]</td>
																				</tr>
																			<tr>
																				<td>Tanggal Registrasi</td>
																				<td>:</td>
																				<td>$row_acc[regDate]</td>
																				</tr>
																			<tr>
																				<td colspan=\"3\" class=\"cart\" style=\"padding-top: 10px;\">
																					<input type=\"submit\" name=\"submit\" value=\"Edit\" class=\"ctombol\">
																					<input type=\"hidden\" name=\"idPelanggan\" value=\"$row_acc[idPelanggan]\">
																					</td>
																				</tr>
																			</table>";
														}
													}
												}
									$isi_2 .="	</form>
												</div>													
											</td>
										</tr>
									</table>
								</td>
							<tr>";
				
				$viewCart = new Pelanggan();
				$viewCart->setTitle($title);
				$viewCart->setLinkLogout($isiLink);
				$viewCart->setMenuAtas($menuAtas);
				$viewCart->setArrayMenu($arrayMenu);
				$viewCart->setIsi_2($isi_2);
				$viewCart->getTampilkan();
			}
		}
		else {
			emptyCart($_SESSION['ASTA_HASH']);
			unset($_GET['token']);
			unset($_SESSION['ASTA_USERNAME']);
			unset($_SESSION['ASTA_PASSWORD']);
			unset($_SESSION['ASTA_HASH']);
			unset($_SESSION['ASTA_TIMESTAMP']);
			unset($_SESSION['ASTA_TOKEN']);
			session_destroy();
			header("Location: index1.php?wrong2");
		}
	}
	else {
		emptyCart($_SESSION['ASTA_HASH']);
		header("Location: index1.php");
	}
?>