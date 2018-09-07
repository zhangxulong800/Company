<?php
//use demo <input type="text" id="demo"  onclick=show_datePicker(this.id,'time') onblur= hide_datePicker() />
header('Content-Type:text/html;charset=utf-8');
$config=require '../../config.php';
$timeoffset=($config['other']['timeoffset']>0)? "-".$config['other']['timeoffset']:str_replace("-","+",$config['other']['timeoffset']);
date_default_timezone_set("Etc/GMT$timeoffset");

$language=require '../../language/'.$config['web']['language'].'.php';
require_once '../../config/functions.php';

$temp=explode("-",$config['other']['optional_year_range']);
$year_start=$temp[0];
$year_end=$temp[1];


$js='';
if(strtolower($config['other']['date_style'][0])=='y'){$js="datePicker_year+datePicker_month+datePicker_day";}
if(strtolower($config['other']['date_style'][0])=='m'){$js="datePicker_month+datePicker_day+datePicker_year";}
if(strtolower($config['other']['date_style'][0])=='d'){$js="datePicker_day+datePicker_month+datePicker_year";}
$js.="+datePicker_hour+datePicker_minute+datePicker_second";

?>
var datePicker_year="<option value='-1'>  <?php echo $language['Y']?>  </option>";
for(i=<?php echo $year_start;?>;i<=<?php echo $year_end;?>;i++){
	datePicker_year+="<option value='"+i+"'>"+i+"</option>";
}
datePicker_year="<select id='datePicker_year' name='datePicker_year'>"+datePicker_year+"</select>";

var datePicker_month="<option value='-1'>  <?php echo $language['m']?>  </option>";
for(i=1;i<=12;i++){
	if(i<10){v="0"+i;}else{v=i;}
	datePicker_month+="<option value='"+v+"'>"+v+"</option>";
}
datePicker_month="<select id='datePicker_month' name='datePicker_month'>"+datePicker_month+"</select>";

function  datePicker_get_days(Year,Month){
    var d = new Date(Year,Month,0);
    return d.getDate();
}

function datePicker_get_day_option(days){
	v2='';
	for(i=1;i<=days;i++){
		if(i<10){v="0"+i;}else{v=i;}
		v2+="<option value='"+v+"'>"+v+"</option>";
	}
	return v2;	
}
var datePicker_day="<option value='-1'>  <?php echo $language['d']?>  </option>";
datePicker_day="<select id='datePicker_day' name='datePicker_day'>"+datePicker_day+datePicker_get_day_option(31)+"</select>";



var datePicker_hour="<option value='-1'>  <?php echo $language['h']?>  </option>";
for(i=0;i<=23;i++){
	if(i<10){v="0"+i;}else{v=i;}
	datePicker_hour+="<option value='"+v+"'>"+v+"</option>";
}
datePicker_hour="<select id='datePicker_hour' name='datePicker_hour'>"+datePicker_hour+"</select>";

var datePicker_minute="<option value='-1'>  <?php echo $language['i']?>  </option>";
for(i=0;i<=59;i++){
	if(i<10){v="0"+i;}else{v=i;}
	datePicker_minute+="<option value='"+v+"'>"+v+"</option>";
}
datePicker_minute="<select id='datePicker_minute' name='datePicker_minute'>"+datePicker_minute+"</select>";

var datePicker_second="<option value='-1'>  <?php echo $language['s']?>  </option>";
for(i=0;i<=59;i++){
	if(i<10){v="0"+i;}else{v=i;}
	datePicker_second+="<option value='"+v+"'>"+v+"</option>";
}
datePicker_second="<select id='datePicker_second' name='datePicker_second'>"+datePicker_second+"</select>";
datePicker="<div id='datePicker_div' name='datePicker_div' style='position:absolute;display:none;'>"+<?php echo $js;?>+"</div>";
document.write(datePicker);
var datePicker_timer='';
var datePicker_obj='';

