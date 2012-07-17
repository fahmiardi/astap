var titlea = new Array();var texta = new Array();var linka = new Array();var trgfrma = new Array();var heightarr = new Array();var cyposarr = new Array();
cyposarr[0]=0;cyposarr[1]=1;cyposarr[2]=2;cyposarr[3]=3;cyposarr[4]=4;cyposarr[5]=5;cyposarr[6]=6;
titlea[0] = "What's New";texta[0] = "Dynamic HTML News Scroller was released.";linka[0] = "http://www.news-scroller.com/";trgfrma[0] = "_parent";titlea[1] = "Features";texta[1] = "Easy building, testing and installation. Full customizable font characteristics. Highlighted URL links.";linka[1] = "http://www.news-scroller.com/";trgfrma[1] = "_parent";titlea[2] = "HTML Support";texta[2] = "Supports basic HTML tags. (img, javascript, ...)";linka[2] = "http://www.news-scroller.com/";trgfrma[2] = "_parent";titlea[3] = "Effects";texta[3] = "Dynamic HTML News Scroller supports 10 different scrolling-transition effects.";linka[3] = "http://www.news-scroller.com/";trgfrma[3] = "_parent";titlea[4] = "Useful and Powerful";texta[4] = "Dynamic HTML News Scroller is an extremely powerful and useful text scroller and news ticker solution for your web sites.";linka[4] = "http://www.news-scroller.com/";trgfrma[4] = "_parent";titlea[5] = "Samples";texta[5] = "Please don't forget to check samples of the scroller.";linka[5] = "http://www.news-scroller.com/";trgfrma[5] = "_parent";titlea[6] = "Builder Tool Available";texta[6] = "Dynamic HTML News Scroller Builder application creates it for you in a few minutes. This easy-to-use tool guides you through the creating process.";linka[6] = "http://www.news-scroller.com/";trgfrma[6] = "_parent";
var mc=7;

var inoout=false;

var spage;
var cvar=0,say=0,tpos=0,enson=0,hidsay=0,hidson=0;
var tmpv;
tmpv=180-8-8-(2*1);

var psy = new Array();
divtextb ="<div id=d";
divtev1=" onmouseover=\"mdivmo(";
divtev2=")\" onmouseout =\"restime(";
divtev3=")\" onclick=\"butclick(";
divtev4=")\"";
divtexts = " style=\"position:absolute;visibility:hidden;width:"+tmpv+"; COLOR: 000000; left:0; top:0; FONT-FAMILY: MS Sans Serif,arial,helvetica; FONT-SIZE: 8pt; FONT-STYLE: normal; FONT-WEIGHT: normal; TEXT-DECORATION: none; margin:0px; LINE-HEIGHT: 12pt; text-align:left;padding:0px;\">";
ns6span= " style=\"position:relative; COLOR: 414A76; width:"+tmpv+"; FONT-FAMILY: verdana,arial,helvetica; FONT-SIZE: 9pt; FONT-STYLE: normal; FONT-WEIGHT: bold; TEXT-DECORATION: none; LINE-HEIGHT: 14pt; text-align:left;padding:0px;\"";

uzun="<div id=\"enuzun\" style=\"position:absolute;left:0;top:0;\">";
var uzunobj=null;
var uzuntop=0;
var toplay=0;

function mdivmo(gnum)
{
	inoout=true;

	if((linka[gnum].length)>2)
	{
		objd=document.getElementById('d'+gnum);
		objd2=document.getElementById('hgd'+gnum);

		objd.style.color="#8E0606";
		objd2.style.color="#B90000";

		objd.style.cursor='pointer';
		objd2.style.cursor='pointer';

		objd.style.textDecoration='none';objd2.style.textDecoration='none';

		window.status=""+linka[gnum];
	}
}

function restime(gnum2)
{
	inoout=false;
	
	objd=document.getElementById('d'+gnum2);
	objd2=document.getElementById('hgd'+gnum2);

	objd.style.color="#000000";
	objd2.style.color="#414A76";

	objd.style.textDecoration='none';objd2.style.textDecoration='none';

	window.status="";
}

function butclick(gnum3)
{
if(linka[gnum3].substring(0,11)=="javascript:"){eval(""+linka[gnum3]);}else{if((linka[gnum3].length)>3){
if((trgfrma[gnum3].indexOf("_parent")>-1)){eval("parent.window.location='"+linka[gnum3]+"'");}else if((trgfrma[gnum3].indexOf("_top")>-1)){eval("top.window.location='"+linka[gnum3]+"'");}else{window.open(''+linka[gnum3],''+trgfrma[gnum3]);}}}

}

function dotrans()
{
	if(inoout==false){

	uzuntop--;
	if(uzuntop<(-1*toplay))
	{
		uzuntop=215;
	}

	uzunobj.style.top=uzuntop+"px";
}
	if(psy[(uzuntop*(-1))+4]==3)
	{
		setTimeout('dotrans()',8000+35);
	}
	else
	{
		setTimeout('dotrans()',35);
	}	
	
}


function initte2()
{
	i=0;
	for(i=0;i<mc;i++)
	{
		objd=document.getElementById('d'+i);
		heightarr[i]=objd.offsetHeight;
	}
	toplay=4;
	for(i=0;i<mc;i++)
	{
		objd=document.getElementById('d'+i);
		objd.style.visibility="visible";
		objd.style.top=""+toplay+"px";
		psy[toplay]=3;
		toplay=toplay+heightarr[i]+10;

	}

	uzunobj=document.getElementById('enuzun');
	uzunobj.style.left=8+"px";
	uzunobj.style.height=toplay+"px";
	uzunobj.style.width=tmpv+"px";
	uzuntop=215;
	dotrans();

}

function initte()
{
	i=0;
	innertxt=""+uzun;

	for(i=0;i<mc;i++)
	{
		innertxt=innertxt+""+divtextb+""+i+""+divtev1+i+divtev2+i+divtev3+i+divtev4+divtexts+"<div id=\"hgd"+i+"\""+ns6span+">"+titlea[i]+"<br></div>"+texta[i]+"</div>";
	}
	innertxt=innertxt+"</div>";
	spage=document.getElementById('spagens');

	spage.innerHTML=""+innertxt;

	spage.style.left="0px";
	spage.style.top="0px";

	setTimeout('initte2()',500);

}


window.onload=initte;