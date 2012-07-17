<?php
	header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
	header('Cache-Control: no-store, no-cache, must-revalidate');
	header('Cache-Control: post-check=0, pre-check=0, false');
	
	session_start();
	
	include_once "./include/functions.php";
	include_once "./library/kelasAdmin.php";
	include_once "./include/functions-product.php";
	if(authAdmin($_SESSION['ASTA_ADM_USERNAME'], $_SESSION['ASTA_ADM_PASSWORD'])) {
		header("Location: index2.php?token=$_SESSION[ASTA_ADM_HASH]");
	}
	else {		
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
		$tokenCek=createRandomtoken(); 
		$enctoken=Encrypt($tokenCek); 
		$_SESSION['ASTA_ADM_TOKEN']=(string)$enctoken;
		
		$title=":: $JUDUL | $RINCIAN ::";
		$arrayMenu=array("about.php$token"=>'Tentang Kami',"pemesanan.php$token"=>'Pemesanan',"viewCart.php$token"=>'Kantong Belanja',"katalog.php$token"=>'Katalog',"konfirm.php$token"=>'Konfirmasi');
		$isiWarning="<tr><td colspan=2><div align=center style=\"padding-top: 10px;\"><font color=orange>$pesan</font></div></td></tr>";
		$konten="<tr>
					<td colspan=\"2\" width=\"100%\">						
						<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" align=\"center\" border=\"0\" style=\"padding: 20px 0 50px 0;\">
							<tr>
								<td align=\"center\">
									<form action=\"index2.php?act=login\" name=\"login\" method=\"POST\">
										<table>
											<tr>
												<td colspan=\"3\" align='center'>L O G I N</td>
											</tr>
											<tr>
												<td valign=\"top\">Username</td>
												<td valign=\"top\">:</td>
												<td valign=\"top\"><input type=\"text\" name=\"uname\" size=\"20\" class=\"ctext\"></td>
											</tr>
											<tr>
												<td valign=\"top\">Password</td>
												<td valign=\"top\">:</td>
												<td valign=\"top\"><input type=\"password\" name=\"cpass\" size=\"20\" class=\"ctext\"></td>
											</tr>
											<tr>
												<td valign=\"top\" colspan=\"3\"  align='center'>
												<input type=\"hidden\" name=\"enctoken\" value=\"$enctoken\">
												<input type=\"submit\" name=\"cmd_submit\" value=\"Login\" class=\"ctombol\">
												<input type=\"reset\" value=\"Batal\" class=\"ctombol\">
												</td>
											</tr>
										</table>
									</form>
									</td>
								</tr>
							</table>
						</td>
					</tr>";
	}

	$admin=new Admin();
	$admin->setWarning($isiWarning);
	$admin->setTitle($title);
	$admin->setIsi($konten);
	$admin->getTampilkan();
?>