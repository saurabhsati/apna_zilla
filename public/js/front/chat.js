/*

Copyright (c) 2009 Anant Garg (anantgarg.com | inscripts.com)

This script may be used for non-commercial purposes only. For any

commercial purposes, please contact the author at 

anant.garg@inscripts.com

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,

EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES

OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND

NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT

HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,

WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING

FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR

OTHER DEALINGS IN THE SOFTWARE.

*/
var windowFocus = true;

var username;

var chatHeartbeatCount = 5000;

var minChatHeartbeat = 500;

var maxChatHeartbeat = 33000;

var chatHeartbeatTime = minChatHeartbeat;

var originalTitle;

var blinkOrder = 0;

var chatboxFocus = new Array();

var newMessages = new Array();

var newMessagesWin = new Array();

var chatBoxes = new Array();

var csrf_token_name;

var csrf_token_value;

var arr_smiley = {};

base_path = '';

$(document).ready(function() 
{
    originalTitle = document.title;
    startChatSession();
    $([window, document]).blur(function() {
        windowFocus = false;
    }).focus(function() {
        windowFocus = true;
        document.title = originalTitle;
    });

    base_path = $('body').attr('data-lang-url');
    csrf_token_name = $('body').attr('data-token-name');
    csrf_token_value = $('body').attr('data-token-value');

    loadSmiley();
});

function restructureChatBoxes() 
{
    align = 0;
    for (x in chatBoxes) 
    {
        chatboxtitle = chatBoxes[x];
        if ($("#chatbox_" + chatboxtitle).css('display') != 'none') 
        {
            if (align == 0) 
            {
                $("#chatbox_" + chatboxtitle).css('right', '195px');
            } 
            else 
            {
                width = (align) * (225 + 7) + 195;
                $("#chatbox_" + chatboxtitle).css('right', width + 'px');
            }
            align++;
        }
    }
}

function chatWith(chatuser, chatusername)
{
    createChatBox(chatuser, '', chatusername);
    $("#chatbox_" + chatuser + " .chatboxtextarea").focus();
}

function createChatBox(chatboxtitle, minimizeChatBox, chatusername)
{
    if ($("#chatbox_" + chatboxtitle).css('display') == 'block')
    { 
        $("#chatbox_" + chatboxtitle + " .chatboxtextarea").focus();
        return false;
    }
    else
    {
        /* Load Recenrt Chats */
        if ($("#chatbox_" + chatboxtitle + " .chatboxtextarea").text().trim().length == 0)
        {
            loadRecentChats(chatboxtitle);
        }

        if ($("#chatbox_" + chatusername).length > 0)
        {
            if ($("#chatbox_" + chatusername).css('display') == 'none')
            {
                $("#chatbox_" + chatusername).css('display', 'block');
                restructureChatBoxes();
            }
            $("#chatbox_" + chatusername + " .chatboxtextarea").focus();
            return;
        }

        /*	if($('.chatbox').hide())

        { */

        $(" <div />").attr("id", "chatbox_" + chatboxtitle)
                     .addClass("chatbox")
                     .html('<div class="chatboxhead"  style="cursor:default;" ><div class="chatboxtitle" onclick="javascript:toggleChatBoxGrowth(\'' + chatboxtitle + '\')"><strong>' + chatusername + '</strong></div>&nbsp;&nbsp;<span style="cursor:default;w" onclick="clearChatHistory(' + chatboxtitle + ',' + chatboxtitle + ')">Clear</span><div class="chatboxoptions"><a href="javascript:void(0)" onclick="javascript:toggleChatBoxGrowth(\'' + chatboxtitle + '\')">-</a> &nbsp;<a href="javascript:void(0)" onclick="javascript:closeChatBox(\'' + chatboxtitle + '\')">X</a></div><br clear="all"/></div><div class="chatboxcontent"></div><div class="chatboxinput"><div class="btn_smiley" onClick="javascript:return show_smiley(' + chatboxtitle + ');"><i class="fa fa-smile-o"></i></div><div style="display:none;" id="smiley_div_' + chatboxtitle + '" class="cls_smiley_div" >:) :D .:*</div><textarea class="chatboxtextarea" id="chatbox_textarea_' + chatboxtitle + '" onkeydown="javascript:return checkChatBoxInputKey(event,this,\'' + chatboxtitle + '\',\'' + chatusername + '\');"></textarea></div>')
                     .appendTo($("body"));

        $("#chatbox_" + chatboxtitle).css('bottom', '0px');
        chatBoxeslength = 0;
        for (x in chatBoxes) 
        {
            if ($("#chatbox_" + chatBoxes[x]).css('display') != 'none') 
            {
                chatBoxeslength++;
            }
        }

        if (chatBoxeslength == 0)
        {
            $("#chatbox_" + chatboxtitle).css('right', '195px');
        } 
        else
        {
            width = (chatBoxeslength) * (225 + 7) + 195;
            $("#chatbox_" + chatboxtitle).css('right', width + 'px');
        }

        chatBoxes.push(chatboxtitle); // alert("minimize chat box value is "+minimizeChatBox);
        if (minimizeChatBox == 1)
        {
            minimizedChatBoxes = new Array();
            if ($.cookie('chatbox_minimized'))
            {
                minimizedChatBoxes = $.cookie('chatbox_minimized').split(/\|/);
            }
            minimize = 0;
            for (j = 0; j < minimizedChatBoxes.length; j++)
            {
                if (minimizedChatBoxes[j] == chatboxtitle)
                {
                    minimize = 1;
                }
            }
            if (minimize == 1)
            {
                $('#chatbox_' + chatboxtitle + ' .chatboxcontent').css('display', 'none');
                $('#chatbox_' + chatboxtitle + ' .chatboxinput').css('display', 'none');
            }
        }
        chatboxFocus[chatboxtitle] = false;

        $("#chatbox_" + chatboxtitle + " .chatboxtextarea").blur(function() {
            chatboxFocus[chatboxtitle] = false;
            $("#chatbox_" + chatboxtitle + " .chatboxtextarea").removeClass('chatboxtextareaselected');
        }).focus(function() 
        {
            chatboxFocus[chatboxtitle] = true;
            newMessages[chatboxtitle] = false;
            $('#chatbox_' + chatboxtitle + ' .chatboxhead').removeClass('chatboxblink');
            $("#chatbox_" + chatboxtitle + " .chatboxtextarea").addClass('chatboxtextareaselected');
        });

        $("#chatbox_" + chatboxtitle).show();
    }
    loadSmileyBox(chatboxtitle);
}

