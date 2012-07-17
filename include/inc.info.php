<?php
	$bd=BrowserDetector();
	$ip = getenv("REMOTE_ADDR");
	echo "<table border='0' cellpadding='0' cellspacing='0'>";
	echo "	<tr>
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
?>