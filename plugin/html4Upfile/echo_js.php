

<!--top_html4 echo_js 开始-->
<script>


function top_html4_upload(input_id,save_dir,dir_append_date,sourceName,top_html4_suffix,max_size,min_size,save_name){
	//monxin_alert(input_id);
	 var top_html4_max_size=max_size*1024;
	 var top_html4_min_size=min_size*1024;
	 var top_html4_suffix=top_html4_suffix;
	 var top_html4_sys_suffix="<?php echo str_replace(',',"|",$config['upload']['upAllowSuffix']);?>";
	 var top_html4_receive_url= "./plugin/html4Upfile/receiveFile.php?token=<?php echo $_SESSION['html4Upfile_token'];?>&act=upfile&saveDir="+save_dir+"&dir_append_date="+dir_append_date+"&sourceName="+sourceName+"&maxSize="+max_size+"&minSize="+min_size+"&top_html4_suffix="+top_html4_suffix+"&input_name="+input_id+"_file&save_name="+save_name;
	now_name=(document.getElementById(input_id+"_file").value.split('\\'));
	if(now_name.length<2){now_name=(document.getElementById(input_id+"_file").value.split('/'));}
	now_name=now_name[now_name.length-1];
	now_top_html4_suffix=(document.getElementById(input_id+"_file").value.split('.'));
	now_top_html4_suffix=now_top_html4_suffix[now_top_html4_suffix.length-1].toLowerCase();	
	//monxin_alert(top_html4_suffix);
	if(top_html4_suffix.indexOf(now_top_html4_suffix)==-1){
		v=now_name+" ("+now_top_html4_suffix+") <?php echo $language['page_forbidden_suffix'];?>";				
		top_html4_show_failedList(v,input_id);return false;
	}
	if(top_html4_sys_suffix.indexOf(now_top_html4_suffix)==-1){
		v=now_name+" ("+now_top_html4_suffix+") <?php echo $language['sys_forbidden_suffix'];?>";				
		top_html4_show_failedList(v,input_id);return false;
	}
	
	document.getElementById(input_id+"_icon").src="./plugin/html4Upfile/execute.gif";
	document.getElementById(input_id+"_icon").style.display='inline-block';
    ajaxFileUpload({
        id:input_id+"_file",
		target_url:top_html4_receive_url,
        callback:function(){
			//monxin_alert(this.responseText);
			temp=this.responseText;			  	
				  try{response=eval("("+temp+")");}catch(exception){alert(temp);}
				if(response.failedList!=''){top_html4_show_failedList(response.failedList,input_id);}
				if(response.succeedList!=''){top_html4_show_succeedList(response.succeedList,input_id,response.hiddenValue);}
				
        }
    });    
}

function top_html4_show_failedList(v,input_id){
	document.getElementById(input_id+"_file").outerHTML += ''; 
	document.getElementById(input_id+"_file").value='';
	document.getElementById(input_id+"_span").innerHTML=v;
	document.getElementById(input_id+"_icon").src="./plugin/html4Upfile/fail.png";
	document.getElementById(input_id+"_icon").style.display='inline-block';

}
function top_html4_show_succeedList(v,input_id,hiddenValue){
	document.getElementById(input_id).value=hiddenValue;
	//monxin_alert(input_id+"="+document.getElementById(input_id).value);
	document.getElementById(input_id+"_span").innerHTML=v;
	document.getElementById(input_id+"_icon").src="./plugin/html4Upfile/success.png";
	document.getElementById(input_id+"_icon").style.display='inline-block';
	try{submit_hidden(input_id);}catch(e){}
	
}


