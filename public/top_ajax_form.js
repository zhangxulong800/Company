//启用此函数前，请先载入 jqeury
//不能上传文件
//使用示例
/*
<form **** onsubmit="return exe_check();">
function exe_check(){
	//表单输入值检测... 如果非法则返回 false
	top_ajax_form('monxin_form','submit_div','callbackFu');
	top_ajax_form('表单ID','接收返回值的元素ID','回调函数');
	return false;
}
*/
function top_ajax_form(id,loading_div,callbackFu){
	form=document.getElementById(id);	
	aInput=form.getElementsByTagName("input");
	aSelect=form.getElementsByTagName("select");
	aTextarea=form.getElementsByTagName("textarea");
	var str='';
	for(var i=0;i<aInput.length;i++){
		if(aInput[i].type=='submit' || aInput[i].type=='button'){continue;}
		if(aInput[i].type=='checkbox'){
			is_checkbox=true;
			checked='';
			while(is_checkbox){
				if(aInput[i].checked){checked+=aInput[i].value+'|';}
				i++;
				if(aInput[i].type!='checkbox' || aInput[i].name!=aInput[i-1].name){is_checkbox=false;i--;}
				
			}
			
			str+="'"+aInput[i].name.replace("[]",'')+"':'"+checked.substring(0,checked.length-1)+"',";
		}else if(aInput[i].type=='radio'){
			if(aInput[i].checked){str+="'"+aInput[i].name+"':'"+aInput[i].value+"',";}
		}else{
			str+="'"+aInput[i].name+"':'"+aInput[i].value+"',";
			}
		
	}
	for(var i=0;i<aSelect.length;i++){
		str+="'"+aSelect[i].name+"':'"+aSelect[i].value+"',";
	}
	for(var i=0;i<aTextarea.length;i++){
		str+="'"+aTextarea[i].name+"':'"+aTextarea[i].value+"',";
	}
	str=str.substring(0,str.length-1);
	//while(str.indexOf("\r\n") >= 0){str= str.replace("\r\n", "\\r\\n");}
	while(str.indexOf("\r") >= 0){str= str.replace("\r", "\\r");}
	while(str.indexOf("\n") >= 0){str= str.replace("\n", "\\n");}
	while(str.indexOf("':'") >= 0){str= str.replace("':'", "`:`");}
	while(str.indexOf("','") >= 0){str= str.replace("','", "`,`");}
	str=replace_quot(str);
	while(str.indexOf("`:`") >= 0){str= str.replace("`:`", "':'");}
	while(str.indexOf("`,`") >= 0){str= str.replace("`,`", "','");}
	str="'"+str.substring(5,str.length-5)+"'";
	//alert(str);
	//return false;
	json="{"+str+"}";
	json=eval("("+json+")");
	//alert(json.title);
	//return false;
	if(form.action.indexOf("?")==-1){form.action+="?";}
	if(form.method.toLowerCase()=='post'){
		$("#"+loading_div).load(form.action+"&callbackFu="+callbackFu, json,function(){
			eval(callbackFu+"()");
			//eval(callbackFu+"()");
			});
	}else{
		str=str.replace(/:/g,'=');
		str=str.replace(/'/g,"");
		str=str.replace(/,/g,'&');
		str=encodeURI(str);
		$("#"+loading_div).load(form.action+"&"+str+"&callbackFu="+callbackFu,function(){
			eval(callbackFu+"()");
		});
	}
	
	
	return false;
	
}

