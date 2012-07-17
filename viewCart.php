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
				if(isset($_POST['update']) && $_POST['update']=="Update") {
					if(isset($_POST['id']) && isset($_POST['qty'])) {						
						$id=$_POST['id'];
						$qty=$_POST['qty'];
						$jmlh=sizeof($qty);
						$i=0;
						while($i<$jmlh) {
							$id_ok=$id[$i];
							$qty_ok=$qty[$i];
							$sql_upd="UPDATE cart SET qty='$qty_ok' WHERE idCart='$id_ok' AND ct_token='$token'";
							sqlCart($sql_upd);
							$i++;
						}
					}
				}
				if(isset($_POST['delete']) && $_POST['delete']=="Delete") {
					if(isset($_POST['idCart'])) {
						$idCart=$_POST['idCart'];
						$jmlh=sizeof($idCart);
						$i=0;
						while($i<$jmlh) {
							$id=$idCart[$i];
							$sql_del="DELETE FROM cart WHERE idCart='$id'";
							sqlCart($sql_del);
							$i++;
						}
					}
				}
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
				$title="::$JUDUL| Kantong Belanja::";
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
											<div style=\"background-color: #$TRIP; width:162px; text-align: center;  font-family: tahoma; font-size: 13px; font-weight: bold; color: #$TEXT;\">Kantong Belanja</div>
											<div style=\"border: 1px solid #$TRIP; padding: 10px 10px 10px 10px;\">";
												opendb();
												$sql_kos="SELECT * FROM cart WHERE ct_token='$token'";
												$query_kos=mysql_query($sql_kos,opendb())or die(mysql_error());
												$jmlh_kos=mysql_num_rows($query_kos);
												if($jmlh_kos <=0 ) {
													$isi_2 .= "	<div style=\"padding-bottom: 10px;\">Kantong Belanja : 0 item</div>
																<div style=\"background: #ffffff;width: 100px; padding: 3px 3px 3px 3px;\"><a href=\"index2.php?token=$token\"><div style=\"color: #$TRIP;\">Lanjutkan Belanja</div></a></div>";
												}
												else {											
													$isi_2 .="<form action=\"$_SERVER[PHP_SELF]?token=$token\" method=\"POST\">
															<table cellpadding=\"2\" cellspacing=\"0\" align=\"center\" bgcolor=\"#364b1a\" width=\"100%\">
																<tr>
																	<td class=\"cart\" width=\"30\" style=\"color: #ffffff;\"><b>No</b>
																		</td>
																	<td class=\"cart\" width=\"170\" style=\"color: #ffffff;\"><b>Produk</b>
																		</td>
																	<td class=\"cart\" width=\"100\" style=\"color: #ffffff;\"><b>Harga</b>
																		</td>
																	<td class=\"cart\" style=\"color: #ffffff;\"><b>Qty</b>
																		</td>
																	<td class=\"cart\" width=\"100\" style=\"color: #ffffff;\"><b>Total</b>
																		</td>
																	<td class=\"cart\" style=\"color: #ffffff;\"><b>Del</b>
																		</td>
																	</tr>";
																										
													$sql_isiCart="	SELECT C.idCart, C.qty, P.namaProduk, P.hargaProduk 
																	FROM cart C, produk P 
																	WHERE C.idProduk=P.idProduk 
																	AND C.ct_token='$token'";
													$query_isiCart=mysql_query($sql_isiCart,opendb())or die(mysql_error());													
													$i=1;
													$j=0;
													while($row_isiCart=mysql_fetch_array($query_isiCart)) {
														$total = $row_isiCart['hargaProduk']*$row_isiCart['qty'];
														$bayar += ($row_isiCart['hargaProduk']*$row_isiCart['qty']);
														if($j==0) {
															$bg="#b08903";
															$j++;
														}
														else {
															$bg="#b29739";
															$j--;
														}
														$isi_2 .="<tr bgcolor=\"$bg\">
																		<td class=\"isicart\" width=\"30\" style=\"color: #000000;\">$i</td>
																		<td class=\"isicart\" width=\"150\" style=\"color: #000000;\">$row_isiCart[namaProduk]</td>
																		<td class=\"isicart\" width=\"100\" style=\"color: #000000;\">$row_isiCart[hargaProduk]</td>
																		<td class=\"isicart\"><input type=\"text\" name=\"qty[]\" size=\"1\" maxlength=\"5\" value=\"$row_isiCart[qty]\"></td>
																		<td class=\"isicart\" width=\"100\" style=\"color: #000000;\">$total</td>
																		<td class=\"isicart\"><input type=\"checkbox\" name=\"idCart[]\" value=\"$row_isiCart[idCart]\">
																			<input type=\"hidden\" name=\"id[]\" value=\"$row_isiCart[idCart]\">
																			</td>																		
																		</tr>";
														$i++;
													}	
													$isi_2 .="	<tr bgcolor=\"#364b1a\">
																	<td colspan=\"2\" class=\"cart\" style=\"text-align: right; vertical-align: middle;\">
																		<input type=\"submit\" name=\"delete\" value=\"Delete\" class=\"ctombol\">
																		<input type=\"submit\" name=\"update\" value=\"Update\" class=\"ctombol\">&nbsp;
																		</td>
																	<td class=\"cart\" colspan=\"2\" style=\"text-align: right; vertical-align: middle; color: #ffffff;\">
																		Jumlah Bayar :<br>
																		Ongkos Kirim :
																		</td>
																	<td class=\"cart\" width=\"100\" colspan=\"2\" valign=\"middle\" style=\"vertical-align: middle; color: #ffffff;\">
																		Rp. $bayar,-<br>
																		Not Set
																		</td>
																	</tr>
															</table>															
														<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" align=\"center\" style=\"padding-top: 20px;\">
															<tr>
																<td align=\"right\" style=\"padding-right: 5px;\" width=\"50%\">
																	<div style=\"background: #c0c0c0; width: 100px; padding: 3px 3px 3px 3px;\">
																		<a href=\"index2.php?token=$token\" style=\"text-decoration: none;\">
																			<div style=\"color: #364b1a; text-align: center;\">Lanjutkan Belanja</div>
																			</a>
																		</div>
																	</td>
																<td align=\"left\" style=\"padding-left: 5px;\">																	
																	<div style=\"background: #c0c0c0; width: 100px; padding: 3px 3px 3px 3px;\">
																		<a href=\"checkout.php?token=$token\" style=\"text-decoration: none;\">
																			<div style=\"color: #364b1a; text-align: center;\">Check Out</div>
																			</a>
																		</div>
																	</td>
																</tr>
															</table>
														</form>";
												}
											$isi_2 .="	</div>													
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