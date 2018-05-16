// JavaScript Document
function docheckall(name,status){
	var objs=document.getElementsByName(name);
	for(i=0;i<objs.length;i++)
		objs[i].checked=status;
	getIDchecked(name);
}
function docheckonce(name){
	var objs=document.getElementsByName(name);
	var flag=true;
	for(i=0;i<objs.length;i++)
		if(objs[i].checked!=true)
		{
			flag=false;
			break;
		}
	document.getElementById("checkall").checked=flag;
	getIDchecked(name);
}
function getIDchecked(name){
	var objs=document.getElementsByName(name);
	var strids="";
	for(i=0;i<objs.length;i++)
		if(objs[i].checked==true)
		{
			strids+=objs[i].value+",";
		}
	document.getElementById("txtids").value=strids;
	activeTr();
}
function activeTr(){
	var Trs=document.getElementsByName("trow");
	for(i=0;i<Trs.length;i++)
	{
		var check=Trs[i].getElementsByTagName("input");
		if(check[0].checked==true)
			Trs[i].className="active";
		else
			Trs[i].className="";
		
	}
}
function dosubmitAction(frmID,action){
	if(document.getElementById("txtaction"))
		document.getElementById("txtaction").value=action;
	if(checkinput()==true)
	{
		if(frmID=="frm_action")
		document.getElementById("cmdsave").click();
		else
		document.frm_menu.submit();
	}
}
function saveOrder(){

    var menuids = document.getElementsByName("menuid"); 
	var orders= document.getElementsByName("txtorder");
    var strids ='';
    var strorder ='';
    
    for (var i=0;i<menuids.length;i++) {
        strids  += menuids[i].value+",";
        strorder  += orders[i].value+",";        
    }
    
    document.getElementById("ids_hidden").value = strids;
    document.getElementById("order_hidden").value = strorder;
    document.frm_list.submit();
    
}
function doSave(frmID,action){
	if(document.getElementById("txtaction"))
		document.getElementById("txtaction").value=action;
	if(checkinput()==true)
	{
		if(frmID=="frm_action")
		document.getElementById("cmdsave").click();
		else
		{
		document.frm_menu.submit();
		}
	}
}

function gotopage(page)
{
	document.getElementById("txtCurnpage").value=page;
	document.frmpaging.submit();
}
function openlink(url)
{
	window.location=url;
}
function onsearch(thisitem,type){
	var str=thisitem.value;
	if(type==0 && str=="")
		thisitem.value="Keyword";
	if(type==1)
		thisitem.value="";
}
function cbo_Selected(id,value)
{
	var obj=document.getElementById(id);
	for(i=0;i<obj.length;i++)
		if(obj[i].value==value)
			obj.selectedIndex=i;
}
function OpenPopup(url){
	myWindow=window.open(url,'_blank','width=750,height=400');
}

function openBox(url)
{
	
	var xmlhttp;
	if (url.length==0)
	  {
	  document.getElementById("shopcart").innerHTML="";
	  return;
	  }
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("shopcart").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET",url,true);
	xmlhttp.send();
}
/*function openBox(fileSrc,winW,winH,scBar,toBar,stBar,t,l){
	var sw = screen.width;
	var sh = screen.height;
	if(winW==null) winW = sw*0.70;
	if(winH==null) winH = sh*0.55;
	if(scBar==null) scBar = 'yes';
	if(toBar==null) toBar = 'no';
	if(stBar==null) stBar = 'yes';
	if(t==null) t = (sh-winH)/2;
	if(l==null) l = (sw-winW)/2;
	var newPar = "width="+winW+",height="+winH;
	newPar += ",scrollbars="+scBar+",toolbar="+toBar;
	newPar += ",status="+stBar+",left="+l+",top="+t;
	window.open(fileSrc,"a",newPar); 
}*/
function add2cart(ItemID)
{
	var xmlhttp;
	if (ItemID.length==0)
	  {
	  document.getElementById("txtHint").innerHTML="";
	  return;
	  }
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","index.php?com=add2cart&ItemID="+ItemID,true);
	xmlhttp.send();
}
function showdate(){
	var mydate=new Date()
	var year = mydate.getYear()
	if (year < 1000)
		year += 1900
	var month = mydate.getMonth() + 1
	if (month < 10)
		month = "0" + month
	var day = mydate.getDate()
	if (day < 10)
		day = "0" + day
	var dayw = mydate.getDay()
	var hour = mydate.getHours()
	if (hour < 10)
		hour = "0" + hour
	var minute=mydate.getMinutes()
	if (minute < 10)
		minute = "0" + minute
	var second=mydate.getSeconds()
	if (second < 10)
		second = "0" + second
	var dayarray=new Array("Chá»§ Nháº­t","Thá»© Hai","Thá»© Ba","Thá»© TÆ°","Thá»© NÄƒm","Thá»© SÃ¡u","Thá»© Báº£y");
	var strtime="<span class=date>"+dayarray[dayw]+", "+day+"/"+month+"/"+year+" "+hour+":"+minute+":"+minute+"</span>"
	document.getElementById("gf-clock").innerHTML=strtime;
	id=setTimeout("showdate()",1000);
}
function clock(){
	var now=new Date();
	var year=now.getFullYear();
	var month=now.getMonth();
	var date=now.getDate();
	var day=now.getDay();
	var hour=now.getHours();
	var minute=now.getMinutes();
	var second=now.getSeconds();
	var montharray=new Array("01","02","03","04","05","06","07","08","09","10","11","12");
	var dayarray=new Array("Chá»§ Nháº­t","Thá»© Hai","Thá»© Ba","Thá»© TÆ°","Thá»© NÄƒm","Thá»© SÃ¡u","Thá»© Báº£y");
	var disptime=dayarray[day]+", "+date+"/"+montharray[month]+"/"+year+" ";
	disptime+=((hour>12) ? hour-12 : hour)+((minute<10)?":0":":")+minute;
	disptime+=((second<10)? ":0":":")+second+((hour>=12) ? " PM" : " AM");
	document.getElementById("datetime").innerHTML=disptime;
	// getElementById(String elementId);
	id=setTimeout("clock()",1000);
}

