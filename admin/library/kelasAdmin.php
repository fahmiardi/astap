<?php
	class Admin {
		var $title="::::";
		var $warning="";		
		var $arrayMenu="";
		var $otherMenu="";
		var $isiLink="";
		var $konten="";
		
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
		
		function getWarning() {
			echo $this->warning;
		}
				
		function setLinkLogout($link) {
			$this->isiLink=$link;
		}
		
		function getLinkLogout() {
			echo $this->isiLink;
		}
		
		function setIsi($konten) {
			$this->konten=$konten;
		}
		
		function getIsi() {			
			echo $this->getWarning();
			echo $this->konten;
		}
			
		function setArrayMenu($array) {
			$this->arrayMenu=$array;
		}
		
		function getArrayMenu() {
			return $this->arrayMenu;
		}
		
		function setOtherMenu($otherMenu){
			$this->otherMenu=otherMenu;
		}
		
		function getOtherMenu(){
			return $this->otherMenu;
		}
		
		function getHeader() { ?>		
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
			<!-- TinyMCE -->
			<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
			<script type="text/javascript">
				tinyMCE.init({
					// General options
					mode : "textareas",
					theme : "advanced",
					plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
					// Theme options
					theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
					theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
					theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
					theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
					theme_advanced_toolbar_location : "top",
					theme_advanced_toolbar_align : "left",
					theme_advanced_statusbar_location : "bottom",
					theme_advanced_resizing : true,

					// Example content CSS (should be your site CSS)
					content_css : "css/content.css",

					// Drop lists for link/image/media/template dialogs
					template_external_list_url : "lists/template_list.js",
					external_link_list_url : "lists/link_list.js",
					external_image_list_url : "lists/image_list.js",
					media_external_list_url : "lists/media_list.js",

					// Replace values for the template plugin
					template_replace_values : {
						username : "Some User",
						staffid : "991234"
					}
				});
			</script>
			<!-- /TinyMCE -->
			
			
			</head>
			<body>
			  <table cellpadding="0" cellspacing="0" align="center" id="mainframe" border="1" style="width: 100%">
				<tr><td colspan="2" style="padding-top: 10px;">
					<table cellpadding="0" cellspacing="0" width="100%" align="center" border="0">
						<tr>
							<td width="30%" valign="top">
								<div align="center"><img src="imagea/aseteck2.gif" width="209" height="89"></div>
								<div style="text-align: left; padding: 0 0 5px 5px;"><?php tanggal(); ?></div>
								</td>							
							</tr>
						</table>
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
				</tr><tr><td colspan="2" style="padding: 10px; " align="center" bgcolor="#364b1a">
					<span class="small">Copyrights &copy;2009 <?php echo $DOMAIN; ?>. Designed and Developed by <b>Masmian Mahida</b>.</span></td></tr>			
			</table>
			</body>
			</html>
<?php	}
		
		function getKiri() { ?>
			<td width="80%">
				<table cellpadding="0" cellspacing="0" width="100%" border="0">
					<?php $this->getIsi(); ?>
					</table>
				</td>
<?php	}
		
		function getMenu() { 
			$header=array("Notifikasi","Produk","Berita","Administrasi","Stock");
			$jmlh=count($header);
			$i=0;
			while($i<$jmlh) { ?>
				<div align="left">					
							<?php
								if($i==0) {
									include_once("./include/functions.php");
									opendb();
									$tahun = date("Y");
									$bulan = date("m");
									$hari = date("d");
									$today=$tahun."-".$bulan."-".$hari;
									
									$sqlPending="SELECT idStatusPesan FROM pemesanan WHERE idStatusPesan = '1'";
									$queryPending=mysql_query($sqlPending);
									$jumPending=mysql_num_rows($queryPending);
									
									$sqlPendingToday="SELECT idStatusPesan FROM pemesanan WHERE idStatusPesan = '1' AND tgl='$today'";
									$queryPendingToday=mysql_query($sqlPendingToday);
									$jumPendingToday=mysql_num_rows($queryPendingToday);
									
									$sqlNew="SELECT idStatusPesan FROM pemesanan WHERE idStatusPesan = '2'";
									$queryNew=mysql_query($sqlNew);
									$jumNew=mysql_num_rows($queryNew);
									
									$sqlPaid="SELECT idStatusPesan FROM pemesanan WHERE idStatusPesan = '3'";
									$queryPaid=mysql_query($sqlPaid);
									$jumPaid=mysql_num_rows($queryPaid);
									
									$sqlShipped="SELECT idStatusPesan FROM pemesanan WHERE idStatusPesan = '4'";
									$queryShipped=mysql_query($sqlShipped);
									$jumShipped=mysql_num_rows($queryShipped);
									
									
									echo "<div style=\"padding: 10px\">
										<div style=\"background: orange; color: white; text-align: center; width: 100px;\" align=\"left\">Notifikasi</div>
										<div style=\"border: 1px solid orange; padding: 10px 10px 10px 10px; width:135px;\">
										<div style=\"padding-top:0px\">
											<table width=\"100%\">
												<tr>
													<td>Transaksi Pending</td>
													<td>:</td>
													<td>$jumPending</td>
												</tr>
												<tr>
													<td>Transaksi Baru</td>
													<td>:</td>
													<td>$jumPaid</td>
												</tr>
												<tr>
													<td>Transaksi Terbayar</td>
													<td>:</td>
													<td>$jumPaid</td>
												</tr>
												<tr>
													<td>Transaksi Terkirim</td>
													<td>:</td>
													<td>$jumShipped</td>
												</tr>
												<tr>
													<td>Status Pending Hari ini</td>
													<td>:</td>
													<td>$jumPendingToday</td>
												</tr>
											</table>
										</div>
									";
									
									
									closedb();
								}
								elseif($i==1) {
									$menu=array('Produk'=>"produk.php?token=$_SESSION[ASTA_ADM_HASH]",
												'Pemesanan'=>"pemesanan.php?token=$_SESSION[ASTA_ADM_HASH]",
												'Konfirmasi'=>"konfirmasi.php?token=$_SESSION[ASTA_ADM_HASH]",
												'Data Pelanggan'=>"pelanggan.php?token=$_SESSION[ASTA_ADM_HASH]",
												'Produsen'=>"produsen.php?token=$_SESSION[ASTA_ADM_HASH]",
												'Kategori Produk'=>"kategori.php?token=$_SESSION[ASTA_ADM_HASH]");
									echo 	"	<div style=\"padding-top: 10px;\">
												<div style=\"background: orange; color: white; text-align: center; width: 100px;\" align=\"left\">Produk</div>
												<div style=\"border: 1px solid orange; padding: 10px 10px 10px 10px; width:135px;\">";
									foreach($menu as $judul=>$link) { ?>
										<div align="left"><img src="./imagea/favicon.ico" width="16" height="16">&nbsp;<a href="<?php echo $link; ?>"><?php echo $judul; ?></a></div>
							<?php	}
								}
								elseif($i==2) {
									$menu=array('Berita'=>"berita.php?token=$_SESSION[ASTA_ADM_HASH]",
												'Networks'=>"network.php?token=$_SESSION[ASTA_ADM_HASH]",
												'Profil'=>"profil.php?token=$_SESSION[ASTA_ADM_HASH]",
												'Contact'=>"contact.php?token=$_SESSION[ASTA_ADM_HASH]",
												'Customer Service'=>"owner.php?token=$_SESSION[ASTA_ADM_HASH]");
									echo 	"	<div style=\"padding-top:10px\">
												<div style=\"background: orange; color: white; text-align: center; width: 100px;\" align=\"left\">Informasi</div>
												<div style=\"border: 1px solid orange; padding: 10px 10px 10px 10px; width:135px;\">";
									foreach($menu as $judul=>$link) { ?>
										<div align="left" style="padding:0px"><img src="./imagea/favicon.ico" width="16" height="16">&nbsp;<a href="<?php echo $link; ?>"><?php echo $judul; ?></a></div>
							<?php	}
								}
								elseif($i==3){
								opendb();
									$sqlStok="SELECT namaProduk
											FROM produk
											WHERE stockProduk <=5";
									$queryStok=mysql_query($sqlStok);
									$jumStok=mysql_num_rows($queryStok);
									if($jumStok==0){
										
									}
									else{
									echo"<div style=\"padding-top:10px\">
										<div style=\"background: orange; color: white; text-align: center; width: 100px;\" align=\"left\">Stok Minim</div>
										<div style=\"border: 1px solid orange; padding: 10px 10px 10px 10px; width:135px;\">";
										while($rowStok=mysql_fetch_array($queryStok)){
											echo "<font color=\"yellow\">$rowStok[namaProduk]</font><br>";
										}
									}
								closedb();
								}
								else {
									$menu=array('Home'=>"index.php?token=$_SESSION[ASTA_ADM_HASH]",
												'My Account'=>"myAccount.php?token=$_SESSION[ASTA_ADM_HASH]",
												'Bank'=>"bank.php?token=$_SESSION[ASTA_ADM_HASH]",
												'Theme'=>"theme.php?token=$_SESSION[ASTA_ADM_HASH]",
												'Upload Image'=>"uploadImage.php?token=$_SESSION[ASTA_ADM_HASH]",
												'Logout'=>"index2.php?act=logout&token=$_SESSION[ASTA_ADM_HASH]");
									echo 	"	<div style=\"padding-top: 10px;\">
												<div style=\"background: orange; color: white; text-align: center; width: 100px;\" align=\"left\">Administrasi</div>
												<div style=\"border: 1px solid orange; padding: 10px 10px 10px 10px; width:135px;\">";
									foreach($menu as $judul=>$link) { ?>
										<div align="left"><img src="./imagea/favicon.ico" width="16" height="16">&nbsp;<a href="<?php echo $link; ?>"><?php echo $judul; ?></a></div>
							<?php	}
								}
								
							?>
							
					</div>
<?php			$i++;
			}	?>			
<?php	}
		
		function getKanan() { ?>
			<td width="20%">				
				<?php
					if(isset($_SESSION['ASTA_ADM_HASH'])) {
						$this->getMenu();
					}
				?>
				
				</td>
			<script type="text/javascript">
				Element.cleanWhitespace('content');
				init();
			</script>
		
<?php }
		function getTampilkan() {
			$this->getHeader();
			$this->getKiri();
			$this->getKanan();
			$this->getFooter();
		}
	}
?>