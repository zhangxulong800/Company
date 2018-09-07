﻿if(typeof(TIDCReader)=="undefined"){TIDCReader=function(){this.BasePath="http://127.0.0.1:8131";this.SN="";this._SFZRTIMER=null;this._isloadSFZ=false,this._err_count=0;return this}}TIDCReader.prototype.Loadjs=function(url,callback,errorcb){var head=document.head||document.getElementsByTagName("head")[0]||document.documentElement;var script=document.createElement("script");script.async=true;if(url.indexOf("/")==0){url=this.BasePath+url}script.src=url;script.onload=script.onreadystatechange=function(_,isAbort){if(isAbort||!script.readyState||/loaded|complete/.test(script.readyState)){script.onload=script.onreadystatechange=null;if(!isAbort){callback(200,"success")}if(script.parentNode){script.parentNode.removeChild(script)}script=null}};script.onerror=function(){errorcb()};head.insertBefore(script,head.firstChild)};TIDCReader.prototype.IDCRead=function(callback){var obj=this;if(obj._SFZRTIMER!=null){clearInterval(obj._SFZRTIMER)}this._SFZRTIMER=window.setInterval(function(){if(obj._isloadSFZ){return}obj._isloadSFZ=true;obj.Loadjs("/read?t="+(new Date()).getTime(),function(){obj._isloadSFZ=false;obj._err_count=0;if(callback){callback(IDC_DATA)}},function(){console.log("err");obj._isloadSFZ=false;obj._err_count++;if(_err_count>1){obj.stopIDCRead();if(callback){callback({"STAT":-99})}}})},1000)};TIDCReader.prototype.closeIDCComm=function(callback){var obj=this;obj._isloadSFZ=true;this.Loadjs("/close?t="+(new Date()).getTime(),function(){obj._isloadSFZ=false;if(callback){callback(IDC_DATA)}},function(){obj._isloadSFZ=false;if(callback){callback({"STAT":-99})}})};TIDCReader.prototype.getZPUrl=function(){return this.BasePath+"/zp?t"+(new Date()).getTime()};TIDCReader.prototype.Register=function(sn,callback){var obj=this;obj.SN=sn;obj._isloadSFZ=true;this.Loadjs("/reg?sn="+encodeURIComponent(obj.SN)+"&t="+(new Date()).getTime(),function(){obj._isloadSFZ=false;if(callback){callback(IDC_DATA)}},function(){obj._isloadSFZ=false;if(callback){callback({"STAT":-99})}})};TIDCReader.prototype.stopIDCRead=function(){try{if(this._SFZRTIMER!=null){clearInterval(this._SFZRTIMER);this.closeIDCComm();this._SFZRTIMER=null}}catch(_ex){}};