<?php
	class Company {
		var $title="Test";
		var $isi="";
		
		//method SET
		function setTitle($title) {
			$this->title=$title;
		}
		
		function setIsi($isi) {
			$this->isi=$isi;
		}
		
		//method GET
		function getTitle() {
			return $this->title;
		}
		
		function getHeader() {
			?>
			<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
			<html>
				<head>
					<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
					<title>.: <?php echo $this->getTitle(); ?>:.</title>
					<link href="./css/style.css" rel="stylesheet" type="text/css">
					<link rel="shortcut icon" href="./imagea/favicon.ico" type="image/x-icon">
					<link rel="stylesheet" href="css/jquery.jcarousel.css" type="text/css">
					<link rel="stylesheet" href="css/skin.css" type="text/css">
					<script type="text/javascript" src="js/jquery-1.1.2.pack.js"></script>			
					<script type="text/javascript" src="js/jquery.jcarousel.pack.js"></script>
					<script type="text/javascript" src="js/prototype.lite.js"></script>
					<script type="text/javascript" src="js/moo.fx.js"></script>
					<script type="text/javascript" src="js/moo.fx.pack.js"></script>
					<script language="javascript" type="text/javascript" src="js/mctabs.js"></script>
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
				<body style="margin: 10px 0 10px 0; text-align: center; background-color: #<?php echo $BACK; ?>;">
					<table cellpadding="0" cellspacing="0" width="739" align="center" border="0" bgcolor="#ffffff">			
						<tr><td height="1" bgcolor="#263d01" colspan="4"></td></tr>
						<tr>
							<td width="1" bgcolor="#263d01" style="font-size: 1px; color: #263d01;">.</td>
							<td width="735" align="center" style="padding-left: 20px; padding-right: 20px;">
								<div id="wrapper2">
								<div id="content">
									<div style="padding-top: 8px;"></div>
									<div id="br1" style="width: 739px; height: 78px; background-color: #ffffff;">
										<div style="background: url(./imagea/theme1/asta_02.gif); width:642px; height: 78px; float: left;"></div>
										<?php
										$sql_ol="SELECT online FROM tema";
										$query_ol=mysql_query($sql_ol,opendb())or die(mysql_error());
										if($query_ol != null) {
											if(mysql_num_rows($query_ol)==1) {
												$row_ol=mysql_fetch_array($query_ol);
												$ol=$row_ol['online'];
												if($ol==0) {
													$bg="background-color: #ffffff";
													$href="#";
												}
												else {
													$bg="background: url(./imagea/theme1/asta_03.gif)";
													$href="page.php?opt=toko";
												}
											}
										}
										?>
										<a href="<?php echo $href; ?>" target="_blank"><div style="<?php echo $bg; ?>; width:97px; height: 78px; float: left; cursor: pointer;">
											</div></a>
										</div>
									<div id="br2" style="width: 739px; height: 101px;">
										<div style="background: url(./imagea/theme1/asta_05.jpg); width:107px; height: 101px; float: left;"></div>
										<div style="background: url(./imagea/theme1/asta_06.gif); width:95px; height: 101px; float: left;"></div>
										<div style="background: url(./imagea/theme1/asta_07.gif); width:95px; height: 101px; float: left;"></div>
										<div style="background: url(./imagea/theme1/asta_08.gif); width:90px; height: 101px; float: left;"></div>
										<div style="background: url(./imagea/theme1/asta_09.gif); width:85px; height: 101px; float: left;"></div>
										<div style="background: url(./imagea/theme1/asta_10.gif); width:84px; height: 101px; float: left;"></div>
										<div style="background: url(./imagea/theme1/asta_11.jpg); width:86px; height: 101px; float: left;"></div>
										<div style="background: url(./imagea/theme1/asta_12.gif); width:97px; height: 101px; float: left;"></div>
										</div>
									<div id="br4" style="width: 739px; height: 45px;">
										<div style="background: url(./imagea/theme1/asta_13.gif); width:18px; height: 45px; float: left;"></div>
										<div style="background: url(./imagea/theme1/asta_14.gif); width:704px; height: 45px; float: left;">
											<div style="font-family: tahoma; font-size: 12px; color: #ffffff; padding-top: 10px; font-weight: bold;"><?php echo $this->getMenuAtas(); ?></div>
											</div>
										<div style="background: url(./imagea/theme1/asta_16.gif); width:17px; height: 45px; float: left;"></div>
										</div>
									
			<?php
		}
		
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
					$RINCIAN=$row_tema['rincian'];
					$DOMAIN=$row_tema['domain'];
				}
			}
			?>					
								<div id="br6" style="width: 739px; height: 29px;">
									<div style="background: url(./imagea/theme1/asta_21.gif); width:18px; height: 29px; float: left;"></div>
									<div style="background: url(./imagea/theme1/asta_22.gif); width:704px; height: 29px; float: left;">
										<div style="font-size: 7px; text-align: center;">
											<b><a href="index.php" style="cursor: pointer; font-size: 7px; ">Home</a> | <a href="page.php?opt=info&act=contact" style="cursor: pointer; font-size: 7px; ">Contact</a></b>
											</div>
										<div style="font-size: 9px; color: #ffffff; padding-top: 5px; text-align: center;">
											Copyright &copy;2009 <?php echo $DOMAIN; ?> Designed and Provided by <b>MASMIAN MAHIDA</b>
											</div>	
										</div>
									<div style="background: url(./imagea/theme1/asta_23.gif); width:17px; height: 29px; float: left;"></div>									
									</div>
								<div style="padding-top: 20px;"></div>
								</div>
							</div>
							<script type="text/javascript">
								Element.cleanWhitespace('content');
								init();
							</script>
							</td>
						<td width="1" bgcolor="#263d01" style="font-size: 1px; color: #263d01;">.</td>
						</tr>		
					<tr><td height="1" bgcolor="#263d01" colspan="4"></td></tr>
					</table>
				</body>
			</html>
			<?php
		}
		
		function getMenuAtas() {
			?>
			<div align="center">
				<a href="index.php"><div style="float: left; color: #ffffff; padding: 0 10px 0 10px; cursor: pointer;">Home</div></a>
				<a href="#about"><div class="tab" style="cursor: pointer;">Tentang Kami</div></a>
				<a href="#porto"><div class="tab" style="cursor: pointer;">Portofolio</div></a>
				<a href="page.php?opt=info&act=contact"><div style="cursor: pointer; float: left; color: #ffffff; padding: 0 10px 0 10px;">Contact</div></a>
				</div>
			<?php
		}
		
		function getContent() {
			?>
			<div id="br5" style="width: 739px;">
				<table cellpadding="0" cellspacing="0" width="739" align="center" border="0">
					<tr>
						<td background="./imagea/theme1/asta_17.gif" width="2"></td>
						<?php 
						echo $this->getContentKiri(); 
						echo $this->getContentKanan(); 
						?>
						<td background="./imagea/theme1/asta_17.gif" width="2"></td>
						</tr>
					</table>
				</div>
			<?php
		}
		
		function getContentKiri() {
			?>
			<td width="207" style="padding: 0 0 0 10px;" valign="top">
				<div class="boxholder" id="linkmenu">
					<div class="box">
						<div style="text-align: left; padding-bottom: 10px;">
							<img src="./imagea/about.gif" width="77" height="9">
							</div>
						<?php
						$sql_about="SELECT idTentang, judulKonten 
									FROM tentangkami 
									WHERE idPosisi='1'";
						$query_about=mysql_query($sql_about,opendb())or die(mysql_error());
						if($query_about != null) {
							if(mysql_num_rows($query_about)>0) {
								while($row_about=mysql_fetch_array($query_about)) {
									echo "<div><img src=\"./imagea/rafa_43.gif\" width=\"8\" height=\"7\"> <a href=\"page.php?opt=info&act=about&sec=$row_about[idTentang]\">$row_about[judulKonten]</a></div>";
								}
							}
						}
						?>
						<div style="padding-top: 20px;"></div>
						</div>
					<div class="box">
						<div style="text-align: left; padding-bottom: 10px;">
							<img src="./imagea/porto.gif" width="62" height="8">
							</div>
						<?php
						$sql_porto="SELECT idTentang, judulKonten 
									FROM tentangkami 
									WHERE idPosisi='2'";
						$query_porto=mysql_query($sql_porto,opendb())or die(mysql_error());
						if($query_porto != null) {
							if(mysql_num_rows($query_porto)>0) {
								while($row_porto=mysql_fetch_array($query_porto)) {
									echo "<div><img src=\"./imagea/rafa_43.gif\" width=\"8\" height=\"7\"> <a href=\"page.php?opt=info&act=about&sec=$row_porto[idTentang]\">$row_porto[judulKonten]</a></div>";
								}
							}
						}
						?>
						<div style="padding-top: 20px;"></div>
						</div>
					</div>				
				<div id="news1">
					<div style="text-align: left;">
						<img src="./imagea/news.gif" width="30" height="9">
						</div>
					<?php
					$sql_news="	SELECT idBerita, judulBerita, tgl, isiBerita 
								FROM berita 
								WHERE idKategoriBerita='3' 
								AND idStatusShow='1'";
					$query_news=mysql_query($sql_news,opendb())or die(mysql_error());
					if($query_news != null) {
						if(mysql_num_rows($query_news)>0) {
							while($row_news=mysql_fetch_array($query_news)) {
								?>								
								<div style="padding: 10px 0 5px 0;">
									<div style="color: red;"><b><?php echo splitTanggal($row_news['tgl']); ?></b></div>
									<div style="size: 12px;"><b><?php echo $row_news['judulBerita']; ?></b></div>
									</div>
								<div style="width: 175px; text-align: left;">
									<a class="news" href="page.php?opt=news&id=<?php echo $row_news['idBerita']; ?>">
									<?php
									echo filter(substr($row_news['isiBerita'],0,100))."...";
									?>
									</a>
									</div>
								<?php
							}
						}
					}
					?>										
					</div>
				<div id="support">
					<div style="text-align: left; padding: 20px 0 10px 0;">
						<img src="./imagea/our.gif" width="72" height="9">
						</div>
					<div style="text-align: left; padding: 0px 0 0px 0; background: url(./imagea/suport.gif); width:166px; height: 100px;">
						<div style="color: #000000; text-align: right; padding: 40px 5px 0 0;">
							<?php
							$sql_sup="SELECT emailPerusahaan, contactPerusahaan FROM perusahaan";
							$query_sup=mysql_query($sql_sup,opendb())or die(mysql_error());
							if($query_sup != null) {
								if(mysql_num_rows($query_sup)==1) {
									$row_sup=mysql_fetch_array($query_sup);
									$eks=explode("/",$row_sup['contactPerusahaan']);
									echo $row_sup['emailPerusahaan']."<br>".$eks[0]."<br>".$eks[1];
								}
							}
							?>
							</div>
						</div>
					</div>
				<div id="network">
					<div style="text-align: left; padding: 20px 0 10px 0;">
						<img src="./imagea/net.gif" width="84" height="10">
						</div>
					<div style="text-align: left; padding: 0px 0 0px 0;">
							<?php
							echo "<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">
								<tr><td><div id=\"coolmenu\">";
								$sql_net="SELECT * FROM network WHERE idStatusShow='1'";
								$query_net=mysql_query($sql_net,opendb())or die(mysql_error());
								if($query_net != null) {
									if(mysql_num_rows($query_net)>0) {
										while($row_net=mysql_fetch_array($query_net)) {
										echo "<div><img src=\"./imagea/rafa_43.gif\" width=\"8\" height=\"7\">&nbsp;<a href=\"$row_net[linkNetwork]\" 
														onMouseover=\"showtext('"."$row_net[keteranganNetwork]"."')\" 
														onMouseout=\"hidetext()\">$row_net[namaNetwork]</a></div>";
										}
									}
								}										
						echo "</ul></div><div id=\"tabledescription\"></div>									
								</td></tr>
							</table>";
							?>
						</div>
					</div>
				</td>
			<?php
		}
		
		function getIsi() {
			return $this->isi;
		}
		
		function getContentKanan() {
			?>
			<td style="padding: 0 10px 0 0;" valign="top" width="508">
				<?php echo $this->getIsi(); ?>							
				</td>
			<?php
		}
		
		function getTampilkan() {
			echo $this->getHeader();
			echo $this->getContent();
			echo $this->getFooter();
		}
	}
?>