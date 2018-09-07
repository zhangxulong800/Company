
<!--top_html5 echo_js 开始-->
    <script type="text/javascript">
     var top_html5_xhr = new XMLHttpRequest();
	 var top_html5_fileObj=new Array();
	 var top_html5_max_size;
	 var top_html5_min_size;
	 var top_html5_suffix;
	 var top_html5_sys_suffix="<?php echo str_replace(',',"|",$config['upload']['upAllowSuffix']);?>";
	 var input_id;
        function top_html5_UpladFile(input_id,save_dir,dir_append_date,sourceName,top_html5_suffix,max_size,min_size) {
			window.input_id=input_id;
			window.top_html5_max_size=max_size*1024;
			window.top_html5_min_size=min_size*1024;
			window.top_html5_suffix=top_html5_suffix;
			
			flag=false;
          	top_html5_fileObj = document.getElementById(input_id+"_file").files; 
			try{var form = new FormData();}catch(e){monxin_alert('<?php echo $language['the_browser_does_not_support_this_operation_replace_or_upgrade_your_browser']?>');return false;}
            
			ii=0;
           	for(var i=0;i<top_html5_fileObj.length;i++){
				
				now_name=(top_html5_fileObj[i].fileName)?top_html5_fileObj[i].fileName:top_html5_fileObj[i].name;
				now_size=(top_html5_fileObj[i].fileSize)?top_html5_fileObj[i].fileSize:top_html5_fileObj[i].size;
				now_top_html5_suffix=now_name.split('.');
				now_top_html5_suffix=now_top_html5_suffix[now_top_html5_suffix.length-1].toLowerCase();	
				
				if(top_html5_suffix.indexOf(now_top_html5_suffix)==-1){
					v=now_name+" ("+now_top_html5_suffix+") <?php echo $language['page_forbidden_suffix'];?><br />";					
					top_html5_show_failedList(v,input_id);continue;
				}
				
				if(top_html5_sys_suffix.indexOf(now_top_html5_suffix)==-1){
					v=now_name+" ("+now_top_html5_suffix+") <?php echo $language['sys_forbidden_suffix'];?><br />";				
					top_html5_show_failedList(v,input_id);continue;
				}
				if(now_size<top_html5_min_size){
					s=parseInt(now_size/1024);
					s2=parseInt(top_html5_min_size/1024);
					v=now_name+" "+s+" KB <?php echo $language['page_min_upload_size'];?> "+s2+"KB</b><br />";
					top_html5_show_failedList(v,input_id);continue;
				}
				if(now_size>top_html5_max_size){
					s=parseInt(now_size/1024);
					s2=parseInt(top_html5_max_size/1024);
					v=now_name+" "+s+" KB <?php echo $language['page_max_upload_size'];?> "+s2+"KB</b><br />";
					top_html5_show_failedList(v,input_id);continue;
				}
				
				if(now_size><?php echo $config['upload']['sys_upload_max_filesize']?>){
					s=(parseInt(now_size/1024/1024*100)/100)+"M";
					s2="<?php echo $config['upload']['sys_upload_max_filesize']/1024/1024;?>M";
					v=now_name+" "+s+" <?php echo $language['sys_upload_max_filesize'];?> "+s2+" </b><br />";
					top_html5_show_failedList(v,input_id);continue;
				}
				
				//monxin_alert(min_size);
				form.append("file_"+ii, top_html5_fileObj[i]);
				ii++;
				flag=true;
				
			}
			if(!flag){document.getElementById(input_id+"_file").value=''; return false;}
			//monxin_alert('send');
            // XMLHttpRequest 对象
			
			var top_html5_receive_url= "./plugin/html5Upfile/receiveFile.php?token=<?php echo $_SESSION['html5Upfile_token'];?>&act=upfile&saveDir="+save_dir+"&dir_append_date="+dir_append_date+"&sourceName="+sourceName+"&maxSize="+max_size+"&minSize="+min_size+"&top_html5_suffix="+window.top_html5_suffix+"&input_name="+input_id;
			//monxin_alert(top_html5_receive_url);

			top_html5_xhr.onreadystatechange=return_file_name;
            top_html5_xhr.open("post",top_html5_receive_url, true);
            top_html5_xhr.onload = function () {
                //monxin_alert("上传完成!");
				//alert($("#"+input_id).val());
			   try{submit_hidden(input_id);}catch(e){}
            };
            top_html5_xhr.upload.addEventListener("progress", top_html5_progressFunction, false);
            
            top_html5_xhr.send(form);
			document.getElementById(input_id+"_file").value='';

        }
		function top_html5_show_failedList(v,input_id){
			top_html5_show_up_info('block',input_id);
			document.getElementById(input_id+"_failedList").innerHTML+=v;
			document.getElementById(input_id+"_fieldset_failedList").style.display='block';
			
		}
		function return_file_name(){
			input_id=window.input_id;
			if(top_html5_xhr.readyState==4 && top_html5_xhr.status==200){
				//alert(top_html5_xhr.responseText);
				temp=top_html5_xhr.responseText;
				responseText=eval("("+temp+")");
				top_html5_show_up_info('block',input_id);
				document.getElementById(input_id).value+=responseText.hiddenValue;
				document.getElementById(input_id+"_succeedList").innerHTML+=responseText.succeedList;	
				document.getElementById(input_id+"_failedList").innerHTML+=responseText.failedList;	
				
				if(responseText.succeedList!=''){document.getElementById(input_id+"_fieldset_succeedList").style.display='block';}
				if(responseText.failedList!=''){document.getElementById(input_id+"_fieldset_failedList").style.display='block';}
				document.getElementById(input_id+"_file").value='';

			}
			
		}
        function top_html5_progressFunction(evt) {
			input_id=window.input_id;
			//monxin_alert(input_id);
            progressBar = document.getElementById(input_id+"_progressBar");
            percentageDiv = document.getElementById(input_id+"_percentage");
			if(document.getElementById(input_id+"_progress_div").style.display=='none'){document.getElementById(input_id+"_progress_div").style.display='block';}
			top_html5_show_up_info('block',input_id);
            if (evt.lengthComputable) {
                progressBar.max = evt.total;
                progressBar.value = evt.loaded;
                percentageDiv.innerHTML = Math.round(evt.loaded / evt.total * 100) + "%";
            }
        } 
		function top_html5_show_up_info(v,input_id){
			if(document.getElementById(input_id+"_up_info").style.display=='none' || v=='block'){
				document.getElementById(input_id+"_up_info").style.display='block';
				document.getElementById(input_id+"_click_target").innerHTML="︽";
			}else{
				document.getElementById(input_id+"_up_info").style.display='none';
				document.getElementById(input_id+"_click_target").innerHTML="︾";
			}
			return false;
		}
		 
    </script>

<!--top_html5 echo_js 结束-->