function chatHeartbeat() 
{
    var itemsfound = 0;
    if (windowFocus == false) 
    {
        var blinkNumber = 0;
        var titleChanged = 0;
        for (x in newMessagesWin) 
        {
            if (newMessagesWin[x] == true) 
            {
                ++blinkNumber;
                if (blinkNumber >= blinkOrder) 
                {
                    document.title = x + ' says...';
                    titleChanged = 1;
                    break;
                }
            }
        }

        if (titleChanged == 0) 
        {
            document.title = originalTitle;
            blinkOrder = 0;
        } 
        else 
        {
            ++blinkOrder;
        }
    } 
    else 
    {
        for (x in newMessagesWin) 
        {
            newMessagesWin[x] = false;
        }
    }

    for (x in newMessages) 
    {
        if (newMessages[x] == true) 
        {
            if (chatboxFocus[x] == false) 
            {
                //FIXME: add toggle all or none policy, otherwise it looks funny
                $('#chatbox_' + x + ' .chatboxhead').toggleClass('chatboxblink');
            }
        }
    }

    $.ajax({
        url: $('body').attr('data-lang-url') + "/chat/chat_heart_beat",
        cache: false,
        dataType: "json",
        success: function(data) 
        {
            $.each(data.items, function(i, item) 
            {
                if (item) 
                { // fix strange ie bug
                    chatboxtitle = get_chatbox_title(item.f,item.a);
                    display_name = item.frm;

                    if ($("#chatbox_" + chatboxtitle).length <= 0) 
                    {
                        createChatBox(chatboxtitle, '', display_name);
                    }
                    if ($("#chatbox_" + chatboxtitle).css('display') == 'none') 
                    {
                        $("#chatbox_" + chatboxtitle).css('display', 'block');
                        restructureChatBoxes();
                    }
                    if (item.s == 1) 
                    {
                        item.f = chatboxtitle;
                        item.frm = display_name;
                    }
                    if (item.s == 2) 
                    {
                        $("#chatbox_" + chatboxtitle + " .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxinfo">' + item.m + '</span></div>');
                    } 
                    else 
                    {
                        newMessages[chatboxtitle] = true;
                        newMessagesWin[display_name] = true;
                        item.frm = "";
                        $("#chatbox_" + chatboxtitle + " .chatboxcontent").append('<div class="chatboxmessage chatboxmessage_from"><span class="chatboxmessagefrom" >' + item.frm + '&nbsp;&nbsp;</span><br><span class="chatboxmessagecontent " style="background:#f8cdf8;">' + item.m + '</span></div>');
                    }

                    $("#chatbox_" + chatboxtitle + " .chatboxcontent").scrollTop($("#chatbox_" + chatboxtitle + " .chatboxcontent")[0].scrollHeight);
                    itemsfound += 1;
                }
            });

            chatHeartbeatCount++;
            if (itemsfound > 0) 
            {
                chatHeartbeatTime = minChatHeartbeat;
                chatHeartbeatCount = 1;
            } 
            else if (chatHeartbeatCount >= 10) 
            {
                chatHeartbeatTime *= 2;
                chatHeartbeatCount = 1;
                if (chatHeartbeatTime > maxChatHeartbeat) 
                {
                    chatHeartbeatTime = maxChatHeartbeat;
                }
            }

            setTimeout('chatHeartbeat();', chatHeartbeatTime);
        }
    });
}

function closeChatBox(chatboxtitle) 
{
    $('#chatbox_' + chatboxtitle).css('display', 'none');
    var tmp_index = chatBoxes.indexOf(chatboxtitle);
    chatBoxes.splice(tmp_index, 1);
    restructureChatBoxes();
    $.post($('body').attr('data-lang-url') + "/chat/close_chat", 
    {
        chatbox: chatboxtitle,
        '_token': csrf_token_value
    }, function(data) {

    });
}

function toggleChatBoxGrowth(chatboxtitle) 
{
    if ($('#chatbox_' + chatboxtitle + ' .chatboxcontent').css('display') == 'none') 
    {
        var minimizedChatBoxes = new Array();
        if ($.cookie('chatbox_minimized')) 
        {
            minimizedChatBoxes = $.cookie('chatbox_minimized').split(/\|/);
        }
        var newCookie = '';
        for (i = 0; i < minimizedChatBoxes.length; i++) 
        {
            if (minimizedChatBoxes[i] != chatboxtitle) 
            {
                newCookie += chatboxtitle + '|';
            }
        }
        newCookie = newCookie.slice(0, -1)
        $.cookie('chatbox_minimized', newCookie);
        $('#chatbox_' + chatboxtitle + ' .chatboxcontent').css('display', 'block');
        $('#chatbox_' + chatboxtitle + ' .chatboxinput').css('display', 'block');
        $("#chatbox_" + chatboxtitle + " .chatboxcontent").scrollTop($("#chatbox_" + chatboxtitle + " .chatboxcontent")[0].scrollHeight);
    } 
    else 
    {
        var newCookie = chatboxtitle;
        if ($.cookie('chatbox_minimized')) 
        {
            newCookie += '|' + $.cookie('chatbox_minimized');
        }

        $.cookie('chatbox_minimized', newCookie);
        $('#chatbox_' + chatboxtitle + ' .chatboxcontent').css('display', 'none');
        $('#chatbox_' + chatboxtitle + ' .chatboxinput').css('display', 'none');
    }

    /* Load Recent chats */

    if ($('#chatbox_' + chatboxtitle + ' .chatboxcontent').text().trim().length == 0)
    {
        loadRecentChats(chatboxtitle);
    }
}

function checkChatBoxInputKey(event, chatboxtextarea, chatboxtitle, chatusername) 
{
    if (event.keyCode == 13 && event.shiftKey == 0) 
    {
        message = $(chatboxtextarea).val();
        message = message.replace(/^\s+|\s+$/g, "");
        $(chatboxtextarea).val('');
        $(chatboxtextarea).focus();
        $(chatboxtextarea).css('height', '44px');
        if (message != '')
        {   
            to_user = get_u_id(chatboxtitle);
            ad_id = get_ad_id(chatboxtitle);

            var req_data = {};

            if (csrf_token_name.length > 0)
            {
                req_data.to = to_user;
                req_data.ad_id = ad_id;
                req_data.to_name = chatusername;
                req_data.message = message;
                req_data._token = csrf_token_value;
            } 
            else
            {
                req_data.to = to_user;
                req_data.ad_id = ad_id;
                req_data.to_name = chatusername;
                req_data.message = message;
            }

            $.post($('body').attr('data-lang-url') + "/chat/send_chat", req_data, function(data) {
                    message = message.replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/\"/g, "&quot;");
                    message = parseSmiley(message);
                    $("#chatbox_" + chatboxtitle + " .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagefrom">' + username + ':&nbsp;&nbsp;</span><span class="chatboxmessagecontent">' + message + '</span></div>');
                    $("#chatbox_" + chatboxtitle + " .chatboxcontent").scrollTop($("#chatbox_" + chatboxtitle + " .chatboxcontent")[0].scrollHeight);
                    $(chatboxtextarea).empty();
                });

        }

        chatHeartbeatTime = minChatHeartbeat;
        chatHeartbeatCount = 1;
        return false;
    }

    var adjustedHeight = chatboxtextarea.clientHeight;
    var maxHeight = 94;
    if (maxHeight > adjustedHeight) 
    {
        adjustedHeight = Math.max(chatboxtextarea.scrollHeight, adjustedHeight);
        if (maxHeight)
            adjustedHeight = Math.min(maxHeight, adjustedHeight);

        if (adjustedHeight > chatboxtextarea.clientHeight)
            $(chatboxtextarea).css('height', adjustedHeight + 8 + 'px');

    } 
    else 
    {
        $(chatboxtextarea).css('overflow', 'auto');
    }
}

function startChatSession() 
{
    $.ajax({
        url: $('body').attr('data-lang-url') + "/chat/start_chat_session",
        cache: false,
        dataType: "json",
        success: function(data) {
            username = data.username;
            $.each(data.items, function(i, item) 
            {
                if (item.length>0) 
                { // fix strange ie bug
                    chatboxtitle = item.f;
                    chatusername = item.frm;
                    if ($("#chatbox_" + chatboxtitle).length <= 0) 
                    {
                        createChatBox(chatboxtitle, 1, chatusername);
                    }
                    if (item.s == 1) 
                    {
                        item.f = chatboxtitle;
                        item.frm = username
                    }
                    if (item.s == 2) 
                    {
                        $("#chatbox_" + chatboxtitle + " .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxinfo">' + item.m + '</span></div>');
                    } 
                    else 
                    {
                        $("#chatbox_" + chatboxtitle + " .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagefrom">' + item.frm + ':&nbsp;&nbsp;</span><span class="chatboxmessagecontent">' + item.m + '</span></div>');
                    }
                }
            });

            for (i = 0; i < chatBoxes.length; i++) 
            {
                chatboxtitle = chatBoxes[i];
                $("#chatbox_" + chatboxtitle + " .chatboxcontent").scrollTop($("#chatbox_" + chatboxtitle + " .chatboxcontent")[0].scrollHeight);
                setTimeout('$("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);', 100); // yet another strange ie bug
            }

            setTimeout('chatHeartbeat();', chatHeartbeatTime);
        }
    });
}

function show_smiley(user_id)
{
    $("#smiley_div_" + user_id + "").toggle();
}

function parseSmiley(raw_msg)
{
    $.each(arr_smiley, function(key, val)
    {
        raw_msg = raw_msg.split(key).join(val);
    });
    return raw_msg;
}

function loadSmiley()
{
    $.ajax({
        url: $('body').attr('data-lang-url') + '/chat/get_smiley_with_path',
        dataType: 'json',
        cache: 'false',
        success: function(response)
        {
            $.each(response, function(key, val)
            {
                arr_smiley[key] = val;
            });
        }
    });
}

function loadSmileyBox(user_id)
{
    var arr_tmp = {};
    var str_tmp = "";
    $.each(arr_smiley, function(key, val)
    {
        key = '"' + key + '"';
        str_tmp += "<span onclick='copyMessageBox(" + key + ",this)'>" + val + "</span> &nbsp;";
    });

    $(".cls_smiley_div").html(str_tmp);
}

function copyMessageBox(key, ref)
{
    var text_area = $(ref).parent().next('textarea');
    text_area.val(text_area.val() + ' ' + key);
    text_area.focus();
}

function clearChatHistory(from_id, chatbox_id)
{
    /* If CSRF Enabled */

    /*if(csrf_token_name.length>0)
    {
    	req_data = {from_u_id:from_id,'_token':csrf_token_value} 
    }
    else
    {
    	req_data = {from_u_id:from_id} 
    }

    $.ajax({
    		url: $('body').attr('data-lang-url')+'/chat/clear_chat_history',
    		type:'POST',
    		data:req_data,
    		cache:'false',
    		dataType:'json',
    		success:function(response)
    		{
    			if(response.sts='SUCCESS')
    			{
    				$("#chatbox_"+chatbox_id+" .chatboxcontent").empty();
				}
   			}
    });*/

    $("#chatbox_" + chatbox_id + " .chatboxcontent").empty();
}

function loadRecentChats(from_id) 
{
    /* If CSRF Enabled */
    if (from_id == undefined) return false;
    if (from_id.length<=0) return false;

     /* Split Ad and User id */
    main_from_id =  from_id; 
    from_id = get_u_id(from_id);
    ad_id = get_ad_id(from_id);

    if (csrf_token_name.length > 0) 
    {
       
        req_data = {
            from_u_id: from_id,
            ad_id: ad_id,
            '_token': csrf_token_value
        }
    } 
    else 
    {
        req_data = {
            from_u_id: from_id,
            ad_id: ad_id,
        }
    }

    $.ajax({
        url: $('body').attr('data-lang-url') + '/chat/load_recent_chats',
        type: 'GET',
        cache: 'false',
        data: req_data,
        dataType: 'json',
        success: function(response)
        {
            if (response.sts = 'SUCCESS')
            {
                $.each(response.data_resp, function(key, sub_data)
                {
                    username = sub_data.from_name;
                    message = sub_data.message;
                    target_box = sub_data.from+"-"+sub_data.ad_id;
                    if (sub_data.from = main_from_id && sub_data.to != main_from_id)
                    {
                        $("#chatbox_" + target_box + " .chatboxcontent").append('<div class="chatboxmessage chatboxmessage_from"><span class="chatboxmessagefrom" >' + username + '&nbsp;&nbsp;</span><br><span class="chatboxmessagecontent " style="background:#f8cdf8;">' + message + '</span></div>');
                    } 
                    else if (sub_data.to = main_from_id && sub_data.from != main_from_id)
                    {
                        $("#chatbox_" + target_box + " .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagefrom">' + username + '&nbsp;&nbsp;</span><br><span class="chatboxmessagecontent" style="background:#d5e1ec;padding:7px;border-radius:9px;">' + message + '</span></div>');
                    }

                    if( $("#chatbox_" + target_box + " .chatboxcontent").length)
                    {
                        $("#chatbox_" + target_box + " .chatboxcontent").scrollTop($("#chatbox_" + from_id + " .chatboxcontent")[0].scrollHeight);    
                    }
                    
                });
            }
        }
    });
}

function get_u_id(str)
{
    var tmp = str.split('-');
    return tmp[0];
}

function get_ad_id(str)
{
    var tmp = str.split('-');
    return tmp[1];
}

function get_chatbox_title(u_id,ad_id)
{
    return u_id+"-"+ad_id;
}
/**
 * Cookie plugin
 *
 * Copyright (c) 2006 Klaus Hartl (stilbuero.de)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 */

jQuery.cookie = function(name, value, options) 
{
    if (typeof value != 'undefined') 
    { // name and value given, set cookie
        options = options || {};
        if (value === null) 
        {
            value = '';
            options.expires = -1;
        }
        var expires = '';
        if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) 
        {
            var date;
            if (typeof options.expires == 'number') 
            {
                date = new Date();
                date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
            } 
            else 
            {
                date = options.expires;
            }
            expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
        }
        // CAUTION: Needed to parenthesize options.path and options.domain
        // in the following expressions, otherwise they evaluate to undefined
        // in the packed version for some reason...
        var path = options.path ? '; path=' + (options.path) : '';
        var domain = options.domain ? '; domain=' + (options.domain) : '';
        var secure = options.secure ? '; secure' : '';
        document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
    } 
    else 
    { // only name given, get cookie
        var cookieValue = null;
        if (document.cookie && document.cookie != '') 
        {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) 
            {
                var cookie = jQuery.trim(cookies[i]);
                // Does this cookie string begin with the name we want?
                if (cookie.substring(0, name.length + 1) == (name + '=')) 
                {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        return cookieValue;
    }
};