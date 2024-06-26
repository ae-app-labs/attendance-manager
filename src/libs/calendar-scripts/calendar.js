/*
 *
 * Copyright (c) 2004-2005 by Zapatec, Inc.
 * http://www.zapatec.com
 * 1700 MLK Way, Berkeley, California,
 * 94709, U.S.A.
 * All rights reserved.
 *
 *
 */
if (!window.Zapatec || (Zapatec && !Zapatec.include)) { alert("You need to include zapatec.js file!"); } else { Zapatec.calendarPath = Zapatec.getPath("Zapatec.CalendarWidget"); } window.calendar = null;		/**< global object that remembers the calendar */ // initialize the preferences object; // embed it in a try/catch so we don't have any surprises try { Zapatec.Calendar.loadPrefs(); } catch(e) {};

Zapatec.Calendar=function(firstDayOfWeek,dateStr,onSelected,onClose){if(typeof this.id=='undefined'){var iId=0;while(Zapatec.Widget.all[iId]){iId++;}
this.id=iId;Zapatec.Widget.all[iId]=this;}
this.bShowHistoryEvent=false;this.activeDiv=null;this.currentDateEl=null;this.getDateStatus=null;this.getDateToolTip=null;this.getDateText=null;this.timeout=null;this.onSelected=onSelected||null;this.onClose=onClose||null;this.onFDOW=null;this.dragging=false;this.hidden=false;this.minYear=1970;this.maxYear=2050;this.minMonth=0;this.maxMonth=11;this.dateFormat=Zapatec.Calendar.i18n("DEF_DATE_FORMAT");this.ttDateFormat=Zapatec.Calendar.i18n("TT_DATE_FORMAT");this.historyDateFormat="%B %d, %Y";this.isPopup=true;this.weekNumbers=true;this.noGrab=false;if(Zapatec.Calendar.prefs.fdow||(Zapatec.Calendar.prefs.fdow==0)){this.firstDayOfWeek=parseInt(Zapatec.Calendar.prefs.fdow,10);}
else{var fd=0;if(typeof firstDayOfWeek=="number"){fd=firstDayOfWeek;}else if(typeof Zapatec.Calendar._FD=='number'){fd=Zapatec.Calendar._FD;}
this.firstDayOfWeek=fd;}
this.showsOtherMonths=false;this.dateStr=dateStr;this.showsTime=false;this.sortOrder="asc";this.time24=true;this.timeInterval=null;this.yearStep=2;this.hiliteToday=true;this.multiple=null;this.table=null;this.element=null;this.tbody=new Array();this.firstdayname=null;this.monthsCombo=null;this.hilitedMonth=null;this.activeMonth=null;this.yearsCombo=null;this.hilitedYear=null;this.activeYear=null;this.histCombo=null;this.hilitedHist=null;this.dateClicked=false;this.numberMonths=1;this.controlMonth=1;this.vertical=false;this.monthsInRow=1;this.titles=new Array();this.rowsOfDayNames=new Array();this.helpButton=true;this.disableFdowClick=true;this.disableDrag=false;this.yearNav=true;this.closeButton=true;Zapatec.Calendar._initSDN();};Zapatec.Calendar._initSDN=function(){if(typeof Zapatec.Calendar._TT._SDN=="undefined"){if(typeof Zapatec.Calendar._TT._SDN_len=="undefined")
Zapatec.Calendar._TT._SDN_len=3;var ar=[];for(var i=8;i>0;){ar[--i]=Zapatec.Calendar._TT._DN[i].substr(0,Zapatec.Calendar._TT._SDN_len);}
Zapatec.Calendar._TT._SDN=ar;if(typeof Zapatec.Calendar._TT._SMN_len=="undefined")
Zapatec.Calendar._TT._SMN_len=3;ar=[];for(var i=12;i>0;){ar[--i]=Zapatec.Calendar._TT._MN[i].substr(0,Zapatec.Calendar._TT._SMN_len);}
Zapatec.Calendar._TT._SMN=ar;}
if(typeof Zapatec.Calendar._TT._AMPM=="undefined"){Zapatec.Calendar._TT._AMPM={am:"am",pm:"pm"};}};Zapatec.Calendar.i18n=function(str,type){var tr='';if(!type){if(Zapatec.Calendar._TT)
tr=Zapatec.Calendar._TT[str];if(!tr&&Zapatec.Calendar._TT_en)
tr=Zapatec.Calendar._TT_en[str];}else switch(type){case"dn":tr=Zapatec.Calendar._TT._DN[str];break;case"sdn":tr=Zapatec.Calendar._TT._SDN[str];break;case"mn":tr=Zapatec.Calendar._TT._MN[str];break;case"smn":tr=Zapatec.Calendar._TT._SMN[str];break;case"ampm":tr=Zapatec.Calendar._TT._AMPM[str];break;}
if(!tr)tr=""+str;return tr;};Zapatec.Calendar._C=null;Zapatec.Calendar.prefs={fdow:null,history:"",sortOrder:"asc",hsize:9};Zapatec.Calendar.savePrefs=function(){Zapatec.Utils.writeCookie("ZP_CAL",Zapatec.Utils.makePref(this.prefs),null,'/',30);};Zapatec.Calendar.loadPrefs=function(){var txt=Zapatec.Utils.getCookie("ZP_CAL"),tmp;if(txt){tmp=Zapatec.Utils.loadPref(txt);if(tmp)
Zapatec.Utils.mergeObjects(this.prefs,tmp);}};Zapatec.Calendar._add_evs=function(el){var C=Zapatec.Calendar;el.onmouseover=C.dayMouseOver;el.onmousedown=C.dayMouseDown;el.onmouseout=C.dayMouseOut;if(Zapatec.is_ie)
el.ondblclick=C.dayMouseDblClick;};Zapatec.Calendar._del_evs=function(el){el.onmouseover=null;el.onmousedown=null;el.onmouseout=null;if(Zapatec.is_ie)
el.ondblclick=null;};Zapatec.Calendar.findMonth=function(el){if(typeof el.month!="undefined"){return el;}else if(el.parentNode&&typeof el.parentNode.month!="undefined"){return el.parentNode;}
return null;};Zapatec.Calendar.findHist=function(el){if(typeof el.histDate!="undefined"){return el;}else if(el.parentNode&&typeof el.parentNode.histDate!="undefined"){return el.parentNode;}
return null;};Zapatec.Calendar.findYear=function(el){if(typeof el.year!="undefined"){return el;}else if(el.parentNode&&typeof el.parentNode.year!="undefined"){return el.parentNode;}
return null;};Zapatec.Calendar.showMonthsCombo=function(){var cal=Zapatec.Calendar._C;if(!cal){return false;}
var cd=cal.activeDiv;var mc=cal.monthsCombo;var date=cal.date,MM=cal.date.getMonth(),YY=cal.date.getFullYear(),min=(YY==cal.minYear),max=(YY==cal.maxYear);for(var i=mc.firstChild;i;i=i.nextSibling){var m=i.month;Zapatec.Utils.removeClass(i,"hilite");Zapatec.Utils.removeClass(i,"active");Zapatec.Utils.removeClass(i,"disabled");i.disabled=false;if((min&&m<cal.minMonth)||(max&&m>cal.maxMonth)){Zapatec.Utils.addClass(i,"disabled");i.disabled=true;}
if(m==MM)
Zapatec.Utils.addClass(cal.activeMonth=i,"active");}
var s=mc.style;s.display="block";if(cd.navtype<0)
s.left=cd.offsetLeft+"px";else{var mcw=mc.offsetWidth;if(typeof mcw=="undefined")
mcw=50;s.left=(cd.offsetLeft+cd.offsetWidth-mcw)+"px";}
s.top=(cd.offsetTop+cd.offsetHeight)+"px";cal.updateWCH(mc);};Zapatec.Calendar.showHistoryCombo=function(){var cal=Zapatec.Calendar._C,a,h,i,cd,hc,s,tmp,div;if(!cal)
return false;hc=cal.histCombo;while(hc.firstChild)
hc.removeChild(hc.lastChild);if(Zapatec.Calendar.prefs.history){a=Zapatec.Calendar.prefs.history.split(/,/);i=0;while(tmp=a[i++]){tmp=tmp.split(/\//);h=Zapatec.Utils.createElement("div");h.className=Zapatec.is_ie?"label-IEfix":"label";h.id="zpCal"+cal.id+"HistoryDropdownItem"+(i-1);h.histDate=new Date(parseInt(tmp[0],10),parseInt(tmp[1],10)-1,parseInt(tmp[2],10),tmp[3]?parseInt(tmp[3],10):0,tmp[4]?parseInt(tmp[4],10):0);h.appendChild(window.document.createTextNode(h.histDate.print(cal.historyDateFormat)));hc.appendChild(h);if(h.histDate.dateEqualsTo(cal.date))
Zapatec.Utils.addClass(h,"active");}}
cd=cal.activeDiv;s=hc.style;s.display="block";s.left=Math.floor(cd.offsetLeft+(cd.offsetWidth-hc.offsetWidth)/2)+"px";s.top=(cd.offsetTop+cd.offsetHeight)+"px";cal.updateWCH(hc);cal.bEventShowHistory=true;};Zapatec.Calendar.showYearsCombo=function(fwd){var cal=Zapatec.Calendar._C;if(!cal){return false;}
var cd=cal.activeDiv;var yc=cal.yearsCombo;if(cal.hilitedYear){Zapatec.Utils.removeClass(cal.hilitedYear,"hilite");}
if(cal.activeYear){Zapatec.Utils.removeClass(cal.activeYear,"active");}
cal.activeYear=null;var Y=cal.date.getFullYear()+(fwd?1:-1);var yr=yc.firstChild;var show=false;for(var i=12;i>0;--i){if(Y>=cal.minYear&&Y<=cal.maxYear){yr.firstChild.data=Y;yr.year=Y;yr.style.display="block";show=true;}else{yr.style.display="none";}
yr=yr.nextSibling;Y+=fwd?cal.yearStep:-cal.yearStep;}
if(show){var s=yc.style;s.display="block";if(cd.navtype<0)
s.left=cd.offsetLeft+"px";else{var ycw=yc.offsetWidth;if(typeof ycw=="undefined")
ycw=50;s.left=(cd.offsetLeft+cd.offsetWidth-ycw)+"px";}
s.top=(cd.offsetTop+cd.offsetHeight)+"px";}
cal.updateWCH(yc);};Zapatec.Calendar.tableMouseUp=function(ev){var cal=Zapatec.Calendar._C;if(!cal){return false;}
if(cal.timeout){clearTimeout(cal.timeout);}
var el=cal.activeDiv;if(!el){return false;}
var target=Zapatec.Utils.getTargetElement(ev);if(typeof(el.navtype)=="undefined"){while(target&&!target.calendar){target=target.parentNode;}}
ev||(ev=window.event);Zapatec.Utils.removeClass(el,"active");if(target==el||target.parentNode==el){Zapatec.Calendar.cellClick(el,ev);}
var mon=Zapatec.Calendar.findMonth(target);var date=null;if(mon){if(!mon.disabled){date=new Date(cal.date);if(mon.month!=date.getMonth()){date.setMonth(mon.month);cal.setDate(date,true);cal.dateClicked=false;cal.callHandler();}}}else{var year=Zapatec.Calendar.findYear(target);if(year){date=new Date(cal.date);if(year.year!=date.getFullYear()){date.setFullYear(year.year);cal.setDate(date,true);cal.dateClicked=false;cal.callHandler();}}else{var hist=Zapatec.Calendar.findHist(target);if(hist&&!hist.histDate.dateEqualsTo(cal.date)){date=new Date(hist.histDate);cal._init(cal.firstDayOfWeek,cal.date=date);cal.dateClicked=false;cal.callHandler();cal.updateHistory();}}}
Zapatec.Utils.removeEvent(window.document,"mouseup",Zapatec.Calendar.tableMouseUp);Zapatec.Utils.removeEvent(window.document,"mouseover",Zapatec.Calendar.tableMouseOver);Zapatec.Utils.removeEvent(window.document,"mousemove",Zapatec.Calendar.tableMouseOver);cal._hideCombos();Zapatec.Calendar._C=null;return Zapatec.Utils.stopEvent(ev);};Zapatec.Calendar.tableMouseOver=function(ev){var cal=Zapatec.Calendar._C;if(!cal){return;}
var el=cal.activeDiv;var target=Zapatec.Utils.getTargetElement(ev);if(target==el||target.parentNode==el){Zapatec.Utils.addClass(el,"hilite active");Zapatec.Utils.addClass(el.parentNode,"rowhilite");}else{if(typeof el.navtype=="undefined"||(el.navtype!=50&&((el.navtype==0&&!cal.histCombo)||Math.abs(el.navtype)>2)))
Zapatec.Utils.removeClass(el,"active");Zapatec.Utils.removeClass(el,"hilite");Zapatec.Utils.removeClass(el.parentNode,"rowhilite");}
ev||(ev=window.event);if(el.navtype==50&&target!=el){var pos=Zapatec.Utils.getAbsolutePos(el);var w=el.offsetWidth;var x=ev.clientX;var dx;var decrease=true;if(x>pos.x+w){dx=x-pos.x-w;decrease=false;}else
dx=pos.x-x;if(dx<0)dx=0;var range=el._range;var current=el._current;var date=cal.currentDate;var pm=(date.getHours()>=12);var old=el.firstChild.data;var count=Math.floor(dx/10)%range.length;for(var i=range.length;--i>=0;)
if(range[i]==current)
break;while(count-->0)
if(decrease){if(--i<0){i=range.length-1;}}else if(++i>=range.length){i=0;}
if(cal.getDateStatus){var minute=null;var hour=null;var new_date=new Date(date);if(el.className.indexOf("ampm",0)!=-1){minute=date.getMinutes();if(old!=range[i]){hour=(range[i]==Zapatec.Calendar.i18n("pm","ampm"))?((date.getHours()==0)?(12):(date.getHours()+12)):(date.getHours()-12);}else{hour=date.getHours();}
new_date.setHours(hour);}
if(el.className.indexOf("hour",0)!=-1){minute=date.getMinutes();hour=(!cal.time24)?((pm)?((range[i]!=12)?(parseInt(range[i],10)+12):(12)):((range[i]!=12)?(range[i]):(0))):(range[i]);new_date.setHours(hour);}
if(el.className.indexOf("minute",0)!=-1){hour=date.getHours();minute=range[i];new_date.setMinutes(minute);}}
var status=false;if(cal.getDateStatus){status=cal.getDateStatus(new_date,date.getFullYear(),date.getMonth(),date.getDate(),parseInt(hour,10),parseInt(minute,10));}
if(status==false){if(!((!cal.time24)&&(range[i]==Zapatec.Calendar.i18n("pm","ampm"))&&(hour>23))){el.firstChild.data=range[i];}}
cal.onUpdateTime();}
var mon=Zapatec.Calendar.findMonth(target);if(mon){if(!mon.disabled){if(mon.month!=cal.date.getMonth()){if(cal.hilitedMonth){Zapatec.Utils.removeClass(cal.hilitedMonth,"hilite");}
Zapatec.Utils.addClass(mon,"hilite");cal.hilitedMonth=mon;}else if(cal.hilitedMonth){Zapatec.Utils.removeClass(cal.hilitedMonth,"hilite");}}}else{if(cal.hilitedMonth){Zapatec.Utils.removeClass(cal.hilitedMonth,"hilite");}
var year=Zapatec.Calendar.findYear(target);if(year){if(year.year!=cal.date.getFullYear()){if(cal.hilitedYear){Zapatec.Utils.removeClass(cal.hilitedYear,"hilite");}
Zapatec.Utils.addClass(year,"hilite");cal.hilitedYear=year;}else if(cal.hilitedYear){Zapatec.Utils.removeClass(cal.hilitedYear,"hilite");}}else{if(cal.hilitedYear){Zapatec.Utils.removeClass(cal.hilitedYear,"hilite");}
var hist=Zapatec.Calendar.findHist(target);if(hist){if(!hist.histDate.dateEqualsTo(cal.date)){if(cal.hilitedHist){Zapatec.Utils.removeClass(cal.hilitedHist,"hilite");}
Zapatec.Utils.addClass(hist,"hilite");cal.hilitedHist=hist;}else if(cal.hilitedHist){Zapatec.Utils.removeClass(cal.hilitedHist,"hilite");}}else if(cal.hilitedHist){Zapatec.Utils.removeClass(cal.hilitedHist,"hilite");}}}
return Zapatec.Utils.stopEvent(ev);};Zapatec.Calendar.tableMouseDown=function(ev){if(Zapatec.Utils.getTargetElement(ev)==Zapatec.Utils.getElement(ev)){return Zapatec.Utils.stopEvent(ev);}};Zapatec.Calendar.calDragIt=function(ev){ev||(ev=window.event);var cal=Zapatec.Calendar._C;if(!cal){Zapatec.Calendar.calDragEnd();}
if(!cal.disableDrag){if(!(cal&&cal.dragging)){return false;}
var posX=ev.clientX+window.document.body.scrollLeft;var posY=ev.clientY+window.document.body.scrollTop;cal.hideShowCovered();var st=cal.element.style,L=posX-cal.xOffs,T=posY-cal.yOffs;st.left=L+"px";st.top=T+"px";Zapatec.Utils.setupWCH(cal.WCH,L,T);}
return Zapatec.Utils.stopEvent(ev);};Zapatec.Calendar.calDragEnd=function(ev){var cal=Zapatec.Calendar._C;Zapatec.Utils.removeEvent(window.document,"mousemove",Zapatec.Calendar.calDragIt);Zapatec.Utils.removeEvent(window.document,"mouseover",Zapatec.Calendar.calDragIt);Zapatec.Utils.removeEvent(window.document,"mouseup",Zapatec.Calendar.calDragEnd);if(!cal){return false;}
cal.dragging=false;Zapatec.Calendar.tableMouseUp(ev);cal.hideShowCovered();};Zapatec.Calendar.dayMouseDown=function(ev){var canDrag=true;var el=Zapatec.Utils.getElement(ev);if(el.className.indexOf("disabled")!=-1||el.className.indexOf("true")!=-1){return false;}
var cal=el.calendar;while(!cal){el=el.parentNode;cal=el.calendar;}
cal.bEventShowHistory=false;cal.activeDiv=el;Zapatec.Calendar._C=cal;if(el.navtype!=300){if(el.navtype==50){if(!((cal.timeInterval==null)||((cal.timeInterval<60)&&(el.className.indexOf("hour",0)!=-1)))){canDrag=false;}
el._current=el.firstChild.data;if(canDrag){Zapatec.Utils.addEvent(window.document,"mousemove",Zapatec.Calendar.tableMouseOver);}}else{if(((el.navtype==201)||(el.navtype==202))&&(cal.timeInterval>30)&&(el.timePart.className.indexOf("minute",0)!=-1)){canDrag=false;}
if(canDrag){Zapatec.Utils.addEvent(window.document,Zapatec.is_ie5?"mousemove":"mouseover",Zapatec.Calendar.tableMouseOver);}}
if(canDrag){Zapatec.Utils.addClass(el,"hilite active");}
Zapatec.Utils.addEvent(window.document,"mouseup",Zapatec.Calendar.tableMouseUp);}else if(cal.isPopup){cal._dragStart(ev);}else{Zapatec.Calendar._C=null;}
if(el.navtype==-1||el.navtype==1){if(cal.timeout)clearTimeout(cal.timeout);cal.timeout=setTimeout("Zapatec.Calendar.showMonthsCombo()",250);}else if(el.navtype==-2||el.navtype==2){if(cal.timeout)clearTimeout(cal.timeout);cal.timeout=setTimeout((el.navtype>0)?"Zapatec.Calendar.showYearsCombo(true)":"Zapatec.Calendar.showYearsCombo(false)",250);}else if(el.navtype==0&&Zapatec.Calendar.prefs.history){if(cal.timeout)clearTimeout(cal.timeout);cal.timeout=setTimeout("Zapatec.Calendar.showHistoryCombo()",250);}else{cal.timeout=null;}
return Zapatec.Utils.stopEvent(ev);};Zapatec.Calendar.dayMouseDblClick=function(ev){Zapatec.Calendar.cellClick(Zapatec.Utils.getElement(ev),ev||window.event);if(Zapatec.is_ie)
window.document.selection.empty();};Zapatec.Calendar.dayMouseOver=function(ev){var el=Zapatec.Utils.getElement(ev),caldate=el.caldate;while(!el.calendar){el=el.parentNode;caldate=el.caldate;}
var cal=el.calendar;var cel=el.timePart;if(caldate){caldate=new Date(caldate[0],caldate[1],caldate[2]);if(caldate.getDate()!=el.caldate[2])caldate.setDate(el.caldate[2]);}
if(Zapatec.Utils.isRelated(el,ev)||Zapatec.Calendar._C||el.className.indexOf("disabled")!=-1||el.className.indexOf("true")!=-1){return false;}
if(el.ttip){if(el.ttip.substr(0,1)=="_"){el.ttip=caldate.print(el.calendar.ttDateFormat)+el.ttip.substr(1);}
el.calendar.showHint(el.ttip);}
if(el.navtype!=300){if(!((cal.timeInterval==null)||(el.className.indexOf("ampm",0)!=-1)||((cal.timeInterval<60)&&(el.className.indexOf("hour",0)!=-1)))&&(el.navtype==50)){return Zapatec.Utils.stopEvent(ev);}
if(((el.navtype==201)||(el.navtype==202))&&(cal.timeInterval>30)&&(cel.className.indexOf("minute",0)!=-1)){return Zapatec.Utils.stopEvent(ev);}
Zapatec.Utils.addClass(el,"hilite");if(caldate){Zapatec.Utils.addClass(el.parentNode,"rowhilite");}}
return Zapatec.Utils.stopEvent(ev);};Zapatec.Calendar.dayMouseOut=function(ev){var el=Zapatec.Utils.getElement(ev);while(!el.calendar){el=el.parentNode;caldate=el.caldate;}
if(Zapatec.Utils.isRelated(el,ev)||Zapatec.Calendar._C||el.className.indexOf("disabled")!=-1||el.className.indexOf("true")!=-1)
return false;Zapatec.Utils.removeClass(el,"hilite");if(el.caldate)
Zapatec.Utils.removeClass(el.parentNode,"rowhilite");if(el.calendar)
el.calendar.showHint(Zapatec.Calendar.i18n("SEL_DATE"));return Zapatec.Utils.stopEvent(ev);};Zapatec.Calendar.cellClick=function(el,ev){var cal=el.calendar;var closing=false;var newdate=false;var date=null;while(!cal){el=el.parentNode;cal=el.calendar;}
if(el.className.indexOf("disabled")!=-1||el.className.indexOf("true")!=-1){return false;}
if(typeof el.navtype=="undefined"){if(cal.currentDateEl){Zapatec.Utils.removeClass(cal.currentDateEl,"selected");Zapatec.Utils.addClass(el,"selected");closing=(cal.currentDateEl==el);if(!closing){cal.currentDateEl=el;}}
var tmpDate=new Date(el.caldate[0],el.caldate[1],el.caldate[2]);if(tmpDate.getDate()!=el.caldate[2]){tmpDate.setDate(el.caldate[2]);}
cal.date.setDateOnly(tmpDate);cal.currentDate.setDateOnly(tmpDate);date=cal.date;cal.dateClicked=true;if(cal.multiple)
cal._toggleMultipleDate(new Date(date));newdate=true;if(el.otherMonth)
cal._init(cal.firstDayOfWeek,date);cal.onSetTime();}else{if(el.navtype==200){Zapatec.Utils.removeClass(el,"hilite");cal.callCloseHandler();return;}
date=new Date(cal.date);if(el.navtype==0&&!cal.bEventShowHistory)
date.setDateOnly(new Date());cal.dateClicked=false;var year=date.getFullYear();var mon=date.getMonth();function setMonth(m){var day=date.getDate();var max=date.getMonthDays(m);if(day>max){date.setDate(max);}
date.setMonth(m);};switch(el.navtype){case 400:Zapatec.Utils.removeClass(el,"hilite");var text=Zapatec.Calendar.i18n("ABOUT");if(typeof text!="undefined"){text+=cal.showsTime?Zapatec.Calendar.i18n("ABOUT_TIME"):"";}else{text="Help and about box text is not translated into this language.\n"+"If you know this language and you feel generous please update\n"+"the corresponding file in \"lang\" subdir to match calendar-en.js\n"+"and send it back to <support@zapatec.com> to get it into the distribution  ;-)\n\n"+"Thank you!\n"+"http://www.zapatec.com\n";}
alert(text);return;case-2:if(year>cal.minYear){date.setFullYear(year-1);}
break;case-1:if(mon>0){setMonth(mon-1);}else if(year-->cal.minYear){date.setFullYear(year);setMonth(11);}
break;case 1:if(mon<11){setMonth(mon+1);}else if(year<cal.maxYear){date.setFullYear(year+1);setMonth(0);}
break;case 2:if(year<cal.maxYear){date.setFullYear(year+1);}
break;case 100:cal.setFirstDayOfWeek(el.fdow);Zapatec.Calendar.prefs.fdow=cal.firstDayOfWeek;Zapatec.Calendar.savePrefs();if(cal.onFDOW)
cal.onFDOW(cal.firstDayOfWeek);return;case 50:var date=cal.currentDate;if(el.className.indexOf("ampm",0)>=0);else
if(!((cal.timeInterval==null)||((cal.timeInterval<60)&&(el.className.indexOf("hour",0)!=-1)))){break;}
var range=el._range;var current=el.firstChild.data;var pm=(date.getHours()>=12);for(var i=range.length;--i>=0;)
if(range[i]==current)
break;if(ev&&ev.shiftKey){if(--i<0){i=range.length-1;}}else if(++i>=range.length){i=0;}
if(cal.getDateStatus){var minute=null;var hour=null;var new_date=new Date(date);if(el.className.indexOf("ampm",0)!=-1){minute=date.getMinutes();hour=(range[i]==Zapatec.Calendar.i18n("pm","ampm"))?((date.getHours()==12)?(date.getHours()):(date.getHours()+12)):(date.getHours()-12);if(cal.getDateStatus&&cal.getDateStatus(new_date,date.getFullYear(),date.getMonth(),date.getDate(),parseInt(hour,10),parseInt(minute,10))){var dirrect;if(range[i]==Zapatec.Calendar.i18n("pm","ampm")){dirrect=-5;}else{dirrect=5;}
hours=hour;minutes=minute;do{minutes+=dirrect;if(minutes>=60){minutes-=60;++hours;if(hours>=24)hours-=24;new_date.setHours(hours);}
if(minutes<0){minutes+=60;--hours;if(hours<0)hours+=24;new_date.setHours(hours);}
new_date.setMinutes(minutes);if(!cal.getDateStatus(new_date,date.getFullYear(),date.getMonth(),date.getDate(),parseInt(hours,10),parseInt(minutes,10))){hour=hours;minute=minutes;if(hour>12)i=1;else i=0;cal.date.setHours(hour);cal.date.setMinutes(minute);cal.onSetTime();}}while((hour!=hours)||(minute!=minutes));}
new_date.setHours(hour);}
if(el.className.indexOf("hour",0)!=-1){minute=date.getMinutes();hour=(!cal.time24)?((pm)?((range[i]!=12)?(parseInt(range[i],10)+12):(12)):((range[i]!=12)?(range[i]):(0))):(range[i]);new_date.setHours(hour);}
if(el.className.indexOf("minute",0)!=-1){hour=date.getHours();minute=range[i];new_date.setMinutes(minute);}}
var status=false;if(cal.getDateStatus){status=cal.getDateStatus(new_date,date.getFullYear(),date.getMonth(),date.getDate(),parseInt(hour,10),parseInt(minute,10));}
if(!status){el.firstChild.data=range[i];}
cal.onUpdateTime();return;case 201:case 202:var cel=el.timePart;var date=cal.currentDate;if((cel.className.indexOf("minute",0)!=-1)&&(cal.timeInterval>30)){break;}
var val=parseInt(cel.firstChild.data,10);var pm=(date.getHours()>=12);var range=cel._range;for(var i=range.length;--i>=0;)
if(val==range[i]){val=i;break;}
var step=cel._step;if(el.navtype==201){val=step*Math.floor(val/step);val+=step;if(val>=range.length)
val=0;}else{val=step*Math.ceil(val/step);val-=step;if(val<0)
val=range.length-step;}
if(cal.getDateStatus){var minute=null;var hour=null;var new_date=new Date(date);if(cel.className=="hour"){minute=date.getMinutes();hour=(!cal.time24)?((pm)?((range[val]!=12)?(parseInt(range[val],10)+12):(12)):((range[val]!=12)?(range[val]):(0))):(range[val]);new_date.setHours(hour);}
if(cel.className=="minute"){hour=date.getHours();minute=val;new_date.setMinutes(range[val]);}}
var status=false;if(cal.getDateStatus){status=cal.getDateStatus(new_date,date.getFullYear(),date.getMonth(),date.getDate(),parseInt(hour,10),parseInt(minute,10));}
if(!status){cel.firstChild.data=range[val];}
cal.onUpdateTime();return;case 0:if(cal.getDateStatus&&((cal.getDateStatus(date,date.getFullYear(),date.getMonth(),date.getDate())==true)||(cal.getDateStatus(date,date.getFullYear(),date.getMonth(),date.getDate())=="disabled"))){return false;}
break;}
if(!date.equalsTo(cal.date)){if((el.navtype>=-2&&el.navtype<=2)&&(el.navtype!=0)){cal._init(cal.firstDayOfWeek,date,true);return;}
cal.setDate(date);newdate=!(el.navtype&&(el.navtype>=-2&&el.navtype<=2));}}
if(newdate){cal.callHandler();}
if(closing){Zapatec.Utils.removeClass(el,"hilite");cal.callCloseHandler();}};Zapatec.Calendar.prototype.create=function(_par){var parent=null;if(!_par){parent=window.document.getElementsByTagName("body")[0];this.isPopup=true;this.WCH=Zapatec.Utils.createWCH();}else{parent=_par;this.isPopup=false;}
this.currentDate=this.date=this.dateStr?new Date(this.dateStr):new Date();var table=Zapatec.Utils.createElement("table");this.table=table;table.cellSpacing=0;table.cellPadding=0;Zapatec.Utils.createProperty(table,"calendar",this);Zapatec.Utils.addEvent(table,"mousedown",Zapatec.Calendar.tableMouseDown);var div=Zapatec.Utils.createElement("div");this.element=div;div.className="calendar";div.id="zpCal"+this.id+"Container";if(Zapatec.is_opera){table.style.width=(this.monthsInRow*((this.weekNumbers)?(8):(7))*2+4.4*this.monthsInRow)+"em";}
if(this.isPopup){div.style.position="absolute";div.style.display="none";}
div.appendChild(table);var cell=null;var row=null;var cal=this;var hh=function(text,cs,navtype,buttonType){cell=Zapatec.Utils.createElement("td",row);if(buttonType){cell.id="zpCal"+cal.id+buttonType+"ButtonStatus";}
cell.colSpan=cs;cell.className="button";if(Math.abs(navtype)<=2)
cell.className+=" nav";Zapatec.Calendar._add_evs(cell);Zapatec.Utils.createProperty(cell,"calendar",cal);cell.navtype=navtype;if(text.substr(0,1)!="&"){cell.appendChild(document.createTextNode(text));}
else{cell.innerHTML=text;}
return cell;};var hd=function(par,colspan,buttonType){cell=Zapatec.Utils.createElement("td",par);if(buttonType){cell.id="zpCal"+cal.id+buttonType+"ButtonStatus";}
cell.colSpan=colspan;cell.className="button";cell.innerHTML="<div>&nbsp</div>";return cell;};var title_length=((this.weekNumbers)?(8):(7))*this.monthsInRow-2;var thead=Zapatec.Utils.createElement("thead",table);if(this.numberMonths==1){this.title=thead;}
row=Zapatec.Utils.createElement("tr",thead);if(this.helpButton){hh("?",1,400,"Help").ttip=Zapatec.Calendar.i18n("INFO");}else{hd(row,1,"Help");}
this.title=hh("&nbsp;",title_length,300);this.title.className="title";this.title.id="zpCal"+this.id+"Title";if(this.isPopup){if(!this.disableDrag){this.title.ttip=Zapatec.Calendar.i18n("DRAG_TO_MOVE");this.title.style.cursor="move";}
if(this.closeButton){hh("&#x00d7;",1,200,"Close").ttip=Zapatec.Calendar.i18n("CLOSE");}else{hd(row,1,"Close");}}else{hd(row,1,"Close");}
row=Zapatec.Utils.createElement("tr",thead);this._nav_py=hh("&#x00ab;",1,-2,"PrevYear");this._nav_py.ttip=Zapatec.Calendar.i18n("PREV_YEAR");this._nav_pm=hh("&#x2039;",1,-1,"PrevMonth");this._nav_pm.ttip=Zapatec.Calendar.i18n("PREV_MONTH");this._nav_now=hh(Zapatec.Calendar.i18n("TODAY"),title_length-2,0,"Today");this._nav_now.ttip=Zapatec.Calendar.i18n("GO_TODAY");this._nav_nm=hh("&#x203a;",1,1,"NextMonth");this._nav_nm.ttip=Zapatec.Calendar.i18n("NEXT_MONTH");this._nav_ny=hh("&#x00bb;",1,2,"NextYear");this._nav_ny.ttip=Zapatec.Calendar.i18n("NEXT_YEAR");var rowsOfMonths=Math.floor(this.numberMonths/this.monthsInRow);if(this.numberMonths%this.monthsInRow>0){++rowsOfMonths;}
for(var l=1;l<=rowsOfMonths;++l){var thead=Zapatec.Utils.createElement("thead",table);if(Zapatec.is_opera){thead.style.display="table-row-group";}
if(this.numberMonths!=1){row=Zapatec.Utils.createElement("tr",thead);var title_length=5;this.weekNumbers&&++title_length;this.titles[l]=new Array();for(var k=1;(k<=this.monthsInRow)&&((l-1)*this.monthsInRow+k<=this.numberMonths);++k){hd(row,1);this.titles[l][k]=hh("&nbsp;",title_length,300);this.titles[l][k].className="title";this.titles[l][k].id="zpCal"+this.id+"SubTitle"+((l-1)*this.monthsInRow+k);hd(row,1);}}
row=Zapatec.Utils.createElement("tr",thead);row.className="daynames";for(k=1;(k<=this.monthsInRow)&&((l-1)*this.monthsInRow+k<=this.numberMonths);++k){if(this.weekNumbers){cell=Zapatec.Utils.createElement("td",row);cell.className="name wn";cell.appendChild(window.document.createTextNode(Zapatec.Calendar.i18n("WK")));if(k>1){Zapatec.Utils.addClass(cell,"month-left-border");}
var cal_wk=Zapatec.Calendar.i18n("WK")
if(cal_wk==null){cal_wk="";}}
for(var i=7;i>0;--i){cell=Zapatec.Utils.createElement("td",row);cell.appendChild(document.createTextNode("&nbsp;"));cell.id="zpCal"+this.id+"WeekDayButton"+(7-i)+"Status";}}
this.firstdayname=row.childNodes[this.weekNumbers?1:0];this.rowsOfDayNames[l]=this.firstdayname;this._displayWeekdays();var tbody=Zapatec.Utils.createElement("tbody",table);this.tbody[l]=tbody;for(i=6;i>0;--i){row=Zapatec.Utils.createElement("tr",tbody);for(k=1;(k<=this.monthsInRow)&&((l-1)*this.monthsInRow+k<=this.numberMonths);++k){if(this.weekNumbers){cell=Zapatec.Utils.createElement("td",row);cell.id="zpCal"+this.id+"WeekNumber"+(6-i);cell.appendChild(document.createTextNode("&nbsp;"));}
for(var j=7;j>0;--j){cell=Zapatec.Utils.createElement("td",row);cell.id="zpCal"+this.id+"DateCell"+((l-1)*this.monthsInRow+k)+"-"+(6-i)+"-"+(7-j);cell.appendChild(document.createTextNode("&nbsp;"));Zapatec.Utils.createProperty(cell,"calendar",this);Zapatec.Calendar._add_evs(cell);}}}}
var tfoot=Zapatec.Utils.createElement("tfoot",table);if(this.showsTime){row=Zapatec.Utils.createElement("tr",tfoot);row.className="time";var emptyColspan;if(this.monthsInRow!=1){cell=Zapatec.Utils.createElement("td",row);emptyColspan=cell.colSpan=Math.ceil((((this.weekNumbers)?8:7)*(this.monthsInRow-1))/2);cell.className="timetext";cell.innerHTML="&nbsp";}
cell=Zapatec.Utils.createElement("td",row);cell.className="timetext";cell.colSpan=this.weekNumbers?2:1;cell.innerHTML=Zapatec.Calendar.i18n("TIME")||"&nbsp;";(function(){function makeTimePart(className,partId,init,range_start,range_end){var table,tbody,tr,tr2,part;if(range_end){cell=Zapatec.Utils.createElement("td",row);cell.colSpan=1;if(cal.showsTime!="seconds"){++cell.colSpan;}
cell.className="parent-"+className;table=Zapatec.Utils.createElement("table",cell);table.cellSpacing=table.cellPadding=0;if(className=="hour")
table.align="right";table.className="calendar-time-scroller";tbody=Zapatec.Utils.createElement("tbody",table);tr=Zapatec.Utils.createElement("tr",tbody);tr2=Zapatec.Utils.createElement("tr",tbody);}else
tr=row;part=Zapatec.Utils.createElement("td",tr);part.className=className;part.id="zpTime"+cal.id+partId+"SelectStatus";part.appendChild(window.document.createTextNode(init));Zapatec.Utils.createProperty(part,"calendar",cal);part.ttip=Zapatec.Calendar.i18n("TIME_PART");part.navtype=50;part._range=[];if(!range_end)
part._range=range_start;else{part.rowSpan=2;for(var i=range_start;i<=range_end;++i){var txt;if(i<10&&range_end>=10)txt='0'+i;else txt=''+i;part._range[part._range.length]=txt;}
var up=Zapatec.Utils.createElement("td",tr);up.className="up";up.navtype=201;up.id="zpTime"+cal.id+partId+"UpButtonStatus";Zapatec.Utils.createProperty(up,"calendar",cal);up.timePart=part;if(Zapatec.is_khtml)
up.innerHTML="&nbsp;";Zapatec.Calendar._add_evs(up);var down=Zapatec.Utils.createElement("td",tr2);down.className="down";down.navtype=202;down.id="zpTime"+cal.id+partId+"DownButtonStatus";Zapatec.Utils.createProperty(down,"calendar",cal);down.timePart=part;if(Zapatec.is_khtml)
down.innerHTML="&nbsp;";Zapatec.Calendar._add_evs(down);}
Zapatec.Calendar._add_evs(part);return part;};var hrs=cal.currentDate.getHours();var mins=cal.currentDate.getMinutes();if(cal.showsTime=="seconds"){var secs=cal.currentDate.getSeconds();}
var t12=!cal.time24;var pm=(hrs>12);if(t12&&pm)hrs-=12;var H=makeTimePart("hour","Hours",hrs,t12?1:0,t12?12:23);H._step=(cal.timeInterval>30)?(cal.timeInterval/60):1;cell=Zapatec.Utils.createElement("td",row);cell.innerHTML=":";cell.className="colon";var M=makeTimePart("minute","Minutes",mins,0,59);M._step=((cal.timeInterval)&&(cal.timeInterval<60))?(cal.timeInterval):5;if(cal.showsTime=="seconds"){cell=Zapatec.Utils.createElement("td",row);cell.innerHTML=":";cell.className="colon";var S=makeTimePart("minute","Seconds",secs,0,59);S._step=5;}
var AP=null;if(t12){AP=makeTimePart("ampm","AMPM",pm?Zapatec.Calendar.i18n("pm","ampm"):Zapatec.Calendar.i18n("am","ampm"),[Zapatec.Calendar.i18n("am","ampm"),Zapatec.Calendar.i18n("pm","ampm")]);AP.className+=" button";}else
Zapatec.Utils.createElement("td",row).innerHTML="&nbsp;";cal.onSetTime=function(){var hrs=this.currentDate.getHours();var mins=this.currentDate.getMinutes();if(this.showsTime=="seconds"){var secs=cal.currentDate.getSeconds();}
if(this.timeInterval){mins+=this.timeInterval-((mins-1+this.timeInterval)%this.timeInterval)-1;}
while(mins>=60){mins-=60;++hrs;}
if(this.timeInterval>60){var interval=this.timeInterval/60;if(hrs%interval!=0){hrs+=interval-((hrs-1+interval)%interval)-1;}
if(hrs>=24){hrs-=24;}}
var new_date=new Date(this.currentDate);if(this.getDateStatus&&this.getDateStatus(this.currentDate,this.currentDate.getFullYear(),this.currentDate.getMonth(),this.currentDate.getDate(),hrs,mins)){hours=hrs;minutes=mins;do{if(this.timeInterval){if(this.timeInterval<60){minutes+=this.timeInterval;}else{hrs+=this.timeInterval/60;}}else{minutes+=5;}
if(minutes>=60){minutes-=60;hours+=1;}
if(hours>=24){hours-=24;}
new_date.setMinutes(minutes);new_date.setHours(hours);if(!this.getDateStatus(new_date,this.currentDate.getFullYear(),this.currentDate.getMonth(),this.currentDate.getDate(),hours,minutes)){hrs=hours;mins=minutes;}}while((hrs!=hours)||(mins!=minutes));}
this.currentDate.setMinutes(mins);this.currentDate.setHours(hrs);var pm=(hrs>=12);if(pm&&t12&&hrs!=12)hrs-=12;if(!pm&&t12&&hrs==0)hrs=12;H.firstChild.data=(hrs<10)?("0"+hrs):hrs;M.firstChild.data=(mins<10)?("0"+mins):mins;if(this.showsTime=="seconds"){S.firstChild.data=(secs<10)?("0"+secs):secs;}
if(t12)
AP.firstChild.data=pm?Zapatec.Calendar.i18n("pm","ampm"):Zapatec.Calendar.i18n("am","ampm");};cal.onUpdateTime=function(){var date=this.currentDate;var h=parseInt(H.firstChild.data,10);if(t12){if(/pm/i.test(AP.firstChild.data)&&h<12)
h+=12;else if(/am/i.test(AP.firstChild.data)&&h==12)
h=0;}
var d=date.getDate();var m=date.getMonth();var y=date.getFullYear();date.setHours(h);date.setMinutes(parseInt(M.firstChild.data,10));if(this.showsTime=="seconds"){date.setSeconds(parseInt(S.firstChild.data,10));}
date.setFullYear(y);date.setMonth(m);date.setDate(d);this.dateClicked=false;this.callHandler();};})();if(this.monthsInRow!=1){cell=Zapatec.Utils.createElement("td",row);cell.colSpan=((this.weekNumbers)?8:7)*(this.monthsInRow-1)-Math.ceil(emptyColspan);cell.className="timetext";cell.innerHTML="&nbsp";}}else{this.onSetTime=this.onUpdateTime=function(){};}
row=Zapatec.Utils.createElement("tr",tfoot);row.className="footrow";cell=hh(Zapatec.Calendar.i18n("SEL_DATE"),this.weekNumbers?(8*this.numberMonths):(7*this.numberMonths),300);cell.className="ttip";cell.id="zpCal"+this.id+"Status";if(this.isPopup&&!this.disableDrag){cell.ttip=Zapatec.Calendar.i18n("DRAG_TO_MOVE");cell.style.cursor="move";}
this.tooltips=cell;div=this.monthsCombo=Zapatec.Utils.createElement("div",this.element);div.className="combo";div.id="zpCal"+this.id+"MonthDropdownCombo";for(i=0;i<12;++i){var mn=Zapatec.Utils.createElement("div");mn.className=Zapatec.is_ie?"label-IEfix":"label";mn.id="zpCal"+this.id+"MonthDropdownItem"+i;mn.month=i;mn.appendChild(window.document.createTextNode(Zapatec.Calendar.i18n(i,"smn")));div.appendChild(mn);}
div=this.yearsCombo=Zapatec.Utils.createElement("div",this.element);div.className="combo";div.id="zpCal"+this.id+"YearDropdownCombo";for(i=0;i<12;++i){var yr=Zapatec.Utils.createElement("div");yr.className=Zapatec.is_ie?"label-IEfix":"label";yr.id="zpCal"+this.id+"YearDropdownItem"+i;yr.appendChild(window.document.createTextNode("&nbsp;"));div.appendChild(yr);}
div=this.histCombo=Zapatec.Utils.createElement("div",this.element);div.id="zpCal"+this.id+"HistoryDropdownCombo";div.className="combo history";this._init(this.firstDayOfWeek,this.date);parent.appendChild(this.element);};Zapatec.Calendar._keyEvent=function(ev){if(!window.calendar){return false;}
(Zapatec.is_ie)&&(ev=window.event);var cal=window.calendar;var act=(Zapatec.is_ie||ev.type=="keypress");var K=ev.keyCode;var date=new Date(cal.date);if(ev.ctrlKey){switch(K){case 37:act&&Zapatec.Calendar.cellClick(cal._nav_pm);break;case 38:act&&Zapatec.Calendar.cellClick(cal._nav_py);break;case 39:act&&Zapatec.Calendar.cellClick(cal._nav_nm);break;case 40:act&&Zapatec.Calendar.cellClick(cal._nav_ny);break;default:return false;}}else switch(K){case 32:Zapatec.Calendar.cellClick(cal._nav_now);break;case 27:act&&cal.callCloseHandler();break;case 37:if(act&&!cal.multiple){date.setTime(date.getTime()-86400000);cal.setDate(date);}
break;case 38:if(act&&!cal.multiple){date.setTime(date.getTime()-7*86400000);cal.setDate(date);}
break;case 39:if(act&&!cal.multiple){date.setTime(date.getTime()+86400000);cal.setDate(date);}
break;case 40:if(act&&!cal.multiple){date.setTime(date.getTime()+7*86400000);cal.setDate(date);}
break;case 13:if(act){Zapatec.Calendar.cellClick(cal.currentDateEl);}
break;default:return false;}
return Zapatec.Utils.stopEvent(ev);};Zapatec.Calendar.prototype._init=function(firstDayOfWeek,date,last){var
today=new Date(),TD=today.getDate(),TY=today.getFullYear(),TM=today.getMonth();if(this.getDateStatus&&!last){var status=this.getDateStatus(date,date.getFullYear(),date.getMonth(),date.getDate());var backupDate=new Date(date);while(((status==true)||(status=="disabled"))&&(backupDate.getMonth()==date.getMonth())){date.setTime(date.getTime()+86400000);var status=this.getDateStatus(date,date.getFullYear(),date.getMonth(),date.getDate());}
if(backupDate.getMonth()!=date.getMonth()){date=new Date(backupDate);while(((status==true)||(status=="disabled"))&&(backupDate.getMonth()==date.getMonth())){date.setTime(date.getTime()-86400000);var status=this.getDateStatus(date,date.getFullYear(),date.getMonth(),date.getDate());}}
if(backupDate.getMonth()!=date.getMonth()){last=true;date=new Date(backupDate);}}
var year=date.getFullYear();var month=date.getMonth();var rowsOfMonths=Math.floor(this.numberMonths/this.monthsInRow);var minMonth;var diffMonth,last_row,before_control;if(!this.vertical){diffMonth=(this.controlMonth-1);minMonth=month-diffMonth;}else{last_row=((this.numberMonths-1)%this.monthsInRow)+1;before_control=(this.controlMonth-1)%this.monthsInRow;bottom=(before_control>=(last_row)?(last_row):(before_control));diffMonth=(before_control)*(rowsOfMonths-1)+Math.floor((this.controlMonth-1)/this.monthsInRow)+bottom;minMonth=month-diffMonth;}
var minYear=year;if(minMonth<0){minMonth+=12;--minYear;}
var maxMonth=minMonth+this.numberMonths-1;var maxYear=minYear;if(maxMonth>11){maxMonth-=12;++maxYear;}
function disableControl(ctrl){Zapatec.Calendar._del_evs(ctrl);ctrl.disabled=true;ctrl.className="button";ctrl.innerHTML="<div>&nbsp</div>";}
function enableControl(ctrl,sign){Zapatec.Calendar._add_evs(ctrl);ctrl.disabled=false;ctrl.className="button nav";ctrl.innerHTML=sign;}
if((minYear<=this.minYear)||!this.yearNav){if(!this._nav_py.disabled){disableControl(this._nav_py);}}else{if(this._nav_py.disabled){enableControl(this._nav_py,"&#x00ab;");}}
if(maxYear>=this.maxYear||!this.yearNav){if(!this._nav_ny.disabled){disableControl(this._nav_ny);}}else{if(this._nav_ny.disabled){enableControl(this._nav_ny,"&#x00bb;");}}
if(((minYear==this.minYear)&&(minMonth<=this.minMonth))||(minYear<this.minYear)){if(!this._nav_pm.disabled){disableControl(this._nav_pm);}}else{if(this._nav_pm.disabled){enableControl(this._nav_pm,"&#x2039;");}}
if(((maxYear==this.maxYear)&&(maxMonth>=this.maxMonth))||(maxYear>this.maxYear)){if(!this._nav_nm.disabled){disableControl(this._nav_nm);}}else{if(this._nav_nm.disabled){enableControl(this._nav_nm,"&#x203a;");}}
upperMonth=this.maxMonth+1;upperYear=this.maxYear;if(upperMonth>11){upperMonth-=12;++upperYear;}
bottomMonth=this.minMonth-1;bottomYear=this.minYear;if(bottomMonth<0){bottomMonth+=12;--bottomYear;}
maxDate1=new Date(maxYear,maxMonth,date.getMonthDays(maxMonth),23,59,59,999);maxDate2=new Date(upperYear,upperMonth,1,0,0,0,0);minDate1=new Date(minYear,minMonth,1,0,0,0,0);minDate2=new Date(bottomYear,bottomMonth,date.getMonthDays(bottomMonth),23,59,59,999);if(maxDate1.getTime()>maxDate2.getTime()){date.setTime(date.getTime()-(maxDate1.getTime()-maxDate2.getTime()));}
if(minDate1.getTime()<minDate2.getTime()){date.setTime(date.getTime()+(minDate2.getTime()-minDate1.getTime())+1);}
delete maxDate1;delete maxDate2;delete minDate1;delete minDate2;this.firstDayOfWeek=firstDayOfWeek;if(!last){this.currentDate=date;}
this.date=date;(this.date=new Date(this.date)).setDateOnly(date);year=this.date.getFullYear();month=this.date.getMonth();var initMonth=date.getMonth();var mday=this.date.getDate();var no_days=date.getMonthDays();var months=new Array();if(this.numberMonths%this.monthsInRow>0){++rowsOfMonths;}
for(var l=1;l<=rowsOfMonths;++l){months[l]=new Array();for(var k=1;(k<=this.monthsInRow)&&((l-1)*this.monthsInRow+k<=this.numberMonths);++k){var tmpDate=new Date(date);if(this.vertical){var validMonth=date.getMonth()-diffMonth+((k-1)*(rowsOfMonths-1)+(l-1)+((last_row<k)?(last_row):(k-1)));}else{var validMonth=date.getMonth()-diffMonth+(l-1)*this.monthsInRow+k-1;}
if(validMonth<0){tmpDate.setFullYear(tmpDate.getFullYear()-1);validMonth=12+validMonth;}
if(validMonth>11){tmpDate.setFullYear(tmpDate.getFullYear()+1);validMonth=validMonth-12;}
tmpDate.setDate(1);tmpDate.setMonth(validMonth);var day1=(tmpDate.getDay()-this.firstDayOfWeek)%7;if(day1<0)
day1+=7;var hrs=tmpDate.getHours();tmpDate.setDate(-day1);tmpDate.setDate(tmpDate.getDate()+1);if(hrs!=tmpDate.getHours()){tmpDate.setDate(1);tmpDate.setMonth(validMonth);tmpDate.setDate(-day1);tmpDate.setDate(tmpDate.getDate()+1);}
months[l][k]=tmpDate;}}
var MN=Zapatec.Calendar.i18n(month,"smn");var weekend=Zapatec.Calendar.i18n("WEEKEND");var dates=this.multiple?(this.datesCells={}):null;var DATETXT=this.getDateText;for(var l=1;l<=rowsOfMonths;++l){var row=this.tbody[l].firstChild;for(var i=7;--i>0;row=row.nextSibling){var cell=row.firstChild;var hasdays=false;for(var k=1;(k<=this.monthsInRow)&&((l-1)*this.monthsInRow+k<=this.numberMonths);++k){date=months[l][k];if(this.weekNumbers){cell.className=" day wn";cell.innerHTML=date.getWeekNumber();if(k>1){Zapatec.Utils.addClass(cell,"month-left-border");}
cell=cell.nextSibling;}
row.className="daysrow";row.id="zpCal"+this.id+"Daysrow"+(6-i);var iday;for(j=7;cell&&(iday=date.getDate())&&(j>0);date.setDate(iday+1),((date.getDate()==iday)?(date.setHours(1)&&date.setDate(iday+1)):(false)),cell=cell.nextSibling,--j){var
wday=date.getDay(),dmonth=date.getMonth(),dyear=date.getFullYear();cell.className=" day";if((!this.weekNumbers)&&(j==7)&&(k!=1)){Zapatec.Utils.addClass(cell,"month-left-border");}
if((j==1)&&(k!=this.monthsInRow)){Zapatec.Utils.addClass(cell,"month-right-border");}
if(this.vertical){validMonth=initMonth-diffMonth+((k-1)*(rowsOfMonths-1)+(l-1)+((last_row<k)?(last_row):(k-1)));}else{validMonth=initMonth-diffMonth+((l-1)*this.monthsInRow+k-1);}
if(validMonth<0){validMonth=12+validMonth;}
if(validMonth>11){validMonth=validMonth-12;}
var current_month=!(cell.otherMonth=!(dmonth==validMonth));if(!current_month){if(this.showsOtherMonths)
cell.className+=" othermonth";else{cell.className+=" true";cell.innerHTML="<div>&nbsp;</div>";continue;}}else
hasdays=true;cell.innerHTML=DATETXT?DATETXT(date,dyear,dmonth,iday):iday;dates&&(dates[date.print("%Y%m%d")]=cell);if(this.getDateStatus){var status=this.getDateStatus(date,dyear,dmonth,iday);if(this.getDateToolTip){var toolTip=this.getDateToolTip(date,dyear,dmonth,iday);if(toolTip)
cell.title=toolTip;}
if(status==true){cell.className+=" disabled";}else{cell.className+=" "+status;}}
if(!cell.disabled){cell.caldate=[dyear,dmonth,iday];cell.ttip="_";if(!this.multiple&&current_month&&iday==this.currentDate.getDate()&&this.hiliteToday&&(dmonth==this.currentDate.getMonth())&&(dyear==this.currentDate.getFullYear())){cell.className+=" selected";this.currentDateEl=cell;}
if(dyear==TY&&dmonth==TM&&iday==TD){cell.className+=" today";cell.ttip+=Zapatec.Calendar.i18n("PART_TODAY");}
if((weekend!=null)&&(weekend.indexOf(wday.toString())!=-1)){cell.className+=cell.otherMonth?" oweekend":" weekend";}}}
if(!(hasdays||this.showsOtherMonths))
row.className="emptyrow";}
if((i==1)&&(l<rowsOfMonths)){if(row.className=="emptyrow"){row=row.previousSibling;}
cell=row.firstChild;while(cell!=null){Zapatec.Utils.addClass(cell,"month-bottom-border");cell=cell.nextSibling;}}}}
if(this.numberMonths==1){this.title.innerHTML=Zapatec.Calendar.i18n(month,"mn")+", "+year;if(this.params&&this.params.titleHtml)
if(typeof this.params.titleHtml=='function')
this.title.innerHTML=this.params.titleHtml(this.title.innerHTML,month,year)
else
this.title.innerHTML+=this.params.titleHtml}else{if(this.params&&this.params.titleHtml)
if(typeof this.params.titleHtml=='function')
this.title.innerHTML=this.params.titleHtml(Zapatec.Calendar.i18n(month,"mn")+", "+year,month,year)
else
this.title.innerHTML=this.params.titleHtml
for(var l=1;l<=rowsOfMonths;++l){for(var k=1;(k<=this.monthsInRow)&&((l-1)*this.monthsInRow+k<=this.numberMonths);++k){if(this.vertical){validMonth=month-diffMonth+((k-1)*(rowsOfMonths-1)+(l-1)+((last_row<k)?(last_row):(k-1)));}else{validMonth=month-diffMonth+(l-1)*this.monthsInRow+k-1;}
validYear=year;if(validMonth<0){--validYear;validMonth=12+validMonth;}
if(validMonth>11){++validYear;validMonth=validMonth-12;}
this.titles[l][k].innerHTML=Zapatec.Calendar.i18n(validMonth,"mn")+", "+validYear;}}}
this.onSetTime();this._initMultipleDates();this.updateWCH();};Zapatec.Calendar.prototype._initMultipleDates=function(){if(this.multiple){for(var i in this.multiple){var cell=this.datesCells[i];var d=this.multiple[i];if(!d)
continue;if(cell)
cell.className+=" selected";}}};Zapatec.Calendar.prototype._toggleMultipleDate=function(date){if(this.multiple){var ds=date.print("%Y%m%d");var cell=this.datesCells[ds];if(cell){var d=this.multiple[ds];if(!d){Zapatec.Utils.addClass(cell,"selected");this.multiple[ds]=date;}else{Zapatec.Utils.removeClass(cell,"selected");delete this.multiple[ds];}}}};Zapatec.Calendar.prototype.setDateToolTipHandler=function(unaryFunction){this.getDateToolTip=unaryFunction;};Zapatec.Calendar.prototype.setDate=function(date,justInit){if(!date)
date=new Date();if(!date.equalsTo(this.date)){var year=date.getFullYear(),m=date.getMonth();if(year<this.minYear||(year==this.minYear&&m<this.minMonth))
this.showHint("<div class='error'>"+Zapatec.Calendar.i18n("E_RANGE")+" ���</div>");else if(year>this.maxYear||(year==this.maxYear&&m>this.maxMonth))
this.showHint("<div class='error'>��� "+Zapatec.Calendar.i18n("E_RANGE")+"</div>");this._init(this.firstDayOfWeek,date,justInit);}};Zapatec.Calendar.prototype.showHint=function(text){this.tooltips.innerHTML=text;};Zapatec.Calendar.prototype.reinit=function(){this._init(this.firstDayOfWeek,this.date);};Zapatec.Calendar.prototype.refresh=function(){var p=this.isPopup?null:this.element.parentNode;var x=parseInt(this.element.style.left);var y=parseInt(this.element.style.top);this.destroy();this.dateStr=this.date;this.create(p);if(this.isPopup)
this.showAt(x,y);else
this.show();};Zapatec.Calendar.prototype.setFirstDayOfWeek=function(firstDayOfWeek){if(this.firstDayOfWeek!=firstDayOfWeek){this._init(firstDayOfWeek,this.date);var rowsOfMonths=Math.floor(this.numberMonths/this.monthsInRow);if(this.numberMonths%this.monthsInRow>0){++rowsOfMonths;}
for(var l=1;l<=rowsOfMonths;++l){this.firstdayname=this.rowsOfDayNames[l];this._displayWeekdays();}}};Zapatec.Calendar.prototype.setDateStatusHandler=Zapatec.Calendar.prototype.setDisabledHandler=function(unaryFunction){this.getDateStatus=unaryFunction;};Zapatec.Calendar.prototype.setRange=function(A,Z){var m,a=Math.min(A,Z),z=Math.max(A,Z);this.minYear=m=Math.floor(a);this.minMonth=(m==a)?0:Math.ceil((a-m)*100-1);this.maxYear=m=Math.floor(z);this.maxMonth=(m==z)?11:Math.ceil((z-m)*100-1);};Zapatec.Calendar.prototype.setMultipleDates=function(multiple){if(!multiple||typeof multiple=="undefined")return;this.multiple={};for(var i=multiple.length;--i>=0;){var d=multiple[i];var ds=d.print("%Y%m%d");this.multiple[ds]=d;}};Zapatec.Calendar.prototype.submitFlatDates=function()
{if(typeof this.params.flatCallback=="function"){Zapatec.Utils.sortOrder=(this.sortOrder!="asc"&&this.sortOrder!="desc"&&this.sortOrder!="none")?"none":this.sortOrder;if(this.multiple&&(Zapatec.Utils.sortOrder!="none")){var dateArray=new Array();for(var i in this.multiple){var currentDate=this.multiple[i];if(currentDate){dateArray[dateArray.length]=currentDate;}
dateArray.sort(Zapatec.Utils.compareDates);}
this.multiple={};for(var i=0;i<dateArray.length;i++){var d=dateArray[i];var ds=d.print("%Y%m%d");this.multiple[ds]=d;}}
this.params.flatCallback(this);}}
Zapatec.Calendar.prototype.callHandler=function(){if(this.onSelected){this.onSelected(this,this.date.print(this.dateFormat));}};Zapatec.Calendar.prototype.updateHistory=function(){var a,i,d,tmp,s,str="",len=Zapatec.Calendar.prefs.hsize-1;if(Zapatec.Calendar.prefs.history){a=Zapatec.Calendar.prefs.history.split(/,/);i=0;while(i<len&&(tmp=a[i++])){s=tmp.split(/\//);d=new Date(parseInt(s[0],10),parseInt(s[1],10)-1,parseInt(s[2],10),parseInt(s[3],10),parseInt(s[4],10));if(!d.dateEqualsTo(this.date))
str+=","+tmp;}}
Zapatec.Calendar.prefs.history=this.date.print("%Y/%m/%d/%H/%M")+str;Zapatec.Calendar.savePrefs();};Zapatec.Calendar.prototype.callCloseHandler=function(){if(this.dateClicked){this.updateHistory();}
if(this.onClose){this.onClose(this);}
this.hideShowCovered();};Zapatec.Calendar.prototype.destroy=function(){this.hide();Zapatec.Utils.destroy(this.element);Zapatec.Utils.destroy(this.WCH);Zapatec.Calendar._C=null;window.calendar=null;};Zapatec.Calendar.prototype.reparent=function(new_parent){var el=this.element;el.parentNode.removeChild(el);new_parent.appendChild(el);};Zapatec.Calendar._checkCalendar=function(ev){if(!window.calendar){return false;}
var el=Zapatec.is_ie?Zapatec.Utils.getElement(ev):Zapatec.Utils.getTargetElement(ev);for(;el!=null&&el!=calendar.element;el=el.parentNode);if(el==null){window.calendar.callCloseHandler();}};Zapatec.Calendar.prototype.updateWCH=function(other_el){Zapatec.Utils.setupWCH_el(this.WCH,this.element,other_el);};Zapatec.Calendar.prototype.show=function(){var rows=this.table.getElementsByTagName("tr");for(var i=rows.length;i>0;){var row=rows[--i];Zapatec.Utils.removeClass(row,"rowhilite");var cells=row.getElementsByTagName("td");for(var j=cells.length;j>0;){var cell=cells[--j];Zapatec.Utils.removeClass(cell,"hilite");Zapatec.Utils.removeClass(cell,"active");}}
if(this.element.style.display!="block"){this.element.style.display="block";}
this.hidden=false;if(this.isPopup){this.updateWCH();window.calendar=this;if(!this.noGrab){Zapatec.Utils.addEvent(window.document,"keydown",Zapatec.Calendar._keyEvent);Zapatec.Utils.addEvent(window.document,"keypress",Zapatec.Calendar._keyEvent);Zapatec.Utils.addEvent(window.document,"mousedown",Zapatec.Calendar._checkCalendar);}}
this.hideShowCovered();};Zapatec.Calendar.prototype.hide=function(){if(this.isPopup){Zapatec.Utils.removeEvent(window.document,"keydown",Zapatec.Calendar._keyEvent);Zapatec.Utils.removeEvent(window.document,"keypress",Zapatec.Calendar._keyEvent);Zapatec.Utils.removeEvent(window.document,"mousedown",Zapatec.Calendar._checkCalendar);}
this.element.style.display="none";Zapatec.Utils.hideWCH(this.WCH);this.hidden=true;this.hideShowCovered();};Zapatec.Calendar.prototype.showAt=function(x,y){var s=this.element.style;s.left=x+"px";s.top=y+"px";this.show();};Zapatec.Calendar.prototype.showAtElement=function(el,opts){var self=this;var p=Zapatec.Utils.getElementOffset(el);if(!opts||typeof opts!="string"){this.showAt(p.x,p.y+el.offsetHeight);return true;}
this.element.style.display="block";var w=self.element.offsetWidth;var h=self.element.offsetHeight;self.element.style.display="none";var valign=opts.substr(0,1);var halign="l";if(opts.length>1){halign=opts.substr(1,1);}
switch(valign){case"T":p.y-=h;break;case"B":p.y+=el.offsetHeight;break;case"C":p.y+=(el.offsetHeight-h)/2;break;case"t":p.y+=el.offsetHeight-h;break;case"b":break;}
switch(halign){case"L":p.x-=w;break;case"R":p.x+=el.offsetWidth;break;case"C":p.x+=(el.offsetWidth-w)/2;break;case"l":p.x+=el.offsetWidth-w;break;case"r":break;}
p.width=w;p.height=h;self.monthsCombo.style.display="none";Zapatec.Utils.fixBoxPosition(p,10);self.showAt(p.x,p.y);};Zapatec.Calendar.prototype.setDateFormat=function(str){this.dateFormat=str;};Zapatec.Calendar.prototype.setTtDateFormat=function(str){this.ttDateFormat=str;};Zapatec.Calendar.prototype.parseDate=function(str,fmt){if(!str)
return this.setDate(this.date);if(!fmt)
fmt=this.dateFormat;var date=Date.parseDate(str,fmt);return this.setDate(date);};Zapatec.Calendar.prototype.hideShowCovered=function(){if(!Zapatec.is_ie5)
return;var self=this;function getVisib(obj){var value=obj.style.visibility;if(!value){if(window.document.defaultView&&typeof(window.document.defaultView.getComputedStyle)=="function"){if(!Zapatec.is_khtml)
value=window.document.defaultView.getComputedStyle(obj,"").getPropertyValue("visibility");else
value='';}else if(obj.currentStyle){value=obj.currentStyle.visibility;}else
value='';}
return value;};var tags=["applet","iframe","select"];var el=self.element;var p=Zapatec.Utils.getAbsolutePos(el);var EX1=p.x;var EX2=el.offsetWidth+EX1;var EY1=p.y;var EY2=el.offsetHeight+EY1;for(var k=tags.length;k>0;){var ar=window.document.getElementsByTagName(tags[--k]);var cc=null;for(var i=ar.length;i>0;){cc=ar[--i];p=Zapatec.Utils.getAbsolutePos(cc);var CX1=p.x;var CX2=cc.offsetWidth+CX1;var CY1=p.y;var CY2=cc.offsetHeight+CY1;if(self.hidden||(CX1>EX2)||(CX2<EX1)||(CY1>EY2)||(CY2<EY1)){if(!cc.__msh_save_visibility){cc.__msh_save_visibility=getVisib(cc);}
cc.style.visibility=cc.__msh_save_visibility;}else{if(!cc.__msh_save_visibility){cc.__msh_save_visibility=getVisib(cc);}
cc.style.visibility="hidden";}}}};Zapatec.Calendar.prototype._displayWeekdays=function(){var fdow=this.firstDayOfWeek;var cell=this.firstdayname;var weekend=Zapatec.Calendar.i18n("WEEKEND");for(k=1;(k<=this.monthsInRow)&&(cell);++k){for(var i=0;i<7;++i){cell.className=" day name";if((!this.weekNumbers)&&(i==0)&&(k!=1)){Zapatec.Utils.addClass(cell,"month-left-border");}
if((i==6)&&(k!=this.monthsInRow)){Zapatec.Utils.addClass(cell,"month-right-border");}
var realday=(i+fdow)%7;if((!this.disableFdowClick)&&((this.params&&this.params.fdowClick)||i)){if(Zapatec.Calendar.i18n("DAY_FIRST")!=null){cell.ttip=Zapatec.Calendar.i18n("DAY_FIRST").replace("%s",Zapatec.Calendar.i18n(realday,"dn"));}
cell.navtype=100;cell.calendar=this;cell.fdow=realday;Zapatec.Calendar._add_evs(cell);}
if((weekend!=null)&&(weekend.indexOf(realday.toString())!=-1)){Zapatec.Utils.addClass(cell,"weekend");}
cell.innerHTML=Zapatec.Calendar.i18n((i+fdow)%7,"sdn");cell=cell.nextSibling;}
if(this.weekNumbers&&cell){cell=cell.nextSibling;}}};Zapatec.Utils.compareDates=function(date1,date2)
{if(Zapatec.Calendar.prefs.sortOrder=="asc")
return date1-date2;else
return date2-date1;}
Zapatec.Calendar.prototype._hideCombos=function(){this.monthsCombo.style.display="none";this.yearsCombo.style.display="none";this.histCombo.style.display="none";this.updateWCH();};Zapatec.Calendar.prototype._dragStart=function(ev){ev||(ev=window.event);if(this.dragging){return;}
this.dragging=true;var posX=ev.clientX+window.document.body.scrollLeft;var posY=ev.clientY+window.document.body.scrollTop;var st=this.element.style;this.xOffs=posX-parseInt(st.left);this.yOffs=posY-parseInt(st.top);Zapatec.Utils.addEvent(window.document,"mousemove",Zapatec.Calendar.calDragIt);Zapatec.Utils.addEvent(window.document,"mouseover",Zapatec.Calendar.calDragIt);Zapatec.Utils.addEvent(window.document,"mouseup",Zapatec.Calendar.calDragEnd);};Date._MD=[31,28,31,30,31,30,31,31,30,31,30,31];Date.SECOND=1000;Date.MINUTE=60*Date.SECOND;Date.HOUR=60*Date.MINUTE;Date.DAY=24*Date.HOUR;Date.WEEK=7*Date.DAY;Date.prototype.getMonthDays=function(month){var year=this.getFullYear();if(typeof month=="undefined"){month=this.getMonth();}
if(((0==(year%4))&&((0!=(year%100))||(0==(year%400))))&&month==1){return 29;}else{return Date._MD[month];}};Date.prototype.getDayOfYear=function(){var now=new Date(this.getFullYear(),this.getMonth(),this.getDate(),0,0,0);var then=new Date(this.getFullYear(),0,0,0,0,0);var time=now-then;return Math.round(time/Date.DAY);};Date.prototype.getWeekNumber=function(){var d=new Date(this.getFullYear(),this.getMonth(),this.getDate(),0,0,0);var DoW=d.getDay();d.setDate(d.getDate()-(DoW+6)%7+3);var ms=d.valueOf();d.setMonth(0);d.setDate(4);return Math.round((ms-d.valueOf())/(7*864e5))+1;};Date.prototype.equalsTo=function(date){return((this.getFullYear()==date.getFullYear())&&(this.getMonth()==date.getMonth())&&(this.getDate()==date.getDate())&&(this.getHours()==date.getHours())&&(this.getMinutes()==date.getMinutes()));};Date.prototype.dateEqualsTo=function(date){return((this.getFullYear()==date.getFullYear())&&(this.getMonth()==date.getMonth())&&(this.getDate()==date.getDate()));};Date.prototype.setDateOnly=function(date){var tmp=new Date(date);this.setDate(1);this.setFullYear(tmp.getFullYear());this.setMonth(tmp.getMonth());this.setDate(tmp.getDate());};Date.prototype.print=function(str){var m=this.getMonth();var d=this.getDate();var y=this.getFullYear();var wn=this.getWeekNumber();var w=this.getDay();var s={};var hr=this.getHours();var pm=(hr>=12);var ir=(pm)?(hr-12):hr;var dy=this.getDayOfYear();if(ir==0)
ir=12;var min=this.getMinutes();var sec=this.getSeconds();s["%a"]=Zapatec.Calendar.i18n(w,"sdn");s["%A"]=Zapatec.Calendar.i18n(w,"dn");s["%b"]=Zapatec.Calendar.i18n(m,"smn");s["%B"]=Zapatec.Calendar.i18n(m,"mn");s["%C"]=1+Math.floor(y/100);s["%d"]=(d<10)?("0"+d):d;s["%e"]=d;s["%H"]=(hr<10)?("0"+hr):hr;s["%I"]=(ir<10)?("0"+ir):ir;s["%j"]=(dy<100)?((dy<10)?("00"+dy):("0"+dy)):dy;s["%k"]=hr?hr:"0";s["%l"]=ir;s["%m"]=(m<9)?("0"+(1+m)):(1+m);s["%M"]=(min<10)?("0"+min):min;s["%n"]="\n";s["%p"]=pm?"PM":"AM";s["%P"]=pm?"pm":"am";s["%s"]=Math.floor(this.getTime()/1000);s["%S"]=(sec<10)?("0"+sec):sec;s["%t"]="\t";s["%U"]=s["%W"]=s["%V"]=(wn<10)?("0"+wn):wn;s["%u"]=(w==0)?7:w;s["%w"]=w?w:"0";s["%y"]=''+y%100;if(s["%y"]<10){s["%y"]="0"+s["%y"];}
s["%Y"]=y;s["%%"]="%";var re=/%./g;var a=str.match(re)||[];for(var i=0;i<a.length;i++){var tmp=s[a[i]];if(tmp){re=new RegExp(a[i],'g');str=str.replace(re,tmp);}}
return str;};Date.parseDate=function(str,format){var fmt=format,strPointer=0,token=null,parseFunc=null,valueLength=null,valueRange=null,valueType=null,date=new Date(),values={};var numberRules=["%d","%H","%I","%m","%M","%S","%s","%W","%u","%w","%y","%e","%k","%l","%s","%Y","%C"];function isNumberRule(rule){if(Zapatec.Utils.arrIndexOf(numberRules,rule)!=-1){return true;}
return false;}
function parseString(){for(var iString=valueRange[0];iString<valueRange[1];++iString){var value=Zapatec.Calendar.i18n(iString,valueType);if(!value){return null;}
if(value==str.substr(strPointer,value.length)){valueLength=value.length;return iString;}}
return null;}
function parseNumber(){var val=str.substr(strPointer,valueLength);if(val.length!=valueLength||/$\d+^/.test(val)){return null;}
return parseInt(val,10);}
function parseAMPM(){var result=(str.substr(strPointer,valueLength).toLowerCase()==Zapatec.Calendar.i18n("pm","ampm"))?true:false;return result||((str.substr(strPointer,valueLength).toLowerCase()==Zapatec.Calendar.i18n("am","ampm"))?false:null);}
function parseCharacter(){return"";}
function parseRule(rule){return(values[rule]=parseFunc());}
function wasParsed(rule){if(typeof rule=="undefined"||rule===null){return false;}
return true;}
function getValue(){for(var i=0;i<arguments.length;++i){if(arguments[i]!==null&&typeof arguments[i]!="undefined"&&!isNaN(arguments[i])){return arguments[i];}}
return null;}
if(typeof fmt!="string"||typeof str!="string"||str==""||fmt==""){return null;}
while(fmt){parseFunc=parseNumber;valueLength=fmt.indexOf("%");valueLength=(valueLength==-1)?fmt.length:valueLength;token=fmt.slice(0,valueLength);if(token!=str.substr(strPointer,valueLength)){return null;}
strPointer+=valueLength;fmt=fmt.slice(valueLength);if(fmt==""){break;}
token=fmt.slice(0,2);valueLength=2;switch(token){case"%A":case"%a":{valueType=(token=="%A")?"dn":"sdn";valueRange=[0,7];parseFunc=parseString;break;}
case"%B":case"%b":{valueType=(token=="%B")?"mn":"smn";valueRange=[0,12];parseFunc=parseString;break;}
case"%p":case"%P":{parseFunc=parseAMPM;break;}
case"%Y":{valueLength=4;if(isNumberRule(fmt.substr(2,2))){return null;}
while(isNaN(parseInt(str.charAt(strPointer+valueLength-1)))&&valueLength>0){--valueLength;}
if(valueLength==0){break;}
break;}
case"%C":case"%s":{valueLength=1;if(isNumberRule(fmt.substr(2,2))){return null;}
while(!isNaN(parseInt(str.charAt(strPointer+valueLength)))){++valueLength;}
break;}
case"%k":case"%l":case"%e":{valueLength=1;if(isNumberRule(fmt.substr(2,2))){return null;}
if(!isNaN(parseInt(str.charAt(strPointer+1)))){++valueLength;}
break;}
case"%j":valueLength=3;break;case"%u":case"%w":valueLength=1;case"%y":case"%m":case"%d":case"%W":case"%H":case"%I":case"%M":case"%S":{break;}}
if(parseRule(token)===null){return null;}
strPointer+=valueLength;fmt=fmt.slice(2);}
if(wasParsed(values["%s"])){date.setTime(values["%s"]*1000);}else{var year=getValue(values["%Y"],values["%y"]+--values["%C"]*100,values["%y"]+(date.getFullYear()-date.getFullYear()%100),values["%C"]*100+date.getFullYear()%100);var month=getValue(values["%m"]-1,values["%b"],values["%B"]);var day=getValue(values["%d"]||values["%e"]);if(day===null||month===null){var dayOfWeek=getValue(values["%a"],values["%A"],values["%u"]==7?0:values["%u"],values["%w"]);}
var hour=getValue(values["%H"],values["%k"]);if(hour===null&&(wasParsed(values["%p"])||wasParsed(values["%P"]))){var pm=getValue(values["%p"],values["%P"]);hour=getValue(values["%I"],values["%l"]);hour=pm?((hour==12)?12:(hour+12)):((hour==12)?(0):hour);}
if(year||year===0){date.setFullYear(year);}
if(month||month===0){date.setMonth(month);}
if(day||day===0){date.setDate(day);}
if(wasParsed(values["%j"])){date.setMonth(0);date.setDate(1);date.setDate(values["%j"]);}
if(wasParsed(dayOfWeek)){date.setDate(date.getDate()+(dayOfWeek-date.getDay()));}
if(wasParsed(values["%W"])){var weekNumber=date.getWeekNumber();if(weekNumber!=values["%W"]){date.setDate(date.getDate()+(values["%W"]-weekNumber)*7);}}
if(hour!==null){date.setHours(hour);}
if(wasParsed(values["%M"])){date.setMinutes(values["%M"]);}
if(wasParsed(values["%S"])){date.setSeconds(values["%S"]);}}
if(date.print(format)!=str){return null;}
return date;};Date.prototype.__msh_oldSetFullYear=Date.prototype.setFullYear;Date.prototype.setFullYear=function(y){var d=new Date(this);d.__msh_oldSetFullYear(y);if(d.getMonth()!=this.getMonth())
this.setDate(28);this.__msh_oldSetFullYear(y);};Date.prototype.compareDatesOnly=function(date1,date2){var year1=date1.getYear();var year2=date2.getYear();var month1=date1.getMonth();var month2=date2.getMonth();var day1=date1.getDate();var day2=date2.getDate();if(year1>year2){return-1;}
if(year2>year1){return 1;}
if(month1>month2){return-1;}
if(month2>month1){return 1;}
if(day1>day2){return-1;}
if(day2>day1){return 1;}
return 0;}
Zapatec.Setup=function(){};Zapatec.Setup.test=true;Zapatec.Calendar.setup=function(params){paramsList=["id"];function param_default(pname,def){if(typeof params[pname]=="undefined"){params[pname]=def;}
paramsList.push(pname);};params.id=Zapatec.Utils.generateID("calendar");param_default("inputField",null);param_default("displayArea",null);param_default("button",null);param_default("eventName","click");param_default("closeEventName",null);param_default("ifFormat","%Y/%m/%d");param_default("daFormat","%Y/%m/%d");param_default("singleClick",true);param_default("disableFunc",null);param_default("dateStatusFunc",params["disableFunc"]);param_default("dateText",null);param_default("firstDay",null);param_default("align","Br");param_default("range",[1900,2999]);param_default("weekNumbers",true);param_default("flat",null);param_default("flatCallback",null);param_default("onSelect",null);param_default("onClose",null);param_default("onUpdate",null);param_default("date",null);param_default("showsTime",false);param_default("sortOrder","asc");param_default("timeFormat","24");param_default("timeInterval",null);param_default("electric",true);param_default("step",2);param_default("position",null);param_default("cache",false);param_default("showOthers",false);param_default("multiple",null);param_default("saveDate",null);param_default("fdowClick",false);param_default("titleHtml",null);param_default("noHelp",false);param_default("noCloseButton",false);param_default("disableYearNav",false);param_default("disableFdowChange",false);if(params.weekNumbers){params.disableFdowChange=true;params.firstDay=1;}
param_default("disableDrag",false);param_default("numberMonths",1);if((params.numberMonths>12)||(params.numberMonths<1)){params.numberMonths=1;}
if(params.numberMonths>1){params.showOthers=false;}
params.numberMonths=parseInt(params.numberMonths,10);param_default("controlMonth",1);if((params.controlMonth>params.numberMonths)||(params.controlMonth<1)){params.controlMonth=1;}
params.controlMonth=parseInt(params.controlMonth,10);param_default("vertical",false);if(params.monthsInRow>params.numberMonths){params.monthsInRow=params.numberMonths;}
param_default("monthsInRow",params.numberMonths);params.monthsInRow=parseInt(params.monthsInRow,10);param_default("multiple",false);if(params.multiple){params.singleClick=false;}
param_default("canType",false);var tmp=["inputField","displayArea","button"];for(var i in tmp){if(typeof params[tmp[i]]=="string"){params[tmp[i]]=document.getElementById(params[tmp[i]]);}}
if(!params.inputField){params.canType=false;}else{params.inputField.setAttribute("autocomplete","off");}
if(!(params.flat||params.multiple||params.inputField||params.displayArea||params.button)){alert("Calendar.setup '"+params.id+"':\n  Nothing to setup (no fields found).  Please check your code");return false;}
if(((params.timeInterval)&&((params.timeInterval!==Math.floor(params.timeInterval))||((60%params.timeInterval!==0)&&(params.timeInterval%60!==0))))||(params.timeInterval>360)){alert("'"+params.id+"': timeInterval option can only have the following number of minutes:\n1, 2, 3, 4, 5, 6, 10, 15, 30,  60, 120, 180, 240, 300, 360 ");params.timeInterval=null;}
if(params.date&&!Date.parse(params.date)){alert("'"+params.id+"' Start Date Invalid: "+params.date+".\nSee date option.\nDefaulting to today.");params.date=null;}
if(params.saveDate){param_default("cookiePrefix",window.location.href+"--"+params.button.id);var cookieName=params.cookiePrefix;var newdate=Zapatec.Utils.getCookie(cookieName);if(newdate!=null){document.getElementById(params.inputField.id).value=newdate;}}
for(var ii in params){if(typeof params.constructor.prototype[ii]!="undefined"){continue;}
if(Zapatec.Utils.arrIndexOf(paramsList,ii)==-1){alert("Wrong config option: "+ii);}}
function onSelect(cal){var p=cal.params;var update=(cal.dateClicked||p.electric);if(update&&p.flat){if(typeof p.flatCallback=="function")
{if(!p.multiple)
p.flatCallback(cal);}else
alert("'"+cal.id+"': No flatCallback given -- doing nothing.");return false;}
if(update&&p.inputField){p.inputField.value=cal.currentDate.print(p.ifFormat);if(typeof p.inputField.onchange=="function")
p.inputField.onchange();}
if(update&&p.displayArea)
p.displayArea.innerHTML=cal.currentDate.print(p.daFormat);if(update&&p.singleClick&&cal.dateClicked)
cal.callCloseHandler();if(update&&typeof p.onUpdate=="function")
p.onUpdate(cal);if(p.saveDate){var cookieName=p.cookiePrefix;Zapatec.Utils.writeCookie(cookieName,p.inputField.value,null,'/',p.saveDate);}};if(params.flat!=null){if(typeof params.flat=="string")
params.flat=document.getElementById(params.flat);if(!params.flat){alert("Calendar.setup '"+params.id+"':\n  Flat specified but can't find parent.");return false;}
var cal=new Zapatec.Calendar(params.firstDay,params.date,params.onSelect||onSelect);cal.disableFdowClick=params.disableFdowChange;cal.showsOtherMonths=params.showOthers;cal.showsTime=params.showsTime;cal.time24=(params.timeFormat=="24");cal.timeInterval=params.timeInterval;cal.params=params;cal.weekNumbers=params.weekNumbers;cal.sortOrder=params.sortOrder.toLowerCase();cal.setRange(params.range[0],params.range[1]);cal.setDateStatusHandler(params.dateStatusFunc);cal.getDateText=params.dateText;cal.numberMonths=params.numberMonths;cal.controlMonth=params.controlMonth;cal.vertical=params.vertical;cal.yearStep=params.step;cal.monthsInRow=params.monthsInRow;cal.helpButton=!params.noHelp;cal.closeButton=!params.noCloseButton;cal.yearNav=!params.disableYearNav;if(params.ifFormat){cal.setDateFormat(params.ifFormat);}
if(params.inputField&&params.inputField.type=="text"&&typeof params.inputField.value=="string"){cal.parseDate(params.inputField.value);}
if(params.multiple){cal.setMultipleDates(params.multiple);}
cal.create(params.flat);cal.show();return cal;}
var triggerEl=params.button||params.displayArea||params.inputField;if(params.canType){function cancelBubble(ev){ev=ev||window.event;if(Zapatec.is_ie){ev.cancelBubble=true;}else{ev.stopPropagation();}}
Zapatec.Utils.addEvent(params.inputField,"mousedown",cancelBubble);Zapatec.Utils.addEvent(params.inputField,"keydown",cancelBubble);Zapatec.Utils.addEvent(params.inputField,"keypress",cancelBubble);Zapatec.Utils.addEvent(params.inputField,"keyup",function(ev){var format=params.inputField?params.ifFormat:params.daFormat;var parsedDate=Date.parseDate(params.inputField.value,format);var cal=window.calendar;if(cal&&parsedDate&&!cal.hidden){cal.setDate(parsedDate);}});}
triggerEl["on"+params.eventName]=function(){var dateEl=params.inputField||params.displayArea;if((!params.canType||params.inputField!=triggerEl)&&triggerEl.blur){triggerEl.blur();}
var dateFmt=params.inputField?params.ifFormat:params.daFormat;var mustCreate=false;var cal=window.calendar;if(params.canType&&(params.inputField==triggerEl)&&cal&&!cal.hidden){return;}
if(!(cal&&params.cache)){window.calendar=cal=new Zapatec.Calendar(params.firstDay,params.date,params.onSelect||onSelect,params.onClose||function(cal){if(params.cache)
cal.hide();else
cal.destroy();});cal.disableFdowClick=params.disableFdowChange;cal.showsTime=params.showsTime;cal.time24=(params.timeFormat=="24");cal.timeInterval=params.timeInterval;cal.weekNumbers=params.weekNumbers;cal.numberMonths=params.numberMonths;cal.controlMonth=params.controlMonth;cal.vertical=params.vertical;cal.monthsInRow=params.monthsInRow;cal.historyDateFormat=params.ifFormat||params.daFormat;cal.helpButton=!params.noHelp;cal.disableDrag=params.disableDrag;cal.closeButton=!params.noCloseButton;cal.yearNav=!params.disableYearNav;cal.sortOrder=params.sortOrder.toLowerCase();mustCreate=true;}else{if(params.date)
cal.setDate(params.date);cal.hide();}
if(params.multiple){cal.setMultipleDates(params.multiple);}
cal.showsOtherMonths=params.showOthers;cal.yearStep=params.step;cal.setRange(params.range[0],params.range[1]);cal.params=params;cal.setDateStatusHandler(params.dateStatusFunc);cal.getDateText=params.dateText;cal.setDateFormat(dateFmt);if(mustCreate)
cal.create();if(dateEl){var dateValue;if(dateEl.value){dateValue=dateEl.value;}else{dateValue=dateEl.innerHTML;}
if(dateValue!=""){var parsedDate=Date.parseDate(dateEl.value||dateEl.innerHTML,dateFmt);if(parsedDate!=null){cal.setDate(parsedDate);}}}
if(!params.position)
cal.showAtElement(params.button||params.displayArea||params.inputField,params.align);else
cal.showAt(params.position[0],params.position[1]);return false;};if(params.closeEventName){triggerEl["on"+params.closeEventName]=function(){if(window.calendar)
window.calendar.callCloseHandler();};}
return cal;};