/*
    ajaxFileUpload 代码来源信息
	作者：天涯
    QQ：63886829
    eMail:flyinksy@gmail.com
    说明：ajax文件上传
*/
var ajaxFileUpload = function(opts){
    return new ajaxFileUpload.prototype.init(opts);
};
ajaxFileUpload.prototype = {
    init:function(opts){
        var set = this.extend({
            //url:'upfile1.php?act=upfile&input_name='+opts.id,
			url:opts.target_url,
            id:'fileId',
            callback:function(){}
        },opts || {});
        var _this = this;
        var id = +new Date();
        var form = this.createForm(id),frame = this.createIframe(id,set.url);
        var oldFile = document.getElementById(set.id)
        var newFile = oldFile.cloneNode(true);
        var fileId = 'ajaxFileUploadFile'+id;
        oldFile.setAttribute('id',fileId);
        oldFile.parentNode.insertBefore(newFile,oldFile);
        form.appendChild(oldFile);//注意浏览器安全问题，要将原文件域放到创建的form里提交
        form.setAttribute('target',frame.id);//将form的target设置为iframe,这样提交后返回的内容就在iframe里
        form.setAttribute('action',set.url);
        setTimeout(function(){
            form.submit();
            if(frame.attachEvent){
                frame.attachEvent('onload',function(){_this.uploadCallback(id,set.callback);});
            }else{
                frame.onload = function(){_this.uploadCallback(id,set.callback);}
            }
        },100);
    },
    /*
        创建iframe，ie7和6比较蛋疼，得像下面那样创建，否则会跳转
    */
    createIframe:function(id,url){
        var frameId = 'ajaxFileUploadFrame'+id,iFrame;
        var IE = /msie ((\d+\.)+\d+)/i.test(navigator.userAgent) ? (document.documentMode ||  RegExp['\x241']) : false,
        url = url || 'javascript:false';
        if(IE && IE < 8){
            iFrame = document.createElement('<iframe id="' + frameId + '" name="' + frameId + '" />');
            iFrame.src = url;
        }else{
            iFrame = document.createElement('iframe');
            this.attr(iFrame,{
                'id':frameId,
                'name':frameId,
                'src':url
            });
        };
        iFrame.style.cssText = 'position:absolute; top:-9999px; left:-9999px';
        return document.body.appendChild(iFrame);
    },
    /*
        创建form
    */
    createForm:function(id){
        var formId = 'ajaxFileUploadForm'+id;
        var form = document.createElement('form');
        this.attr(form,{
            'action':'',
            'method':'POST',
            'name':formId,
            'id':formId,
            'enctype':'multipart/form-data',
            'encoding':'multipart/form-data'
        });
        form.style.cssText = 'position:absolute; top:-9999px; left:-9999px';
        return document.body.appendChild(form);  
    },
    /*
        获取iframe内容，执行回调函数，并移除生成的iframe和form
    */
    uploadCallback:function(id,callback){
        var frame = document.getElementById('ajaxFileUploadFrame'+id),form = document.getElementById('ajaxFileUploadForm'+id);data = {};
        var db = document.body;
        try{
            if(frame.contentWindow){
                data.responseText = frame.contentWindow.document.body ? frame.contentWindow.document.body.innerHTML : null;
                data.responseXML = frame.contentWindow.document.XMLDocument ? frame.contentWindow.document.XMLDocument : frame.contentWindow.document;
            }else{
                data.responseText = frame.contentDocument.document.body ? frame.contentDocument.document.body.innerHTML : null;
                data.responseXML = frame.contentDocument.document.XMLDocument ? frame.contentDocument.document.XMLDocument : frame.contentDocument.document;
            }
        }catch(e){};
        callback && callback.call(data);
        setTimeout(function(){
            db.removeChild(frame);
            db.removeChild(form);
        },100);
    },
    attr:function(el,attrs){
        for(var prop in attrs) el.setAttribute(prop,attrs[prop]);
        return el;
    },
    extend:function(target,source){
        for(var prop in source) target[prop] = source[prop];
        return target;
    }
};
ajaxFileUpload.prototype.init.prototype = ajaxFileUpload.prototype;
</script>
		

<!--top_html4 ech_js 结束-->
