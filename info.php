<?php
	$title="$JUDUL | $RINCIAN";
	$isi="<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" align=\"center\" border=\"0\">
			<tr>
				<td valign=\"top\" width=\"100%\">";
					$id=(int)$_GET['sec'];
					$act=$_GET['act'];
					switch($act){
						case "about":
							$sqlAbout="
								SELECT T.judulKonten, T.deskripsiKonten, P.namaPosisi FROM 
								posisi P, tentangkami T 
								WHERE 
								T.idPosisi=P.idPosisi AND 
								T.idTentang='$id'
							";
							$queryAbout=mysql_query($sqlAbout);
							if(mysql_num_rows($queryAbout) > 0){
								while($rowAbout=mysql_fetch_array($queryAbout)){
									$isi.="<div>$rowAbout[namaPosisi]&nbsp;&nbsp;<img src=\"./imagea/rafa_43.gif\" width=\"8\" height=\"7\">&nbsp;&nbsp;$rowAbout[judulKonten]</div>
										<div style=\"text-align:justify;\">$rowAbout[deskripsiKonten]</div>
									";
								}
							}
						break;
						case "contact":
							$sqlContact="
							SELECT * FROM perusahaan
							";
							$queryContact=mysql_query($sqlContact);
							if(mysql_num_rows($queryContact)==1){
								$row_pt=mysql_fetch_array($queryContact);
						$isi.="<table align=\"center\" width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
								<tr>
									<td width=\"60\">
										<img src=\"./imagea/pt.ico\" width=\"48\" height=\"48\">
										</td>
									<td colspan=\"2\" style=\"padding-top: 20px;\">
										<font style=\"color: red;\" size=4>".strtoupper($row_pt['namaPerusahaan'])."
										</td>
									</tr>
								<tr>
									<td></td>
									<td width=\"25\">
										<img src=\"./imagea/alamat.ico\" width=\"16\" height=\"16\">
										</td>
									<td style=\"padding-bottom: 5px;\">
										$row_pt[alamatPerusahaan]
										</td>
									</tr>
								<tr>
									<td></td>
									<td width=\"25\">
										<img src=\"./imagea/phone.ico\" width=\"16\" height=\"16\">
										</td>
									<td style=\"padding-bottom: 5px;\">
										$row_pt[contactPerusahaan]
										</td>
									</tr>
								<tr>
									<td></td>
									<td width=\"25\">
										<img src=\"./imagea/email.ico\" width=\"16\" height=\"16\">
										</td>
									<td style=\"padding-bottom: 5px;\">
										$row_pt[emailPerusahaan]
										</td>
									</tr>
								</table>";
							}
							$sql_cs="SELECT * FROM owner";
							$query_cs=mysql_query($sql_cs,opendb())or die(mysql_error());
							if($query_cs != null) {
								if(mysql_num_rows($query_cs)>0) {
								$isi .="	<table align=\"center\" width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
												<tr>
													<td width=\"60\">
														<img src=\"./imagea/cs2.ico\" width=\"48\" height=\"48\">
														</td>
													<td colspan=\"2\" style=\"padding-top: 20px;\">
														<font style=\"color: red;\" size=4>Customer Service
														</td>
													</tr>";
									while($row_cs=mysql_fetch_array($query_cs)) {
										$isi .="<tr>
													<td></td>
													<td width=\"25\">
														<img src=\"./imagea/cs1.ico\" width=\"16\" height=\"16\">
														</td>
													<td style=\"padding-bottom: 5px;\">
														Nama: $row_cs[namaOwner]<br>Email: $row_cs[emailOwner]<br>Contact: $row_cs[contactOwner]
														</td>
													</tr>";
									}
								}
							}															
							$isi.="	</table>
									<div style=\"padding-top: 100px;\"></div>";
						break;
						default:
							include_once "./index.php";
						break;
					}
					$isi.="</td>
				</tr>
			</table>";
	
	$render->setTitle($title);
	$render->setIsi($isi);
	$render->getTampilkan();
?>