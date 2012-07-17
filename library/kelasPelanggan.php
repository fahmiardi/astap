<?php	
	class Pelanggan {
		var $title="::";
		var $slide="";
		var $warning="";
		var $arrayMenu=array("katalog.php"=>'Katalog',"konfirm.php"=>'Konfirmasi');
		var $menuAtas=array("index1.php"=>'Home',"index.php"=>'BackToFront',"viewCart.php"=>'0 Item');
		var $isiLink="";
		var $isi_2="";
		var $isi_3="";
		var $isiMarquee="";
		
		//Methods		
		function setTitle($title) {
			$this->title=$title;
		}
		
		function getTitle() {
			echo $this->title;
		}
		
		function setWarning($warning) {
			$this->warning=$warning;
		}
		
		function BrowserDetector() {
			$bd['UA']=getenv(HTTP_USER_AGENT);
			$preparens="";
			$parens="";
			$i=strpos($bd['UA'],"(");
			if($i>=0) {
				$preparens=trim(substr($bd['UA'],0,$i));
				$parens=substr($bd['UA'],$i+1, strlen($bd['UA']));
				$j=strpos($parens,")");
				if($j>=0) {
					$parens=substr($parens,0,$j);
				}
			}
			else {
				$preparens=$bd['UA'];
			}
			
			$browVer=$preparens;
			$token=trim(strtok($parens,";"));
			while($token) {
				if($token=="compatible") {
				}
				else if (preg_match("/MSIE/i","$token")) {
					$browVer=$token;
				}
				else if (preg_match("/Opera/i","$token")) {
					$browVer=$token;
				}
				else if (preg_match("/X11/i","$token") || preg_match("/Linux/i","$token")) {
					$bd['PLATFORM']="Unix";
				}
				else if (preg_match("/Win/i","$token")) {
					$bd['PLATFORM']=$token;
				}
				else if (preg_match("/Mac/i","$token") || preg_match("/PPC/i","$token")) {
					$bd['PLATFORM']=$token;
				}
				$token=strtok(";");
			}
			$msieIndex=strpos($browVer,"MSIE");
			if($msieIndex>=0) {
				$browVer=substr($browVer,$msieIndex,strlen($browVer));
			}
			$leftover="";
			if(substr($browVer,0,strlen("Mozilla"))=="Mozilla") {
				$bd['BROWSER']="Mozilla";
				$leftover=substr($browVer,strlen("Mozilla")+1,strlen($browVer));
			}
			else if(substr($browVer,0,strlen("Lynx"))=="Lynx") {
				$bd['BROWSER']="Lynx";
				$leftover=substr($browVer,strlen("Lynx")+1,strlen($browVer));
			}
			else if(substr($browVer,0,strlen("MSIE"))=="MSIE") {
				$bd['BROWSER']="Internet Explorer";
				$leftover=substr($browVer,strlen("MSIE")+1,strlen($browVer));
			}
			else if(substr($browVer,0,strlen("Microsoft Internet Explorer"))=="Microsoft Internet Explorer") {
				$bd['BROWSER']="Internet Explorer";
				$leftover=substr($browVer,strlen("Microsoft Internet Explorer")+1,strlen($browVer));
			}
			else if(substr($browVer,0,strlen("Opera"))=="Opera") {
				$bd['BROWSER']="Opera";
				$leftover=substr($browVer,strlen("Opera")+1,strlen($browVer));
			}
			$leftover=trim($leftover);
			$i=strpos($leftover," ");
			if($i>0) {
				$bd['VERSION']=substr($leftover,0,$i);
			}
			else {
				$bd['VERSION']=$leftover;
			}
			return($bd);
		}
		
		function getIsi4() {
			//Untuk Tema
			$sql_tema="SELECT * FROM tema";
			$query_tema=mysql_query($sql_tema,opendb())or die(mysql_error());
			if($query_tema != null) {
				if(mysql_num_rows($query_tema)==1) {
					$row_tema=mysql_fetch_array($query_tema);
					$BODY=$row_tema['bodyTema'];
					$BACK=$row_tema['backTema'];
					$TRIP=$row_tema['tripTema'];
					$TEXT=$row_tema['tripTextTema'];
					$BANER=$row_tema['banerTema'];
					$BANERTRIP=$row_tema['banerTripTema'];
					$JUDUL=$row_tema['title'];
					$RINCIAN=$ROW_tema['rincian'];
					$DOMAIN=$row_tema['domain'];
				}
			}
				$isi="<tr><td colspan=\"2\">
						<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\">
							<tr><td>
								<table cellpadding=\"1\" cellspacing=\"1\" width=\"242\">
									<tr><td>";
										$bd=$this->BrowserDetector();
										$ip = getenv("REMOTE_ADDR");
										$isi .= "<table border='0' cellpadding='0' cellspacing='0' align='center' width='100%'>";
										$isi .= "	<tr>
													<td class='info'>IP</td>
													<td class='info'>:&nbsp;</td>
													<td class='info'>$ip</td>
												</tr>
												<tr>
													<td class='info'>Browser</td>
													<td class='info'> : </td>
													<td class='info'>$bd[BROWSER]</td>
												</tr>
												<tr>
													<td class='info'>Versi</td>
													<td class='info'> : </td>
													<td class='info'>$bd[VERSION]</td>
												</tr>
												<tr>
													<td class='info'>Sistem Operasi&nbsp;</td>
													<td class='info'> : </td>
													<td class='info'>$bd[PLATFORM]</td>
												</tr>
												
											  </table>";
						$isi .="		</td></tr>
								</table>
							</td><td>
								<table bgcolor=\"#$TRIP\" cellpadding=\"0\" cellspacing=\"0\" width=\"246\" style=\"font: normal 11px tahoma, arial;\">
									<tr><td style=\"padding: 10px; color:#$TEXT;\"><b>Our Networks</b></td><td></td></tr>
									<tr style=\"background: #$BACK;\"><td>
										<table cellpadding=\"1\" cellspacing=\"1\" width=\"100%\" bgcolor=\"#$TRIP\">
											<tr bgcolor=\"#$BACK\"><td><div id=\"coolmenu\">
											<ul style=\"left: 0px; margin-top: 10px;\">";
											$sql_net="SELECT * FROM network WHERE idStatusShow='1'";
											$query_net=mysql_query($sql_net,opendb())or die(mysql_error());
											if($query_net != null) {
												if(mysql_num_rows($query_net)>0) {
													while($row_net=mysql_fetch_array($query_net)) {
													$isi .="<li><div><a href=\"$row_net[linkNetwork]\" 
																	onMouseover=\"showtext('"."$row_net[keteranganNetwork]"."')\" 
																	onMouseout=\"hidetext()\">$row_net[namaNetwork]</a></div></li>";
													}
												}
											}										
									$isi .="</ul></div><div id=\"tabledescription\"></div>									
											</td></tr>
										</table>
									</td>
									<td></td></tr>
								</table>
								</td></tr>
						</table>
						</td>
						</tr>";
					return $isi;
		}
		
		function getWarning() {
			echo $this->warning;
		}
		
		function setSlide($slide) {
			$this->slide=$slide;
		}
		
		function getSlide() {
			echo $this->slide;
		}
		
		function setLinkLogout($link) {
			$this->isiLink=$link;
		}
		
		function getLinkLogout() {
			echo $this->isiLink;
		}
		
		function getIsi() {
			echo $this->getIsi_1();
			echo $this->getWarning();
			echo $this->isi_2;
			echo $this->isi_3;
			echo $this->getIsi4();
		}
	
		function getIsi_1() { 			
			?>
			<tr><td>
					<table cellpadding="0" cellspacing="0" width="100%" class="moduleItem">
						<tr><td>
							<table cellpadding="0" cellspacing="0" width="162">
								<?php							
									$arrayMenu=$this->getArrayMenu();
									foreach($arrayMenu as $link => $nama) { ?>
										<tr><td><a href="<?php echo $link; ?>" class="menuItem" alt="<?php echo $nama; ?>" title="<?php echo $nama; ?>"><div class="break"><?php echo $nama; ?></div></a></td></tr>
									<?	}	?>																
								<?php $this->getLinkLogout(); ?>
								<?php $this->getMarquee(); ?>
							</table>
						</td></tr>
					</table>
					</td>
				<?php $this->getSlide(); ?>
				</tr>
<?php	}
		
		function setMarquee($marq) {
			$this->isiMarquee=$marq;
		}
		
		function getMarquee() {
			echo $this->isiMarquee;
		}
		
		function setArrayMenu($array) {
			$this->arrayMenu=$array;
		}
		
		function getArrayMenu() {
			return $this->arrayMenu;
		}
		
		function setMenuAtas($atas) {
			$this->menuAtas=$atas;
		}
		
		function getMenuAtas() {
			return $this->menuAtas;
		}
		
		function setIsi_2($isi_2) {
			$this->isi_2=$isi_2;
		}
		
		function getIsi_2() {
			echo $this->isi_2;
		}
		
		function setIsi_3($isi_3) {
			$this->isi_3=$isi_3;
		}
		
		function getIsi_3() {
			echo $this->isi_3;
		}
		
		function setIsi_4($isi_4) {
			$this->isi_4=$isi_4;
		}
		
		function getIsi_4() {
			echo $this->isi_4;
		}
		
		function getHeader() { 
			//Untuk Tema
			$sql_tema="SELECT * FROM tema";
			$query_tema=mysql_query($sql_tema,opendb())or die(mysql_error());
			if($query_tema != null) {
				if(mysql_num_rows($query_tema)==1) {
					$row_tema=mysql_fetch_array($query_tema);
					$BODY=$row_tema['bodyTema'];
					$BACK=$row_tema['backTema'];
					$TRIP=$row_tema['tripTema'];
					$TEXT=$row_tema['tripTextTema'];
					$BANER=$row_tema['banerTema'];
					$BANERTRIP=$row_tema['banerTripTema'];
					$JUDUL=$row_tema['title'];
					$RINCIAN=$ROW_tema['rincian'];
					$DOMAIN=$row_tema['domain'];
				}
			}
			?>		
			<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
			"http://www.w3.org/TR/html4/loose.dtd">
			<html>
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
			<title><?php $this->getTitle(); ?></title>
			<link rel="icon" href="./imagea/favicon.ico" type="image/x-icon" /> 
			<link rel="shortcut icon" href="./imagea/favicon.ico" type="image/x-icon" />
			<link href="stylea.css" rel="stylesheet" type="text/css" />
			<link rel="stylesheet" href="css/jquery.jcarousel.css" type="text/css" />
			<link rel="stylesheet" href="css/skin.css" type="text/css" />
			<script type="text/javascript" src="js/jquery-1.1.2.pack.js"></script>			
			<script type="text/javascript" src="js/jquery.jcarousel.pack.js"></script>
			<script type="text/javascript" src="js/prototype.lite.js"></script>
			<script type="text/javascript" src="js/moo.fx.js"></script>
			<script type="text/javascript" src="js/moo.fx.pack.js"></script>
			<script language="javascript" type="text/javascript" src="js/mctabs.js"></script>
			<STYLE type="text/css">
				a.menuItem
				{
					display: block;
					font: bold 11px tahoma, arial, Helvetica, sans-serif !important;
					text-decoration:none;
					background: url(imagea/<?php echo $BANERTRIP; ?>) no-repeat;
					padding: 0 0 0 30px;
					height: 22px;
					text-transform: capitalize;
				}

				a.menuItem:hover
				{
					background: url(imagea/HD-hover.jpg) no-repeat;
					color: #fff;
				}
				
				#tabledescription{
				width: 100%;
				height: auto;
				color:#<?php echo $TRIP; ?>;
				font-family: tahoma;
				font-size: 11px;
				text-align: left;
				padding-left: 2px;
				padding: 2px;
				filter:alpha(opacity=0);
				-moz-opacity:0;
				}
			</STYLE>
			<script type="text/javascript">
				function init(){
					var stretchers = document.getElementsByClassName('box');
					var toggles = document.getElementsByClassName('tab');
					var myAccordion = new fx.Accordion(
						toggles, stretchers, {opacity: false, height: true, duration: 400}
					);
					//hash functions
					var found = false;
					toggles.each(function(h3, i){
						var div = Element.find(h3, 'nextSibling');
							if (window.location.href.indexOf(h3.title) > 0) {
								myAccordion.showThisHideOpen(div);
								found = true;
							}
						});
						if (!found) myAccordion.showThisHideOpen(stretchers[0]);
				}
			</script>
			<script type="text/javascript">
				var baseopacity=0

				function showtext(thetext){
					if (!document.getElementById)
						return
					textcontainerobj=document.getElementById("tabledescription")
					browserdetect=textcontainerobj.filters? "ie" : typeof textcontainerobj.style.MozOpacity=="string"? "mozilla" : ""
					instantset(baseopacity)
					document.getElementById("tabledescription").innerHTML=thetext
					highlighting=setInterval("gradualfade(textcontainerobj)",50)
				}

				function hidetext(){
					cleartimer()
					instantset(baseopacity)
				}

				function instantset(degree){
					if (browserdetect=="mozilla")
						textcontainerobj.style.MozOpacity=degree/100
					else if (browserdetect=="ie")
						textcontainerobj.filters.alpha.opacity=degree
					else if (document.getElementById && baseopacity==0)
						document.getElementById("tabledescription").innerHTML=""
				}

				function cleartimer(){
					if (window.highlighting) 
						clearInterval(highlighting)
				}

				function gradualfade(cur2){
					if (browserdetect=="mozilla" && cur2.style.MozOpacity<1)
						cur2.style.MozOpacity=Math.min(parseFloat(cur2.style.MozOpacity)+0.2, 0.99)
					else if (browserdetect=="ie" && cur2.filters.alpha.opacity<100)
						cur2.filters.alpha.opacity+=20
					else if (window.highlighting)
						clearInterval(highlighting)
				}
			</script>
			</head>
			<body style="margin: 10px 0 10px 0;">
			  <table cellpadding="0" cellspacing="0" align="center" id="mainframe" border="1" style="background: #<?php echo "$BACK"; ?>;">
				<tr><td colspan="2">
				<div id="wrapper">
					<img src="imagea/<?php echo $BANER; ?>" width="209" height="63"> <?php tanggal(); ?>
					<div id="topnav">
						<table width="250" height="100%" cellpadding="0" cellspacing="0">
							<tr>
								<?php
									$menuAtas=$this->getMenuAtas();						
									$i=1;
									if(count($menuAtas)==3) {
										foreach($menuAtas as $link => $nama) { 
											if($i==1) {
												$img="pt.ico";
											}
											elseif($i==2) {
												$img="alamat.ico";
											}
											else {
												$img="trash.ico";
											}
										?>										
											<td class="topnav"><a href="<?php echo $link; ?>" class="topnav" title="<?php echo $nama; ?>" alt="<?php echo $nama; ?>"><img src="imagea/<?php echo $img; ?>" width="16" height="16"><br><?php echo $nama; ?></a></td>									
									<?		$i++;
										}	
									}
								?>	
								</tr>
						</table>
					</div><!-- end topnav -->
				</div>
				</td></tr><tr>
<?php	}
		
		function getFooter() { 
			//Untuk Tema
			$sql_tema="SELECT * FROM tema";
			$query_tema=mysql_query($sql_tema,opendb())or die(mysql_error());
			if($query_tema != null) {
				if(mysql_num_rows($query_tema)==1) {
					$row_tema=mysql_fetch_array($query_tema);
					$BODY=$row_tema['bodyTema'];
					$BACK=$row_tema['backTema'];
					$TRIP=$row_tema['tripTema'];
					$TEXT=$row_tema['tripTextTema'];
					$BANER=$row_tema['banerTema'];
					$BANERTRIP=$row_tema['banerTripTema'];
					$JUDUL=$row_tema['title'];
					$RINCIAN=$ROW_tema['rincian'];
					$DOMAIN=$row_tema['domain'];
				}
			}
		?>			
				</tr><tr><td colspan="2" style="padding: 10px; " align="center" bgcolor="#<?php echo $BACK; ?>">
					<span class="small">Copyrights &copy;2009 <?php echo $DOMAIN; ?>. Designed and Developed by <b>Masmian Mahida </b>.</span></td></tr>			
			</table>
			</body>
			</html>
<?php	}
		
		function getKiri() { 
			//Untuk Tema
			$sql_tema="SELECT * FROM tema";
			$query_tema=mysql_query($sql_tema,opendb())or die(mysql_error());
			if($query_tema != null) {
				if(mysql_num_rows($query_tema)==1) {
					$row_tema=mysql_fetch_array($query_tema);
					$BODY=$row_tema['bodyTema'];
					$BACK=$row_tema['backTema'];
					$TRIP=$row_tema['tripTema'];
					$TEXT=$row_tema['tripTextTema'];
					$BANER=$row_tema['banerTema'];
					$BANERTRIP=$row_tema['banerTripTema'];
					$JUDUL=$row_tema['title'];
					$RINCIAN=$ROW_tema['rincian'];
					$DOMAIN=$row_tema['domain'];
				}
			}
		?>
		<td width="487">
			<table cellpadding="0" cellspacing="0" width="487" border="0">
				<?php $this->getIsi(); ?>
				</table>
			</td>
<?php	}
		
		function getKanan() { 
			//Untuk Tema
			$sql_tema="SELECT * FROM tema";
			$query_tema=mysql_query($sql_tema,opendb())or die(mysql_error());
			if($query_tema != null) {
				if(mysql_num_rows($query_tema)==1) {
					$row_tema=mysql_fetch_array($query_tema);
					$BODY=$row_tema['bodyTema'];
					$BACK=$row_tema['backTema'];
					$TRIP=$row_tema['tripTema'];
					$TEXT=$row_tema['tripTextTema'];
					$BANER=$row_tema['banerTema'];
					$BANERTRIP=$row_tema['banerTripTema'];
					$JUDUL=$row_tema['title'];
					$RINCIAN=$ROW_tema['rincian'];
					$DOMAIN=$row_tema['domain'];
				}
			}
			?>
			<td width="212" style="background-color: #<?php echo $BACK; ?>;">
			<table cellpadding="0" cellspacing="0" class="spacer"><tr><td>
			<div id="wrapper2">
				<div id="content" style="background-color: #<?php echo $TRIP; ?>;">
					<div class="tab" style="background-color: #<?php echo $TRIP; ?>;"><h3 class="tabtxt" title="Panduan" ><a href="#panduan"><div style="color: #<?php echo $TEXT; ?>;">Panduan</div></a></h3></div>
					<div class="tab" style="background-color: #<?php echo $TRIP; ?>;"><h3 class="tabtxt" title="best"><a href="#best"><div style="color: #<?php echo $TEXT; ?>;">Best Seller</div></a></h3></div>					
					<div class="boxholder" style="background-color: #<?php echo $BACK; ?>;">
						<div class="box" style="background-color: #<?php echo $BACK; ?>;">
							<ul>
								<?php
									if(isset($_SESSION['ASTA_HASH'])) {
										$anc="&token=$_SESSION[ASTA_HASH]";
									}
									else {
										$anc="";
									}
								?>
								<li><a href="<?php echo "informasi.php?opt=belanja$anc"; ?>">Cara Belanja</a></li>								
								<li><a href="<?php echo "informasi.php?opt=bayar$anc"; ?>">Cara Pembayaran dan Konfirmasi</a></li>								
								<li><a href="<?php echo "informasi.php?opt=kirim$anc"; ?>">Biaya Pengiriman</a></li>						
							</ul>
						</div>						
						<div class="box" style="margin: 0px; padding: 0px;color: #<?php echo $BACK; ?>">
							<?php
								$sql_best="SELECT idProduk FROM produk WHERE idStatusProduk='4'";
								$query_best=mysql_query($sql_best,opendb())or die(mysql_error());
								if($query_best != null) {
									if(mysql_num_rows($query_best)>0) { 
										while($row_best=mysql_fetch_array($query_best)) {
											$bestID[]=$row_best['idProduk'];
										}
										srand((float) microtime() * 10000000);
										$show_best=2;
										$randBest=array_rand($bestID,$show_best);
										for($iB=0; $iB<$show_best; $iB++) {
											$id_best=$bestID[$randBest[$iB]];
											$sql_idBe="	SELECT P.idProduk, P.stockProduk, P.namaProduk, P.hargaProduk, P.konten, P.pathImage, D.namaProdusen, K.namaKategori 
														FROM produk P, produsen D, kategori K 
														WHERE P.idProdusen=D.idProdusen 
														AND P.idKategori=K.idKategori 
														AND P.idProduk='$id_best'";
											$query_idBe=mysql_query($sql_idBe,opendb())or die(mysql_error());
											if($query_idBe != null) {
												if(mysql_num_rows($query_idBe)>0) {
													$row_idBe=mysql_fetch_array($query_idBe); ?>
													<div style="padding: 10px 10px 10px 10px;">
														<div style="padding-bottom: 5px; color: #000000; text-align: center;"><?php echo "<b>".strtoupper($row_idBe['namaProduk'])."</b>"; ?></div>
														<table cellpadding="0" cellspacing="0" align="center" width="100%" border="0">
															<tr>
																<td width="85">
																	<div><img src="./imagea/product/<?php echo $row_idBe['pathImage']; ?>" width="75" height="111"></div>
																	</td>
																<td align="left">
																	<?php
																		if($_SESSION['ASTA_HASH']) {
																			$href="cart.php?token=$_SESSION[ASTA_HASH]&";
																		}
																		else {
																			$href="cart.php?";
																		}
																	?>															
																	<div><i><font color="black">Produsen</font></i> <b><?php echo $row_idBe['namaProdusen']; ?></b></div>
																	<div><i><font color="black">Rp. </font></i> <b><?php echo $row_idBe['hargaProduk']; ?></b></div>
																	<div><i><font color="black">Stock</font></i> <b><?php echo $row_idBe['stockProduk']; ?></b></div>
																	<div style="padding-top: 10px;"><div style="background-color: #<?php echo $TRIP; ?>; width: 65px; text-align: center;"><b><a href="<?php echo $href."pd_id=$row_idBe[idProduk]"; ?>"><div style="color: #<?php echo $TEXT; ?>;">AddToCart</div></a></b></div></div>
																	</td>
																</tr>
															<tr>
																<td colspan="2" align="left" valign="top">
																	<div><i><?php echo $row_idBe['konten']; ?></i></div>
																	</td>
																</tr>
															</table>
														<div style="padding-top: 3px;"><div style="height: 1px; background-color: #<?php echo $TRIP; ?>; width: 191px; text-align: left;"></div></div>
														</div>
										<?php	}
											}								
										}
									}
								}
							?>
							</div>
					<div style="padding-bottom: 10px;"></div>
						</div>
					</div>
				</div>
			</div>
			<script type="text/javascript">
				Element.cleanWhitespace('content');
				init();
			</script>
			</td></tr>
			<tr><td align="center" valign="top" style="padding-top:5px;">
				<div class="bank" style="color: #<?php echo $TEXT; ?>;background-color: #<?php echo $TRIP; ?>;">Produk Unggulan</div>
				<div style="border: 1px solid #<?php echo $BACK; ?>; width: 211px;">
					<?php
						$sql_unggul="SELECT idProduk FROM produk WHERE idStatusProduk='3'";
						$query_unggul=mysql_query($sql_unggul,opendb())or die(mysql_error());
						if($query_unggul != null) {
							if(mysql_num_rows($query_unggul)>0) { 
								while($row_unggul=mysql_fetch_array($query_unggul)) {
									$unggulID[]=$row_unggul['idProduk'];
								}
								srand((float) microtime() * 10000000);
								$show_unggul=2;
								$randUg=array_rand($unggulID,$show_unggul);
								for($i=0; $i<$show_unggul; $i++) {
									$id_unggul=$unggulID[$randUg[$i]];
									$sql_id="	SELECT P.idProduk, P.stockProduk, P.namaProduk, P.hargaProduk, P.konten, P.pathImage, D.namaProdusen, K.namaKategori 
												FROM produk P, produsen D, kategori K 
												WHERE P.idProdusen=D.idProdusen 
												AND P.idKategori=K.idKategori 
												AND P.idProduk='$id_unggul'";
									$query_id=mysql_query($sql_id,opendb())or die(mysql_error());
									if($query_id != null) {
										if(mysql_num_rows($query_id)>0) {
											$row_id=mysql_fetch_array($query_id); ?>
											<div style="padding: 10px 10px 10px 10px;">
												<div style="padding-bottom: 5px; color: #000000;"><?php echo "<b>".strtoupper($row_id['namaProduk'])."</b>"; ?></div>
												<table cellpadding="0" cellspacing="0" align="center" width="100%" border="0">
													<tr>
														<td width="85">
															<div><img src="./imagea/product/<?php echo $row_id['pathImage']; ?>" width="75" height="111"></div>
															</td>
														<td align="left">
															<?php
																if($_SESSION['ASTA_HASH']) {
																	$href="cart.php?token=$_SESSION[ASTA_HASH]&";
																}
																else {
																	$href="cart.php?";
																}
															?>															
															<div><i><font color="black">Produsen</font></i> <b><?php echo $row_id['namaProdusen']; ?></b></div>
															<div><i><font color="black">Rp. </font></i> <b><?php echo $row_id['hargaProduk']; ?></b></div>
															<div><i><font color="black">Stock</font></i> <b><?php echo $row_id['stockProduk']; ?></b></div>
															<div style="padding-top: 10px;"><div style="background-color: #<?php echo $TRIP; ?>; width: 65px; text-align: center;"><a href="<?php echo $href."pd_id=$row_id[idProduk]"; ?>"><div style="color: #ffffff;"><b>AddToCart</b></div></a></div></div>
															</td>
														</tr>
													<tr>
														<td colspan="2" align="left" valign="top">
															<div><i><?php echo $row_id['konten']; ?></i></div>
															</td>
														</tr>
													</table>
												<div style="padding-top: 3px;"><div style="height: 1px; background-color: #<?php echo $TRIP; ?>; width: 191px; text-align: left;"></div></div>
												</div>
								<?php	}
									}								
								}
							}
						}
					?>
					</div><div style="padding-bottom: 10px;"></div>
				<div class="bank" style="color: #<?php echo $TEXT; ?>; background-color: #<?php echo $TRIP; ?>;">Customer Service</div>
				<div style="border: 1px solid #<?php echo $BACK; ?>; width: 211px;">
					<div style="padding: 10px 10px 0px 10px;">
					<?php
						/**
						$sql_owner="SELECT namaOwner, emailOwner FROM owner WHERE idStatusShow='1'";
						$query_owner=mysql_query($sql_owner,opendb())or die(mysql_error());
						if($query_owner != null) {
							if(mysql_num_rows($query_owner)>0) { 
								while($row_owner=mysql_fetch_array($query_owner)) {
									$source=explode("@",$row_owner['emailOwner']);
									$ym=$source[0]; ?>
									<div>
										<a href="ymsgr:sendim?<?php echo $ym; ?>" style="text-decoration: none;" alt="<?php echo $ym; ?>" title="<?php echo $ym; ?>">
											<img src="http://opi.yahoo.com/online?u=<?php echo $ym; ?>&m=g&t=1" alt="" vspace="4" border="0">
											</a>
										</div>
									<div style="padding-bottom: 10px;"><?php echo $row_owner['namaOwner']; ?></div>
						<?php	}								
							}
						}**/
					?>
						</div>
					<div><b><u>Konfirmasi Melalui SMS:</u></b></div>
					<div>085691969575</div>
					<div>Dengan menyertakan No Faktur</div>
					</div>
				<div style="padding-bottom: 10px;"></div>
				<div class="bank" style="color: #<?php echo $TEXT; ?>;background-color: #<?php echo $TRIP; ?>;">Kami Menerima</div>
				<div style="border: 1px solid #<?php echo $BACK; ?>; width: 211px;">
					<div style="padding: 10px 10px 0px 10px;">
					<?php
						$sql_bank="SELECT * FROM bank";
						$query_bank=mysql_query($sql_bank,opendb())or die(mysql_error());
						if($query_bank !=null) {
							if(mysql_num_rows($query_bank)>0) { 
								while($row_bank=mysql_fetch_array($query_bank)) { ?>							
									<div align="center"><img src="./imagea/<?php echo $row_bank['image']; ?>" width="70" height="46"></div>
									<div align="center"><b><?php echo strtoupper($row_bank['namaBank']); ?></b> Rek. <b><?php echo $row_bank['noRekBank']; ?></b></div>
									<div align="center">a.n. <b><?php echo $row_bank['namaPemilik']; ?></b></div>
									<div align="center">Cabang <b><?php echo $row_bank['cabang']; ?></b></div>
									<div style="padding-bottom: 10px;"></div>
					<?php		}
							}
						}
					?>
						</div>
					</div>
				</td></tr>
			</table>
		</td>
<?php	}
		
		function getTampilkan() {
			$this->getHeader();
			$this->getKiri();
			$this->getKanan();
			$this->getFooter();
		}
	}
?>