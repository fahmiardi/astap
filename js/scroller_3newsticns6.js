var titlea = new Array();
var texta = new Array();
var linka = new Array();
var trgfrma = new Array();
var heightarr = new Array();
var cyposarr = new Array();

cyposarr[0]=0;
cyposarr[1]=1;
cyposarr[2]=2;
cyposarr[3]=3;
cyposarr[4]=4;
cyposarr[5]=5;
cyposarr[6]=6;

titlea[0] = "What's New <img src=\"icon6.gif\" width=24 height=24></img>";
titlea[1] = "Features <img src=\"icon6.gif\" width=24 height=24></img>";
titlea[2] = "HTML Support <img src=\"icon6.gif\" width=24 height=24></img>";
titlea[3] = "Effects <img src=\"icon6.gif\" width=24 height=24></img>";
titlea[4] = "Useful and Powerful <img src=\"icon6.gif\" width=24 height=24></img>";
titlea[5] = "Samples <img src=\"icon6.gif\" width=24 height=24></img>";
titlea[6] = "Builder Tool Available <img src=\"icon6.gif\" width=24 height=24></img>";

texta[0] = "Dynamic HTML News Scroller was released.";
texta[1] = "Easy building, testing and installation. Full customizable font characteristics. Highlighted URL links.";
texta[2] = "Supports basic HTML tags. (img, javascript, ...)";
texta[3] = "Dynamic HTML News Scroller supports 10 different scrolling-transition effects.";
texta[4] = "Dynamic HTML News Scroller is an extremely powerful and useful text scroller and news ticker solution for your web sites.";
texta[5] = "Please don't forget to check samples of the scroller.";
texta[6] = "Dynamic HTML News Scroller Builder application creates it for you in a few minutes. This easy-to-use tool guides you through the creating process.";

linka[0] = "http://www.news-scroller.com/";
linka[1] = "http://www.news-scroller.com/";
linka[2] = "http://www.news-scroller.com/";
linka[3] = "http://www.news-scroller.com/";
linka[4] = "http://www.news-scroller.com/";
linka[5] = "http://www.news-scroller.com/";
linka[6] = "http://www.news-scroller.com/";

trgfrma[0] = "_parent";
trgfrma[1] = "_parent";
trgfrma[2] = "_parent";
trgfrma[3] = "_parent";
trgfrma[4] = "_parent";
trgfrma[5] = "_parent";
trgfrma[6] = "_parent";

var mc=7;
var inoout=false;
var spage;
var cvar=0,say=0,tpos=0,enson=0,hidsay=0,hidson=0;
var tmpv;
var uzunobj=null;
var uzuntop=0;
var toplay=0;

tmpv=190-8-8-(2*1);
divtextb ="<div id=d";
divtev1=" onmouseover=\"mdivmo(";
divtev2=")\" onmouseout =\"restime(";
divtev3=")\" onclick=\"butclick(";
divtev4=")\"";
divtexts = " style=\"position:absolute;visibility:hidden;width:"+tmpv+"; COLOR: 000000; left:0; top:0; FONT-FAMILY: MS Sans Serif,arial,helvetica; FONT-SIZE: 8pt; FONT-STYLE: normal; FONT-WEIGHT: normal; TEXT-DECORATION: none; margin:0px; LINE-HEIGHT: 12pt; text-align:left;padding:0px;\">";
ns6span= " style=\"position:relative; COLOR: 414A76; width:"+tmpv+"; FONT-FAMILY: verdana,arial,helvetica; FONT-SIZE: 9pt; FONT-STYLE: normal; FONT-WEIGHT: bold; TEXT-DECORATION: none; LINE-HEIGHT: 14pt; text-align:left;padding:0px;\"";
uzun="<div id=\"enuzun\" style=\"position:absolute;left:0;top:0;\">";

function mdivmo(gnum) {
	inoout=true;
	if((linka[gnum].length)>2)	{
		objd=document.getElementById('d'+gnum);
		objd2=document.getElementById('hgd'+gnum);
		objd.style.color="#8E0606";
		objd2.style.color="#B90000";
		objd.style.cursor='pointer';
		objd2.style.cursor='pointer';
		window.status=""+linka[gnum];
	}
}

function restime(gnum2) {
	inoout=false;	
	objd=document.getElementById('d'+gnum2);
	objd2=document.getElementById('hgd'+gnum2);
	objd.style.color="#000000";
	objd2.style.color="#414A76";
	window.status="";
}

function butclick(gnum3) {
	if(linka[gnum3].substring(0,11)=="javascript:"){
		eval(""+linka[gnum3]);
	}
	else {
		if((linka[gnum3].length)>3){
			if((trgfrma[gnum3].indexOf("_parent")>-1)){
				eval("parent.window.location='"+linka[gnum3]+"'");
			}
			else if((trgfrma[gnum3].indexOf("_top")>-1)){
				eval("top.window.location='"+linka[gnum3]+"'");
			}
			else {
				window.open(''+linka[gnum3],''+trgfrma[gnum3]);
			}
		}
	}
}

function dotrans() {
	if(inoout==false) {
		dahayok=false;
		uzuntop--;
		for(i=0;i<mc;i++) {
			objd=document.getElementById('d'+i);
			objd.style.top=""+(uzuntop+(i*115))+"px";
			if((uzuntop+(i*115))==4){
				dahayok=true;
			}
		}
		if(uzuntop<(-1*(mc-1)*115)) {
			objd=document.getElementById('d'+0);
			objd.style.top=""+(uzuntop+(mc*115))+"px";
			if((uzuntop+(i*115))==4){
				dahayok=true;
			}		
		}
		if(uzuntop<(-1*(mc)*115)) {
			uzuntop=0;
		}
	}
	if(dahayok==true) {
		setTimeout('dotrans()',3000);
	}
	else {
		setTimeout('dotrans()',35);
	}
}

function initte2() {
	toplay=4;
	for(i=0;i<mc;i++) {
		objd=document.getElementById('d'+i);
		objd.style.visibility="visible";
		objd.style.top=""+(toplay+(115*i))+"px";
		objd.style.left=""+8+"px";
	}
	uzunobj=document.getElementById('enuzun');
	uzuntop=115;
	dotrans();
}

function initte() {
	i=0;
	innertxt="";
	for(i=0;i<mc;i++) {
		innertxt=innertxt+""+divtextb+""+i+""+divtev1+i+divtev2+i+divtev3+i+divtev4+divtexts+"<div id=\"hgd"+i+"\""+ns6span+">"+titlea[i]+"<br></div>"+texta[i]+"</div>";
	}
	spage=document.getElementById('spagens');
	spage.innerHTML=""+innertxt;
	spage.style.left="0px";
	spage.style.top="0px";
	setTimeout('initte2()',500);
}

window.onload=initte;