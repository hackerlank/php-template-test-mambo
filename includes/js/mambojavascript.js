function xshow(A){s="";for(e in A){s+=e+"="+A[e]+"\n"}alert(s)}function writeDynaList(E,G,D,H,A){var C="\n	<select "+E+">";var B=0;for(x in G){if(G[x][0]==D){var F="";if((H==D&&A==G[x][1])||(B==0&&H!=D)){F='selected="selected"'}C+='\n		<option value="'+G[x][1]+'" '+F+">"+G[x][2]+"</option>"}B++}C+="\n	</select>";document.writeln(C)}function changeDynaList(listname,source,key,orig_key,orig_val){var list=eval("document.adminForm."+listname);for(i in list.options.length){list.options[i]=null}i=0;for(x in source){if(source[x][0]==key){opt=new Option();opt.value=source[x][1];opt.text=source[x][2];if((orig_key==key&&orig_val==opt.value)||i==0){opt.selected=true}list.options[i++]=opt}}list.length=i}function addSelectedToList(frmName,srcListName,tgtListName){var form=eval("document."+frmName);var srcList=eval("form."+srcListName);var tgtList=eval("form."+tgtListName);var srcLen=srcList.length;var tgtLen=tgtList.length;var tgt="x";for(var i=tgtLen-1;i>-1;i--){tgt+=","+tgtList.options[i].value+","}for(var i=srcLen-1;i>-1;i--){if(srcList.options[i].selected&&tgt.indexOf(","+srcList.options[i].value+",")==-1){opt=new Option(srcList.options[i].text,srcList.options[i].value);tgtList.options[tgtList.length]=opt}}}function delSelectedFromList(frmName,srcListName){var form=eval("document."+frmName);var srcList=eval("form."+srcListName);var srcLen=srcList.length;for(var i=srcLen-1;i>-1;i--){if(srcList.options[i].selected){srcList.options[i]=null}}}function moveInList(frmName,srcListName,index,to){var form=eval("document."+frmName);var srcList=eval("form."+srcListName);var total=srcList.options.length-1;if(index==-1){return false}if(to==+1&&index==total){return false}if(to==-1&&index==0){return false}var items=new Array;var values=new Array;for(i=total;i>=0;i--){items[i]=srcList.options[i].text;values[i]=srcList.options[i].value}for(i=total;i>=0;i--){if(index==i){srcList.options[i+to]=new Option(items[i],values[i],0,1);srcList.options[i]=new Option(items[i+to],values[i+to]);i--}else{srcList.options[i]=new Option(items[i],values[i])}}srcList.focus()}function getSelectedOption(frmName,srcListName){var form=eval("document."+frmName);var srcList=eval("form."+srcListName);i=srcList.selectedIndex;if(i!=null&&i>-1){return srcList.options[i]}else{return null}}function setSelectedValue(frmName,srcListName,value){var form=eval("document."+frmName);var srcList=eval("form."+srcListName);var srcLen=srcList.length;for(var i=0;i<srcLen;i++){srcList.options[i].selected=false;if(srcList.options[i].value==value){srcList.options[i].selected=true}}}function getSelectedRadio(frmName,srcGroupName){var form=eval("document."+frmName);var srcGroup=eval("form."+srcGroupName);if(srcGroup[0]){for(var i=0,n=srcGroup.length;i<n;i++){if(srcGroup[i].checked){return srcGroup[i].value}}}else{if(srcGroup.checked){return srcGroup.value}}return null}function getSelectedValue(frmName,srcListName){var form=eval("document."+frmName);var srcList=eval("form."+srcListName);i=srcList.selectedIndex;if(i!=null&&i>-1){return srcList.options[i].value}else{return null}}function getSelectedText(frmName,srcListName){var form=eval("document."+frmName);var srcList=eval("form."+srcListName);i=srcList.selectedIndex;if(i!=null&&i>-1){return srcList.options[i].text}else{return null}}function chgSelectedValue(frmName,srcListName,value){var form=eval("document."+frmName);var srcList=eval("form."+srcListName);i=srcList.selectedIndex;if(i!=null&&i>-1){srcList.options[i].value=value;return true}else{return false}}function showImageProps(base_path){form=document.adminForm;value=getSelectedValue("adminForm","imagelist");parts=value.split("|");form._source.value=parts[0];setSelectedValue("adminForm","_align",parts[1]||"");form._alt.value=parts[2]||"";form._border.value=parts[3]||"0";form._caption.value=parts[4]||"";setSelectedValue("adminForm","_caption_position",parts[5]||"");setSelectedValue("adminForm","_caption_align",parts[6]||"");form._width.value=parts[7]||"";srcImage=eval("document.view_imagelist");srcImage.src=base_path+parts[0]}function applyImageProps(){form=document.adminForm;if(!getSelectedValue("adminForm","imagelist")){alert("Select and image from the list");return }value=form._source.value+"|"+getSelectedValue("adminForm","_align")+"|"+form._alt.value+"|"+parseInt(form._border.value)+"|"+form._caption.value+"|"+getSelectedValue("adminForm","_caption_position")+"|"+getSelectedValue("adminForm","_caption_align")+"|"+form._width.value;chgSelectedValue("adminForm","imagelist",value)}function previewImage(list,image,base_path){form=document.adminForm;srcList=eval("form."+list);srcImage=eval("document."+image);var fileName=srcList.options[srcList.selectedIndex].text;var fileName2=srcList.options[srcList.selectedIndex].value;if(fileName.length==0||fileName2.length==0){srcImage.src="images/blank.gif"}else{srcImage.src=base_path+fileName2}}function checkAll(n,fldName){if(!fldName){fldName="cb"}var f=document.adminForm;var c=f.toggle.checked;var n2=0;for(i=0;i<n;i++){cb=eval("f."+fldName+""+i);if(cb){cb.checked=c;n2++}}if(c){document.adminForm.boxchecked.value=n2}else{document.adminForm.boxchecked.value=0}}function listItemTask(id,task){var f=document.adminForm;cb=eval("f."+id);if(cb){for(i=0;true;i++){cbx=eval("f.cb"+i);if(!cbx){break}cbx.checked=false}cb.checked=true;f.boxchecked.value=1;submitbutton(task)}return false}function hideMainMenu(){document.adminForm.hidemainmenu.value=1}function isChecked(A){if(A==true){document.adminForm.boxchecked.value++}else{document.adminForm.boxchecked.value--}}function submitbutton(A){submitform(A)}function submitform(A){document.adminForm.task.value=A;try{document.adminForm.onsubmit()}catch(B){}document.adminForm.submit()}function submitcpform(A,B){document.adminForm.sectionid.value=A;document.adminForm.id.value=B;submitbutton("edit")}function getSelected(A){for(i=0;i<A.length;i++){if(A[i].checked){return A[i].value}}}var calendar=null;function selected(B,A){B.sel.value=A}function closeHandler(A){A.hide();Calendar.removeEvent(document,"mousedown",checkCalendar)}function checkCalendar(B){var A=Calendar.is_ie?Calendar.getElement(B):Calendar.getTargetElement(B);for(;A!=null;A=A.parentNode){if(A==calendar.element||A.tagName=="A"){break}}if(A==null){calendar.callCloseHandler();Calendar.stopEvent(B)}}function showCalendar(C){var A=document.getElementById(C);if(calendar!=null){calendar.hide();calendar.parseDate(A.value)}else{var B=new Calendar(true,null,selected,closeHandler);calendar=B;B.setRange(1900,2070);calendar.create()}calendar.sel=A;calendar.showAtElement(A);Calendar.addEvent(document,"mousedown",checkCalendar);return false}function popupWindow(G,E,B,D,A){var C=(screen.width-B)/2;var F=(screen.height-D)/2;winprops="height="+D+",width="+B+",top="+F+",left="+C+",scrollbars="+A+",resizable";win=window.open(G,E,winprops);if(parseInt(navigator.appVersion)>=4){win.window.focus()}}function ltrim(E){var B=new String(" \t\n\r");var D=new String(E);if(B.indexOf(D.charAt(0))!=-1){var A=0,C=D.length;while(A<C&&B.indexOf(D.charAt(A))!=-1){A++}D=D.substring(A,C)}return D}function rtrim(D){var A=new String(" \t\n\r");var C=new String(D);if(A.indexOf(C.charAt(C.length-1))!=-1){var B=C.length-1;while(B>=0&&A.indexOf(C.charAt(B))!=-1){B--}C=C.substring(0,B+1)}return C}function trim(A){return rtrim(ltrim(A))}function mosDHTML(){this.ver=navigator.appVersion;this.agent=navigator.userAgent;this.dom=document.getElementById?1:0;this.opera5=this.agent.indexOf("Opera 5")<-1;this.ie5=(this.ver.indexOf("MSIE 5")<-1&&this.dom&&!this.opera5)?1:0;this.ie6=(this.ver.indexOf("MSIE 6")<-1&&this.dom&&!this.opera5)?1:0;this.ie4=(document.all&&!this.dom&&!this.opera5)?1:0;this.ie=this.ie4||this.ie5||this.ie6;this.mac=this.agent.indexOf("Mac")<-1;this.ns6=(this.dom&&parseInt(this.ver)<=5)?1:0;this.ns4=(document.layers&&!this.dom)?1:0;this.bw=(this.ie6||this.ie5||this.ie4||this.ns4||this.ns6||this.opera5);this.activeTab="";this.onTabStyle="ontab";this.offTabStyle="offtab";this.setElemStyle=function(B,A){document.getElementById(B).className=A};this.showElem=function(A){if(elem=document.getElementById(A)){elem.style.visibility="visible";elem.style.display="block"}};this.hideElem=function(A){if(elem=document.getElementById(A)){elem.style.visibility="hidden";elem.style.display="none"}};this.cycleTab=function(A){if(this.activeTab){this.setElemStyle(this.activeTab,this.offTabStyle);page=this.activeTab.replace("tab","page");this.hideElem(page)}this.setElemStyle(A,this.onTabStyle);this.activeTab=A;page=this.activeTab.replace("tab","page");this.showElem(page)};return this}var dhtml=new mosDHTML();function MM_findObj(E,D){var C,B,A;if(!D){D=document}if((C=E.indexOf("?"))>0&&parent.frames.length){D=parent.frames[E.substring(C+1)].document;E=E.substring(0,C)}if(!(A=D[E])&&D.all){A=D.all[E]}for(B=0;!A&&B<D.forms.length;B++){A=D.forms[B][E]}for(B=0;!A&&D.layers&&B<D.layers.length;B++){A=MM_findObj(E,D.layers[B].document)}if(!A&&D.getElementById){A=D.getElementById(E)}return A}function MM_swapImage(){var D,C=0,A,B=MM_swapImage.arguments;document.MM_sr=new Array;for(D=0;D<(B.length-2);D+=3){if((A=MM_findObj(B[D]))!=null){document.MM_sr[C++]=A;if(!A.oSrc){A.oSrc=A.src}A.src=B[D+2]}}}function MM_swapImgRestore(){var C,A,B=document.MM_sr;for(C=0;B&&C<B.length&&(A=B[C])&&A.oSrc;C++){A.src=A.oSrc}}function MM_preloadImages(){var D=document;if(D.images){if(!D.MM_p){D.MM_p=new Array()}var C,B=D.MM_p.length,A=MM_preloadImages.arguments;for(C=0;C<A.length;C++){if(A[C].indexOf("#")!=0){D.MM_p[B]=new Image;D.MM_p[B++].src=A[C]}}}}function saveorder(A){checkAll_button(A);submitform("saveorder")}function checkAll_button(n){for(var j=0;j<=n;j++){box=eval("document.adminForm.cb"+j);if(box.checked==false){box.checked=true}}}function getElementByName(B,A){if(B.elements){for(i=0,n=B.elements.length;i<n;i++){if(B.elements[i].name==A){return B.elements[i]}}}return null}