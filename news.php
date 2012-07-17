<?php
	$title="$JUDUL | News";
	$isi="<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" align=\"center\" border=\"0\">
			<tr>
				<td valign=\"top\" width=\"100%\">";
					$id=(int)$_GET['id'];
					$sqlNews="
						SELECT B.judulBerita, B.tgl, B.isiBerita FROM 
						berita B, kategoriberita K 
						WHERE 
						B.idKategoriBerita=K.idKategoriBerita AND 
						B.idBerita='$id'
					";
					$queryNews=mysql_query($sqlNews);
					if(mysql_num_rows($queryNews) > 0){
						while($rowNews=mysql_fetch_array($queryNews)){
							$isi.="<div>News</div>
								<div style=\"text-align:left; padding-top:20px; padding-bottom:5px;\"><b>$rowNews[judulBerita]</b></div>
								<div style=\"text-align:left; padding-bottom:5px;color: red;\">".splitTanggal($rowNews[tgl])."</div>
								<div style=\"text-align:justify;\">$rowNews[isiBerita]</div>
							";
						}
					}
						
					$isi.="</td>
				</tr>
			</table>";
	
	$render->setTitle($title);
	$render->setIsi($isi);
	$render->getTampilkan();
?>