function show_datePicker(id,show){
	if(show=='date'){$("#datePicker_hour").css('display','none');$("#datePicker_minute").css('display','none');$("#datePicker_second").css('display','none');}
	if(show=='time'){$("#datePicker_year").css('display','none');$("#datePicker_month").css('display','none');$("#datePicker_day").css('display','none');}
    if(show=='date_time'){$("#datePicker_div select").css('display','inline-block');}
    
    if($("#"+id).val()==''){
    	if(show=='date'){$("#"+id).val('<?php echo date('Y-m',time());?>');}
    	if(show=='time'){$("#"+id).val('<?php echo date('H:i',time());?>');}
    	if(show=='date_time'){$("#"+id).val('<?php echo date('Y-m-d H:i',time());?>');}
    	//$("#datePicker_div select").val(-1);
    }
    
    v=$("#"+id).val();
    v=v.replace(/:/g," ");
    v=v.replace(/<?php echo $config['other']['date_style'][1]?>/g," ");
    //monxin_alert(v);
    v=v.split(" ");
    if(show=='time'){$("#datePicker_hour").val(v[0]);$("#datePicker_minute").val(v[1]);$("#datePicker_second").val(v[2]);}
    if(show=='date'){$("#datePicker_year").val(v[0]);$("#datePicker_month").val(v[1]);$("#datePicker_day").val(v[2]);}
    if(show=='date_time'){
         $("#datePicker_div select").each(function (index, domEle){
            $(this).val(v[index]);
         });
    }
        
        
	datePicker_obj=id;
    clearTimeout(datePicker_timer);
	//$("#"+id).after($("#datePicker_div"));
	offset=$("#"+id).offset();
    $("#datePicker_div").css('top',offset.top+$("#"+id).height()+5);
    $("#datePicker_div").css('left',offset.left);
    $("#datePicker_div").css('display','block');
    var evt =arguments.callee.caller.arguments[0] || window.event;
    evt.stopPropagation ? evt.stopPropagation() : (evt.cancelBubble=true);
}
function hide_datePicker(){
	datePicker_timer= setTimeout("exe_hide_datePicker()", 500);
}
function exe_hide_datePicker(){
	$("#datePicker_div").css('display','none');
}
if($){
	$("#datePicker_div").mousemove(function(){
    	clearTimeout(datePicker_timer);
    });
    $("#datePicker_div select").change(function(){
    full='';
    $("#datePicker_div select").each(function (index, domEle) { 
    	if($(this).css('display')!='none'){
        	if((this.id=='datePicker_year' || this.id=='datePicker_month') && $("#datePicker_year").val()!=-1 && $("#datePicker_month").val()!=-1){
            	day=$("#datePicker_day").val();
                days=datePicker_get_days($("#datePicker_year").val(),$("#datePicker_month").val());
                $("#datePicker_day").html("<option value='-1'>  <?php echo $language['d']?>  </option>"+datePicker_get_day_option(days));
                //monxin_alert(days);
                if(parseInt(day)>days){day=days;}
                $("#datePicker_day").val(day);
            }
        
            if($(this).val()==-1){full=false;return false;}else{
            if(index==0){
              full=$(this).val();
            }else{
              if(this.id=='datePicker_month' || this.id=='datePicker_day'){
                  full+="<?php echo $config['other']['date_style'][1]?>"+$(this).val();
              }else{
                  if(this.id=='datePicker_hour'){
                  	 if($("#datePicker_day").css('display')=='none'){full+=$(this).val();}else{full+=" "+$(this).val();}
                  }else{
                      full+=":"+$(this).val();
                  }
              }
            }
            }
      }
    });
    if(full!=false){
    	$("#"+datePicker_obj).val(full);
        $("#"+datePicker_obj).focus();
        datePicker_timer= setTimeout("exe_hide_datePicker()", 100);
    }
    	
    });
	$("body").click(function(event){
    	if(event.target.id.search(/datePicker/i)==-1 && event.target.id!=''){
        	//$("#"+datePicker_obj).focus();
        	datePicker_timer= setTimeout("exe_hide_datePicker()", 500);
        }
    });
}
