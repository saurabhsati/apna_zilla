 
 /* Check and pass paramer to url by chetan*/
 function check_url(ukey, uval)
   { 
      var url = location.href;
      var target_link  = '';
      var pattern_var = '';
      var parameter = ukey;
      //var rpx_ptr = new RegExp(/[?]*[&]*view=[A-Za-z]*/);
      //console.log(rpx_ptr); exit;
      var urlparts= url.split('?');   
      if (urlparts.length>=2) {
        //console.log(urlparts);  
        var prefix= encodeURIComponent(parameter)+'=';
        //console.log('prefix='+prefix);
        var pars= urlparts[1].split(/[&;]/g);
        //console.log('pars='+pars); 
         
        //reverse iteration as may be destructive
        for (var i= pars.length; i-- > 0;) {    
            //idiom for string.startsWith
            if (pars[i].lastIndexOf(prefix, 0) !== -1) {  
                pars.splice(i, 1);
            }
        }
       // console.log("join--->>"+pars);
        url = urlparts[0]+'?'+pars.join('&');
         if(pars.length==1){
           url = url +'&';
         }
        url = url+ukey+'='+uval;  
    } else {
        url = url+'?'+ukey+'='+uval;

    }
      
      /*target_link = current_search_string.replace(rpx_ptr/g,'');
      (target_link.indexOf("?")>0)?pattern_var='&' : pattern_var='?';  
      target_link = target_link+pattern_var+ukey+'='+uval;*/
     // alert(url);
     window.location=url;
          
   }

 /*Dyanamic parament */
 function passurl(uarr,uval){
    alert('test');
    var url = location.href;

    var urlparts= url.split('?');

    if (urlparts.length>=2) {

    }else{
    
     url = url+'?'+uarr+'='+uval;
    }

   window.location=url;
    
 }  