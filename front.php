<?php
	$title="$JUDUL | $RINCIAN";
	$isi="<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" align=\"center\" border=\"0\">
			<tr>
				<td valign=\"top\" width=\"100%\">";
					$isi .="<div style=\"width: 250px;\">
								<img src=\"./imagea/astape_22.gif\" width=\"262\" height=\"46\">
								</div>";
					$sql_home="SELECT judulBerita, isiBerita FROM berita WHERE idStatusShow='1' AND idKategoriBerita='4'";
					$query_home=mysql_query($sql_home,opendb())or die(mysql_error());
					if($query_home != null) {
						if(mysql_num_rows($query_home)==1) {
							$row_home=mysql_fetch_array($query_home);					
							$isi.="<div style=\"text-align: left;\">
								<div style=\"\">".$row_home['isiBerita']."</div>
								</div>";
						}
					}					
		$isi.="	</tr>
			</table>";
	
	$render->setTitle($title);
	$render->setIsi($isi);
	$render->getTampilkan();
?>