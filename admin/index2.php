<?php
	header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
	header('Cache-Control: no-store, no-cache, must-revalidate');
	header('Cache-Control: post-check=0, pre-check=0, false');
	
	session_start();
	include_once "./library/kelasAdmin.php";
	include_once "./include/functions.php";
	include_once "cekLogin.php";
	if(isset($_SESSION['ASTA_ADM_HASH']) && $_GET['token']==$_SESSION['ASTA_ADM_HASH']) {
		if(!authAdmin($_SESSION['ASTA_ADM_USERNAME'], $_SESSION['ASTA_ADM_PASSWORD'])) {
			unset($_POST['uname']);
			unset($_POST['cpass']);
			unset($_POST['enctoken']);
			unset($_POST['cmd_submit']);
			unset($_SESSION['ASTA_ADM_USERNAME']);
			unset($_SESSION['ASTA_ADM_PASSWORD']);
			unset($_SESSION['ASTA_ADM_HASH']);
			unset($_SESSION['ASTA_ADM_TIMESTAMP']);
			unset($_SESSION['ASTA_ADM_TOKEN']);
			session_destroy();
			header("Location: index.php?naughty");
		}			
		else { 
			$token="?token=".$_SESSION['ASTA_ADM_HASH'];
			$arrayMenu=array("index.php$token"=>'Home',"produk.php$token"=>'Produk',"pemesanan.php$token"=>'Pemesanan',"konfirmasi.php$token"=>'Konfirmasi',"Pelanggan.php$token"=>'Pelanggan',"kategori.php$token"=>'Kategori');
			$isiLink="<tr><td><a href=\"index2.php?act=logout&token=$_SESSION[ASTA_ADM_HASH]\" class=\"menuItem\" alt=\"Logout\" title=\"Logout\"><div class=\"break\">Logout</div></a></td></tr>
					<tr><td align=\"center\" valign=\"top\">
				<div class=\"bank\">Orther Menu</div>";
				$isiLink.="<div style=\"border: 1px solid #364b1a; width: 211px; height: 100px;\">";
				$isiLink.=otherMenu();
				$isiLink.="</div><div style=\"padding-bottom: 10px;\"></div>
				<div class=\"bank\">Order</div>
				<div style=\"border: 1px solid #364b1a; width: 211px; \">";
					opendb();
					$isiLink.=traPending();
					$isiLink.=traBaru();
					$isiLink.=traKirim();
					$isiLink.=traBayar();
					$isiLink.="</div><div style=\"padding-bottom: 10px;\"></div>
					<div class=\"bank\">Konfirmasi</div>";
					$isiLink.=jumKonf();
					closedb();
				$isiLink.="<div style=\"border: 1px solid #364b1a; width: 211px; height: 100px;\">
					</div>
				</td></tr>";
			$konten="<tr><td colpsan=\"2\">
					<center>
						<table>
							<tr>
								<td>
									Please click menu beside to manage this system
								</td>
							</tr>
						</table>
					</center>
					</td>
				</tr>";
			$title=":: $JUDUL | Halaman Admin ::";		
			
			$index2=new Admin();
			$index2->setTitle($title);
			$index2->setIsi($konten);
			$index2->setArrayMenu($arrayMenu);
			$index2->setLinkLogout($isiLink);
			$index2->getTampilkan();
			if($_GET['token']!=$_SESSION['ASTA_ADM_HASH']) {
				header("Location: index.php?error_sess");
			}
		} 
	}
	else {
		header("Location: index.php?nosess");
	}
?>