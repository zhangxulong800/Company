<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script type="text/javascript" src="./public/sfz/IDCRead.js"></script>
    <script>
        var objTIDCR = new TIDCReader();

        function SFZRead() {
            objTIDCR.IDCRead(function (dat) {
                if (dat.STAT == -1) {
                    alert("未接入阅读器，请检查阅读器与电脑的连接是否正常！\n\n确认连接后刷新页面重试");
                    objTIDCR.stopIDCRead();
                }
                //if (dat.STAT == -9) {
                //    alert("您尚未注册，请联系管理员注册");
                //    objTIDCR.stopIDCRead();
                //}
                //if (dat.STAT == -99) {
                //    if(confirm("您未安装身份证阅读控件，请下载安装")){
                //        location = "/Files/TIDCReader.exe";
                //    }
                //    objTIDCR.stopIDCRead();
                //}
                if (dat.STAT == 1) {
                    window.focus();
                    //sfzhm: dat.IDC_CARDNO, //身份证号码
                    //xm: dat.IDC_NAME, //姓名
                    //xb: dat.IDC_SEX,  //性别
                    //mz: dat.IDC_MINZU, //民族
                    //csrq: dat.IDC_BIRTH,  //出生日期
                    //addr: dat.IDC_ADDRESS,   //地址 
                    //pub: dat.IDC_PUBLISHER,  //发证机关
                    //yxqs: dat.IDC_YXQS,   //有效期
                    //yxqe: dat.IDC_YXQE,
                    //naddr: dat.IDC_RECENTADDR,
                    //photo:dat.IDC_PHOTOB64    //图像base64编码
				  	set_sfz_info(dat);
                    //document.getElementById("idcimg").src = objTIDCR.getZPUrl();
                }
            })
        }

        //插件保护产品保护 需要注册（收费）:）
        objTIDCR.Register("a1d48c9dd32bc99747f200d5c80af8478affc6249851853cf523240e5208ae0b6e4ac1942b1daeaaff2b61ad3298536bd69ee39a31e3e41da51058efc045c05dac2b2cc02a5b00cb", function (dat) {
            if (dat.STAT == -99) {
                if (confirm("您未安装身份证阅读控件，请下载安装")) {
                    location = "./public/sfz/TIDCReader.exe";
                }
            } else {
                objTIDCR.closeIDCComm();
                SFZRead();
            }
        })
		
	function set_sfz_info(dat){
		 $("#<?php echo $module['module_name'];?> .icon").attr('src',"data:image/jpg;base64,"+dat.IDC_PHOTOB64+"");
		 $("#<?php echo $module['module_name'];?> .real_name").html(dat.IDC_NAME);
		 $("#<?php echo $module['module_name'];?> .username").val(dat.IDC_NAME);
		  $("#<?php echo $module['module_name'];?> .gender").attr('gender',dat.IDC_SEX);
		 if(dat.IDC_SEX==1){
			 $("#<?php echo $module['module_name'];?> .gender").html('<?php echo $module['data']['gender'][1]?>');
		}else{
			 $("#<?php echo $module['module_name'];?> .gender").html('<?php echo $module['data']['gender'][0]?>');
		}
		 $("#<?php echo $module['module_name'];?> .minzu").attr('minzu',dat.IDC_MINZU);
		 $("#<?php echo $module['module_name'];?> .minzu").html($("#<?php echo $module['module_name'];?> .minzu_array [k='"+dat.IDC_MINZU+"']").html());
		 
		 
		 $("#<?php echo $module['module_name'];?> .birthday").html(dat.IDC_BIRTH);
		 $("#<?php echo $module['module_name'];?> .address").html(dat.IDC_ADDRESS);
		 $("#<?php echo $module['module_name'];?> .license_id").html(dat.IDC_CARDNO);
		 $("#<?php echo $module['module_name'];?> .publisher").html(dat.IDC_PUBLISHER);
		 $("#<?php echo $module['module_name'];?> .yxqs").html(dat.IDC_YXQS);
		 $("#<?php echo $module['module_name'];?> .yxqe").html(dat.IDC_YXQE);
	}
    </script>
	
	<script>
	var is_null=false;
    $(document).ready(function(){
            
        $("#<?php echo $module['module_name'];?> .submit").click(function(){
			$("#<?php echo $module['module_name'];?> .state").html('');
			
			var obj=new Object();
		 	$("#<?php echo $module['module_name'];?> input").each(function(index, element) {
				obj[$(this).attr('class')]=$(this).val();
            });
			
		 	$("#<?php echo $module['module_name'];?> .sfz_info >div >span").each(function(index, element) {
				if($(this).attr('class')!='s_label'){
					obj[$(this).attr('class')]=$(this).html();
				}
            });
			
			obj['icon']=$("#<?php echo $module['module_name'];?> .icon").attr('src');
			obj['gender']=$("#<?php echo $module['module_name'];?> .gender").attr('gender');
			obj['minzu']=$("#<?php echo $module['module_name'];?> .minzu").attr('minzu');
			if(!obj['icon']){
				$("#<?php echo $module['module_name'];?> .submit").next().html('<span class=fail><?php echo self::$language['please_brush_your_id_card']?></span>');
				return false;
			}
			
			
			
		 	$("#<?php echo $module['module_name'];?> input").each(function(index, element) {
                if($(this).val()=='' && $(this).attr('class')!='email' && $(this).attr('class')!='chip' && $(this).attr('class')!='introducer' && $(this).attr('class')!='openid'){
					$(this).next().html('<span class=fail><?php echo self::$language['is_null']?></span>');	
					is_null=true;
					return false;
				}
            });
			if(is_null){return false;}
			
			
			$("#<?php echo $module['module_name'];?> .submit").next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.post('<?php echo $module['action_url'];?>&act=add',obj, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				
				if(v.id){
					$("#<?php echo $module['module_name'];?> ."+v.id).next().html(v.info);
					$("#<?php echo $module['module_name'];?> .submit").next().html('<span class=fail><?php echo self::$language['fail']?></span>');
				}else{
					$("#<?php echo $module['module_name'];?> .submit").next().html(v.info);
				}
				if(v.state=='success'){
					$("#<?php echo $module['module_name'];?> input").val('');
					$("#<?php echo $module['module_name'];?> .sfz_info >div >span").each(function(index, element) {
						if($(this).attr('class')!='s_label'){
							$(this).html('');
						}
					});
					
					$("#<?php echo $module['module_name'];?> .icon").removeAttr('src');
					
				}
				
			});
			return false;
        });
			
    });
    </script>
    

    
    
    
    
    <style>
    #<?php echo $module['module_name'];?> { }
    #<?php echo $module['module_name'];?>_html{ padding-top:20px;padding-bottom:20px;}
	#<?php echo $module['module_name'];?>_html .line{  display:inline-block; vertical-align:top; width:33%;  white-space:nowrap; overflow:hidden; line-height:3rem;}
	#<?php echo $module['module_name'];?>_html .line .m_label{display:inline-block; vertical-align:top; width:35%; opacity:0.5; text-align:right; padding-right:5px; font-size:0.9rem;}
	#<?php echo $module['module_name'];?>_html .line .input{ display:inline-block; vertical-align:top; width:60%; overflow:hidden; }
	#<?php echo $module['module_name'];?>_html .line .input input{ width:60%;}
	
	#<?php echo $module['module_name'];?> .sfz_info{}
	#<?php echo $module['module_name'];?> .sfz_info >div{ display:inline-block; vertical-align:top; width:33%;  white-space:nowrap; overflow:hidden; line-height:2rem;}
	#<?php echo $module['module_name'];?> .sfz_info >div >span{ display:inline-block; vertical-align:top; text-align:left; width:60%; overflow:hidden;  }
	
	#<?php echo $module['module_name'];?> .sfz_info .icon_div{ width:100%; text-align:center;}
	#<?php echo $module['module_name'];?> .sfz_info .s_label{ display:inline-block; vertical-align:top; width:35%; opacity:0.5; text-align:right; padding-right:5px; font-size:0.9rem;}
	#<?php echo $module['module_name'];?> .sfz_info .address{ font-size:0.8rem; white-space: normal;}
	
	#<?php echo $module['module_name'];?> .openid{ width:260px;}
	.please_brush_your_id_card{ text-align:center; font-size:1.5rem;}
    </style>
    
    <div id="<?php echo $module['module_name'];?>_html">
    	<div class=minzu_array style=" display:none;"><?php echo $module['minzu_html'];?></div>
        <div class=please_brush_your_id_card><?php echo self::$language['please_brush_your_id_card']?></div>
        <div class=sfz_info>
        	<div class=icon_div><img class=icon /></div>
        	<div><span class=s_label><?php echo self::$language['real_name']?></span><span class=real_name></span></div>
        	<div><span class=s_label><?php echo self::$language['gender']?></span><span class=gender></span></div>
        	<div><span class=s_label><?php echo self::$language['minzu']?></span><span class=minzu></span></div>
        	<div><span class=s_label><?php echo self::$language['birthday']?></span><span class=birthday></span></div>
        	<div><span class=s_label><?php echo self::$language['address']?></span><span class=address></span></div>
        	<div><span class=s_label><?php echo self::$language['license_id']?></span><span class=license_id></span></div>
        	<div><span class=s_label><?php echo self::$language['publisher']?></span><span class=publisher></span></div>
        	<div><span class=s_label><?php echo self::$language['yxqs']?></span><span class=yxqs></span></div>
        	<div><span class=s_label><?php echo self::$language['yxqe']?></span><span class=yxqe></span></div>
            
            
            
            
        </div>
        
        
    	<div class=line><span class=m_label><?php echo self::$language['username']?></span><span class=input> <input type="text" class=username placeholder="<?php echo self::$language['real_name']?>/<?php echo self::$language['phone']?>"> <span class=state></span></span></div>
    	<div class=line><span class=m_label><?php echo self::$language['phone']?></span><span class=input> <input type="text" class=phone  /> <span class=state></span></span></div>
    	<div class=line><span class=m_label><?php echo self::$language['email']?>(<?php echo self::$language['optional']?>)</span><span class=input> <input type="text" class=email  /> <span class=state></span></span></div>
    	<div class=line><span class=m_label><?php echo self::$language['introducer']?>(<?php echo self::$language['optional']?>)</span><span class=input> <input type="text" class=introducer /> <span class=state></span></span></div>
    	<div class=line><span class=m_label><?php echo self::$language['login']?><?php echo self::$language['password']?></span><span class=input> <input type="text" class=password  value="<?php echo $module['random']?>" /> <span class=state></span></span></div>
    	<div class=line><span class=m_label><?php echo self::$language['transaction_password']?></span><span class=input> <input type="text" class=transaction_password  value="<?php echo $module['random']?>" /> <span class=state></span></span></div>
    	<div class=line><span class=m_label><?php echo self::$language['chip']?>(<?php echo self::$language['optional']?>)</span><span class=input> <input type="text" class=chip  /> <span class=state></span></span></div>
    	
        <div class=line><span class=m_label>&nbsp;</span><span class=input> <a href=# class=submit><?php echo self::$language['submit']?></a> <span class=state></span></span></div>
        
        <div class=line_b style="border-top:dashed 1px #ccc; padding-top:1rem; text-align:center;"><span class=m_label><?php echo self::$language['openid']?><?php echo self::$language['authcode']?>(<?php echo self::$language['optional']?>)</span><span class=input> <input type="text" class=openid  /> <span class=state></span>
        
        <?php echo $module['weixin_code'];?>
        </span></div>
        
        
        
    
    
    </div>
</div>

